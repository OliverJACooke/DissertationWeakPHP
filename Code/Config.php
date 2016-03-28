<?php
session_start();
$connection = mysql_connect("192.168.16.25","usr_weak",'%Pa55w0rd') or die("Could Not Connect");
mysql_select_db("WeakDB") or die("Couldnt find DB");
?>
