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
$client = new RenRenClient();

# 如果您应该通过其他sdk（或自己实现）获得了session key，那么您可以选择只使用该sdk中的api部分
# 您可以通过setSessionKey方法设置您已经获取到的session key。
$session_key = $_SESSION['renren_oauth']['session_key'];
$client->setSessionKey($session_key);

# $client->setCallId('12345678');

# 调用api时的第一个参数是api方法名。
# 第二个参数请参考config.inc.php文件中的配置进行设置。
$friends = $client->POST('friends.getFriends', array('1', '10'));

foreach($friends as $friend) {
	echo "<img src=\"{$friend['tinyurl']}\" />&nbsp;&nbsp;{$friend['name']}<br/>";
}

?>