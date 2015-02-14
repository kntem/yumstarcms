<?php

$server = "192.168.1.201";
$user = "FoodOrder";
$password = "P6z8BD35ZCMQ79F";
$dbname = 'FoodOrder';

$con = mysql_connect($server, $user, $password);

mysql_set_charset('utf8', $con);

error_reporting(E_ERROR | E_PARSE);

if (!$con) {
    die('Database does not connect: ' . mysql_error());
}
else {
    mysql_select_db($dbname, $con);
}
?>