# phpMyAdmin MySQL-Dump
# version 2.3.3pl1
# http://www.phpmyadmin.net/ (download page)
#
# Host: localhost
# Generation Time: Feb 21, 2003 at 11:33 AM
# Server version: 3.23.49
# PHP Version: 4.1.2
# Database : `MyAddressbook`
# --------------------------------------------------------

#
# Table structure for table `xoopsbook_config`
#

CREATE TABLE xoopsbook_config (
    bgcolor      VARCHAR(10)  NOT NULL DEFAULT '',
    topmargin    CHAR(1)      NOT NULL DEFAULT '',
    leftmargin   CHAR(1)      NOT NULL DEFAULT '',
    marginheight CHAR(1)      NOT NULL DEFAULT '',
    marginwidth  CHAR(1)      NOT NULL DEFAULT '',
    tablebg      VARCHAR(10)  NOT NULL DEFAULT '',
    tabletitle   VARCHAR(10)  NOT NULL DEFAULT '',
    rowcolor1    VARCHAR(10)  NOT NULL DEFAULT '',
    rowcolor2    VARCHAR(10)  NOT NULL DEFAULT '',
    title        VARCHAR(40)  NOT NULL DEFAULT '',
    fontsize     VARCHAR(10)  NOT NULL DEFAULT '',
    fontfamily   VARCHAR(100) NOT NULL DEFAULT '',
    textcolor    VARCHAR(10)  NOT NULL DEFAULT '',
    alink        VARCHAR(10)  NOT NULL DEFAULT '',
    vlink        VARCHAR(10)  NOT NULL DEFAULT '',
    hover        VARCHAR(10)  NOT NULL DEFAULT '',
    icontheme    VARCHAR(10)  NOT NULL DEFAULT ''
)
    ENGINE = ISAM;

#
# Dumping data for table `xoopsbook_config`
#

INSERT INTO xoopsbook_config
VALUES ('#dddddd', '0', '0', '0', '0', '#eeeeee', '#888888', '#eeeeee', '#fefefe', 'MyAddressbook', '10pt', 'Verdana', '#000000', '#000033', '#000033', '#ff0000', 'nope');
# --------------------------------------------------------

#
# Table structure for table `xoopsbook_olafur`
#

CREATE TABLE xoopsbook_olafur (
    id      INT(11)     NOT NULL AUTO_INCREMENT,
    name    VARCHAR(60) NOT NULL DEFAULT '',
    home    VARCHAR(60) NOT NULL DEFAULT '',
    place   VARCHAR(60) NOT NULL DEFAULT '',
    country VARCHAR(60) NOT NULL DEFAULT '',
    phone   VARCHAR(30) NOT NULL DEFAULT '',
    gsm     VARCHAR(30) NOT NULL DEFAULT '',
    email   VARCHAR(40) NOT NULL DEFAULT '',
    www     VARCHAR(60) NOT NULL DEFAULT '',
    pnr     VARCHAR(11) NOT NULL DEFAULT '',
    comment TEXT        NOT NULL,
    date    VARCHAR(12) NOT NULL DEFAULT '',
    PRIMARY KEY (id)
)
    ENGINE = ISAM;

