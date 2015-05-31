<?php

include "../config.php";
include "../include/function.php";
//Controllo la password proveniente dal client con la var globale__
$controllo=true;
$passwdute=$_POST['passwd'];
$cssid=$_POST['id'];

if ($passwdute!=$passwdgl){
	$controllo=false;
}
if ($controllo)
{
	$cssarray=ls("*.css","./css",true);
	if (!(($cssid>(count($cssarray)-1))||($cssid<0))){
		//se l'id css esiste
		filedel("./cssname");
		$writecss=fopen("./cssname","w");
		fwrite($writecss,"css/".$cssarray[$cssid]);
		fclose($writecss);
		echo "Css successfull changed!\n";
	}else
		echo "Wrong css id....=(\n";
}else
{
	echo "AuthError<br />this incident will be reported!";
	log_ip("try_to_changecss");
}
?>
