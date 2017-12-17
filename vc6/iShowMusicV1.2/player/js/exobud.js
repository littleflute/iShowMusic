<!--
var objMmInfo = null;
var intMmCnt = 0;
var intSelMmCnt = 0;
var intActMmCnt = 0;
var cActIdx = 0;
var cActTit = "nAnT";
var strMmInfo = "媒体档案信息";
var blnfpl = false;
var blnEnabled = false;
var blnEOT = false;
var arrSelMm = null;
var arrActMm = null;
var intExobudStat = 0;
var tidTLab = null;
var tidErr = null;
var tidMsg = null;
var intErrCnt = 0;
var blnRept = false;

// 这是「自动连续播放」的设定。一般来说，播放一首音乐完毕后就会自动跳到下一首。
// 但是如果您要播放的媒体是视讯档案(例如:MV)的话，最好将这个设定值改为 false 。
// true = 自动连续播放
// false = 不要自动连续播放，让使用者自行挑选下一首曲目
var blnAutoProc = true;

// 设定播放面板上所显示的时间长度，预设是以正常方式(Elapse)抑或倒数方式(Lapse)显示：
// true = 以正常方式显示时间长度，即动态地显示曲目已播放的时间
// false = 以倒数方式显示时间长度，即动态地显示曲目剩余的时间
var blnElaps = true;

