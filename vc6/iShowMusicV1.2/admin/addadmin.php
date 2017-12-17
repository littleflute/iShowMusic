<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=addadmin";

if($right<3){
   adminmsg('对不起，你没有权限进行此操作');
   exit;
 }

function get_admin(){
 global $datadir,$basename,$manager;
	$admin_info='';
	$ad=opendir(R_P."$datadir/adminuser/");
	echo "-->\n";
	while ($userfile=readdir($ad)) {
		if (($userfile!=".") && ($userfile!="..") && ($userfile!="") && strpos($userfile,".php")) {
			$admin=explode("|",readfrom(R_P."$datadir/adminuser/$userfile"));
	        unset($nm);unset($sm);
			if($admin[3]==3) $sm='selected';
			if($admin[3]==2) $nm='selected';
			if($admin[1]==$manager) $isbu='disabled';else $isbu='';
	        $admin_info.="<form action=$basename method=POST><tr class=bg><td>管理员用户名：<input type=hidden name=action value=\"editadmin\"><input type=hidden name=oldname value=\"$admin[1]\"><input type=text name=\"name\" size=20 value=\"$admin[1]\" $isbu> 密码：<input type=text name=\"usrpwds\" size=20 $isbu>  权限：<select name=\"usrpower\" $isbu><option value=2 $nm>普通管理员</option><option value=3 $sm>超级管理员</option></select> <input type=\"submit\" name=\"Submit\" value=\"修 改\" $isbu> <input type=button value=\"删 除\" onClick=\"location.href='$basename&action=del&name=$admin[1]'\" $isbu></td></tr></form>";
		}
	}
	echo $admin_info;
	echo "<!--";
	closedir($dh);
}

if (empty($action)){
       include PrintEot('addadmin');
	   exit;
	   
}elseif ($_POST['action']=="newadmin"){
        $name=safeconvert($name);
		$addpwd=md5($usrpwd);
		$user_info="<?echo\"????\";exit;?>|$name|$addpwd|$usrpower|$timestamp|";
		writeto(R_P."$datadir/adminuser/".$name.".php",$user_info);
	    adminmsg('完成相应操作');
		
}elseif ($_POST['action']=="editadmin"){
        unset($admin);
        if(file_exists(R_P."$datadir/adminuser/".$oldname.".php")){
		   $admin=explode("|",readfrom(R_P."$datadir/adminuser/".$oldname.".php"));
		  if($oldname==$manager){
		    adminmsg('对不起，网站创始人不可修改');
			exit;
			}else{
		   if($usrpwds) $addpwd=md5($usrpwds); else $addpwd=$admin[2];
		   if ($name==$oldname) {
               $user_info="$admin[0]|$admin[1]|$addpwd|$usrpower|$admin[4]|";
                writeto(R_P."$datadir/adminuser/".$name.".php",$user_info);
				adminmsg('完成相应操作');
				}
            else{
               $user_info="$admin[0]|$name|$addpwd|$usrpower|$admin[4]|";
               writeto(R_P."$datadir/adminuser/".$name.".php",$user_info);
               if(file_exists("../$datadir/adminuser/".$oldname.".php")) 
			      unlink(R_P."$datadir/adminuser/".$oldname.".php");
				  adminmsg('完成相应操作');
               }
		    }
         }
}elseif($action=="del"){
		    if(file_exists(R_P."$datadir/adminuser/".$name.".php")){
			   if($name==$manager){
		          adminmsg('对不起，网站创始人不可删除');
			     exit;}
				 else{
			       unlink(R_P."$datadir/adminuser/".$name.".php");
			       adminmsg('完成相应操作');
			     }
		     }
}
?>