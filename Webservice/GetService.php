<?php
/**
 * Created by ka
 * User: c86
 * Date: 21/03/14
 * Time: 09:04 AM
 */

include_once 'config.php';
include 'userFunctions.php';

$post_body = file_get_contents('php://input');
$post_body = iconv('UTF-8', 'UTF-8//IGNORE', utf8_encode($post_body));
$reqData[] = json_decode($post_body);
$userData=$reqData[0];

if($_REQUEST['Service'] == "getcategory")
{   
    $data = getCategory();
}

else if($_REQUEST['Service'] == "getRegister")
{
	$userData = array();
	echo $_REQUEST['fb_id'];
	$userData['fb_id']=$_REQUEST['fb_id'];
	$userData['email_id']=$_REQUEST['email_id'];
    $userData['FirstName']=$_REQUEST['FirstName'];
    $userData['LastName']=$_REQUEST['LastName'];
    $userData['phone_no']=$_REQUEST['phone_no'];
    $userData['profile_photo']=$_REQUEST['profile_photo'];
    $userData['created_time']=$_REQUEST['created_time'];
    $userData['modification_time']=$_REQUEST[modification_time];
    $userData['deviceid']=$_REQUEST['deviceid'];
    $userData['Visibility']=$_REQUEST['Visibility'];
    $userData['Followers']=$_REQUEST['Followers'];
    $userData['Followins']=$_REQUEST['Followins'];
    $userData['TotalFeeds']=$_REQUEST['TotalFeeds'];
    $data = registerUser($userData);
}

/////////////////////////////////////////////////////////////////////////////////

header('Content-type: application/json');
echo json_encode($data);
mysql_close($con);

/////////////////////////////////////////////////////////////////////////////////

?>