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

# 本例中是生成超链接，实际应用中您可以使用header("Location: $url");方式跳转
$url = $oauth->getAuthorizeUrl();
?>

<a href="<?php echo $url;?>">用人人账号登录</a>