<?php
require("global.php");
header("Content-type:text/html;charset=GBK");
header("Cache-Control:no-cache,must-revalidate");
$subtitle='�ҵ����ֺ�';

//��������
$top="viewhot";

if (GetCookie('userlogin')!="1"){
	Showmsg("no","����û�е�¼��ע��!","��¼��ע��", "login.php?jumpurl=musicbox.php");
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
	    $listmsg="<li>����δ�ղ����֣�����������ֵ��������ֺУ�</li>";
		$allmusic = 0;
	    $leftnum=$maxboxnum-$allmusic;
		echo $listmsg;
	   }
  echo "<li><span class=\"green\">".$user_nicheng."</span> ,������ֺ�Ŀǰ���ղ����� <span class=\"red\">".$allmusic."</span> �ף��������ղ� <span class=\"red\">".$leftnum."</span>�ף�ϵͳ�����������ղ� <span class=\"red\">".$maxboxnum."</span>�ף�</li>";   
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
		Showmsg("yes","��ȷɾ���˸�����","��������", "musicbox.php");
	  }
 else{
	Showmsg("no","�޴˸�����","���²���", "musicbox.php");
	exit;
  } 
} 
elseif ($action=="add"){
   if(empty($songid)){
	Showmsg("no","δѡ�����!","����", "javascript:history.back(-1)");
	exit;
	}else{
 	   $addtime=$timestamp;
       $line=$songname."|".$singer."|".$songid."|".$addtime."|\n";
	   if (!file_exists("$userdir/{$username}_box.php")) {
    	 writetofile("$userdir/{$username}_box.php",$line);
	     Showmsg("yes","�ղسɹ���","�����ҵ����ֺ�", "musicbox.php");
	     exit;	
 		}
		else{
		 $mymusicbox= file("$userdir/{$username}_box.php");
         $allmusic = count($mymusicbox)+1;
		 
		 if($allmusic>$maxboxnum){
		   Showmsg("no","�Բ���������ֺ�����������ɾ��һЩ�ղ����֣�","�����ҵ����ֺ�", "musicbox.php");
	       exit;
		 }
		 
		 for($i=0;$i<$allmusic;$i++){
		   $detail=explode("|", trim($mymusicbox[$i]));
		   if($detail[2]=="$songid"){
		     Showmsg("no","���Ѿ��ղ��˴����֣��������ղأ�","�رմ�ҳ", "javascript:window.close()");
			 exit;
		    }
		 }
		 
		 writetofile("$userdir/{$username}_box.php",$line,"a+");
	     Showmsg("yes","�ղسɹ���","�����ҵ����ֺ�", "musicbox.php");
	     exit;	
		}
	}
} 
?>