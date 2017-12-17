<?php
require("global.php");

if (empty($id)){
	Showmsg("no","非法操作","关闭", "javascript:window.close()");
	exit; 
  }

if (!file_exists("$datadir/data/$id.php")) {
	Showmsg("no","此歌曲不存在，可能已被删除，有问题请联系站长","关闭", "javascript:window.close()");
	exit; 
  }


$info=@file("$datadir/data/$id.php");
list($catid,$singerid,$songname,$songurl,$hot,$commend,$times)=explode("|",$info[1]);
list($viewnum,$downnum,$tviewnum,$tdownnum,$pinfeng,$viewtimes,$viewtimes1)=explode("|",$info[2]);
   
if(empty($type)){

if (GetCookie('userlogin')!="1"){
	Showmsg("no","您还没有登录!","登录", "login.php?jumpurl=down.php?id=$id");
	exit; 
  }

  if ($downon=="0"){
	Showmsg("no","对不起，管理员关闭了下载功能!","进入首页", "index.php");
	exit; 
  }

  $t=getdate($viewtimes);	
  $d=getdate($timestamp);
   if($t['mday']==$d['mday']) {
	$tdownnum++;
      }
    else{
      $tdownnum=1;
      $viewtimes1=$timestamp;
       }
   $downnum++;
   $infoa=trim($info[0]);
   $infob=trim($info[1]);
   unset($info[0]);
   unset($info[1]);
   unset($info[2]);
   $infoc="$viewnum|$downnum|$tviewnum|$tdownnum|$pinfeng|$viewtimes|$viewtimes1|";
   $line= $infoa."\n".$infob."\n".$infoc."\n".implode("",$info);
   writetofile("$datadir/data/$id.php",$line);


   $down_hot=file("$datadir/downhot.php");
   $down_hot_count=count($down_hot)-1;
   $down_hot_info=explode("|",$down_hot[29]);
   $d_info=@file("$datadir/data/$down_hot_info[2].php"); 
   list($viewnumd,$downnumd,$tviewnumd,$tdownnumd,$pinfengd,$viewtimesd,$viewtimesd1)=explode("|",$d_info[2]);
   if ($downnum>=$downnumd) {
    for ($i=0;$i<=$down_hot_count;$i++){
       $down_hot_info=explode("|",$down_hot[$i]);
	   $d_info=@file("$datadir/data/$down_hot_info[2].php"); 
       list($viewnumd,$downnumd,$tviewnumd,$tdownnumd,$pinfengd,$viewtimesd,$viewtimesd1)=explode("|",$d_info[2]);
       	if ($down_hot_info[2]!=$id)   $rank_typearray[$down_hot[$i]]=$downnumd;
       }
    $down_hot_show=$catid."|".$singerid."|".$id."|".$songname."|".$times."|\n";
    $rank_typearray[$down_hot_show]=$downnum;
    arsort($rank_typearray);
    reset($rank_typearray);
    $fp=fopen("$datadir/downhot.php","w");
    flock($fp,3);
   for ($counter=1; $counter<=30; $counter++) {
        $keytype=key($rank_typearray);
        fwrite($fp,$keytype);
       if (!(next($rank_typearray))) break;
         }
    fclose($fp);
   }
  $day_hot=file("$datadir/downhotday.php");
  $day_hot_count=count($day_hot)-1;
  $day_hot_info=explode("|",$day_hot[9]);
  $d_info=@file("$datadir/data/$day_hot_info[2].php"); 
  list($viewnumd,$downnumd,$tviewnumd,$tdownnumd,$pinfengd,$viewtimesd,$viewtimesd1)=explode("|",$d_info[2]);
   if ($tdownnum>=$tdownnumd) {
     for ($i=0;$i<=$day_hot_count;$i++){
       $day_hot_info=explode("|",$day_hot[$i]);
	   $d_info=@file("$datadir/data/$day_hot_info[2].php"); 
       $day_hots=explode("|",$d_info[2]);
       $c=getdate($day_hots[5]);
         if ($day_hot_info[2]!=$id && $c['mday']==$d['mday'])   $rank_hots[$day_hot[$i]]=$day_hots[3];
         }
   $day_hot_show=$catid."|".$singerid."|".$id."|".$songname."|".$times."|".$tdownnum."|\n";
   $rank_hots[$day_hot_show]=$tdownnum;
   arsort($rank_hots);
   reset($rank_hots);
   $fp=fopen("$datadir/downhotday.php","w");
   flock($fp,3);
  for ($counter=1; $counter<=10; $counter++) {
    $keytype=key($rank_hots);
    fwrite($fp,$keytype);
    if (!(next($rank_hots))) break;
      }
  fclose($fp);
   }
   
    $file_size = filesize($songurl);
	$ext = strtolower(strrchr($songurl,'.'));
	$file_name = $songname."".$ext;
 
    header("Content-type: application/octet-stream");
    header("Accept-Ranges: bytes");
    header("Accept-Length: $file_size");
    header("Content-Disposition: attachment; filename=".$file_name);
	readfile($songurl);   
   exit; 
}
elseif($type=="lrc"){

    header("Content-type: application/octet-stream");
    header("Accept-Ranges: bytes");
    header("Content-Disposition: attachment; filename=".$songname.".lrc");
	readfile("$datadir/lrc/".$id.".lrc");  
   exit; 
}
elseif($type=="box"){
   echo"$songurl";
   exit; 
}
?>