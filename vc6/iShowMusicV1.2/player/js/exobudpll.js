	var via = parent;
	var write_via = "parent";
	var iLoc= self.location.href;

	function playSel(){via.wmpStop();via.startExobud();}
	function refreshPl(){ self.location=iLoc;}
	function chkSel(){via.chkAllSel();refreshPl();}
	function chkDesel(){via.chkAllDesel();refreshPl();}

	function dspList(n){
		
		var elmABlock= 8;// 设定每页可显示多少个播放项目
		var totElm = via.intMmCnt;
		var totBlock= Math.floor((via.intMmCnt -1) / elmABlock)+1;
		var cblock;
		if(n==null){cblock=1;}
		else{cblock=n;}
		var seed;
		var limit;
		if(cblock < totBlock){seed= elmABlock * (cblock-1); limit =  cblock*elmABlock -1}
		else{seed=elmABlock * (cblock-1); limit= totElm-1;}

	if(via.intMmCnt >0 ){
		var list_num=0;
		mmList.innerHTML='';
		for (var i=seed; i <= limit; i++)
		{	list_num = i + 1;
		    var color = (i%2==0) ? '#35374C': '#292B3F';
			var outcolor = (i%2==0) ? '#33354A': '#292B3F';
			elm= '<TABLE cellSpacing=0 cellPadding=0 width=340 border=0>';
			elm= elm + '<tr bgcolor='+ color + ' onMouseOver="mOvrSend(this,\'#4F5168\')" onMouseOut="mOutSend(this,\'' + outcolor + '\')"> ';
			elm= elm + '<td align="center" class=line-black width=24 height=24>';
			if(via.objMmInfo[i].selMm=="t"){
				elm=elm+'&nbsp;<input type=checkbox  style="cursor:hand;" onfocus=blur() onClick='+ write_via + '.chkItemSel('+ i +'); checked>' ;}
			else{
				elm = elm +'&nbsp;<input type=checkbox style="cursor:hand;" onfocus=blur() onClick='+ write_via + '.chkItemSel('+ i +');>' ;}
			elm = elm + '</td>';
			elm = elm + '<td> ';
			elm = elm + '   <span class="font12-purple"> ' + list_num + '.</span>' 
			elm = elm + '   <a href=javascript:' + write_via + '.selPlPlay(' + i + ');'
			elm = elm + ' onfocus=blur() onclick=\"this.blur();\">'
			if(via.objMmInfo[i].mmTit =="nAnT"){ elm = elm + "未指定媒体标题(等待自动取得媒体信息)";}
			else{elm = elm + via.objMmInfo[i].mmTit;}
			elm= elm+  '</a>';
			elm = elm + '</td>';
			elm = elm + '</tr>';
			elm = elm + '</table>';
			mmList.innerHTML=mmList.innerHTML+elm;
		}

        var pmin=new Number(cblock)-3;
		var pmax=new Number(cblock)+3;
		var ppre=new Number(cblock)-1;
		var pnext=new Number(cblock)+1;
		if(pmin<=3){pmin=1;pmax=7;}
		if(pmax>totBlock){pmax=totBlock;}
		if(ppre<=1){ppre=1;}
		if(pnext>totBlock){pnext=totBlock;}

		for(var j=pmin; j<=pmax; j++){
			page='<a href=javascript:dspList('+j+') onFocus=blur()>['+j+']</a> ';
		}

		pageInfo.innerHTML='<a href=javascript:dspList(1) onfocus=blur() title=首页><font face="Webdings">9</font></a>&nbsp;<a href=javascript:dspList('+ppre+') onfocus=blur() title=上一页><font face="Webdings">3</font></a>&nbsp;第<font color=#3399FF><b>'+cblock+ '</b></font>页&nbsp;共'+ totBlock+'页&nbsp;共'+totElm+'首&nbsp;<a href=javascript:dspList('+pnext+') onfocus=blur() title=下一页><font face="Webdings">4</font></a>&nbsp;<a href=javascript:dspList('+totBlock+') onfocus=blur() title=尾页><font face="Webdings">:</font></a>';

	}
	else { mmList.innerHTML='<a href=http://www.iShowSky.cn>iShowMusic</a>'; }
	 }

function mOvrSend(src,clrOver){ 
	if (!src.contains(event.fromElement)) { 
		src.style.cursor = 'hand'; 
		src.bgColor = clrOver; 
	}
}
function mOutSend(src,clrIn)  { 
	if (!src.contains(event.toElement)) { 
		src.style.cursor = 'default'; 
		src.bgColor = clrIn; 
	}
}
-->