<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=error";

function get_error_list($page){
global $datadir,$perpage,$basename;

       if(empty($page) or $page<=0) $page=1;
       settype($page, integer);
	   
       $errlist=file(R_P."$datadir/error.php");
	   $count=count($errlist);
	   $list_info="";
	   echo "-->\n";
	   if($count!=0){
	      if ($count%$perpage==0) $maxpageno=$count/$perpage;
		    else $maxpageno=floor($count/$perpage)+1;
	      if ($page>$maxpageno) $page=$maxpageno;
	        $pagemin=min( ($page-1)*$perpage , $count-1);
	        $pagemax=min( $pagemin+$perpage-1, $count-1);
			
			for ($i=$pagemin; $i<=$pagemax; $i++) {
	           $detail=explode("|",$errlist[$i]);
               $errtime=date("Y.m.d H:i",$detail[4]);
			   $list_info.="<tr class=bg><td width=\"12%\" height=25 align=\"center\">$detail[0]</td><td width=\"33%\" align=\"center\"><a href=\"play.php?id=$detail[2]\" target=_blank>$detail[1]</a></td><td width=\"10%\" align=\"center\">$detail[2]</td><td width=\"25%\" align=\"center\">$detail[3]</td><td align=\"center\">$errtime</td><td width=\"5%\" align=\"center\"><input type=\"checkbox\" name=\"delid[]\" value=\"$detail[4]\"></td></tr>\n";
	        }
		  echo $list_info;
	   }
	   else{
	       $list_info.="<tr class=bg><td colspan=6>暂时还没有用户错误报告列表信息</td></tr>";
		   echo $list_info;
	   }
	   $pageurl="$basename&";
       PageNav($maxpageno,$count,$page,$pageurl,6);
	   echo "<!--";
}

if (empty($action)){

       include PrintEot('error');
	   exit;
	   
}elseif($action=='del'){
    $delid = $_POST['delid'];
	foreach ( (array) $delid as $id) {
	 text_delete(R_P."$datadir/error.php","$id","|","4");
	}
	adminmsg('完成相应操作');
}
?>