<?
//FUNZIONI IMPORTANTI

//*///---LS---
function ls($pattern="*", $folder="", $recursivly=false, $options=array('return_files','return_folders')) {
    if($folder) {
        $current_folder = realpath('.');
        if(in_array('quiet', $options)) { // If quiet is on, we will suppress the 'no such folder' error
            if(!file_exists($folder)) return array();
        }
        
        if(!chdir($folder)) return array();
    }
    
    
    $get_files    = in_array('return_files', $options);
    $get_folders= in_array('return_folders', $options);
    $both = array();
    $folders = array();
    
    // Get the all files and folders in the given directory.
    if($get_files) $both = glob($pattern, GLOB_BRACE + GLOB_MARK);
    if($recursivly or $get_folders) $folders = glob("*", GLOB_ONLYDIR + GLOB_MARK);
    
    //If a pattern is specified, make sure even the folders match that pattern.
    $matching_folders = array();
    if($pattern !== '*') $matching_folders = glob($pattern, GLOB_ONLYDIR + GLOB_MARK);
    
    //Get just the files by removing the folders from the list of all files.
    $all = array_values(array_diff($both,$folders));
        
    if($recursivly or $get_folders) {
        foreach ($folders as $this_folder) {
            if($get_folders) {
                //If a pattern is specified, make sure even the folders match that pattern.
                if($pattern !== '*') {
                    if(in_array($this_folder, $matching_folders)) array_push($all, $this_folder);
                }
                else array_push($all, $this_folder);
            }
            
            if($recursivly) {
                // Continue calling this function for all the folders
                $deep_items = ls($pattern, $this_folder, $recursivly, $options); # :RECURSION:
                foreach ($deep_items as $item) {
                    array_push($all, $this_folder . $item);
                }
            }
        }
    }
    
    if($folder) chdir($current_folder);
    //echo "LS_called!<br />";
    return $all;
}



