<?php
include "../include/function.php";
include "./template.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
		<title>Virublog-Guestbook$</title>
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
				Virublog-Guestbook
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
			 <strong>Guestbook</strong><br />
				<a href="./scrivi.php" title="Scrivi nel Guestbook"><strong>Scrivi nel Guestbook</strong></a><br />
				 <p>Ecco a voi il mio guestbook basato sull'engine di viRublog</p>
					<?php
						$pagina=(int)($_GET['p']);
						if(($pagina<1)||(!(is_numeric($pagina)))) $pagina=1;
						$vettore=ls("*","./data/",false);
						$lungh_array= count($vettore);
						$pathdata="./data/";
						
						$paginegen=(int)($lungh_array/6);
						if (($lungh_array%6)>0) $paginegen=($paginegen+1);
						if($pagina>$paginegen) $pagina=1;
						inpagina($vettore,$lungh_array,$pagina,$pathdata);
						
						echo "<div class=\"sinistra\">".$lung_array."go to page:";
						for ($i=1;$i<=$paginegen;++$i){
										if ($pagina==$i)
											echo "$i &gt; ";
										else
											echo "<a href='./guestbook.php?p=".$i."'>".$i."</a> &gt; ";
						}
						echo "</div>";
					?>
			</div>
			<?
				include "../include/footer.txt";
			?>
			</div>
	</body>

</html>
