<?php
/**
*  小鬼当家音乐系统 iShowMusic V1.2
*  Copyright (c) 2008 Ghost. All rights reserved.
*  Authors: Ghost
*           http://www.ishowsky.cn
*           ishowsky@163.com
*
**/

!defined('R_P') && exit('Forbidden');
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

//error_reporting(0);
unset($_ENV,$HTTP_ENV_VARS,$_REQUEST,$HTTP_POST_VARS,$HTTP_GET_VARS,$HTTP_POST_FILES,$HTTP_COOKIE_VARS);
if($_SERVER['HTTP_X_FORWARDED_FOR']){
	$onlineip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	$c_agentip=1;
}elseif($_SERVER['HTTP_CLIENT_IP']){
	$onlineip = $_SERVER['HTTP_CLIENT_IP'];
	$c_agentip=1;
}else{
	$onlineip = $_SERVER['REMOTE_ADDR'];
	$c_agentip=0;
}

foreach($_POST as $_key=>$_value){
	!ereg("^\_",$_key) && !isset($$_key) && $$_key=$_POST[$_key];
}
foreach($_GET as $_key=>$_value){
	!ereg("^\_",$_key) && !isset($$_key) && $$_key=$_GET[$_key];
}
strpos($adminjob,'..') !== false && exit('Forbidden');

!$_SERVER['PHP_SELF'] && $_SERVER['PHP_SELF']=$_SERVER['SCRIPT_NAME'];
$REQUEST_URI  = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];

if($adminjob=='quit'){
	Cookie('AdminUser','',0);
	ObHeader($admin_file);
}

$timestamp  = time();
require_once(R_P."inc/config.php");
require_once(R_P."inc/text_function.php");
require_once(R_P."$datadir/manager.php");

$cookietime = $timestamp+31536000;
$version   = "1.2";
$datapath  = $datadir;
$userpath  = $userdir;
$uppath    = $updir;
$stylepath = $skinpath;
$style	   = $skin;

if($_POST['adminpwd'] && $_POST['adminuser']){
	$pwuser		= $_POST['adminuser'];
	$AdminUser	= $timestamp."\t".$pwuser."\t".md5($_POST['adminpwd']);
	Cookie('AdminUser',$AdminUser);
}elseif(GetCookie('AdminUser')){
	$AdminUser = GetCookie('AdminUser');
}else{
	$AdminUser = '';
}
if($AdminUser){
	$CK			= explode("\t",$AdminUser);
	$adminuser = stripcslashes($CK[1]);
}else{
	$CK = $adminuser = '';
}
$right = checkpass($CK);
if ($right < 2) {
	if ($_POST['adminuser'] && $_POST['adminpwd']){
		adminmsg('密码错误');
	}
	include PrintEot('adminlogin');exit;
}elseif($_POST['adminuser']){
	ObHeader($REQUEST_URI);
}

function Add_S(&$array){
	if($array){
		foreach($array as $key=>$value){
			if(!is_array($value)){
				$array[$key]=addslashes($value);
			}else{
				Add_S($array[$key]);
			}
		}
	}
}

function checkpass($CK){
	global $datadir,$manager,$manager_pwd,$adminuser;
	if (!$CK)return false;
	if (!file_exists(R_P."$datadir/adminuser/".$adminuser.".php") || strpos($adminuser,"..")!==false) return false;
	$admindata=explode("|",readfrom(R_P."$datadir/adminuser/".$adminuser.".php"));
	if($CK[2] != $admindata[2])return false;
	if($admindata[3] < 2)return false;
	$right = $admindata[3];
	return $right;
}

function Cookie($ck_Var,$ck_Value,$ck_Time='F'){
	global $cookietime;
	if($ck_Time=='F') $ck_Time = $cookietime;
	setcookie($ck_Var,$ck_Value,$ck_Time);
}

function GetCookie($Var){
    return $_COOKIE[$Var];
}

