<?php
require("global.php");
$subtitle='点 歌 台';
require("header.php");

$singerlist=@file("$datadir/singer.php");	

/* 最新点歌 */
function get_new_diange(){
global $datadir,$skinpath,$skin;
$diange = @file("$datadir/diange.php");
$alldiange = count($diange);
if($alldiange!=0) {
    $diangelist.= "-->";
   for ($i=$alldiange-1; $i>=0; $i--){
     $diangedata = explode("|", $diange[$i]);
     $diangelist.= "<li><img src=\"$skinpath/$skin/images/icon_song.gif\"> <a href=\"dgplay.php?time=$diangedata[4]\"><font color=\"#009999\">$diangedata[0]</font> 点了一首《<font color=\"#FF3300\">$diangedata[2]</font>》送给<font color=\"#FF3399\">$diangedata[1]</font></a> ( ".strftime("%Y/%m/%d",$diangedata[4])." )</li>\n";	
     }
	  echo $diangelist;
    }
else{ echo "<br><br>对不起,暂时还没有点歌信息!<br><br>";} 
echo "<!--";
}

/* 试听排行 */
$top="viewhot";

include_once PrintEot('song');
footer();
 
?>
