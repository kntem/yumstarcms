<?php
include("dbConfig.php");

$obj = new genFunction(true);

$paramArray = $obj->getRestArray();


$private = mysql_query("select privacy from `users` where id=" . $paramArray['userID'] . "", $con) or die(mysql_error());


$privacy = mysql_query("select count(*) count from users u
              inner join users_friends_mappings ufm on ufm.friend_id=u.id
              where ufm.user_id=" . $paramArray['userID'] . " and ufm.friend_id=" . $paramArray['currentId'] . " and friend <> 0", $con) or die(mysql_error());


if ($paramArray['currentId'] != $paramArray['userID']) {

    if (mysql_num_rows($private) > 0) {

        while ($row = mysql_fetch_array($private)) {


            if ($row['privacy'] == 0) {

                ram(0);
            } else {
                if (mysql_num_rows($privacy) > 0) {
                    while ($row = mysql_fetch_array($privacy)) {
                        if ($row['count'] == 0) {

                            ram(0);//0
                        } else {

                            ram(0);
                        }
                    }


                } else {
                    ram(0);//0
                }
            }

        }
    }

} else {

    ram(0);
}

function ram($resu)
{

    global $paramArray;
    global $obj;
    global $con;
    if ($resu == 0) {


        $result = mysql_query("select u.id,u.fb_id,u.first_name,u.last_name,u.address,(select is_follow from `users_friends_mappings` um where um.user_id=" . $paramArray['currentId'] . " and um.friend_id=" . $paramArray['userID'] . ")as 'is_follow',(select count(*) from `users_friends_mappings` um
								inner join users u on (u.id=um.user_id)
								where friend_id=" . $paramArray['userID'] . " and is_follow=true) as 'totalFollowerCount', (select count(u.id) as 'totalFollowingCount' from `users_friends_mappings` um
								inner join users u on (u.id=um.friend_id)
								where user_id=" . $paramArray['userID'] . " and is_follow=true) as 'totalFollowingCount' from users u where u.id=" . $paramArray['userID'], $con) or die(mysql_error());


        if (mysql_num_rows($result) > 0) {

            while ($row = mysql_fetch_array($result)) {

                $row_array['friendID'] = $row['id'];
                $ro_Count = mysql_query("select COUNT(s.user_id) AS CountRecord FROM suggestions s where user_id=" . $row['id']);
                if (mysql_num_rows($ro_Count) > 0) {
                    while ($rows = mysql_fetch_array($ro_Count)) {
                        $row_array['user_suggested'] = $rows['CountRecord'];
                    }
                }

                $row_array['fbID'] = $row['fb_id'];
                $row_array['is_follow'] = $row['is_follow'];
                $row_array['first_name'] = $row['first_name'];
                $row_array['last_name'] = $row['last_name'];
                $row_array['address'] = $row['address'];
                $row_array['totalFollowingCount'] = $row['totalFollowingCount'];
                $row_array['totalFollowerCount'] = $row['totalFollowerCount'];
            }

            $arr['status'] = "true";
            $arr['code'] = "P026";
            $arr['msg'] = "data found";
        } else {

            $arr['status'] = "false";
            $arr['code'] = "P027";
            $arr['msg'] = "data not found";

        }


        $arr['Post'][0] = $row_array;
        echo json_encode($arr);


    } else {

        $arr['status'] = "false";
        $arr['code'] = "P027";
        $arr['msg'] = "data not found";

        $arr['Post'][0] = $row_array;
        echo json_encode($arr);

    }
}


//$result = mysql_query("select u.id,u.fb_id,u.first_name,u.last_name,u.address,(select 	count(*) from `users_friends_mappings` um
//								inner join users u on (u.id=um.user_id)
//								where friend_id=".$paramArray['userID']." and is_follow=true) as 'totalFollowerCount', (select count(u.id) as 'totalFollowingCount' from `users_friends_mappings` um
//								inner join users u on (u.id=um.friend_id)
//								where user_id=".$paramArray['userID']." and is_follow=true) as 'totalFollowingCount' from users u where u.id=".$paramArray['userID'],$con) or die(mysql_error());
//
//
// if(mysql_num_rows($result)>0)
// {
// 	while ($row = mysql_fetch_array($result)) {
//
//	 	$row_array['friendID'] = $row['id'];
//        $ro_Count=mysql_query("select COUNT(s.user_id) AS CountRecord FROM suggestions s where user_id=".$row['id']);
//        if(mysql_num_rows($ro_Count)>0) {
//            while ($rows = mysql_fetch_array($ro_Count)) {
//                $row_array['user_suggested']=$rows['CountRecord'];
//            }
//        }
//
//        $row_array['fbID'] = $row['fb_id'];
//		$row_array['first_name'] = $row['first_name'];
//		$row_array['last_name'] = $row['last_name'];
//		$row_array['address'] = $row['address'];
//		$row_array['totalFollowingCount'] = $row['totalFollowingCount'];
//		$row_array['totalFollowerCount'] = $row['totalFollowerCount'];
//    }
//
//         $arr['status']="true";
//         $arr['code']="P026";
//         $arr['msg']="data found";
//}
//else{
//		 $arr['status']="false";
//         $arr['code']="P027";
//         $arr['msg']="data not found";
//}


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