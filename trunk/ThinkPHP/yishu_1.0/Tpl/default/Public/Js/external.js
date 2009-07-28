 var bookmarkname=document.title;
 var dynamichost=document.location.host;
 var countimg=document.createElement('img');
 document.onclick=clickOut;
function checkhomepage(){
   if (document.getElementById('logo').isHomePage('http://' + document.location.host + '/'))
   {
     return true;
   }else{
     return false;
   }
}
function clicklogo(){
    if(checkhomepage()){
	    window.location=('http://' + document.location.host + '/');
	}else{ 
		document.getElementById('logourl').style.behavior='url(#default#homepage)';
		document.getElementById('logourl').setHomePage('http://' + document.location.host + '/'); 
	}
}
function selectTag(showContent,selfObj){
	var tag = document.getElementById("tags").getElementsByTagName("a");
	var taglength = tag.length;
	for(i=0; i<taglength; i++){
		tag[i].className = "";
	}
	selfObj.className = "focu";
	for(i=0; j=document.getElementById("baidu"+i); i++){
		j.style.display = "none";
	}
	document.getElementById(showContent).style.display = "block";
}
function addBookmark(title,url) {
    if (window.sidebar) {
        window.sidebar.addPanel(title, url,"");
    } else if( document.all ) {
        window.external.AddFavorite( url, title);
    } else if( window.opera && window.print ) {
        return true;
    }
}
function setHomePage(url){
    if (window.sidebar)
    {
        try { 
           netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect"); 
        } 
        catch (e) 
        {  
           alert("此操作被浏览器拒绝！\n请在浏览器地址栏输入“about:config”并回车\n然后将[signed.applets.codebase_principal_support]设置为'true'"); 
        } 
        var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
            prefs.setCharPref('browser.startup.homepage',url);
    }
}

function SetCookie (name, value) { 
       var exp = new Date(); 
       exp.setTime (exp.getTime()+86400*365); 
       document.cookie = name + "=" + value + "; expires=" + exp.toGMTString()+"; path=/"; 
}

function getCookieVal (offset) { 
	var endstr = document.cookie.indexOf (";", offset); 
	if (endstr == -1) endstr = document.cookie.length; 
    return unescape(document.cookie.substring(offset, endstr)); 
 } 
function DelCookie(name)
{
    SetCookie(name, '');
    return;
}

function GetCookie(name) {
         var arg = name + "="; 
         var alen = arg.length; 
         var clen = document.cookie.length; 
         var i = 0; 
         while (i < clen) { 
             var j = i + alen; 
             if (document.cookie.substring(i, j) == arg) return getCookieVal (j); 
             i = document.cookie.indexOf(" ", i) + 1; 
             if (i == 0) break; 
         } 
	     return null; 
 } 
function $(o){
 var o=document.getElementById(o)?document.getElementById(o):'';
 return o;
}
function createXMLHttpRequest(){
  if(window.ActiveXObject){
      xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
  }else if(window.XMLHttpRequest) {
      xmlHttp = new XMLHttpRequest();
  }
} 
function startRequest(url,returnfun) {
   createXMLHttpRequest(); 
   xmlHttp.onreadystatechange =returnfun;
   xmlHttp.open("GET",url,true);
   xmlHttp.send(null);    

}
function weatherStateChange(){
  if(xmlHttp.readyState == 4){
	  $("ipweather").innerHTML=xmlHttp.responseText;
  }	  
}

function ResetPwd()
{
	$("Mpwd").value="";
}
function checkIP(ip)
{
	var ipArray,j;
	var ip=ip.toLowerCase();
    if(/[A-Za-z_-]/.test(ip)){
		if(!/^([\w-]+\.)+((com)|(net)|(org)|(gov\.cn)|(info)|(cc)|(com\.cn)|(net\.cn)|(org\.cn)|(name)|(biz)|(tv)|(cn))$/.test(ip)){
			alert("不是正确的域名或域名");
			return false;
		}
              
    }else{
		ipArray = ip.split(".");
		j = ipArray.length
		if(j!=4)
		{
			alert("不是正确的IP或域名");			
			return false;
		}

		for(var i=0;i<4;i++)
		{
			if(ipArray[i].length==0 || ipArray[i]>255)
			{
				alert("不是正确的IP或域名");
				return false;
			}
		}
	}
}

function DelHtml(Word) {
  a = Word.indexOf("<");
  b = Word.indexOf(">");
  len = Word.length;
  c = Word.substring(0, a);
  if(b == -1)
  b = a;
  d = Word.substring((b + 1), len);
  Word = c + d;
  tagCheck = Word.indexOf("<");
   if(tagCheck != -1)
   Word = DelHtml(Word);
   return Word;
} 

