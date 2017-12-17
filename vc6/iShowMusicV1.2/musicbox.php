<?php
require("global.php");
header("Content-type:text/html;charset=GBK");
header("Cache-Control:no-cache,must-revalidate");
$subtitle='我的音乐盒';

//试听排行
$top="viewhot";

if (GetCookie('userlogin')!="1"){
	Showmsg("no","您还没有登录或注册!","登录或注册", "login.php?jumpurl=musicbox.php");
	exit; 
  }
   else { $username=GetCookie('username'); }
   
$user_info=@file("$userdir/$username.php");
list($user_name,$user_nicheng,$user_pass,$user_level,$user_mail,$add_lrcnum,$commend_song,$reg_time)=explode("|",$user_info[1]);

function get_box(){
global $userdir,$username,$user_nicheng,$maxboxnum,$skinpath,$skin;
echo "-->";
   if (file_exists("$userdir/{$username}_box.php")){
       $mymusicbox= file("$userdir/{$username}_box.php");
       $allmusic = count($mymusicbox);
	   $leftnum=$maxboxnum-$allmusic;
	   $listmsg = "";
        for ($i=0;$i<$allmusic;$i++){
		 $mymusic=explode("|", $mymusicbox[$i]);
		 $time=date("Y.m.d",$mymusic[3]);
		 $listmsg= "<li><span class=\"songname\"><input type=checkbox  checked  name=id[] value=".$mymusic[2]."><a href=\"play.php?id=$mymusic[2]\" target=\"_blank\"> ".$mymusic[0]."</a></span><span class=\"singer\">".$mymusic[1]."</span><span class=\"scrq\">".$time."</span><span class=\"play\"><a href=\"play.php?id=$mymusic[2]\" target=\"_blank\"><img src=\"$skinpath/$skin/images/icon_play.gif\" align=\"middle\"></a></span><span class=\"down\"><a href=\"down.php?id=$mymusic[2]\" target=\"_blank\"><img src=\"$skinpath/$skin/images/icon_down.gif\" align=\"middle\"></a></span><span class=\"sc\"><a href=\"javascript:delBoxSong($mymusic[3])\"><img src=\"$skinpath/$skin/images/delete.gif\" align=\"middle\"></a></span></li>\n";
		 echo $listmsg;
		 }
     }
	 else{
	    $listmsg="<li>您还未收藏音乐，请先添加音乐到您的音乐盒！</li>";
		$allmusic = 0;
	    $leftnum=$maxboxnum-$allmusic;
		echo $listmsg;
	   }
  echo "<li><span class=\"green\">".$user_nicheng."</span> ,你的音乐盒目前共收藏音乐 <span class=\"red\">".$allmusic."</span> 首，还可以收藏 <span class=\"red\">".$leftnum."</span>首（系统设置最大可以收藏 <span class=\"red\">".$maxboxnum."</span>首）</li>";   
  echo "<!--";
}
   
if(empty($action)){ 
  require("header.php");
  include_once PrintEot('musicbox');
  footer();
  exit;
}
elseif ($action=="del"){
 if (file_exists("$userdir/{$username}_box.php")){
		text_delete("$userdir/{$username}_box.php","$t","|","3");
		Showmsg("yes","正确删除此歌曲！","继续操作", "musicbox.php");
	  }
 else{
	Showmsg("no","无此歌曲！","重新操作", "musicbox.php");
	exit;
  } 
} 
elseif ($action=="add"){
   if(empty($songid)){
	Showmsg("no","未选择歌曲!","返回", "javascript:history.back(-1)");
	exit;
	}else{
 	   $addtime=$timestamp;
       $line=$songname."|".$singer."|".$songid."|".$addtime."|\n";
	   if (!file_exists("$userdir/{$username}_box.php")) {
    	 writetofile("$userdir/{$username}_box.php",$line);
	     Showmsg("yes","收藏成功！","进入我的音乐盒", "musicbox.php");
	     exit;	
 		}
		else{
		 $mymusicbox= file("$userdir/{$username}_box.php");
         $allmusic = count($mymusicbox)+1;
		 
		 if($allmusic>$maxboxnum){
		   Showmsg("no","对不起，你的音乐盒已满，请先删除一些收藏音乐！","进入我的音乐盒", "musicbox.php");
	       exit;
		 }
		 
		 for($i=0;$i<$allmusic;$i++){
		   $detail=explode("|", trim($mymusicbox[$i]));
		   if($detail[2]=="$songid"){
		     Showmsg("no","你已经收藏了此音乐，无需再收藏！","关闭此页", "javascript:window.close()");
			 exit;
		    }
		 }
		 
		 writetofile("$userdir/{$username}_box.php",$line,"a+");
	     Showmsg("yes","收藏成功！","进入我的音乐盒", "musicbox.php");
	     exit;	
		}
	}
} 
?>