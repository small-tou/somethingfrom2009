<script>

</script>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>来源分析器</title>
        <script>


            var   MJBASEURL="http://html-js.com/mj/version1.0.3",
            CACHE=true,
            DEBUG=true
        </script>
        <script src="http://html-js.com/mj/version1.0.3/core-min.js"></script>

    </head>
    <body>
        <?php

        function safe_encode($data) {
            if (is_scalar($data)) {
                return str_ireplace(
                        array('+', '%7E'),
                        array(' ', '~'),
                        rawurlencode($data)
                );
            } else {
                return '';
            }
        }

        $url = 'http://api.t.sina.com.cn/oauth/request_token';
        $secret = "MCD8BKwGdgPHvAuvgvz4EQpqDAtx89grbuNMRd7Eh98";
        //POST数据
        $post_data['oauth_callback'] = "http://www.html-js.com";
        $post_data['oauth_consumer_key'] = "1053363421";
        $post_data['oauth_nonce'] = md5(rand());
        $post_data['oauth_signature_method'] = "HMAC-SHA1";
        $post_data['oauth_timestamp'] = time();
        $post_data['oauth_version'] = "1.0";
        $basestring = "POST&https%3A%2F%2Fapi.t.sina.com.cn%2Foauth%2Frequest_token&"; //%26oauth_callback%3Dhttp%3A%2F%2Fwww.html-js.com%26oauth_consumer_key%3D".$post_data['oauth_consumer_key']."%26oauth_nonce%3D" . $post_data['oauth_nonce'] . "%26oauth_signature_method%3DHMAC-SHA1%26oauth_timestamp%3D" . $post_data['oauth_timestamp'] . "%26oauth_version%3D1.0";
        $arr = array();
        foreach ($post_data as $key => $value) {
            array_push($arr, urlencode($key) . "%3D" . urlencode($value));
        }
        $basestring.=implode("%26", $arr);
        $basestring = "POST&https%3A%2F%2Fapi.t.sina.com.cn%2Foauth%2Frequest_token&oauth_callback%3Dhttp%253A%252F%252Flocalhost%253A3005%252Fthe_dance%252Fprocess_callback%253Fservice_provider_id%253D11%26oauth_consumer_key%3DGDdmIQH6jhtmLUypg82g%26oauth_nonce%3DQP70eNmVz8jvdPevU3oJD2AfF7R7odC2XJcn4XlZJqk%26oauth_signature_method%3DHMAC-SHA1%26oauth_timestamp%3D1272323042%26oauth_version%3D1.0";
        $post_data['oauth_signature'] =safe_encode(base64_encode(hash_hmac('sha1', $basestring, urlencode($secret) . "&", true))) ;


        echo $basestring;
        print_r($post_data);
        $o = "";
        foreach ($post_data as $k => $v) {
            $o.= "$k=" . urlencode($v) . "&";
        }
        $post_data = substr($o, 0, -1);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
//为了支持cookie
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $result = curl_exec($ch);
        echo $result;
        ?>


    </body>
</html>
