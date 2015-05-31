<?php
session_start();
$a = rand(1,6);
$b = rand(1,6);
$op = rand(1,3);
if ($op == 1) {
	$res = $a+$b;
	$op = ' + ';
}
if ($op == 2) {
	$res = $a-$b;
	$op = ' - ';
}
if ($op == 3) {
	$res = $a*$b;
	$op = ' x ';
}
$code=$a.' '.$op.' '.$b;

$salt="saltverymuch";
$hash1 = md5($salt.$res);
//setcookie("antibot", $hash1, time()+1000, "/"/*, ".webook.it"*/);
$_SESSION['capt'] = $hash1;
$im = imagecreate(140, 30);
$bg = imagecolorallocate($im, 35, 30, 30);

$grey = imagecolorallocate($im, 128, 128, 128);
$black = imagecolorallocate($im, 0, 0, 0);
$font = './mosh.ttf';
$textcolor = imagecolorallocate($im, 0, 100, 255);
// Add some shadow to the text
imagettftext($im, 20, 0, 11, 21, $grey, $font, $code);

// Add the text
imagettftext($im, 20, 0, 10, 20, $black, $font, $code);



//imagestring($im, 5, 20, 10, $code, $textcolor);
// output the image
header("Content-type: image/jpeg");
imagejpeg($im);
?>
