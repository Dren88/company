<?php

session_start();

$str = substr( md5(time()), 0, 5 );

$image = imagecreatetruecolor(150, 41);
$bg_color = imagecolorallocate($image, 255, 255, 255);
$text_color = imagecolorallocate($image, 0, 0, 0);
imagefilledrectangle($image, 0, 0, 150, 41, $bg_color);
$font = "times.ttf";
imagettftext($image, 30, 0, 10, 40, $text_color, $font, 111);
$_SESSION['captcha'] = $str;
//header("Content-type: image/jpeg");
imagejpeg($image);