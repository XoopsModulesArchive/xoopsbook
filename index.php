<?php
include '../../mainfile.php';
include '../../header.php';
OpenTable();
session_start();
if (!isset($_SESSION['Language'])) {
    $_SESSION['Language'] = 'strings_en.php';
}
include 'functions.php';
include 'admin_config.php';
include 'lang/' . $_SESSION['Language'] . ''; ?>

 

<html>
<head>
<style type="text/css">

BODY		{font-size: $fontsize; font-family: $fontfamily; color: $textcolor; scrollbar-base-color: $tabletitle; scrollbar-arrow-color: $bgcolor;}
TD		{font-size: $fontsize; font-family: $fontfamily, sans-serif; color: $textcolor;}
INPUT		{font-size: $fontsize; font-family: $fontfamily;}
SELECT		{font-size: $fontsize; font-family: $fontfamily;}
A:LINK		{color : $alink; text-decoration : underline;}
A:VISITED	{color : $vlink; text-decoration : underline;}
A:HOVER		{color : $hover; text-decoration : none;}

</style>
<title>$title</title>
</head>

<body 
	onLoad=\"self.focus();document.searchby.second.focus()\"
	bgcolor=$bgcolor
	topmargin=$topmargin
	leftmargin=$leftmargin 
	marginheight=$marginheight 
	marginwidth=$marginwidth>

<table width=97% align=center height=100% border=0><tr><td valign=top> 

<?php
ShowForm();

/******************************************************************************
* Look for a name
******************************************************************************/

if ('1' == $_REQUEST['Search']) {
    $query = "select * from $db_table where " . $_REQUEST['first'] . " like '" . $_REQUEST['second'] . "%' order by " . $_REQUEST['order'] . ' limit ' . $_REQUEST['lowlimit'] . ',15';

    $result = $GLOBALS['xoopsDB']->queryF($query);

    $number = $GLOBALS['xoopsDB']->getRowsNum($result);

    $i = 0;

    if (0 == $number) :
    window();

    $first = ucfirst($_REQUEST['first']);

    $second = ucfirst($_REQUEST['second']);

    print "
	<p><b>$StrNotFound</b><p>
	$StrYouChoose <b>$second</b>.<br>
	<form method=post action=" . $_SERVER['PHP_SELF'] . ">
	<input type=submit value=\"$StrTryAgain\">
	</form>";

    window_close(); elseif ($number > 0) :
    print "
	<table border=0 cellspacing=1 cellpadding=3 width=100%>
	<tr><td bgcolor=$tabletitle>
	<table border=0 bgcolor=$tablebg cellspacing=0 cellpadding=2 width=100%><tr><td>
	<table border=0 bgcolor=$tabletitle width=100% cellspacing=0 cellpadding=1><tr><td width=35% valign=bottom>
	<a href=" . $_SERVER['PHP_SELF'] . "?Search=1&order=name&first=name&second=$second&lowlimit=0><font color=#FFFFFF><b>$StrName</b></font></a>
	<td><a href=" . $_SERVER['PHP_SELF'] . "?Search=1&order=place&first=name&second=$second&lowlimit=0><font color=#FFFFFF><b>$StrCity</b></font></a></td>
	<td align=right><a href=" . $_SERVER['PHP_SELF'] . "?Search=1&order=email&first=name&second=$second&lowlimit=0>
	<font color=#FFFFFF><b>$StrEmail</b></font></a></td>
	<td width=30 align=right><a href=" . $_SERVER['PHP_SELF'] . '><img src=images/logoff.gif alt=Close border=0></a>
	</td></tr></table>';

    while ($i < $number) :
    $id = mysql_result($result, $i, 'id');

    $name = mysql_result($result, $i, 'name');

    $home = mysql_result($result, $i, 'home');

    $place = mysql_result($result, $i, 'place');

    $country = mysql_result($result, $i, 'country');

    $phone = mysql_result($result, $i, 'phone');

    $gsm = mysql_result($result, $i, 'gsm');

    $email = mysql_result($result, $i, 'email');

    $www = mysql_result($result, $i, 'www');

    $comment = mysql_result($result, $i, 'comment');

    $urlheimili = urlencode($heimili);

    $name = ucwords($name);

    $home = ucfirst($home);

    $place = ucfirst($place);

    $country = ucfirst($country);

    $rowcolor = colorchange();

    print "
	<table border=0 bgcolor=$rowcolor width=100% cellspacing=0 cellpadding=0>
	<tr onmouseover=\"this.bgColor='$bgcolor';\" onmouseout=\"this.bgColor='$rowcolor';\">
	<td width=35%><a href=" . $_SERVER['PHP_SELF'] . "?Closer=$id>$name</a></td>
	<td>$place</td>
	<td align=right><a href=mailto:$email>$email</a>&nbsp;</td>
	<td align=right width=25><a href=" . $_SERVER['PHP_SELF'] . "?Edit=$id><img src=images/prop.gif border=0></a>
	</td></tr></table>";

    $i++;

    endwhile;

    print '
	</td></tr>';

    $query = "select * from $db_table where " . $_REQUEST['first'] . " like '" . $_REQUEST['second'] . "%' order by " . $_REQUEST['order'] . '';

    $result = $GLOBALS['xoopsDB']->queryF($query);

    $totalnumber = $GLOBALS['xoopsDB']->getRowsNum($result);

    if (0 == $totalnumber):
        { print '</table>'; } elseif ($number == $totalnumber):
        { print '</table>'; } elseif ($number < $totalnumber):
            if ('15' == $_REQUEST['lowlimit']) {
                $number += $_REQUEST['lowlimit'];
            } elseif ('30' == $_REQUEST['lowlimit']) {
                $number += $_REQUEST['lowlimit'];
            } elseif ('45' == $_REQUEST['lowlimit']) {
                $number += $_REQUEST['lowlimit'];
            }

        $_REQUEST['lowlimit'] += 15;

    {
                if ($totalnumber < $_REQUEST['lowlimit']) {
                    print '</table>';
                } else {
                    print "<tr><td align=center bgcolor=$tabletitle><font color=#ffffff><b>$number $StrOneOfMany $totalnumber - </b></font><a href=" . $_SERVER['PHP_SELF'] . '?Search=1&first=name&second=' . $_REQUEST['second'] . '&order=' . $_REQUEST['order'] . '&lowlimit=' . $_REQUEST['lowlimit'] . "><font color=#ffffff><b>$StrNext&gt;&gt;</b></font></a></td></tr></table>";
                }
            } elseif ($number > $totalnumber):
        { print '</table>'; }

    endif;

    print '</td></tr></table>';

    endif;
}

