<?php

require('../class/curl.class.php');
require('../fun/functions.php');
$config_api = require('../conf/config.php');
session_start();
$session_key = $_SESSION['session_key'];

function sendApi($param) {
    global $config_api;
    $url = $config_api['api_url'];
    $param['sig'] = getSig($param, $config_api['api_secret']);
    $mycurl = new MyCurl();
    $result = $mycurl->post($url, $param);
    return (json_decode($result, true));
}

$userid = sendApi(array(
            'api_key' => $config_api['api_key'],
            'call_id' => time(),
            'format' => 'json', //制定返回的数据格式
            'method' => 'users.getLoggedInUser', //那这个api做例子
            'session_key' => $session_key,
            'status' => "i am from php",
            'v' => '1.0'
        ));
$userid = $userid['uid'];

$albums = sendApi(array(
            'api_key' => $config_api['api_key'],
            'call_id' => time(),
            'format' => 'json', //制定返回的数据格式
            'method' => 'photos.getAlbums', //那这个api做例子
            'session_key' => $session_key,
            'uid' => $userid,
            'v' => '1.0'
        ));
$albums_1 = $albums[0];

$pics = sendApi(array(
     'aid' => $albums_1['aid'],
            'api_key' => $config_api['api_key'],
            'call_id' => time(),
            'format' => 'json', //制定返回的数据格式
            'method' => 'photos.get', //那这个api做例子
   
            'session_key' => $session_key,
            
            'uid' => $userid,
            'v' => '1.0'
        ));

$pic=$pics[0]['url_large'];
echo $pic;
file_put_contents(basename($pic), file_get_contents($pic));


?>