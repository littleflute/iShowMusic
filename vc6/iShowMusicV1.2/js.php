<?php
/**************************************************************************
*
* iShow Music JS����
*
* $color   : �������ʾ��ɫ���������ߣ�ʱ�䣬
* $prefix  : ����ǰ�ַ���������ͼƬ��<img src="ͼƬ��ַ" border="0">
*
**************************************************************************/

$color   = '#999';
$prefix  = array('<li>','��','��','��','��','- ','��-');

/*****************************************************/
require("global.php");

$REFERER = parse_url($_SERVER['HTTP_REFERER']);
if(!$jsifopen){
	exit("document.write(\"��û�п���JS���ù��ܣ���Ҫ��ϵͳ���������п���\");");
}
if ($jsurl && $_SERVER['HTTP_REFERER'] && strpos(",$jsurl,",",$REFERER[host],") === false){
	exit("document.write(\"�Ƿ����ã�ϵͳ���������������վ���ݵ�����\");");
}
if(isset($type) && $type=="new"){
   $datalist=@file($datadir."/list.php");
}elseif(isset($type) && $type=="top"){
   $datalist=@file($datadir."/viewhot.php");
}else $datalist=@file($datadir."/list.php");
$listcount=count($datalist);

$singerlist=@file("$datadir/singer.php");
$singercount=count($singerlist);

	$num	  = is_numeric($num) ? $num : 10;
	$length	  = is_numeric($length) ? $length : 35;
	$pre	  = is_numeric($pre) ? $prefix[$pre] : $prefix[0];

$music="";
$j=0;
for ($i=0; $i<$listcount; $i++){
		 $songdetail=explode("|",$datalist[$i]);
		 if(!is_numeric($sort) && !is_numeric($singer)){
		    $song[]=$datalist[$i];
		    $j++;
		 }elseif(is_numeric($sort) && !is_numeric($singer) && $songdetail[0]==$sort){
		    $song[]=$datalist[$i];
		    $j++;
		 }elseif(!is_numeric($sort) && is_numeric($singer) && $songdetail[1]==$singer){
		    $song[]=$datalist[$i];
		    $j++;
		 }elseif(is_numeric($sort) && is_numeric($singer) && $songdetail[1]==$singer){
		    $song[]=$datalist[$i];
		    $j++;
		 }
		 if($j>$num) break;
} 
$countnum=count($song);

if($countnum!=0){
 for ($m=0; $m<$countnum; $m++){
   $detail=explode("|",$song[$m]);
	$id=chop($detail[2]);
	$info=@file("$datadir/data/$id.php");  
	list($catid,$singer_id,$songname,$songurl,$hot,$commend,$times)=explode("|",$info[1]);
    list($viewnum,$downnum,$tviewnum,$tdownnum,$pinfeng,$viewtimes)=explode("|",$info[2]);
	if($downnum=="") $downnum=0;if($viewnum=="") $viewnum=0;
	$times=get_date($times);
	$alltitle=$songname;
	$songname=gbsubstr($songname,0,$length);
	for ($ii=0; $ii<$singercount; $ii++){
		   $singerdetail=explode("|", trim($singerlist[$ii]));
		   if ($singerdetail[1]==$detail[1] && $singerdetail[0]==$detail[0]){$singername=$singerdetail[2];break;}
		    }
    $showsinger=="1" ? $music.="$pre [<a href='$site_url/list.php?catid=$detail[0]&singerid=$detail[1]' target=_blank>$singername</a>] ":$music.="$pre ";
	$music.=" <a href='$site_url/play.php?id=$id' target=_blank>$songname</a>";
	$hits=="1"? $music.="<font color=$color>($viewnum)</font>" : $music.="";
 }
}else $music.="�������������";

echo "document.write(\"$music\");";
?>