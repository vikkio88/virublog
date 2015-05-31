<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php
include "./include/function.php";
include "./template.php";

$vettore=ls("*","./db/",false);
$lungh_array= count($vettore);
$post=(int)$_GET['id'];
$old=false;

if(($post<=0)||(!(is_numeric($post)))){
	 $post=($lungh_array-1);
}

if ($post>($lungh_array-1)){
		if (!(in_array($post,$vettore))){
			$post=($lungh_array-1);
			$old=true;
		}else {
					$old=false;
		}
}
if (!($old))
	$f1=fopen("./db/".$vettore[$post],"r");
else
	$f1=fopen("./db/".$post,"r");
$output=fgets($f1, 4096);
fclose ($f1);
$title=get_title($output);
//$morphtitle=str_replace(" ","_",$title);
echo "<head>
		<meta name=\"Robots\" content=\"INDEX,FOLLOW\" />
		<meta name=\"language\" content=\"it\" />
		<link rel=\"SHORTCUT ICON\" href=\"./img/favicon.ico\"/>
		<title>".$title."</title>
		<link href=\"./grafica/".$filecssname."\" rel=\"stylesheet\" type=\"text/css\" />
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
if (!($post>12000))
	require("./db/".$vettore[$post]);
else 
	require ("./db/".$post);
$questo= curURL();
echo "<div class=\"sinistra\">";
echo "condividi:";
print "
<ul>
<li><a href=\"http://www.google.com/buzz/post?url=".$questo."&message=$title&type=normal-count\" title=\"Aggiungi su GoogleBuzz\" rel=\"nofollow\" class=\"image\" target=\"_blank\"><img src=\"./grafica/img/buzz.png\" alt=\"Aggiungi su Buzz\"></a></li>
<li><a href=\"http://myweb2.search.yahoo.com/myresults/bookmarklet?u=".$questo."\" title=\"Aggiungi su Yahoo\" rel=\"nofollow\" class=\"image\" target=\"_blank\"><img src=\"./grafica/img/yahoo.png\" alt=\"Aggiungi su Yahoo\"></a></li>
<li><a href=\"http://www.facebook.com/sharer.php?u=".$questo."\" title=\"Aggiungi su Facebook\" rel=\"nofollow\" class=\"image\" target=\"_blank\"><img src=\"./grafica/img/facebook.png\" alt=\"Aggiungi su Facebook\"></a></li>
<li><a href=\"http://twitter.com/home?status=".$questo."\" title=\"Aggiungi su Twitter\" rel=\"nofollow\" class=\"image\" target=\"_blank\"><img src=\"./grafica/img/twitter.png\" alt=\"Aggiungi su Twitter\"></a></li>
</ul>
";

echo "</div>";
if (($old)){
echo "<div style=\"padding: 1px; border: solid 1px\">";
echo "<strong>Commenti:</strong><br />";
	if (file_exists(("./commentsdb/".$post)))
		include("./commentsdb/".$post);
	else
		echo "No comment for this post =(<br />";
echo "</div><a name=\"commentend\"></a>";
echo "<a href=\"./comment/scrivi.php?id=$post\" title=\"commenta\"><strong>Aggiungi un commento</strong></a>";
}
echo "</div>";
include "./include/footer.txt";
echo "</div>";
echo "</body></html>";



?>
