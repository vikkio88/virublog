<?php
	/*
	 * 
	 * CSSdirnavigator
	 * 
	 * */
	
	include "../include/function.php";
	echo "Css in css dir:\n";
	$cssarray=ls("*.css","./css",true);
	$i=0;
	foreach ($cssarray as $css)
	{
		echo "name: " .$css." --id--> ".$i."\n";
		$i++;
	}
	echo "*******************\n";
	echo "EOC! = End Of Css!\n";
	echo "*******************\n";
?>
