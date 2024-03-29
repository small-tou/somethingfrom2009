<?php


include 'lib/SaeTOAuth.php';
class SinaClient extends SaeTClient {

    var $token = "";
    var $secret = "";
    var $client;

    function can_use() {
        if ($this->token && $this->secret) {
            return true;
        } else {
            return false;
        }
    }

    function __construct($token, $secret) {
        global $sina_config;
        $this->token = $token;
        $this->secret = $secret;
        if ($this->can_use()) {
            parent::__construct($sina_config['api_key'], $sina_config['api_secret'], $token, $secret);
        }
    }
    function oauth_url(){
        global $sina_config;
        $auth=new SaeTOAuth($sina_config['api_key'],$sina_config['api_secret']);
$token=$auth->getRequestToken();
$url=$auth->getAuthorizeURL($token,true,$sina_config['callback_url']);
$_SESSION['sina_oauth']['temp_token']=$token['oauth_token'];
$_SESSION['sina_oauth']['temp_secret']=$token['oauth_token_secret'];
return $url;
      //  return $sina_config['begin_url'];
    }
}

?>