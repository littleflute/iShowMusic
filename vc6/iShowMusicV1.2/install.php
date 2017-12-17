<?
/*
	小鬼当家音乐系统 iShowMusic install.php - installation of iShow Music
	Version: 1.2 
	Author: Ghost
	Copyright: www.ishowsky.cn
*/
error_reporting(E_ERROR | E_WARNING | E_PARSE);

@set_time_limit(1000);
set_magic_quotes_runtime(0);
if(!@ini_get('register_globals') || !get_magic_quotes_gpc()){
	@extract($_POST,EXTR_SKIP);
	@extract($_GET,EXTR_SKIP);
}
!$_POST && $_POST=array();
!$_GET && $_GET=array();
if(PHP_VERSION < '4.1.0') {
	$_GET = &$HTTP_GET_VARS;
	$_POST = &$HTTP_POST_VARS;
}
$step = $_POST['step'] ? $_POST['step'] : $_GET['step'];
$installfile = basename(__FILE__);

$PHP_SELF=$HTTP_SERVER_VARS['PHP_SELF'];
function readover($filename,$method="rb")
{
	$handle=fopen($filename,$method);
	flock($handle,LOCK_SH);
	$filedata=fread($handle,filesize($filename));
	fclose($handle);
	return $filedata;
}
function writeover($filename,$data,$method="wb")
{
	$handle=fopen($filename,$method);
	flock($handle,LOCK_EX);
	fputs($handle,$data);
	fclose($handle);
}
?>
<html><head><title>iShowMusic Installation</title>
<meta http-equiv=Content-Type content="text/html; charset=gb2312">
    <style type="text/css">
	body{font-size:12px;}
    .t {font-family: Verdana, Arial, Sans-serif;font-size:12px;padding-left: 10px;font-weight: normal;line-height: 150%;color : #333366;}
    .r {font-family: Arial, Sans-serif;font-size  : 12px;font-weight: normal;line-height: 200%;color : #0000EE;}
    .c {font-family: Arial, Sans-serif;font-size  : 12px;font-weight: normal;line-height: 200%;color : #EE0000;}
    .h {font-family: Arial, Sans-serif;padding-top: 5px;padding-left: 10px;font-size  : 20px;font-weight: bold;color : #000000;}
    .i {font-family: Arial, Sans-serif;padding-top: 5px;padding-left: 10px;font-size  : 14px;font-weight: bold;color : #000000;}
	table {width   : 80%;align: center;vertical-align: top;background-color: #FFF;}
	a:link,a:actived,a:visited{ color:#000000;}
	a:hover{color:#FF9900;}
	    </style>

<body bgcolor=#3A4273 leftmargin=0 topmargin=5 marginwidth="0" marginheight="0">
<table width="95%" cellspacing=0 cellpadding=0 align=center bgcolor=#fff border=0>
<tr>
<td class=h valign=top align=left colspan=2><p><span 
style="COLOR: #cc0000">&gt;&gt;</span> iShow Music 1.2 Installation 
</p>
  <p align="center"><img src="images/ishowmusic.jpg" width="250" height="102"></p>
  <hr noshade align="center" width="100%" size="1">
</td></tr>
<tr>
<td class='t' valign='top' align='left' colspan='2'>
欢迎来到 iShow Music 安装向导，安装前请仔细阅读 安装说明里的每处细节后才能开始安装。安装文件夹里同样提供了有关软件安装的说明，请您同样仔细阅读，以保证安装进程的顺利进行。
<hr noshade align="center" width="100%" size="1">
<b>注意:</b>
	<br>
	<span class='r'>此种状况表示状态正确.</span>
	<br>
	<span class='c'>此种状况表示状态发生错误.</span><hr noshade align="center" width="100%" size="1"></td>
</tr>
<?
if(!$step)
{
	$ishowmusic_licence= <<<EOT
版权所有 (c) 2007,www.ishowsky.cn

    在开始安装和使用 iShowMusic 之前，请务必仔细阅读本授权文档，在确定您理解和同意以下全部条款后， 方可继续安装和使用。
    iShowMusic音乐系统（以下简称程序）是由Ghost开发的音乐程序，基于PHP脚本和文本数据库，无需MySQL数据库支持。本程序是免费和开源程序， 任何人都可以从互联网上免费下载，并可以在不违反本协议规定的前提下进行分发， 且可以在不进行商业行为的前提下免费使用而无需缴纳程序使用费。
    1. 程序使用和版权：
    (1) 任何人都可以在程序官方网站或者下载网站上获得最新版本的程序稳定版以及可能提供的测试版。
    (2) 任何人除以下情况外，都可以免费在各类主机上架设和使用本程序而无需支付使用费，这些不允许的情况包括：
      a. 记录、发布违法和不良信息， 国家法律法规禁止发布的信息的；
      b. 以盈利为目的的网站；
    (3) 在确保安装包完整、 保持免费的前提下，各类网站和个人可以对程序再分发。
    2.免责：
    (1) 程序作者不对使用程序造成的数据丢失、 密码失窃负责，不对因使用者发表的内容引起的一切后果负责。
    (2) 如有使用上的困惑和问题，作者将尽量予以帮助，但此并非是作者的义务。
    在此，感谢您选择了iShowMusic，当发现问题，或有任何改进的建议，都可在官方网站、 BLOG留言，也可通过邮件渠道提出。再次感谢！
EOT;

	$ishowmusic_licence = str_replace('  ', '&nbsp; ', nl2br($ishowmusic_licence));
	?>
	<tr> 
	<td class='t' align=center><font color="#0000EE"><b>iShowMusic 用户许可协议</b></font></td>
	</tr>
	<tr>
	<td class='t'><b><font color="#99ccff">&gt;</font><font color="#000000"> 请您务必仔细阅读下面的许可协议</font></b></td>
	</tr>
	<tr>
	<td class='t'><div style="background:#EFEFEF; margin:30; padding:20"><?=$ishowmusic_licence?></div>
	</td>
	</tr>
	<tr>
	<td align="center">
	<br>
	<form action="<?=$installfile?>" method=post>
	<input type="hidden" name="step" value="1">
	<input type="submit" name="submit" value="我完全同意" style="height:20px;background-color:#f3f3f3;border:1 solid #CCC" onMouseOver ="this.style.backgroundColor='#FFC864'" onMouseOut ="this.style.backgroundColor='#f3f3f3'">&nbsp;
	<input type="button" name="exit" value="我不能同意" style="height:20px;background-color:#f3f3f3;border:1 solid #CCC" onMouseOver ="this.style.backgroundColor='#FFC864'" onMouseOut ="this.style.backgroundColor='#f3f3f3'" onClick="javascript: window.close();">
	</form>
	<br>
	<br>
	
	</td>
	</tr>
	<?
}
if($_POST['step']==1) {
    $check=1;
  	$correct='<font style="color:blue"> OK</font>';
	$incorrect='<font style="color:red">777属性检测不通过</font>';
	$uncorrect='<font style="color:red">文件不存在请上传此文件</font>';
	$filecheck=array(
		'Ad',
		'inc',
		'inc/config.php',
		'data',
		'data/data',
		'data/adminuser',
		'data/advert.php',
		'data/announce.php',
		'data/cknum.php',
		'data/reply.php',
		'data/sharelinks.php',
		'data/list.php',
		'data/badwords.php',
		'data/bannames.php',
		'data/cat.php',
		'data/commend.php',
		'data/diange.php',
		'data/viewhot.php',
		'data/viewhotday.php',
		'data/error.php',
		'data/ipbans.php',
		'data/manager.php',
		'data/singer.php',
		'data/usercom.php',
		'user',
		'user/list.php',
		'upload',
		'upload/uplist.php',
		'data/lrc',
		'template',
	);
	if ($fp=@fopen('test.txt',"wb")) {
		$s=$correct;
		fclose($fp);
	} else{
		$s='777属性检测不通过 网站根目录无法写数据,请速将根目录属性设置为777';
	}
	echo "<TR><td class='i' colspan='2' align='left'> <span style='color:#CC0000'>&gt;</span>检查必要目录和文件的完整性及是否可写入，如果发生错误，请上传文件或更改文件/目录写入属性 777 </td></tr><tr><td colspan=2 align=left class='t'><br>";
	echo "讨论区根目录 (iShowMusic目录) ....... <br>";
	
	$count=count($filecheck);
	for ($i=0; $i<$count; $i++) {
		echo "$filecheck[$i] ....... ";
		if(!file_exists($filecheck[$i])) { echo $uncorrect; $check=0;}
		elseif(is_writable($filecheck[$i])){echo $correct;}
		else{ echo $incorrect; $check=0; }
		echo "<br>";
	}
	echo "</TD></TR>";

	if(!($REQUEST_URI=$_SERVER['REQUEST_URI'])){
		$REQUEST_URI=$_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
	}
	$wwwurl='http://'.$_SERVER['HTTP_HOST'].substr($REQUEST_URI,0,strrpos($REQUEST_URI,'/'));
    
	if($check){
	  @unlink('test.txt');
	    echo "<form method=post action=$installfile>";
	  	echo "<tr> <td class=t valign=top align=left colspan=2><hr noshade align=center width=100% size=1></td></tr>";
		echo '<INPUT type=hidden value=2 name=step>';
		echo "<tr>
		<td class='i' colspan='2' align='left'><span style='color:#CC0000'>&gt;</span>设置各相关资料<br>&nbsp;</td>
		</tr><tr>
		<td class='t' align='left' width='40%'>&nbsp;&nbsp;音乐网名称:</td>
		<td class='t' align='left' width='60%'><input type='text' name='sitename'></td>
		</tr><tr>
		<td class='t' align='left' width='40%'>&nbsp;&nbsp;音乐网地址:</td>
		<td class='t' align='left' width='60%'><input type='text' name='siteurl' value='$wwwurl'></td>
		</tr><tr>
		<td class='t' align='left' width='40%'>&nbsp;&nbsp;网站创始人用户名:</td>
		<td class='t' align='left' width='60%'><input type='text' name='adminname'></td>
		</tr><tr>
		<td class='t' align='left' width='40%'>&nbsp;&nbsp;网站创始人 Email:</td>
		<td class='t' align='left' width='60%'><input type='text' name='adminemail'></td>
		</tr><tr>
		<td class='t' align='left' width='40%'>&nbsp;&nbsp;网站创始人密码:</td>
		<td class='t' align='left' width='60%'><input type='text' name='adminpass'></td>
		</tr><tr>
		<td class='t' align='left' width='40%'>&nbsp;&nbsp;重复密码:<br><br><br><br><br></td>
		<td class='t' align='left' width='60%'><input type='text' name='repadminpass'>&nbsp;&nbsp;
	    <input type='submit' value='确认完成安装' style=\"height:20px;background-color:'#f3f3f3';border:1 solid #CCC\" onMouseOver =\"this.style.backgroundColor='#FFC864'\" onMouseOut =\"this.style.backgroundColor='#f3f3f3'\"><br><br><br><br><br></td>
		<tr>";
		echo "</form>";
    } 
	else {
		echo "</tr><tr><td class='i' colspan='2' align='center'><input onclick='history.go(-1)' type='button' value='发生错误点击返回' style='font-family:Verdana;width:50%'></td><tr>";
	}
}elseif ($_POST['step']==2){
	$check=1;
	echo '<TR><td class="i" colspan=2 align=left><span style="color:#CC0000">&gt;</span>最后：检查输入资料并写入数据</td></tr>';
	if ($adminpass != $repadminpass) {
		echo '<tr><TD align=left class=c align=middle colspan=2>您所输入的2个密码不一致</TD></TR>';
		$check=0;
	}
	if ($check) {
		$showpwd=$adminpass;
		$writepwd=md5($adminpass);
		$adminnicheng='网站创始人';
		writeover('data/manager.php',"<? \$manager='$adminname'; \$manager_pwd='$writepwd';");
		require("inc/config.php");
		$timestamp=time();
		if(!file_exists("$datadir/adminuser/$adminname.php")){
			$admin_info="<?echo\"????\";exit;?>|$adminname|$writepwd|3|$timestamp|";
			writeover("$datadir/adminuser/$adminname.php",$admin_info);
		 }
		$cfgcontent="<?PHP \r\n\$site_name='$sitename';\r\n\$site_url='$siteurl';\r\n\$admin_email='$adminemail';\r\n\$datadir='data';\r\n\$userdir='user';\r\n\$updir='upload';\r\n\$skinpath='template';\r\n\$skin= 'default';\r\n\$perpage='20';\r\n\$regon='1';\r\n\$regbanname='';\r\n\$regright='0';\r\n\$maxboxnum='50';\r\n\$downon= '1';\r\n\$steal='1';\r\n\$refreshtime='3';\r\n?>";
		writeover("inc/config.php",$cfgcontent);
		$newuserlist="$adminname|$adminnicheng|3|$timestamp||\n";
		$user_line=array($adminname,$adminnicheng,$writepwd,3,$adminemail,0,0,$timestamp);
	    $line=implode("|",$user_line)."|\n";
        $line="<? exit;?>\n".$line;
	    writeover("$userdir/$adminname.php",$line);
		writeover("$userdir/list.php",$newuserlist);
		
		echo '<tr><TD align=center class=r align=middle colSpan=2>OK，音乐系统资料已经写入并已经注册成功</TD></TR>';
		echo "<tr><td class='i' colspan='2' align='center'><span style='color:#CC0000'>&gt;</span>恭喜您，iShowMusic 音乐系统 安装成功！<br>&nbsp;</td></tr><tr><td class='t' align='center' width='50%'>&nbsp;&nbsp;网站超级管理员账号：</td><td class='t' align='center' width='50%'><b>Name</b>:$adminname <b>密码为:$showpwd </b></td></tr><tr><td class='i' colspan='2' align='center'><span style='color:#CC0000'>&gt;</span><a href='admin.php'>点击这里进入管理面板，设置您的详细资料</a><br><br></td></tr>";
		if (!unlink('install.php'))
			echo "<tr><td class='i' colspan='2' align='left'><span style='color:#CC0000'>&gt;<b>安装文件 install.php 不可删除:请务必使用FTP删除install.php</b></span></TD></TR>";
		}
}
?>
</table>
<br><br>
<div align="center" style="color:#FFFFFF">Copyright 2007-2008 版权所有 <a href=http://www.ishowsky.cn/ target=_blank><b>iShowSky</b><b style=color:#FF9900>.CN</b></a></div>
<br></body></html>
