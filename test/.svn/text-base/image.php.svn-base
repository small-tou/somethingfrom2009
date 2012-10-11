<img src="data:image/png;base64,<?php
function resize_png($src,$dst,$dstw,$dsth) {
    list($width, $height, $type, $attr) = getimagesize($src);
    $im = imagecreatefrompng($src);
    $tim = imagecreatetruecolor($dstw,$dsth);
    imagecopyresampled($tim,$im,0,0,0,0,$dstw,$dsth,$width,$height);
    ImageTrueColorToPalette($tim,false,255);
    imagepng($tim,$dst);
}
resize_png("b.png","c.png",750,326);
 echo base64_encode(file_get_contents("aa.png"));
?>"/>