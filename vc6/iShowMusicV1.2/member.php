<?php
require("global.php");
$subtitle='��Ա����';

if (GetCookie('userlogin')!="1"){
	Showmsg("no","����û�е�¼!","��¼", "login.php?jumpurl=member.php");
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