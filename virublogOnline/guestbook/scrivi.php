<?php
include "../include/function.php";
include "./template.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
		<title>Scrivi nel Guestbook</title>
		<meta name="Description" content="Vikkio88 home" />
		<meta name="Keywords" content="vikkio88" />
		<meta name="Robots" content="INDEX,FOLLOW" />
		<meta name="language" content="it" />
		<link rel="SHORTCUT ICON" href="./img/favicon.ico"/>
		<?php
		echo "<link href=\"../grafica/".$filecssname."\" rel=\"stylesheet\" type=\"text/css\" />";
		?>
		</head>
	<body>
	<div id="header">
			<h1>
				Scrivi nel guestbook
			</h1>
	</div>
			<div id="pagebody">
			<div id="right_side">
			<div id="navigatore">
								<ul>
				<li><a href="../index.php" title="Indice">Home</a></li>
			</ul>
			</div>
			</div>
			<div id="left_side">
				<h1>Scrivi nel mio Guestbook</h1>
				    <form action="./posta.php" method="post" >

						<fieldset>

						<label>Nickname</label><br />
						<input type="text" name="nickname" /><br />
						<label>email(non visualizzata)</label><br />
						<input type="text" name="email" /><br />
						<label>sito_web(opzionale)</label><br />
						<input type="text" name="sito" /><br />
						<textarea name="messaggio" cols="50" rows="6" id="condizion"></textarea><br />
						<label>Sistema antibot:</label><br />
						<label>Quanto fa <img src="./image.php" alt="operazione" /> ?</label><br />
						<label>Sono presenti: somma, sottrazione e moltiplicazione</label><br />
						<input type="text" name="antibot" /><br />
						<input type="submit" name="Invia" value="Invia" /> <input type="reset" name="Cancella" value="Cancella" />
						</fieldset>

					</form> 
				</div>
			<?
				include "../include/footer.txt";
			?>
			</div>
	</body>

</html>
