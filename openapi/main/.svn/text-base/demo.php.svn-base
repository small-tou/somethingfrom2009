<?php
include "init.php";
session_start();

$sina_token=isset ($_SESSION['sina_oauth']['token'])?$_SESSION['sina_oauth']['token']:"";
$sina_secret=isset($_SESSION['sina_oauth']['secret'])?$_SESSION['sina_oauth']['secret']:"";

$sina=new SinaClient($sina_token, $sina_secret);
if (!$sina->can_use()) {
    echo "<a href=" . $sina->oauth_url() . ">绑定新浪网账号</a>";
} else {
    echo "<div>已绑定新浪网账号</div>";
}


$renren_token =isset ( $_SESSION['renren_oauth']['token'])? $_SESSION['renren_oauth']['token']:'';
$renren_refresh_token =isset ($_SESSION['renren_oauth']['refresh_token'])? $_SESSION['renren_oauth']['refresh_token']:"";
$renren_session_key = isset ($_SESSION['renren_oauth']['session_key'])?$_SESSION['renren_oauth']['session_key']:"";

$renren = new RenClient($renren_token, $renren_refresh_token, $renren_session_key);
if (!$renren->can_use()) {
    echo "<a href=" . $renren->oauth_url() . ">绑定人人网账号</a>";
} else {
    echo "<div>已绑定人人网账号</div>";
}


?>

