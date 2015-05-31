<?php
function conta(){
	$ff =fopen("./newsletter.txt","r");
	$i=0;
	while (!feof ($ff))
	{
		$riga = fgets ($ff);
		$i++;
	}
	return ($i-1);
}
echo conta();
?>
