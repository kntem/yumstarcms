<?php
include("dbConfig.php");

$Page = "";
$Limit = "";
$obj = new genFunction(true);
$obj->getPagination();
$paramArray = $obj->getRestArray();
$return_arr = array();
$arr = array();
$defaultRecordLimit = 10;
$totalRows = mysql_query("select distinct(c1.`name`) as name,c1.id from items i
						inner join categories c on (c.`id` = i.`category_id`)
						left join categories c1 on (c.`parent_id` = c1.`id`)
						where i.`rest_id`=" . $paramArray['resturantID']);

$category_Result = mysql_query("select distinct(c1.`name`) as name,c1.id,ifnull(c.icon,'') as icon from items i
						inner join categories c on (c.`id` = i.`category_id`)
						left join categories c1 on (c.`parent_id` = c1.`id`)
						where i.`rest_id`=" . $paramArray['resturantID'] . " limit " . $paramArray['Limit1'] . ", " . $defaultRecordLimit, $con) or die(mysql_error());


/*left join (select count(lik.id) as 'totalLikes',lik.item_id from likes lik
							where rest_id=".$paramArray['resturantID']." )l on (i.id=l.item_id)*/
/*ifnull(l.totalLikes,0) as 'totalLikes',*/

if (mysql_num_rows($category_Result) > 0) {
    while ($row = mysql_fetch_array($category_Result)) {
        $row_array['categoryId'] = $row['id'];
        $row_array['categoryName'] = $row['name'];
        $row_array['icon'] = $row['icon'];
        $sub_category_Result = mysql_query("select distinct(c.name) as subName,c.id,ifnull(c.icon,'') as icon from items i
						inner join categories c on (c.`id` = i.`category_id`)
						left join categories c1 on (c.`parent_id` = c1.`id`)
						where i.`rest_id`=" . $paramArray['resturantID'] . " and c1.id=" . $row['id']);

        $subArray = array();
        $i = 0;
        while ($row1 = mysql_fetch_array($sub_category_Result)) {

            $subArray[$i]['SubCategoryId'] = $row1['id'];
            $subArray[$i]['SubCategoryName'] = $row1['subName'];
            $subArray[$i]['icon'] = $row1['icon'];

            $sub_category_item_Result = mysql_query("select i.id as itemID,i.name, i.description,
                        i.price,ifnull(d.totalSuggestion,0) as 'totalSuggestion',
                        i.`is_markedasabused` as is_markedAsAbused,ifnull(l.totalLikes,0) as 'totalLikes' from items i
						inner join categories c on (c.`id` = i.`category_id`)
						left join categories c1 on (c.`parent_id` = c1.`id`)
						left join (select sug.item_id,count(sug.user_id) as 'totalSuggestion' from suggestions
								sug group by item_id ) d on (i.id=d.item_id)
		
						left join (select sug.item_id,count(*) as 'totalLikes' from suggestions sug 
									inner join likes l on (l.suggestion_id = sug.id)
									where l.is_like=1
									group by sug.item_id)l on (i.id=l.item_id)	

						where i.`rest_id`=" . $paramArray['resturantID'] .
                " and DATE(NOW()) not between i.start_date and i.end_date and i.`category_id`=" . $row1['id']);

            $j = 0;
            while ($row2 = mysql_fetch_array($sub_category_item_Result)) {
                $subItemArray['itemID'] = $row2['itemID'];
                $subItemArray['itemName'] = $row2['name'];
                $subItemArray['description'] = $row2['description'];
                $subItemArray['price'] = $row2['price'];
                $subItemArray['suggestionCount'] = $row2['totalSuggestion'];
                $subItemArray['totalLikes'] = $row2['totalLikes'];

                $queryItemChoice = mysql_query("select id,choice_name,price from item_choices where item_id =" . $row2['itemID'] . "");


                $choice_array = array();

                if (mysql_num_rows($queryItemChoice) > 0) {

                    while ($row_ch = mysql_fetch_array($queryItemChoice)) {

                        $arr['choice_id'] = $row_ch['id'];
                        $arr['choice_name'] = $row_ch['choice_name'];
                        $arr['price'] = $row_ch['price'];


                        $choice_array[] = $arr;

                    }


                }

                $subItemArray['item_choice'] = $choice_array;
                // $subArray[$i]['item'][$j] = ;


                $suggestedPeople = mysql_query("select u.`first_name`,u.`fb_id` as profile_photo,
                                u.id as 'userIDs',sug.`suggested_image`,ifnull(x.totalLikes,0) as 'TotalLikesOfImage',
                                sug.id as 'suggestionID',ifnull(dx.is_like,'0') as isLikedByLoginUser from suggestions sug
											inner join users u on (u.id = sug.user_id)
											left join (select count(*) as 'totalLikes',suggestion_id from likes group by suggestion_id)x on x.suggestion_id=sug.id
											left join (select is_like,suggestion_id from likes where
											user_id=" . $paramArray['userID'] . ") dx
											on dx.suggestion_id=sug.`id`
											WHERE sug.`item_id`=" . $row2['itemID'] . " and sug.suggested_image <> '' order by u.id desc");
                $k = 0;
                $subItemArray['images'] = array();
                while ($row3 = mysql_fetch_array($suggestedPeople)) {

                    $suggestedImageArray = $row3['suggested_image'] . "," . $row3['TotalLikesOfImage'] . "," . $row3['suggestionID'] . "," . $row3['isLikedByLoginUser'];


                    $subItemArray['images'][$k] = $suggestedImageArray;

                    $k++;
                }

                $suggestedPeople = mysql_query("select distinct(u.`fb_id`) as profile_photo from
                                 suggestions sug inner join users u on (u.id = sug.user_id)
                                 WHERE sug.`item_id`=" . $row2['itemID'] . " group by u.fb_id order by u.id desc");

                $k = 0;
                $subItemArray['peoples'] = array();
                while ($row3 = mysql_fetch_array($suggestedPeople)) {
                    $suggestedPeopleArray = $row3['profile_photo'];
                    $subItemArray['peoples'][$k] = $suggestedPeopleArray;
                    $k++;
                }

                $subArray[$i]['item'][$j] = $subItemArray;
                $j++;


            }
            $i++;
        }
        $row_array['SubCategory'] = $subArray;
        array_push($return_arr, $row_array);
    }
    $arr['status'] = "true";
    $arr['code'] = "P003";
    $arr['msg'] = "Category data found";
} else {
    $arr['status'] = "false";
    $arr['code'] = "P004";
    $arr['msg'] = "Category data not found";
}
$arr['Post'][0] = mysql_num_rows($totalRows);
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