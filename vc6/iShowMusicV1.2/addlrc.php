<?php
require("global.php");
$subtitle='��Ӹ��';

if (empty($id)){
	Showmsg("no","�Ƿ�����!","�ر�ҳ��", "javascript:window.close()");
	exit; 
  }
  
if (file_exists($datadir."/lrc/$id.lrc")){
	Showmsg("no","���ݿ������б����ָ��,���������","�ر�ҳ��", "javascript:window.close()");
	exit; 
  }  
  
if (GetCookie('userlogin')!="1" || GetCookie('userlever')<"1"){
	Showmsg("no","����û�е�¼��ע������㻹������֤��Ա!","��¼��ע��", "login.php?jumpurl=addlrc.php?id=$id");
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
	    echo"û��ѡ���ļ�! ��<a href=javascript:history.back(-1)>����</a>��";
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
	  echo "<font color=green>�ϴ��ɹ�</font>";
	  exit;
    }
	 else {
	  echo "<font color=red>�ϴ�ʧ��!</font> ԭ��: ���ϴ��Ĳ���LRC����ļ�! ��<a href=javascript:history.back(-1)>����</a>��";
	 }
	}
}  
?>
