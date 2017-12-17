<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=addmusic";

function showsinger() {
    global $datadir;
	$list=file(R_P."$datadir/singer.php");
	$count=count($list);
	echo "-->\n";
	for ($i=0; $i<$count; $i++) {
    $detail=explode("|",$list[$i]);
		echo "subcat[$i] = new Array(\"$detail[2]\",\"$detail[0]\",\"$detail[1]\");\n";
	}
	echo "onecount=$count;\n";
	echo "<!--";
}

function showcat() {
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
       include PrintEot('addmusic');
	   exit;
}elseif ($_POST['action']=="save"){
    	$songname=stripslashes($songname); 
		$songurl=stripslashes($songurl);
		$songname=safeconvert($songname);
		$songurl=safeconvert($songurl);
		if (file_exists(R_P."$datadir/list.php")) {
			$file=readfrom(R_P."$datadir/list.php");			
			$filename=get_next_filename($file);
		}
		else $filename="1";
		$newlist=$catid."|".$singerid."|".$filename."|".$songname."|".$timestamp."|\n";
		if (isset($file)) $newlist.=$file;
		writeto(R_P."$datadir/list.php",$newlist); 
		
		if($from=="usercom"){
		  text_delete(R_P."$datadir/usercom.php",$d,"|","5");
		}
		
		if($commend=='yes') {
			if (file_exists(R_P."$datadir/commend.php")) $filecommend=readfrom(R_P."$datadir/commend.php");	
			if (isset($filecommend)) $commendlist.=$filecommend;
			writeto(R_P."$datadir/commend.php",$newlist); 
		}
		
		$id_line=array($catid,$singerid,$songname,$songurl,$hot,$commend,$timestamp,);
		$line=implode("|",$id_line)."|\n";
        $line="<? exit;?>\n".$line;
		writeto(R_P."$datadir/data/$filename.php",$line);
        
        @extract($GLOBALS, EXTR_SKIP);		
		if($_FILES['fileup']['tmp_name']==""){
		   $upload_file=$_FILES['fileup']['tmp_name'];
           $upload_filename=$_FILES['fileup']['name'];
           $ext = strtolower(strrchr($upload_filename,'.'));
           $lrcname=$filename.".lrc";
		   if($ext==".lrc"){
              @move_uploaded_file ($upload_file,$datadir."/lrc/".$lrcname); 
			}
			else { adminmsg('音乐成功添加，歌词文件未上传'); exit; }
		}
		
	    adminmsg('完成相应操作');
}
?>