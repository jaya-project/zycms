<?php 

function printCurrentDirRecursively($originDirectory, $printDistance=0){
     
	 
     // just a little html-styling
     if($printDistance==0)echo '<div style="color:#35a; font-family:Verdana; font-size:11px;">';
     $leftWhiteSpace = "";
     for ($i=0; $i < $printDistance; $i++)  $leftWhiteSpace = $leftWhiteSpace."&nbsp;";
     
	
     
     $CurrentWorkingDirectory = dir($originDirectory);
     while($entry=$CurrentWorkingDirectory->read()){
         if($entry != "." && $entry != ".."){
             if(is_dir($originDirectory."\\".$entry)){
                 // echo $leftWhiteSpace."<b>".$entry."</b><br>\n";
                 printCurrentDirRecursively($originDirectory."\\".$entry, $printDistance+2);
              }
             else{
				 $extend = substr($entry, strrpos($entry, '.')+1);
				 if ($extend == 'php') {
					 if (isDangerFile($originDirectory."\\".$entry)) {
						 echo $originDirectory."\\".$entry."<br> <hr />\n";
					 }
				 }
				 
                 // echo $leftWhiteSpace.$entry."<br>\n";
             }
         }
     }
     $CurrentWorkingDirectory->close();
     
     if($printDistance==0)echo "</div>";
	
 }
 
 function isDangerFile($filename) {
	  preg_match_all('~.*\beval\b\(.*~i', file_get_contents($filename), $matches);
	  if (empty($matches[0][0])) {
		  return false;
	  } else {
		  echo $matches[0][0]. '<br />';
		  return true;
	  }
 }
 
 // var_dump(findIsExistsPhp('config_update.php'));

//TEST IT!
printCurrentDirRecursively(getcwd());
