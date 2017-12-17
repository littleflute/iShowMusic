<?php
require("global.php");
$subtitle='部点公告';
require("header.php");


/* 最新点歌 */
function get_new_notice(){
global $datadir,$skinpath,$skin;
$notice = @file("$datadir/announce.php");
$allnotice = count($notice);
if($allnotice!=0) {
    $noticelist.= "-->";
   for ($i=$allnotice-1; $i>=0; $i--){
     $noticedata = explode("|", $notice[$i]);
	 $pubtime=date("Y-m-d H:i",$noticedata[2]);
     $noticelist.= "<div id=\"Dg\"> <li><a name=\"$noticedata[2]\"><span class=\"left\">标 题：</span><font style=\"color:#099;\"><b>$noticedata[3]</b></font></a></li>\n
	 <li><span class=\"left\">具体内容：</span><font style=\"color:green;\">$noticedata[4]</font></li>
	 <li><span class=\"left\">发布时间：</span>$pubtime</li></div>\n";	
     }
	  echo $noticelist;
    }
else{ echo "<br><br>对不起,暂时还没有点歌信息!<br><br>";} 
echo "<!--";
}

/* 试听排行 */
$top="viewhot";

include_once PrintEot('notice');
footer();
 
?>
