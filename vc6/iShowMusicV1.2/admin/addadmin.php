<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=addadmin";

if($right<3){
   adminmsg('�Բ�����û��Ȩ�޽��д˲���');
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
	        $admin_info.="<form action=$basename method=POST><tr class=bg><td>����Ա�û�����<input type=hidden name=action value=\"editadmin\"><input type=hidden name=oldname value=\"$admin[1]\"><input type=text name=\"name\" size=20 value=\"$admin[1]\" $isbu> ���룺<input type=text name=\"usrpwds\" size=20 $isbu>  Ȩ�ޣ�<select name=\"usrpower\" $isbu><option value=2 $nm>��ͨ����Ա</option><option value=3 $sm>��������Ա</option></select> <input type=\"submit\" name=\"Submit\" value=\"�� ��\" $isbu> <input type=button value=\"ɾ ��\" onClick=\"location.href='$basename&action=del&name=$admin[1]'\" $isbu></td></tr></form>";
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
	    adminmsg('�����Ӧ����');
		
}elseif ($_POST['action']=="editadmin"){
        unset($admin);
        if(file_exists(R_P."$datadir/adminuser/".$oldname.".php")){
		   $admin=explode("|",readfrom(R_P."$datadir/adminuser/".$oldname.".php"));
		  if($oldname==$manager){
		    adminmsg('�Բ�����վ��ʼ�˲����޸�');
			exit;
			}else{
		   if($usrpwds) $addpwd=md5($usrpwds); else $addpwd=$admin[2];
		   if ($name==$oldname) {
               $user_info="$admin[0]|$admin[1]|$addpwd|$usrpower|$admin[4]|";
                writeto(R_P."$datadir/adminuser/".$name.".php",$user_info);
				adminmsg('�����Ӧ����');
				}
            else{
               $user_info="$admin[0]|$name|$addpwd|$usrpower|$admin[4]|";
               writeto(R_P."$datadir/adminuser/".$name.".php",$user_info);
               if(file_exists("../$datadir/adminuser/".$oldname.".php")) 
			      unlink(R_P."$datadir/adminuser/".$oldname.".php");
				  adminmsg('�����Ӧ����');
               }
		    }
         }
}elseif($action=="del"){
		    if(file_exists(R_P."$datadir/adminuser/".$name.".php")){
			   if($name==$manager){
		          adminmsg('�Բ�����վ��ʼ�˲���ɾ��');
			     exit;}
				 else{
			       unlink(R_P."$datadir/adminuser/".$name.".php");
			       adminmsg('�����Ӧ����');
			     }
		     }
}
?>