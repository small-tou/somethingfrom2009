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
include 'lib/SaeTOAuth.php';
include '../main/config.php';

$auth=new SaeTOAuth($sina_config['api_key'],$sina_config['api_secret']);
$token=$auth->getRequestToken();
$url=$auth->getAuthorizeURL($token,true,$sina_config['callback_url']);
$_SESSION['sina_oauth']['temp_token']=$token['oauth_token'];
$_SESSION['sina_oauth']['temp_secret']=$token['oauth_token_secret'];
?>
<a href="<?php echo $url;?>">用新浪微博账号登录</a>