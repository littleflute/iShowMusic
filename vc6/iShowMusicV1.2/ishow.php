<?php
require("global.php");
if(empty($id)){ 
	Showmsg("no","非法操作！", "关闭本页", "javascript:window.close()");
	exit; }
if (!file_exists("$datadir/data/$id.php")){
	Showmsg("no","此音乐数据不存在，可能已被删除！", "返回前一页", "javascript:history.back(-1)");
	exit; }

$info=@file("$datadir/data/$id.php");
list($catid,$singerid,$songname,$songurl,$hot,$commend,$times)=explode("|",$info[1]);
list($viewnum,$downnum,$tviewnum,$tdownnum,$pinfeng,$viewtimes,$viewtimes1)=explode("|",$info[2]);
get_catid();
get_singerid();

   $asx="";
   $asx.="<ASX version =\"3.0\">\n";
   $asx.="<Entry>\n";
   $asx.="<Title>$songname</Title>\n";
   $asx.="<Ref href =\"$songurl\"/>\n";
   $asx.="<author>$site_name $site_url</author>\n";
   $asx.="<copyright>本歌曲版权属于歌手及其唱片公司所有 本站只作试听用途</copyright>\n";
   $asx.="<param name=\"Artist\" value=\"$singer_name\"/>\n";
   $asx.="<param name=\"Album\" value=\"本歌曲共点播{$viewnum}次\"/>\n";
   $asx.="<param name=\"Title\" value=\"$songname\"/>\n";
   $asx.="</Entry>\n";
   $asx.="</ASX>\n";
   
//防盗链	
if($steal=="1") {
   $host = $_SERVER['HTTP_HOST'];
   $url = parse_url($_SERVER['HTTP_REFERER']);
   $ishowcookie=GetCookie('ishow');
   Cookie("ishow",'0');
   if($ishowcookie==$id){
      echo $asx;
   }elseif($stealurl && strpos(",$stealurl,",",$host") == true){
      echo $asx;
   }else{
      Showmsg("no","请勿盗链！请从本站首页进入试听", "进入本站首页", "$site_url");
   }
}else{
 echo $asx;
}
?>