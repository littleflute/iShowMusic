<?php
require("global.php");

if (file_exists('install.php')) {
  @die("
  <!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\" />
<title>С��������ϵͳiShowMusic </title>
    <style type=\"text/css\">
	body{font-family: Verdana, Arial, Sans-serif; font-size:12px; line-height: 150%;color : #333;}
	a{color:#330066;}
    </style>
</head>
<body>
<p><img src=images/ishowmusic.jpg></p>
	<h3>��װ�ļ� install.php �����ڣ���ȷ�����Ѿ���װ��iShow Music��</h3>
  <ul>
   <li>���Ѿ���װ��Ϊ��ȷ��ϵͳ�İ�ȫ�������̽��������ɾ����</li>
   <li>��δ��װ����� <a href='install.php'>install.php</a> ���а�װ��</li>
   <li>����ڰ�װ����ʲô���⣬��������ǵ���վѰ����� <a href='http://www.ishowsky.cn'>iShowMusic�ٷ�</a>.</li>
  </ul>
</body>
</html>");
}

$subtitle='��ҳ';
require("header.php");

$singerlist=@file("$datadir/singer.php");	

/* ���µ�� */
$diange = @file("$datadir/diange.php");
$alldiange = count($diange);
$dianglist = "";
if($alldiange<1) {
  $dianglist.= "<span class=\"DiangeList\">���޵����Ϣ!</span>";
}else{
$diange1 = explode("|", $diange[$alldiange-1]);
$times=$diange1[4]; $date=get_date($times); 
$diange1[5]=safeconvert($diange1[5]);
$dianglist.= "<span class=\"DiangeList\"><a href=\"dgplay.php?time=$diange1[4]\" title=\"�����/��˵��$diange1[5]\">$diange1[0] ����һ�ס�$diange1[2]���͸�$diange1[1]($date)</a></span>";	
}

//���·������//
function new_song($singerid,$num)  {
global $datadir,$timestamp,$skinpath,$skin;
$newlist=@file("$datadir/list.php");
$singerlist=@file("$datadir/singer.php");
$allnum=count($newlist);
$allsinger=count($singerlist);
$n=0;
echo"-->";
echo "<form action=\"player/playall.php\" method=\"post\" name=\"form".$singerid."\" onsubmit=\"FormWin(this,'musicbox')\">\n";
echo "<ul>";
for ($i=0; $i<$allnum; $i++){
 $songdetail=explode("|",$newlist[$i]);
 if($singerid==$songdetail[0]){
    $n++;
    for ($ii=0; $ii<$allsinger; $ii++){
	$singerdetail=explode("|", trim($singerlist[$ii]));
	if ($singerdetail[1]==$songdetail[1] && $singerdetail[0]==$songdetail[0])
		{ $singername=$singerdetail[2];break; } else{ $singername=""; }
		}
 $alltitle=$songdetail[3];
 $isnewday=$timestamp-$songdetail[4];
 $showdays=86400*3;  //���3�췢���Ľ���ʾ new.gif ͼƬ����Ҳ��������Ϊ��������
 if($isnewday<=$showdays){ $isnew="<img src=".$skinpath."/".$skin."/images/new.gif>";}else $isnew="";
 echo "<li><span class=\"singername\"><a href=\"list.php?catid=$songdetail[0]&singerid=$songdetail[1]\" title=\"�鿴 $singername �����и���\" target=_blank>$singername</a></span><span class=\"songname\"><input type=checkbox  checked  name=id[] value=$songdetail[2]> <a href=\"play.php?id=$songdetail[2]\" target=_blank title=\"$alltitle\" >$songdetail[3]</a> $isnew </span></li>\n";
    }
  if($n>=$num) break;
  }
  echo "</ul>\n";
  echo "<div align=\"center\" style=\"margin-top:5px\">
		<input type='button' value='ȫѡ' onclick='sal(form{$singerid})' class=\"sbt\">\n
&nbsp;&nbsp;<input type='button' value='��ѡ' onclick='opal(form{$singerid})' class=\"sbt\">\n
&nbsp;&nbsp;<input type='button' value='���' onclick='clal(form{$singerid})' class=\"sbt\">\n
&nbsp;&nbsp;<input type=\"submit\" name=\"Submit\" value='����' class=\"sbt\"></div> ";
  echo "</form>";
  echo"<!--";
}

//���������
function GetSortName($cat_id){
global $datadir;
$catlist=file("$datadir/cat.php");
$count=count($catlist);
$name="-->\n";
for($i=0;$i<$count;$i++){
    $detail=explode("|", trim($catlist[$i]));
	if($detail[0]==$cat_id){
	 $name.="<a href=\"list.php?catid=$detail[0]\" target=_blank>$detail[1]</a>";
	 }
   }
  $name.="<!--";
  echo $name;
}

//��������
function Sharelinks(){
   global $datadir;
   $share_info=@file("$datadir/sharelinks.php");
   $c=count($share_info); 
   echo"-->";
    for($i=0; $i<$c; $i++){ 
		$detail=explode("|",$share_info[$i]); 
		 if($detail[5]==""){
		    $textlink.="<span class=\"text-link\"><a href=\"$detail[3]\" target=_blank title=\"$detail[4]\">$detail[1]</span></a>";
		 }else{
		    $piclink.="<span class=\"pic-link\"><a href=\"$detail[3]\" target=_blank><img src=$detail[5] width=88 height=31 alt=\"$detail[4]\"></a></span>";
		 }
		}
  echo $piclink; echo $textlink;
 echo"<!--";
}

/* �������� */
$top="viewhot";

/* �����Ƽ� */
$commend="commend";

include_once PrintEot('index');
footer();
 
?>