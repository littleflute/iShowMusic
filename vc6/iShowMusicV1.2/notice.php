<?php
require("global.php");
$subtitle='���㹫��';
require("header.php");


/* ���µ�� */
function get_new_notice(){
global $datadir,$skinpath,$skin;
$notice = @file("$datadir/announce.php");
$allnotice = count($notice);
if($allnotice!=0) {
    $noticelist.= "-->";
   for ($i=$allnotice-1; $i>=0; $i--){
     $noticedata = explode("|", $notice[$i]);
	 $pubtime=date("Y-m-d H:i",$noticedata[2]);
     $noticelist.= "<div id=\"Dg\"> <li><a name=\"$noticedata[2]\"><span class=\"left\">�� �⣺</span><font style=\"color:#099;\"><b>$noticedata[3]</b></font></a></li>\n
	 <li><span class=\"left\">�������ݣ�</span><font style=\"color:green;\">$noticedata[4]</font></li>
	 <li><span class=\"left\">����ʱ�䣺</span>$pubtime</li></div>\n";	
     }
	  echo $noticelist;
    }
else{ echo "<br><br>�Բ���,��ʱ��û�е����Ϣ!<br><br>";} 
echo "<!--";
}

/* �������� */
$top="viewhot";

include_once PrintEot('notice');
footer();
 
?>
