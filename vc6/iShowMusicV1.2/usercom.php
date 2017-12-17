<?php
require("global.php");
$subtitle='向本站推荐音乐';

function showcategory() {
    global $datadir;
    $catlist=file("$datadir/cat.php");
	$fcount=count($catlist);
	echo "-->";
	for ($i=0; $i<$fcount; $i++) {
	$detail=explode("|",$catlist[$i]);
		echo "<OPTION VALUE=\"$detail[0]\">$detail[1]</OPTION>\n";
	}
	echo "<!--";
}

if (GetCookie('userlogin')!="1"){
	Showmsg("no","您还没有登录或注册!","登录或注册", "login.php?jumpurl=addlrc.php?id=$id");
	exit; 
  }
   else { 
     $username=GetCookie('username'); 
   }
   
if(empty($action)){ 
  require ("header.php");
  include_once PrintEot('usercom');
  footer();
  exit;
}

elseif ($action=="save"){
   if(empty($comsongname) || empty($comsinger) || empty($comurl)){
   	  Showmsg("no","所有项都要填写!","返回前一页", "javascript:history.back(-1)");
	  exit; 
     }
	 
  $user_info=@file("$userdir/$username.php");
  list($usernamec,$usernicheng,$userpassc,$reglevel,$usermail,$addlrcnum,$commendsong,$regtime)=explode("|",$user_info[1]);
  $comsongname=safeconvert($comsongname);
  $comsinger=safeconvert($comsinger); 
  $addtime=$timestamp;
  $line=$username."|".$comsongname."|".$comsinger."|".$comsort."|".$comurl."|".$addtime."|\n";
  writetofile("$datadir/usercom.php",$line,"a+");
  
  $commendsong=$commendsong+1;
  $new_line=array($usernamec,$usernicheng,$userpassc,$reglevel,$usermail,$addlrcnum,$commendsong,$regtime);
  $line_u=implode("|",$new_line)."|\n";
  $line_u="<? exit;?>\n".$line_u;
  writetofile("$userdir/$usernamec.php",$line_u);
  Showmsg("yes","提交成功,谢谢您的支持!","继续推荐", "usercom.php");
  exit; 
}
?>
