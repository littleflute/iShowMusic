<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=editmypwd";

if (empty($action)){
       include PrintEot('editmypwd');
	   exit;
	   
}elseif ($_POST['action']=="save"){
       if(!$newpwd || $newpwd!=$repnewpwd){
	     adminmsg('密码不能为空或重复密码与新密码不一致');
		 exit;
	     }else{
	       $info=explode("|",readfrom(R_P."$datadir/adminuser/".$adminuser.".php"));
		   if(md5($oldpwd)!=$info[2]){
		     adminmsg('原密码不正确');
			 exit;
		    }else{
			    if($adminuser==$manager){
			     $addpwd=md5($newpwd);
				 $manage_line="<?php\n\r\$manager='$adminuser';\n\r\$manager_pwd='$addpwd';\n\r?>";
				 writeto(R_P."$datadir/manager.php",$manage_line);
				 
			     $new_info="$info[0]|$info[1]|$addpwd|$info[3]|$info[4]|";
		         writeto(R_P."$datadir/adminuser/".$adminuser.".php",$new_info);
	             adminmsg('完成相应操作');
				 }else{
			        $addpwd=md5($newpwd);
			        $new_info="$info[0]|$info[1]|$addpwd|$info[3]|$info[4]|";
		            writeto(R_P."$datadir/adminuser/".$adminuser.".php",$new_info);
	                adminmsg('完成相应操作');
				    }
				}
		}
}
?>