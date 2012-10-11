<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function WriteFile($s_FileName, $s_Text){
if (!$handle = fopen($s_FileName, 'a')) {
   exit;
}
if (fwrite($handle, $s_Text) === FALSE) {
   exit;
}
fclose($handle);
}
WriteFile("site.txt", "http://".$_GET["url"]."\r\n")
?>
