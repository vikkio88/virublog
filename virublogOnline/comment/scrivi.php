<?php
include "../include/function.php";
include "./template.php";

$vettore=ls("*","../db/",false);
$lungh_array= count($vettore);
$post=(int)$_GET['id'];
$controllo=false;

if (in_array($post,$vettore))
	$controllo=true;

?>
<head>
		<meta name="Robots" content="INDEX,FOLLOW" />
		<meta name="language" content="it" />
		<link rel="SHORTCUT ICON" href="./img/favicon.ico"/>
		<?php 
		echo "<title>Comment a Post</title>";
		echo "<link href=\"../grafica/".$filecssname."\" rel=\"stylesheet\" type=\"text/css\" />
	  </head>
		
	<body>";
?>
<div id="header">
<h1>Add a comment</h1>
</div>
<?php
echo "<div id=\"pagebody\">";
	echo "<div id=\"right_side\">";
		echo "<div id=\"navigatore\">";
			include "./menu/navi.php"; 
		echo "</div>";
	echo "</div>";

echo "<div id=\"left_side\">";
				if ($controllo){
					$f1=fopen("../db/".$post,"r");
					$output=fgets($f1, 4096);
					fclose ($f1);
					$title=get_title($output);	
					
				print "<h2>Commenta il post =><strong> $title</strong></h2>: <br />
				    <form action=\"./posta.php\" method=\"post\" >
					
						<fieldset>
						<label>Nickname</label><br />
						<input type=\"text\" name=\"nickname\" /><br />
						<label>email(non visualizzata, ma Obbligatoria)</label><br />
						<input type=\"text\" name=\"email\" /><br />
						<label>sito_web(opzionale)</label><br />
						<input type=\"text\" name=\"sito\" /><br />
						<textarea name=\"messaggio\" cols=\"50\" rows=\"6\" id=\"condizion\"></textarea><br />
						<label>Sistema antibot:</label><br />
						<label>Quanto fa <img src=\"./image.php\" alt=\"operazione\" /> ?</label><br />
						<label>Sono presenti: somma, sottrazione e moltiplicazione</label><br />
						<input type=\"text\" name=\"antibot\" /><br />
						<input type=\"hidden\" name=\"id\" value=\"$post\"/> 
						<input type=\"submit\" name=\"Invia\" value=\"Invia\" /> <input type=\"reset\" name=\"Cancella\" value=\"Cancella\" />
						</fieldset>

						</form>";
				} else
					echo "<strong>Not a valid post id! =(...this will be reported!</strong>";
				
					?>
				</div>
			<?
				include "../include/footer.txt";
			?>
			</div>
	</body>

</html>