function history_show()
{   
try
{
 var history=GetCookie("history");
 history=unescape(history);
 var content='';
 if(history!="null"&&history.indexOf("&")==-1)
 {
 history_arg=history.split("_honghesoft_");
 i=0;
 linknum=0;
 len= history_arg.length;
 for(i=0;i<len;i++)
 { 
 	var wlink=history_arg[i].split("+");
    if(history_arg[i]!="null" && content.indexOf(wlink[0])==-1 && linknum<44){
       content+="<li><a href=\""+wlink[1]+"\" target=\"_blank\"  title=\""+wlink[0]+"\">"+wlink[0]+"</a></li>";
       linknum+=1;
    }    
}    
 document.getElementById("history").innerHTML=content; 

}else{
 	document.getElementById("history").innerHTML="<div style='text-align=center'>您目前还没有浏览记录。</div>";

}
}
catch(e){}
}

function favorate_show()
{   
    try
    {
         var favorate=GetCookie("favorate");
         favorate=unescape(favorate);
         var content='';
         if(favorate!='null')
         {
             favorate_arg=favorate.split("`~honghesoft~`");
             i=0;
             linknum=0;
             len= favorate_arg.length;
             for(i=0;i<len;i++)
             { 
             	var wlink=favorate_arg[i].split("`~mysites~`");
                if(favorate_arg[i]!="null" && content.indexOf(wlink[0])==-1 && linknum<44)
                {
                   content+="<li><a href=\""+wlink[1]+"\" target=\"_blank\"  title=\""+wlink[0]+"\">"+wlink[0]+"</a></li>";
                   linknum+=1;
                }    
            }    
            document.getElementById("favorate").innerHTML=content;         
        }
        else
        {
         	document.getElementById("favorate").innerHTML="<div style='text-align=center'>您的网址收藏夹里目前还没有网址。 <a href='user/'>点击这里管理收藏夹</a>>></div>";
        }
    }
    catch(e)
    {
    }
}

function ClearHistory()
{
  if(confirm("您要清除所有的浏览记录，是否确定？")	)
  {
	DelCookie("history");
	document.getElementById("history").innerHTML="<center>目前还没有浏览记录。</center>";
  }
}

function clickOut(evt)
{
    evt=evt?evt:window.event;
    var srcElem=(evt.target)?evt.target:evt.srcElement;
    if (('A' == srcElem.tagName.toUpperCase()) && ('' != srcElem.id) && (!isNaN(srcElem.id)))
    {
         var  wlink=srcElem.innerHTML+"+"+srcElem.href +"_honghesoft_"; 
         wlink+=GetCookie("history");
         wlink=escape(wlink);
         SetCookie("history",wlink); 
         history_show();
    
        var url = "apps/clickout.php?sId=" + srcElem.id + "&t=" + (new Date()).getTime();
        
        try 
        {
            if (!isIndex)
            {
                url = '../' + url;
            }
        }
        catch (e)
        {
            url = '../' + url;
        }
        
        countimg.src= url;
    }
}

