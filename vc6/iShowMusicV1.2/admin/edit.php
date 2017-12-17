<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=edit";

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
    global $datadir,$catid;
    $list=file(R_P."$datadir/cat.php");
	$count=count($list);
	echo "-->\n";
	for($i=0; $i<$count; $i++) {
	$detail=explode("|",$list[$i]);
	if($catid==$detail[0])
		echo "<OPTION VALUE=\"$detail[0]\" selected>$detail[1]</OPTION>\n";
    else echo "<OPTION VALUE=\"$detail[0]\" >$detail[1]</OPTION>\n";
	}
	echo "<!--";
}

function get_music_list($page){
global $datadir,$perpage,$basename;

       if(empty($page) or $page<=0) $page=1;
       settype($page, integer);
	   
       $mlist=file(R_P."$datadir/list.php");
	   $count=count($mlist);
	   $list_info="";
	   echo "-->\n";
	   if($count!=0){
	      if ($count%$perpage==0) $maxpageno=$count/$perpage;
		    else $maxpageno=floor($count/$perpage)+1;
	      if ($page>$maxpageno) $page=$maxpageno;
	        $pagemin=min( ($page-1)*$perpage , $count-1);
	        $pagemax=min( $pagemin+$perpage-1, $count-1);
			
			for ($i=$pagemin; $i<=$pagemax; $i++) {
	           $detail=explode("|",$mlist[$i]);
               $pubtime=date("Y.m.d H:i",$detail[4]);
			   $list_info.="<tr class=bg><td width=\"10%\" height=25 align=\"center\">$detail[2]</td><td width=\"62%\"><a href=\"play.php?id=$detail[2]\" target=_blank>$detail[3]</td><td width=\"18%\" align=\"center\">$pubtime</td><td width=\"5%\" align=\"center\"><a href=\"$basename&editID=$detail[2]&action=edit\">编辑</a></td><td width=\"5%\" align=\"center\"><input type=\"checkbox\" name=\"delID[]\" value=\"$detail[2]\"></td></tr>\n";
	       }
		  echo $list_info;
	   }
	   else{
	       $list_info.="<tr class=bg><td colspan=5>暂时还没有音乐列表信息</td></tr>";
		   echo $list_info;
	   }
	   $pageurl="$basename&";
       PageNav($maxpageno,$count,$page,$pageurl,5);
	   echo "<!--";
}

if (empty($action)){
       include PrintEot('edit');
	   exit;
	   
}elseif ($action=="edit"){
	 if(empty($editID) || !file_exists(R_P."$datadir/data/$editID.php")) { 
		adminmsg('此音乐不存在，可能已被删除');
		exit;}
	 $info=@file(R_P."$datadir/data/$editID.php");
	 list($catid,$singerid,$songname,$songurl,$hot,$commend,$pubtime)=explode("|",$info[1]);
	 $statlist=explode("|",$info[2]);
	 $s_list[2]=implode("|",$statlist);

     if(!$step){
		 get_catid($catid);
         get_singerid($catid,$singerid);
		 if($hot==1) $show_1hot='selected';
           elseif($hot==2) $show_2hot='selected';
           elseif($hot==3) $show_3hot='selected';
           elseif($hot==4) $show_4hot='selected';
           elseif($hot==5) $show_5hot='selected';
        if($commend=="yes") $show_1commend='selected'; else $show_2commend='selected';
        include PrintEot('edit');
	    exit;
	    }
	    elseif($step=='2'){
        $song_name=stripslashes($song_name); 
		$song_url=stripslashes($song_url);
		$song_name=safeconvert($song_name);
		$song_url=safeconvert($song_url);
		$catid=$_POST['catid'];
		$singerid=$_POST['singerid'];
		$newlist=$catid."|".$singerid."|".$editID."|".$song_name."|".$timestamp."|\n";
		$commendlist=$newlist;
		text_modify(R_P."$datadir/list.php",$editID,"|","2",$newlist);
		
		if($commend=="yes" && $newcommend=='yes'){
		   text_modify(R_P."$datadir/commend.php",$editID,"|","2",$newlist);
		  }elseif($commend=="no" && $newcommend=='yes'){
              $filecommend=readfrom(R_P."$datadir/commend.php");	
			   if (isset($filecommend)) $commendlist.=$filecommend;
			   writeto(R_P."$datadir/commend.php",$commendlist);
		 }elseif($commend=="yes" && $newcommend=='no'){
		   text_delete(R_P."$datadir/commend.php",$editID,"|","2");
		  }
		$id_line=array($catid,$singerid,$song_name,$song_url,$newhot,$newcommend,$pubtime);
		$line=implode("|",$id_line);
        $linee="<? exit;?>\n $line $s_list[2]";
		writeto(R_P."$datadir/data/$editID.php",$linee);
		@extract($GLOBALS, EXTR_SKIP);
		
		  if($_FILES['fileup']['tmp_name']==""){
		   $upload_file=$_FILES['fileup']['tmp_name'];
           $upload_filename=$_FILES['fileup']['name'];
           $ext = strtolower(strrchr($upload_filename,'.'));
           $lrcname=$editID.".lrc";
		   if($ext==".lrc"){
              @move_uploaded_file ($upload_file,$datadir."/lrc/".$lrcname); 
			}
			else { adminmsg('音乐成功修改，但歌词文件不是LRC文件'); exit; }
		   }
           adminmsg('完成相应操作');
	    }
		
}elseif($action=='del'){
    $delID = $_POST['delID'];
	foreach ( (array) $delID as $ID) {
	 unlink(R_P."$datadir/data/$ID.php");
	 if(file_exists(R_P.$datadir."/lrc/$ID.lrc")) unlink(R_P.$datadir."/lrc/$ID.lrc");
	 text_delete(R_P."$datadir/list.php","$ID","|","2");
	 text_delete(R_P."$datadir/commend.php","$ID","|","2");
	 text_delete(R_P."$datadir/viewhot.php","$ID","|","2");
	 text_delete(R_P."$datadir/downhot.php","$ID","|","2");
	}
	adminmsg('完成相应操作');
}
?>