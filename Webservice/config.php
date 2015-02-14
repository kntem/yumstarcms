<?php
/**
 * Created by JetBrains PhpStorm.
 * User: c33
 * Date: 03/09/14
 * Time: 4:12 PM
 * To change this template use File | Settings | File Templates.
 */


date_default_timezone_set('UTC');
define("DATABASE_SERVER", "192.168.1.201");
define("DATABASE_USER", "FoodOrder");
define("DATABASE_PASSWORD", "P6z8BD35ZCMQ79F");
define("DATABASE_NAME", "FoodOrder");
$server = "192.168.1.201";
$user = "FoodOrder";
$password = "P6z8BD35ZCMQ79F";

$dbname = 'FoodOrder';
$con = "";
$con = mysql_connect($server, $user, $password);

mysql_set_charset('utf8', $con);

error_reporting(E_ERROR | E_PARSE);

if (!$con) {
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