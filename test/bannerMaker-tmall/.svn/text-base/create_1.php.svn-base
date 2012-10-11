<?php

function resize_png($src, $dstw, $dsth) {
    list($width, $height, $type, $attr) = getimagesize($src);
    $im = imagecreatefrompng($src);
    $tim = imagecreatetruecolor($dstw, $dsth);
    imagecopyresampled($tim, $im, 0, 0, 0, 0, $dstw, $dsth, $width, $height);

    ImageTrueColorToPalette($tim, false, 255);
    $filepath = "temp/" . time() . md5($src) . ".png";
    imagepng($tim, $filepath);
    header("Content-type:image/png");
    header("Content-Disposition: attachment; filename=$filepath");
    header('Content-Length: ' . filesize($filepath));
    $fp = fopen($filepath, 'rb');
    fpassthru($fp);
    fclose($fp);
    if (file_exists($filepath)) {
        unlink($filepath);
    }
}

resize_png($_POST['image_data'], 170, 150);
?>
