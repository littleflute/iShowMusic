<?php
require("global.php");
$subtitle='注册会员';

/* 音乐推荐 */
$commend="commend";

/* 试听排行 */
$top="viewhot";

if (GetCookie('userlogin')=="1"){
	Showmsg("no","你已经登录，不可重复注册", "返回", "javascript:history.back(-1)");
	exit; }
	
if ($regon=='0'){  //是否开放注册
	Showmsg("no","管理员已经关闭注册！请稍后再来！", "返回首页", "index.php");
	exit; }	
	
if(empty($action)) $action="reg";

if ($action=="reg"){ 
  require("header.php");
  include_once PrintEot('register');
  footer();
  exit;
}
 elseif ($action=="save"){
 
    $cknumon && GdConfirm($gdcode);
	
  	if (file_exists("$userdir/$usernamec.php")) {
	    Showmsg("no","已经有此用户名，请更改!", "返回重新填写", "javascript:history.back(-1)");
		exit;
	}
	if($userpassc!=$userpassc1) {
	    Showmsg("no","两次密码输入不一致，请返回重新填写!", "返回重新填写", "javascript:history.back(-1)");
		exit;
	}
	if(!ereg("^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+",$usermail)){
	    Showmsg("no","邮箱格式错误，请返回重新填写!", "返回重新填写", "javascript:history.back(-1)");
		exit;
	}
	
	$regbanname=explode(',',$regbanname);
 	foreach($regbanname as $value){
		if(strpos($usernamec,$value)!==false){
	    Showmsg("no","此用户名被管理员禁止，请更改!", "返回重新填写", "javascript:history.back(-1)");
		exit;
		}
	} 

// Discuz接口
    $username=$usernamec;
	$password=md5($userpassc);
	$email=$usermail;
	$time2=$timestamp;
// Discuz接口

	$usernicheng = safeconvert($usernicheng);
	$usernicheng=stripslashes($usernicheng);
	$userpassc=md5($userpassc);
	$regtime=time();
	$reglevel=$regright;//会员等级,在系统参数里设置
	$addlrcnum="0";//添加歌词篇数
	$commendsong="0";//推荐歌曲数
	$reglist="$usernamec|$usernicheng|$reglevel|$regtime||\n";
	$reg_line=array($usernamec,$usernicheng,$userpassc,$reglevel,$usermail,$addlrcnum,$commendsong,$regtime);
	$line=implode("|",$reg_line)."|\n";
    $line="<? exit;?>\n".$line;
	writetofile("$userdir/$usernamec.php",$line);
	writetofile("$userdir/list.php",$reglist,"a");
	Cookie("username",$usernamec);
	Cookie("userlogin","1");
	Cookie("usernicheng",$usernicheng);
	Cookie("userlever",$reglevel);
	Cookie("userpass",$userpassc1);
	Cookie("user_mail",$usermail);

    require("inc/discuz.php");
	
	if($isdiscuz && $discuz && $passport_key){
	$member = array
		(
		'time'		=> $time2,
		'username'	=> $username,
		'password'	=> $password,
		'email'		=> $email,
		);

    $action		= 'login';
	$auth		= passport_encrypt(passport_encode($member), $passport_key);
	$forward ? 	$_GET['forward'] : $site_url."/index.php";
	$verify		= md5($action.$auth.$forward.$passport_key);

	header("Location:".$discuz."/api/passport.php"."?action=$action"."&auth=".rawurlencode($auth)."&forward=".rawurlencode($forward)."&verify=$verify");
	exit;
	}else{
	  Showmsg("yes","感谢您的注册，现在您可以开始使用您的会员权利了", "进入会员中心", "member.php");
	  exit;
	}
}  
?>
