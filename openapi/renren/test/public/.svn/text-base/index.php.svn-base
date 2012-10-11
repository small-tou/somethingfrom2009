<?php

/* 包含配置文件 */
require('../class/curl.class.php');
require('../fun/functions.php');
$config_api = require('../conf/config.php');
session_start();
header("Content-Type:text/html;charset=utf-8");
/* 主流程 */
$session_key = "";

function doGet() {
    global $config_api;
    if (isset($_GET['code'])) {
        $config_api['code'] = $_GET['code'];
        $access_key = getAccessToken($config_api['api_key'], $config_api['api_secret'], "http://localhost/mj/openapi/renren/test/public/index.php", $config_api['code']);
        if ("" != $access_key) {
           global  $session_key;
           $session_key= getSessionKey($access_key);
            if ("" != $session_key) {
                //    sendApi($session_key);
            } else {
                echo "获取session_key失败!";
            }
        } else {
            echo "获取access_key失败!";
        }
    }
}

/* * 获取access_key
 * param $client_id        应用的api_key
 * param $client_secret    应用的secret_key
 * param $redirect_uri     回调的url
 * param $code             之前获取到的Authorization Code
 * param $grant_type       "authorization_code"
 * https://graph.renren.com/oauth/token?client_id=109c776f58db4fb881c75671e977445b&client_secret=f3bf687b8a65445f98e4c47734fda86d&code=eSKpF1VmNMQMBa3bjgt2WOtiodW3TKFB&grant_type=authorization_code&redirect_uri=http://localhost/mj/openapi/renren/test/public/index.php
 * return string
 * */

function getAccessToken($client_id, $client_secret, $redirect_uri, $code) {
    global $config_api;
    $url = $config_api['access_url'];
    $param = array(
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'code' => $code,
        'grant_type' => 'authorization_code',
        'redirect_uri' => $redirect_uri
    );

    $mycurl = new MyCurl();
    $result = $mycurl->get($url, $param);

    if (is_string($result)) {
        $result = json_decode($result, true);
        return $result['access_token'];
    }
}

/* 获取session_key
 * param   $oauth_token    之前获取得access_key
 * return string
 * */

function getSessionKey($oauth_token) {
    global $config_api;
    $url = $config_api['session_url'];
    $param = array(
        'oauth_token' => $oauth_token
    );
    $mycurl = new MyCurl();
    $result = $mycurl->get($url, $param);
    if (is_string($result)) {
        $result = json_decode($result, true);
        return $result['renren_token']['session_key'];
    }
}

/**
 * 向人人网api发送请求
 * */
function sendApi($param) {
    global $config_api;
    $url = $config_api['api_url'];
    $param['sig'] = getSig($param, $config_api['api_secret']);
    $mycurl = new MyCurl();
    $result = $mycurl->post($url, $param);
    return (json_decode($result, true));
}

doGet();
$_SESSION['session_key']=$session_key;
echo $session_key;
?>