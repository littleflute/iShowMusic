<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=usercom";

function get_com_list($page){
global $datadir,$perpage,$basename;

       if(empty($page) or $page<=0) $page=1;
       settype($page, integer);
	   
       $comlist=file(R_P."$datadir/usercom.php");
	   $count=count($comlist);
	   $list_info="";
	   echo "-->\n";
	   if($count!=0){
	      if ($count%$perpage==0) $maxpageno=$count/$perpage;
		    else $maxpageno=floor($count/$perpage)+1;
	      if ($page>$maxpageno) $page=$maxpageno;
	        $pagemin=min( ($page-1)*$perpage , $count-1);
	        $pagemax=min( $pagemin+$perpage-1, $count-1);
			
			for ($i=$pagemin; $i<=$pagemax; $i++) {
	           $detail=explode("|",$comlist[$i]);
               $comtime=date("Y.m.d H:i",$detail[5]);
			   $list_info.="<tr class=bg><td width=\"10%\" height=25 align=\"center\">$detail[0]</td><td width=\"15%\" align=\"center\">$detail[1]</td><td width=\"10%\" align=\"center\">$detail[2]</td><td width=\"35%\" align=\"center\"><a href=\"$detail[4]\" target=_blank>$detail[4]</td><td width=\"15%\" align=\"center\">$comtime</td><td width=\"5%\" align=\"center\"><a href=\"javascript:playmedia('mediaplayer','".urlencode($detail[4])."')\">试听</a></td><td width=\"5%\" align=\"center\"><a href=\"admin.php?adminjob=addmusic&from=usercom&d=$detail[5]&songname=".urlencode($detail[1])."&songurl=".urlencode($detail[4])."\">通过</a></td><td width=\"5%\" align=\"center\"><input type=\"checkbox\" name=\"delid[]\" value=\"$detail[5]\"></td></tr>\n";
	        }
		  echo $list_info;
	   }
	   else{
	       $list_info.="<tr class=bg><td colspan=7>暂时还没有用户推荐列表信息</td></tr>";
		   echo $list_info;
	   }
	   $pageurl="$basename&";
       PageNav($maxpageno,$count,$page,$pageurl,8);
	   echo "<!--";
}

if (empty($action)){

       include PrintEot('usercom');
	   exit;
	   
}elseif($action=='del'){
    $delid = $_POST['delid'];
	foreach ( (array) $delid as $id) {
	 text_delete(R_P."$datadir/usercom.php","$id","|","5");
	}
	adminmsg('完成相应操作');
}
?>