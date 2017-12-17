<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=advert";

function get_adv_list(){
global $datadir,$basename;

       $advlist=file(R_P."$datadir/advert.php");
	   $count=count($advlist);
	   $list_info="";
	   echo "-->\n";
	   if($count!=0){
			for ($i=0; $i<$count; $i++) {
	           $detail=explode("|",$advlist[$i]);
			   $list_info.="<tr class=bg><td width=\"24%\" height=25 align=\"center\">$detail[3]</td><td width=\"41%\" height=25 align=\"center\"><a href=\"$basename&ad=$detail[5]&action=edit\">$detail[1]</a></td><td width=\"20%\" align=\"center\">$detail[2]</td><td align=\"center\" width=\"5%\"><a href=\"$basename&ad=$detail[5]&action=edit\">编辑</a></td><td width=\"5%\" align=\"center\"><a href=\"$basename&action=use&ad=$detail[5]\">调用</a></td><td width=\"5%\" align=\"center\"><input type=\"checkbox\" name=\"delID[]\" value=\"$detail[3]\"></td></tr>\n";
	       }
		  echo $list_info;
	   }
	   else{
	       $list_info.="<tr class=bg><td colspan=6>暂时还没有广告列表信息</td></tr>";
		   echo $list_info;
	   }
	   echo "<!--";
}

if (!$action){
	include PrintEot('advert');exit();
} elseif($action=='add'){
	if (!$_POST['step']){
    	include PrintEot('advert');exit();
	} else {
		!file_exists(D_P.'Ad') && adminmsg('Ad 目录存在,请在程序根目录建立文件名为 Ad 目录');
		
		if(!$content){
		    	adminmsg('信息不完整');
	    	}else{
				$val = str_replace('/','\/',$content);
	            $val = str_replace('"','\"',$content);
                $cont= "document.writeln(\"$val\");"."\n";
	            writeto(D_P.'Ad/'.$filename,"$cont");
		        $ad_line="<? die();?>|$subject|$startdate|$filename|$content|$timestamp|\n";
		        writeto(R_P."$datadir/advert.php",$ad_line,"a+");
        		adminmsg('完成相应操作');
		}
	}
} elseif ($action=='edit'){
 	if (!$_POST['step']){
	   $advlist=file(R_P."$datadir/advert.php");
	   $count=count($advlist);
      
	   for($i=0;$i<=$count;$i++){
	      $detail=explode("|",$advlist[$i]);
		  if($ad==$detail[5]){
		   $content=$detail[4];
		   $subject=$detail[1];
		   $oldname=$detail[3];
		   }
		}
	include PrintEot('advert');exit();
	} else{
		!file_exists(D_P.'Ad') && adminmsg('Ad 目录存在,请在程序根目录建立文件名为 Ad 目录');
		
		if(!$content){
		    	adminmsg('信息不完整');
	    	}else{
				$val = str_replace('/','\/',$content);
	            $val = str_replace('"','\"',$content);
                $cont= "document.writeln(\"$val\");"."\n";
	            writeto(D_P.'Ad/'.$filename,"$cont");
		        $newlist="<? die();?>|$subject|$startdate|$filename|$content|$timestamp|\n";
		        text_modify(R_P."$datadir/advert.php",$ad,"|","5",$newlist);
				 @unlink(D_P."Ad/".$oldname);
		        adminmsg('完成相应操作');
		}
	}
} elseif ($action=='del'){
    $delid = $_POST['delID'];
	foreach ( (array) $delid as $id) {
	 text_delete(R_P."$datadir/advert.php","$id","|","3");
	 @unlink(D_P.'Ad/'.$id);
	}
	adminmsg('完成相应操作');
}elseif($action=='use'){
	   $advlist=file(R_P."$datadir/advert.php");
	   $count=count($advlist);
	   for($i=0;$i<=$count;$i++){
	      $detail=explode("|",$advlist[$i]);
		  if($ad==$detail[5]){
		   $filename=$detail[3];
		   }
		}

	$use = "<script language=\"JavaScript\" src=\"http://$_SERVER[SERVER_NAME]/Ad/$filename\"></script>";
	include PrintEot('advert');exit();
}
?>