// 设定播放每首曲目之间的延迟时间(Delay Time)，单位是毫秒(msec)。
// 每100毫秒代表0.1秒，默认值是500毫秒(即0.5秒)，最少也要设为100毫秒。
var intDelay = 500;
// wmpInit() 函式: 使用 wmp-obj v7.x 链接库建立环境设定
function wmpInit(){
var wmps = Exobud.settings;
var wmpc = Exobud.ClosedCaption;
wmps.autoStart = true;
wmps.balance = 0;
wmps.enableErrorDialogs = false;
wmps.invokeURLs = false;
wmps.mute = false;
wmps.playCount = 1;
wmps.rate = 1;
wmps.volume = 100;
//if(blnUseSmi){wmpc.captioningID="capText"; capText.style.display="";}
Exobud.enabled = true;
}
// mkMmPath() 函式: 准备建立 Multi-object 的数组
function mkMmPath(u,t,f,s){
this.mmUrl = u;
this.mmTit = t;
this.mmDur = 0;
this.selMm = f;
this.actMm = f;
if(blnUseSmi){this.mmSmi=s;}
}
// mkList() 函式: 建立 Multi-object 的数组
function mkList(u,t,s,f){
var cu = u;
var ct = t;
var cs = s;
var cf = f;
var idx = 0;
if(objMmInfo == null){objMmInfo=new Array(); idx=0;}
else {idx=objMmInfo.length;}
if(u=="" || u==null){cu="mms://";}
if(t=="" || t==null){ct="nAnT";}
if(f=="f" || f=="F"){cf="f";}
else {cf="t"; intSelMmCnt++;}
if(blnUseSmi){
objMmInfo[idx]=new mkMmPath(cu,ct,cf,cs);
} else {
objMmInfo[idx]=new mkMmPath(cu,ct,cf);
}
intActMmCnt = intSelMmCnt;
intMmCnt = objMmInfo.length;
}
// mkSel() 函式: 建立已选取播放项目(Selected Media)的数组
function mkSel(){
arrSelMm = null;
intSelMmCnt = 0;
var selidx = 0;
if(intMmCnt<=0){intExobudStat=1; blnEnabled=false; return;} // 没有任何播放清单项目
arrSelMm = new Array();
for(var i=0; i<intMmCnt; i++){
if(objMmInfo[i].selMm =="t"){arrSelMm[selidx]=i;selidx++;}
}
intSelMmCnt=arrSelMm.length;
if(intSelMmCnt<=0){blnEnabled=false; intExobudStat=2; arrSelMm=null; return;}
else {blnEnabled=true; mkAct();}
}
// mkAct() 函式: 建立已启用播放项目(Activated Media)的数组
function mkAct(){
arrActMm = null;
intActMmCnt = 0;
var selidx = 0;
var actidx = 0;
if(blnEnabled){
arrActMm=new Array();
for(var i=0; i<intSelMmCnt; i++){
selidx=arrSelMm[i];
if(objMmInfo[selidx].actMm=="t"){arrActMm[actidx]=selidx; actidx++;}
}
intActMmCnt=arrActMm.length;
}
else { return;}
if(intActMmCnt<=0){blnEOT=true;arrActMm=null;}
else {blnEOT=false;}
}
// chkAllSel() 函式: 全部选取所有的播放清单项目
function chkAllSel(){
for(var i=0; i<intMmCnt; i++){
objMmInfo[i].selMm="t";
objMmInfo[i].actMm="t";
}
mkSel();
}
// chkAllDesel() 函式: 不选取所有的播放清单项目
function chkAllDesel(){
for(var i=0; i<intMmCnt; i++){
objMmInfo[i].selMm="f";
objMmInfo[i].actMm="f";
}
mkSel();
}
// chkItemSel() 函式: 选取或不选取播放清单项目
function chkItemSel(idx){
if(objMmInfo[idx].selMm =="t"){
objMmInfo[idx].selMm="f";objMmInfo[idx].actMm="f";
} else {
objMmInfo[idx].selMm="t";objMmInfo[idx].actMm="t";
}
mkSel();
}
// chkItemAct() 函式: 将某个已启用播放项目(Activated Media)冻结
function chkItemAct(idx){
objMmInfo[idx].actMm="f";
mkAct();
}
// mkSelAct() 函式: 将已选取播放项目(Selected Media)加入到已启用播放项目(Activated Media)
function mkSelAct(){
var idx=0;
for(var i=0; i<intSelMmCnt; i++){
idx=arrSelMm[i];
objMmInfo[idx].actMm="t";
}
mkAct();
}
// initExobud() 函式: 初始化 ExoBUD MP 媒体播放程序
function initExobud(){
wmpInit();
mkSel();
blnfpl = false;
showTLab();
disp1.innerHTML = "iShowMusic 音乐播放器";
if(blnStatusBar){ window.status=('iShowMusic 音乐播放器');}
if(blnAutoStart){startExobud();}
}
// startExobud() 函式: 开始播放曲目
function startExobud(){
var wmps = Exobud.playState;
if(wmps==2){
Exobud.controls.play(); 
try{clearInterval(play_time)}catch(e){}
return;
}
if(wmps==3){ return;}
blnfpl=false;
if(!blnEnabled){waitMsg();return;}
if(blnEOT){mkSelAct();}
if(intErrCnt>0){intErrCnt=0;tidErr=setTimeout('retryPlay(),1000');return;}
if(blnRndPlay){rndPlay();}
else {cActIdx=arrActMm[0]; selMmPlay(cActIdx);}
imgChange("playt",1);
}
// selMmPlay() 函式: 处理媒体标题
function selMmPlay(idx){
clearTimeout(tidErr);
cActIdx=idx;
var trknum=idx+1;
var ctit =objMmInfo[idx].mmTit;
if(ctit=="nAnT"){ctit="(没有媒体标题)"}
Exobud.URL = objMmInfo[idx].mmUrl;
cActTit = "当前播放：" + ctit;
disp1.innerHTML = cActTit;
imgChange("playt",1);
if(blnStatusBar){ window.status=(cActTit);}
chkItemAct(cActIdx);
}
// wmpPlay() 函式: 使用 wmp-obj v7.x 链接库播放曲目
function wmpPlay(){Exobud.controls.play();
imgChange("playt",1);
}
// wmpStop() 函式: 停止播放曲目及显示「就绪」状态讯息
function wmpStop(){
intErrCnt=0;
clearTimeout(tidErr);
clearInterval(tidTLab);
imgChange("playt",0);
playt.title="播放";
playt.onClick="startExobud()";
//imgChange("scope",0);
showTLab();
mkSelAct();
Exobud.controls.stop();
Exobud.close();
CourseButton.style.width=0
disp1.innerHTML = "当前无音乐文件在播放";
if(blnStatusBar){ window.status=('当前无音乐文件在播放');}
}
// wmpPause() 函式: 使用 wmp-obj v7.x 链接库暂停播放曲目
function wmpPause(){Exobud.controls.pause();}

