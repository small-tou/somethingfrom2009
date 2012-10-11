<?php

session_start();
//error_reporting (0);
include 'lib/SaeTOAuth.php';
include '../main/config.php';
//$auth = new SaeTOAuth($sina_config['api_key'],$sina_config['api_secret'],$_SESSION['token'],$_SESSION['token_secret']);
//$post_data["source"] = "1269846683";
//$post_data["count"] = 200;
//$post_data["cursor"] = -1;
//$userList = $auth->oAuthRequest("http://api.t.sina.com.cn/statuses/friends.json", "POST", $post_data);
//$userList = json_decode($userList);
$token = $_SESSION['sina_oauth']['token'];
$secret = $_SESSION['sina_oauth']['secret'];
$client = new SaeTClient($sina_config['api_key'], $sina_config['api_secret'], $token, $secret);
//print_r($client->upload("test","http://ww4.sinaimg.cn/bmiddle/60718250tw1djj2r1dtxvj.jpg"));


//print_r($mentions);
$timestamp = strtotime("2011-7-23 20:34:00");
$count = 0;
date_default_timezone_set("Asia/Chongqing");

function co($men) {
    global $count;
  
    foreach ($men as $key => $value) {
        $time = strtotime($value['created_at']);
        if ($time > $timestamp) {
            $count++;
            $c--;
        }else{
            return true;
        }
    }
   return false;
}
$page=1;
$mentions = $client->mentions($page, 200);
while(co($mentions)==false){
    $page++;
   /// echo $page;
    $mentions=$client->mentions($page, 200);
}

echo $count;
$client->update("自从7.23特大事故发生之后,您的微博共被转发  "+$count+"  次!你也来试试吧!")

?>