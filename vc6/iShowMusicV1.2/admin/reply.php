<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=reply";

function get_reply_list($page){
global $datadir,$perpage,$basename;

       if(empty($page) or $page<=0) $page=1;
       settype($page, integer);
	   
       $replylist=file(R_P."$datadir/reply.php");
	   $count=count($replylist);
	   $list_info="";
	   echo "-->\n";
	   if($count!=0){
	      if ($count%$perpage==0) $maxpageno=$count/$perpage;
		    else $maxpageno=floor($count/$perpage)+1;
	      if ($page>$maxpageno) $page=$maxpageno;
	        $pagemin=min( ($page-1)*$perpage , $count-1);
	        $pagemax=min( $pagemin+$perpage-1, $count-1);
			
			for ($i=$pagemin; $i<=$pagemax; $i++) {
	           $detail=explode("|",$replylist[$i]);
               $replytime=date("Y.m.d H:i",$detail[5]);
			   $list_info.="<tr class=bg><td width=\"10%\" height=25 align=\"center\"><a href=\"play.php?id=$detail[0]\" target=_blank>$detail[0]</a></td><td width=\"15%\" align=\"center\">$detail[1]</td><td width=\"20%\" align=\"center\">$detail[4]</td><td align=\"center\"><a href=\"play.php?id=$detail[0]\" target=_blank>$detail[3]</a></td><td width=\"15%\" align=\"center\">$replytime</td><td width=\"5%\" align=\"center\"><input type=\"checkbox\" name=\"delid[]\" value=\"$detail[5]\"></td></tr>\n";
	        }
		  echo $list_info;
	   }
	   else{
	       $list_info.="<tr class=bg><td colspan=6>暂时还没有用户评论</td></tr>";
		   echo $list_info;
	   }
	   $pageurl="$basename&";
       PageNav($maxpageno,$count,$page,$pageurl,6);
	   echo "<!--";
}

if (empty($action)){

       include PrintEot('reply');
	   exit;
	   
}elseif($action=='del'){
    $delid = $_POST['delid'];
	foreach ( (array) $delid as $id) {
	 text_delete(R_P."$datadir/reply.php","$id","|","5");
	}
	adminmsg('完成相应操作');
}
?>