<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
header('Content-type: application/txt');
header('Content-Disposition: attachment; filename="aa.txt"');
readfile('aa.txt');
?>
