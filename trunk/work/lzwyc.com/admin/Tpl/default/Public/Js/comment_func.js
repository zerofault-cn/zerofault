function copy(str){
	if(typeof(window.clipboardData)=='undefined'){
		myAlert('您的浏览器不支持此操作！');
		myOK(5000);
	}
	else{
		window.clipboardData.setData('Text',str);
		myAlert('已将Email地址复制到剪贴板！');
		myOK(1500);
	}
}
function traceIP(ip){ //提交新的分类
	//http://www.youdao.com/smartresult-xml/search.s?type=ip&q=122.224.1.1
	//http://www.yodao.com/smartresult-xml/search.s?type=mobile&q=15958010001
	$.post(_APP_+"/Public/httpPost",{
		'url':'http://www.ip138.com/ips.asp',
		'params':'ip='+ip+'&action=2'
	},function(str){
			var pos = str.indexOf('<ul class="ul1">');
			str = str.substr(pos);
			pos = str.indexOf('</ul>');
			myAlert(str.substr(0,pos+5));
		});
}