// wmpPP() 函式: 在暂停播放和继续播放之间进行切换
function wmpPP(){
var wmps = Exobud.playState;
var wmpc = Exobud.controls;
clearInterval(tidTLab);
clearTimeout(tidMsg);
if(wmps==2){wmpc.play();imgChange("playt",1);playt.title="暂停";}
if(wmps==3){wmpc.pause();imgChange("playt",0); playt.title="播放";disp2.innerHTML="暂停"; tidMsg=setTimeout('rtnTLab()',1500);}
return;
}
// rndPlay() 函式: 随机播放(Random Play)的运算方式
function rndPlay(){
if(!blnEnabled){waitMsg();return;}
intErrCnt=0;
var idx=Math.floor(Math.random() * intActMmCnt);
cActIdx=arrActMm[idx];
selMmPlay(cActIdx);
}
// playAuto() 函式: 对已启用播放项目进行「自动连续播放」的处理
// 这是根据上面 blnAutoProc 的设定值而决定的动作。
function playAuto(){
if(blnRept){selMmPlay(cActIdx);return;}
if(!blnAutoProc){wmpStop();return;}
if(blnfpl){wmpStop();return;}
if(!blnEnabled){wmpStop();return;}
if(blnEOT){
if(blnLoopTrk){startExobud();}
else {wmpStop();}
} else {
if(blnRndPlay){rndPlay();}
else {cActIdx=arrActMm[0]; selMmPlay(cActIdx);}
}
}
// 播放使用者在播放清单上所点选的单一曲目
function selPlPlay(idx){
blnfpl=true;
selMmPlay(idx);
}
// playPrev() 函式: 播放上一首已启用播放项目
function playPrev(){
var wmps = Exobud.playState;
imgChange("playt",1);
playt.title="暂停";
if(wmps==2 || wmps==3){Exobud.controls.stop();}
blnfpl=false;
if(!blnEnabled){waitMsg();return;}
if(blnEOT){mkSelAct();}
intErrCnt=0;
if(blnRndPlay){rndPlay();}
else {
var idx=cActIdx;
var blnFind=false;
for(var i=0;i<intSelMmCnt;i++){ if(cActIdx==arrSelMm[i]){idx=i-1; blnFind=true;}}
if(!blnFind){startExobud();return;}
if(idx<0){idx=intSelMmCnt-1;cActIdx=arrSelMm[idx];}
else {cActIdx=arrSelMm[idx];}
selMmPlay(cActIdx);
}
}
// playNext() 函式: 播放下一首已启用播放项目
function playNext(){
var wmps = Exobud.playState;
imgChange("playt",1);
playt.title="暂停";
if(wmps==2 || wmps==3){Exobud.controls.stop();}
blnfpl=false;
if(!blnEnabled){waitMsg();return;}
if(blnEOT){mkSelAct();}
intErrCnt=0;
if(blnRndPlay){rndPlay();}
else {
var idx=cActIdx;
var blnFind=false;
for(var i=0;i<intSelMmCnt;i++){ if(cActIdx==arrSelMm[i]){idx=i+1; blnFind=true;}}
if(!blnFind){startExobud();return;}
if(idx>=intSelMmCnt){idx=0;cActIdx=arrSelMm[idx];}
else {cActIdx=arrSelMm[idx];}
selMmPlay(cActIdx);
}
}
// retryPlay() 函式: 再次尝试联机到媒体档案
function retryPlay(){
selMmPlay(cActIdx);
}
// chkRept() 函式: 切换是否重复播放目前的曲目(已启用播放项目)
function chkRept(){
var wmps = Exobud.playState;
if(wmps==3){clearInterval(tidTLab);}
if(blnRept){
blnRept=false; 
//imgChange('rept',0); 
disp2.innerHTML="不重复播放";
} else {
blnRept=true; 
//imgChange('rept',1); 
disp2.innerHTML="重复播放";
}
tidMsg=setTimeout('rtnTLab()',1000);
}
// chgPMode() 函式: 切换以循序(Sequential)抑或随机(Random)的方式来播放媒体项目
function chgPMode(){
var wmps = Exobud.playState;
if(wmps==3){clearInterval(tidTLab);}
if(blnRndPlay){
blnRndPlay=false; 
//imgChange('pmode',0);
disp2.innerHTML="循序播放";
} else {
blnRndPlay=true; 
//imgChange('pmode',1); 
disp2.innerHTML="随机播放";
}
tidMsg=setTimeout('rtnTLab()',1000);
}
// evtOSChg() 函式: 以弹出窗口方式显示媒体档案信息
function evtOSChg(f){
// 以下是状态值 (f) 的说明:
// 0(未定义) 8(转换媒体中) 9(寻找媒体中) 10(联机媒体中) 11(加载媒体中)
// 12(开启媒体中) 13(媒体已开启) 20(等待播放中) 21(正在开启不明的连结)
//if(f==8){capText.innerHTML="CopyRight&nbsp;&copy;&nbsp;小鬼当家 Ver2006&nbsp;&trade;";}
if(f==13){
var strTitle = Exobud.currentMedia.getItemInfo("Title");
if(strTitle.length <= 0){strTitle = "(未命名的标题)"}
var strAuthor = Exobud.currentMedia.getItemInfo("Author");
if(strAuthor.length <= 0){strAuthor = "(未命名的演出者)"}
var strCopy = Exobud.currentMedia.getItemInfo("Copyright");
if(strCopy.length <= 0){strCopy = "(没有著作权信息)"}
var strType = Exobud.currentMedia.getItemInfo("MediaType");
var strDur = Exobud.currentMedia.durationString;
var strUrl = Exobud.URL;
var trknum = cActIdx+1;
var ctit = objMmInfo[cActIdx].mmTit;
if(ctit=="nAnT"){
objMmInfo[cActIdx].mmTit = strAuthor + " - " + strTitle;
ctit = strAuthor + " - " + strTitle;
cActTit = trknum + ". " + ctit;
disp1.innerHTML = cActTit;
}
strMmInfo = "　　标题： " + strTitle + " (形式: " + strType +")" + "\n\n";
strMmInfo += "　演出者： " + strAuthor + "\n\n";
strMmInfo += "档案位置： " + strUrl + "\n\n";
strMmInfo += "　著作权： " + strCopy + "\n\n";
strMmInfo += "时间长度： " + strDur + "\n\n\n";
if(blnShowMmInfo){alert(strMmInfo);}
}
}
// evtPSChg() 函式: 切换播放程序的动作
function evtPSChg(f){
// 以下是状态值 (f) 的说明:
// 0(未定义) 1(已停止播放) 2(已暂停播放) 3(正在播放中) 4(向前搜索) 5(向后搜索)
// 6(缓冲处理中) 7(等待中) 8(已播放完毕) 9(转换曲目中) 10(就绪状态)
switch(f){
case 1:
evtStop();
break;
case 2:
evtPause();
break;
case 3:
evtPlay();
break;
case 8:
setTimeout('playAuto()', intDelay);
break;
}
}
// evtWmpBuff() 函式: 对媒体档案进行缓冲处理(Buffering)的动作
function evtWmpBuff(f){
if(f){
disp2.innerHTML = "缓冲处理中";
var msg = cActTit;
disp1.innerHTML = msg;
if(blnStatusBar){ window.status=(msg);}
} else {
disp1.innerHTML = cActTit; showTLab();
}
}
// evtWmpError() 函式: 当无法联机到媒体档案时，显示错误讯息
function evtWmpError(){
intErrCnt++;
Exobud.Error.clearErrorQueue();
if(intErrCnt<=3){
disp2.innerHTML = "尝试联机 (" + intErrCnt + ")";
var msg = "(尝试第 " + intErrCnt + " 次联机) " + cActTit;
disp1.innerHTML = "<无法播放> " + cActTit;
if(blnStatusBar){ window.status=(msg);}
tidErr=setTimeout('retryPlay()',1000);
} else {
clearTimeout(tidErr);
intErrCnt=0;showTLab();
var msg = "已放弃尝试再联机。现在将会播放下一首曲目。";
if(blnStatusBar){ window.status=(msg);}
setTimeout('playAuto()',1000);}
}
// evtStop() 函式: 停止播放
function evtStop(){
clearTimeout(tidErr);
clearInterval(tidTLab);
showTLab();
intErrCnt=0;
//imgChange("pauzt",0);
//imgChange("playt",0);
//imgChange("scope",0);
//disp2.innerHTML = "等待中…";
if(blnStatusBar){ window.status=('等待…');return true;}
}
// evtPause() 函式: 暂停播放
function evtPause(){
//imgChange("pauzt",1)
//imgChange("playt",0);
//imgChange("stopt",0);
//imgChange("scope",0);
clearInterval(tidTLab);
showTLab();
}
// evtPlay() 函式: 开始播放
function evtPlay(){
//imgChange("pauzt",0)
//imgChange("playt",1);
//imgChange("stopt",0);
//imgChange("scope",1);
tidTLab=setInterval('showTLab()',1000);
}
// showTLab() 函式: 显示时间长度
function showTLab(){
var ps = Exobud.playState;
if(ps==2 || ps==3){
var cp=Exobud.controls.currentPosition;
var cps=Exobud.controls.currentPositionString;
var dur=Exobud.currentMedia.duration;
var durs=Exobud.currentMedia.durationString;
if(blnElaps){
disp2.innerHTML = "PLAYTIME / "+cps + " | " + durs+"";
var msg = ""+cActTit + " (" + cps + " | " + durs + ")";
if(ps==2){msg = "(暂停) " + msg;}
if(blnStatusBar){ 
//window.status=(msg);
CourseButton.style.width=(cp/dur)*238
return true;
}
} else {
var laps = dur-cp;
var strLaps = wmpTime(laps);
disp2.innerHTML = "PLAYTIME / "+strLaps + " | " + durs+"";
var msg = ""+cActTit + " (" + strLaps + " | " + durs + ")";
if(ps==2){msg = "(暂停) " + msg;}
if(blnStatusBar){ 
//window.status=(msg);
//CourseButton.style.width=Math.round((CourseButtonBox.offsetWidth-CourseButton.offsetWidth)*Exobud.controls.currentposition/Exobud.currentMedia.duration)
CourseButton.style.width=(cp/dur)*238
return true;}
}
} else {
disp2.innerHTML = "PLAYTIME / 00:00 | 00:00";
}
}
// chgTimeFmt() 函式: 变更时间长度的显示方式
function chgTimeFmt(){
var wmps = Exobud.playState;
if(wmps==3){clearInterval(tidTLab);}
if(blnElaps){
blnElaps=false; disp2.innerHTML="倒数方式";
} else {
blnElaps=true; disp2.innerHTML="正常方式";
}
tidMsg=setTimeout('rtnTLab()',1000);
}
// rtnTLab() 函式: 传回时间长度
function rtnTLab(){
clearTimeout(tidMsg);
var wmps = Exobud.playState;
if(wmps==3){tidTLab=setInterval('showTLab()',1000);}
else {showTLab();}
}
// wmpTime() 函式: 计算时间长度
function wmpTime(dur){
var hh, min, sec, timeLabel;
hh=Math.floor(dur/3600);
min=Math.floor(dur/60)%60;
sec=Math.floor(dur%60);
if(isNaN(min)){ return "00:00";}
if(isNaN(hh) || hh==0){timeLabel="";}
else {
if(hh>9){timeLabel = hh.toString() + ":";}
else {timeLabel = "0" + hh.toString() + ":";}
}
if(min>9){timeLabel = timeLabel + min.toString() + ":";}
else {timeLabel = timeLabel + "0" + min.toString() + ":";}
if(sec>9){timeLabel = timeLabel + sec.toString();}
else {timeLabel = timeLabel + "0" + sec.toString();}
return timeLabel;
}

