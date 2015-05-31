<?php
	include "../include/function.php";
	function logme($type="nothing",$ip,$nick,$datareale,$email,$post=0){
		$error=fopen("./error.txt",a);
		$loggare="ERROR!>date:".$datareale." nick:".$nick." ip: ".$ip." errortype: ".$type." email: ".$email." postid: $post \n";
		fwrite($error,$loggare);
		fclose($error);
	}
	//IP
	$ip = $_SERVER["REMOTE_ADDR"];
	$vettore=ls("*","../db/",false);
	$lungh_array= count($vettore);

		//varibili data
	$dataora=time();
	$datareale=date('d/m/Y',$dataora);
	$datareale=$datareale." ".(date("G:i",$dataora));
	
	$controllo=true;
	$sitoshow=false;
	//var_x_POST
	session_start();
	$nick=htmlspecialchars($_POST['nickname']);
	$email=htmlspecialchars($_POST['email']);
	$sito=htmlspecialchars($_POST['sito']);
	$antibot=$_POST['antibot'];
	$messaggio=subsgrave(htmlspecialchars($_POST['messaggio']));
	$cookie=$_SESSION['capt'];/*$_COOKIE['antibot'];*/
	$post=(int)$_POST['id'];
	
	

//controllo id post
if (!(in_array($post,$vettore))){
	$controllo=false;
}
	//controllo_antibot
		/*echo "prima dell'if<br />";
			echo "cookie= $cookie <br />";*/
	
	if ($cookie!=""){
		$salt="saltverymuch";
		$utehash=md5($salt.$antibot);
		//echo "nell'if= $utehash <br />";
		if($utehash!=$cookie){
			$controllo=false;
			logme("*cookie_error*",$ip,$nick,$datareale,$email);
		}
		
	}else{
		logme("*del_cookie?*",$ip,$nick,$datareale,$email);
		$controllo=false;
	}
	
	
	//controlli vari sull'input
		//sostituzioni sceme
			$messaggio=str_replace('\\',"",$messaggio);
			$nick=str_replace('\\',"",$nick);
	//TryXSS
	if ((stristr($nick,"&lt;")) != FALSE or (stristr($messaggio,"&lt;")) != FALSE){
		$controllo=false;
		logme("*XSS_try*",$ip,$nick,$datareale,$email);
	}
	//controlli RegExp
	if ((preg_match('/^([_a-zA-Z0-9+-+_+~+@]{2,10})+$/',$nick))!=1){
		$controllo=false;
		logme("*nick_error*",$ip,$nick,$datareale,$email);
	}
		//validità mail
	if ((preg_match('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}/',$email))!=1){
		$controllo=false;
		logme("*fake_mail*",$ip,$nick,$datareale,$email);
	}
	
	//corpomessaggiopiccolo
	if (strlen($messaggio)<2){
		$controllo=false;
		logme("*tiny_message*",$ip,$nick,$datareale,$email);
	}
	
	//controllo del sito
	//echo "prima di sitoshow<br>";
	if ((preg_match('/http:\/\/[a-zA-Z0-9._%+-]+\.[a-zA-Z]{2,4}/',$sito))==1){
		$sitoshow=true;
	}
	//echo "il preg da: ".(preg_match('/http:\/\/[a-zA-Z0-9._%+-]+\.[a-zA-Z]{2,4}/',$sito));
	
	
	//Scrittura
	if ($controllo){
		$namefile=("../commentsdb/".$post);
		//echo $namefile."<br />";
		if (file_exists($namefile))
			$filenew=fopen($namefile,"a");
		else
			$filenew=fopen($namefile,"w");
			
		if ($sitoshow==true){
			fwrite($filenew,"<div class=\"commento\" style=\"border: solid 1 px; padding: 1.5px\"><div class=\"commentop\" style=\"border:dotted 1px;\"><div class=\"title\"><a href='".$sito."'>".$nick."</a></div><div class=\"date\">&nbsp;&nbsp;data:".$datareale."</div></div><br />".$messaggio."</div><br />");
		}else{
			fwrite($filenew,"<div class=\"commento\" style=\"border: solid 1 px; padding: 1.5px\"><div class=\"commentop\" style=\"border:dotted 1px;\"><div class=\"title\">".$nick."</div><div class=\"date\">&nbsp;&nbsp;data:".$datareale."</div></div><br />".$messaggio."</div><br />");
		}
		fclose($filenew);
		//ultimicommenti
		if (file_exists("./corretti.txt"))
			$flast=fopen("./corretti.txt","a");
		else
			$flast=fopen("./corretti.txt","w");
		$titolo=substr((get_title(fgets(fopen("../db/$post","r")))), 0, 21)."..";
		$stringa="$nick in $titolo";
		if ((strlen($stringa))>38) {
			$titolo=substr($titolo,0,(strlen($titolo)-((strlen($stringa))-38)));
		}
		fwrite($flast,"<li>$nick in <a href=\"../view.php?id=$post\">$titolo</a></li>\n");
		fclose($flast);
		logme("*written_OK*",$ip,$nick,$datareale,$email,$post);
	//	echo "$post<br />";
		//echo "<a href='./scrivi.php'>dietro</a><a href='./guestbook.php'>avanti</a>";
		//echo 'setTimeout("location.href=\'../view.php?id='.$post.'\', 3*1000 ");</script>';
		header("location: ../view.php?id=$post");
	}else{
		echo '<script>alert("Something go wrong! =(,retry?");';
		echo 'setTimeout("location.href=\'../index.php\', 3*1000 ");</script>';
	}


?>
