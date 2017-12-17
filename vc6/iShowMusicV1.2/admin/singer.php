<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=singer";

if($right<3){
   adminmsg('对不起，你没有权限进行此操作');
   exit;
 }

$singerdata=file(R_P."$datadir/singer.php");
$singercount=count($singerdata);

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

function getsinger() {
    global $datadir;
	$list=file(R_P."$datadir/singer.php");
	$count=count($list);
	echo "-->\n";
	for ($i=0; $i<$count; $i++) {
    $detail=explode("|",$list[$i]);
		echo "<OPTION VALUE=\"$detail[1]\">$detail[2]</OPTION>\n";
	}
	echo "<!--";
}

if (empty($action)){
       include PrintEot('singer');
	   exit;
	   
}elseif ($_POST['action']=="newsinger"){
       unset($temp);
	   unset($newstring);
	   $newstring="";
	   $name=str_replace("|","",$name); 
	   $name=stripslashes($name);
	   $max=0;
		for ($i=0; $i<$singercount; $i++) {
			$temp=explode("|",$singerdata[$i]);
			$max=max($max,$temp[1]);
		}
		$id=$max+1;		
		$newstring="$cat|$id|$name|$timestamp\n"; 
		writeto(R_P."$datadir/singer.php",$newstring,'a+'); 
	    adminmsg('完成相应操作');
		
}elseif ($_POST['action']=="editsinger"){
        unset($temp);
		unset($newstring);
		$name=str_replace("|","",$name); 
	    $name=stripslashes($name);
		for ($i=0; $i<$singercount; $i++) {
		  $temp=explode("|",$singerdata[$i]);
			if($temp[1]==$singer){ 
		      $temp[2]=$name;
              $singerdata[$i]="$temp[0]|$singer|$name|$timestamp\n";
		     break;
			 }
		}
		$newstring=implode("",$singerdata);
	    writeto(R_P."$datadir/singer.php",$newstring);				        
	    adminmsg('完成相应操作');
		
}elseif ($_POST['action']=="delsinger"){
        unset($temp);
		unset($newstring);
        if($job=='delall'){
		 $comdata=file(R_P."$datadir/commend.php");
		 $comcount=count($comcount);
		 for ($i=0; $i<$comcount; $i++) {
			$temp=explode("|",$comdata[$i]);
			if($temp[1]==$singer) unset($comdata[$i]);	
			}
         $newstring=implode("",$comdata);
	     writeto(R_P."$datadir/commend.php",$newstring);
		 
		 $hotdata=file(R_P."$datadir/hot.php");
		 $hotcount=count($hotcount);
		 for ($i=0; $i<$hotcount; $i++) {
			$temp=explode("|",$hotdata[$i]);
			if($temp[1]==$singer) unset($hotdata[$i]);	
			}
         $newstring=implode("",$hotdata);
	     writeto(R_P."$datadir/hot.php",$newstring);
		 
		 unset($temp);
		 unset($newstring);
		 $list_temp=explode("\n",readfrom(R_P."$datadir/list.php"));
		 $list_count=count($list_temp);
		 for ($i=0; $i<$list_count; $i++) {
	        $list_info=explode("|",$list_temp[$i]);
	        if ($list_info[1]==$singer){
		       if (file_exists(R_P."$datadir/data/$list_info[2].php")) unlink(R_P."$datadir/data/$list_info[2].php");
		       unset($list_temp[$i]);
	                }
	            }
          writeto(R_P."$datadir/list.php",implode("\n",$list_temp));
		  
		  unset($temp);
		  unset($newstring);
		  for ($i=0; $i<$singercount; $i++) {
			$temp=explode("|",$singerdata[$i]);
			if($temp[1]==$singer){ 		 
               unset($singerdata[$i]);
		       break;}			
		   }
		  $newstring=implode("",$singerdata);
	      writeto(R_P."$datadir/singer.php",$newstring);		
		  adminmsg('完成相应操作');
		}
		
		elseif($job=="del"){
		  unset($temp);
		  unset($newstring);
		  for ($i=0; $i<$singercount; $i++) {
			$temp=explode("|",$singerdata[$i]);
			if($temp[1]==$singer){ 		 
               unset($singerdata[$i]);
		       break;}			
		     }
		   $newstring=implode("",$singerdata);
	       writeto(R_P."$datadir/singer.php",$newstring);		
		   adminmsg('完成相应操作');
		}
		
}elseif ($_POST['action']=="editorder"){
		unset($temp);
		unset($newstring);
		for ($i=0; $i<$singercount; $i++) {
			$temp=explode("|",$singerdata[$i]);
			if($temp[1] != $singer) $newstring.=$singerdata[$i];
		    if($temp[1] == $singer2){
			  for ($j=0; $j<$singercount; $j++) {
	           $temp2=explode("|",$singerdata[$j]);
	           if ($temp2[1]==$singer) $newstring.=$singerdata[$j];
	           }
            }
		}
	    writeto(R_P."$datadir/singer.php",$newstring);		
		adminmsg('完成相应操作');
}
?>