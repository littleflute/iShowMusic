<?php
require("global.php");
$subtitle='�������';

if (GetCookie('userlogin')=="1") $usernicheng=GetCookie('usernicheng'); else $username='';

if(empty($action)) $action="dg";

if ($action=="dg"){ 
  require("header.php");
  include_once PrintEot('dg');
  footer();
}
 elseif ($_POST['action']=="add"){
  $cknumon && GdConfirm($gdcode);
  if(empty($id)) { 
    Showmsg("no","�㻹δѡ�������!","����������д","javascript:history.back(-1)"); exit;}
  elseif(empty($_POST['user'])) {
    Showmsg("no","�㻹ûд������!","����������д","javascript:history.back(-1)"); exit;}
  elseif(empty($_POST['user2'])){
    Showmsg("no","�����͸�˭����","����������д","javascript:history.back(-1)"); exit; }
  elseif(empty($_POST['say'])) {
    Showmsg("no","�ѵ���ûʲô��˵����","����������д","javascript:history.back(-1)"); exit; }
  elseif($dgmail && !isemail($umail)){
    Showmsg("no","E-mail ��ʽ����","����������д","javascript:history.back(-1)"); exit; }
  else{
  $user=safeconvert($_POST['user']);
  $user2=safeconvert($_POST['user2']);
  $say=safeconvert($_POST['say']);
  //$songname=safeconvert($songname);
  $line="$user|$user2|$songname|$id|$time|$say|$umail|\n";
  $diange="$datadir/diange.php";
  writetofile($diange,$line,"a+");
  
   if($dgmail){
    $email_subject="���õĺ��ѵ���͸�����!";
	$email_message="�𾴵� $user2 ����(Ůʿ):<br>���ĺ��� $user Ϊ���õ���һ�� $songname �͸���,����������!<br><br>��ϸ��Ϣ�� <a href='$site_url/dgplay.php?time=$time' target=_blank><b>������</b><br>ע��:���ʼ���ϵͳ����,����ظ�!";
	$email_from = "$site_name ���̨<$admin_email>";
	sendmail($umail, $email_subject, $email_message, $email_from);
    }
  Showmsg("yes","��ϲ�㣬���ɹ���","ȥ��跢��������","song.php");  exit;
  }
}  
?>