/******************************************************************************
* Add new name into database
******************************************************************************/

elseif ($_REQUEST['AddNew']) {
    print "
	<table border=0 cellspacing=1 cellpadding=3><tr><td bgcolor=$tabletitle>
	<table border=0 bgcolor=$tablebg cellspacing=0 cellpadding=2><tr><td>
	<table border=0 bgcolor=$tabletitle width=100% cellspacing=0 cellpadding=1><tr>
	<td width=20><img src=images/newaddress.gif border=0></td>
	<td><font color=#ffffff><b>$StrAddNew</b></font> 
	</td><td align=right valign=bottom><a href=" . $_SERVER['PHP_SELF'] . '><img src=images/logoff.gif alt=Close border=0></a>
	</td></tr></table>	
	<form method=post action=' . $_SERVER['PHP_SELF'] . ">
	<table>
	<tr><td>$StrName</td><td><input type=text size=25 name=name value=></td></tr>
	<tr><td>$StrStreet</td><td><input type=text size=25 name=home value=></td></tr>
	<tr><td>$StrCity</td><td><input type=text size=25 name=place value=></td></tr>
	<tr><td>$StrCode</td><td><input type=text size=10 name=pnr value=></td></tr>
	<tr><td>$StrPhone</td><td><input type=text size=25 name=phone value=></td></tr>
	<tr><td>$StrMobile</td><td><input type=text size=25 name=gsm value=></td></tr>
	<tr><td>$StrEmail</td><td><input type=text size=25 name=email value=></td></tr>
	<tr><td>$StrWWW</td><td><input type=text size=25 name=www value='http://'></td></tr>
	<tr><td>$StrCountry</td><td><select name=country>
	<option value=\"\" selected>$StrNoCountry</option>";

    CountryList();

    print "
	</select></td></tr>
	<tr><td>$StrNote</td><td><textarea name=comment rows=4 cols=25 wrap=hard></textarea></td></tr>
	<input type=hidden name=date value=$dags>
	<input type=hidden name=dbAdd value=1>
	<tr><td colspan=2 align=right><input type=image src=images/ok.gif border=0 value=submit></td></tr>
	</td></tr></table>
	</td></tr></table>
	</td></tr></table>
	</form>";
} elseif ('1' == $_REQUEST['dbAdd']) {
    if ($_REQUEST['name']) {
        $name = strip_tags($_REQUEST['name']);

        $home = strip_tags($_REQUEST['home']);

        $place = strip_tags($_REQUEST['place']);

        $country = strip_tags($_REQUEST['country']);

        $comment = strip_tags($_REQUEST['comment']);

        $phone = strip_tags($_REQUEST['phone']);

        $gsm = strip_tags($_REQUEST['gsm']);

        $email = strip_tags($_REQUEST['email']);

        $www = strip_tags($_REQUEST['www']);

        $pnr = strip_tags($_REQUEST['pnr']);

        if ($email) {
            if (!validateEmail($email)) {
                window();

                print "<p><b>$StrInvalidEmail</b>
			<form method=post action=" . $_SERVER['PHP_SELF'] . ">
			<input type=hidden name=AddNew value=1>
			<input type=submit value=\"$StrTryAgain\">
			</form>";

                window_close();

                exit;
            }
        }

        $query = "insert into $db_table (id, name, home, place, country, phone, gsm, email, www, pnr, comment, date) values ('', '$name', '$home', '$place', '$country', '$phone', '$gsm', '$email', '$www', '$pnr', '$comment', '$dags')";

        $result = $GLOBALS['xoopsDB']->queryF($query);

        window();

        print '<p>' . $_REQUEST['name'] . " $StrBeenAdded<p>";

        $query = "select id from $db_table where name = '" . $_REQUEST['name'] . "'";

        $result = $GLOBALS['xoopsDB']->queryF($query);

        $number = $GLOBALS['xoopsDB']->getRowsNum($result);

        $id = mysql_result($result, 'id');

        print '
	<form method=post action=' . $_SERVER['PHP_SELF'] . "?Closer=$id>
	<input type=submit value=\"$StrView\">
	</form>";

        window_close();
    } else {
        window();

        print "
	<p>$StrNeedName<p>
	<form method=post action=" . $_SERVER['PHP_SELF'] . ">
	<input type=hidden name=AddNew value=1>
	<input type=submit value=\"$StrTryAgain\">
	</form>";

        window_close();
    }
}

