<!--
//
// �� ���ж�̬��ťͼ�ļ����л�����
// 
toggleKey = new Object();
toggleKey[0] = "_off";
toggleKey[1] = "_on";

function imgChange(id,act){
if(document.images){ document.images[id].src = eval("img." + id + toggleKey[act] + ".src");}
}
// ����γ������Ӧ�õ�������ʹ��ʱ��
// �Ժ�ʽ imgChange('��ťʶ������',0) ���еĶ�����ʹ�� "off" ��ͼ����
// �Ժ�ʽ imgChange('��ťʶ������',1) ���еĶ�����ʹ�� "on" ��ͼ����
// ����Ĳ��ݾ����趨 "off" �� "on" �Ķ�̬��ťͼ�ļ���
// vmute, pmode, rept, playt, pauzt, stopt ��Щ���ǡ���ťʶ�����ơ���
if(document.images){
img = new Object();
// ������ģʽ����ť��ͼ�ļ� (�ѹرգ��ѿ���)
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

