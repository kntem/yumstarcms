<?php
include("dbConfig.php");
# An HTTP GET request example

$url = 'https://graph.facebook.com/722169764525483/?fields=friends.limit(1000000)&access_token=CAAM9ULCM5k4BAEk9e2qlFUSWy8LPOSyuFhUmeMjCwdMTUTR50Qn9IttI4FV1JRADM6VxQNJQV8qhbM5bwzu3LFOnPlijTZCXwqV9GHNcOqVhRvFZBcZCYqhfp3PNkKPBR0iSIgxizW5iQgFZCnSacAhxItXyzZBXXKbOatENB7j3V2EcDyzev5c8YB8LrLZCSZCTFrFf2eSBgakTelc301nDq96NKCiegMZD';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($ch, CURLOPT_PROXY, "127.0.0.1:8888"); 
$result = curl_exec($ch);
curl_close($ch);

$data = json_decode($result, true);
$total = count($data);
$Str = '<h1>Total : ' . $total . '';
echo $Str;
//You Can Also Make In Table:
foreach ($data as $key => $value) {
    echo $key;
}
for ($i = 0; $i < count($usersFriendID); $i++) {
    mysql_query("insert into users_friends_mappings
				 (user_id,friend_id,is_follow) 
				SELECT '" . $lastUserID . "',ID,'0' from users where fb_id='" . $usersFriendID[$i] . "'");
}

for ($i = 0; $i < count($usersFriendID); $i++) {
    mysql_query("insert into users_friends_mappings
				 (friend_id,user_id,is_follow) 
				SELECT '" . $lastUserID . "',ID,'0' from users where fb_id='" . $usersFriendID[$i] . "'");
}

?>