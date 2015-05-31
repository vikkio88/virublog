<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php
include "./include/function.php";
include "./template.php";
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

		echo "</div>";
	echo "</div>";


	echo "<div id=\"left_side\">";

		$vettore=ls("*","./db/",false);
	$lungh_array= count($vettore);
	$text="";
	$trovati=array();
	$cercato=/*"Sono";*/htmlspecialchars($_GET['cer']);
	$xss=false;
	
	//controlli sulla stringa cercata:
	if (strlen($cercato)<=3){
		log_ip("searched tiny=> $cercato");
		$cercato="";
	}
	if ((stristr($cercato,"&lt;"))) 
	{
			$xss=true;
			log_ip("***XSStry=> $cercato");
			$cercato="";
	}
	
	if(is_numeric($cercato)){
			$cercato="";
	}
	
	
	
	if (!($cercato=="")){
		for($i=0;$i<$lungh_array;++$i){
			//$i=1;
			$f=fopen("./db/".$vettore[$i],"r");	
			$text.=fgets($f);
			fclose($f);
			//regexp per pulire il testo dai tag
			$text=preg_replace('/<(.+?)>/'," ",$text);
			if (stristr($text,$cercato))
			{
				array_push($trovati,$i);
			}
			$text="";
		}	
		$numf=count($trovati);
		echo "<div style=\"padding: 4px; font-size: 1.1em;\">";
			if ($numf) {
			//print_r($trovati);
			echo "Founded <strong>$numf</strong> posts with your search key...<br />";
			if ($xss) echo "<strong>I think that you are a little more idiot than i hoped lamah! do you think htmlspecialchars doesnt exist? :D your ip was logged f*c*ing n00b xD!</strong>";
			echo "<ul>";
				foreach($trovati as $id) {
					$f=fopen("./db/".$vettore[$id],"r");	
					$text=fgets($f);
					fclose($f);
					echo "<li>".get_title($text,false)."</li>";
				}
				echo "</ul>";
			}else
				echo "No posts with search key founds on db!<br />";
				if ($xss) echo "<strong>I think that you are a little more idiot than i hoped lamah! do you think htmlspecialchars doesnt exist? :D your ip was logged f*c*ing n00b xD!</strong>";
		echo "</div>";
	} else{
		echo "<div style=\"padding: 4px; font-size: 1.1em;\">";
		echo "No correct search param<br />";
		if ($xss) echo "<strong>I think that you are a little more idiot than i hoped lamah! do you think htmlspecialchars doesnt exist? :D your ip was logged f*c*ing n00b xD!</strong>";
		echo "</div>";
		}
echo "</div>";

include "./include/footer.txt";
echo "</div>";
echo "</div>";
echo "</body></html>";

?>