/******************************************************************************
* Closer look at name
******************************************************************************/
elseif ($_REQUEST['Closer']) {
    $query = "select * from $db_table where id = " . $_REQUEST['Closer'] . '';

    $result = $GLOBALS['xoopsDB']->queryF($query);

    $number = $GLOBALS['xoopsDB']->getRowsNum($result);

    if (0 == $number) :
    window();

    print "<p><b>$StrNotFound</b><p>";

    window_close(); elseif ($number > 0) :
    $id = mysql_result($result, $i, 'id');

    $name = mysql_result($result, $i, 'name');

    $home = mysql_result($result, $i, 'home');

    $place = mysql_result($result, $i, 'place');

    $country = mysql_result($result, $i, 'country');

    $phone = mysql_result($result, $i, 'phone');

    $gsm = mysql_result($result, $i, 'gsm');

    $pnr = mysql_result($result, $i, 'pnr');

    $email = mysql_result($result, $i, 'email');

    $www = mysql_result($result, $i, 'www');

    $comment = mysql_result($result, $i, 'comment');

    $date = mysql_result($result, $i, 'date');

    $urlheimili = urlencode($heimili);

    $name = ucwords($name);

    $home = ucfirst($home);

    $place = ucfirst($place);

    $country = ucfirst($country);

    $comment = nl2br($comment);

    $maphome = urlencode($home);

    $mapplace = urlencode($place);

    $mapcountry = urlencode($country);

    $mappnr = urlencode($pnr);

    $googlename = urlencode($name);

    print "
	<table border=0 cellspacing=0 cellpadding=3><tr><td bgcolor=$tabletitle>
	<table border=0 bgcolor=$tablebg cellspacing=0 cellpadding=2><tr><td>
	<table border=0 bgcolor=$tabletitle width=100% cellspacing=0 cellpadding=1><tr>
	<td width=20><img src=images/text.gif border=0></td>
	<td align=center><font color=#ffffff><b>$StrCloserLook $name &nbsp;&nbsp;</b></font>
	</td><td align=right valign=bottom><a href=" . $_SERVER['PHP_SELF'] . "><img src=images/logoff.gif alt=Close border=0></a>
	</td></tr></table>	
	<table border=1 bordercolor=#999999 width=100% cellpadding=3>
	<tr><td colspan=2><b>$name</b></td></tr>";

    if ($home) {
        print "<tr><td colspan=2>$home</td></tr>";
    }

    if ($pnr || $place) {
        print "<tr><td colspan=2>$pnr $place</td></tr>";
    }

    if ($country) {
        print "<tr><td colspan=2>$country</td></tr><p>";
    }

    print '<tr><td colspan=2></td></tr>';

    if ($phone) {
        print "<tr><td>$StrPhone</td><td>$phone</td></tr>";
    }

    if ($gsm) {
        print "<tr><td>$StrMobile</td><td>$gsm</td></tr>";
    }

    if ($email) {
        print "<tr><td>$StrEmail</td><td><a href=mailto:$email>$email</a></td></tr>";
    }

    $wwwlen = mb_strlen($www);

    if ($wwwlen > 8) {
        print "<tr><td>$StrWWW</td><td><a href=$www target=_blank>$www</a></td></tr>";
    }

    if ($comment) {
        print "<tr><td>$StrNote</td><td>$comment</td></tr>";
    }

    print "<tr><td colspan=2></td></tr>
	<tr><td align=center>
	<a href=update.php?PrintPage=1&id=$id target=_blank><img src=images/print.gif border=0 alt=Print></a>
		</td><td align=center><form method=post action=" . $_SERVER['PHP_SELF'] . ">
	<input type=hidden name=dbDelete value=1>
	<input type=hidden name=Edit value=$id>
	<input type=submit value=$StrUpdate></td></tr>
	</form>
	<tr><td colspan=2></td></tr>
	<tr><td colspan=2 align=center><a href=sendcard.php?Card=$id><b>$StrVcard</b></a></td></tr>";

    if ($country && $home) {
        print "<tr><td colspan=2 align=center><a href=http://www.mapquest.com/maps/map.adp?country=$mapcountry&address=$maphome&city=$mapplace&zipcode=$mappnr target=_blank><b>$StrGetMap</b></a></td></tr>";
    }

    print "<small><tr><td colspan=2><small><center>$StrLastChanged $date</center></small>
	</td></tr></table>
	</td></tr></table>
	</td></tr></table>";

    endif;
}

