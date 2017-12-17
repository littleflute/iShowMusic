<?php
/*************************************************
^^^^^^^^�ı����ݿ��Զ��庯����0.2���԰�^^^^^^^^^^^
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
�˺����������ڣ����ı���ʽ�洢���ݣ���һ��Ϊһ����¼���Էָ����ָ��ֶε��ı��ṹ���ݿ⡣
��ϵ������xbrid@163.com
����֧�֣�http://PHPLink.126.com
��Ȩ���У�PHP��ѧ�����ˣ�δ��������ɾ����Ȩ��Ϣ
�����д��xbrid
�޸����ڣ�2003.04.30
**************************************************/
/*
ʹ�÷�����
ע�⣺���ı����ݿ��У����ʹ�ùؼ��֣��˹ؼ������ҪΨһ��������ɾ���޸�ʱֻ�������һ����¼��
text_append($filename,$linecon)������׷�Ӻ���������1Ϊ�ɹ���0Ϊ���ɹ�
text_locate($filename,$keyword,$cutword,$colnum)�����ݲ��Һ�����������ҵ��򷵻ش�����¼�����򷵻�0
text_delete($filename,$keyword,$cutword,$colnum)������ɾ������������д˼�¼��ɾ��������1�����򷵻�0
text_modify($filename,$keyword,$cutword,$colnum,$modify)�������޸ĺ���������д˼�¼���޸ĳɹ�����1�����򷵻�0
text_insert($filename,$keyword,$cutword,$colnum,$insert)�����ݲ��뺯���������ڹؼ��ּ�¼ǰ
text_insertb($filename,$keyword,$cutword,$colnum,$insert)�����ݲ��뺯���������ڹؼ��ּ�¼ǰ
text_sort($filename,$cutword,$colnum,$mode)��������������������ļ�����������ɵ��ļ�����
text_select($filename,$keyword,$cutword,$colnum)��������¼���Һ��������ض�����ؼ�����ͬ�ļ�¼
text_find($filename,$keyword,$cutword,$colnum)��ģ����ѯ�����������ֶ��а����ؼ��ֵ����м�¼


$filename���ļ���
$linecon��Ҫ׷�ӵ�����
$keyword�����һ�ɾ���Ȳ���ʱʹ�õĹؼ��֣��˹ؼ���ҪΨһ��
$cutword���ָ���
$colnum���ؼ��֣��ֶΣ����ڵ��У����Ǵ�0��ʼ���е�
$modify��Ҫ�޸ĵ�����

�޸Ļ�׷�ӵ�����Ҫ�뱾���������õĸ�ʽ�����
*/

//���ݿ�׷�Ӻ���
function text_append($filename,$linecon)
{
	$fp=fopen($filename,"a");
	flock($fp,2);
	$file=fwrite($fp,$linecon);
	fclose($fp);
	return $file;
}
//�ı����ݿ���Һ���������Ƿ��ص�һ����¼
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
//�ı����ݿ�ɾ����¼����
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
//�ı����ݿ��޸ļ�¼����
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
//�ı����ݿ�����¼�����������Թؼ���Ϊ��¼��ǰ��
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
//�ı����ݿ�����¼�����������Թؼ���Ϊ��¼�ĺ���
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
//�ı����ݿ�����
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
//�ı����ݿ������¼���Һ���������������ؼ�����ͬ������
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
//�ı����ݿ�ģ�����Һ������������а����ؼ��ֵ�����
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
//�Զ������������
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