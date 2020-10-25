<?php
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
BODY		{font-size: <?php print $_REQUEST['fontsize']; ?>; font-family: <?php print $_REQUEST['fontfamily']; ?>;}
TD		{font-size: <?php print $_REQUEST['fontsize']; ?>; font-family: <?php print $_REQUEST['fontfamily']; ?>;}
-->
</style>
<title>MyAddressbook</title>
</head>

<body bgcolor=#ffffff text=#000000>
<table border=0 align=center><tr><td>
<table border=0 width=<?php print $_REQUEST['pagewidth']; ?> cellpadding=0 cellspacing=1 bgcolor=#000000><tr><td>
<table border=0 width=<?php print $_REQUEST['pagewidth']; ?> cellpadding=10 cellspacing=1 bgcolor=#ffffff><tr><td>
<center>

<?php
    dbconnect();
    $query = "select * from $db_table order by " . $_REQUEST['orderby'] . '';
    $result = $GLOBALS['xoopsDB']->queryF($query);
    $number = @$GLOBALS['xoopsDB']->getRowsNum($result);
    $i = 0;
    if (0 == $number) :
    print 'Nothing found';
    elseif ($number > 0) :
    $HeadPrint = $_REQUEST['printhead'];
    if ($HeadPrint) {
        print "<center><h3>$HeadPrint</h3></center>";
    }
    print '<table'; if ($_REQUEST['grid']) {
        print ' border=1';
    } print ' width=100% cellspacing=0 cellpadding=2>';
    print '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
    while ($i < $number) :
    $$_REQUEST['nr1'] = mysql_result($result, $i, $_REQUEST['nr1']);
    if ($_REQUEST['nr2']) {
        $$_REQUEST['nr2'] = mysql_result($result, $i, $_REQUEST['nr2']);
    }
    if ($_REQUEST['nr3']) {
        $$_REQUEST['nr3'] = mysql_result($result, $i, $_REQUEST['nr3']);
    }
    if ($_REQUEST['nr4']) {
        $$_REQUEST['nr4'] = mysql_result($result, $i, $_REQUEST['nr4']);
    }
    if ($_REQUEST['nr5']) {
        $$_REQUEST['nr5'] = mysql_result($result, $i, $_REQUEST['nr5']);
    }
    if ($_REQUEST['nr6']) {
        $$_REQUEST['nr6'] = mysql_result($result, $i, $_REQUEST['nr6']);
    }

    $nr1 = $$_REQUEST['nr1'];
    if ($_REQUEST['nr2']) {
        $nr2 = $$_REQUEST['nr2'];
    }
    if ($_REQUEST['nr3']) {
        $nr3 = $$_REQUEST['nr3'];
    }
    if ($_REQUEST['nr4']) {
        $nr4 = $$_REQUEST['nr4'];
    }
    if ($_REQUEST['nr5']) {
        $nr5 = $$_REQUEST['nr5'];
    }
    if ($_REQUEST['nr6']) {
        $nr6 = $$_REQUEST['nr6'];
    }

    if ($_REQUEST['shownumber']) {
        $shownumber = ($i + '1');
    }

    print "<tr><td>$shownumber $nr1</td><td>$nr2&nbsp;</td><td>$nr3&nbsp;</td><td>$nr4&nbsp;</td><td>$nr5&nbsp;</td><td>$nr6&nbsp;</td></tr>";

    $i++;
    endwhile;
    print '</table>';
    $FootPrint = $_REQUEST['printfoot'];
    if ($FootPrint) {
        print "<center><i>$FootPrint</i></center>";
    }
    endif;
?>
</center>
</td></tr></table>
</td></tr></table>
</td></tr></table>

</body>
</html>
