<?php
date_default_timezone_set("Asia/Bangkok");
$date = new DateTime();
$timenow = $date->format('Y-m-d H:i:s');

$kp = hash('ripemd160', 'kerjapraktek_5520115666');
$ta = hash('ripemd160', 'tugasakhir_5520114073');
$id_bimbingan = hash('ripemd160', 'bimbingan_ta_5520114073_'.$timenow);

echo $kp;
echo ("<br/>");
echo $ta;
echo ("<br/>");
echo strlen($kp);
echo ("<br/>");
echo $timenow;
echo ("<br/>");
echo $id_bimbingan;
 ?>
