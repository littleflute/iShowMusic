<?php
require("../global.php");

$playid=$_POST['id'];
$playnum=count($playid);
if($playnum==0){
  echo "你还未选择歌曲!";
  exit;
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>== iShowMusic 音乐播放器==</title>
<meta name="Author" content="Ghost">
<meta name="Keywords" content="iShowMusic,小鬼当家音乐系统,www.iShowSky.cn iShowMusic音乐播放器">
<meta name="Description" content="asf,asx,wma,wmx,wmv,wvx,mp3,wav,mid,www.iShowSky.cn  iShowMusic音乐播放器">
<LINK href="images/player.css" type=text/css rel=stylesheet>
<script language="JavaScript" src="js/exobud.js"></script>
<script language="JScript" for="Exobud" event="openStateChange(sf)">evtOSChg(sf);</script>
<script language="JScript" for="Exobud" event="playStateChange(ns)">evtPSChg(ns);</script>
<script language="JScript" for="Exobud" event="error()">evtWmpError();</script>
<script language="JScript" for="Exobud" event="Buffering(bf)">evtWmpBuff(bf);</script>
<SCRIPT Language="JavaScript" src="js/set.js"></SCRIPT>
<? 
   $msg=@file("../".$datadir."/list.php");
   $total=count($msg); 
  echo "<script language=Javascript>\n";

for($i=0;$i<$total;$i++)
   {  $flag=0 ;
   list($catid,$singerid,$songid,$songname,$addtime)=explode("|",$msg[$i]);
     for($j=0;$j<=$playnum;$j++)
	  if($playid[$j]==$songid) {
	    $flag=1; break ;
		}
	 if($flag==0) continue; 
	 $song="mkList(\"".$site_url."/down.php?type=box&id=".$songid."\",\"".$songname."\");\n" ;
         echo $song;
   } 

echo "</script>\n";  

?>
<script language="JavaScript" src="js/imgchg.js"></script>

<META content="MSHTML 6.00.6000.16544" name=GENERATOR></HEAD>
<BODY onLoad="initExobud();this.focus();" oncontextmenu="window.event.returnValue=false" ondragstart="window.event.returnValue=false" onselectstart="event.returnValue=false" topmargin=0 leftmargin=0 marginwidth=0 marginheight=0>
<DIV class=boxButtom-green></DIV>
<Div id="playerobj" style="display:none">
<object id="Exobud" classid="CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6" type="application/x-oleobject" width="0" height="0">
        <param name="autoStart" value="true">
        <param name="balance" value="0">
        <param name="currentPosition" value="0">
        <param name="currentMarker" value="0">
        <param name="enableContextMenu" value="false">
        <param name="enableErrorDialogs" value="false">
        <param name="enabled" value="true">
        <param name="fullScreen" value="false">
        <param name="invokeURLs" value="false">
        <param name="mute" value="false">
        <param name="playCount" value="1">
        <param name="rate" value="1">
        <param name="uiMode" value="none">
        <param name="volume" value="100">
  </object></Div>
<DIV class=playerBg align=center>
<UL>
  <LI>
  <TABLE cellSpacing=0 cellPadding=0 width=595 border=0>
    <TBODY>
    <TR vAlign=top>
      <TD width=170 height=61>
        <TABLE cellSpacing=0 cellPadding=0 width=150 border=0>
          <TBODY>
          <TR align=right>
            <TD width=47><IMG height=25 
              src="images/btn_forward.gif" width=25 onClick="playPrev()" name="prevt" title="上一首曲目" style="cursor:hand"></TD>
            <TD vAlign=bottom width=41 height=36><IMG height=35 
              src="images/btn_play.gif" width=35 onClick="wmpPP()" name="playt" title="暂停" style="cursor:hand"></TD>
            <TD width=31><IMG height=25 
              src="images/btn_next.gif" width=25 onClick="playNext()" name="nextt" title="下一首曲目" style="cursor:hand"></TD>
            <TD width=31><IMG height=25 
              src="images/btn_stop.gif" width=25 onClick="wmpStop()" name="stopt" title="停止" style="cursor:hand"></TD></TR>
          <TR align=right>
            <TD colSpan=4 height=24>
              <TABLE cellSpacing=0 cellPadding=0 width=156 border=0>
                <TBODY>
                <TR>
                  <TD align=right width=45 height=7><IMG height=7 
                    src="images/btn_sound_on.gif" width=13 name="vmute" onClick="wmpMute()" title="静音模式" style="cursor:hand"></TD>
                  <TD class=sound-linebg align=middle width=99>
                    <div id="VolumeButtonBox" style="height:5;width:99;" align="left"><img id="VolumeButton" src="images/sound_scollbtn.gif" style="position:relative;left:31;height:5;width:37" onMouseDown="button_down()" onMouseMove="button_move()" onMouseUp="button_up()" title="控制音量"></div></TD>
                  <TD><IMG height=7 src="images/btn_sound_on.gif" 
                    width=12></TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></TD>
      <TD><TABLE cellSpacing=0 cellPadding=0 width=100% border=0>
        <TBODY>
          <TR>
            <TD class=font12-gray><span id="disp1">当前播放：</span> </TD>
          </TR>
          <TR>
            <TD class=efont10-purple onClick="chgTimeFmt()"><span id="disp2" title="时间长度显示方式 (正常/倒数)"> <strong>PLAYTIME / 00:00 | 00:00</strong></span></TD>
          </TR>
          <TR>
            <TD vAlign=center height=23><div id="CourseButtonBox" style="height:3;width:254;"><IMG id="CourseButton" style="width:0;" height=3 src="images/player_guage_pic.gif" onMouseDown="button_down()" onMouseMove="button_move()" onMouseUp="button_up()"></div></TD>
          </TR>
        </TBODY>
      </TABLE></TD>
      </TR></TBODY></TABLE>
  </LI></UL></DIV>
	  <div align="center">
	    <iframe src="exobudpl.htm" width=620 height=300 scrolling="no" frameborder="0"></iframe>
	    </div>
</BODY></HTML>
