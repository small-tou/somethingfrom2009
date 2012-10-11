<?php
include "config.php";
include "../../sina/sina_init.php";
include "../../renren/renren_init.php";
session_start();
$sina_token = isset($_SESSION['sina_oauth']['token']) ? $_SESSION['sina_oauth']['token'] : "";
$sina_secret = isset($_SESSION['sina_oauth']['secret']) ? $_SESSION['sina_oauth']['secret'] : "";

$client = new SinaClient($sina_token, $sina_secret);
$info = $client->verify_credentials();
$pic = $info['profile_image_url'];
$big_pic = preg_replace("/(http:\/\/.*?\/.*?\/)(50)(\/.*$)/iu", "\${1}180\${3}", $pic);

$srcfile = "images/" . $info['id'] . ".jpg";
$grayfile = "images/" . $info['id'] . "-grey.jpg";

$info="";
if ($_GET['action'] == "color") {
    if (file_exists($srcfile)) {
        $client->update_profile_image($srcfile);
    }else{
        
    }
} else {
    if (file_exists($grayfile)) {
        print_r($client->update_profile_image($grayfile));
    } else {
        file_put_contents("images/" . $info['id'] . ".jpg", file_get_contents($big_pic));

        $im = imagecreatefromjpeg($srcfile);
        imagefilter($im, IMG_FILTER_GRAYSCALE);
        imagejpeg($im, "images/" . $info['id'] . "-grey.jpg");
        $client->update_profile_image($grayfile);
    }
}
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script>
 //   window.location.href="index.php"
    </script>
    </head>
    <body>
<?php
echo $info;
?>
    </body>
</html>
