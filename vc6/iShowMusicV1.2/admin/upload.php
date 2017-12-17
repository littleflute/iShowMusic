<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>上传音乐</title>
<style type="text/css">
<!--
body,td{
	font-size: 12px;
	color: #333;
	margin:0px;
	line-height:20px;
}
a:link {color: #333;TEXT-DECORATION: none}
a:visited {color: #333;TEXT-DECORATION: none}
a:hover {color: #333;TEXT-DECORATION: underline}

-->
</style>
<body>
<?php

$magic_quotes_gpc = get_magic_quotes_gpc();
$register_globals = @ini_get('register_globals');
if(!$register_globals || !$magic_quotes_gpc)
{
	@extract($HTTP_POST_FILES, EXTR_SKIP); 
	@extract($HTTP_POST_VARS, EXTR_SKIP); 
	@extract($HTTP_GET_VARS, EXTR_SKIP); 
}
@extract($_REQUEST);
@extract($GLOBALS, EXTR_SKIP);
error_reporting(0);
unset($_ENV,$HTTP_ENV_VARS,$_REQUEST,$HTTP_POST_VARS,$HTTP_GET_VARS,$HTTP_POST_FILES,$HTTP_COOKIE_VARS);
foreach($_POST as $_key=>$_value){
	$_POST[$_key]=str_replace(array('|','$','..'),array('&#124;','&#36;','&#46;&#46;'),$_POST[$_key]);
	!ereg("^\_",$_key) && !$$_key && $$_key=$_POST[$_key];
}
foreach($_GET as $_key=>$_value){
	$_GET[$_key]=str_replace(array('|','$','..'),array('&#124;','&#36;','&#46;&#46;'),$_GET[$_key]);
	!ereg("^\_",$_key) && !$$_key && $$_key=$_GET[$_key];
}

$AdminUser=$_COOKIE['AdminUser'];
$CK= explode("\t",$AdminUser);
$user = stripcslashes($CK[1]);
if(!$user) { echo "请先登陆";exit; }

define('D_P',__FILE__ ? getdirname(__FILE__).'/' : './');
define('R_P',D_P);

function getdirname($path){
	if(strpos($path,'\\')!==false){
		return substr($path,0,strrpos($path,'\\'));
	}elseif(strpos($path,'/')!==false){
		return substr($path,0,strrpos($path,'/'));
	}else{
		return '/';
	}
}

require("../inc/config.php");

if (empty($action)){ ?>
<form enctype="multipart/form-data" action="upload.php" method="post"> 
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="20" class="table">　请选择文件并点击上传</td>
  </tr>
  <tr> 
    <td> 　请选择文件: 
      <input name="fileup" type="file" id="fileup" size="30">
      <input type=hidden name=action value="upload"> 　 
      <input name="submit" type=submit value=" 上 传 "></td>
    </tr>
</table>
</form>
<? }elseif ($_POST['action']=="upload"){
    @extract($GLOBALS, EXTR_SKIP);
	if($_FILES['fileup']['tmp_name']==""){
        echo"没有选择文件!【<a href=javascript:history.back(1)>返回</a>】";
	    exit;
	  }
      $upload_file=$_FILES['fileup']['tmp_name'];
      $upload_filename=$_FILES['fileup']['name'];
      $upload_filesize=$_FILES['fileup']['size'];
      $ext = strtolower(strrchr($upload_filename,'.'));
      $newfilename=time()."$ext";
      $uptime=time();

     if($ext==".mp3"||$ext==".wma"||$ext==".wmv"||$ext==".asf"||$ext==".asx"||$ext==".avi"||$ext==".rm"||$ext==".rmvb"||$ext==".ra"||$ext==".ram"){
       @move_uploaded_file ($upload_file,"../$updir/$newfilename"); 
       $upline="$user|$newfilename|$upload_filename|$upload_filesize|$uptime|\n";
	   $fp = fopen("../$updir/uplist.php", "a+");
       fwrite($fp, $upline);
       fclose($fp);
       echo"<font color=red>上传成功!</font> 名称: <font color=blue>$upload_filename</font><br>地址:$site_url/$updir/$newfilename <script>parent.FORM.songname.value='{$upload_filename}';parent.FORM.songurl.value='{$site_url}/{$updir}/{$newfilename}'</script>";
       exit; }
      else {
	    echo"<font color=red>上传失败!</font> 原因: 您上传的文件不是有效的音乐格式! 【<a href=javascript:history.back(1)>返回</a>】";
      exit;}
}
?>
</body>
</html>