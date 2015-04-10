<?php

$server = "192.186.249.233";
$user = "Narola";
$password = "narola123";
$dbname = 'Foodorder';

$con = mysql_connect($server, $user, $password);

mysql_set_charset('utf8', $con);

date_default_timezone_set('UTC');

error_reporting(E_ERROR | E_PARSE);
function getDefaultDate()
{
    date_default_timezone_set('UTC');
    $dt = new DateTime();
    return $dt->format('Y-m-d H:i:s');
}

if (!$con) {
    die('Database does not connect: ' . mysql_error());
} else {
    mysql_select_db($dbname, $con);
}

?>