/*****************************************************************************
* Edit/Update name in the database.
******************************************************************************/
elseif ($_REQUEST['Edit']) {
    $query = "select * from $db_table where id = " . $_REQUEST['Edit'] . '';

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

    print "
	<table border=0 cellspacing=0 cellpadding=3><tr><td bgcolor=$tabletitle>
	<table border=0 bgcolor=$tablebg cellspacing=0 cellpadding=2><tr><td rowspan=2>
	<table border=0 bgcolor=$tabletitle width=100% cellspacing=0 cellpadding=1><tr>
	<td width=20><img src=images/config.gif border=0></td>
	<td><font color=#ffffff><b>$StrUpdate</b></font> 
	</td><td align=right valign=bottom><a href=" . $_SERVER['PHP_SELF'] . '><img src=images/logoff.gif alt=Close border=0></a>
	</td></tr></table>	
	<table>
	<form method=post action=' . $_SERVER['PHP_SELF'] . ">
	<tr><td>$StrName</td><td><input type=text size=25 name=name value='$name'></td></tr>
	<tr><td>$StrStreet</td><td><input type=text size=25 name=home value='$home'></td></tr>
	<tr><td>$StrCity</td><td><input type=text size=25 name=place value='$place'></td></tr>
	<tr><td>$StrCode</td><td><input type=text size=10 name=pnr value='$pnr'></td></tr>
	<tr><td>$StrPhone</td><td><input type=text size=25 name=phone value='$phone'></td></tr>
	<tr><td>$StrMobile</td><td><input type=text size=25 name=gsm value='$gsm'></td></tr>
	<tr><td>$StrEmail</td><td><input type=text size=25 name=email value='$email'></td></tr>
	<tr><td>$StrWWW</td><td><input type=text size=25 name=www value='$www'></td></tr>
	<tr><td>$StrCountry</td><td><select name=country>
	<option value=\"$country\">$country</option>";

    CountryList();

    print "
	</select></td></tr>
	<tr><td>$StrNote</td><td><textarea name=comment rows=4 cols=25 value='$comment' wrap=hard>$comment</textarea></td></tr>
	<input type=hidden name=dags value='$dags'>
	<input type=hidden name=id value='$id'>
	<tr><td colspan=2 align=right>
	<input type=hidden name=dbUpdate value=1>
	<input type=image src=images/ok.gif alt=OK border=0 value=submit> &nbsp;
	<a href=" . $_SERVER['PHP_SELF'] . "?dbDelete=1&id=$id&name=$name><img src=images/cancel.gif border=0 alt=Delete></a></td></tr>
	<tr><td colspan=2 align=center><small>$StrLastChanged $date</small></td></tr>
	</td></tr></table>
	</form>
	</td></tr></table>
	</td></tr></table>";
} elseif (('1' == $_REQUEST['dbUpdate']) and ('hide' != $icontheme)) {
    $name = strip_tags($_REQUEST['name']);

    $home = strip_tags($_REQUEST['home']);

    $place = strip_tags($_REQUEST['place']);

    $country = strip_tags($_REQUEST['country']);

    $comment = strip_tags($_REQUEST['comment']);

    $phone = strip_tags($_REQUEST['phone']);

    $gsm = strip_tags($_REQUEST['gsm']);

    $email = strip_tags($_REQUEST['email']);

    $www = strip_tags($_REQUEST['www']);

    $pnr = strip_tags($_REQUEST['pnr']);

    if ($email) {
        if (!validateEmail($email)) {
            window();

            print "<p><b>$StrInvalidEmail</b>
			<form method=post action=" . $_SERVER['PHP_SELF'] . '>
			<input type=hidden name=Edit value=' . $_REQUEST['id'] . ">
			<input type=submit value=\"$StrTryAgain\">
			</form>";

            window_close();

            exit;
        }
    }

    $query = "update $db_table set name='$name', home='$home', place='$place', country='$country', phone='$phone', gsm='$gsm', email='$email', www='$www', pnr='$pnr', comment='$comment', date='$dags' where id = '" . $_REQUEST['id'] . "'";

    $result = $GLOBALS['xoopsDB']->queryF($query);

    window();

    print '<p>' . $_REQUEST['name'] . " $StrWasChanged";

    print '
	<form method=post action=' . $_SERVER['PHP_SELF'] . '?Closer=' . $_REQUEST['id'] . ">
	<input type=submit value=\"$StrView\">
	</form>";

    window_close();
} elseif ('1' == $_REQUEST['dbDelete']) {
    window();

    print '
	<form method=post action=' . $_SERVER['PHP_SELF'] . '?dbDel=l&id=' . $_REQUEST['id'] . '&name=' . $_REQUEST['name'] . '>
	<input type=hidden name=dbDel value=1>
	<input type=hidden name=id value=' . $_REQUEST['id'] . ">
	$StrSure <b>" . $_REQUEST['name'] . "</b> ?<p>
	<input type=submit value= \" $StrYes \" >
	</form>";

    window_close();
} elseif (('1' == $_REQUEST['dbDel']) and ('hide' != $icontheme)) {
    $query = "delete from $db_table where id = '" . $_REQUEST['id'] . "'";

    $result = $GLOBALS['xoopsDB']->queryF($query);

    window();

    print '<p><b>' . $_REQUEST['name'] . "</b> $StrWasDel<p>";

    window_close();
}

