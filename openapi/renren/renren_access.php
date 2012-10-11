<?php

session_start();
//if( isset($_SESSION['last_key']) ) header("Location: weibolist.php");
/**
include_once( 'config.php' );
include_once( 'weibooauth.php' );



$o = new WeiboOAuth( WB_AKEY , WB_SKEY  );

$keys = $o->getRequestToken();
$aurl = $o->getAuthorizeURL($keys['oauth_token'] ,false , $_SERVER['SCRIPT_URI'].'/callback.php');
print_r($keys);
$_SESSION['keys'] = $keys;
**/
require_once 'lib/requires.php';

$oauth = new RenRenOauth();
$code = $_GET['code'];

/**
 * 返回以下格式的数组
 *array(
 *	'access_token' => '130705|5.a2bf7f751cc195cbb310ff15e3cd793a.86400.1305525600-223378553',
 *	'expires_in' => 87048,
 *);
 */
$token = $oauth->getAccessToken($code);
$access_token = $token['access_token'];
$key = $oauth->getSessionKey($access_token);
$_SESSION['renren_oauth']['token']=$access_token;
$_SESSION['renren_oauth']['refresh_token']=$token['refresh_token'];
$_SESSION['renren_oauth']['session_key']=$key['renren_token']['session_key'];
if($key['renren_token']['session_key']){
     Header("Location:".$_GET['renren_callback']);
}
?>
