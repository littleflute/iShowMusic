<?php
require("global.php");
$subtitle='�����ϼ�';
require("header.php");

$singerlist=@file("$datadir/singer.php");
$newsonglist=@file("$datadir/list.php");
$singersum=count($singerlist);	
$songsum=count($newsonglist);

function get_newsong($page){

global $datadir,$singerlist,$newsonglist,$singersum,$songsum,$perpage,$skinpath,$skin;

if(empty($page) or $page<=0) $page=1;
settype($page, integer);

echo"-->\n";
if($songsum!=0){
    if ($songsum%$perpage==0) $maxpageno=$songsum/$perpage;
		else $maxpageno=floor($songsum/$perpage)+1;
	if ($page>$maxpageno) $page=$maxpageno;
	    $pagemin=min( ($page-1)*$perpage , $songsum-1);
	    $pagemax=min( $pagemin+$perpage-1, $songsum-1);
		
		for ($i=$pagemin; $i<=$pagemax; $i++){
		 $songdetail=explode("|",$newsonglist[$i]);
		 $id=chop($songdetail[2]);
		 $info=@file("$datadir/data/$id.php");  
		 list($catid,$singerid,$songname,$songurl,$hot,$commend,$times)=explode("|",$info[1]);
		 list($viewnum,$downnum,$tviewnum,$tdownnum,$pinfeng,$viewtimes)=explode("|",$info[2]);
		 if($downnum=="") $downnum=0;if($viewnum=="") $viewnum=0;
		 $times=get_date($times);
		   for ($ii=0; $ii<$singersum; $ii++){
		   $singerdetail=explode("|", trim($singerlist[$ii]));
		   if ($singerdetail[1]==$songdetail[1] && $singerdetail[0]==$songdetail[0]){$singername=$singerdetail[2];break;}
		    }
			$m=$i+1;
			if(GetIfLogin()) {
			    $box="musicbox.php?songid=$id&songname=".rawurlencode($songname)."&singer=".rawurlencode($singername)."&action=add  target=\"_blank\"";
				$down="down.php?id=$id"; 
			  }else{
			    $box="javascript:alert('���ȵ�¼��ע�ᣡ')";
				$down="javascript:alert('���ȵ�¼��ע�ᣡ')";
			  }
 		 echo "<li><span class=\"songname\"><input type=checkbox  checked  name=id[] value=$id> $m. <a href=\"play.php?id=$id\" title=\"������$viewnum\" target=\"_blank\">$songname</a></span> <span class=\"singer\"><a href=\"list.php?catid=$catid&singerid=$singerid\" title=\"����鿴 $singername ��������\" target=\"_blank\">$singername</a></span><span class=\"play\"><a href=\"play.php?id=$id\" title=\"������� $songname\" target=\"_blank\"><img src=\"$skinpath/$skin/images/icon_play.gif\" align=\"middle\"></a></span><span class=\"dg\"><a href=\"dg.php?id=$id&name=".rawurlencode($songname)."\" title=\"����͸�����\"><img src=\"$skinpath/$skin/images/icon_dg.gif\" align=\"middle\"></a></span><span class=\"sc\"><a href=$box title=\"�ղص��ҵ����ֺ�\"><img src=\"$skinpath/$skin/images/icon_sc.gif\" align=\"middle\"></a></span><span class=\"down\"><a href=\"$down\" title=\"���� $songname ������\"><img src=\"$skinpath/$skin/images/icon_down.gif\" align=\"middle\"></a></span></li>\n"; 
	}
}
else{ echo "<br><br>�Բ���,�������ʱδ��¼�����ļ�!<br><br>";} 
  echo "<li><div align=\"center\">
		<input type='button' value='ȫѡ' onclick='sal(newsong)' class=\"sbt\">\n
&nbsp;&nbsp;<input type='button' value='��ѡ' onclick='opal(newsong)' class=\"sbt\">\n
&nbsp;&nbsp;<input type='button' value='���' onclick='clal(newsong)' class=\"sbt\">\n
&nbsp;&nbsp;<input type=\"submit\" name=\"Submit\" value='����' class=\"sbt\"></div></li> ";
$pages = numofpage($songsum,$page,ceil($songsum/$perpage),'new.php?');	
echo $pages;

echo"<!--\n";
}

/* �����Ƽ� */
$commend="commend";

/* �������� */
$top="viewhot";

include_once PrintEot('new');
footer();
 
?>
