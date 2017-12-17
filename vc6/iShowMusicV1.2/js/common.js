<!--
//***********默认设置定义.*********************
tPopWait=10;		//停留tWait豪秒后显示提示。
tPopShow=6000;		//显示tShow豪秒后关闭提示
showPopStep=100;
popOpacity=95;
fontcolor="#333";
bgcolor="#DFF4FF";
bordercolor="#0E91CF";

//***************内部变量定义*****************
sPop=null;curShow=null;tFadeOut=null;tFadeIn=null;tFadeWaiting=null;
document.write("<style type='text/css'id='defaultPopStyle'>");
document.write(".cPopText {  background-color: " + bgcolor + ";color:" + fontcolor + "; border: 1px " + bordercolor + " solid;font-color: font-size: 12px; padding-right: 4px; padding-left: 4px; height: 20px; padding-top: 2px; padding-bottom: 2px; filter: Alpha(Opacity=0)}");
document.write("</style>");
document.write("<div id='dypopLayer' style='position:absolute;z-index:1000;' class='cPopText'></div>");


function showPopupText(){
var o=event.srcElement;
	MouseX=event.x;
	MouseY=event.y;
	if(o.alt!=null && o.alt!=""){o.dypop=o.alt;o.alt=""};
        if(o.title!=null && o.title!=""){o.dypop=o.title;o.title=""};
	if(o.dypop!=sPop) {
			sPop=o.dypop;
			clearTimeout(curShow);
			clearTimeout(tFadeOut);
			clearTimeout(tFadeIn);
			clearTimeout(tFadeWaiting);	
			if(sPop==null || sPop=="") {
				dypopLayer.innerHTML="";
				dypopLayer.style.filter="Alpha()";
				dypopLayer.filters.Alpha.opacity=0;	
				}
			else {
				if(o.dyclass!=null) popStyle=o.dyclass 
					else popStyle="cPopText";
				curShow=setTimeout("showIt()",tPopWait);
			}
			
	}
}
function showIt(){
		dypopLayer.className=popStyle;
		dypopLayer.innerHTML=sPop;
		popWidth=dypopLayer.clientWidth;
		popHeight=dypopLayer.clientHeight;
		if(MouseX+12+popWidth>document.body.clientWidth) popLeftAdjust=-popWidth-24
			else popLeftAdjust=0;
		if(MouseY+12+popHeight>document.body.clientHeight) popTopAdjust=-popHeight-24
			else popTopAdjust=0;
		dypopLayer.style.left=MouseX+12+document.body.scrollLeft+popLeftAdjust;
		dypopLayer.style.top=MouseY+12+document.body.scrollTop+popTopAdjust;
		dypopLayer.style.filter="Alpha(Opacity=0)";
		fadeOut();
}

function fadeOut(){
	if(dypopLayer.filters.Alpha.opacity<popOpacity) {
		dypopLayer.filters.Alpha.opacity+=showPopStep;
		tFadeOut=setTimeout("fadeOut()",1);
		}
		else {
			dypopLayer.filters.Alpha.opacity=popOpacity;
			tFadeWaiting=setTimeout("fadeIn()",tPopShow);
			}
}

function fadeIn(){
	if(dypopLayer.filters.Alpha.opacity>0) {
		dypopLayer.filters.Alpha.opacity-=1;
		tFadeIn=setTimeout("fadeIn()",1);
		}
}
document.onmouseover=showPopupText;

//Input Foucus 特效
function fEvent(sType,oInput){
		switch (sType){
			case "focus" :
				oInput.isfocus = true;
			case "mouseover" :
				oInput.style.borderColor = '#9ecc00';
				break;
			case "blur" :
				oInput.isfocus = false;
			case "mouseout" :
				if(!oInput.isfocus){
					oInput.style.borderColor='#84a1bd';
				}
				break;
		}
	}


