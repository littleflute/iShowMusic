<?php
require("global.php");
$subtitle='�� �� ̨';
require("header.php");

$singerlist=@file("$datadir/singer.php");	

/* ���µ�� */
function get_new_diange(){
global $datadir,$skinpath,$skin;
$diange = @file("$datadir/diange.php");
$alldiange = count($diange);
if($alldiange!=0) {
    $diangelist.= "-->";
   for ($i=$alldiange-1; $i>=0; $i--){
     $diangedata = explode("|", $diange[$i]);
     $diangelist.= "<li><img src=\"$skinpath/$skin/images/icon_song.gif\"> <a href=\"dgplay.php?time=$diangedata[4]\"><font color=\"#009999\">$diangedata[0]</font> ����һ�ס�<font color=\"#FF3300\">$diangedata[2]</font>���͸�<font color=\"#FF3399\">$diangedata[1]</font></a> ( ".strftime("%Y/%m/%d",$diangedata[4])." )</li>\n";	
     }
	  echo $diangelist;
    }
else{ echo "<br><br>�Բ���,��ʱ��û�е����Ϣ!<br><br>";} 
echo "<!--";
}

/* �������� */
$top="viewhot";

include_once PrintEot('song');
footer();
 
?>
