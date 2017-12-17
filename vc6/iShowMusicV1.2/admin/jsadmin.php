<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=jsadmin";

if ($action){
	$code  = str_replace('EOT','',$advert);
	$code1 = htmlspecialchars(stripslashes($code));
	$code2 = stripslashes($code);
}
include PrintEot('jsadmin');exit;
?>