//顶部menu JS特效
var dt='start';
var da='start';
function chg(tt,aa)
{
  if (document.getElementById(aa).className="NewMusic_unselect")
  {
    if(dt!='start') document.getElementById(dt).className="NewMusic_tab_unselect";
    if(da!='start') document.getElementById(da).className="NewMusic_unselect";
	if(document.getElementById('l01').className=='NewMusic_tab_select') document.getElementById('l01').className="NewMusic_tab_unselect";
    if(document.getElementById('a1').className="NewMusic_select") document.getElementById('a1').className="NewMusic_unselect";
    document.getElementById(tt).className="NewMusic_tab_select";
	document.getElementById(aa).className="NewMusic_select";
    dt=tt;
    da=aa;
  }
}

//播放页面播放器
function player(id){
	document.write("<object classid='clsid:6bf52a52-394a-11d3-b153-00c04f79faa6' id='aboutplayer' width='460' height='64'>");
	document.write("<param name='url' value='ishow.php?id=" + id + "'>");
	document.write("<param name='volume' value='100'>");
	document.write("<param name='enablecontextmenu' value='0'>");
	document.write("<param name='enableerrordialogs' value='0'>");
	document.write("<param name='loop' value='true' />");
	document.write("</object>");
}

//页面加载中效果开始
var t_id = setInterval(animate,20); 
var pos=0; 
var dir=2; 
var len=0; 
function animate() { 
    var elem = document.getElementById('progress'); 
    if(elem != null) { 
     if (pos==0) len += dir; 
     if (len>32 || pos>79) pos += dir; 
     if (pos>79) len -= dir; 
     if (pos>79 && len==0) pos=0; 
     elem.style.left = pos; 
     elem.style.width = len; 
    } 
} 
function remove_loading() { 
    this.clearInterval(t_id); 
    var targelem = document.getElementById('loader_container'); 
    targelem.style.display='none'; 
    targelem.style.visibility='hidden'; 
} 
//随机收听音乐
function randPlay(randnum){
	window.open("player/randplay.php?randnum="+ randnum,"","scrollbars=yes,width=640,height=410,resizable,scrollbars")
}
//音乐盒删除操作
function delBoxSong(songid){		
	if(confirm("确定要从音乐盒中删除该歌曲吗?")){
		location.href="musicbox.php?action=del&t=" + songid;
	}
}

//后台试听
function playmedia(strID,strURL) {
	strID.replace(" ","%20");
	var objDiv=document.getElementById(strID);
		document.getElementById('player').style.display='block';
		objDiv.innerHTML=makemedia(strURL);
}

//Media Build
function makemedia (strURL) {
	var strHtml;
	
	strHtml ="<object id='MediaPlayer' width='400' height='64' classid='clsid:6bf52a52-394a-11d3-b153-00c04f79faa6'>";
    	strHtml+="<param name='url' value=\""+ strURL +"\">";
    	strHtml+="<param name='volume' value='100'>";
    	strHtml+="<param name='loop' value='true'>";
    	strHtml+="<param name='autoStart' value='-1'>";
        strHtml+="</object>";
        
     
	return strHtml;
}


String.prototype.trim = function() { return this.replace(/^\s+|\s+$/g,''); }
var IEBrowser = (window.navigator.userAgent.toLowerCase().indexOf('msie') > -1);
function returnClick(event, rbool)
{
	if (IEBrowser) {
		window.event.returnValue = rbool;
	} else {
		if(!rbool && event.preventDefault) event.preventDefault(); //ff
	}
}
function SearchCheck(form)
{
	if (form.keyword.value.trim() == "") {
		alert("搜索关键字不能为空！");
		form.keyword.focus();
		returnClick(event, false);
	}
	else
	{
    	returnClick(event, true);
	}
 }
//URL 复制
function copyUrl(url){
var test = document.getElementById(url).value;
window.clipboardData.setData("Text",test);
alert("代码获取成功，请粘贴到你的QQ/MSN上推荐给你的好友");
}