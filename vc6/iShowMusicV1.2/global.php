<?php
/**
*  С��������ϵͳ iShowMusic V1.2
*  Copyright (c) 2008 Ghost. All rights reserved.
*  Authors: Ghost
*           http://www.ishowsky.cn
*           ishowsky@163.com
*
**/

$magic_quotes_gpc = get_magic_quotes_gpc();
$register_globals = @ini_get('register_globals');
if(!$register_globals || !$magic_quotes_gpc)
{
	@extract($HTTP_POST_FILES, EXTR_SKIP); 
	@extract($HTTP_POST_VARS, EXTR_SKIP); 
	@extract($HTTP_GET_VARS, EXTR_SKIP); 
}
@extract($_REQUEST);
@extract($GLOBALS, EXTR_SKIP);
require("inc/config.php");
require("inc/text_function.php");
require("$datadir/manager.php");

error_reporting(0);
unset($_ENV,$HTTP_ENV_VARS,$_REQUEST,$HTTP_POST_VARS,$HTTP_GET_VARS,$HTTP_POST_FILES,$HTTP_COOKIE_VARS);
foreach($_POST as $_key=>$_value){
	$_POST[$_key]=str_replace(array('|','$','..'),array('&#124;','&#36;','&#46;&#46;'),$_POST[$_key]);
	!ereg("^\_",$_key) && !$$_key && $$_key=$_POST[$_key];
}
foreach($_GET as $_key=>$_value){
	$_GET[$_key]=str_replace(array('|','$','..'),array('&#124;','&#36;','&#46;&#46;'),$_GET[$_key]);
	!ereg("^\_",$_key) && !$$_key && $$_key=$_GET[$_key];
}

$timestamp=time();
$iShow_Ver="1.2";
 if ($REQUEST_URI == $HTTP_COOKIE_VARS['lastpath'] && ($timestamp-$HTTP_COOKIE_VARS['lastvisit_fr']<$refreshtime)) {
	Showmsg("no","������ʾ��ֹ��ԭ�򣺷���ͬһURL��ˢ��ʱ��С��$refreshtime�롣","�رձ�ҳ","javascript:window.close()");
	exit;
	} 

//Cookie����
function Cookie($ck_Var,$ck_Value,$ck_Time = 'F'){
	global $timestamp;
	$ck_Time = $ck_Time == 'F' ? $timestamp + 31536000 : ($ck_Value == '' && $ck_Time == 0 ? $timestamp - 31536000 : $ck_Time);
	setcookie($ck_Var,$ck_Value,$ck_Time);
}
function GetCookie($Var){
    return $_COOKIE[$Var];
}

//��ֹIP����
$i_p=getenv('REMOTE_ADDR');
$i_p1 = getenv('HTTP_X_FORWARDED_FOR');
if (($i_p1 != "") && ($i_p1 != "unknown")) $i_p=$i_p1;
ipbanned();

function ipbanned() {
global $i_p,$datadir;
if (!file_exists("$datadir/ipbans.php")) return;
	$term_bannedmembers = file("$datadir/ipbans.php");
	if (empty($term_bannedmembers)) return;
	$count = count($term_bannedmembers);
	for ($i=0; $i<$count; $i++) {
		$bannedip = trim($term_bannedmembers[$i]);
		if (!$bannedip) continue;
		if ( strpos($i_p , $bannedip)===0 ) {
            Showmsg("no","�Բ������ IP ����ֹ����վ!�������ʣ�����ϵ����Ա��","�رձ�ҳ","javascript:window.close()");
			exit;		
		}
	}
}


// ��ȫת���������Ѳ���ϵͳ��ֹ�ı�ǩ�޳�
function safeconvert($msg){
	$msg = str_replace('&amp;','&',$msg);
	$msg = str_replace('&nbsp;',' ',$msg);
	$msg = str_replace('"','&quot;',$msg);
	$msg = str_replace("'",'&#39',$msg);
	$msg = str_replace("\t","   &nbsp;  &nbsp;",$msg);
	$msg = str_replace("<","&lt;",$msg);
	$msg = str_replace(">","&gt;",$msg);
	$msg = str_replace("\r","",$msg);
	$msg = str_replace("\n","<br />",$msg);
	$msg = str_replace("|","��",$msg);//&#124
	$msg = str_replace("   "," &nbsp; ",$msg);
	return $msg;
}
// ���ļ�
function readfromfile($file_name)
{
	$filenum = fopen($file_name, "r");
	flock($filenum, LOCK_SH);
	$file_data = fread($filenum, filesize($file_name));
	fclose($filenum);
	return $file_data;
} 
// д�ļ�
function writetofile($file_name, $data, $method = "w")
{
	$filenum = fopen($file_name, $method);
	flock($filenum, LOCK_EX);
	$file_data = fwrite($filenum, $data);
	fclose($filenum);
	return $file_data;
} 

