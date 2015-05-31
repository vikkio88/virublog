<?php
	function logme($type="nothing",$ip,$nick,$datareale,$email){
		$error=fopen("./error.txt",a);
		$loggare="ERROR!>date:".$datareale." nick:".$nick." ip: ".$ip." errortype: ".$type." email: ".$email."\n";
		fwrite($error,$loggare);
		fclose($error);
	}
	//IP
	$ip = $_SERVER["REMOTE_ADDR"];

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
	$messaggio=htmlspecialchars($_POST['messaggio']);
	$cookie=$_SESSION['capt']/*$_COOKIE['antibot']*/;
	//controllo_antibot
		/*echo "prima dell'if<br />";
			echo "cookie= $cookie <br />";*/
	
	if ($cookie!=""){
		$salt="saltabestia";
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
	if ($controllo==true){
		$namefile="./data/".$dataora;
		//echo $namefile."<br />";
		$filenew=fopen($namefile,"w");
		if ($sitoshow==true){
			fwrite($filenew,"<div class=\"post\"><div class=\"posttop\"><div class=\"title\"><a href='".$sito."'>".$nick."</a></div><div class=\"date\">&nbsp;&nbsp;data:".$datareale."</div></div><br />".$messaggio."</div><br />");
		}else{
			fwrite($filenew,"<div class=\"post\"><div class=\"posttop\"><div class=\"title\">".$nick."</div><div class=\"date\">&nbsp;&nbsp;data:".$datareale."</div></div><br />".$messaggio."</div><br />");
		}
		fclose($filenew);
		logme("*written_OK*",$ip,$nick,$datareale,$email);
		//@mail('vikkio88@yahoo.it','Qualcuno ha scritto sul tuo guestbook!', "nick: $nick ip: $ip per leggere clicka => http://vikkio88.altervista.org/guestbook/guestbook.php",'from: vikkio88@altervista.org');
		//echo "done<br />";
		//echo "<a href='./scrivi.php'>dietro</a><a href='./guestbook.php'>avanti</a>";
		header("location: ./guestbook.php");
	}else{
		echo '<script>alert("Something go wrong! =(,retry?");';
		echo 'setTimeout("location.href=\'./scrivi.php\', 3*1000 ");</script>';
	}


?>
