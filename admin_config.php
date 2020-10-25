<?php
/******************************************************************************
 * MyAddressbook written in PHP
 * Copyright (C)2000-2003 by olafur@rootus.org
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License.
 ******************************************************************************/
require 'db_config.php';
@mysql_connect((string)$db_host, (string)$db_user, (string)$db_pass) || die('Could not connect to server, check the admin_config.php file');
@mysqli_select_db($GLOBALS['xoopsDB']->conn, (string)$db_db) || die('Could not select the database, check the admin_config.php file');
$query = "select * from $db_table_config";
$result = $GLOBALS['xoopsDB']->queryF($query);
$number = $GLOBALS['xoopsDB']->getRowsNum($result);
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
