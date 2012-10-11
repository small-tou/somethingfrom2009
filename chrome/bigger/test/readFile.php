<?php
$url =$_GET["url"];
$contents = file_get_contents("http://tt.mop.com/topic/read_4228307_1_0.html");
//如果出现中文乱码使用下面代码
//$getcontent = iconv(”gb2312″, “utf-8″,file_get_contents($url));
//echo $getcontent;
echo $contents;
?>