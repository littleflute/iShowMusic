<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=badwords";

if (empty($action)){
	   include(R_P."$datadir/badwords.php");
		while (@list($key, $value) = @each($badwords)) {
			$badwords="$key=$value\n\r";
		}
       include PrintEot('badwords');
	   exit;
	   
}elseif ($_POST['action']=="save"){
	$badwords="<?\n";
	$wordarray=str_replace("\n","",$wordarray);
	$wordarray=explode("\r",$wordarray);
	$count=count($wordarray);
	for ($i=0; $i<$count; $i++) {
		list($key,$value)=explode("=",$wordarray[$i]);
		if (empty($key)) continue;
		$badwords.="\$badwords['$key']='$value';\n";
		$newbadwords[$key]=$value;
	}
	  writeto(R_P."$datadir/badwords.php",$badwords); 
	  adminmsg('完成相应操作');
}
?>