<?php
require("global.php");
$subtitle='��վ�Ƽ�����';

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
	Showmsg("no","����û�е�¼��ע��!","��¼��ע��", "login.php?jumpurl=addlrc.php?id=$id");
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
   	  Showmsg("no","�����Ҫ��д!","����ǰһҳ", "javascript:history.back(-1)");
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
  Showmsg("yes","�ύ�ɹ�,лл����֧��!","�����Ƽ�", "usercom.php");
  exit; 
}
?>
