<?php
require("global.php");
$subtitle='��������';

if(empty($id) || empty($action)){ 
	Showmsg("no","�Ƿ�������", "�رձ�ҳ", "javascript:window.close()");
	exit; }

if($action=="save"){

   $cknumon && GdConfirm($gdcode);
   
   if(!$content || !$user){
       Showmsg("no","�����Ҫ��д��", "����ǰһҳ", "javascript:history.back(-1)");
	   exit; }
    else{ 
	     $user=safeconvert($_POST['user']);
	     $content=safeconvert($_POST['content']);
		 $commentfile="$datadir/reply.php";
		 $line="$id|$user|$grade|$content|$i_p|$timestamp|\n";
         writetofile($commentfile,$line,"a+");
		 Showmsg("yes","���۷����ɹ���", "�رմ�ҳ!", "javascript:window.close()");
	      exit;
	 }
}
?>
