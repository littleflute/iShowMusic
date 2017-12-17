<?php
require("global.php");
$subtitle='报告错误';

if (GetCookie('userlogin')=="1") $usernicheng=GetCookie('usernicheng'); else $usernicheng='';

if(empty($action)) {
  require("header.php");
  include_once PrintEot('error');
  footer();
}
 elseif ($_POST['action']=="save"){
  $cknumon && GdConfirm($gdcode);
  if(empty($id)) { 
    Showmsg("no","你还未选择歌曲呢!","返回重新填写","javascript:history.back(-1)"); exit;}
  elseif(empty($_POST['user'])) {
    Showmsg("no","你还没写名字呢!","返回重新填写","javascript:history.back(-1)"); exit;}
  else{
   $user=safeconvert($user);
   $line="$user|$songname|$id|$errmsg|$timestamp|\n";
   $e="$datadir/error.php";
   writetofile($e,$line,"a+");
   Showmsg("yes","提交成功，谢谢您的支持！","关闭本页","javascript:window.close()");  exit;
  }
}  
?>