//��ȡ�ļ���׺��
function lastfilename($file_name)
{
	$lastname=explode(".",$file_name);
	$lastnum=count($lastname)-1;
	return $lastname[$lastnum];
}
// �����ַ�����ȡ
function gbsubstr($str, $start, $len)
{
	$tmpstr="";
	if (strlen($str) > $len) {
		$strlen = $start + ($len-4);
		for($i = 0;$i < $strlen;$i++) {
			if (ord(substr($str, $i, 1)) > 0xa0){
				$tmpstr .= substr($str, $i, 2);
				$i++;
			}
			else {
				$tmpstr .= substr($str, $i, 1);
			}
		}
		$tmpstr .= "...";
		return $tmpstr;
	}
	else {
		return $str;
	}
}
//��֤��
function GdConfirm($code){
	global $datadir,$timestamp;
	$sid = GetCookie('sid');
	$ckdata=@file("$datadir/cknum.php");
	$c=count($ckdata);
	for($i=0;$i<=$c;$i++){
	   $detail=explode("|", trim($ckdata[$i]));
		if ($detail[0]==$sid) {
		  $nmsg=$detail[1];
		}
	}
	if(!$code || $nmsg!=$code){
		Showmsg("no","��֤�벻��ȷ���ѹ���","����","javascript:history.back(-1)");
	}else{
		$newnmsg=num_rand(4);
	    $ckline="<? die();?>|$sid|$newnmsg|$timestamp|\n";
        $ckdata="$datadir/cknum.php";
        text_modify($ckdata,$sid,"|","1",$ckline);
	}
}
function num_rand($lenth){
	mt_srand((double)microtime() * 1000000);
	for($i=0;$i<$lenth;$i++){
		$randval.= mt_rand(0,9);
	}
	return $randval;
}

//��ҳ����
function numofpage($count,$page,$numofpage,$url,$max=0)
{
	$total=$numofpage;
	$max && $numofpage > $max && $numofpage=$max;
	$pages="<span class=\"PageNav\">";
	if ($numofpage <= 1 || !is_numeric($page)){
	    $pages.="���м�¼ {$count} �� | ֻ��һҳ</span><br>";
		return $pages;
	}else{
		$pages.="��ҳ��$page/$numofpage &nbsp;&nbsp;<a href=\"{$url}page=1\">< Prev</a>";
		$flag=0;
		for($i=$page-3;$i<=$page-1;$i++)
		{
			if($i<1) continue;
			$pages.=" <a href='{$url}page=$i'>&nbsp;$i&nbsp;</a>";
		}
		$pages.="<span class=current>$page</span>";
		if($page<$numofpage)
		{
			for($i=$page+1;$i<=$numofpage;$i++)
			{
				$pages.=" <a href='{$url}page=$i'>&nbsp;$i&nbsp;</a>";
				$flag++;
				if($flag==4) break;
			}
		}
		$pages.="&nbsp;<input type='text' size='2' style='height:20px; border:1px solid #b7d8ee' onkeydown=\"javascript: if(event.keyCode==13) location='{$url}page='+this.value;\"> <a href=\"{$url}page=$numofpage\">Next ></a> &nbsp;</span><br>";
		return $pages;
	}
}

//ʱ�亯��

function get_time($infoatetime){
	$t=getdate($infoatetime);
	$hour=$t['hours'];
	$min=$t['minutes'];
	if (strlen($min)==1) $min="0".$min;
	return "{$hour}:{$min}";
}
function get_date($infoatetime){
	$t=getdate($infoatetime);
	$year=$t['year'];
	$mon=$t['mon'];
	$mday=$t['mday'];
	return "{$year}-{$mon}-{$mday}";
}
function get_datetime($infoatetime){
	$t=getdate($infoatetime);
	$year=$t['year'];
	$mon=$t['mon'];
	$mday=$t['mday'];
	$hour=$t['hours'];
	$min=$t['minutes'];
	return "{$year}-{$mon}-{$mday} {$hour}:{$min}";
}
//վ�㹫��
function GetNotice(){
global $datadir;
$noticelist=file("$datadir/announce.php");
$count=count($noticelist);
$list="-->\n";
if($count!=0){
 for($i=0;$i<$count;$i++){
    $detail=explode("|", trim($noticelist[$i]));
	$t=strftime("%Y/%m/%d",$detail[2]); ;
	$list.="<P><a href=\"notice.php?#".$detail[2]."\" target=_blank title=\"$detail[3]\" class=\"notice\">[$t] $detail[3]</a></P>";
   }
  }else $list.="��û�й�����Ϣ!";
  $list.="<!--";
  echo $list;
}
//���ַ�����ʾ
function MusicNav(){
global $datadir;
$list=file("$datadir/cat.php");
$count=count($list);
$catlist="-->\n";
for($i=0;$i<$count;$i++){
    $detail=explode("|", trim($list[$i]));
	$catlist.="<li><a href=\"list.php?catid=$detail[0]\">$detail[1]</a></li>";
   }
  $catlist.="<!--";
  echo $catlist;
}
//ȡ�����ַ���
function get_catid() {
global $cat_name,$catid,$cat_time,$ckeckid,$datadir;
$list=file("$datadir/cat.php");
$ckeckid=0;
	$count=count($list);
	for ($i=0; $i<$count; $i++) {
		$detail=explode("|", trim($list[$i]));
		if ($detail[0]==$catid) {
			$cat_name=$detail[1];
			$cat_time=$detail[2];
			$ckeckid=1;
			break;
		}
	}
}

