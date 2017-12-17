var lrc0;
var lrc1;
var min;
lrcobj = new lrcClass(lrcdata.innerHTML.slice(4,-3));

function lrcClass(tt)
{
  this.inr = [];
  this.min = [];

  this.oTime = 0;

  this.dts = -1;
  this.dte = -1;
  this.dlt = -1;
  this.ddh;
  this.fjh;

  lrcbc.style.width = 0;

  if(/\[offset\:(\-?\d+)\]/i.test(tt))
    this.oTime = RegExp.$1/1000;

  tt = tt.replace(/\[\:\][^$\n]*(\n|$)/g,"$1");
  tt = tt.replace(/\[[^\[\]\:]*\]/g,"");
  tt = tt.replace(/\[[^\[\]]*[^\[\]\d]+[^\[\]]*\:[^\[\]]*\]/g,"");
  tt = tt.replace(/\[[^\[\]]*\:[^\[\]]*[^\[\]\d\.]+[^\[\]]*\]/g,"");
  tt = tt.replace(/<[^<>]*[^<>\d]+[^<>]*\:[^<>]*>/g,"");
  tt = tt.replace(/<[^<>]*\:[^<>]*[^<>\d\.]+[^<>]*>/g,"");

  while(/\[[^\[\]]+\:[^\[\]]+\]/.test(tt))
  {
    tt = tt.replace(/((\[[^\[\]]+\:[^\[\]]+\])+[^\[\r\n]*)[^\[]*/,"\n");
    var zzzt = RegExp.$1;
    /^(.+\])([^\]]*)$/.exec(zzzt);
    var ltxt = RegExp.$2;
    var eft = RegExp.$1.slice(1,-1).split("][");
    for(var ii=0; ii<eft.length; ii++)
    {
      var sf = eft[ii].split(":");
      var tse = parseInt(sf[0],10) * 60 + parseFloat(sf[1]);
      var sso = { t:[] , w:[] , n:ltxt }
      sso.t[0] = tse-this.oTime;
      this.inr[this.inr.length] = sso;
    }
  }
  this.inr = this.inr.sort( function(a,b){return a.t[0]-b.t[0];} );

  for(var ii=0; ii<this.inr.length; ii++)
  {
    while(/<[^<>]+\:[^<>]+>/.test(this.inr[ii].n))
    {
      this.inr[ii].n = this.inr[ii].n.replace(/<(\d+)\:([\d\.]+)>/,"%=%");
      var tse = parseInt(RegExp.$1,10) * 60 + parseFloat(RegExp.$2);
      this.inr[ii].t[this.inr[ii].t.length] = tse-this.oTime;
    }
    lrcbc.innerHTML = "<font>"+ this.inr[ii].n.replace(/&/g,"&").replace(/</g,"<").replace(/>/g,">").replace(/%=%/g,"</font><font>") +"</font>";
    var fall = lrcbc.getElementsByTagName("font");
    for(var wi=0; wi<fall.length; wi++)
      this.inr[ii].w[this.inr[ii].w.length] = fall[wi].offsetWidth;
    this.inr[ii].n = lrcbc.innerText;
  }

  for(var ii=0; ii<this.inr.length-1; ii++)
    this.min[ii] = Math.floor((this.inr[ii+1].t[0]-this.inr[ii].t[0])*10);
  this.min.sort(function(a,b){return a-b});
  min = this.min[0]/2;

  this.run = function(tme)
  {
    if(tme<this.dts || tme>=this.dte)
    {
      var ii;
      for(ii=this.inr.length-1; ii>=0 && this.inr[ii].t[0]>tme; ii--){}
      if(ii<0) return;
      this.ddh = this.inr[ii].t;
      this.fjh = this.inr[ii].w;
      this.dts = this.inr[ii].t[0];
      this.dte = (ii<this.inr.length-1)?this.inr[ii+1].t[0]:aboutplayer.currentMedia.duration;

      lrcwt1.innerText = this.retxt(ii-7);
      lrcwt2.innerText = this.retxt(ii-6);
      lrcwt3.innerText = this.retxt(ii-5);
      lrcwt4.innerText = this.retxt(ii-4);
      lrcwt5.innerText = this.retxt(ii-3);
      lrcwt6.innerText = this.retxt(ii-2);
      lrcwt7.innerText = this.retxt(ii-1);
      lrcfilter.innerText = this.retxt(ii-1);
      lrcwt8.innerText = this.retxt(ii+1);
      lrcwt9.innerText = this.retxt(ii+2);
      lrcwt10.innerText = this.retxt(ii+3);
      lrcwt11.innerText = this.retxt(ii+4);
      lrcwt12.innerText = this.retxt(ii+5);
      lrcwt13.innerText = this.retxt(ii+6);
      this.print(this.retxt(ii));
      if(this.dlt==ii-1)
      {
        clearTimeout(lrc0);
        if(lrcoll.style.pixelTop!=0) lrcoll.style.top = 0;
        golrcoll(0);
        clearTimeout(lrc1);
        lrcfilter.filters.alpha.opacity = 100;
        golrcolor(0);
      }
      else if(parseInt(lrcoll.style.top)!=-20)
      {
        clearTimeout(lrc0);
        lrcoll.style.top = -20;
        clearTimeout(lrc1);
        lrcfilter.filters.alpha.opacity = 0;
      }
      this.dlt = ii;
    }
    var bbw = 0;
    var ki;
    for(ki=0; ki<this.ddh.length && this.ddh[ki]<=tme; ki++)
      bbw += this.fjh[ki];
    var kt = ki-1;
    var sc = ((ki<this.ddh.length)?this.ddh[ki]:this.dte) - this.ddh[kt];
    var tc = tme - this.ddh[kt];
    bbw -= this.fjh[kt] - tc / sc * this.fjh[kt];
    if(bbw>lrcbox.offsetWidth)
      bbw = lrcbox.offsetWidth;
    lrcbc.style.width = Math.round(bbw);
  }

  this.retxt = function(i)
  {
    return (i<0 || i>=this.inr.length)?"":this.inr[i].n;
  }

  this.print = function(txt)
  {
    lrcbox.innerText = txt;
    lrcbc.innerText = txt;
  }

  this.print("系统暂没有相关歌词\n或歌词正在加载中...\nwww.iShowSky.cn");
  lrcwt1.innerText = "";
  lrcwt2.innerText = "";
  lrcwt3.innerText = "";
  lrcwt4.innerText = "";
  lrcwt5.innerText = "";
  lrcwt6.innerText = "";
  lrcwt7.innerText = "";
  lrcfilter.innerText = "";
  lrcwt8.innerText = "";
  lrcwt9.innerText = "";
  lrcwt10.innerText = "";
  lrcwt11.innerText = "";
  lrcwt12.innerText = "";
  lrcwt13.innerText = "";
}

function lrcrun()
{
  with(aboutplayer)
  {
    lrcobj.run(controls.currentPosition);
  }
  if(arguments.length==0) setTimeout("lrcrun()",10);
}

function golrcoll(s)
{
  lrcoll.style.top = -(s++)*2;
  if(s<=9)
    lrc0 = setTimeout("golrcoll("+s+")",min*10);
}

function golrcolor(t)
{
  lrcfilter.filters.alpha.opacity = 110-(t++)*10;
  if(t<=10)
    lrc1 = setTimeout("golrcolor("+t+")",min*10);
}
window.onerror = function()
{return true;}
lrcrun();