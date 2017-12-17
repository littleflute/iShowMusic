<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=cat";

if($right<3){
   adminmsg('对不起，你没有权限进行此操作');
   exit;
 }

$catdata=file(R_P."$datadir/cat.php");
$count=count($catdata);

function getcat() {
    global $datadir;
    $list=file(R_P."$datadir/cat.php");
	$count=count($list);
	echo "-->\n";
	for($i=0; $i<$count; $i++) {
	$detail=explode("|",$list[$i]);
	  echo "<OPTION VALUE=\"$detail[0]\">$detail[1]</OPTION>\n";
	}
	echo "<!--";
}

if (empty($action)){
       include PrintEot('cat');
	   exit;
	   
}elseif ($_POST['action']=="newcat"){
       unset($temp);
	   $newstring="";
	   $name=str_replace("|","",$name); 
	   $name=stripslashes($name);
	   $max=0;
		for ($i=0; $i<$count; $i++) {
			$temp=explode("|",$catdata[$i]);
			$max=max($max,$temp[0]);
		}
		$id=$max+1;		
		$newstring="$id|$name|$timestamp\n"; 
		writeto(R_P."$datadir/cat.php",$newstring,'a+'); 
	    adminmsg('完成相应操作');
		
}elseif ($_POST['action']=="editcat"){
        unset($temp);
		$name=str_replace("|","",$name); 
	    $name=stripslashes($name);
		for ($i=0; $i<$count; $i++) {
		  $temp=explode("|",$catdata[$i]);
			if($temp[0]==$cat){ 
		      $temp[1]=$name;
              $catdata[$i]="$cat|$name|$timestamp\n";
		     break;
			 }
		}
		$newstring=implode("",$catdata);
	    writeto(R_P."$datadir/cat.php",$newstring);				        
	    adminmsg('完成相应操作');
		
}elseif ($_POST['action']=="delcat"){
        unset($temp);
		for ($i=0; $i<$count; $i++) {
			$temp=explode("|",$catdata[$i]);
			if($temp[0]==$cat){ 		 
             unset($catdata[$i]);
		     break;}			
		}
		$newstring=implode("",$catdata);
	    writeto(R_P."$datadir/cat.php",$newstring);				        
					        
	   unset($temp);
	   $singerdata=file(R_P."$datadir/cat.php");	
	   $scount=count($singerdata);			        
	   for ($i=0; $i<$scount; $i++) {
			$temp=explode("|",$singerdata[$i]);
			if($temp[0]==$cat)  unset($singerdata[$i]);	
		}
		$newstring=implode("",$singerdata);
	    writeto(R_P."$datadir/singer.php",$newstring);		
		adminmsg('完成相应操作');
}
?>