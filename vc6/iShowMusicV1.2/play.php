<?php
require("global.php");
include("$datadir/badwords.php");
$subtitle='在线试听';

if(empty($id)){ 
	Showmsg("no","非法操作！", "关闭本页", "javascript:window.close()");
	exit; }
if (!file_exists("$datadir/data/$id.php")){
	Showmsg("no","此音乐数据不存在，可能已被删除！", "返回前一页", "javascript:history.back(-1)");
	exit; }

$thisurl="http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
	
$info=@file("$datadir/data/$id.php");
list($catid,$singerid,$songname,$songurl,$hot,$commend,$times)=explode("|",$info[1]);
get_catid();
get_singerid();
list($viewnum,$downnum,$tviewnum,$tdownnum,$pinfeng,$viewtimes,$viewtimes1)=explode("|",$info[2]);	   
$t=getdate(0+$viewtimes1);	
$d=getdate(0+$timestamp);
if($t['mday']==$d['mday']) {
	$tviewnum++;
}else{
  $tviewnum=1;
  $viewtimes1=$timestamp;
}
$viewnum=$viewnum+1;
$a_info=trim($info[0]);
$b_info=trim($info[1]);
unset($info[0]);
unset($info[1]);
unset($info[2]);
$c_info="$viewnum|$downnum|$tviewnum|$tdownnum|$pinfeng|$viewtimes|$viewtimes1|";
$line= $a_info."\n".$b_info."\n".$c_info."\n".implode("",$info);
writetofile("$datadir/data/$id.php",$line);

//总试听排行判断
$view_hot=file("$datadir/viewhot.php");
$view_hot_count=count($view_hot)-1;
$alllist=@file("$datadir/list.php");
$allcount=count($alllist)-1;
$view_hot_info=explode("|",$view_hot[$allcount]);
$hotinfo=@file("$datadir/data/$view_hot_info[2].php"); 
list($viewnumd,$downnumd,$tviewnumd,$tdownnumd,$pinfengd,$viewtimesd,$viewtimesd1)=explode("|",$hotinfo[2]);
 if ($viewnum>=$viewnumd) {
    for ($i=0;$i<=$view_hot_count;$i++){
        $view_hot_info=explode("|",$view_hot[$i]);
	    $hotinfo=@file("$datadir/data/$view_hot_info[2].php"); 
        list($viewnumd,$downnumd,$tviewnumd,$tdownnumd,$pinfengd,$viewtimesd,$viewtimesd1)=explode("|",$hotinfo[2]);
       if ($view_hot_info[2]==$id)
          continue;
          $rank_typearray[$view_hot[$i]]=$viewnumd;
       }
$view_hot_show=$catid."|".$singerid."|".$id."|".$songname."|".$times."|\n";
$rank_typearray[$view_hot_show]=$viewnum;
arsort($rank_typearray);
reset($rank_typearray);
$fp=fopen("$datadir/viewhot.php","w");
flock($fp,3);
for ($counter=1; $counter<=$allcount; $counter++) {
      $keytype=key($rank_typearray);
      fwrite($fp,$keytype);
       if (!(next($rank_typearray))) break;
     }
fclose($fp);
}

//今日试听排行判断
$day_hot=file("$datadir/viewhotday.php");
$day_hot_count=count($day_hot);
$day_hot_info=explode("|",$day_hot[9]);
$ab_info=@file("$datadir/data/$day_hot_info[2].php"); 
list($viewnumd,$downnumd,$tviewnumd,$tdownnumd,$pinfengd,$viewtimesd,$viewtimesd1)=explode("|",$ab_info[2]);
if ($tviewnum>=$tviewnumd) {
for ($i=0;$i<$day_hot_count;$i++){
    $day_hot_info=explode("|",$day_hot[$i]);
	$ab_info=@file("$datadir/data/$day_hot_info[2].php"); 
    $day_hots=explode("|",$ab_info[2]);
    $c=getdate($day_hots[6]);
    if ($day_hot_info[2]!=$id && $c['mday']==$d['mday'])   $rank_hots[$day_hot[$i]]=$day_hots[2];
}
$day_hot_show=$catid."|".$singerid."|".$id."|".$songname."|".$singer_name."|".$tviewnum."|\n";
$rank_hots[$day_hot_show]=$tviewnum;
arsort($rank_hots);
reset($rank_hots);
$fp=fopen("$datadir/viewhotday.php","w");
flock($fp,3);
for ($counter=1; $counter<=10; $counter++) {
    $keytype=key($rank_hots);
    fwrite($fp,$keytype);
    if (!(next($rank_hots))) break;
}
fclose($fp);
}

if($viewnum=="") $viewnum=0;
$subtitle="在线试听：$songname";
$pubtime=date("Y-m-d H:i",$times);

//加载歌词
function get_lrc($id){
global $datadir;
if (file_exists($datadir."/lrc/$id.lrc")){
 $handle= fopen($datadir."/lrc/$id.lrc","rb");   
 $lrccontents="";   
  do{   
     $data=fread($handle,8192);   
        if(strlen($data)==0){   
         break;   
        }   
        $lrccontents.=$data;   
  }   while(true);   
  fclose($handle);
   }
  echo $lrccontents;
}

if (file_exists($datadir."/lrc/$id.lrc")){
   $ishavelrc="<a href=\"down.php?type=lrc&id=$id\">下载 ".$songname." 的LRC歌词</a>";
    }
  else{
        if(GetCookie('userlogin')=="1" && GetCookie('userlever')>="1"){
         $ishavelrc="暂无 ".$songname." 的LRC歌词 <input style=\"border:1px solid #CCC; background:#FFF\" onclick=\"OpenUp(ifaddlrc)\" name=\"submit\" type=\"submit\" value=\"上传LRC歌词\">";
		 }
		  else {
		    $ishavelrc="暂无 ".$songname." 的LRC歌词";
		  }
  }

if(GetIfLogin()) {
	$box="musicbox.php?songid=$id&songname=".rawurlencode($songname)."&singer=".rawurlencode($singer_name)."&action=add  target=\"_blank\"";
	$down="down.php?id=$id"; 
}else{
	$box="javascript:alert('请先登录或注册！')";
	$down="javascript:alert('请先登录或注册！')";
}
 
//防盗链
if($steal=="1")  {
   Cookie("ishow",$id);
  }

function get_comment($id){
 global $datadir,$badwords;
 $com_info=@file("$datadir/reply.php");
 $count=count($com_info);
 echo "-->";
 $com_list="";
 $j=0;
  for ($i=0; $i<$count; $i++){
    $detail=explode("|",$com_info[$i]);
	if($detail[0]==$id){
	 while (list($key,$value)=each($badwords))
	 $detail[3]=str_replace($key,$value,$detail[3]);
	 $time=get_datetime($detail[5]);
	 $com_list.="<div class=\"clist\"><li>网友：<span class=\"green\">".$detail[1]."</span>&nbsp;&nbsp;  评分：<span class=\"red\"><img src=images/face/".$detail[2].".gif height=24 width=24></span>&nbsp;&nbsp;&nbsp;&nbsp;  发表于：$time<span class=main>$detail[3]</span></li></div>";
	 $j++;
	 }
	}
  if($j==0){ 
     $com_list.="暂无网友评论！"; 
   }

  echo $com_list;
  echo "<!--";
}

  require("header.php");
  include_once PrintEot('play');
  footer();
  exit;
?>
