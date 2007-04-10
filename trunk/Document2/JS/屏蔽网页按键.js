<!-- 
  //屏蔽鼠标右键、Ctrl+N、Shift+F10、F11、F5刷新、退格键

document.oncontextmenu = function(){ return false;}//屏蔽鼠标右键 
function window.onhelp(){return false} //屏蔽F1帮助
 
function document.onkeydown() 
{
  if (event.srcElement.tagName == "A" && event.keyCode == 16) {
  	alert("对不起，不能使用Shift加鼠标左键或Enter新开一网页！");
	event.returnValue=false;
  }//屏蔽 shift 加鼠标左键新开一网页

  if ((window.event.altKey)&& 
      ((window.event.keyCode==37)||   //屏蔽 Alt+ 方向键 ← 
       (window.event.keyCode==39)))   //屏蔽 Alt+ 方向键 → 
  { 
     alert("对不起, 不能使用ALT+方向键前进或后退网页！"); 
     event.returnValue=false; 
  } 

  if (//(event.keyCode==8)  ||                 //屏蔽退格删除键 
      (event.keyCode==116)||                 //屏蔽 F5 刷新键 
      (event.ctrlKey && event.keyCode==82)){ //Ctrl + R 
     event.keyCode=0; 
     event.returnValue=false; 
     } 
  if (event.keyCode==122){event.keyCode=0;event.returnValue=false;}  //屏蔽F11 
  if (event.ctrlKey && event.keyCode==78) event.returnValue=false;   //屏蔽 Ctrl+n 
  if (event.shiftKey && event.keyCode==121)event.returnValue=false;  //屏蔽 shift+F10

  if ((window.event.altKey)&&(window.event.keyCode==115))             //屏蔽Alt+F4 
  { 
      window.showModelessDialog("about:blank","","dialogWidth:1px;dialogheight:1px"); 
      return false; 
  }
}
//-->