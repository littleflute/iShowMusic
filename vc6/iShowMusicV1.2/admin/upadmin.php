<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=upadmin";

function get_up_list($page){
global $site_url,$datadir,$updir,$perpage,$basename;

       if(empty($page) or $page<=0) $page=1;
       settype($page, integer);
	   
       $uplist=file(R_P."$updir/uplist.php");
	   $count=count($uplist);
	   $list_info="";
	   echo "-->\n";
	   if($count!=0){
	      if ($count%$perpage==0) $maxpageno=$count/$perpage;
		    else $maxpageno=floor($count/$perpage)+1;
	      if ($page>$maxpageno) $page=$maxpageno;
	        $pagemin=min( ($page-1)*$perpage , $count-1);
	        $pagemax=min( $pagemin+$perpage-1, $count-1);
			
			for ($i=$pagemin; $i<=$pagemax; $i++) {
	           $updetail=explode("|",$uplist[$i]);
               $uptime=date("Y.m.d H:i",$updetail[4]);
			   $list_info.="<tr class=bg><td width=\"13%\" height=25 align=\"center\">$updetail[0]</td><td width=\"23%\" align=\"center\">$updetail[1]</td><td width=\"25%\" align=\"center\">$updetail[2]</td><td width=\"12%\" align=\"center\">{$updetail[3]} B</td><td width=\"17%\" align=\"center\">$uptime</td><td width=\"5%\" align=\"center\"><a onclick=\"javascript:playmedia('mediaplayer','".$site_url."/".$updir."/".$updetail[1]."' );\" 
href=\"javascript:\">试听</a></td><td width=\"5%\" align=\"center\"><input type=\"checkbox\" name=\"delid[]\" value=\"$updetail[1]\"></td></td></tr>\n";
	        }
		  echo $list_info;
	   }
	   else{
	       $list_info.="<tr class=bg><td colspan=7>暂时还没有上传文件列表信息</td></tr>";
		   echo $list_info;
	   }
	   $pageurl="$basename&";
       PageNav($maxpageno,$count,$page,$pageurl,7);
	   echo "<!--";
}

if (empty($action)){

       include PrintEot('upadmin');
	   exit;
	   
}elseif($action=='del'){
    $delid = $_POST['delid'];
	foreach ( (array) $delid as $id) {
	 unlink(R_P."$updir/{$id}");
	 text_delete(R_P."$updir/uplist.php","$id","|","1");
	}
	adminmsg('完成相应操作');
}
?>