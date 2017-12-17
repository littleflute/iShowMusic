<?php
require("global.php");
$subtitle='搜 索';
require("header.php");

$singerlist=@file("$datadir/singer.php");
$singersum=count($singerlist);	

function get_search($keyword){

global $datadir,$skinpath,$skin,$type,$singerlist,$singersum;

if(empty($page) or $page<=0) $page=1;
settype($page, integer);

echo"-->\n";
if(empty($type)) $type='name';

if($type=='name'){
	$namelist=file("$datadir/list.php");
	$namecount=count($namelist);
	for ($j=0; $j<$namecount; $j++){
	list($a,$b,$c,$d,$e,$f)=explode("|",$namelist[$j]);
	if (strpos($d,$keyword) !== false ) {
		$result[] = $namelist[$j];
		$resultcount++;}
	 }
}elseif($type=="singer"){
    $singerlist=file("$datadir/singer.php");
	$singercount=count($singerlist);
	for ($m=0; $m<$singercount; $m++){     
		$detail=explode("|", $singerlist[$m]);
		if (strpos($detail[2],$keyword) !== false ){
			$singerid=$detail[1];
			$songlist=file("$datadir/list.php");
            $songcount=count($songlist);
			for ($n=0; $n<$songcount; $n++){
				list($aa,$bb,$cc,$dd,$ee,$ff)=explode("|",$songlist[$n]);
				if($bb==$singerid){
					$result[] = $songlist[$n];
					$resultcount++; }
			 }
		 }	 
	 }
}
$songsum=count($result);
if($songsum!=0){
		for ($i=0; $i<$songsum; $i++){
		 $songdetail=explode("|",$result[$i]);
		 $id=chop($songdetail[2]);
		 $info=@file("$datadir/data/$id.php");  
		 list($catid,$singerid,$songname,$songurl,$hot,$commend,$times)=explode("|",$info[1]);
		 list($viewnum,$downnum,$tviewnum,$tdownnum,$pinfeng,$viewtimes)=explode("|",$info[2]);
		 $songname = str_replace($keyword,"<font color=red>$keyword</font>",$songname);
		 if($downnum=="") $downnum=0;if($viewnum=="") $viewnum=0;
		 $times=get_date($times);
		   for ($ii=0; $ii<$singersum; $ii++){
		   $singerdetail=explode("|", trim($singerlist[$ii]));
		   if ($singerdetail[1]==$songdetail[1] && $singerdetail[0]==$songdetail[0]){$singername=$singerdetail[2];break;}
		    }
			$singername = str_replace($keyword,"<font color=red>$keyword</font>",$singername);
			$m=$i+1;
 		 echo "<li><span class=\"songname\">$m. <a href=\"play.php?id=$id\" title=\"人气：$viewnum\" target=\"_blank\">$songname</a></span> <span class=\"singer\"><a href=\"list.php?catid=$catid&singerid=$singerid\" title=\"点击查看 $singername 所有音乐\" target=\"_blank\">$singername</a></span><span class=\"play\"><a href=\"play.php?id=$id\" title=\"点击试听 $songname\" target=\"_blank\"><img src=\"$skinpath/$skin/images/icon_play.gif\" align=\"middle\"></a></span><span class=\"dg\"><a href=\"dg.php?id=$id&name=".rawurlencode($songname)."\" title=\"点歌送给好友\" target=\"_blank\"><img src=\"$skinpath/$skin/images/icon_dg.gif\" align=\"middle\"></a></span><span class=\"sc\"><a href=\"musicbox.php?songid=$id&songname=".rawurlencode($songname)."&singer=".rawurlencode($singername)."&action=add\" title=\"收藏到我的音乐盒\" target=\"_blank\"><img src=\"$skinpath/$skin/images/icon_sc.gif\" align=\"middle\"></a></span><span class=\"down\"><a href=\"down.php?id=$id\" title=\"下载 $songname 到本地\" target=\"_blank\"><img src=\"$skinpath/$skin/images/icon_down.gif\" align=\"middle\"></a></span></li>\n"; 
	}
}
else{ echo "<br><br>对不起,没有符合条件的音乐文件!<br><br>";} 
echo"<!--\n";
}

if(empty($action)){
   include_once PrintEot('search');
   footer();
}elseif($action=='search') {
 if(empty($keyword)){
 	Showmsg("no","你要找什么？","返回", "javascript:history.go.back(-1)"); footer();
	exit; 
    }
	else{
	   include_once PrintEot('search');
       footer();
	}
}
?>
