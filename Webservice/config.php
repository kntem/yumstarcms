<?php
/**
 * Updated by Bhargavi Kacha.
 * User: c107
 * Date: 03/20/15
 * Time: 10:41 AM
 * This is the config file for the web servcies access.
 */



date_default_timezone_set('UTC');
define("DATABASE_SERVER", "192.186.249.233");
define("DATABASE_USER", "Narola");
define("DATABASE_PASSWORD", "narola123");
define("DATABASE_NAME", "Foodorder");

$con = "";
$con = mysql_connect(DATABASE_SERVER, DATABASE_USER, DATABASE_PASSWORD);

mysql_set_charset('utf8', $con);

error_reporting(E_ERROR | E_PARSE);

if (!$con) 
{
    die('Database does not connect: ' . mysql_error());
}
else {
    mysql_select_db($dbname, $con);
}

function validateValue($value, $placeHolder) {

    $value = strlen($value) > 0 ? $value : $placeHolder;
    return $value;
}

function json_validate($string) {
    if (is_string($string)) {
        @json_decode($string);
        return (json_last_error() === JSON_ERROR_NONE);
    }
    return false;
}

function getDefultDate()
{
    return date("Y-m-d H:i:s");
}

function db_connect()  
{
   return $con;
}

// Closing database connection
function db_close() 
{
     mysql_close();
}

?>