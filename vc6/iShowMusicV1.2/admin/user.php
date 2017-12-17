<?php
!function_exists('adminmsg') && exit('Forbidden');
$basename="$admin_file?adminjob=user";

function get_user_list($page){
global $datadir,$userdir,$perpage,$basename;

       if(empty($page) or $page<=0) $page=1;
       settype($page, integer);
	   
       $userlist=file(R_P."$userdir/list.php");
	   $count=count($userlist);
	   $list_info="";
	   echo "-->\n";
	   if($count!=0){
	      if ($count%$perpage==0) $maxpageno=$count/$perpage;
		    else $maxpageno=floor($count/$perpage)+1;
	      if ($page>$maxpageno) $page=$maxpageno;
	        $pagemin=min( ($page-1)*$perpage , $count-1);
	        $pagemax=min( $pagemin+$perpage-1, $count-1);
			
			for ($i=$pagemin; $i<=$pagemax; $i++) {
	           $user=explode("|",$userlist[$i]);
	           $user_info=@file(R_P."$userdir/$user[0].php");  
               list($username,$usernicheng,$userpass,$reglever,$usermail,$addlrcnum,$commendsong,$regtime)=explode("|",$user_info[1]);
			   switch($reglever){
			       case 0 : $lever="普通会员"; break;
				   case 1 : $lever="认证会员"; break;
				   case 2 : $lever="普通管理员"; break;
				   case 3 : $lever="超级管理员"; break;
				   default : $lever="普通会员"; break;
			   }
               $regtime=date("Y.m.d H:i",$regtime);
			   $list_info.="<tr class=bg><td width=\"13%\" height=25 align=\"center\">$username</td><td width=\"23%\" align=\"center\">$usernicheng</td><td width=\"13%\" align=\"center\">$lever</td><td width=\"11%\" align=\"center\">$addlrcnum</td><td width=\"11%\" align=\"center\">$commendsong</td><td width=\"17%\" align=\"center\">$regtime</td><td width=\"5%\" align=\"center\"><a href=\"$basename&action=edit&user=$username\">编辑</a></td><td width=\"5%\" align=\"center\"><input type=\"checkbox\" name=\"delusers[]\" value=\"$username\"></td></tr>\n";
	      }
		  echo $list_info;
	   }
	   else{
	       $list_info.="<tr class=bg><td colspan=8>暂时还没有会员列表信息</td></tr>";
		   echo $list_info;
	   }
	   $pageurl="$basename&";
       PageNav($maxpageno,$count,$page,$pageurl,8);
	   echo "<!--";
}

if (empty($action)){

       include PrintEot('user');
	   exit;
	   
}elseif ($action=="edit"){
     if(!$step){
      if (file_exists(R_P."$userdir/$user.php") and $user){
	     $user_info=@file(R_P."$userdir/$user.php");
	     list($username,$usernicheng,$userpass,$reglever,$usermail,$addlrcnum,$commendsong,$regtime)=explode("|",$user_info[1]);
		 $leverselect="<option value=\"0\">普通会员</option><option value=\"1\">认证会员</option>";
		 $leverselect = str_replace("<option value=\"$reglever\">","<option value=\"$reglever\" selected>",$leverselect); 
	     }else{
		      adminmsg('无此用户，请查看是否有此用户名！');
		      exit;
	          }
          include PrintEot('user');
	      exit;
	    }
	    elseif($step=='2'){
		   $user_info=@file(R_P."$userdir/$user.php");
	       list($username,$usernicheng,$userpass,$reglevel,$usermail,$addlrcnum,$commendsong,$regtime)=explode("|",$user_info[1]);
		   if(!$pwd) $pwd=$userpass; else $pwd=md5($pwd);
		   $file_line=array($username,$nicheng,$pwd,$lever,$useremail,$useraddlrc,$usercommend,$regtime);
		   $line=implode("|",$file_line)."|\n";
           $line="<? exit;?>\n".$line;
		   writeto(R_P."$userdir/$newuser.php",$line);
           $listdata="$newuser|$nicheng|$lever|$regtime|\n";
		   text_modify(R_P."$userdir/list.php",$newuser,"|","0",$listdata);
           adminmsg('完成相应操作');
	    }
		
}elseif($action=='del'){
    $delusers = $_POST['delusers'];
	foreach ( (array) $delusers as $users) {
	 unlink(R_P."$userdir/$users.php");
	 unlink(R_P."$userdir/{$users}_box.php");
	 text_delete(R_P."$userdir/list.php","$users","|","0");
	}
	adminmsg('完成相应操作');
}
?>