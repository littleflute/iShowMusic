<?php
require("global.php");
require("inc/discuz.php");
$subtitle='��Ա��¼';

//��������
$top="viewhot";

if(empty($action)){ 
  if (GetCookie('userlogin')=="1"){
	Showmsg("no","���Ѿ���¼�������ٵ�¼","����", "javascript:history.back(-1)");
	exit; 
  }
  require("header.php");
  include_once PrintEot('login');
  footer();
  exit;
}
elseif ($action=="login"){
    
	$cknumon && GdConfirm($gdcode);
	
  	if (!file_exists("$userdir/$username.php")) {
	    Showmsg("no","�޴��û����������!","����������д","javascript:history.back(-1)");
		exit;
	}
	if (empty($username) || empty($userpass)) {
	    Showmsg("no","�û��������벻��Ϊ�գ�����д�������¼!","����������д","javascript:history.back(-1)");
		exit;
	}
	else{
    $user_info=@file("$userdir/$username.php");
    list($user_name,$user_nicheng,$user_pass,$user_level,$user_mail,$add_lrcnum,$commend_song,$reg_time)=explode("|",$user_info[1]);
    if ($user_name!=$username || $user_pass!=md5($userpass)) {
		Showmsg("no","�û������������","����������д","javascript:history.back(-1)");
		exit;
	}
	
	// Discuz�ӿ�
	$password=md5($userpass);
	$email=$user_mail;
	$time2=$timestamp;
    // Discuz�ӿ�

    $cktime != 0 && $cktime += $timestamp;
	Cookie("username",$user_name,$cktime);
	Cookie("userlogin","1",$cktime);
	Cookie("usernicheng",$user_nicheng,$cktime);
	Cookie("userlever",$user_level,$cktime);
	Cookie("userpass",$userpass,$cktime);
    Cookie("user_mail",$user_mail,$cktime);
	if (!$jumpurl) $jumpurl="member.php"; 

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
	Showmsg("yes","��¼�ɹ���2 ���ҳ�潫�Զ���ת���µ�ҳ��","�Զ���ת", $jumpurl);
	exit;
	}
  }
}  
elseif ($action=="out"){
    if( $isdiscuz && $discuz && $passport_key ){
	  $username=GetCookie('username');
	  $password=md5(GetCookie('userpass'));
	  $email=GetCookie('user_mail');
	  $time2=$timestamp;

	  $member = array
		(
		'time'		=> $time2,
		'username'	=> $username,
		'password'	=> $password,
		'email'		=> $email,
		);

    $action		= 'logout';
	$auth		= passport_encrypt(passport_encode($member), $passport_key);
	$forward ?  $_GET['forward'] : $site_url."/index.php";
	$verify		= md5($action.$auth.$forward.$passport_key);
    
   	Cookie("username","");
	Cookie("userlogin","");
	Cookie("usernicheng","");
	Cookie("userlever","");
	Cookie("userpass","");
    Cookie("user_mail","");
 header("Location:".$discuz."/api/passport.php"."?action=$action"."&auth=".rawurlencode($auth)."&forward=".rawurlencode($forward)."&verify=$verify");
 exit;
	}else{

	Cookie("username","");
	Cookie("userlogin","");
	Cookie("usernicheng","");
	Cookie("userlever","");
	Cookie("userpass","");
    Cookie("user_mail","");
	Showmsg("yes","��ȫ�˳���2 ���ҳ�潫�Զ���ת����ҳ","������ҳ","index.php");
	exit;
	}
} 
?>
