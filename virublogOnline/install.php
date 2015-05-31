<?php
	//*INSERISCI LA PASSWORD:
		$password= "adminpassword";
	//*titolo del blog
	//	non potrai più cambiarlo!
		$titolo="Virublog's Engine!";
	
	
	
	//*Il template che vuoi...
	/*	Lascialo non specificato se vuoi il template di default
	 * 	n.b. è possibile cambiarlo dal client successivamente
	 * */
		$cssfilename= "default.css"; //N.B. non omettere l'estensione .css
	
	
	
	$filename2="./grafica/cssname";
	$writecss=fopen($filename2,"w");
	fwrite($writecss,"css/".$cssfilename);
	fclose($writecss);
	
	
	$configure=fopen("./config.php","w");
	
	fwrite($configure,'<?php
		$ute=$_POST[\'pass\'];
		$passwdgl="'.$password.'";
		//echo $passwdgl;
		if ($passwdgl==$ute){
			echo "true";
		}
		else
		{
			echo "_";
		}
		?>');
	fclose($configure);

	$template=fopen("./template.php","w");
	fwrite($template,'<?php
		$cssfileopen=fopen("'.$filename2.'","r");
		$filecssname=fgets($cssfileopen);
		fclose($cssfileopen);
		$blogtitle="'.$titolo.'";
		?>');
	fclose($template);
	
	//otherTemplatecomment
	$template=fopen("./comment/template.php","w");
	fwrite($template,'<?php
		$cssfileopen=fopen("../'.$filename2.'","r");
		$filecssname=fgets($cssfileopen);
		fclose($cssfileopen);
		?>');
	fclose($template);
	
	mkdir("./db");
	mkdir("./commentsdb");
	
	$template=fopen("./guestbook/template.php","w");
	fwrite($template,'<?php
		$cssfileopen=fopen("../'.$filename2.'","r");
		$filecssname=fgets($cssfileopen);
		fclose($cssfileopen);
		?>');
	fclose($template);
	
	
	$head=fopen("./include/header.txt","w");
	fwrite($head,"<h1>".$titolo."</h1>");
	fclose($head);
	
	@unlink("./index.php");
	$index=fopen("./index.php","w");
	fwrite($index,'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
	function sleep(milliseconds) {
		var start = new Date().getTime();
		for (var i = 0; i < 1e7; i++) {
			if ((new Date().getTime() - start) > milliseconds){
				break;
    }
  }
}
	
	function conta(){
			$.get("conta.php", function(data){$(\'#count\').html("<strong>"+data+("</strong>"))});
	}
	
	function join(){
		oForm = document.forms["emailform"];
		name = oForm.elements["email"].value;
		var ajxFile = "./email.php";
		$.post(ajxFile,{email: name}, function(data){alert(data);});
		sleep(1000);
		conta();
	}
</script>
<?php
include "./include/function.php";
include "./template.php";

//loggo gli ip dei visitatori
log_ip();
$pagina=(int)($_GET[\'p\']);
if(($pagina<1)||(!(is_numeric($pagina)))||($pagina=="")) $pagina=1;
$vettore=ls("*","./db/",false);
$lungh_array= count($vettore);


echo "<head>
		<meta name=\"Robots\" content=\"INDEX,FOLLOW\" />
		<meta name=\"language\" content=\"it\" /><link rel=\"SHORTCUT ICON\" href=\"./img/favicon.ico\"/>
		<title>$blogtitle</title>
		<link href=\"./grafica/".$filecssname."\" rel=\"stylesheet\" type=\"text/css\" />
		<link rel=\"alternate\" type=\"application/rss+xml\" href=\"./feed_rss.php\" title=\"Feeds\" />
	   </head>
		
		<body>";
echo "<div id=\"header\">";
include "./include/header.txt";			
echo "</div>";

echo "<div id=\"pagebody\">";
	echo "<div id=\"right_side\">";
		echo "<div id=\"navigatore\">";
	
			include "./menu/navi.php";
			echo "<div class=\"menu_title\">
					NewsLetter
				  </div>
				<ul class=\"navigatore\">
					<li>
					<form id=\"emailform\">
						Join the newsLetter!
						<label>email(should be valid!)</label><br />
						<input id=\"mailbox\" type=\"text\" name=\"email\" /><div id=\"loader\"></div><br />
						<input type=\"button\" onclick=\"join()\" value=\"Send\"/>
						<label>We got <span id=\"count\"></span> addict(s)</label><br />
						
					</form>
					</li>
				</ul>";
			lastcomment();
		echo "</div>";
	echo "</div>";

echo "<br />";


	echo "<div id=\"left_side\">";

//echo "p= ".$pagina;
$paginegen=(int)($lungh_array/6);
if (($lungh_array%6)>0) $paginegen=($paginegen+1);
//echo "per ".$lungh_array." post, farei: ".$paginegen." pagine...che te ne pare?<br/>";

if($pagina>$paginegen) $pagina=1;
inpagina($vettore,$lungh_array,$pagina);
	
	echo "<div class=\"destra\">";
if (!($pagina==1))echo "<a href=\'./index.php?p=".(((int)$pagina)-1)."\'>&laquo;- Newest Posts</a>";
				echo " $pagina/$paginegen ";
				echo "<a href=\'./index.php?p=".(((int)$pagina)+1)."\'>Older Posts -&raquo;</a>";
	echo "</div>";
echo "</div>";

include "./include/footer.txt";
echo "</div>";
echo "</div>";
echo "</body></html>";



?>');
fclose($index);

@unlink("./install.php");

header("location: ./index.php");

?>