//*///---APP_BBCODE---
function app_bbcode($str){
	//SMILES
	$str = str_replace(":)","<img src=\"./img/smilies/smile.gif\" />",$str);
	$str = str_replace(":(","<img src=\"./img/smilies/sad.gif\" />",$str);
	$str = str_replace(":P","<img src=\"./img/smilies/bigrazz.gif\" />",$str);
	$str = str_replace(":D","<img src=\"./img/smilies/biggrin.gif\" />",$str);
	$str = str_replace("XD","<img src=\"./img/smilies/biggrin.gif\" />",$str);
	$str = str_replace("8)","<img src=\"./img/smilies/cool.gif\" />",$str);
	$str = str_replace(":@","<img src=\"./img/smilies/mad.gif\" />",$str);
	$str = str_replace(";)","<img src=\"./img/smilies/wink.gif\" />",$str);
	//End
	$str = str_replace("	", "&nbsp;&nbsp;&nbsp;&nbsp;", $str);
	$str = str_replace("[img]", "<img src=\"", $str);
	$str = str_replace("[/img]", "\" />", $str);
	$str= preg_replace("/\[url\](.*?)\[\/url\]/","<a href=\"".htmlspecialchars("$1")."\">".htmlspecialchars("$1")."</a>", $str);
	$str= preg_replace("/\[url\=(.*?)\](.*?)\[\/url\]/","<a href=\"".htmlspecialchars("$1")."\">".htmlspecialchars("$2")."</a>", $str);
	$str = str_replace("[b]", "<strong>", $str);
	$str = str_replace("[/b]", "</strong>", $str);
	$str = str_replace("[i]", "<i>", $str);
	$str = str_replace("[/i]", "</i>", $str);
	$str = str_replace("[u]", "<u>", $str);
	$str = str_replace("[/u]", "</u>", $str);
	$str = preg_replace ("/\[code\](.*?)\[\/code\]/", "<div class=\"code\">".htmlentities("$1")."</p>", $str);
	$str = preg_replace ("/\[spoiler\](.*?)\[\/spoiler\]/", "<script>
function spoil() {
    var e = document.getElementById('spoiler');
    if (e.style.visibility == 'hidden') {
        e.style.visibility = 'visible';
        e.style.display = 'block';
    } else {
        e.style.visibility = 'hidden';
        e.style.display = 'none';
    }
}
</script>" . '<b>SPOILER</b> (<a href = "javascript: spoil()"><u>click to view</u></a>)<div id = "spoiler" style = "display: none; border: 1px solid;">' . htmlspecialchars("$1") . '</div>', $str);
	//$str = str_replace ("[/spoiler]", "</div>", $str);
	// Aggiungerne altri...
	//Funzione BBCODE youtube...mia! :D
	$str= preg_replace("/\[youtube\](.*?)\[\/youtube\]/","<br /><object width=\"425\" height=\"344\"><param name=\"movie\" value=\"http://www.youtube.com/v/".("$1")."&hl=it_IT&fs=1&\"></param><param name=\"allowFullScreen\" value=\"true\"></param><param name=\"allowscriptaccess\" value=\"always\"></param><embed src=\"http://www.youtube.com/v/".("$1")."&hl=it_IT&fs=1&\" type=\"application/x-shockwave-flash\" allowscriptaccess=\"always\" allowfullscreen=\"true\" width=\"425\" height=\"344\"></embed></object><br />",$str);
	return $str;
}



//*///---IP_LOGGER---
function log_ip($beha="*visit*",$logfile="./logger/visitevirublog.txt"){
$ip = $_SERVER ['REMOTE_ADDR'];

$ora = date ("G:i:s");
$cal = date("d/m/Y");
$ref = htmlspecialchars($_SERVER ['HTTP_REFERER']); 
$userag = htmlspecialchars($_SERVER ['HTTP_USER_AGENT']);

if (file_exists($logfile))
	$fp=fopen($logfile,"a");
else
	$fp=fopen($logfile,"w");
	
fwrite ($fp , $ip . " DATA:".$cal." " .$ora." USERAG:".$userag." REF:".$ref." beha:".$beha."\n");
fclose ($fp);
}

//subsgrave
function subsgrave ($stringa) {
$stringa=str_replace("à", "&agrave;", $stringa);
$stringa=str_replace("è","&egrave;", $stringa);
$stringa=str_replace("ì","&igrave;", $stringa);
$stringa=str_replace("ò","&ograve;", $stringa);
$stringa=str_replace("ù","&ugrave;", $stringa);
$stringa=str_replace("é","&eacute;", $stringa);
$stringa=str_replace("&","&amp;", $stringa);
$stringa=str_replace("μ","&mu;", $stringa);
$stringa=str_replace("\n","<br />", $stringa);
return $stringa;
}

//--Calcellare un file
function filedel($file_nome){
	if (!unlink($file_nome)) {
		return "$PHP_SELF: Errore, impossibile cancellare il file $nome_file";
	} else {
		return "FileDeleteSuccess!";
	}
}

//--Funzione per gettare i titoli dai posts
function get_title($stringa,$dellink=true){	
	if (preg_match("/<div class=\"title\">([^`]*?)<\/div>/", $stringa, $out)){
		$stringa = $out[1];
	}
	if ($dellink){
		$stringa=preg_replace("/<a href='.\/view.php\?id=.+'>/","",$stringa);
		$stringa=preg_replace("/<\/a>/","",$stringa);
	}
	return $stringa;
}




//--Stampa dove viene richiamato la prima pagina del ./db
//--Il cuore di tutto l'engine
function inpagina($vettore1,$lungh_array,$pagina=1,$path="./db/"){
	$offset=($lungh_array-(($pagina-1)*6));
		for ($a=0;$a<$offset;++$a)
			$vettore[$a]=$vettore1[$a];
	
	switch ($offset){
		case 0:
			echo "<h1>It Works!</h1>NoPosts on DB dir!";
			break;
		case 1:
			require($path.$vettore[0]);
			break;
		case 2:
			require($path.$vettore[1]);
			require($path.$vettore[0]);
			break;
		case 3:
			for ($i=2;$i>=0;--$i)
				require($path.$vettore[$i]);
			break;
		case 4:
			for ($i=3;$i>=0;--$i)
				require($path.$vettore[$i]);
			break;
		case 5:
			for ($i=4;$i>=0;--$i)
				require($path.$vettore[$i]);
			break;
		default:
			$j=0;
			$i=1;
			while($j<6){
				require($path.$vettore[$offset-$i]);
				$i++;
				$j++;
			}
	}
}


function curURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}


function lastcomment() {
	echo "  <div class=\"menu_title\">Last Comments</div><ul class=\"navigatore\">";
	
	if (file_exists("./comment/corretti.txt")){
	
		$f=fopen("./comment/corretti.txt","r");
		$test=array();	
		while ((!feof ($f)))
		{
			array_push($test,fgets($f));
		}
		fclose($f);
		$ltest=(count($test))-1;
		$end=($ltest-6);
		if ($end>=0){
			for ($i=$ltest;$i>$end;--$i){
				echo $test[$i];
			}
		}else {
			foreach ($test as $riga){
					echo "$riga";
			}
		 }
	
	}else{
	echo "<li>No comment</li>";
	}
	echo "</ul>";
}

?>
