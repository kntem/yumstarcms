<?php
/**
 * Created by ka
 * User: c86
 * Date: 21/03/14
 * Time: 09:04 AM
 */

include_once 'config.php';

$post_body = file_get_contents('php://input');
$post_body = iconv('UTF-8', 'UTF-8//IGNORE', utf8_encode($post_body));
$reqData[] = json_decode($post_body);
$userData=$reqData[0];

if($_REQUEST['Service'] == "getcategory")
{
    include 'userFunctions.php';
    $data = registerUser($userData);
}

header('Content-type: application/json');
echo json_encode($data);
mysql_close($con);


?>