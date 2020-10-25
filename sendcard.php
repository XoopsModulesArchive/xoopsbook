<?php
include '../../mainfile.php';
include '../../header.php';
OpenTable();
/******************************************************************************
* MyAddressbook written in PHP
* Copyright (C)2000-2003 by olafur@rootus.org
* vCard feature is using a class by kaib@bitfolge.de
*
* This program is free software; you can redistribute it and/or
* modify it under the terms of the GNU General Public License.
******************************************************************************/
include 'db_config.php';
include 'functions.php';

dbconnect();
$query = "select * from $db_table where id = " . $_REQUEST['Card'] . '';
$result = $GLOBALS['xoopsDB']->queryF($query);
$number = $GLOBALS['xoopsDB']->getRowsNum($result);
$id = mysql_result($result, $i, 'id');
$name = mysql_result($result, $i, 'name');
$home = mysql_result($result, $i, 'home');
$place = mysql_result($result, $i, 'place');
$country = mysql_result($result, $i, 'country');
$phone = mysql_result($result, $i, 'phone');
$gsm = mysql_result($result, $i, 'gsm');
$email = mysql_result($result, $i, 'email');
$www = mysql_result($result, $i, 'www');
$pnr = mysql_result($result, $i, 'pnr');
$comment = mysql_result($result, $i, 'comment');
$date = mysql_result($result, $i, 'date');
$name = ucwords($name);
$home = ucfirst($home);
$place = ucfirst($place);
$country = ucfirst($country);

$v = new vCard();

$v->setPhoneNumber((string)$phone, 'PREF;HOME;VOICE');
$v->setName((string)$name, '', '', '');
$v->setBirthday('');
$v->setAddress('', '', (string)$home, (string)$place, '', (string)$pnr, (string)$country);
$v->setEmail((string)$email);
$v->setNote((string)$comment);
$v->setURL((string)$www, 'WORK');

$output = $v->getVCard();
$filename = $v->getFileName();

header("Content-Disposition: attachment; filename=$filename");
header('Content-Length: ' . mb_strlen($output));
header('Connection: close');
header("Content-Type: text/x-vCard; name=$filename");

echo $output;

/***************************************************************************
 * PHP vCard class v2.0
 * (c) Kai Blankenhorn
 * www.bitfolge.de/en
 * kaib@bitfolge.de
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 **************************************************************************
 * @param $string
 * @return string|string[]
 */

function encode($string)
{
    return escape(quoted_printable_encode($string));
}

function escape($string)
{
    return str_replace(';', "\;", $string);
}

function quoted_printable_encode($input, $line_max = 76)
{
    $hex = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F'];

    $lines = preg_preg_split("/(?:\r\n|\r|\n)/", $input);

    $eol = "\r\n";

    $linebreak = '=0D=0A';

    $escape = '=';

    $output = '';

    for ($j = 0, $jMax = count($lines); $j < $jMax; $j++) {
        $line = $lines[$j];

        $linlen = mb_strlen($line);

        $newline = '';

        for ($i = 0; $i < $linlen; $i++) {
            $c = mb_substr($line, $i, 1);

            $dec = ord($c);

            if ((32 == $dec) && ($i == ($linlen - 1))) { // convert space at eol only
                $c = '=20';
            } elseif ((61 == $dec) || ($dec < 32) || ($dec > 126)) { // always encode "\t", which is *not* required
                $h2 = floor($dec / 16);

                $h1 = floor($dec % 16);

                $c = $escape . $hex[(string)$h2] . $hex[(string)$h1];
            }

            if ((mb_strlen($newline) + mb_strlen($c)) >= $line_max) { // CRLF is not counted
                $output .= $newline . $escape . $eol; // soft line break; " =\r\n" is okay
                $newline = '    ';
            }

            $newline .= $c;
        } // end of for

        $output .= $newline;

        if ($j < count($lines) - 1) {
            $output .= $linebreak;
        }
    }

    return trim($output);
}

class vCard
{
    public $properties;

    public $filename;

    public function setPhoneNumber($number, $type = '')
    {
        $key = 'TEL';

        if ('' != $type) {
            $key .= ';' . $type;
        }

        $key .= ';ENCODING=QUOTED-PRINTABLE';

        $this->properties[$key] = quoted_printable_encode($number);
    }

    public function setPhoto($type, $photo)
    { // $type = "GIF" | "JPEG"
        $this->properties["PHOTO;TYPE=$type;ENCODING=BASE64"] = base64_encode($photo);
    }

    public function setFormattedName($name)
    {
        $this->properties['FN'] = quoted_printable_encode($name);
    }

    public function setName($family = '', $first = '', $additional = '', $prefix = '', $suffix = '')
    {
        $this->properties['N'] = "$family;$first;$additional;$prefix;$suffix";

        $this->filename = "$first%20$family.vcf";

        if ('' == $this->properties['FN']) {
            $this->setFormattedName(trim("$prefix $first $additional $family $suffix"));
        }
    }

    public function setBirthday($date)
    { // $date format is YYYY-MM-DD
        $this->properties['BDAY'] = $date;
    }

    public function setAddress($postoffice = '', $extended = '', $street = '', $city = '', $region = '', $zip = '', $country = '', $type = 'HOME;POSTAL')
    {
        $key = 'ADR';

        if ('' != $type) {
            $key .= ";$type";
        }

        $key .= ';ENCODING=QUOTED-PRINTABLE';

        $this->properties[$key] = encode($name) . ';' . encode($extended) . ';' . encode($street) . ';' . encode($city) . ';' . encode($region) . ';' . encode($zip) . ';' . encode($country);

        if ('' == $this->properties["LABEL;$type;ENCODING=QUOTED-PRINTABLE"]) {
        }
    }

    public function setLabel($postoffice = '', $extended = '', $street = '', $city = '', $region = '', $zip = '', $country = '', $type = 'HOME;POSTAL')
    {
        $label = '';

        if ('' != $postoffice) {
            $label .= "$postoffice\r\n";
        }

        if ('' != $extended) {
            $label .= "$extended\r\n";
        }

        if ('' != $street) {
            $label .= "$street\r\n";
        }

        if ('' != $zip) {
            $label .= "$zip ";
        }

        if ('' != $city) {
            $label .= "$city\r\n";
        }

        if ('' != $region) {
            $label .= "$region\r\n";
        }

        if ('' != $country) {
            $country .= "$country\r\n";
        }

        $this->properties["LABEL;$type;ENCODING=QUOTED-PRINTABLE"] = quoted_printable_encode($label);
    }

    public function setEmail($address)
    {
        $this->properties['EMAIL;INTERNET'] = $address;
    }

    public function setNote($note)
    {
        $this->properties['NOTE;ENCODING=QUOTED-PRINTABLE'] = quoted_printable_encode($note);
    }

    public function setURL($url, $type = '')
    {
        $key = 'URL';

        if ('' != $type) {
            $key .= ";$type";
        }

        $this->properties[$key] = $url;
    }

    public function getVCard()
    {
        $text = "BEGIN:VCARD\r\n";

        $text .= "VERSION:2.1\r\n";

        foreach ($this->properties as $key => $value) {
            $text .= "$key:$value\r\n";
        }

        $text .= 'REV:' . date('Y-m-d') . 'T' . date('H:i:s') . "Z\r\n";

        $text .= "MAILER:PHP vCard class by Kai Blankenhorn\r\n";

        $text .= "END:VCARD\r\n";

        return $text;
    }

    public function getFileName()
    {
        return $this->filename;
    }
}
CloseTable();
include('../../footer.php');
