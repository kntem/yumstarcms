<?php
include("dbConfig.php");
$obj = new genFunction(true);
$paramArray = $obj->getRestArray();
$return_arr = array();

mysql_query("update users set privacy=" . $paramArray['privacy'] . " where id=" . $paramArray['userID'], $con) or die(mysql_error());

$return_arr['status'] = "true";
$return_arr['code'] = "P011";
$return_arr['msg'] = "privacy updated.";
$return_arr['Post'] = array();
echo json_encode($return_arr);
?>

<?php

class genFunction
{
    private $getRestAPI = array();

    function __construct($Method = false) // $Method must be true if using post
    {
        if ($Method === false) {

            if (isset($_GET) && is_array($_GET)) {
                foreach ($_GET as $key => $val) {
                    $this->getRestAPI[$key] = $val;
                }
            }
        } else {
            if (isset($_POST) && is_array($_POST)) {
                foreach ($_POST as $key => $val) {
                    $this->getRestAPI[$key] = $val;
                }
            }
        }
    }

    public function getRestArray()
    {
        return $this->getRestAPI;
    }
}

?>