<?php
require("global.php");
$subtitle='�޸�����';

//��������
$top="viewhot";

if (GetCookie('userlogin')!="1"){
	Showmsg("no","����û�е�¼��ע��!","��¼��ע��", "login.php?jumpurl=editpsd.php");
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
	    Showmsg("no","���벻��Ϊ�գ�����д����!", "����������д", "javascript:history.back(-1)");
		exit;
	}
	
    $user_info=@file("$userdir/$username.php");
    list($user_name,$user_nicheng,$user_pass,$user_level,$user_mail,$add_lrcnum,$commend_song,$reg_time)=explode("|",$user_info[1]);
    if ($user_pass!=md5($oldpsd)) {
		Showmsg("no","ԭ�������","����������д","javascript:history.back(-1)");
		exit;
	}
	if($newpsd!=$repnewpsd) {
	    Showmsg("no","�����������벻һ�£��뷵��������д!", "����������д", "javascript:history.back(-1)");
		exit;
	}
    $new_psd=md5($newpsd);
    $new_line=array($user_name,$user_nicheng,$new_psd,$user_level,$user_mail,$add_lrcnum,$commend_song,$reg_time);
	$line=implode("|",$new_line)."|\n";
    $line="<? exit;?>\n".$line;
	writetofile("$userdir/$username.php",$line);
	if (!$jumpurl) $jumpurl="member.php"; 
	Showmsg("yes","�����޸ĳɹ���2 ���ҳ�潫�Զ���ת���µ�ҳ��","�Զ���ת", $jumpurl);
	exit;
}  
?>
