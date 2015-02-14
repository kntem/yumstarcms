<?php
include ("dbConfig.php");

$Limit="";
$obj = new genFunction(true);
$obj->getPagination();
$paramArray=$obj->getRestArray();
$return_arr = array();
$arr=array();
$defaultRecordLimit=10;
$userID=$paramArray['userID'];
$flag=$paramArray['flag']; //1 or 0. 1= users suggestion, 0 all suggestion
$getAllRecord=$paramArray['getAllRecord']; //if isset get all record
$userWhereCondition="";
$userWhereConditionAnd="";
if($flag == "1")
{
	$userWhereCondition =" where sug.`user_id`= ".$userID;
	$userWhereConditionAnd = " and sug.`user_id`= ".$userID;
}
$limitPart=" limit ".$paramArray['Limit1'].", ".$defaultRecordLimit;
if(isset($getAllRecord)){
	if($getAllRecord == "true"){
		$limitPart="";
	}
}
/*
$totalRows=mysql_query("select count(*) as 'totalCount' from (select max(sug.id),sug.suggested_image,suggested_comment,u.fb_id,
						ri.name as restName,i.name as itemName,u.username,u.first_name,u.last_name
						from suggestions sug
						inner join items i on (i.id=sug.item_id)
						inner join restaurants ri on (ri.id=i.rest_id)
						inner join users u on (u.id=sug.user_id)
						".$userWhereCondition."
						group by sug.item_id,sug.`user_id`
						order by post_time asc)ds") or die(mysql_error());
*/

$totalRows=mysql_query("select count(*) as 'totalCount' from (select sug.suggested_image,suggested_comment,u.fb_id,
						ri.name as restName,i.name as itemName,u.username,u.first_name,u.last_name
						from suggestions sug
						inner join items i on (i.id=sug.item_id)
						inner join restaurants ri on (ri.id=i.rest_id)
						inner join users u on (u.id=sug.user_id)
						".$userWhereCondition."
						
						order by post_time asc)ds") or die(mysql_error());



