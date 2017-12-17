<?php
/*************************************************
^^^^^^^^文本数据库自定义函数集0.2测试版^^^^^^^^^^^
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
此函数集适用于：以文本格式存储数据，以一行为一条记录，以分隔符分隔字段的文本结构数据库。
联系方法：xbrid@163.com
技术支持：http://PHPLink.126.com
版权所有：PHP初学者联盟，未经允许不得删除版权信息
程序编写：xbrid
修改日期：2003.04.30
**************************************************/
/*
使用方法：
注意：在文本数据库中，如果使用关键字，此关键字最好要唯一，否则其删除修改时只会操作第一条记录。
text_append($filename,$linecon)→数据追加函数，返回1为成功，0为不成功
text_locate($filename,$keyword,$cutword,$colnum)→数据查找函数，如果查找到则返回此条记录，否则返回0
text_delete($filename,$keyword,$cutword,$colnum)→数据删除函数，如果有此记录则删除并返回1，否则返回0
text_modify($filename,$keyword,$cutword,$colnum,$modify)→数据修改函数，如果有此记录并修改成功返回1，否则返回0
text_insert($filename,$keyword,$cutword,$colnum,$insert)→数据插入函数，插入在关键字记录前
text_insertb($filename,$keyword,$cutword,$colnum,$insert)→数据插入函数，插入在关键字记录前
text_sort($filename,$cutword,$colnum,$mode)→数据排序函数，排序后文件被排序后生成的文件覆盖
text_select($filename,$keyword,$cutword,$colnum)→多条记录查找函数，返回多条与关键字相同的记录
text_find($filename,$keyword,$cutword,$colnum)→模糊查询函数，返回字段中包含关键字的所有记录


$filename→文件名
$linecon→要追加的内容
$keyword→查找或删除等操作时使用的关键字，此关键字要唯一。
$cutword→分隔符
$colnum→关键字（字段）所在的列，列是从0开始排列的
$modify→要修改的内容

修改或追加的内容要与本函数库适用的格式相符合
*/

//数据库追加函数
function text_append($filename,$linecon)
{
	$fp=fopen($filename,"a");
	flock($fp,2);
	$file=fwrite($fp,$linecon);
	fclose($fp);
	return $file;
}
//文本数据库查找函数→结果是返回第一条记录
function text_locate($filename,$keyword,$cutword,$colnum)
{
	$filelist=file($filename);
	$listnum=count($filelist);
	for ($i=0;$i<$listnum;$i++) {
		$list=explode($cutword,$filelist[$i]);
		if ($keyword==$list[$colnum]) {
			return $list;
		}
	}
	return 0;
}
//文本数据库删除记录函数
function text_delete($filename,$keyword,$cutword,$colnum)
{
	$filelist=file($filename);
	$listnum=count($filelist);
	$fp=fopen($filename,"w");
	flock($fp,2);
	$yesno=1;
	for ($i=0;$i<$listnum;$i++) {
		$list=explode($cutword,$filelist[$i]);
		if ($keyword==$list[$colnum] and $yesno==1) {
			$yesno=0;
			$returnkey=1;
			continue;
		}
		fputs($fp,$filelist[$i]);
	}
	fclose($fp);
	if (empty($returnkey)) $returnkey=0;
	return $returnkey;
}
//文本数据库修改记录函数
function text_modify($filename,$keyword,$cutword,$colnum,$modify)
{
	$filelist=file($filename);
	$listnum=count($filelist);
	$fp=fopen($filename,"w");
	flock($fp,2);
	$yesno=1;
	for ($i=0;$i<$listnum;$i++) {
		$list=explode($cutword,$filelist[$i]);
		if ($keyword==$list[$colnum] and $yesno==1) {
			fputs($fp,$modify);
			$yesno=0;
			$returnkey=1;
			continue;
		}
		fputs($fp,$filelist[$i]);
	}
	fclose($fp);
	if (empty($returnkey)) $returnkey=0;
	return $returnkey;
}
//文本数据库插入记录函数→插入以关键字为记录的前面
function text_insert($filename,$keyword,$cutword,$colnum,$insert)
{
	$filelist=file($filename);
	$listnum=count($filelist);
	$fp=fopen($filename,"w");
	flock($fp,2);
	for ($i=0;$i<$listnum;$i++) {
		$list=explode($cutword,$filelist[$i]);
		if ($keyword==$list[$colnum]) {
			fputs($fp,$insert);
		}
		fputs($fp,$filelist[$i]);
	}
	fclose($fp);
}
//文本数据库插入记录函数→插入以关键字为记录的后面
function text_insertb($filename,$keyword,$cutword,$colnum,$insert)
{
	$filelist=file($filename);
	$listnum=count($filelist);
	$fp=fopen($filename,"w");
	flock($fp,2);
	for ($i=0;$i<$listnum;$i++) {
		fputs($fp,$filelist[$i]);
		$list=explode($cutword,$filelist[$i]);
		if ($keyword==$list[$colnum]) {
			fputs($fp,$insert);
			$returnkey=1;
		}
	}
	fclose($fp);
	if (empty($returnkey)) $returnkey=0;
	return $returnkey;
}
//文本数据库排序
function text_sort($filename,$cutword,$colnum,$mode)
{
	$list=file($filename);
	for ($i=0;$i<count($list);$i++) {
		$list1= explode($cutword, $list[$i]);
		$list2[($list[$i])]=$list1[$colnum]+1;
	}
	if ($mode=="a") {
		@asort($list2);
		@reset($list2);
	}
	if ($mode=="d") {
		@arsort($list2);
		@reset($list2);
	}
	for ($all=0;$all<=count($list2);$all++) {
		$newlist[] = key($list2);
		if (!(next($list2))) break;
	}
	$fp=fopen($filename,"w");
	flock($fp,2);
	$listnum=count($newlist);
	for ($i=0;$i<$listnum;$i++) {
		fputs($fp,$newlist[$i]);
	}
	fclose($fp);
}
//文本数据库多条记录查找函数→返回所有与关键字相同的数据
function text_select($filename,$keyword,$cutword,$colnum)
{
	$filelist=file($filename);
	$listnum=count($filelist);
	for ($i=0;$i<$listnum;$i++) {
		$list=explode($cutword,$filelist[$i]);
		if ($keyword==$list[$colnum]) {
			$newlist[]=$filelist[$i];
		}
	}
	if (empty($newlist)) return 0;
	else return $newlist;
}
//文本数据库模糊查找函数→返回所有包含关键字的数据
function text_find($filename,$keyword,$cutword,$colnum)
{
	$filelist=file($filename);
	$listnum=count($filelist);
	for ($i=0;$i<$listnum;$i++) {
		$list=explode($cutword,$filelist[$i]);
		if (eregi($keyword,$list[$colnum])) {
			$newlist[]=$filelist[$i];
		}
	}
	if (empty($newlist)) return 0;
	else return $newlist;
}
//自定义的数组排序
function array_sort($list,$cutword,$colnum,$mode)
{
	for ($i=0;$i<count($list);$i++) {
		$list1= explode($cutword, $list[$i]);
		$list2[$list[$i]]=$list1[$colnum];
	}
	if ($mode=="a") {
		@asort($list2);
		@reset($list2);
	}
	if ($mode=="d") {
		@arsort($list2);
		@reset($list2);
	}
	for ($all=0;$all<count($list2);$all++) {
		$newlist[]=key($list2);
		if (!(next($list2))) break;
	}
	return $newlist;
}
?>