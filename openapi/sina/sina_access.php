<?php
session_start();

include 'lib/SaeTOAuth.php';
include '../main/config.php';
$auth=new SaeTOAuth($sina_config['api_key'],$sina_config['api_secret'],$_SESSION['sina_oauth']['temp_token'],$_SESSION['sina_oauth']['temp_secret']);
$accessToken=$auth->getAccessToken($_REQUEST['oauth_verifier'],$_REQUEST['oauth_token']);
$_SESSION['sina_oauth']['token']=$accessToken['oauth_token'];
$_SESSION['sina_oauth']['secret']=$accessToken['oauth_token_secret'];
if($accessToken['oauth_token_secret']){
        Header("Location:".$_GET['sina_callback']);
}
?>