<?
/*
	С��������ϵͳ iShowMusic install.php - installation of iShow Music
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
��ӭ���� iShow Music ��װ�򵼣���װǰ����ϸ�Ķ� ��װ˵�����ÿ��ϸ�ں���ܿ�ʼ��װ����װ�ļ�����ͬ���ṩ���й������װ��˵��������ͬ����ϸ�Ķ����Ա�֤��װ���̵�˳�����С�
<hr noshade align="center" width="100%" size="1">
<b>ע��:</b>
	<br>
	<span class='r'>����״����ʾ״̬��ȷ.</span>
	<br>
	<span class='c'>����״����ʾ״̬��������.</span><hr noshade align="center" width="100%" size="1"></td>
</tr>
<?
if(!$step)
{
	$ishowmusic_licence= <<<EOT
��Ȩ���� (c) 2007,www.ishowsky.cn

    �ڿ�ʼ��װ��ʹ�� iShowMusic ֮ǰ���������ϸ�Ķ�����Ȩ�ĵ�����ȷ��������ͬ������ȫ������� ���ɼ�����װ��ʹ�á�
    iShowMusic����ϵͳ�����¼�Ƴ�������Ghost���������ֳ��򣬻���PHP�ű����ı����ݿ⣬����MySQL���ݿ�֧�֡�����������ѺͿ�Դ���� �κ��˶����Դӻ�������������أ��������ڲ�Υ����Э��涨��ǰ���½��зַ��� �ҿ����ڲ�������ҵ��Ϊ��ǰ�������ʹ�ö�������ɳ���ʹ�÷ѡ�
    1. ����ʹ�úͰ�Ȩ��
    (1) �κ��˶������ڳ���ٷ���վ����������վ�ϻ�����°汾�ĳ����ȶ����Լ������ṩ�Ĳ��԰档
    (2) �κ��˳���������⣬����������ڸ��������ϼ����ʹ�ñ����������֧��ʹ�÷ѣ���Щ����������������
      a. ��¼������Υ���Ͳ�����Ϣ�� ���ҷ��ɷ����ֹ��������Ϣ�ģ�
      b. ��ӯ��ΪĿ�ĵ���վ��
    (3) ��ȷ����װ�������� ������ѵ�ǰ���£�������վ�͸��˿��ԶԳ����ٷַ���
    2.����
    (1) �������߲���ʹ�ó�����ɵ����ݶ�ʧ�� ����ʧ�Ը��𣬲�����ʹ���߷�������������һ�к������
    (2) ����ʹ���ϵ���������⣬���߽��������԰��������˲��������ߵ�����
    �ڴˣ���л��ѡ����iShowMusic�����������⣬�����κθĽ��Ľ��飬�����ڹٷ���վ�� BLOG���ԣ�Ҳ��ͨ���ʼ�����������ٴθ�л��
EOT;

	$ishowmusic_licence = str_replace('  ', '&nbsp; ', nl2br($ishowmusic_licence));
	?>
	<tr> 
	<td class='t' align=center><font color="#0000EE"><b>iShowMusic �û����Э��</b></font></td>
	</tr>
	<tr>
	<td class='t'><b><font color="#99ccff">&gt;</font><font color="#000000"> ���������ϸ�Ķ���������Э��</font></b></td>
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
	<input type="submit" name="submit" value="����ȫͬ��" style="height:20px;background-color:#f3f3f3;border:1 solid #CCC" onMouseOver ="this.style.backgroundColor='#FFC864'" onMouseOut ="this.style.backgroundColor='#f3f3f3'">&nbsp;
	<input type="button" name="exit" value="�Ҳ���ͬ��" style="height:20px;background-color:#f3f3f3;border:1 solid #CCC" onMouseOver ="this.style.backgroundColor='#FFC864'" onMouseOut ="this.style.backgroundColor='#f3f3f3'" onClick="javascript: window.close();">
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
	$incorrect='<font style="color:red">777���Լ�ⲻͨ��</font>';
	$uncorrect='<font style="color:red">�ļ����������ϴ����ļ�</font>';
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
		$s='777���Լ�ⲻͨ�� ��վ��Ŀ¼�޷�д����,���ٽ���Ŀ¼��������Ϊ777';
	}
	echo "<TR><td class='i' colspan='2' align='left'> <span style='color:#CC0000'>&gt;</span>����ҪĿ¼���ļ��������Լ��Ƿ��д�룬��������������ϴ��ļ�������ļ�/Ŀ¼д������ 777 </td></tr><tr><td colspan=2 align=left class='t'><br>";
	echo "��������Ŀ¼ (iShowMusicĿ¼) ....... <br>";
	
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
		<td class='i' colspan='2' align='left'><span style='color:#CC0000'>&gt;</span>���ø��������<br>&nbsp;</td>
		</tr><tr>
		<td class='t' align='left' width='40%'>&nbsp;&nbsp;����������:</td>
		<td class='t' align='left' width='60%'><input type='text' name='sitename'></td>
		</tr><tr>
		<td class='t' align='left' width='40%'>&nbsp;&nbsp;��������ַ:</td>
		<td class='t' align='left' width='60%'><input type='text' name='siteurl' value='$wwwurl'></td>
		</tr><tr>
		<td class='t' align='left' width='40%'>&nbsp;&nbsp;��վ��ʼ���û���:</td>
		<td class='t' align='left' width='60%'><input type='text' name='adminname'></td>
		</tr><tr>
		<td class='t' align='left' width='40%'>&nbsp;&nbsp;��վ��ʼ�� Email:</td>
		<td class='t' align='left' width='60%'><input type='text' name='adminemail'></td>
		</tr><tr>
		<td class='t' align='left' width='40%'>&nbsp;&nbsp;��վ��ʼ������:</td>
		<td class='t' align='left' width='60%'><input type='text' name='adminpass'></td>
		</tr><tr>
		<td class='t' align='left' width='40%'>&nbsp;&nbsp;�ظ�����:<br><br><br><br><br></td>
		<td class='t' align='left' width='60%'><input type='text' name='repadminpass'>&nbsp;&nbsp;
	    <input type='submit' value='ȷ����ɰ�װ' style=\"height:20px;background-color:'#f3f3f3';border:1 solid #CCC\" onMouseOver =\"this.style.backgroundColor='#FFC864'\" onMouseOut =\"this.style.backgroundColor='#f3f3f3'\"><br><br><br><br><br></td>
		<tr>";
		echo "</form>";
    } 
	else {
		echo "</tr><tr><td class='i' colspan='2' align='center'><input onclick='history.go(-1)' type='button' value='��������������' style='font-family:Verdana;width:50%'></td><tr>";
	}
}elseif ($_POST['step']==2){
	$check=1;
	echo '<TR><td class="i" colspan=2 align=left><span style="color:#CC0000">&gt;</span>��󣺼���������ϲ�д������</td></tr>';
	if ($adminpass != $repadminpass) {
		echo '<tr><TD align=left class=c align=middle colspan=2>���������2�����벻һ��</TD></TR>';
		$check=0;
	}
	if ($check) {
		$showpwd=$adminpass;
		$writepwd=md5($adminpass);
		$adminnicheng='��վ��ʼ��';
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
		
		echo '<tr><TD align=center class=r align=middle colSpan=2>OK������ϵͳ�����Ѿ�д�벢�Ѿ�ע��ɹ�</TD></TR>';
		echo "<tr><td class='i' colspan='2' align='center'><span style='color:#CC0000'>&gt;</span>��ϲ����iShowMusic ����ϵͳ ��װ�ɹ���<br>&nbsp;</td></tr><tr><td class='t' align='center' width='50%'>&nbsp;&nbsp;��վ��������Ա�˺ţ�</td><td class='t' align='center' width='50%'><b>Name</b>:$adminname <b>����Ϊ:$showpwd </b></td></tr><tr><td class='i' colspan='2' align='center'><span style='color:#CC0000'>&gt;</span><a href='admin.php'>���������������壬����������ϸ����</a><br><br></td></tr>";
		if (!unlink('install.php'))
			echo "<tr><td class='i' colspan='2' align='left'><span style='color:#CC0000'>&gt;<b>��װ�ļ� install.php ����ɾ��:�����ʹ��FTPɾ��install.php</b></span></TD></TR>";
		}
}
?>
</table>
<br><br>
<div align="center" style="color:#FFFFFF">Copyright 2007-2008 ��Ȩ���� <a href=http://www.ishowsky.cn/ target=_blank><b>iShowSky</b><b style=color:#FF9900>.CN</b></a></div>
<br></body></html>
