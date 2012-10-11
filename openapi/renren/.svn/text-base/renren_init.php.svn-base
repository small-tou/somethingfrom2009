<?php


include 'lib/requires.php';



class RenClient extends RenRenClient {

    var $token = "";
    var $refresh_token = "";
    var $session_key = "";
    var $client;
    function __construct($token, $refresh_token, $session_key) {
        $this->token = $token;
        $this->refresh_token = $refresh_token;
        $this->session_key = $session_key;
        
        if ($this->can_use()) {
            parent::__construct();
            $this->setSessionKey($session_key);
        }
    }

    function can_use() {
        if ($this->token && $this->refresh_token && $this->session_key) {
            return true;
        } else {
            return false;
        }
    }

    function oauth_url() {
        global $renren_config;
        return $renren_config['begin_url'];
    }

    function refresh_access_token() {
        $url = $this->_config->ACCESSTOKENURL;
        $params = array(
            'client_id' => $this->_config->APIKey,
            'client_secret' => $this->_config->SecretKey,
            'refresh_token' => $this->refresh_token,
            'grant_type' => 'refresh_token',
        );
        $client = new RESTClient();
        $ret = $client->call($url, 'POST', $params);
        $ret = json_decode($ret, true);
        print_r($ret);
        $_SESSION['renren_oauth']['token'] = $access_token;
    }

}

?>