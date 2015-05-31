<?php
include "./config.php";
include "./include/function.php";
//Controllo la password proveniente dal client con la var globale__
$controllo=true;
$passwdute=$_POST['passwd'];
if ($passwdute!=$passwdgl){
	$controllo=false;
}

if ($controllo){
	
$vettore=ls("*","./db/",false);
$lungh_array= count($vettore);
	
$corpo=$_POST['corpo'];
$titolo=$_POST['titolo'];
$titolo=str_replace('\\',"",$titolo);
$corpo=app_bbcode($corpo);
$corpo=str_replace('\\',"",$corpo);
$dataora=time();
$datareale=date('d/m/Y',$dataora);
$datareale=$datareale." ".(date("G:i",$dataora));
//echo $dataora."<br />";
$fp=fopen("./db/".$dataora,w);
fwrite($fp,"<div class=\"post\"><div class=\"posttop\"><div class=\"title\"><a href='./view.php?id=".$dataora."'>".$titolo."</a></div><div class=\"date\">&nbsp;&nbsp;data:".$datareale."</div></div><br />".$corpo."<div class=\"comment\"><a href='./comment/scrivi.php?id=".$dataora."'><strong>Aggiungi Commento</strong></a>/<a href='./view.php?id=".$dataora."'><strong>Commenti</strong></a></div></div><br />");
fclose($fp);
echo "Post Successfull! =)\n";
echo "Sending mails to mailinglist!\n";
$mails=array();
$ff =fopen("./newsletter.txt","r");
while (!feof ($ff))
{
	$riga = fgets ($ff);
	array_push($mails,$riga);
}
fclose($ff);
echo "...";
/*foreach ($mails as $mail) {
    @mail($mail,'New post!', "New post!\ntitle: $titolo\nlink: ".$_SERVER['SERVER_NAME'].$_SERVER['DOCUMENT_ROOT']."view.php?id=$dataora\n.",'from: admin@virublog.org');
}*/
echo "Done!...\n";
echo "Bye! =)...\n";
} else{
	echo "AuthError<br />this incident will be reported!";
	log_ip("try_to_post_access");
}

?>
