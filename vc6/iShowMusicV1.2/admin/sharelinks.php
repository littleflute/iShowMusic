<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=sharelinks";

if (!$action){
function get_sharelinks_list($page){
global $datadir,$perpage,$basename;

       if(empty($page) or $page<=0) $page=1;
       settype($page, integer);
	   
       $sharelink_list=file(R_P."$datadir/sharelinks.php");
	   $count=count($sharelink_list);
	   $list_info="";
	   echo "-->\n";
	   if($count!=0){
	      if ($count%$perpage==0) $maxpageno=$count/$perpage;
		    else $maxpageno=floor($count/$perpage)+1;
	      if ($page>$maxpageno) $page=$maxpageno;
	        $pagemin=min( ($page-1)*$perpage , $count-1);
	        $pagemax=min( $pagemin+$perpage-1, $count-1);
			
			for ($i=$pagemin; $i<=$pagemax; $i++) {
	           $detail=explode("|",$sharelink_list[$i]);
			   $j=$i+1;
               $addtime=date("Y.m.d H:i",$detail[2]);
			   $showname = $detail[1] =="iShow Music" ? "$detail[1]" : "<a href=\"$basename&action=edit&lid=$detail[2]\">$detail[1]</a>";
			   $showcheckbox = $detail[1] =="iShow Music" ? "<input type='checkbox' name='delID[]' value=\"$detail[2]\" onclick=\"this.disabled=true;\">" : "<input type='checkbox' name='delID[]' value=\"$detail[2]\">";
			   
			   $list_info.="<tr class=bg><td width=\"5%\" height=25 align=\"center\">$j</td><td width=\"20%\" height=25 align=\"center\">$showname</td><td align=\"center\" width=\"30%\"><a href=\"$detail[3]\" target=_blank>$detail[3]</a></td><td width=\"36%\" align=\"center\">$detail[4]</td><td width=\"5%\" align=\"center\">$showcheckbox</td></tr>\n";
	       }
		  echo $list_info;
	   }
	   else{
	       $list_info.="<tr class=bg><td colspan=5>暂时还没有链接列表信息</td></tr>";
		   echo $list_info;
	   }
	   $pageurl="$basename&";
       PageNav($maxpageno,$count,$page,$pageurl,5);
	   echo "<!--";
}
	include PrintEot('sharelinks');exit;
} elseif ($action=="add"){
	if(!$_POST['step']){
		include PrintEot('sharelinks');exit;
	} elseif (!$name || !$url) {
		adminmsg('操作失败，请检查数据完整性');
	} else{
		$name    = Char_cv($name);
		$url     = Char_cv($url);
		$descrip = Char_cv($descrip);
		$logo    = Char_cv($logo);
		$share_line="<? die();?>|$name|$timestamp|$url|$descrip|$logo|\n";
		writeto(R_P."$datadir/sharelinks.php",$share_line,"a+");
		adminmsg('完成相应操作');
	}
} elseif($action=="edit"){
	if(!$_POST['step']){
	   $sharelist=file(R_P."$datadir/sharelinks.php");
	   $count=count($sharelist);
	   for($i=0;$i<=$count;$i++){
	      $detail=explode("|",$sharelist[$i]);
		  if($lid == $detail[2]){
		    $name        = $detail[1];
			$url         = $detail[3];
			$descrip     = $detail[4];
			$logo        = $detail[5];
		   }
		 }
		include PrintEot('sharelinks');exit;
	} else{
		$name    = Char_cv($name);
		$url     = Char_cv($url);
		$descrip = Char_cv($descrip);
		$logo    = Char_cv($logo);
		$newlist="<? die();?>|$name|$timestamp|$url|$descrip|$logo|\n";
		text_modify(R_P."$datadir/sharelinks.php",$lid,"|","2",$newlist);
		adminmsg('完成相应操作');
	}
} elseif($action=="del"){
    $delid = $_POST['delID'];
	foreach ( (array) $delid as $id) {
	 text_delete(R_P."$datadir/sharelinks.php","$id","|","2");
	}
	adminmsg('完成相应操作');
}
?>