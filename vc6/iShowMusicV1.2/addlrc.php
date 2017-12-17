<?php
require("global.php");
$subtitle='添加歌词';

if (empty($id)){
	Showmsg("no","非法请求!","关闭页面", "javascript:window.close()");
	exit; 
  }
  
if (file_exists($datadir."/lrc/$id.lrc")){
	Showmsg("no","数据库里已有本音乐歌词,无需再添加","关闭页面", "javascript:window.close()");
	exit; 
  }  
  
if (GetCookie('userlogin')!="1" || GetCookie('userlever')<"1"){
	Showmsg("no","您还没有登录或注册或者你还不是认证会员!","登录或注册", "login.php?jumpurl=addlrc.php?id=$id");
	exit; 
  }
   else { 
     $username=GetCookie('username'); 
   }
   
if(empty($action)){ 
  include_once PrintEot('addlrc');
  exit;
}
elseif ($_POST['action']=="up"){
    @extract($GLOBALS, EXTR_SKIP);
    if($_FILES['fileup']['tmp_name']=="") {
	    echo"没有选择文件! 【<a href=javascript:history.back(-1)>返回</a>】";
		exit;
	}
	else{
   $user_info=@file("$userdir/$username.php");
   list($user_name,$user_nicheng,$user_pass,$user_level,$user_mail,$add_lrcnum,$commend_song,$reg_time)=explode("|",$user_info[1]);

   $upload_file=$_FILES['fileup']['tmp_name'];
   $upload_filename=$_FILES['fileup']['name'];
   $upload_filesize=$_FILES['fileup']['size'];
   $ext = strtolower(strrchr($upload_filename,'.'));
   $newfilename=$id.".lrc";
   if($ext==".lrc"){
      @copy ($upload_file,$datadir."/lrc/".$newfilename); 
	  $add_lrcnum=$add_lrcnum+1;
	  $new_line=array($user_name,$user_nicheng,$user_pass,$user_level,$user_mail,$add_lrcnum,$commend_song,$reg_time);
	  $line=implode("|",$new_line)."|\n";
      $line="<? exit;?>\n".$line;
	  writetofile("$userdir/$username.php",$line);
	  echo "<font color=green>上传成功</font>";
	  exit;
    }
	 else {
	  echo "<font color=red>上传失败!</font> 原因: 您上传的不是LRC歌词文件! 【<a href=javascript:history.back(-1)>返回</a>】";
	 }
	}
}  
?>
