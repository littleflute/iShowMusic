<?php
require("global.php");
get_catid();
if ($ckeckid==0){ echo"û�д˷���";exit;}
if (!$singerid) { $subtitle=$cat_name; }
else {
    get_singerid();
    if ($nckeckid==0){ echo"û�д��ӷ���";exit;}
	else $subtitle=$singer_name;
}

require("header.php");

$singerlist=@file("$datadir/singer.php");
$list=@file("$datadir/list.php");
$singersum=count($singerlist);	
$sum=count($list);

function get_list($page){

global $datadir,$singerid,$catid,$singerlist,$list,$singersum,$sum,$perpage,$skinpath,$skin;

if(empty($page) or $page<=0) $page=1;
settype($page, integer);

for ($i=0; $i<$sum; $i++){ 
    $detail=explode("|",$list[$i]);
    $file_name=chop($detail[2]);
    if (file_exists("$datadir/data/$file_name.php")){
      if(!$singerid) {
	     if ($catid==$detail[0]) 
            $song_list[]=$list[$i];
                 }
	  else if ($catid==$detail[0] && $singerid==$detail[1]) 
		    $song_list[]=$list[$i];
    } 
 }
$countnum=count($song_list);

echo"-->\n";
if($countnum!=0){
    if ($countnum%$perpage==0) $maxpageno=$countnum/$perpage;
		else $maxpageno=floor($countnum/$perpage)+1;
	if ($page>$maxpageno) $page=$maxpageno;
	    $pagemin=min( ($page-1)*$perpage , $countnum-1);
	    $pagemax=min( $pagemin+$perpage-1, $countnum-1);
		
		for ($j=$pagemin; $j<=$pagemax; $j++){
		 $songdetail=explode("|",$song_list[$j]);
		 $id=chop($songdetail[2]);
		 $info=@file("$datadir/data/$id.php");  
		 list($catid,$singer_id,$songname,$songurl,$hot,$commend,$times)=explode("|",$info[1]);
		 list($viewnum,$downnum,$tviewnum,$tdownnum,$pinfeng,$viewtimes)=explode("|",$info[2]);
		 if($downnum=="") $downnum=0;if($viewnum=="") $viewnum=0;
		 $times=get_date($times);
		   for ($ii=0; $ii<$singersum; $ii++){
		   $singerdetail=explode("|", trim($singerlist[$ii]));
		   if ($singerdetail[1]==$songdetail[1] && $singerdetail[0]==$songdetail[0]){$singername=$singerdetail[2];break;}
		    }
			$m=$j+1;
			if(GetIfLogin()) {
			    $box="musicbox.php?songid=$id&songname=".rawurlencode($songname)."&singer=".rawurlencode($singername)."&action=add  target=\"_blank\"";
				$down="down.php?id=$id"; 
			  }else{
			    $box="javascript:alert('���ȵ�¼��ע�ᣡ')";
				$down="javascript:alert('���ȵ�¼��ע�ᣡ')";
			  }
 		 echo "<li><span class=\"songname\"><input type=checkbox  checked  name=id[] value=$id> $m. <a href=\"play.php?id=$id\" title=\"������$viewnum\" target=\"_blank\">$songname</a></span> <span class=\"singer\"><a href=\"list.php?catid=$catid&singerid=$singer_id\" title=\"����鿴 $singername ��������\" target=\"_blank\">$singername</a></span><span class=\"play\"><a href=\"play.php?id=$id\" title=\"������� $songname\" target=\"_blank\"><img src=\"$skinpath/$skin/images/icon_play.gif\" align=\"middle\"></a></span><span class=\"dg\"><a href=\"dg.php?id=$id&name=".rawurlencode($songname)."\" title=\"����͸�����\" target=\"_blank\"><img src=\"$skinpath/$skin/images/icon_dg.gif\" align=\"middle\"></a></span><span class=\"sc\"><a href=$box title=\"�ղص��ҵ����ֺ�\"><img src=\"$skinpath/$skin/images/icon_sc.gif\" align=\"middle\"></a></span><span class=\"down\"><a href=\"$down\" title=\"���� $songname ������\"><img src=\"$skinpath/$skin/images/icon_down.gif\" align=\"middle\"></a></span></li>\n"; 
	}
}
else{ echo "<br><br>�Բ���,�������ʱδ��¼�����ļ�!<br><br>";} 
  echo "<li><div align=\"center\">
		<input type='button' value='ȫѡ' onclick='sal(list)' class=\"sbt\">\n
&nbsp;&nbsp;<input type='button' value='��ѡ' onclick='opal(list)' class=\"sbt\">\n
&nbsp;&nbsp;<input type='button' value='���' onclick='clal(list)' class=\"sbt\">\n
&nbsp;&nbsp;<input type=\"submit\" name=\"Submit\" value='����' class=\"sbt\"></div></li> ";

if(!$singerid) $pageurl="list.php?catid=$catid&"; else $pageurl="list.php?catid=$catid&singerid=$singerid&";
$pages = numofpage($countnum,$page,ceil($countnum/$perpage),$pageurl);	
echo $pages;
echo"<!--\n";
}

/* �����Ƽ� */
$commend="commend";

/* �������� */
$top="viewhot";

/* �������� */
function sort_top($catid,$singerid,$num){
global $datadir,$singerid,$catid,$skinpath,$skin;
$sortlist=@file("$datadir/viewhot.php");
$allnum=count($sortlist);
$n=0;
echo"-->";
for($i=0;$i<$allnum;$i++){
   $songdetail=explode("|",trim($sortlist[$i])); 
   if(empty($singerid)){
     if($catid==$songdetail[0]){
	    $n++;
	    $alltitle=$songdetail[3];
	    //$songdetail[3]=gbsubstr($songdetail[3], 0, 48);//��ȡ�ַ���
	    echo "<li><a href=\"play.php?id=$songdetail[2]\" title=\"$alltitle\" target=_blank>$songdetail[3]</a></li>\n";
	  }
	 }
	else {
	  if($catid==$songdetail[0] && $singerid==$songdetail[1]){
	    $n++;
	    $alltitle=$songdetail[3];
	    //$songdetail[3]=gbsubstr($songdetail[3], 0, 48);//��ȡ�ַ���
	    echo "<li><a href=\"play.php?id=$songdetail[2]\" title=\"$alltitle\" target=_blank>$songdetail[3]</a></li>\n";
	  }
	}
	if($n>=$num) break;
  }
 echo"<!--";
} 

include_once PrintEot('list');
footer();
 
?>
