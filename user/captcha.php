<?php
session_start();

$kode = substr(str_shuffle("ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnopqrstuvwxyz23456789"), 0, 4);
$_SESSION['captcha'] = $kode;

header('Content-type: image/png');

$image = imagecreate(120, 40);
$bg = imagecolorallocate($image, 240, 240, 240);
$textcolor = imagecolorallocate($image, 0, 0, 0);

imagestring($image, 5, 30, 10, $kode, $textcolor);

imagepng($image);
imagedestroy($image);
?>