//滚动条事件
var EventObject=0,Old_X,New_X;
function button_down(){//拖动按钮按下事件
    EventObject=event.srcElement;
    Old_X=event.clientX;
    EventObject.setCapture();
    }
function button_move(){//拖动按钮移动事件
    if(EventObject){
        New_X=event.clientX;
        var MovePels=EventObject.style.pixelLeft+New_X-Old_X;
        var MaxBound=document.all(EventObject.id+"Box").offsetWidth-EventObject.offsetWidth;
        if(EventObject&&MovePels<=MaxBound&&MovePels>=0){
            EventObject.style.pixelLeft=MovePels;
            eval(EventObject.id+"Event("+EventObject.style.pixelLeft+","+MaxBound+")");
            Old_X=New_X;
            }
        }
    }
function button_up(){//拖动按钮松开事件
    if(EventObject){
        EventObject.releaseCapture();
        EventObject=0;
        }
    }
function CourseButtonEvent(l,m){//播放进程控制
    Exobud.controls.currentposition=Math.round(Exobud.currentMedia.duration*l/m);
    }
function VolumeButtonEvent(l,m){//音量控制
    var wmps=Exobud.playState;
    if(wmps == 3){clearInterval(tidTLab);}
    var ps = Exobud.settings;
    ps.volume=Math.round((l/m)*100);
    disp2.innerHTML = "音量: " + ps.volume + "%";
    }
