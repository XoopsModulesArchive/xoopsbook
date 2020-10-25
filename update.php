<?php
include '../../mainfile.php';
include '../../header.php';
OpenTable();
session_start();
if (!isset($_SESSION['Language'])) {
    $_SESSION['Language'] = 'strings_en.php';
}
require 'functions.php';
require 'db_config.php'; ?>
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
A:LINK		{color : #003333; text-decoration : underline;}
A:VISITED	{color : #003333; text-decoration : underline;}
A:HOVER		{color : red; text-decoration : none;}
-->
</style>
<title>Administration</title>
</head>

<body 
	bgcolor=#ffffee>

<?php
if ('1' == $_REQUEST['DoUpdate']) {
    dbconnect();

    $query = "update $db_table_config set bgcolor='" . $_REQUEST['bgcolor'] . "', tablebg='" . $_REQUEST['tablebg'] . "', tabletitle='" . $_REQUEST['tabletitle'] . "', rowcolor1='" . $_REQUEST['rowcolor1'] . "',  rowcolor2='" . $_REQUEST['rowcolor2'] . "', topmargin='" . $_REQUEST['topmargin'] . "', leftmargin='" . $_REQUEST['leftmargin'] . "', marginheight='" . $_REQUEST['marginheight'] . "', marginwidth='" . $_REQUEST['marginwidth'] . "',  title='" . $_REQUEST['title'] . "', fontsize='" . $_REQUEST['fontsize'] . "', fontfamily='" . $_REQUEST['fontfamily'] . "', textcolor='" . $_REQUEST['textcolor'] . "', alink='" . $_REQUEST['alink'] . "', vlink='" . $_REQUEST['vlink'] . "',  hover='" . $_REQUEST['hover'] . "', icontheme='" . $_REQUEST['icontheme'] . "'";

    $result = $GLOBALS['xoopsDB']->queryF($query);

    print "<h3>MyAddressbook $version</h3>Base de donnée mise a jour avec succés";
} elseif ('1' == $_REQUEST['Default']) {
    dbconnect();

    $query = "update config set bgcolor='#dddddd', tablebg='#eeeeee', tabletitle='#888888', rowcolor1='#eeeeee', rowcolor2='#fefefe', topmargin='0', leftmargin='0', marginheight='0', marginwidth='0',  title='MyAddressbook', fontsize='10pt', fontfamily='Verdana', textcolor='#000000', alink='#000033', vlink='#000033', hover='#ff0000', icontheme='nope'";

    $result = $GLOBALS['xoopsDB']->queryF($query);

    print "<h3>MyAddressbook $version</h3>Configuration changed back to default !";
} elseif ('1' == $_REQUEST['PrintPage']) {
    include 'admin_config.php';

    include 'lang/' . $_SESSION['Language'] . '';

    print "
<script language=\"JavaScript\">
<!-- hide
function closeIt() {
  close();
}
// -->
</script>
<body bgcolor=#ffffff text=#000000>
<center>
From $title $version<p>
</center>
<table border=0 align=center><tr><td>
<table border=0 width=640 cellpadding=0 cellspacing=1 bgcolor=#000000><tr><td>
<table border=0 width=640 cellpadding=20 cellspacing=1 bgcolor=#ffffff><tr><td>
<center>";

    $query = "select * from $db_table where id =  '" . $_REQUEST['id'] . "'";

    $result = $GLOBALS['xoopsDB']->queryF($query);

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

    print "
<table border=0 width=100%>
<tr><td colspan=2><h4>$name</h4></td></tr>";

    if ($home) {
        print "<tr><td colspan=2>$home</td></tr>";
    }

    if ($pnr || $place) {
        print "<tr><td colspan=2>$pnr $place</td></tr>";
    }

    if ($country) {
        print "<tr><td colspan=2>$country</td></tr><p>";
    }

    print '<tr><td colspan=2><br></td></tr>';

    if ($phone) {
        print "<tr><td>$StrPhone</td><td>$phone</td></tr>";
    }

    if ($gsm) {
        print "<tr><td>$StrMobile</td><td>$gsm</td></tr>";
    }

    if ($email) {
        print "<tr><td>$StrEmail</td><td>$email</td></tr>";
    }

    $wwwlen = mb_strlen($www);

    if ($wwwlen > 8) {
        print "<tr><td>$StrWWW</td><td>$www</td></tr>";
    }

    if ($comment) {
        print "<tr><td><br>$StrNote</td><td><br>$comment</td></tr>";
    }

    print '
</table>
</center>
</td></tr></table>
</td></tr></table>
<br><br>
<center>
<a href=. onClick="closeIt()">Fermer</a>
</center>
';
} else {
    print '';
}
if (!$_REQUEST['PrintPage']) {
    print "
<p><b>
<a href=admin.php>Retour admin</a><p>
<a href=.>Retour carnet d'adresse</a><p>
</b>";
}
CloseTable();
include('../../footer.php');
?>
</body>
</html>
