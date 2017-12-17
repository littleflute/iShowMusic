<!--
//
// ■ 进行动态按钮图文件的切换动作
// 
toggleKey = new Object();
toggleKey[0] = "_off";
toggleKey[1] = "_on";

function imgChange(id,act){
if(document.images){ document.images[id].src = eval("img." + id + toggleKey[act] + ".src");}
}
// 当这段程序代码应用到播放器使用时：
// 以函式 imgChange('按钮识别名称',0) 进行的动作即使用 "off" 的图档；
// 以函式 imgChange('按钮识别名称',1) 进行的动作即使用 "on" 的图档。
// 下面的部份就是设定 "off" 与 "on" 的动态按钮图文件。
// vmute, pmode, rept, playt, pauzt, stopt 这些都是「按钮识别名称」。
if(document.images){
img = new Object();
// 「静音模式」按钮的图文件 (已关闭／已开启)
img.vmute_off = new Image();
img.vmute_off.src = "./images/btn_sound_on.gif";
img.vmute_on = new Image();
img.vmute_on.src = "./images/btn_sound_off.gif";

img.playt_off = new Image();
img.playt_off.src = "./images/btn_play.gif";
img.playt_on = new Image();
img.playt_on.src = "./images/btn_pause.gif";
}

function imgmute(){
var ps=Exobud.settings;
if(ps.mute){imgChange("vmute",1);}
else {imgChange("vmute",0);}
}

function imgplay(f){
var wmps=Exobud.playState;
if(wmps==3){imgChange("playt",1);}
else {imgChange("playt",0);}
}

//-->

