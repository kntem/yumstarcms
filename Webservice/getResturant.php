<?php

include("dbConfig.php");

$Limit = "";
$obj = new genFunction(true);
$paramArray = $obj->getRestArray();
$return_arr = array();

$restaurantList = mysql_query("select * from restaurants where id=" . $paramArray['resturantID'], $con) or die(mysql_error());

if (mysql_num_rows($restaurantList) > 0) {
    while ($row = mysql_fetch_assoc($restaurantList)) {
        $return_arr[] = $row;
    }
    $arr['status'] = "true";
    $arr['code'] = "P020";
    $arr['msg'] = "resturant found";
} else {
    $arr['status'] = "false";
    $arr['code'] = "P021";
    $arr['msg'] = "resturant not found";
}

$arr['Post'] = $return_arr;
echo json_encode($arr);
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



