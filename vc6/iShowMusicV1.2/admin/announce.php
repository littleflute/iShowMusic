<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=announce";

function get_announce_list($page){
global $datadir,$perpage,$basename;

       if(empty($page) or $page<=0) $page=1;
       settype($page, integer);
	   
       $announcelist=file(R_P."$datadir/announce.php");
	   $count=count($announcelist);
	   $list_info="";
	   echo "-->\n";
	   if($count!=0){
	      if ($count%$perpage==0) $maxpageno=$count/$perpage;
		    else $maxpageno=floor($count/$perpage)+1;
	      if ($page>$maxpageno) $page=$maxpageno;
	        $pagemin=min( ($page-1)*$perpage , $count-1);
	        $pagemax=min( $pagemin+$perpage-1, $count-1);
			
			for ($i=$pagemin; $i<=$pagemax; $i++) {
	           $detail=explode("|",$announcelist[$i]);
			   $j=$i+1;
               $pubtime=date("Y.m.d H:i",$detail[2]);
			   $list_info.="<tr class=bg><td width=\"5%\" height=25 align=\"center\">$j</td><td width=\"15%\" align=\"center\">$detail[1]</td><td align=\"center\"><a href=\"$basename&aid=$detail[2]&action=edit\">$detail[3]</a></td><td width=\"25%\" align=\"center\">$pubtime</td><td width=\"5%\" align=\"center\"><input type=\"checkbox\" name=\"delID[]\" value=\"$detail[2]\"></td></tr>\n";
	       }
		  echo $list_info;
	   }
	   else{
	       $list_info.="<tr class=bg><td colspan=5>暂时还没有公告信息</td></tr>";
		   echo $list_info;
	   }
	   $pageurl="$basename&";
       PageNav($maxpageno,$count,$page,$pageurl,5);
	   echo "<!--";
}

if (!$action){
	include PrintEot('announce');exit();
} elseif($action=='add'){
	if (!$_POST['step']){
    	include PrintEot('announce');exit();
	} else {
		if (!$newsubject || !$atc_content){
			adminmsg('操作失败，请检查数据完整性');
		}
		$newsubject  = ieconvert($newsubject);
		$atc_content = ieconvert($atc_content);
		$atc_content = trim($atc_content);
		$atc_line="<? die();?>|$adminuser|$timestamp|$newsubject|$atc_content\n";
		writeto(R_P."$datadir/announce.php",$atc_line,"a+");
		adminmsg('完成相应操作');
	}
} elseif ($action=='edit'){
 	if (!$_POST['step']){
	   $announcelist=file(R_P."$datadir/announce.php");
	   $count=count($announcelist);
      
	   for($i=0;$i<=$count;$i++){
	      $detail=explode("|",$announcelist[$i]);
		  if($aid==$detail[2]){
		   HtmlConvert($detail[3]);$subject=$detail[3];
		   HtmlConvert($detail[4]);$atc_content=$detail[4];
		   }
		}
	include PrintEot('announce');exit();
	} else{
		!is_numeric($vieworder) && $vieworder=0;
		$newsubject  = ieconvert($newsubject);
		$atc_content = ieconvert($atc_content);
		$atc_content = trim($atc_content);
		$newlist="<? die();?>|$adminuser|$timestamp|$newsubject|$atc_content\n";
		text_modify(R_P."$datadir/announce.php",$aid,"|","2",$newlist);
		adminmsg('完成相应操作');
	}

} elseif ($action=='del'){
    $delid = $_POST['delID'];
	foreach ( (array) $delid as $id) {
	 text_delete(R_P."$datadir/announce.php","$id","|","2");
	}
	adminmsg('完成相应操作');
}
?>