/*****************************************************************************
* Set New Language
******************************************************************************/
elseif ('1' == $_REQUEST['NewLang']) {
    unset($_SESSION['Language']);

    $_SESSION['Language'] = $_REQUEST['lang'];

    window();

    print "<br><b>$StrNewLang</b><p>";

    print '<a href=.><h2>Reload</h2></a>';

    window_close();
}

/*****************************************************************************
* If nothing else lets show this window here.
******************************************************************************/
else {
    window();

    print "
	<table><tr><td width=95% align=center>
	<b>$title $version<p>";

    if ('hide' == $icontheme) {
        print "<font color=#FF0000>$StrViewOnly</font><p>";
    }

    print "$StrTotal ";

    $query = "select count(id) from $db_table";

    $result = $GLOBALS['xoopsDB']->queryF($query);

    $nr = mysql_result($result, 'id');

    print "$nr $StrEntry<p>
	<form method=post action=" . $_SERVER['PHP_SELF'] . ">	
	<input type=hidden name=Search value=1>
	<input type=hidden name=order value=name>
	<input type=hidden name=lowlimit value=0>
	<input type=hidden name=first value=name>
	<input type=hidden name=second value=%>
	<input type=submit value=\"$StrShowAll\">
	</form></b><p>
	$StrSearchAZ<br>
	<a href=" . $_SERVER['PHP_SELF'] . '?Search=1&first=name&second=a&order=name&lowlimit=0>A</a> |
	<a href=' . $_SERVER['PHP_SELF'] . '?Search=1&first=name&second=b&order=name&lowlimit=0>B</a> |
	<a href=' . $_SERVER['PHP_SELF'] . '?Search=1&first=name&second=c&order=name&lowlimit=0>C</a> |
	<a href=' . $_SERVER['PHP_SELF'] . '?Search=1&first=name&second=d&order=name&lowlimit=0>D</a> |
	<a href=' . $_SERVER['PHP_SELF'] . '?Search=1&first=name&second=e&order=name&lowlimit=0>E</a> |
	<a href=' . $_SERVER['PHP_SELF'] . '?Search=1&first=name&second=f&order=name&lowlimit=0>F</a> |
	<a href=' . $_SERVER['PHP_SELF'] . '?Search=1&first=name&second=g&order=name&lowlimit=0>G</a> |
	<a href=' . $_SERVER['PHP_SELF'] . '?Search=1&first=name&second=h&order=name&lowlimit=0>H</a> |
	<a href=' . $_SERVER['PHP_SELF'] . '?Search=1&first=name&second=i&order=name&lowlimit=0>I</a> |
	<a href=' . $_SERVER['PHP_SELF'] . '?Search=1&first=name&second=j&order=name&lowlimit=0>J</a> |
	<a href=' . $_SERVER['PHP_SELF'] . '?Search=1&first=name&second=k&order=name&lowlimit=0>K</a> |
	<a href=' . $_SERVER['PHP_SELF'] . '?Search=1&first=name&second=l&order=name&lowlimit=0>L</a> |
	<a href=' . $_SERVER['PHP_SELF'] . '?Search=1&first=name&second=m&order=name&lowlimit=0>M</a> |
	<a href=' . $_SERVER['PHP_SELF'] . '?Search=1&first=name&second=n&order=name&lowlimit=0>N</a><br>
	<a href=' . $_SERVER['PHP_SELF'] . '?Search=1&first=name&second=o&order=name&lowlimit=0>O</a> |
	<a href=' . $_SERVER['PHP_SELF'] . '?Search=1&first=name&second=p&order=name&lowlimit=0>P</a> |
	<a href=' . $_SERVER['PHP_SELF'] . '?Search=1&first=name&second=q&order=name&lowlimit=0>Q</a> |
	<a href=' . $_SERVER['PHP_SELF'] . '?Search=1&first=name&second=r&order=name&lowlimit=0>R</a> |
	<a href=' . $_SERVER['PHP_SELF'] . '?Search=1&first=name&second=s&order=name&lowlimit=0>S</a> |
	<a href=' . $_SERVER['PHP_SELF'] . '?Search=1&first=name&second=t&order=name&lowlimit=0>T</a> |
	<a href=' . $_SERVER['PHP_SELF'] . '?Search=1&first=name&second=u&order=name&lowlimit=0>U</a> |
	<a href=' . $_SERVER['PHP_SELF'] . '?Search=1&first=name&second=v&order=name&lowlimit=0>V</a> |
	<a href=' . $_SERVER['PHP_SELF'] . '?Search=1&first=name&second=w&order=name&lowlimit=0>W</a> |
	<a href=' . $_SERVER['PHP_SELF'] . '?Search=1&first=name&second=x&order=name&lowlimit=0>X</a> |
	<a href=' . $_SERVER['PHP_SELF'] . '?Search=1&first=name&second=y&order=name&lowlimit=0>Y</a> |
	<a href=' . $_SERVER['PHP_SELF'] . '?Search=1&first=name&second=z&order=name&lowlimit=0>Z</a>
	</td></tr></table>';

    window_close();
}
print "
</td></tr>
<tr><td valign=bottom align=center>
<font size=-2>©2003 olafur@rootus.org | <a href=docs/ target=_blank><b>Manual</b></a>  | <a href=admin.php><b>$StrAdminLink</b></a> | $StrSource <a href=http://rootus.org/src.php>rootus.org</a></font>

</td></tr>
</table>

</body>
</html>";
CloseTable();
include('../../footer.php');
?>