//ȡ�ø��ַ���
function get_singerid() {
global $singer_name,$catid,$singerid,$singer_time,$nckeckid,$datadir;
$list=file("$datadir/singer.php");
$nckeckid=0;
	$count=count($list);
	for ($i=0; $i<$count; $i++) {
		$detail=explode("|", trim($list[$i]));
		if ($detail[1]==$singerid && $detail[0]==$catid) {
			$singer_name=$detail[2];
			$singer_time=$detail[3]; 
			$nckeckid=1;
			break;
		}
	}
}

//�Ƽ�����
//$j Ϊ�ض��ַ���������;$numΪ��ʾ����
function commend($url,$num,$j){
   if(empty($j)) $j=0;
   global $datadir;
   $song_info=@file("$datadir/$url.php");
   $c=min(count($song_info),$num);
   echo"-->"; 
    for ($i=0; $i<$c; $i++){ 
		$detail=explode("|",$song_info[$i]); 
        $allname=$detail[3];
		$listshow="";
		if($j!=0) {if (strlen($detail[3])>=24) $detail[3]=substr($detail[3],0,22)."...";}
	   else{ if (strlen($detail[3])>=32) $detail[3]=substr($detail[3],0,30)."...";}   //��ȡ�ַ���
        $listshow.= "<li><a href=\"play.php?id=$detail[2]\" title=\"$allname\" target=\"_blank\">$detail[3]</a></li>\n";
		echo $listshow;
		 }
	  echo"<!--";
}
//����
//$j Ϊ�ض��ַ���������;$numΪ��ʾ����
function top($url,$num,$j){
   if(empty($j)) $j=0;
   global $datadir,$skinpath,$skin;
   $song_info=@file("$datadir/$url.php");
   $c=min(count($song_info),$num); 
   echo"-->";
    for ($i=0; $i<$c; $i++){ 
		$detail=explode("|",$song_info[$i]); 
        $allname=$detail[3];
		$listshow="";
		if($j!=0) {if (strlen($detail[3])>=24) $detail[3]=substr($detail[3],0,22)."..";}
	   elseif (strlen($detail[3])>=32) { $detail[3]=substr($detail[3],0,30)."...";}   //��ȡ�ַ���
        $listshow.= "<li><a href=\"play.php?id=$detail[2]\" title=\"$allname\" target=_blank>$detail[3]</a></li>\n";
		echo $listshow;
		 }
 echo"<!--";
}
//��֤�ʼ�
function isemail($email) {
	return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
}
//�����ʼ�
function sendmail($email_to, $email_subject, $email_message, $email_from = ''){
  global $site_name,$site_url,$admin_email;
  $maildelimiter = "\r\n";
  $email_subject = '=?'.$charset.'?B?'.base64_encode(str_replace("\r", '', str_replace("\n", '', '['.$site_name.'] '.$email_subject))).'?=';
  $email_message = chunk_split(base64_encode(str_replace("\r\n.", " \r\n..", str_replace("\n", "\r\n", str_replace("\r", "\n", str_replace("\r\n", "\n", str_replace("\n\r", "\r", $email_message)))))));
  $email_from = $email_from == '' ? '=?'.$charset.'?B?'.base64_encode($site_name)."?= <$admin_email>" : (preg_match('/^(.+?) \<(.+?)\>$/',$email_from, $from) ? '=?'.$charset.'?B?'.base64_encode($from[1])."?= <$from[2]>" : $email_from);
  $headers = "From: $email_from{$maildelimiter}X-Priority: 3{$maildelimiter}X-Mailer: iShow Music! $iShow_Ver{$maildelimiter}MIME-Version: 1.0{$maildelimiter}Content-type: text/plain; charset=$charset{$maildelimiter}Content-Transfer-Encoding: base64{$maildelimiter}";

  if(function_exists('mail')) {
	@mail($email_to, $email_subject, $email_message, $headers);
   } 
}
//�ж��Ƿ��½
function GetIfLogin(){
  if (GetCookie('userlogin')=="1")
  return true;
}
//��Ϣ��ʾ
function Showmsg($yesno,$msg_info,$goto,$url){
    global $skinpath,$skin;
	require_once PrintEot('showmsg');
	exit;
}
//ҳ��ײ�
function footer(){
global $site_name,$site_url,$admin_email,$manager,$iShow_Ver;
	include PrintEot('footer');
	exit;
}

function SafePath($Path){
	if(strpos($Path,'..')!==false){
		Showmsg("no","�Ƿ�����,�뷵��!","����","javascript:history.back(1)");
	}
}

//ҳ��ģ�����
function PrintEot($template,$EXT="html"){
	global $skinpath,$skin;
	SafePath($template);
	if(empty($template)) $template='Nopage.$EXT';
	if(file_exists("./$skinpath/$skin/$template.$EXT"))
	$path="./$skinpath/$skin/$template.$EXT";
	else $path="./$skinpath/default/$template.$EXT";
	return $path;
}

?>