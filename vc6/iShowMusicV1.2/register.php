<?php
require("global.php");
$subtitle='ע���Ա';

/* �����Ƽ� */
$commend="commend";

/* �������� */
$top="viewhot";

if (GetCookie('userlogin')=="1"){
	Showmsg("no","���Ѿ���¼�������ظ�ע��", "����", "javascript:history.back(-1)");
	exit; }
	
if ($regon=='0'){  //�Ƿ񿪷�ע��
	Showmsg("no","����Ա�Ѿ��ر�ע�ᣡ���Ժ�������", "������ҳ", "index.php");
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
	    Showmsg("no","�Ѿ��д��û����������!", "����������д", "javascript:history.back(-1)");
		exit;
	}
	if($userpassc!=$userpassc1) {
	    Showmsg("no","�����������벻һ�£��뷵��������д!", "����������д", "javascript:history.back(-1)");
		exit;
	}
	if(!ereg("^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+",$usermail)){
	    Showmsg("no","�����ʽ�����뷵��������д!", "����������д", "javascript:history.back(-1)");
		exit;
	}
	
	$regbanname=explode(',',$regbanname);
 	foreach($regbanname as $value){
		if(strpos($usernamec,$value)!==false){
	    Showmsg("no","���û���������Ա��ֹ�������!", "����������д", "javascript:history.back(-1)");
		exit;
		}
	} 

// Discuz�ӿ�
    $username=$usernamec;
	$password=md5($userpassc);
	$email=$usermail;
	$time2=$timestamp;
// Discuz�ӿ�

	$usernicheng = safeconvert($usernicheng);
	$usernicheng=stripslashes($usernicheng);
	$userpassc=md5($userpassc);
	$regtime=time();
	$reglevel=$regright;//��Ա�ȼ�,��ϵͳ����������
	$addlrcnum="0";//��Ӹ��ƪ��
	$commendsong="0";//�Ƽ�������
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
	  Showmsg("yes","��л����ע�ᣬ���������Կ�ʼʹ�����Ļ�ԱȨ����", "�����Ա����", "member.php");
	  exit;
	}
}  
?>
