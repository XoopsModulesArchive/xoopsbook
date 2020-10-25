<?php
include '../../mainfile.php';
include '../../header.php';
OpenTable();
session_start();
if (!isset($_SESSION['Lang'])) {
    $_SESSION['Lang'] = 'strings_en.php';
}
include 'functions.php';
require 'db_config.php';
/* A really lame password scheme, just dont see the reason of using .htaccess for this file, no big secrets here */
if (!isset($_SERVER['PHP_AUTH_USER'])) {
    CheckPass();
} else {
    if ($_SERVER['PHP_AUTH_USER'] != (string)$admin_user || $_SERVER['PHP_AUTH_PW'] != (string)$admin_pass) {
        CheckPass();
    }
}
?> 
<html>
<head>
<!-- 
/******************************************************************************
*
* Addressbook written in PHP
* Copyright (C)2000-2003 by olafur@rootus.org
*
* This program is free software; you can redistribute it and/or
* modify it under the terms of the GNU General Public License.
*
******************************************************************************/
-->
<style type="text/css">
<!--
BODY		{font-size: 10pt; font-family: Verdana, Tahoma, Arial, Helvetica, sans-serif}
TD			{font-size: 10pt; font-family: Verdana, Tahoma, Arial, Helvetica, sans-serif}
INPUT		{font-size: 10pt; font-family: Verdana, Tahoma, Arial, Helvetica, sans-serif}
A:LINK		{color : #003333; text-decoration : none;}
A:VISITED	{color : #003333; text-decoration : none;}
A:HOVER		{color : #003333; text-decoration : none;}
-->
</style>
<title>MyAddressbook - Admin</title>
</head>

<body bgcolor=#ffffee>

<table border=1 bordercolor=#FF0000 cellpadding=3 cellspacing=3>
<tr><td bgcolor=#FF8800><b><a href=admin.php>Configuration</a></b></td>
<td bgcolor=#FF9900><b><a href=admin.php?Show=PrintList>Report Generator</a></b></td>
<td bgcolor=#FFAA00><b><a href=admin.php?Show=Import>Import / Export</a></b></td>
<td bgcolor=#FFBB00><b><a href=".">Mon carnet d'adresse</a></b></td></tr>
</table>
<br>
<?php

if (!$_REQUEST['Show']) {
    dbconnect();

    $query = "select * from $db_table_config";

    $result = $GLOBALS['xoopsDB']->queryF($query);

    $bgcolor = mysql_result($result, $i, 'bgcolor');

    $topmargin = mysql_result($result, $i, 'topmargin');

    $leftmargin = mysql_result($result, $i, 'leftmargin');

    $marginheight = mysql_result($result, $i, 'marginheight');

    $marginwidth = mysql_result($result, $i, 'marginwidth');

    $tablebg = mysql_result($result, $i, 'tablebg');

    $tabletitle = mysql_result($result, $i, 'tabletitle');

    $rowcolor1 = mysql_result($result, $i, 'rowcolor1');

    $rowcolor2 = mysql_result($result, $i, 'rowcolor2');

    $title = mysql_result($result, $i, 'title');

    $fontsize = mysql_result($result, $i, 'fontsize');

    $fontfamily = mysql_result($result, $i, 'fontfamily');

    $textcolor = mysql_result($result, $i, 'textcolor');

    $alink = mysql_result($result, $i, 'alink');

    $vlink = mysql_result($result, $i, 'vlink');

    $hover = mysql_result($result, $i, 'hover');

    $icontheme = mysql_result($result, $i, 'icontheme');

    print "
<h3>Configuration</h3>
<table border=0 bordercolor=#FFAA00x><tr><td>
<form method=post action=update.php?DoUpdate=1>
Background Color</td><td><input type=text size=8 name=bgcolor value='$bgcolor'></td><td width=25 colspan=2 bgcolor='$bgcolor'></td></tr>
<tr><td>Table Background</td><td><input type=text size=8 name=tablebg value='$tablebg'></td><td width=25 colspan=2 bgcolor='$tablebg'</td></tr>
<tr><td>Table Title</td><td><input type=text size=8 name=tabletitle value='$tabletitle'></td><td width=25 colspan=2 bgcolor='$tabletitle'</td></tr>
<tr><td>Table Rowcolor 1</td><td><input type=text size=8 name=rowcolor1 value='$rowcolor1'></td><td width=25 colspan=2 bgcolor='$rowcolor1'</td></tr>
<tr><td>Table Rowcolor 2</td><td><input type=text size=8 name=rowcolor2 value='$rowcolor2'></td><td width=25 colspan=2 bgcolor='$rowcolor2'></td></tr>
<tr><td>Text Color</td><td><input type=text size=8 name=textcolor value='$textcolor'></td><td width=25 colspan=2 bgcolor='$textcolor'></td></tr>
<tr><td>A:Link</td><td><input type=text size=8 name=alink value='$alink'></td><td width=25 colspan=2 bgcolor='$alink'></td></tr>
<tr><td>A:Visited</td><td><input type=text size=8 name=vlink value='$vlink'></td><td width=25 colspan=2 bgcolor='$vlink'></td></tr>
<tr><td>A:Hover</td><td><input type=text size=8 name=hover value='$hover'></td><td width=25 colspan=2 bgcolor='$hover'></td></tr>
<tr><td>Page Title</td><td colspan=4><input type=text size=33 name=title value='$title'></td></tr>
<tr><td>Topmargin</td><td><input type=text size=1 name=topmargin value='$topmargin'></td>
<td>Leftmargin</td><td><input type=text size=1 name=leftmargin value='$leftmargin'></td></tr>
<tr><td>Marginheight</td><td><input type=text size=1 name=marginheight value='$marginheight'></td>
<td>Marginwidth</td><td><input type=text size=1 name=marginwidth value='$marginwidth'></td></tr>
<tr><td>Fonts</td>
<td><select name=fontfamily>
<option value='$fontfamily'>'$fontfamily'
<option value=Verdana>Verdana
<option value=Tahoma>Tahoma
<option value=Helvetica>Helvetica
<option value='Century Gothic'>Century Gothic
<option value='Comic Sans MS'>Comic Sans MS
<option value=Georgia>Georgia
<option value=Terminal>Terminal
<option value='Trebuchet MS'>Trebuchet MS
<option value=Courier>Courier
<option value=Ariel>Ariel
</select></td>
<td>Font size</td>
<td><select name=fontsize>
<option value='$fontsize'>$fontsize
<option value=8pt>8pt
<option value=10pt>10pt
<option value=12pt>12pt
<option value=14pt>14pt
<option value=16pt>16pt
<option value=18pt>18pt
</select></td></tr>
<tr><td colspan=3><b>Lecture seule</b> ? <small>(Desactive Ajouter, Effacer et Mettre à jour)</small></td><td><input type=checkbox name=icontheme value=hide";

    if ('hide' == $icontheme) {
        print ' checked';
    }

    print '></td></tr>
<tr><td colspan=4>&nbsp;</td></tr>
<tr><td colspan=2><input type=submit value="Soumettre">
</form></td>
<td colspan=2>
<form method=post action=update.php?Default=1>
<input type=submit value=" Par Defaut">
</form>
</td></tr></table>';
}

if ('PrintList' == $_REQUEST['Show']) {
    print "
<h3>Report Generator</h3>
<table>
<form method=post action=printlist.php target=_blank>
<tr><td colspan=2><b>Page Setup</b></td></tr>
<tr><td>Font Size</td><td>
<select name=fontsize>
<option value=8pt>8pt
<option value=10pt selected>10pt
<option value=12pt>12pt
<option value=14pt>14pt
<option value=16pt>16pt
<option value=18pt>18pt
</select></td></tr>
<tr><td>Font Face</td><td>
<select name=fontfamily>
<option value=\"Verdana, Arial, Helvetica, sans-serif\">Verdana
<option value=\"Tahoma, Arial, Helvetica, sans-serif\">Tahoma
<option value=\"Helvetica, sans-serif\">Helvetica
<option value='Century Gothic'>Century Gothic
<option value='Comic Sans MS'>Comic Sans MS
<option value=Georgia>Georgia
<option value=Terminal>Terminal
<option value='Trebuchet MS'>Trebuchet MS
<option value=Courier>Courier
<option value=Ariel>Ariel
</select></td></tr>
<tr><td>Page Width</td><td>
<select name=pagewidth>
<option value=400>400
<option value=480>480
<option value=640 selected>640
<option value=720>720
<option value=800>800
<option value=960>960
<option value=1280>1280
</select></td></tr>
<tr><td>Page Header</td><td><input type=text name=printhead></td></tr>
<tr><td>Page Footer</td><td><input type=text name=printfoot></td></tr>
<tr><td colspan=2><b>Options</b></td></tr>
<tr><td>Order By</td><td>
<select name=orderby>
<option value=id>id</option>
<option value=name selected>Nom</option>
<option value=home>Rue</option>
<option value=place>Ville</option>
<option value=pnr>Code Postal</option>
<option value=phone>téléphone</option>
<option value=gsm>Mobile</option>
<option value=email>E-mail</option>
<option value=www>Url</option>
<option value=country>Pays</option>
<option value=comment>Commentaire</option>
</select></td></tr>
<tr><td>Nombres</td><td><input type=checkbox name=shownumber></td></tr>
<tr><td>Montrer Grille</td><td><input type=checkbox name=grid></td></tr>
<tr><td colspan=2><b>Choisissez Les Champs pour m'impression</b></td></tr>
<tr><td>Champ 1</td><td><select name=nr1>
<option value=name>Nom</option>
<option value=home>Rue</option>
<option value=place>Ville</option>
<option value=pnr>Code postal</option>
<option value=phone>Téléphone</option>
<option value=gsm>Mobile</option>
<option value=email>E-mail</option>
<option value=www>Url</option>
<option value=country>Pays</option>
<option value=comment>Commentaire</option>
</select></td></tr>
<tr><td>Champ 2</td><td><select name=nr2>";

    Select_Fields();

    print '</select></td></tr>
<tr><td>Champ 3</td><td><select name=nr3>';

    Select_Fields();

    print '</select></td></tr>
<tr><td>Champ 4</td><td><select name=nr4>';

    Select_Fields();

    print '</select></td></tr>
<tr><td>Champ 5</td><td><select name=nr5>';

    Select_Fields();

    print '</select></td></tr>
<tr><td>Champ 6</td><td><select name=nr6>';

    Select_Fields();

    print '</select></td></tr>
<tr><td colspan=2></td></tr>
<tr><td colspan=2><input type=submit value=" Aperçue "></td></tr>
</form>
</table>';
}

if ('Import' == $_REQUEST['Show']) {
    print "
<h3>Exportation</h3>	
Export Addressbook so it can imported into another program.<p>
Please note that you can save every address as vCard directly into your<br>
computers address book using the \"Closer Look\" option of the addressbook.<br>
But that will ofcause only save 1 address at a time.<p>

Pour exporter vers t'on carnet d'adresse Mozilla  - (Sous forme de fichier txt)<br>
clic <a href=export.php?Moz=1><b>ici</a></b><p>

Pour exporter vers t'on carnet d'adresse d'outlook express - (Sous forme de fichier txt)<br>
clic <a href=export.php><b>ici</a></b><p>";
}

CloseTable();
include('../../footer.php');
?>
