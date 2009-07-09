var isIE=document.all?true:false;
function googleHint(key){
  if($('gsuggest'))$('gsuggest').removeNode(true);
  if (document.readyState=="complete"){
    var sg=document.body.appendChild(document.createElement('script'));
    sg.language='javascript';
    sg.id='gsuggest';
    sg.charset='utf-8';
    sg.src='http://www.google.cn/complete/search?hl=zh-CN&client=suggest&js=true&q=' + encodeURIComponent(key);
   }
}
var showobj=$('getfocus');
function myhint(event,obj){
   showobj=obj;
   if(!isIE)  return ;
   var keyword=showobj;
   var h=$('suggest');
   if(!keyword.value || !keyword.value.length || event.keyCode==27 || event.keyCode==13){
       h.style.display='none';
       return;
   }
   if(event.keyCode==38 || event.keyCode==40){
     if(h.style.display=='none') return;
       if(event.keyCode==38){
         if(h._i==-1)h._i=h.firstChild.rows.length-1;
         else{
	     h._i--;
         } 
      }else{
         h._i++;
      } 
    for(var i=0;i<h.firstChild.rows.length;i++)h.firstChild.rows[i].style.background="#FFF";
      if(h._i >= 0 && h._i < h.firstChild.rows.length)with(h.firstChild.rows[h._i]){
        style.background="#F1F8FF";
		tmp=cells[0].innerHTML.split("</EM>");
        keyword.value=tmp[1].replace("</A>",'');
      }else{
        keyword.value=h._kw;
        h._i=-1;
      } 
    }else{
      h._i=-1;
      h._kw=keyword.value;
      googleHint(keyword.value);
      var pos=getPosition(keyword);
      with(h.style){
        left=pos.x;
        top=pos.y+keyword.offsetHeight;
        width=keyword.offsetWidth - 1;
      } 
    } 
}
var searchurl='http://www.baidu.com/s?tn=haozhan&ie=utf-8&wd=';
window.google={} ;
window.google.ac={} ;
window.google.ac.Suggest_apply=function(a,b,c,d){
 if(!c || c.length<3) return;
 if(b != showobj.value) return;
 var ihtml='';
 if (document.readyState=="complete")
 {
  for(var j=1;j<c.length;j+=2){
      url=searchurl+encodeURIComponent(c[j]);
	  ihtml+='<tr style="cursor:hand" onmouseover="this.style.background=\'#F1F8FF\';$(\''+showobj.id+'\').value=\'' +c[j] +'\';" onmouseout="this.style.background=\'#FFF\';"><td style="color:#000;" align="left"><a href="'+url+'" target="_blank" onclick="$(\'suggest\').style.display=\'none\';"><em style="cursor:pointer">' +c[j+1] +'</em>' +c[j] +'</a></td></tr>';
  }
    $('suggest').innerHTML='<table width="100%" border="0" cellpadding="0" cellspacing="0">'+ihtml+'</table>';
    $('suggest').style.display="block";
  }else{
    //setTimeout("myhint(event)", 2000);
  }
};
function getPosition(ele){
	var overflown = [];
	var el = ele, left = 1, top = 2;
	do {
		left += el.offsetLeft || 0;
		top += el.offsetTop || 0;
		el = el.offsetParent;
	} while (el);
	return {'x': left, 'y': top};
}