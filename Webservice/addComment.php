<?php
include("dbConfig.php");
include("GCM.php");
$obj = new genFunction(true);
$paramArray = $obj->getRestArray();
$return_arr = array();
$curDate = getDefaultDate();
mysql_query("INSERT INTO comments(`comment`, `comment_by`,`suggestion_id`,`post_time`)
 VALUES('" . $paramArray['comment'] . "'," . $paramArray['comment_by'] . ",'" . $paramArray['suggestion_id'] . "', '" . $curDate . "')", $con) or die(mysql_error());

$return_arr['status'] = "true";
$return_arr['code'] = "P022";
$return_arr['msg'] = "comment successfully added.";

$row_array = array();

$return_arr['Post'] = $row_array;


$res = mysql_query("select u.deviceid from suggestions sug
	 			inner join users u on (u.id=sug.user_id)
			 where sug.id=" . $paramArray['suggestion_id'], $con) or die(mysql_error());


$res = mysql_query("select u.deviceid,ua.`username` as commentd_username,i.name from suggestions sug
	 			inner join users u on (u.id=sug.user_id)
	 			left join users ua on (ua.id=" . $paramArray['comment_by'] . ")
	 			inner join items i on (i.id=sug.item_id)
			 where sug.id=" . $paramArray['suggestion_id'] . " and u.deviceid <> '" . $paramArray['deviceid'] . "' limit 1", $con) or die(mysql_error());

$regId = "";
$$userName = "";
$itemName = "";
while ($row = mysql_fetch_array($res)) {

    $regId = $row['deviceid'];

    $userName = $row['commentd_username'];
    $itemName = $row['name'];
}


/*$post = getSuggetedUserId($paramArray['item_id']);
$postSender = getUser($post['user_id']);
$regId =  $postSender['deviceid'];
*/

/*$postComented = getUser($paramArray['comment_by']);
$userName = $postComented['username'];
*/


$msg = $userName . " commented: " . $paramArray['comment'] . " on your post: " . $itemName; //acccept

$gcmData["key"] = "comment";
$gcmData["message"] = $msg;


echo json_encode($return_arr);
//if($paramArray['Current_User']==1){

$squery =mysql_query("select u.deviceid from users_friends_mappings ufm
inner join suggestions sug on sug.user_id=ufm.friend_id
inner join users u on u.id=sug.user_id
where ufm.user_id=". $paramArray['Current_User'] ." and ufm.is_follow = 1 
group by sug.user_id", $con) or die(mysql_error());
 
while ($row = mysql_fetch_array($squery)) {

    $regId = $row['deviceid'];
  
	sendNotification($regId, $gcmData);
}



//}


/*function getSuggetedUserId($itemId)
{
     $queryToUser = "Select * from items where id = '".$itemId."'";
    $resToUser = mysql_query($queryToUser) or $errorMsg =  mysql_error();

    if (mysql_num_rows($resToUser)) {
        while ($post = mysql_fetch_assoc($resToUser)) {
            return $post;
        }
    }

}

function getUser($userId)
{
    $queryToUser = "Select * from users where id = '".$userId."'";
    $resToUser = mysql_query($queryToUser) or $errorMsg =  mysql_error();

    if (mysql_num_rows($resToUser)) {
        while ($post = mysql_fetch_assoc($resToUser)) {
            return $post;
        }
    }

}*/


function sendNotification($regId, $msg)
{


    $gcm = new GCM();

    $registatoin_ids[] = $regId;

    $message = array("message" => $msg);

    $gcm->send_notification($registatoin_ids, $message);
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