<?php

/**
 * Created by JetBrains PhpStorm.
 * User: bp
 * Date: 04/12/14
 * Time: 2:54 PM
 * To change this template use File | Settings | File Templates.
 *
 *  * Param :: suggestionId , userId
 */

include ("dbConfig.php");

$Limit="";
$obj = new genFunction(true);
$paramArray=$obj->getRestArray();
$return_arr = array();

$likeQuery = mysql_query("select * from like_suugestion_mappings where 
suggestion_id=".$paramArray['suggestionId']." AND user_id=".$paramArray['userId'],$con) or die(mysql_error());

if(mysql_num_rows($likeQuery)>0)
{
    $isLike=1;

    while ($row = mysql_fetch_assoc($likeQuery))
    {
        $isLike = $row['is_like'];
        if($isLike==1)
        {
            $isLike=0;
        }
        else if($isLike==0)
        {
            $isLike=1;
        }
    }

    mysql_query("update like_suugestion_mappings set is_like=".$isLike." where suggestion_id=".$paramArray['suggestionId']." AND user_id=".$paramArray['userId'],$con)or die(mysql_error());
    $arr['status']="true";
    $arr['code']="P031";
    $arr['msg']="Liked updated .";
}
else{

    mysql_query("INSERT INTO like_suugestion_mappings(`user_id`, `suggestion_id`, `is_like`)
    VALUES(".$paramArray['userId'].",'".$paramArray['suggestionId']."',1)",$con) or die(mysql_error());

    $arr['status']="true";
    $arr['code']="P032";
    $arr['msg']="Liked successfully .";

}

$arr['Post']=$return_arr;
echo json_encode($arr);
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






