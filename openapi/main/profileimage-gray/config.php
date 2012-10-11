<?php

$host = "http://localhost/xampp/mj/openapi";
$sina_config = array(
    "api_key" => "99395284",
    "api_secret" => "abdee7a47ba5d96e646ffb2f1923b81d",
    "request_token_url" => "http://api.t.sina.com.cn/oauth/request_token",
    "authorize_url" => "http://api.t.sina.com.cn/oauth/authorize",
    "access_token_url" => "http://api.t.sina.com.cn/oauth/access_token",
    "callback_url" => $host . "/sina/sina_access.php?sina_callback=http%3A%2F%2Flocalhost%2Fxampp%2Fmj%2Fopenapi/main/profileimage-gray/index.php",
    "begin_url" => $host."/sina/sina_token.php",
);

$renren_config = array(
    "api_url" => "http://api.renren.com/restserver.do",
    "token_url" => "http://graph.renren.com/oauth/authorize",
    "session_url" => "http://graph.renren.com/renren_api/session_key",
    "access_url" => "http://graph.renren.com/oauth/token",
    "api_key" => "06a4d96949eb42809758b3b02dd42c04",
    "api_secret" => "c28c847eee8e4ecf9211db3fe9026bd7",
    "callback_url" => $host . "/renren/renren_access.php?renren_callback=http%3A%2F%2Flocalhost%2Fmj%2Fopenapi%2Frenren%2Frenren_demo.php",
    "begin_url" => $host . "/renren/renren_token.php"
);
?>