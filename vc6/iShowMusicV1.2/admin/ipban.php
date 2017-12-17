<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=ipban";

if (empty($action)){
       $bannedips=readfrom(R_P."$datadir/ipbans.php");
	   $bannedips=str_replace("\n","\r\n",$bannedips);
       include PrintEot('ipban');
	   exit;
	   
}elseif ($_POST['action']=="save"){
	  $wordarray=str_replace("\n","",$wordarray);
	  $wordarray=str_replace("\r","\n",$wordarray);
	  writeto(R_P."$datadir/ipbans.php",$wordarray); 
	  adminmsg('完成相应操作');
}
?>