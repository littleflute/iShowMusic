<?php
require("global.php");
$subtitle='修改密码';

//试听排行
$top="viewhot";

if (GetCookie('userlogin')!="1"){
	Showmsg("no","您还没有登录或注册!","登录或注册", "login.php?jumpurl=editpsd.php");
	exit; 
  }
   else { $username=GetCookie('username'); }
   
if(empty($action)){ 
  require("header.php");
  include_once PrintEot('editpsd');
  footer();
  exit;
}
elseif ($_POST['action']=="save"){

    $cknumon && GdConfirm($gdcode);
	
    if(!$oldpsd || !$newpsd || !$repnewpsd) {
	    Showmsg("no","密码不能为空！请填写完整!", "返回重新填写", "javascript:history.back(-1)");
		exit;
	}
	
    $user_info=@file("$userdir/$username.php");
    list($user_name,$user_nicheng,$user_pass,$user_level,$user_mail,$add_lrcnum,$commend_song,$reg_time)=explode("|",$user_info[1]);
    if ($user_pass!=md5($oldpsd)) {
		Showmsg("no","原密码错误！","返回重新填写","javascript:history.back(-1)");
		exit;
	}
	if($newpsd!=$repnewpsd) {
	    Showmsg("no","两次密码输入不一致，请返回重新填写!", "返回重新填写", "javascript:history.back(-1)");
		exit;
	}
    $new_psd=md5($newpsd);
    $new_line=array($user_name,$user_nicheng,$new_psd,$user_level,$user_mail,$add_lrcnum,$commend_song,$reg_time);
	$line=implode("|",$new_line)."|\n";
    $line="<? exit;?>\n".$line;
	writetofile("$userdir/$username.php",$line);
	if (!$jumpurl) $jumpurl="member.php"; 
	Showmsg("yes","密码修改成功！2 秒后页面将自动跳转到新的页面","自动跳转", $jumpurl);
	exit;
}  
?>
