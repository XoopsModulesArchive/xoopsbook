<?php
/******************************************************************************
 * MyAddressbook written in PHP
 * Copyright (C)2000-2003 by olafur@rootus.org
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License.
 ******************************************************************************/
/****************************************************************************** 
 * Some variables
 ******************************************************************************/
$version = '1.1.1';		// Version number
$dags = date('d m Y');		// This sets the date used in "Last Updated" field
/****************************************************************************** 
 * PHP Functions
 ******************************************************************************/
function dbconnect() 
{
require 'db_config.php';
    mysql_connect((string)$db_host, (string)$db_user, (string)$db_pass) || die('Could not connect to server, check the config.php file');
    mysqli_select_db($GLOBALS['xoopsDB']->conn, (string)$db_db) || die('Could not select the database, check the config.php file');
}

function CheckPass() {
require 'db_config.php';
        header('WWW-authenticate: basic realm="Login to MyAddressbook"');
        header('HTTP/1.0 401 Unauthorized');
        $title = 'Password protected';
    ?>
		<center><br>
        <h3>MyAddressbook</h3>You need an valid username and password to access this page.<p><a href=".">Retour</a></b>
        </center>
    <?php
        exit;
}

function validateEmail($email)
{
return preg_match("^[a-zA-Z0-9\._-]+@[a-zA-Z0-9\._-]+$", $email);
}

function colorchange() 
{
require 'admin_config.php';
static $color;
if($color == $rowcolor1)
	{
	$color = $rowcolor2;
	}
	else
	{
	$color = $rowcolor1;
	}
return($color);
}

function Select_Fields()
{
print '
<option value=>Select</option>
<option value=name>Name</option>
<option value=home>Street</option>
<option value=place>City</option>
<option value=pnr>Zip Code</option>
<option value=phone>Phone</option>
<option value=gsm>Mobile</option>
<option value=email>E-mail</option>
<option value=www>Homepage</option>
<option value=country>Country</option>
<option value=comment>Comment</option>
';
}

function window() 
{
include 'lang/' . $_SESSION['Language'] . '';
require 'admin_config.php';
print "
	<table border=0 cellspacing=0 cellpadding=0><tr><td>
	<table border=0 cellspacing=0 cellpadding=3><tr><td bgcolor=$tabletitle>
	<table border=0 bgcolor=$tablebg cellspacing=0 cellpadding=2><tr><td align=center>
	<table border=0 bgcolor=$tabletitle width=100% cellspacing=0 cellpadding=1><tr><td width=20>
	<img src=images/prop.gif border=0></td>
	<td><font color=ffffff><b>$title</b></font></td><td align=right valign=bottom>
	<a href=.><img src=images/logoff.gif alt=Close border=0></a>
	</td></tr></table>";	
}

function window_close() 
{
print '
	</td></tr></table>
	</td></tr></table>
	</td></tr></table>';
}

function ShowForm()
{
include 'lang/' . $_SESSION['Language'] . '';
require 'admin_config.php';
print '<br>
	<form name=searchby method=post action=' . $_SERVER['PHP_SELF'] . ">	
	<input type=hidden name=Search value=1>
	<input type=hidden name=order value=name>
	<input type=hidden name=lowlimit value=0>
	<table border=0 cellspacing=0 cellpadding=0><tr><td>
	<table border=0 cellspacing=0 cellpadding=3><tr><td bgcolor=$tabletitle>
	<table border=0 bgcolor=$tablebg cellspacing=0 cellpadding=2><tr><td>
	<table border=0 bgcolor=$tabletitle width=100% cellspacing=0 cellpadding=1><tr><td width=20>
	<img src=images/address.gif border=0></td>
	<td><font color=#ffffff><b>$title</b></font></td>
	<td align=right valign=bottom width=20><a href=../..><img src=images/logoff.gif alt=Close border=0></a>
	</td></tr></table><p>
	$StrSearchFor
	<select name=first>
	<option value=name>$StrName
	<option value=home>$StrStreet
	<option value=email>$StrEmail
	<option value=place>$StrCity
	<option value=country>$StrCountry
	</select>
	<input type=text size=15 name=second>
	<input type=submit value=\"$StrSearch !\"><p>
	</td></form></td></table>
	</td></tr></table>
	</td>
		<td>";
		

if ($icontheme != 'hide')
{
	print '&nbsp;</td>
	<td>
	<form method=get action=' . $_SERVER['PHP_SELF'] . ">
	<table border=0 cellspacing=0 cellpadding=3><tr><td bgcolor=$tabletitle>
	<table border=0 bgcolor=$tablebg cellspacing=0 cellpadding=2><tr><td align=center>
	<table border=0 bgcolor=$tabletitle width=100% cellspacing=0 cellpadding=1><tr>
	<td width=20><img src=images/newaddress.gif></td><td>
	<font color=#ffffff><b>&nbsp; $StrAddNew &nbsp;</b></font></td><td align=right valign=bottom>
	<img src=images/logoff.gif border=0>
	</td></tr></table><p>
	<input type=hidden name=AddNew value=1>
	<input type=submit value=\"$StrAddNew\"><p>
	</td></form></tr></table>
	</td></tr></table>
	</td>
	<td>";
}	
	print "&nbsp;
	</td>
	<td>
	<form method=post action=index.php?NewLang=1>
	<table border=0 cellspacing=0 cellpadding=3><tr><td bgcolor=$tabletitle>
	<table border=0 bgcolor=$tablebg cellspacing=0 cellpadding=2><tr><td align=center>
	<table border=0 bgcolor=$tabletitle width=100% cellspacing=0 cellpadding=1><tr>
	<td width=20><img src=images/newaddress.gif></td><td>
	<font color=#ffffff><b>$StrLangTitle</b></font></td><td align=right valign=bottom>
	<img src=images/logoff.gif border=0>
	</td></tr></table><p>
	<select name=lang onChange=\"this.form.submit()\">";
	$dir = opendir('lang/');
	while (($file = readdir($dir)) !== false) {
    if ($file != '.' && $file != '..') {
		$shfile = preg_replace('.php', '', $file);
		$shfile = preg_replace('strings_', '', $shfile);
		$shfile = strtoupper($shfile);
        if ($_SESSION['Language'] == $file) {
            print "<option value=\"$file\" SELECTED>$shfile</option>\n";
			} else {
            print "<option value=\"$file\">$shfile</option>\n";
			}
		}
	}
	closedir($dir);
	print '		
	</select><p>
	</td></form></tr></table>
	</td></tr></table>
	</td></tr></table><p>';
}

