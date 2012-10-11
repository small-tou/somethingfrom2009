<?php
class MyCurl
{
    public function get($url, $params)
    {
        $ch = curl_init();
        // curl的get配置
        
        curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($params,"","&"));
       // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        $returnTransfer = curl_exec($ch);
        curl_close($ch);
        return $returnTransfer;
    }

    public function post($url, $params)
    {
        $ch = curl_init();
        // curl的post配置
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        $returnTransfer = curl_exec($ch);
        curl_close($ch);
        return $returnTransfer;
    }
}
?>
