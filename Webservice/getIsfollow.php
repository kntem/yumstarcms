<?php
include("dbConfig.php");
$obj = new genFunction(true);

$paramArray = $obj->getRestArray();




$isfollow = mysql_query("select is_follow from `users_friends_mappings` um where um.user_id=" . $paramArray['currentId'] . " and um.friend_id=" . $paramArray['userID'], $con) or die(mysql_error());
if (mysql_num_rows($isfollow) > 0) {
    while ($row = mysql_fetch_array($isfollow)) {

        $row_array['is_follow'] = $row['is_follow'];
    }
    $arr['status'] = "true";
    $arr['code'] = "P026";
    $arr['msg'] = "data found";
    $arr['Post'][0] = $row_array;
    echo json_encode($arr);
} else {
    $arr['status'] = "false";
    $arr['code'] = "P027";
    $arr['msg'] = "data not found";

    $arr['Post'][0] = $row_array;
    echo json_encode($arr);
}
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