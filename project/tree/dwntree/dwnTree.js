//dwnTree 1.1
//All By 秦歌
//Welcome to Dancewithnet.com
//Email:kavenyan@163.com
//URL:http://dancewithnet.com/2007/04/30/dwntree/

var dwnTree = function(url,container,options){
	this.url = url;
	this.container = $(container);
	this.options = {
		name:null,
		hours:365*24,
		path:null,
		domain:null,
		secure:false				
	}
	Object.extend(this.options,options||{});
	this.id = 'dwn';
	this.self = this;
	this.create();
	var _opt = this.options;
	if(_opt.name){
		this.cookie = new dwnCookie(_opt.name,_opt.hours,_opt.path,_opt.domain,_opt.secure);
	}
}
dwnTree.prototype ={
	create:function(){
		this.container.innerHTML = '正在装载数据，请稍等，……';
		var xmlHttpReq;
		if(window.ActiveXObject){
		try{xmlHttpReq = new ActiveXObject('Msxml2.XMLHTTP');}
		catch(e){
				try{xmlHttpReq = new ActiveXObject('Microsoft.XMLHTTP');}
				catch(ex){xmlHttpReq = null;}
			}
		}else if(window.XMLHttpRequest){//for Mozilla, Safari,...
			xmlHttpReq = new XMLHttpRequest();
			if (xmlHttpReq.overrideMimeType) {//for some Mozilla
				xmlHttpReq.overrideMimeType('text/xml');
			}
		}
		if(!xmlHttpReq){
			alert('Giving up :( Cannot create an XMLHTTP instance');
			return false;
		}
		xmlHttpReq.onreadystatechange=function(){
			if (xmlHttpReq.readyState==4){
				if(xmlHttpReq.status==200){
					this.itemRoot = xmlHttpReq.responseXML.documentElement;
					this.container.innerHTML = '';				
					this.create_item(this.itemRoot,this.container);
				}else{this.container.innerHTML=xmlHttpReq.status+'!Data downloaded unsuccessfully.'}
			}
		}.bind(this);
		var _cache = 'cache=' + (new Date()).getTime() + '.xml';
		var _url = this.url; 
		if(_url.indexOf('?')>-1){_url = _url + '&' + _cache;}
		else{_url = _url + '?' + _cache;}
		xmlHttpReq.open('GET',_url,true);
		xmlHttpReq.send(null);
	},
	create_item:function(root,container){
		var itemNodes = [];
		var nodes = root.childNodes;
		var itemList = dwn_create_tag('ul');
		for(var i=0;i<nodes.length;i++){
			if(nodes[i].nodeType == 1){itemNodes.push(nodes[i]);}
		}
		var listLen = itemNodes.length;
		for(var i=0;i<listLen;i++){
			var _item = itemNodes[i];
			var subItem = dwn_create_tag('li');
			if(i==listLen -1){subItem.className = 'noBg';}
			if(_item.hasChildNodes()){
				var subContainer = dwn_create_tag('div');
				var caption = dwn_create_tag('span');
				caption.appendChild(document.createTextNode(_item.getAttribute('caption')));
				caption.onmouseover = function(){
					if(this.className!='active'){this.className = 'hover';}
				}
				caption.onmouseout = function(){
					if(this.className!='active'){this.className = '';}
				}
				subContainer.appendChild(caption);
				subContainer.root = _item;
				subContainer.create_item = this.create_item;
				subContainer.container = subItem;
				subContainer.className = 'fold';
				if(i==listLen -1){subContainer.className = 'foldLast';}
				if(i==0 && root == this.itemRoot){subContainer.className = 'foldFirst';}
				subContainer.onclick = function(){
					this.self.delete_active();
					this.firstChild.className = 'active';
					if(this.unfolded == null){
						this.create_item(this.root,this.container);
						this.unfolded = true;
						if(this.self.cookie){this.self.cookie.set(this.id,2);}
						if(this.className=='foldLast'){this.className='unfoldLast';}
						else if(this.className=='foldFirst'){this.className='unfoldFirst';}
						else{this.className = 'unfold';}
					}else if(this.unfolded){
						this.nextSibling.style.display = 'none';
						this.unfolded = false;
						if(this.self.cookie){this.self.cookie.set(this.id,3);}
						if(this.className=='unfoldLast'){this.className='foldLast';}
						else if(this.className=='unfoldFirst'){this.className='foldFirst';}
						else{this.className = 'fold';}
					}else{
						this.nextSibling.style.display = 'block';
						this.unfolded = true;
						if(this.self.cookie){this.self.cookie.set(this.id,2);}
						if(this.className=='foldLast'){this.className='unfoldLast';}
						else if(this.className=='foldFirst'){this.className='unfoldFirst';}
						else{this.className = 'unfold';}
					}
				}
			}else{
				var subContainer = dwn_create_tag('a');
				subContainer.setAttribute('href',_item.getAttribute('url'));
				if(_item.getAttribute('target')){subContainer.setAttribute('target',_item.getAttribute('target'));}
				subContainer.appendChild(document.createTextNode(_item.getAttribute('caption')));
				subContainer.onclick = function(){
					this.self.delete_active();
					this.className = 'active';
					if(this.self.cookie){this.self.cookie.set(this.id,1);}
				}
				subItem.className = 'anchor';
				if(i==listLen -1){subItem.className = 'joinLast';}
				if(i==0 && root == this.itemRoot){subItem.className = 'joinFirst';}
			}
			subContainer.self = this.self;
			subContainer.id = this.id + '_' + i;
			subItem.appendChild(subContainer);
			var _cookie = -1
			if(subContainer.self.cookie){_cookie = subContainer.self.cookie.get(subContainer.id)||-1;}
			if(subContainer.unfold==null){
				if(_item.hasChildNodes() && ((_item.getAttribute('unfolded') && _cookie!=0 && _cookie!=3 )||_cookie==1||_cookie==2)){
					subContainer.create_item(itemNodes[i],subItem);
					subContainer.unfolded = true;
					if(subContainer.className=='foldLast'){subContainer.className='unfoldLast';}
					else if(subContainer.className=='foldFirst'){subContainer.className='unfoldFirst';}
					else{subContainer.className = 'unfold';}
				}else if(!_item.hasChildNodes() && _cookie==1){
					subContainer.className = 'active';
					subContainer.unfolded = true;
				}
			}
			if(_cookie==2 || _cookie == 3){subContainer.firstChild.className = 'active';}
			itemList.appendChild(subItem);
		}
		container.appendChild(itemList);
	},
	delete_active:function(){
		var actives = dwn_getElementsByClass('active',this.container);
		for(var i=0;i<actives.length;i++){
			actives[i].className = '';
			if(this.self.cookie){
				var _id = actives[i].id;
				if(_id){
					var _cookie = this.self.cookie.get(_id);
					if(_cookie=1){this.self.cookie.set(_id,0);}
					
				}else{
					_id = actives[i].parentNode.id;
					var _cookie = this.self.cookie.get(_id)*1;
					switch(_cookie){
						case 2:
							this.self.cookie.set(_id,1);
						break;
						case 3:
							this.self.cookie.set(_id,0);
						break;
					}
				}
			}
		}
	}
}

