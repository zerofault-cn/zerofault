<div id="andyscroll" style="overflow:hidden;height:740px">
	<div id="scrollmessage">
	���ǹ�������
	</div>
</div>
<script type="text/javascript"> 
<!-- 
var stopscroll = false; 
var scrollElem = document.getElementById("andyscroll"); 
var marqueesHeight = scrollElem.style.height; 
scrollElem.onmouseover = new Function('stopscroll = true'); 
scrollElem.onmouseout  = new Function('stopscroll = false'); 
var preTop = 0; 
var currentTop = 0; 
var stoptime = 0; 
var leftElem = document.getElementById("scrollmessage");  
scrollElem.appendChild(leftElem.cloneNode(true)); 
init_srolltext(); 

function init_srolltext(){ 
scrollElem.scrollTop = 0; 
setInterval('scrollUp()', 20);//������������25, ��ȷ�������ٶȵ�, ��ֵԽС, �ٶ�Խ�� 
} 
function scrollUp(){ 
if(stopscroll) return; 
currentTop += 2; //��Ϊ1, ����ʵ�ּ�Ъʽ�Ĺ���; ��Ϊ2, ������������ 
if(currentTop == 19) { 
stoptime += 1; 
currentTop -= 1; 
if(stoptime == 180) { 
currentTop = 0; 
stoptime = 0; 
} 
}else{ 
preTop = scrollElem.scrollTop; 
scrollElem.scrollTop += 1; 
if(preTop == scrollElem.scrollTop){ 
scrollElem.scrollTop = 0; 
scrollElem.scrollTop += 1; 
} 
} 
} 
//--> 
</script>