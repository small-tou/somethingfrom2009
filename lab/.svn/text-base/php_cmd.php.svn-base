<?php
$to_ping = "www.baidu.com";
$count = 2;
$psize = 66;
echo " Please be patient, this can take a few moments…\n<br><br>";
flush();
$ii = 1;
while ($ii < 2) {
echo "<pre>";
echo $ii;
exec("ping -n $count -l $psize $to_ping", $list);
for ($i=0;$i < count($list);$i++) {
    print $list[$i]."\n";
}
echo "</pre>";
flush();
sleep(3);
$ii++;
}

exec("ipconfig /all", $list);
for ($i=0;$i < count($list);$i++) {
    print $list[$i]."\n"."<br>";
    flush();
}
?>