<?php
require("global.php");
$subtitle='���ַ���';
require("header.php");

function get_sort(){

global $datadir,$skinpath,$skin;
$sort_list="";
$list=file("$datadir/cat.php");
$count=count($list);
echo"-->";
for ($i=0; $i<$count; $i++) {
	$list_info=explode("|",$list[$i]);
	$sort_list.="<p><a href=\"list.php?catid=$list_info[0]\" target=\"_blank\"><h2>$list_info[1]</h2></a></p><div id=\"Content\">";
$list1=file("$datadir/singer.php");
$count1=count($list1)-1;
for ($i1=0; $i1<=$count1; $i1++) {
	$list_info1=explode("|",$list1[$i1]);
	if($list_info1[0]==$list_info[0])	
	$sort_list.="<span class=\"SingerContent\"><a href=\"list.php?catid=$list_info[0]&singerid=$list_info1[1]\"  title=\"$list_info1[2]ר��\" target=\"_blank\">$list_info1[2]</a></span>";
                 }
	$sort_list.="</div>";
         }
echo "$sort_list";
echo"<!--";
}


/* �����Ƽ� */
$commend="commend";

/* ���� */
$top="viewhot";

include_once PrintEot('sort');
footer();
 
?>
