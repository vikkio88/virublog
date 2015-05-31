<?
include "../config.php";
include "../include/function.php";
//Controllo la password proveniente dal client con la var globale__
$controllo=true;
$passwdute=$_POST['passwd'];
if ($passwdute!=$passwdgl){
	$controllo=false;
}
if ($controllo)
{
	$vettore=ls("*","../db/",false);
	echo "Post List:\n";
	$i=0;

	foreach ($vettore as $numeri){
		$f1=fopen("../db/".$numeri,"r");
		//while(!feof($f1)) {
			//read file line by line into variable
			//$output = $output . fgets($f1, 4096);
			$output=fgets($f1, 4096);
		//}
		fclose ($file);
		echo "Titolo: ".get_title($output)."  --id=".$i."-->  ".$numeri."\n";
		$i++;
	}
	
	
	/*echo "File List:<br />";
	echo $lung_array;
	$lungh_array-=1;
	echo "err";
	for ($i=($lungh_array-1);$i=0;--$i){
		echo get_title(require("./db/".$vettore[$lungh_array-$i]));
		echo "___";
		echo "<br />";
	}*/

}else
{
	echo "AuthError<br />this incident will be reported!";
	log_ip("try_to_accessfileman");
}

?>
