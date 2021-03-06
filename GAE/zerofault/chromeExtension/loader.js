var text = chrome.contextMenus.create({"title": "收藏到我的网摘","contexts":["selection"], "onclick": posttwtext});
function posttwtext(info, tab) {
	var posturl="http://zerofault.appspot.com/add?type=note&title="+escape(tab.title)+"&url="+escape(info.pageUrl)+"&content="+escape(info.selectionText);
	chrome.windows.create({"url":posturl, "type":"popup", "height":500,"width":650});
}

var page = chrome.contextMenus.create({"title": "收藏到我的网址","contexts":["page"], "onclick": posttwpage});
function posttwpage(info, tab) {
	var posturl="http://zerofault.appspot.com/add?title="+escape(tab.title)+"&url="+escape(info.pageUrl);
	if (typeof(info.selectionText)!= 'undefined') {
		posturl += "&content="+escape(info.selectionText);
	}
	chrome.windows.create({"url":posturl, "type":"popup", "height":500,"width":650});
}

var pict = chrome.contextMenus.create({"title": "收藏到我的图库","contexts":["image"], "onclick": posttwpict});
function posttwpict(info, tab) {
	var posturl="http://zerofault.appspot.com/add?type=pic&title="+escape(tab.title)+"&url="+escape(info.srcUrl)+"&purl="+escape(info.pageUrl);
	if (typeof(info.selectionText)!= 'undefined') {
		posturl += "&content="+escape(info.selectionText);
	}
	chrome.windows.create({"url":posturl, "type":"popup", "height":500,"width":650});
}

var link = chrome.contextMenus.create({"title": "收藏到我的链接","contexts":["link"], "onclick": posttwlink});
function posttwlink(info, tab) {
	var posturl="http://zerofault.appspot.com/add?url="+escape(info.linkUrl);
	if (typeof(info.selectionText)!= 'undefined') {
		posturl += "&title="+escape(info.selectionText);
	}
	chrome.windows.create({"url":posturl, "type":"popup", "height":500,"width":650});
}

