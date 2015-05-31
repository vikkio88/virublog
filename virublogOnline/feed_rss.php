<?php
include "./include/function.php";
function ascizza($stringa){
	$stringa=str_replace("&egrave;", "è", $stringa);
	$stringa=str_replace("&agrave;", "à", $stringa);
	$stringa=str_replace("&igrave;", "ì", $stringa);
	$stringa=str_replace("&ograve;", "ò", $stringa);
	$stringa=str_replace("&ugrave;", "ù", $stringa);
	/*/$stringa=str_replace("^", "&#94;", $stringa);
	$stringa=str_replace("?", "&#63;", $stringa);
	$stringa=str_replace("@", "&#64;", $stringa);
	$stringa=str_replace("!", "&#33;", $stringa);
	$stringa=str_replace("\"", "&#34;", $stringa);
	$stringa=str_replace("&", "&#38;", $stringa);
	$stringa=str_replace("*", "&#42;", $stringa);
	$stringa=str_replace("%", "&#37;", $stringa);
	$stringa=str_replace("<", "&#60;", $stringa);
	$stringa=str_replace(">", "&#62;", $stringa);
	$stringa=str_replace("'", "&#39;", $stringa);
	$stringa=str_replace("$", "&#36;", $stringa);//*/
	return $stringa;
}
$vettore=ls("*","./db/",false);
$lung=$max=count($vettore);
if ($max>20) $max=20;
header("Content-type: text/xml; charset=utf-8");
echo ("<rss version=\"2.0\">");
echo ("<channel>");
echo ("<title> Virublog RSSFeed! </title>");
echo("<link></link>");
echo ("<description> A simple feed of virublog</description>");
echo "<copyright> Copyleft 2010 Vincenzo vikkio88 Ciaccio </copyright>\n";
echo "<docs>http://blogs.law.harvard.edu/tech/rss</docs>\n";
echo "<managingEditor></managingEditor>\n";
echo "<webMaster>vikkio88@yahoo.it</webMaster>\n";
echo ("<language>IT-it</language>");
$indicizzati=0;
$lung-=1;
while($indicizzati<$max){
	$f1=fopen("./db/".$vettore[$lung],"r");
			$output=fgets($f1, 4096);
		fclose ($file);
$titolo= get_title($output);
$titolo=ascizza($titolo);
echo "
<item>
<title>$titolo</title>
<link>./view.php?id=$lung</link>
<description>post id-> $lung</description>
<category domain=\"virublog.altervista.org\">virublogposts</category>
</item>
";
$lung--;
$indicizzati++;
}
echo"
</channel>
</rss>
";
?>
