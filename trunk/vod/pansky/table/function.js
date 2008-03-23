var imgUrl=new Array();
var imgLink=new Array();
var imgtext=new Array();
var adNum=0;
imgUrl[1]="image/src/1.jpg";
imgtext[1]="image1";
imgLink[1]="#1";
imgUrl[2]="image/src/2.jpg";
imgtext[2]="image2";
imgLink[2]="#2";
imgUrl[3]="image/src/3.jpg";
imgtext[3]="image3";
imgLink[3]="#3";
var imgPre=new Array();
var count=0;
for (i=1;i<=3;i++) 
{
	if( (imgUrl[i]!="") && (imgLink[i]!="") ) 
	{
		count++;
	} 
	else 
	{
		break;
	}
}
function playTran()
{
	if (document.all)
	{
		imgInit.filters.revealTrans.play();
	}
}
var key=0;
function nextAd()
{
	if(adNum<count)
	{
		adNum++ ;
	}
	else
	{
		adNum=1;
	}
	if(key==0)
	{
		key=1;
	} 
	else if(document.all)
	{
		imgInit.filters.revealTrans.Transition=23;
		imgInit.filters.revealTrans.apply();
		playTran();
	}
	document.images.imgInit.src=imgUrl[adNum];
	document.images.imgInit.alt=imgtext[adNum];
	theTimer=setTimeout("nextAd()", 3000);
}
function goUrl()
{
	window.location=imgLink[adNum];
}
function nextImg(d)
{
	imgInit.filters.revealTrans.Transition=23;
	imgInit.filters.revealTrans.apply();
	playTran();
	if(d>0)
	{
		adNum++;
		if(adNum>count)
		{
			adNum=1;
		}
	}
	else
	{
		adNum--;
		if(adNum<1)
		{
			adNum=count;
		}
	}
	document.images.imgInit.src=imgUrl[adNum];
	document.images.imgInit.alt=imgtext[adNum];
}


function wordCount()
{
	maxLen=1000;
	if (document.form3.content.value.length > maxLen)
	{
		document.form3.content.value = document.form3.content.value.substring(0,maxLen);
	}
	else
	{
		document.getElementById('wordCount').innerHTML=document.form3.content.value.length;
	}
}

//µ¼º½
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);

function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}

