<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=setting";

if($right<3){
   adminmsg('对不起，你没有权限进行此操作');
   exit;
 }

if (empty($action)){
		$dir		= opendir(R_P."/$skinpath");
		$choseskin	= "<option value=$skin>$skin</option>";
		while ($userskin=readdir($dir)) {
			if($userskin!=$skin && $userskin!='admin' && $userskin!='.' && $userskin!='..'){
					$choseskin .= "<option value=$userskin>$userskin</option>";
			}
		}
		closedir($dir);
		
		ifcheck($cknumon,'cknum');
		ifcheck($downon,'down');
		ifcheck($indexlinkon,'indexlink');
		ifcheck($dgmail,'dgmail');
		ifcheck($steal,'steal');
		ifcheck($regon,'regon');
		ifcheck($regright,'regright');
		ifcheck($isdiscuz,'isdiscuz');
		ifcheck($jsifopen,'jsifopen');
		
		if (file_exists($datapath) && !is_writeable($datapath)){
			$datadisabled='disabled';
		}
		if (file_exists($userpath) && !is_writeable($userpath)){
			$userdisabled='disabled';
		}
		if (file_exists($uppath) && !is_writeable($uppath)){
			$updisabled='disabled';
		}
		if (file_exists($stylepath) && !is_writeable($stylepath)){
			$styledisabled='disabled';
		}
		
       include PrintEot('setting');
	   exit;
}elseif ($_POST['action']=="save"){
       if(!is_writeable(D_P.'inc/config.php') && !chmod(D_P.'inc/config.php',0777)){
		adminmsg('<font color=red>无法修改程序核心配置文件,请将 inc/config.php 文件属性设为可写模式(777)</font>');
	   }
	   	!is_numeric($cfg['perpage'])	&& $cfg['perpage']=20;
		!is_numeric($cfg['refreshtime'])	&& $cfg['refreshtime']=3;
		!is_numeric($cfg['maxboxnum ']) 	&& $cfg['maxboxnum ']=50;
       	
		if(!is_dir($cfg['datapath']) && $datapath!=$cfg['datapath'] && !@rename($datapath,$cfg['datapath'])){
			$cfg['datapath']=$datapath;
			adminmsg('<font color=red>无法更改音乐数据目录名,请设置其属性为可写模式(777)</font>');
		}
		if (!is_dir($cfg['userpath']) && $userpath<>$cfg['userpath'] && !@rename($userpath,$cfg['userpath'])){
			$cfg['userpath']=$userpath;
			adminmsg('<font color=red>无法更改用户数据目录名,请设置其属性为可写模式(777)</font>');
		}
		if(!is_dir($cfg['uppath']) && $uppath!=$cfg['uppath'] && !@rename($uppath,$cfg['uppath'])){
			$cfg['uppath']=$uppath;
			adminmsg('<font color=red>无法更改上传目录名,请设置其属性为可写模式(777)</font>');
		}
		if (!is_dir($cfg['stylepath']) && $stylepath<>$cfg['stylepath'] && !@rename($stylepath,$cfg['stylepath'])){
			$cfg['stylepath']=$stylepath;
			adminmsg('<font color=red>无法更改模板目录名,请设置其属性为可写模式(777)</font>');
		}
       $cfgcontent="<?PHP 
\$site_name='$cfg[site_name]';
\$site_url='$cfg[site_url]';
\$admin_email='$cfg[admin_email]';
\$datadir='$cfg[datapath]';
\$userdir='$cfg[userpath]';
\$updir='$cfg[uppath]';
\$skinpath='$cfg[stylepath]';
\$skin= '$cfg[skin]';
\$perpage='$cfg[perpage]';
\$regon='$cfg[regon]';
\$regbanname='$cfg[regbanname]';
\$regright='$cfg[regright]';
\$maxboxnum='$cfg[maxboxnum]';
\$cknumon= '$cfg[cknum]';
\$downon= '$cfg[down]';
\$indexlinkon= '$cfg[indexlink]';
\$dgmail= '$cfg[dgmail]';
\$steal='$cfg[steal]';
\$stealurl='$cfg[stealurl]';
\$jsifopen='$cfg[jsifopen]';
\$jsurl='$cfg[jsurl]';
\$refreshtime='$cfg[refreshtime]';
\$isdiscuz='$cfg[isdiscuz]';
\$discuz='$cfg[discuz]';
\$passport_key='$cfg[passport_key]';
	 ";
     writeto(D_P.'inc/config.php',$cfgcontent);
	 adminmsg('完成相应操作');
}
?>