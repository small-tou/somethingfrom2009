<?php

/*
  $filename=  htmlspecialchars($_POST['filename']);
  $bg_color= htmlspecialchars($_POST['bg_color']);
  $title= htmlspecialchars($_POST['title']);
  $des= htmlspecialchars($_POST['des']);

 */

function to_entities($string) {
    $len = strlen($string);
    $buf = "";
    for ($i = 0; $i < $len; $i++) {
        if (ord($string[$i]) <= 127) {
            $buf .= $string[$i];
        } else if (ord($string[$i]) < 192) {
            //unexpected 2nd, 3rd or 4th byte
            $buf .= "&#xfffd";
        } else if (ord($string[$i]) < 224) {
            //first byte of 2-byte seq
            $buf .= sprintf("&#%d;",
                            ((ord($string[$i + 0]) & 31) << 6) +
                            (ord($string[$i + 1]) & 63)
            );
            $i += 1;
        } else if (ord($string[$i]) < 240) {
            //first byte of 3-byte seq
            $buf .= sprintf("&#%d;",
                            ((ord($string[$i + 0]) & 15) << 12) +
                            ((ord($string[$i + 1]) & 63) << 6) +
                            (ord($string[$i + 2]) & 63)
            );
            $i += 2;
        } else {
            //first byte of 4-byte seq
            $buf .= sprintf("&#%d;",
                            ((ord($string[$i + 0]) & 7) << 18) +
                            ((ord($string[$i + 1]) & 63) << 12) +
                            ((ord($string[$i + 2]) & 63) << 6) +
                            (ord($string[$i + 3]) & 63)
            );
            $i += 3;
        }
    }
    return $buf;
}

function resize_png($src, $dstw, $dsth) {
    list($width, $height, $type, $attr) = getimagesize($src);
    $path = pathinfo($src);
    switch ($path ['extension']) {
        case "png": $im = imagecreatefrompng($src);
            break;
        case "jpg":
        case "jpeg": $im = imagecreatefromjpeg($src);
            break;
        case "gif":$im = imagecreatefromgif($src);
            break;
        default:die("不支持的图片格式");
    }

   
    $tim = imagecreatetruecolor($dstw, $dsth);
    imagecopyresampled($tim, $im, 0, 0, 0, 0, $dstw, $dsth, $width, $height);
    $bgcolor = imagecolorallocatealpha($tim, $_POST['red'], $_POST['green'], $_POST['blue'], 20);
    $white = imagecolorallocate($tim, 255, 255, 255);
    $white75 = imagecolorallocatealpha($tim, 255, 255, 255, 30);
    imagefilledrectangle($tim, 0, 100, 170, 150, $bgcolor);
    ImageTTFText($tim, 10.2, 0, 10, 123, $white, "simsun.ttf", to_entities($_POST['title']));
    ImageTTFText($tim, 10.2, 0, 11, 123, $white, "simsun.ttf", to_entities($_POST['title']));
    ImageTTFText($tim, 9, 0, 10, 140, $white75, "simsun.ttf", to_entities($_POST['des']));
    ImageTrueColorToPalette($tim, false, 255);
    $filepath = "temp/" . time() . md5($src) . ".png";
    imagepng($tim, $filepath);
    header("Content-type:image/png");
    header("Content-Disposition: attachment; filename=$filepath");
    header('Content-Length: ' . filesize($filepath));
    $fp = fopen($filepath, 'rb');
    fpassthru($fp);
    fclose($fp);
}

resize_png($_POST['filename'], 170, 150);
?>
