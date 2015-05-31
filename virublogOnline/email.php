<?php
$email=$_POST['email'];
$ip = $_SERVER["REMOTE_ADDR"];


if ($email!="") {
	if ((preg_match('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}\b/',$email))==1){
		$dataora=time();
		$datareale=date('d/m/Y',$dataora);
		$datareale=$datareale." ".(date("G:i",$dataora));
		$ff =fopen("./newsletter.txt","r");
		$i=0;
		$mail=array();
		while (!feof ($ff))
		{
			$riga = fgets ($ff);
			$riga=str_replace("\n","",$riga);
			$mail[$i]=$riga;
			$i++;
		}
		fclose($ff);
	/*	echo "valore passato=> $email<br />";
		echo "array che ho: ";
		$i=0;
		while ($i<count($mail)){
			echo "*".$mail[$i]."*";
			++$i;
		}
		echo "<br /> risposta in_array:".(int)(in_array($email,$mail));*/
		if(!(in_array($email,$mail))){
			$filenew=fopen("./newsletter.txt","a");
			fwrite($filenew,"$email\n");
			fclose($filenew);
			echo 'Mail correct! =), added! =)';
			//echo 'setTimeout("location.href=\'./index.php\', 3*1000 ");</script>';
		}
		else{
			echo 'Mail correct! =), but alredy in our db! =(';
			//echo 'setTimeout("location.href=\'./index.php\', 3*1000 ");</script>';
			}
	}
	else
	{
		echo 'mail incorrect! =(,retry?';
		//echo 'setTimeout("location.href=\'./index.php\', 3*1000 ");</script>';
	}
}else{
		echo 'mail incorrect! =(,retry?';
		//echo 'setTimeout("location.href=\'./index.php\', 3*1000 ");</script>';
}
?>
