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

$totalRows = mysql_query("select i.name from orders o
						inner join order_items ot on (ot.`order_id`=o.id)
						inner join items i on (i.id=ot.item_id)
						where o.user_id=" . $paramArray['userID']);


$orderHistory = mysql_query("select o.id as orderID,i.name,i.id,i.description,
o.order_date,minute(Sec_to_time(Timestampdiff (second, now(), o.order_date))) as min,
second(Sec_to_time(Timestampdiff (second, now(), o.order_date))) as sec,
HOUR(Sec_to_time(Timestampdiff (second, now(), o.order_date))) as hours,
						datediff(now(),o.order_date) as days,
						floor(datediff(now(),o.order_date) / 365) as years,ot.price,ot.is_suggested,
ifnull(d.totalSuggestion,0) as totalSuggestion,ifnull(rr.name,'') as 'restName' from orders o
inner join order_items ot on (ot.`order_id`=o.id)
inner join items i on (i.id=ot.item_id)
left join restaurants rr on rr.id=o.rest_id
left join (select sug.item_id,count(sug.user_id) as 'totalSuggestion' from suggestions sug group by item_id ) d on (ot.item_id=d.item_id)
where o.user_id=" . $paramArray['userID'] . "
order by o.order_date desc limit " . $paramArray['Limit1'] . ", " . $defaultRecordLimit, $con) or die(mysql_error());


if (mysql_num_rows($orderHistory) > 0) {
    while ($row = mysql_fetch_array($orderHistory)) {
        $row_array['Name'] = $row['name'];
        $row_array['Id'] = $row['id'];
        $row_array['Description'] = $row['description'];
        $row_array['price'] = $row['price'];
        $row_array['Purchased_date'] = $row['order_date'];
        $row_array['isSuggested'] = $row['is_suggested'];
        $row_array['suggestionCount'] = $row['totalSuggestion'];
        $row_array['orderID'] = $row['orderID'];
        $row_array['restName'] = $row['restName'];
        //restName

        if ($row['years'] == 0) {
            $row_array['time_ago'] = $row['days'] . " d";
            if ($row['days'] == 0) {
                $row_array['time_ago'] = $row['hours'] . " h";
                if ($row['hours'] == 0) {
                    $row_array['time_ago'] = $row['min'] . " m";
                }
                if ($row['min'] == 0) {
                    $row_array['time_ago'] = $row['sec'] . " s";
                }
            }
        } else {
            $row_array['time_ago'] = $row['years'] . " y";
        }


        array_push($return_arr, $row_array);
    }
    $arr['status'] = "true";
    $arr['code'] = "P003";
    $arr['msg'] = "History found";

} else {
    $arr['status'] = "false";
    $arr['code'] = "P004";
    $arr['msg'] = "No history found";
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