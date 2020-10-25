<?php
/******************************************************************************
 * MyAddressbook written in PHP
 * Copyright (C)2000-2003 by olafur@rootus.org
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License.
 ******************************************************************************/

header('Content-Disposition: attachment; filename=MyAddressbook.txt');
header('Content-Length: ' . mb_strlen(@$output));
header('Connection: close');
header('Content-Type: text/plain; name=MyAddressbook.txt');

include 'db_config.php';
include 'functions.php';
dbconnect();
    $query = "select * from $db_table where name like '%' order by id";
    $result = $GLOBALS['xoopsDB']->queryF($query);
    $number = $GLOBALS['xoopsDB']->getRowsNum($result);
    $i = 0;
    if (0 == $number) :
    print 'Found 0';
    elseif ($number > 0) :
    while ($i < $number) :
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
    $name = ucwords($name);
    $home = ucfirst($home);
    $place = ucfirst($place);
    $country = ucfirst($country);
    $comment = trim($comment);
    $name = trim($name);
    $email = trim($email);
    $phone = trim($phone);
    $gsm = trim($gsm);
    $home = trim($home);
    $place = trim($place);
    $pnr = trim($pnr);
    $country = trim($country);

    if ('1' == @$_REQUEST['Moz']) {
        $output = "$name\t\t$name\t\t$email\t\t\t$phone\t\t\t$gsm\t$home\t\t$place\t\t$pnr\t$country\t\t\t\t\t\t\t\t\t\t$www\n";
    } else {
        $output = ";;;$name;;$email;$home;$place;$pnr;;$country;$phone;;$gsm;$www\n";
    }

    echo $output;

    $i++;
    endwhile;
    endif;