function CountryList()
{
print '
		<option value="Afghanistan">Afghanistan</option>
		<option value="Albania">Albania</option>
		<option value="Algeria">Algeria</option>
		<option value="American Somoa">American Somoa</option>
		<option value="Andorra">Andorra</option>
		<option value="Angola">Angola</option>
		<option value="Anguilla">Anguilla</option>
		<option value="Antarctica">Antarctica</option>
		<option value="Antigua and Barbuda">Antigua and Barbuda</option>
		<option value="Argentina">Argentina</option>
		<option value="Armenia">Armenia</option>
		<option value="Aruba">Aruba</option>
		<option value="Australia">Australia</option>
		<option value="Austria">Austria</option>
		<option value="Azerbaidjan">Azerbaidjan</option>
		<option value="Bahamas">Bahamas</option>
		<option value="Bahrain">Bahrain</option>
		<option value="Banglades">Banglades</option>
		<option value="Barbados">Barbados</option>
		<option value="Belarus">Belarus</option>
		<option value="Belgium">Belgium</option>
		<option value="Belize">Belize</option>
		<option value="Benin">Benin</option>
		<option value="Bermuda">Bermuda</option>
		<option value="Bolivia">Bolivia</option>
		<option value="Bosnia-Herzegovina">Bosnia-Herzegovina</option>
		<option value="Botswana">Botswana</option>
		<option value="Bouvet Island">Bouvet Island</option>
		<option value="Brazil">Brazil</option>
		<option value="British Indian O. Terr.">British Indian O. Terr.</option>
		<option value="Brunei Darussalam">Brunei Darussalam</option>
		<option value="Bulgaria">Bulgaria</option>
		<option value="Barkina Faso">Barkina Faso</option>
		<option value="Burundi">Burundi</option>
		<option value="Buthan">Buthan</option>
		<option value="Cambodia">Cambodia</option>
		<option value="Cameroon">Cameroon</option>
		<option value="Canada">Canada</option>
		<option value="Cape Verde">Cape Verde</option>
		<option value="Cayman Islands">Cayman Islands</option>
		<option value="Central African Rep.">Central African Rep.</option>
		<option value="Chad">Chad</option>
		<option value="Chile">Chile</option>
		<option value="China">China</option>
		<option value="Christmas Island">Christmas Island</option>
		<option value="Cocos (Keeling) Isl.">Cocos (Keeling) Isl.</option>
		<option value="Colombia">Colombia</option>
		<option value="Comoros">Comoros</option>
		<option value="Congo">Congo</option>
		<option value="Cook Islands">Cook Islands</option>
		<option value="Costa Rica">Costa Rica</option>
		<option value="Croatia">Croatia</option>
		<option value="Cyprus">Cyprus</option>
		<option value="Czech Republic">Czech Republic</option>
		<option value="Denmark">Denmark</option>
		<option value="Djibouti">Djibouti</option>
		<option value="Dominica">Dominica</option>
		<option value="Dominican Republic">Dominican Republic</option>
		<option value="East Timor">East Timor</option>
		<option value="Ecuador">Ecuador</option>
		<option value="Egypt">Egypt</option>
		<option value="El Salvador">El Salvador</option>
		<option value="Equatorial Guinea">Equatorial Guinea</option>
		<option value="Estonia">Estonia</option>
		<option value="Ethiopia">Ethiopia</option>
		<option value="Falkland Isl.(Malvinas)">Falkland Isl.(Malvinas)</option>
		<option value="Faroe Islands">Faroe Islands</option>
		<option value="Fiji">Fiji</option>
		<option value="Finland">Finland</option>
		<option value="France (European Terr.)">France (European Terr.)</option>
		<option value="France">France</option>
		<option value="French Southern Terr.">French Southern Terr.</option>
		<option value="Gabon">Gabon</option>
		<option value="Gambia">Gambia</option>
		<option value="Georgia">Georgia</option>
		<option value="Germany">Germany</option>
		<option value="Ghana">Ghana</option>
		<option value="Gibralter">Gibralter</option>
		<option value="Great Britain (UK)">Great Britain (UK)</option>
		<option value="Greece">Greece</option>
		<option value="Greenland">Greenland</option>
		<option value="Grenada">Grenada</option>
		<option value="Guadeloupe (Fr.)">Guadeloupe (Fr.)</option>
		<option value="Guam (US)">Guam (US)</option>
		<option value="Guatemala">Guatemala</option>
		<option value="Guinea Bissau">Guinea Bissau</option>
		<option value="Guinea">Guinea</option>
		<option value="Guyana (Fr.)">Guyana (Fr.)</option>
		<option value="Guyana">Guyana</option>
		<option value="Haiti">Haiti</option>
		<option value="Heard & McDonald Isl.">Heard & McDonald Isl.</option>
		<option value="Honduras">Honduras</option>
		<option value="Hong Kong">Hong Kong</option>
		<option value="Hungary">Hungary</option>
		<option value="Iceland">Iceland</option>
		<option value="India">India</option>
		<option value="Indonesia">Indonesia</option>
		<option value="Iraq">Iraq</option>
		<option value="Ireland">Ireland</option>
		<option value="Israel">Israel</option>
		<option value="Italy">Italy</option>
		<option value="Ivory Coast">Ivory Coast</option>
		<option value="Jamaica">Jamaica</option>
		<option value="Japan">Japan</option>
		<option value="Jordan">Jordan</option>
		<option value="Kazakhstan">Kazakhstan</option>
		<option value="Kenya">Kenya</option>
		<option value="Kyrgyzstan">Kyrgyzstan</option>
		<option value="Korea (North)">Korea (North)</option>
		<option value="Korea (South)">Korea (South)</option>
		<option value="Kuwait">Kuwait</option>
		<option value="Laos">Laos</option>
		<option value="Latvia">Latvia</option>
		<option value="Lebanon">Lebanon</option>
		<option value="Lesotho">Lesotho</option>
		<option value="Liberia">Liberia</option>
		<option value="Libya">Libya</option>
		<option value="Liechtenstein">Liechtenstein</option>
		<option value="Lithuania">Lithuania</option>
		<option value="Luxembourg">Luxembourg</option>
		<option value="Macau">Macau</option>
		<option value="Madagascar">Madagascar</option>
		<option value="Malawi">Malawi</option>
		<option value="Malaysia">Malaysia</option>
		<option value="Maldives">Maldives</option>
		<option value="Mali">Mali</option>
		<option value="Malta">Malta</option>
		<option value="Marshall Islands">Marshall Islands</option>
		<option value="Martinique (Fr.)">Martinique (Fr.)</option>
		<option value="Mauritania">Mauritania</option>
		<option value="Mauritius">Mauritius</option>
		<option value="Mexico">Mexico</option>
		<option value="Micronesia">Micronesia</option>
		<option value="Moldova">Moldova</option>
		<option value="Monaco">Monaco</option>
		<option value="Mongolia">Mongolia</option>
		<option value="Montserrat">Montserrat</option>
		<option value="Morocco">Morocco</option>
		<option value="Mozambique">Mozambique</option>
		<option value="Myanmar">Myanmar</option>
		<option value="Namibia">Namibia</option>
		<option value="Nauru">Nauru</option>
		<option value="Nepal">Nepal</option>
		<option value="Netherland Antilles">Netherland Antilles</option>
		<option value="Netherlands">Netherlands</option>
		<option value="Neutral Zone">Neutral Zone</option>
		<option value="New Caledonia (Fr.)">New Caledonia (Fr.)</option>
		<option value="New Zealand">New Zealand</option>
		<option value="Nicaragua">Nicaragua</option>
		<option value="Niger">Niger</option>
		<option value="Nigeria">Nigeria</option>
		<option value="Niue">Niue</option>
		<option value="Norfolk Island">Norfolk Island</option>
		<option value="Northern Mariana Isl.">Northern Mariana Isl.</option>
		<option value="Norway">Norway</option>
		<option value="Oman">Oman</option>
		<option value="Pakistan">Pakistan</option>
		<option value="Palau">Palau</option>
		<option value="Panama">Panama</option>
		<option value="Papua New Guinea">Papua New Guinea</option>
		<option value="Paraguay">Paraguay</option>
		<option value="Peru">Peru</option>
		<option value="Philippines">Philippines</option>
		<option value="Pitcairn">Pitcairn</option>
		<option value="Poland">Poland</option>
		<option value="Polynesia (Fr.)">Polynesia (Fr.)</option>
		<option value="Portugal">Portugal</option>
		<option value="Puerto Rico (US)">Puerto Rico (US)</option>
		<option value="Qatar">Qatar</option>
		<option value="Reunion (Fr.)">Reunion (Fr.)</option>
		<option value="Romania">Romania</option>
		<option value="Russian Federation">Russian Federation</option>
		<option value="Rwanda">Rwanda</option>
		<option value="Saint Lucia">Saint Lucia</option>
		<option value="Samoa">Samoa</option>
		<option value="San Marino">San Marino</option>
		<option value="Saudi Arabia">Saudi Arabia</option>
		<option value="Senegal">Senegal</option>
		<option value="Seychelles">Seychelles</option>
		<option value="Sierra Leone">Sierra Leone</option>
		<option value="Singapore">Singapore</option>
		<option value="Slovak Republic">Slovak Republic</option>
		<option value="Slovenia">Slovenia</option>
		<option value="Solomon Islands">Solomon Islands</option>
		<option value="Somalia">Somalia</option>
		<option value="South Africa">South Africa</option>
		<option value="Spain">Spain</option>
		<option value="Sri Lanka">Sri Lanka</option>
		<option value="St. Helena">St. Helena</option>
		<option value="St. Pierre & Miquelon">St. Pierre & Miquelon</option>
		<option value="St. Tome and Principe">St. Tome and Principe</option>
		<option value="St.Kitts Nevis Anguilla">St.Kitts Nevis Anguilla</option>
		<option value="St.Vincent & Grenadines">St.Vincent & Grenadines</option>
		<option value="Sudan">Sudan</option>
		<option value="Suriname">Suriname</option>
		<option value="Svalbard & Jan Mayen Is">Svalbard & Jan Mayen Is</option>
		<option value="Swaziland">Swaziland</option>
		<option value="Sweden">Sweden</option>
		<option value="Switzerland">Switzerland</option>
		<option value="Tajikistan">Tajikistan</option>
		<option value="Taiwan">Taiwan</option>
		<option value="Tanzania">Tanzania</option>
		<option value="Thailand">Thailand</option>
		<option value="Togo">Togo</option>
		<option value="Tokelau">Tokelau</option>
		<option value="Tonga">Tonga</option>
		<option value="Trinidad & Tobago">Trinidad & Tobago</option>
		<option value="Tunisia">Tunisia</option>
		<option value="Turkey">Turkey</option>
		<option value="Turkmenistan">Turkmenistan</option>
		<option value="Turks & Caicos Islands">Turks & Caicos Islands</option>
		<option value="Tuvalu">Tuvalu</option>
		<option value="US Minor outlying Isl.">US Minor outlying Isl.</option>
		<option value="Uganda">Uganda</option>
		<option value="Ukraine">Ukraine</option>
		<option value="United Arab Emirates">United Arab Emirates</option>
		<option value="United Kingdom">United Kingdom</option>
		<option value="United States">United States</option>
		<option value="Uruguay">Uruguay</option>
		<option value="Uzbekistan">Uzbekistan</option>
		<option value="Vanuatu">Vanuatu</option>
		<option value="Vatican City">Vatican City</option>
		<option value="Venezuela">Venezuela</option>
		<option value="Vietnam">Vietnam</option>
		<option value="Virgin Islands (British)">Virgin Islands (British)</option>
		<option value="Virgin Islands (US)">Virgin Islands (US)</option>
		<option value="Wallis & Futuna Islands">Wallis & Futuna Islands</option>
		<option value="Western Sahara">Western Sahara</option>
		<option value="Yemen">Yemen</option>
		<option value="Yugoslavia">Yugoslavia</option>
		<option value="Congo, Dem. Rep.">Congo, Dem. Rep.</option>
		<option value="Zambia">Zambia</option>
		<option value="Zimbabwe">Zimbabwe</option>
';
}

?>
