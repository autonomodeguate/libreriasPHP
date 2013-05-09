<?php
session_start();
$caracteres = "abcdefghijklmnpqrstuvwxyz123456789";
$cadena = "";
$num_caracteres = 5;
for($i=0;$i<$num_caracteres;$i++)
{
	$random = rand(0,strlen($caracteres)-1);
	$cadena .= substr($caracteres,$random,1);
}

$_SESSION['captcha'] = md5($cadena);

$captcha = imagecreatefrompng("fondo.png");
$color = imagecolorallocate($captcha,96,152,252);
imagestring($captcha,15,30,10,$cadena,$color);
header("Content-type:image/png");
imagepng($captcha);
?>