function PrintEot($template,$EXT="htm"){
    global $skinpath;
	if(!$template) $template='N';
	$path=R_P."$skinpath/admin/$template.$EXT";
	return $path;
}
function ObHeader($URL){
	echo "<meta http-equiv='refresh' content='0;url=$URL'>";
	exit;
}
function GetLang($lang,$EXT="php"){
	$path=R_P."inc/admin_$lang.$EXT";
	return $path;
}
function adminmsg($msg,$jumpurl='',$t=2){
	extract($GLOBALS, EXTR_SKIP);
	!$basename && $basename=$REQUEST_URI;
	if($jumpurl!=''){
		$ifjump="<META HTTP-EQUIV='Refresh' CONTENT='$t; URL=$jumpurl'>";
	}
	include PrintEot('message');exit;
}
function readfrom($file_name) {
	$filenum=@fopen($file_name,"r");
	@flock($filenum,LOCK_SH);
	$file_data=@fread($filenum,filesize($file_name));
	@fclose($filenum);
	return $file_data;
}
function writeto($file_name,$infoata,$method="w") {
	$filenum=@fopen($file_name,$method);
	flock($filenum,LOCK_EX);
	$file_data=fwrite($filenum,$infoata);
	fclose($filenum);
	return $file_data;
}

function get_next_filename($list) {
  global $datadir;
  $list=explode("\n",$list,11);
  $count=min(count($list),11);
  $filecount=0;
  for ($i=0; $i<$count; $i++) {
    $temp=explode("|",$list[$i]);
    $thiscount=$temp[2];   
    if ($thiscount>$filecount) $filecount=$thiscount;
  }
  $filecount++;
  while (file_exists(R_P."$datadir/data/$filecount.php")) $filecount++;
  return("$filecount");
}
function get_catid() {
global $cat_name,$catid,$cat_time,$ckeckid,$datadir;
$list=file(R_P."$datadir/cat.php");
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

function get_singerid() {
global $singer_name,$catid,$singerid,$singer_time,$nckeckid,$datadir;
$list=file(R_P."$datadir/singer.php");
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

function PageNav($maxpageno,$sum,$page,$url,$colspan){
global $perpage;
echo"<tr class=bg><td colspan=$colspan align=right>";
if ($maxpageno<=1) echo " 共有记录 {$sum} 条 | 只有一页";
else { 
      $nextpage=$page+1;
      $previouspage=$page-1;
	  echo " 共有记录 {$sum} 条 | ";
	  if ($page<=1) echo " 首页　上一页　<a href={$url}page=$nextpage>下一页</a>　<a href={$url}page=$maxpageno>尾页</a> ";
	  elseif($page>=$maxpageno) echo " <a href={$url}page=1>首页</a>　<a href={$url}page=$previouspage>上一页</a>　下一页　尾页 ";
	  else echo " <a href={$url}page=1>首页</a>　<a href={$url}page=$previouspage>上一页</a>　<a href={$url}page=$nextpage>下一页</a>　<a href={$url}page=$maxpageno>尾页</a> ";
	  echo " | $page/$maxpageno  {$perpage}个/页 ";
  }
  echo"</td></tr>";
}
function ieconvert($msg){
	$msg = str_replace("\t","",$msg);
	$msg = str_replace("\r","",$msg);
	$msg = str_replace("\n","<br />",$msg);
	$msg = str_replace("|","│",$msg);
	$msg = str_replace("   "," &nbsp; ",$msg);//允许html
	return $msg;       
}

function HtmlConvert(&$array){
	if(is_array($array)){
		foreach($array as $key => $value){
			if(!is_array($value)){
				$array[$key]=htmlspecialchars($value);
			}else{
				HtmlConvert($array[$key]);
			}
		}
	} else{
		$array=htmlspecialchars($array);
	}
}

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
	$msg = str_replace("|","│",$msg);//&#124
	$msg = str_replace("   "," &nbsp; ",$msg);
	return $msg;
}
function Char_cv($msg){
	$msg = str_replace("\t","",$msg);
	$msg = str_replace("<","&lt;",$msg);  
	$msg = str_replace(">","&gt;",$msg);
	$msg = str_replace("\r","",$msg);
	$msg = str_replace("\n","<br />",$msg);
	$msg = str_replace("|","│",$msg);
	$msg = str_replace("   "," &nbsp; ",$msg);//禁止html
	return $msg;
}
function ifcheck($var,$out){
	global ${$out.'_Y'},${$out.'_N'};
	if($var) ${$out.'_Y'}="CHECKED"; else ${$out.'_N'}="CHECKED";

}
?>