function handleStateChange(){
  if(xmlHttp.readyState == 4){
	  //alert(xmlHttp.responseText);
  }	  
}
var showsoft=false;
function showStm(n){
	if(n==0)showindexhtml();
	if(showsoft==false && n==1){
		$("indexsoft").innerHTML="正在加载中,请稍候……";
        softinfo();
		showsoft=true;
	}
	for (i=0;i<=4;i++){
		 document.getElementById("stgm" + i).className = "blur";
		 document.getElementById("stm" + i).style.display = "none";
    }
	document.getElementById("stgm" + n).className = "";
	document.getElementById("stm" + n).style.display = "block";
}
function softinfo(){
   startRequest("apps/soft.html",showsoftinfo);	
}
function showsoftinfo(){
 if(xmlHttp.readyState == 4){
   $("indexsoft").innerHTML=xmlHttp.responseText;
 }
}
var tmptxt='';
function gositesearch(keyword){
	oldkeyword=keyword;
	if (tmptxt=='')
	{
		tmptxt=$("indexhtml").innerHTML;// 保存临时变量
	}
	url='apps/insidesearch.php?keyword='+encodeURIComponent(keyword)+'&t='+(new Date()).getTime();
    $("indexhtml").innerHTML='<center><img src="images/loading.gif" />正在搜索中,请稍候...</center>';
	startRequest(url,showsearchsite);
}
function showsearchsite(){
  if(xmlHttp.readyState == 4){
	  txt=xmlHttp.responseText;
	  if(txt=='')
	  { 
		 $("indexhtml").innerHTML='<center>没有搜索到相关站点!</center>';
		 setTimeout(showindexhtml,2000);
	  }else{
	     $("indexhtml").innerHTML=txt;
	  }
  }	  
}
function showindexhtml(){
 if(tmptxt!=''){
   $("indexhtml").innerHTML=tmptxt;
 }
}
function JHshStrLen(sString)
{
var sStr,iCount,i,strTemp ; 
iCount = 0 ;
sStr = sString.split("");
for (i = 0 ; i < sStr.length ; i ++)
{
strTemp = escape(sStr[i]); 
if (strTemp.indexOf("%u",0) == -1) // 表示是汉字
{ 
iCount = iCount + 1 ;
} 
else 
{
iCount = iCount + 2 ;
}
}
return iCount ;
}
var oldkeyword='';
function KeyDown()
{
    if (event.keyCode == 13)
    {
        event.returnValue=false;
        event.cancel = true;
        if($('sitekeyword').value=='' ||JHshStrLen($('sitekeyword').value)<2){
			alert('请输入要搜索的关键字或关键字不能少于2个字节!!');
		}else{
			if ($('sitekeyword').value!=oldkeyword)
			{
				gositesearch($('sitekeyword').value);
			}
			
		}
    }
}
function input(){
	
      if($('sitekeyword').value=='' ||JHshStrLen($('sitekeyword').value)<2 ){//||JHshStrLen($('sitekeyword').value)<3
		 // showindexhtml();
      }else{
		  // $("indexhtml").innerHTML=JHshStrLen($('sitekeyword').value);
		  // 请求判断
		  // if (xmlHttp.readyState!=4)
		   //{
			 //  xmlHttp.abort();
		   //}
	       if ($('sitekeyword').value!=oldkeyword)
		  {
			gositesearch($('sitekeyword').value);
		  }
			
	  }
}
function addsite(site){
  var lst = '';  
  for(i=0;i<site.length;i++){
     if(site[i][2]==''){
		 lst+='<a href="'+site[i][0]+'" target="_blank">'+site[i][1]+'</a>&nbsp;&nbsp;';
	 }else{
		 lst+='<a href="'+site[i][0]+'" target="_blank"><span style="color:'+site[i][2]+'">'+site[i][1]+'</span></a>&nbsp;&nbsp;';
	 }
    
  }
  $("dfsite").innerHTML='<strong>地方站点</strong>&nbsp;&nbsp;&nbsp;&nbsp;'+lst;
  $("dfsite").style.display="block";
 
}
function CopyToClipBoard(){
	window.clipboardData.setData("Text", document.title + '\r\nhttp://' + document.location.host + '/');
	alert("复制成功，请粘贴到你的QQ/MSN上推荐给你的好友，谢谢！");
}

try
{
    if (isIndex && ('' != document.referrer) && !isSameSite(document.referrer))
    {
        countimg.src = "apps/clickin.php?url=" + document.referrer;
    }
}
catch(e)
{}

function isSameSite(str)
{
    return (new RegExp("http://" + document.location.host)).test(str);
}

function goSearch(objSrc, objUrl)
{
    if ('' == objSrc.value)
    {
        alert('请输入关键词。');
        objSrc.select();
        return false;
    }
    var targetUrl = objUrl.value + gb2312(objSrc.value);
    window.open(targetUrl);
    
    return false;    
}

function gb2312(key)
{
    var r = "";
    for(var i=0;i<key.length;i++)
    {
        var t = key.charCodeAt(i);
        if(t>=0x4e00 || t==0x300A || t==0x300B)
        {
            try
            {
                execScript("ascCode=hex(asc(\""+key.charAt(i)+"\"))", "vbscript");
                r += ascCode.replace(/(.{2})/g, "%$1");
            } 
            catch (e)
            {
            } 
        } 
        else
        {
            r += escape(key.charAt(i))
        }  
    }  
    return r;
} 

function showClickInSites(divName)
{
    try
    {
        if (arrClickInSites.length <= 1)
        {
            return;
        }
        
        var str = '';
        str += '<div class="title">';
        str += '<div class="subject">点入推荐</div>';
        str += '<div class="link"><a href="apps/about.html#link">想让您的网站出现在这里？</a></div>';
        str += '<div class="time">更新时间：' + clickInRefreshDate + ' ' + clickInRefreshTime + '</div>';
        str += '</div>';
        str += '<div class="con">';
        str += '<ul>';
        for (i = 0; i < arrClickInSites.length - 1; i++)
        {
            if (undefined != arrClickInSites[i][0])
            {
                str += '<li><a href="' + arrClickInSites[i][2] + '" id="' + arrClickInSites[i][0] + '" title="' + arrClickInSites[i][1] + '">' + arrClickInSites[i][1] + '</a></li>';
            }
        }
        str += '</ul>';
        str += '</div>';
        str += '<div style="clear:both"></div>';
        
        $(divName).innerHTML = str;
    }
    catch (e)
    {}
}

function closeWin()
{
    window.opener = null;
    window.close();
}