<?php
include("dbConfig.php");
include("GCM.php");
$obj = new genFunction(true);
$paramArray=$obj->getRestArray();
$return_arr = array();
	
mysql_query("update users_friends_mappings set is_follow=".$paramArray['isFollow']." 
			where user_id=".$paramArray['userID']." and friend_id=".$paramArray['friendID'],$con) or die(mysql_error());
	$return_arr['status']="true";
	$return_arr['code']="P015";
	$return_arr['msg']="users follow status updated.";
 	$return_arr['Post']=array();

    $post = getUser($paramArray['userID']);
    $post1 = getUser($paramArray['friendID']);
    $userName = $post['username'];
    $regId = $post1['deviceid'];


    $msg = $userName. " started following you."; //acccept

    $gcmData["key"] = "follow";
    $gcmData["message"] = $msg;
if($paramArray['Current_User']==1 && $paramArray['isFollow']==1) {
    sendNotification($regId, $gcmData);
}

 	echo json_encode($return_arr);



function getUser($userId)
{
    $queryToUser = "Select * from users where id = '".$userId."'";
    $resToUser = mysql_query($queryToUser) or $errorMsg =  mysql_error();

    if (mysql_num_rows($resToUser)) {
        while ($post = mysql_fetch_assoc($resToUser)) {
            return $post;
        }
    }

}


function sendNotification($regId,$msg)
{
    $gcm = new GCM();

    $registatoin_ids = array($regId);
    $message = array("message" => $msg);

    $gcm->send_notification($registatoin_ids, $message);
}



?>

<?php
class genFunction{
	private $getRestAPI=array();
		function __construct($Method = false) // $Method must be true if using post
        {
			if ($Method === false)
            {
				if (isset($_GET) && is_array($_GET))
                {
					foreach ($_GET as $key => $val)
                    {
						$this->getRestAPI[$key] = $val;
					}
				}
			}
			else
            {
				if (isset($_POST) && is_array($_POST))
                {
					foreach ($_POST as $key => $val)
                    {
						$this->getRestAPI[$key] = $val;
					}
				}
			}
		}
		public function getRestArray(){
			return $this->getRestAPI;
		}
}
?>