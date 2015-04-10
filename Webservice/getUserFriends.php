<?php
include("dbConfig.php");

$Limit = "";
$obj = new genFunction(true);
$obj->getPagination();
$paramArray = $obj->getRestArray();
$return_arr = array();
$arr = array();
$defaultRecordLimit = 10;

$totalRows = mysql_query("select count(u.id) as 'totalCount' from `users_friends_mappings` um
					inner join users u on (u.id=um.`friend_id`)
					where user_id=" . $paramArray['userID']);

$usersFriend = mysql_query("select u.*,um.`is_follow` from `users_friends_mappings` um
					inner join users u on (u.id=um.`friend_id`)
					where user_id=" . $paramArray['userID'] . " order by id asc limit " . $paramArray['Limit1'] . ", " . $defaultRecordLimit, $con) or die(mysql_error());


if (mysql_num_rows($usersFriend) > 0) {
    while ($row = mysql_fetch_array($usersFriend)) {

        $row_array['friendID'] = $row['id'];
        $ro_Count = mysql_query("select COUNT(s.user_id) AS CountRecord FROM suggestions s where user_id=" . $row['id']);
        if (mysql_num_rows($ro_Count) > 0) {
            while ($rows = mysql_fetch_array($ro_Count)) {
                $row_array['user_suggested'] = $rows['CountRecord'];
            }
        }
        $row_array['fbID'] = $row['fb_id'];
        $row_array['first_name'] = $row['first_name'];
        $row_array['last_name'] = $row['last_name'];
        $row_array['is_follow'] = $row['is_follow'];
        $row_array['address'] = $row['address'];


        $totalFollowingCount = mysql_query("select count(u.id) as 'totalFollowingCount' from `users_friends_mappings` um
								inner join users u on (u.id=um.friend_id)
								where user_id=" . $row['id'] . " and is_follow=true");
        $totalFollowing = "";
        while ($row3 = mysql_fetch_array($totalFollowingCount)) {
            $totalFollowing = $row3['totalFollowingCount'];
        }

        $totalFollowersCount = mysql_query("select count(u.id) as 'totalFollowerCount' from `users_friends_mappings` um
								inner join users u on (u.id=um.user_id)
								where friend_id=" . $row['id'] . " and is_follow=true");


        $totalFollower = "";
        while ($row3 = mysql_fetch_array($totalFollowersCount)) {
            $totalFollower = $row3['totalFollowerCount'];
        }


        $row_array['totalFollowingCount'] = $totalFollowing;
        $row_array['totalFollowerCount'] = $totalFollower;

        array_push($return_arr, $row_array);
    }

    $arr['status'] = "true";
    $arr['code'] = "P013";
    $arr['msg'] = "friend list found";
} else {
    $arr['status'] = "false";
    $arr['code'] = "P014";
    $arr['msg'] = "no friend found";
}
$totalRows1 = "";
while ($row3 = mysql_fetch_array($totalRows)) {
    $totalRows1 = $row3['totalCount'];
}

$arr['Post'][0] = $totalRows1;
$arr['Post'][1] = $return_arr;
echo json_encode($arr);
?>


<?php

class genFunction
{
    private $getRestAPI = array();
    private $defaultRecordLimit = 10;

    public function getPagination()
    {
        $limit = $this->getRestAPI['Limit'];
        if ($limit == 0) {
        } else {
            $limit += $defaultRecordLimit;
        }
        $this->getRestAPI['Limit1'] = $limit;
    }

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