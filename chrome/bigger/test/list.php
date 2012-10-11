<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
header("Content-Type: text/html;charset=utf-8");
function getFile($s_FileName){
if (!$handle = fopen($s_FileName, 'a+')) {
   exit;
}
if (fwrite($handle, $s_Text) === FALSE) {
   exit;
}
$count=0;
echo "<a href=download.php>下载完整的列表</a><br/><br/>";
while (!feof($handle)&&count<200) {
   $line = fgets($handle);
   $count++;
   echo "<a href=$line>$line</a><br/>";
}
fclose($handle);
}
getFile("aa.txt")
?>