var $ = function(obj){ return document.getElementById(obj);}
var dwn_create_tag = function(tag){return document.createElement(tag);}
var dwnUserAgent = navigator.userAgent;
var dwnIsOpera = dwnUserAgent.indexOf('Opera')>-1;
var dwnIsIE = dwnUserAgent.indexOf('MSIE')>-1 && !dwnIsOpera;

Function.prototype.bind = function() {
  var __method = this, args = $A(arguments), object = args.shift();
  return function() {
    return __method.apply(object, args.concat($A(arguments)));
  }
}
var $A = function(iterable) {
  if (!iterable) return [];
  if (iterable.toArray) {
    return iterable.toArray();
  } else {
    var results = [];
    for (var i = 0, length = iterable.length; i < length; i++)
      results.push(iterable[i]);
    return results;
  }
}
Object.extend = function(destination, source) {
  for (var property in source) {
    destination[property] = source[property];
  }
  return destination;
}
var dwn_getElementsByClass = function (searchClass,node,tag) {
	var classElements = new Array();
	if ( node == null )
		node = document;
	if ( tag == null )
		tag = '*';
	var els = node.getElementsByTagName(tag);
	var elsLen = els.length;
	var pattern = new RegExp('(^|\\s)'+searchClass+'(\\s|$)');
	for (i = 0, j = 0; i < elsLen; i++) {
		if ( pattern.test(els[i].className) ) {
			classElements[j] = els[i];
			j++;
		}
	}
	return classElements;
}
var dwnCookie = function(name,hours,path,domain,secure){
	this._name = name; 
	if(hours){this._expiration = new Date((new Date()).getTime() + hours*3600000);}
		else{this._expiration = null;}
	if(path){this._path = path;}
		else{this._path = null;}
	if(domain){this._domain = domain;}
		else{this._domain = null;}
	if(secure) {this._secure = true;}
		else{this._secure = false;}
	if(!this.init()){this.store();}
}
dwnCookie.prototype.store = function(){
	var cookieVal ='';
	for(var prop in this){
		if((prop.charAt(0) == '_')||((typeof this[prop]) == 'function')){continue;}
		if(cookieVal !=''){cookieVal += '&';}
		//cookieVal += prop + ':' + encodeURIComponent(this[prop].join());//decodeURIComponent
		cookieVal += prop + ':' + this[prop];
	}
	var cookie = this._name + '=' + cookieVal;
	if(this._expiration){cookie += ';expires=' + this._expiration.toGMTString();}
	if(this._path){cookie += ';path=' + this._path;}
	if(this._domain){cookie += ';domain=' + this._domain;}
	if(this._secure){cookie += ';secure';}
	document.cookie = cookie;
}
dwnCookie.prototype.init = function(){
	var allCookies = document.cookie;
	if(allCookies == ''){return false;}
	var start = allCookies.indexOf(this._name + '=');
	if(start == -1){return false;}
	start += this._name.length + 1;
	var end = allCookies.indexOf(';',start);
	if(end == -1){end = allCookies.length;}
	var cookieVal = allCookies.substring(start,end);
	if(cookieVal==''){return true;}
	var stat = cookieVal.split('&');
	for(var i=0;i<stat.length;i++){
		stat[i] = stat[i].split(':');
		this[stat[i][0]] = stat[i][1];
	}
	return true;
}
dwnCookie.prototype.set = function(name,n){
	this.init();
	this[name] = n;
	this.store();
}
dwnCookie.prototype.get = function(name){
	this.init();
	if(!this[name]){return null;}
	else{return this[name];}
}