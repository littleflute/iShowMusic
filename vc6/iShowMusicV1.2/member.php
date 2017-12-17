<?php
require("global.php");
$subtitle='会员中心';

if (GetCookie('userlogin')!="1"){
	Showmsg("no","您还没有登录!","登录", "login.php?jumpurl=member.php");
	exit; 
  }
   else { $username=GetCookie('username'); }
   
   $user_info=@file("$userdir/$username.php");
   list($user_name,$user_nicheng,$user_pass,$user_level,$user_mail,$add_lrcnum,$commend_song,$reg_time)=explode("|",$user_info[1]);
   
   require("header.php");
   include_once PrintEot('member');
   footer();
   exit;
?>