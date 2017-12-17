<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=songadmin";

function get_dg_list($page){
global $datadir,$perpage,$basename;

       if(empty($page) or $page<=0) $page=1;
       settype($page, integer);
	   
       $dglist=file(R_P."$datadir/diange.php");
	   $count=count($dglist);
	   $list_info="";
	   echo "-->\n";
	   if($count!=0){
	      if ($count%$perpage==0) $maxpageno=$count/$perpage;
		    else $maxpageno=floor($count/$perpage)+1;
	      if ($page>$maxpageno) $page=$maxpageno;
	        $pagemin=min( ($page-1)*$perpage , $count-1);
	        $pagemax=min( $pagemin+$perpage-1, $count-1);
			
			for ($i=$pagemin; $i<=$pagemax; $i++) {
	           $detail=explode("|",$dglist[$i]);
               $dgtime=date("Y.m.d H:i",$detail[4]);
			   $list_info.="<tr class=bg><td width=\"10%\" height=25 align=\"center\">$detail[0]</td><td width=\"15%\" align=\"center\">$detail[1]</td><td width=\"20%\" align=\"center\"><a href=\"play.php?id=$detail[3]\" target=_blank>$detail[2]</a></td><td align=\"center\">$detail[5]</td><td width=\"15%\" align=\"center\">$dgtime</td><td width=\"5%\" align=\"center\"><input type=\"checkbox\" name=\"delid[]\" value=\"$detail[4]\"></td></tr>\n";
	        }
		  echo $list_info;
	   }
	   else{
	       $list_info.="<tr class=bg><td colspan=6>暂时还没有点歌信息</td></tr>";
		   echo $list_info;
	   }
	   $pageurl="$basename&";
       PageNav($maxpageno,$count,$page,$pageurl,6);
	   echo "<!--";
}

if (empty($action)){

       include PrintEot('songadmin');
	   exit;
	   
}elseif($action=='del'){
    $delid = $_POST['delid'];
	foreach ( (array) $delid as $id) {
	 text_delete(R_P."$datadir/diange.php","$id","|","4");
	}
	adminmsg('完成相应操作');
}
?>