function TrackButtonEvent(l,m){//声道控制
    var n=Math.round(l/m*100);
    var ps = Exobud.settings;
    ps.balance=n==50?0:n>50?(n-50)*1.8:n<50?-(50-n)*1.8:0;
    }

vArray = new Array();
vArray[0] = 0;
vArray[1] = 10;
vArray[2] = 20;
vArray[3] = 30;
vArray[4] = 40;
vArray[5] = 50;
vArray[6] = 60;
vArray[7] = 70;
vArray[8] = 80;
vArray[9] = 90; 
vArray[10] = 100; 

function SetVolume(index)
{
var wmps=Exobud.playState;
if(wmps == 3){clearInterval(tidTLab);}
var ps = Exobud.settings;
ps.volume = vArray[index];
document.images["meter"].src = eval("meter" + index + ".src");
disp2.innerHTML="Vol. " + ps.volume +"%";
if(ps.volume != 0 && ps.mute){ps.mute = false;imgChange("vmute", 0);}
if(ps.volume == 0 && !ps.mute){ps.mute = true;disp2.innerHTML="静音模式"; imgChange("vmute", 1);}
tidMsg=setTimeout('rtnTLab()',1000);
}
function MeterClick(n)
{
SetVolume(n);
}
// wmpMute() 函式: 静音模式(Mute)
function wmpMute(){ 
var wmps=Exobud.playState;
if(wmps == 3){clearInterval(tidTLab);}
var ps = Exobud.settings;
if(!ps.mute){ps.mute = true;disp2.innerHTML="静音模式启动"; imgChange("vmute", 1);}
else {ps.mute = false;disp2.innerHTML="静音模式关闭"; imgChange("vmute", 0);}
tidMsg=setTimeout('rtnTLab()',1000);
}
//function wmpMute(){
// var wmps = Exobud.playState;
// if(wmps==3){clearInterval(tidTLab);}
// var ps = Exobud.settings;
// if(!ps.mute){
// ps.mute=true; disp2.innerHTML="开启静音模式"; imgChange("vmute",1);
// } else {
// ps.mute=false; disp2.innerHTML="关闭静音模式"; imgChange("vmute",0);
// }
// tidMsg=setTimeout('rtnTLab()',1000);
//}
// waitMsg() 函式: 显示因播放列表空白而无法播放的讯息
function waitMsg(){
//capText.innerHTML="CopyRight&nbsp;&copy;&nbsp;2006&nbsp;&trade;";
if(intExobudStat==1){disp1.innerHTML = "无法播放 － 播放列表上没有设定任何曲目。";}
if(intExobudStat==2){disp1.innerHTML = "无法播放 － 您没有选取播放列表上任何一首曲目。";}
if(blnStatusBar){
if(intExobudStat==1){ window.status=('无法播放 － 播放列表上没有设定任何曲目。'); return true;}
if(intExobudStat==2){ window.status=('无法播放 － 您没有选取播放列表上任何一首曲目。'); return true;}
}
}

// chkWmpState() 函式: 当播放程序动作变更时，传回 playState 的状态值
function chkWmpState(){
// 以下是状态值的说明:
// 0(未定义) 1(已停止播放) 2(已暂停播放) 3(正在播放中) 4(向前搜索) 5(向后搜索)
// 6(缓冲处理中) 7(等待中) 8(已播放完毕) 9(转换曲目中) 10(就绪状态)
return Exobud.playState;
}
// chkWmpOState() 函式: 当播放程序开启媒体档案准备播放时，传回 openState 的状态值
function chkWmpOState(){
// 以下是状态值的说明:
// 0(未定义) 8(转换媒体中) 9(寻找媒体中) 10(联机媒体中) 11(加载媒体中)
// 12(开启媒体中) 13(媒体已开启) 20(等待播放中) 21(正在开启不明的连结)
return Exobud.openState;
}
// chkOnline() 函式: 检查使用者的联机状态 (不一定每款面板都会使用)

//-->

