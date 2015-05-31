<?
include "../config.php";
include "../include/function.php";
//Controllo la password proveniente dal client con la var globale__
$controllo=true;
$passwdute=$_POST['passwd'];
$postid=$_POST['id'];

if ($passwdute!=$passwdgl){
	$controllo=false;
}
if ($controllo)
{
	$vettore=ls("*","../db/",false);
	$filetodel="../db/".$vettore[$postid];
	echo filedel($filetodel);
	if (file_exists("../commentsdb/."$vettore[$postid]))
		echo "comment_file: "filedel("../commentsdb/."$vettore[$postid]);
}else
{
	echo "AuthError<br />this incident will be reported!";
	log_ip("try_to_delfile");
}

?>