$items = mysql_query("select sug.id as 'suggestionID',i.name as itemName,i.id as itemID, re.`name`as 'resturantName',
				sug.suggested_image,sug.suggested_comment,u.username,u.first_name,u.last_name,u.fb_id,u.id as userID,
					
					ifnull(dd.is_Like,0) as 'is_LikeByLoginUser',
					ifnull(ddd.totalComments,0) as 'totalComments',
					sug.is_abused as is_markedAsAbused,d.totalSuggestion,ifnull(dd1.totalLikes,0) as 'totalLikes',
					second(Sec_to_time(Timestampdiff (second, now(), sug.post_time))) as sec,
					minute(Sec_to_time(Timestampdiff (second, now(), sug.post_time))) as min
					,HOUR(Sec_to_time(Timestampdiff (second, now(), sug.post_time))) as hours
					,datediff(now(),sug.post_time) as days
					,floor(datediff(now(),sug.post_time) / 365) as years from suggestions sug
					
					inner join items i on (i.`id` = sug.`item_id`)
					inner join users u on (u.`id` = sug.`user_id`)
					inner join restaurants re on (i.`rest_id` = re.`id`)
					
					left join (select sug.item_id,count(sug.user_id) as 'totalSuggestion'
					from suggestions 	
								sug group by item_id ) d on (i.id=d.item_id)
					
					
					left join (select is_Like,`suggestion_id` from likes where  user_id=".$userID."
					) dd on sug.id=dd.suggestion_id 
					
					
					left join (select suggestion_id,count(*) as 'totalLikes' from likes 
					where is_like=1 group by suggestion_id
					) dd1 on sug.id=dd1.suggestion_id
					
					left join (select count(*) as 'totalComments',suggestion_id from comments 
					group by suggestion_id
					) ddd on sug.id=ddd.suggestion_id 
					". $userWhereCondition ."
					group by sug.id
					order by SUG.post_time asc $limitPart " ,$con) or die(mysql_error());


 if(mysql_num_rows($items)>0)
 {
 	while ($row = mysql_fetch_array($items)) {
		$row_array['suggestionID'] = $row['suggestionID'];
	 	$row_array['itemID'] = $row['itemID'];
        $row_array['itemName'] = $row['itemName'];
		$row_array['resturantName'] = $row['resturantName'];
		$row_array['suggested_image'] = $row['suggested_image'];
		$row_array['suggested_comment'] = $row['suggested_comment'];
		$row_array['suggestionCount'] = $row['totalSuggestion'];
		$row_array['username'] = $row['username'];
		$row_array['first_name'] = $row['first_name'];
		$row_array['last_name'] = $row['last_name'];
		$row_array['userID'] = $row['userID'];
		$row_array['fb_id'] = $row['fb_id'];
		$row_array['is_LikeByLoginUser'] = $row['is_LikeByLoginUser'];
		$row_array['is_markAsAbsued'] = $row['is_markedAsAbused'];
		$row_array['totalCommentCount'] = $row['totalComments'];
		$row_array['totalLikes'] = $row['totalLikes'];
		
		
		if($row['years'] == 0){
        	 $row_array['time_ago']=$row['days'] . " day";
   	         if($row['days'] == 0){
   	         	$row_array['time_ago']=$row['hours'] . " hrs";
   	         	if($row['hours'] == 0){
   	         		$row_array['time_ago']=$row['min'] . " min";
   	         	}
   	         	if($row['min'] == 0){
   	         		$row_array['time_ago']=$row['sec'] . " sec";
   	         	}
   	         }
        }
        else{
        	$row_array['time_ago']=$row['years'] . " yr";
        }
		
        array_push($return_arr,$row_array);
   
        }
         $arr['status']="true";
         $arr['code']="P009";
         $arr['msg']="suggestion data found";
}
else{
		 $arr['status']="false";
         $arr['code']="P010";
         $arr['msg']="suggestion data not found";
}
		$totalRows1="";
		while($row3 = mysql_fetch_array($totalRows)){
			$totalRows1=$row3['totalCount'];
		}
        $arr['Post'][0]=$totalRows1;
        $arr['Post'][1]=$return_arr;
        echo json_encode($arr);
?>


<?php
class genFunction{
	private $getRestAPI=array();
	private $defaultRecordLimit=10;
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



<?php
/*include ("dbConfig.php");

$Limit="";
$obj = new genFunction(true);
$obj->getPagination();
$paramArray=$obj->getRestArray();
$return_arr = array();
$arr=array();
$defaultRecordLimit=10;
$userID=$paramArray['userID'];
$flag=$paramArray['flag']; //1 or 0. 1= users suggestion, 0 all suggestion
$userWhereCondition="";
$userWhereConditionAnd="";
if($flag == "1")
{
	$userWhereCondition =" where sug.`user_id`= ".$userID;
	$userWhereConditionAnd = " and sug.`user_id`= ".$userID;
}

$totalRows=mysql_query("select count(*) as 'totalCount' from (select max(sug.id),sug.suggested_image,suggested_comment,u.fb_id,
						ri.name,i.name as itemName
						from suggestions sug
						inner join items i on (i.id=sug.item_id)
						inner join rest_item_mappings re on (i.id = re.item_id)
						inner join restaurants ri on (ri.id=re.rest_id)
						inner join users u on (u.id=sug.user_id)
						" .$userWhereCondition. "
						group by sug.id
						order by post_time desc)ds");



$items = mysql_query("select distinct(i.name) as name,i.id as itemID,i.`description`, re.`name`as 'resturantName',
					re.id as 'resturantID',ifnull(dd.is_Like,0) as 'is_LikeByLoginUser',
					ifnull(ddd.totalComments,0) as 'totalComments',
					ri.`is_markedAsAbused`,d.totalSuggestion,
					d1.min,d1.hours,d1.days,d1.years from suggestions sug
					inner join items i on (i.`id` = sug.`item_id`)
					inner join users u on (u.`id` = sug.`user_id`)
					left join (select sug.item_id,count(sug.user_id) as 'totalSuggestion'
					from suggestions 	
								sug group by item_id ) d on (i.id=d.item_id)
					inner join rest_item_mappings ri on (ri.`item_id` = i.`id`)
					inner join restaurants re on (ri.`rest_id` = re.`id`) 
					
					left join (select is_Like,item_id from likes where  user_id=".$userID."
					) dd on i.id=dd.item_id 
					
					left join (select max(id),item_id,
						minute(Sec_to_time(Avg (Timestampdiff (second, now(), c.post_time)))) as min,
						HOUR(Sec_to_time(Avg (Timestampdiff (second, now(), c.post_time)))) as hours,
						datediff(now(),c.post_time) as days,
						floor(datediff(now(),c.post_time) / 365) as years
						from suggestions  c group by item_id
					) d1 on i.id=d1.item_id
					
					left join (select count(*) as 'totalComments',item_id from comments where is_like=1 
					group by item_id
					) ddd on i.id=ddd.item_id  " .$userWhereCondition 
					." limit ".$paramArray['Limit1'].", ".$defaultRecordLimit,$con) or die(mysql_error()); 
 
 if(mysql_num_rows($items)>0)
 {
 	while ($row = mysql_fetch_array($items)) {
	 	$row_array['itemId'] = $row['itemID'];
        $row_array['itemName'] = $row['name'];
		$row_array['itemDescription'] = $row['description'];
		$row_array['resturantName'] = $row['resturantName'];
		$row_array['resturantID'] = $row['resturantID'];		
		$row_array['suggestionCount'] = $row['totalSuggestion'];
		$row_array['is_LikeByLoginUser'] = $row['is_LikeByLoginUser'];
		$row_array['is_markAsAbsued'] = $row['is_markedAsAbused'];
		$row_array['totalCommentCount'] = $row['totalComments'];
		
		
		if($row['years'] == 0){
        	 $row_array['time_ago']=$row['days'] . " days ago";
   	         if($row['days'] == 0){
   	         	$row_array['time_ago']=$row['hours'] . " hours ago";
   	         	if($row['hours'] == 0){
   	         		$row_array['time_ago']=$row['min'] . " min ago";
   	         	}
   	         	if($row['min'] == 0){
   	         		$row_array['time_ago']="Just now";
   	         	}
   	         }
        }
        else{
        	$row_array['time_ago']=$row['years'] . " years ago";
        }
		
		
		if($flag == "0"){
                $peoples=mysql_query("select u.`first_name`,u.fb_id as 'profile_photo',u.id as 'userIDs' from suggestions sug
					inner join users u on (u.id = sug.user_id)
					WHERE sug.`item_id`=".$row['itemID'] ." order by u.id desc limit 5");
					
                $subArray=array(); 
                $i=0;
                while ($row1 = mysql_fetch_array($peoples)) 
                {
                       // $subArray[$i]['first_name'] = $row1['first_name'];
                        //$subArray[$i]['profile_photo'] = $row1['profile_photo'];
						//$subArray[$i]['userID'] = $row1['userIDs'];
						$subArray[$i] = $row1['profile_photo'];
                        $i++;
                }
                $row_array['Peoples']=$subArray;
                
        }
                
                 $images=mysql_query("select sug.`suggested_image` from suggestions sug 
							inner join users u on (u.id=sug.`user_id`)
							where sug.item_id=".$row['itemID'] . $userWhereConditionAnd . " order by sug.id desc ");
					
                $subArray=array(); 
                $i=0;
                while ($row2 = mysql_fetch_array($images)) 
                {
	                if($flag == "0"){
		                $subArray[$i] = $row2['suggested_image'];
                        //$subArray[$i]['suggested_image'] = $row2['suggested_image'];
                    }
                    else{
	                    $row_array['suggested_image'] = $row2['suggested_image'];
                    	//$row_array['suggested_image'] = $row2['suggested_image'];
                    }
                        $i++;
                }
                
                if($flag == "0"){
                	$row_array['images']=$subArray;
                }
                array_push($return_arr,$row_array);
                
                
                
        }
         $arr['status']="true";
         $arr['code']="P009";
         $arr['msg']="suggestion data found";
}
else{
		 $arr['status']="false";
         $arr['code']="P010";
         $arr['msg']="suggestion data not found";
}
		$totalRows1="";
		while($row3 = mysql_fetch_array($totalRows)){
			$totalRows1=$row3['totalCount'];
		}
        $arr['Post'][0]=$totalRows1;
        $arr['Post'][1]=$return_arr;
        echo json_encode($arr);
        */
?>


<?php
/*class genFunction{
	private $getRestAPI=array();
	private $defaultRecordLimit=10;
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
*/
?>