<?php
/*������*/
$config_api = require('../conf/config.php');
$codeUrl = getAuthorizationCode($config_api['api_key'],"http://localhost/mj/openapi/renren/test/public/index.php");
echo "<a href=". $codeUrl.">fds</a>";
/*��ȡauthorization_code
 * param   $client_id    Ӧ�õ�api_key
 * param   $redirect_uri �ص���url
 * 
 * */
function getAuthorizationCode($client_id,$redirect_uri){
	$url = "http://graph.renren.com/oauth/authorize";
	return  $url."?client_id=".$client_id."&redirect_uri=".urlencode($redirect_uri)."&response_type=code&scope=status_update%20create_album%20read_user_album%20photo_upload%20read_user_photo";
}
