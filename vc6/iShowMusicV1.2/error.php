<?php
require("global.php");
$subtitle='�������';

if (GetCookie('userlogin')=="1") $usernicheng=GetCookie('usernicheng'); else $usernicheng='';

if(empty($action)) {
  require("header.php");
  include_once PrintEot('error');
  footer();
}
 elseif ($_POST['action']=="save"){
  $cknumon && GdConfirm($gdcode);
  if(empty($id)) { 
    Showmsg("no","�㻹δѡ�������!","����������д","javascript:history.back(-1)"); exit;}
  elseif(empty($_POST['user'])) {
    Showmsg("no","�㻹ûд������!","����������д","javascript:history.back(-1)"); exit;}
  else{
   $user=safeconvert($user);
   $line="$user|$songname|$id|$errmsg|$timestamp|\n";
   $e="$datadir/error.php";
   writetofile($e,$line,"a+");
   Showmsg("yes","�ύ�ɹ���лл����֧�֣�","�رձ�ҳ","javascript:window.close()");  exit;
  }
}  
?>
