<?php
require("global.php");
if(empty($id)){ 
	Showmsg("no","�Ƿ�������", "�رձ�ҳ", "javascript:window.close()");
	exit; }
if (!file_exists("$datadir/data/$id.php")){
	Showmsg("no","���������ݲ����ڣ������ѱ�ɾ����", "����ǰһҳ", "javascript:history.back(-1)");
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
   $asx.="<copyright>��������Ȩ���ڸ��ּ��䳪Ƭ��˾���� ��վֻ��������;</copyright>\n";
   $asx.="<param name=\"Artist\" value=\"$singer_name\"/>\n";
   $asx.="<param name=\"Album\" value=\"���������㲥{$viewnum}��\"/>\n";
   $asx.="<param name=\"Title\" value=\"$songname\"/>\n";
   $asx.="</Entry>\n";
   $asx.="</ASX>\n";
   
//������	
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
      Showmsg("no","�����������ӱ�վ��ҳ��������", "���뱾վ��ҳ", "$site_url");
   }
}else{
 echo $asx;
}
?>