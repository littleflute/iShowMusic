<?php

define('D_P',__FILE__ ? getdirname(__FILE__).'/' : './');
define('R_P',D_P);

$admin_file = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
require_once(R_P."admin/global.php");
if (!$adminjob){
	require_once PrintEot('index');
	exit;
} elseif ($adminjob == 'left'){
	require_once(R_P."admin/left.php");
} elseif ($adminjob == 'admin'){
	$sysversion = PHP_VERSION;
	$sysos      = $_SERVER['SERVER_SOFTWARE'];
	$max_upload = ini_get('file_uploads') ? ini_get('upload_max_filesize') : 'Disabled';
	$max_ex_time= ini_get('max_execution_time').' seconds';
	$ifcookie   = isset($_COOKIE) ? "SUCCESS" : "FAIL";
	if (function_exists("gd_info")) {
		$tmp_gd_info=gd_info();
		$gdver=$tmp_gd_info["GD Version"];
	} else $gdver="未安装";

	require_once PrintEot('admin');
	exit;
} elseif ($adminjob){
	require_once(R_P."admin/$adminjob.php");
} else {
	adminmsg('您没有权限进行此项操作或此功能未完成');
}

function getdirname($path){
	if(strpos($path,'\\')!==false){
		return substr($path,0,strrpos($path,'\\'));
	}elseif(strpos($path,'/')!==false){
		return substr($path,0,strrpos($path,'/'));
	}else{
		return '/';
	}
}

?>