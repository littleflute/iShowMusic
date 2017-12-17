<?php
require("global.php");
$subtitle='发表评论';

if(empty($id) || empty($action)){ 
	Showmsg("no","非法操作！", "关闭本页", "javascript:window.close()");
	exit; }

if($action=="save"){

   $cknumon && GdConfirm($gdcode);
   
   if(!$content || !$user){
       Showmsg("no","所有项都要填写！", "返回前一页", "javascript:history.back(-1)");
	   exit; }
    else{ 
	     $user=safeconvert($_POST['user']);
	     $content=safeconvert($_POST['content']);
		 $commentfile="$datadir/reply.php";
		 $line="$id|$user|$grade|$content|$i_p|$timestamp|\n";
         writetofile($commentfile,$line,"a+");
		 Showmsg("yes","评论发布成功！", "关闭此页!", "javascript:window.close()");
	      exit;
	 }
}
?>
