<?php
require("global.php");
$subtitle='点歌送人';

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
    Showmsg("no","你还未选择歌曲呢!","返回重新填写","javascript:history.back(-1)"); exit;}
  elseif(empty($_POST['user'])) {
    Showmsg("no","你还没写名字呢!","返回重新填写","javascript:history.back(-1)"); exit;}
  elseif(empty($_POST['user2'])){
    Showmsg("no","你想送给谁啊？","返回重新填写","javascript:history.back(-1)"); exit; }
  elseif(empty($_POST['say'])) {
    Showmsg("no","难道你没什么想说的吗？","返回重新填写","javascript:history.back(-1)"); exit; }
  elseif($dgmail && !isemail($umail)){
    Showmsg("no","E-mail 格式错误","返回重新填写","javascript:history.back(-1)"); exit; }
  else{
  $user=safeconvert($_POST['user']);
  $user2=safeconvert($_POST['user2']);
  $say=safeconvert($_POST['say']);
  //$songname=safeconvert($songname);
  $line="$user|$user2|$songname|$id|$time|$say|$umail|\n";
  $diange="$datadir/diange.php";
  writetofile($diange,$line,"a+");
  
   if($dgmail){
    $email_subject="您好的好友点歌送给您了!";
	$email_message="尊敬的 $user2 先生(女士):<br>您的好友 $user 为您好点了一首 $songname 送给您,快来看看吧!<br><br>详细信息请 <a href='$site_url/dgplay.php?time=$time' target=_blank><b>点击这点</b><br>注意:此邮件是系统发送,请勿回复!";
	$email_from = "$site_name 点歌台<$admin_email>";
	sendmail($umail, $email_subject, $email_message, $email_from);
    }
  Showmsg("yes","恭喜你，点歌成功！","去点歌发布栏看看","song.php");  exit;
  }
}  
?>
