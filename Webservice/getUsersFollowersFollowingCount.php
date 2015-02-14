<?php
include ("dbConfig.php");
$obj = new genFunction(true);
$paramArray=$obj->getRestArray();
					
$result = mysql_query("select u.id,u.fb_id,u.first_name,u.last_name,u.address,(select 			    			count(*) from `users_friends_mappings` um
								inner join users u on (u.id=um.user_id)
								where friend_id=".$paramArray['userID']." and is_follow=true) as 'totalFollowerCount', (select count(u.id) as 'totalFollowingCount' from `users_friends_mappings` um
								inner join users u on (u.id=um.friend_id)
								where user_id=".$paramArray['userID']." and is_follow=true) as 'totalFollowingCount' from users u where u.id=".$paramArray['userID'],$con) or die(mysql_error()); 


 if(mysql_num_rows($result)>0)
 {
 	while ($row = mysql_fetch_array($result)) {

	 	$row_array['friendID'] = $row['id'];
        $row_array['fbID'] = $row['fb_id'];
		$row_array['first_name'] = $row['first_name'];
		$row_array['last_name'] = $row['last_name'];
		$row_array['address'] = $row['address'];
		$row_array['totalFollowingCount'] = $row['totalFollowingCount'];
		$row_array['totalFollowerCount'] = $row['totalFollowerCount'];
    }

         $arr['status']="true";
         $arr['code']="P026";
         $arr['msg']="data found";
}
else{
		 $arr['status']="false";
         $arr['code']="P027";
         $arr['msg']="data not found";
}
		
        $arr['Post'][0]=$row_array;
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