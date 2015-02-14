<?php
/**
 * Created by JetBrains PhpStorm.
 * User: bp
 * Date: 04/12/14
 * Time: 2:29 PM
 * To change this template use File | Settings | File Templates.
 *
 *
 * Param :: suggestionId
 */

include ("dbConfig.php");

$Limit="";
$obj = new genFunction(true);
$obj->getPagination();
$paramArray=$obj->getRestArray();
$return_arr = array();
$defaultRecordLimit=10;
$totalRows=mysql_query("select count(a.comment) as 'totalCommentCount' from 
(select c.comment as 'comment' from comments c inner join users u on (u.id=c.comment_by) where 
c.suggestion_id=".$paramArray['suggestion_id']." group by c.id order by c.id desc)a") or die(mysql_error());

$commentList = mysql_query("select c.comment,u.first_name,
							second(Sec_to_time(Avg (Timestampdiff (second, now(), c.post_time)))) as sec,
							minute(Sec_to_time(Avg (Timestampdiff (second, now(), c.post_time)))) as min,
							HOUR(Sec_to_time(Avg (Timestampdiff (second, now(), c.post_time)))) as hours,
							datediff(now(),c.post_time) as days,
							floor(datediff(now(),c.post_time) / 365) as years
							from comments c
							inner join users u on (u.id=c.comment_by)
							where c.suggestion_id=".$paramArray['suggestion_id']."
							group by c.id order by c.id asc "." limit ".$paramArray['Limit1']. ", ".$defaultRecordLimit
							,$con) or die(mysql_error());



if(mysql_num_rows($commentList)>0)
{
    $subArray=array();
	$j=0;
    while ($row1 = mysql_fetch_array($commentList)) {
        $subArray[$j]['comment'] = $row1['comment'];
        $subArray[$j]['first_name'] = $row1['first_name'];	
        
        if($row1['years'] == 0){
        	 $subArray[$j]['time_ago']=$row1['days'] . " day";
   	         if($row1['days'] == 0){
   	         	$subArray[$j]['time_ago']=$row1['hours'] . " hrs";
   	         	if($row1['hours'] == 0){
   	         		$subArray[$j]['time_ago']=$row1['min'] . " min";
   	         	}
   	         	if($row1['min'] == 0){
   	         		$subArray[$j]['time_ago']=$row1['sec'] . " sec";
   	         	}
   	         }
        }
        else{
        	$subArray[$j]['time_ago']=$row1['years'] . " yr";
        }
       
        $j++;
    }
    $arr['status']="true";
    $arr['code']="P024";
    $arr['msg']="comments found";
    
    $totalRows1="";
		while($row3 = mysql_fetch_array($totalRows)){
			$totalRows1=$row3['totalCommentCount'];
		}
    $arr['Post'][0]=$totalRows1;
    $arr['Post'][1]=$subArray;
}
else{
    $arr['status']="false";
    $arr['code']="P025";
    $arr['msg']="comments not found";
}

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
    
    public function getPagination()
		{
			$limit=$this->getRestAPI['Limit'];
			if ($limit == 0){
			}
			else{
				$limit+=$defaultRecordLimit;
			}
			$this->getRestAPI['Limit1']= $limit;
		}
    
    public function getRestArray(){
        return $this->getRestAPI;
    }
}
?>









