//K_ReverterMap 0.3
function K_ReverterMap()
{
//这个是加载外部JS的函数,handle是加载完成后执行的函数
	function K_LoadJS(src,handle)
	{
		var jsFile= document.createElement("script");
		jsFile.src=src;
		jsFile.onreadystatechange=function(){if(this.readyState=="complete" || this.readyState=="loaded"){if(handle)handle.call()}};
		document.body.appendChild(jsFile);
	}
//读取网址后缀的函数
	function K_GetQueryString(key)
	{
		var returnValue =""; 
		var sURL = window.document.URL;
		if (sURL.indexOf("?") > 0)
		{
			var arrayParams = sURL.split("?");
			var arrayURLParams = arrayParams[1].split("&");
			for (var i = 0; i < arrayURLParams.length; i++)
			{
				var sParam =  arrayURLParams[i].split("=");

				if ((sParam[0] ==key) && (sParam[1] != ""))
					returnValue=sParam[1];
			}
		}
		return returnValue;
	}
//读写Cookie的函数
	function K_GetCookieVal(offset)
	{
		var endstr = document.cookie.indexOf (";", offset);
		if (endstr == -1)
			endstr = document.cookie.length;
		return unescape(document.cookie.substring(offset, endstr));
	}
	function K_SetCookie(name, value)
	{
		var expdate = new Date();
		var argv = K_SetCookie.arguments;
		var argc = K_SetCookie.arguments.length;
		var expires = (argc > 2) ? argv[2] : null;
		var path = (argc > 3) ? argv[3] : null;
		var domain = (argc > 4) ? argv[4] : null;
		var secure = (argc > 5) ? argv[5] : false;
		if(expires!=null) expdate.setTime(expdate.getTime() + ( expires * 1000 ));
		document.cookie = name + "=" + escape (value) +((expires == null) ? "" : ("; expires="+ expdate.toGMTString()))+((path == null) ? "" : ("; path=" + path)) +((domain == null) ? "" : ("; domain=" + domain))+((secure == true) ? "; secure" : "");
	}
	function K_DelCookie(name)
	{
		var exp = new Date();
		exp.setTime(exp.getTime() - 1);
		var cval =K_GetCookie(name);
		document.cookie = name + "=" + cval + "; expires="+ exp.toGMTString();
	}
	function K_GetCookie(name)
	{
		var arg = name + "=";
		var alen = arg.length;
		var clen = document.cookie.length;
		var i = 0;
		while (i < clen)
		{
			var j = i + alen;
			if (document.cookie.substring(i, j) == arg)
				return K_GetCookieVal(j);
			i = document.cookie.indexOf(" ", i) + 1;
			if (i == 0) break;
		}
		return null;
	}
//取得回调函数
	function K_GetCallBack(obj,func)
	{
		return function(){return func.apply(obj,arguments)};
	}
//让点沿轨迹移动的类
	function K_PointMover(points,time,rate,handle)
	{
		this.points=points;
		this.time=time?time:100;
		this.rate=rate?rate:1;
		this.handle=handle;
		this.pointsIndex=0;
		this.numberIndex=0;
	}
	K_PointMover.prototype.Move=function()
	{
		if(!this.timer)
		{
			this.timer=setInterval(K_GetCallBack(this,this.Move),this.time);
			this.point=this.points[this.pointsIndex];
			if(this.handle)
				this.handle.call(null,this);
			return;
		}
		else
		{
			if(!this.offset)
			{
				offsetX=this.points[this.pointsIndex+1].x-this.points[this.pointsIndex].x;
				a=Math.log((1+Math.sin(this.points[this.pointsIndex].y*Math.PI/180))/(1-Math.sin(this.points[this.pointsIndex].y*Math.PI/180)))*180/Math.PI/2;
				a1=Math.log((1+Math.sin(this.points[this.pointsIndex+1].y*Math.PI/180))/(1-Math.sin(this.points[this.pointsIndex+1].y*Math.PI/180)))*180/Math.PI/2;
				offsetY=a1-a;//this.points[this.pointsIndex+1].y-this.points[this.pointsIndex].y;
				offset=Math.sqrt(Math.pow(offsetX,2)+Math.pow(offsetY,2));
				if(offset==0)
					this.offset=new GSize(0,0);
				else
					this.offset=new GSize(offsetX/offset,offsetY/offset);
			}
			x=this.points[this.pointsIndex].x+this.rate*this.offset.width*(this.numberIndex+1);
			y=Math.log((1+Math.sin(this.points[this.pointsIndex].y*Math.PI/180))/(1-Math.sin(this.points[this.pointsIndex].y*Math.PI/180)))*180/Math.PI/2+this.rate*this.offset.height*(this.numberIndex+1);
			y=(Math.asin((Math.pow(Math.E,y*Math.PI/180*2)-1)/(Math.pow(Math.E,y*Math.PI/180*2)+1))*180/Math.PI);
			if((x-this.points[this.pointsIndex].x)*(x-this.points[this.pointsIndex+1].x)<0 || (y-this.points[this.pointsIndex].y)*(y-this.points[this.pointsIndex+1].y)<0)
			{
				this.point=new GPoint(x,y);
				if(this.handle)
					this.handle.call(null,this);
				this.numberIndex++;
			}
			else
			{
				this.pointsIndex++;
				this.numberIndex=0;
				this.offset=null;
				this.point=this.points[this.pointsIndex];
				if(this.handle)
					this.handle.call(null,this);
				if(this.pointsIndex>=this.points.length-1)
				{
					clearInterval(this.timer);
					this.pointsIndex=0;
					this.numberIndex=0;
				}
			}
		}
	}
	K_PointMover.prototype.Pause=function()
	{
		if(this.timer)
		{
			clearInterval(this.timer);
			this.timer=null;
		}
	}
//这是调用用户所在地点的对象
	function K_UserPosition()
	{
		this.loaded=false;
	}
	K_UserPosition.prototype.Load=function(handle)
	{
		this.handle=handle;
		this.LoadByPacino();
		this.LoadByWiFi();
	}
	K_UserPosition.prototype.LoadByPacino=function()
	{
		var xmlLoader=new K_XmlLoader(K_GetCallBack(this,this.ParsePacinoFile));
		xmlLoader.Load("/GetRemoteFile.aspx?url=http%3A//www.pacino.roxr.com/map/%3Frs%3Dget_ip_info%26rsargs%5B%5D%3D{K_UserIp}");
	}
	K_UserPosition.prototype.ParsePacinoFile=function(xmlLoader)
	{
		try{
			eval(xmlLoader.responseText.substring(2));
			this.point=new GPoint(res[3],res[4]);
			this.zoom=10;
			this.message=res[0]+res[1];
			this.loaded=true;
			if(this.handle)
			{
				this.handle.apply(this);
				this.handle=null;
			}
		}
		catch(e){}
	}
	K_UserPosition.prototype.LoadByWiFi=function()
	{
		var wifi=this.GetWiFiControl();
		if(wifi)
		{
			try
			{
				var results = wifi.GetLocation();
				if(results&&results.length>0)
					{eval(results);return;}
			}
			catch(ex){}
		}
		window.SetAutoLocateViewport=K_GetCallBack(this,this.SetAutoLocateViewport);
		window.ShowMessage=K_GetCallBack(this,this.ShowMessage);
		K_LoadJS("http://virtualearth.msn.com/WiFiIPService/locate.ashx?pos=");
	}
	K_UserPosition.prototype.GetWiFiControl=function()
	{
		var wifi=null;
		try
		{
			wifi=new ActiveXObject("WiFiScanner");
		}
		catch(e)
		{
			try
			{
				wifi=new ActiveXObject("Microsoft.MapPoint.WiFiScanner.1");
			}
			catch(e)
			{
				try
				{
					wifi=new WiFiScanner("Microsoft.MapPoint.WiFiScanner.1");
				}
				catch(e)
				{}
			}
		}
		return wifi;
	}
	K_UserPosition.prototype.ShowMessage=function(message)
	{
	}
	K_UserPosition.prototype.SetAutoLocateViewport=function(lat,lon,zoom,pin,message)
	{
		if(this.loaded)
			return;
		this.point=new GPoint(lon,lat);
		this.zoom=zoom;
		this.pin=pin;
		this.message=message;
		this.loaded=true;
		if(this.handle)
		{
			this.handle.apply(this);
			this.handle=null;
		}
	}
//用来显示在地图上的图片组
	function K_ImagesOverlayGroup(tileSize,topLeftPoint,coordScale,zoomArray,scaleArray,opacity)
	{
		this.tileSize=tileSize;
		this.topLeftPoint=topLeftPoint;
		this.coordScale=coordScale;
		this.opacity=opacity?opacity:1;
		this.zoomArray=zoomArray?zoomArray:[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18];
		this.scaleArray=scaleArray?scaleArray:[0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18];
		this.images=[];
	}
	K_ImagesOverlayGroup.prototype.Bind=function(map)
	{
		this.Map=map;
		if(this.moveListener)
			GEvent.removeListener(this.moveListener);
		this.moveListener=GEvent.bind(map,"moveend",this,this.Load);
		this.Load();
	}
	K_ImagesOverlayGroup.prototype.unBind=function()
	{
		GEvent.removeListener(this.moveListener);
		this.moveListener=null;
		this.Clear();
	}
	K_ImagesOverlayGroup.prototype.getBitmapCoordinate=function(point)
	{
		var point_map=new GPoint();
		point_map.x=point.x;
		point_map.y=point.y;
		point_map.x=parseInt((point_map.x-this.topLeftPoint.x)*this.coordScale.width);
		point_map.y=parseInt((point_map.y-this.topLeftPoint.y)*this.coordScale.height);
		return point_map;
	}
	K_ImagesOverlayGroup.prototype.getLatlng=function(point)
	{
		var point_map=new GPoint();
		point_map.x=point.x/this.coordScale.width+this.topLeftPoint.x;
		point_map.y=point.y/this.coordScale.height+this.topLeftPoint.y;
		return point_map;
	}
	K_ImagesOverlayGroup.prototype.Load=function()
	{
		if(this.zoom!=this.Map.getZoomLevel())
		{
			this.Clear();
			this.zoom=this.Map.getZoomLevel();
		}
		if(this.zoom>=this.zoomArray.length)
			return;
		var ul = this.Map.spec.getLatLng(this.Map.topLeftTile.x*this.Map.spec.tileSize,(this.Map.topLeftTile.y+this.Map.tileImages.length)*this.Map.spec.tileSize,this.zoom);
		var lr = this.Map.spec.getLatLng((this.Map.topLeftTile.x+this.Map.tileImages.length)*this.Map.spec.tileSize,this.Map.topLeftTile.y*this.Map.spec.tileSize,this.zoom);
		ul_map=this.getBitmapCoordinate(ul);
		lr_map=this.getBitmapCoordinate(lr);
		startX=parseInt(ul_map.x/(this.tileSize*Math.pow(2,this.scaleArray[this.zoomArray[this.zoom]])));
		startY=parseInt(ul_map.y/(this.tileSize*Math.pow(2,this.scaleArray[this.zoomArray[this.zoom]])));
		endX=parseInt(lr_map.x/(this.tileSize*Math.pow(2,this.scaleArray[this.zoomArray[this.zoom]])))+1;
		endY=parseInt(lr_map.y/(this.tileSize*Math.pow(2,this.scaleArray[this.zoomArray[this.zoom]])))+1;
		this.Clear(startX,startY,endX,endY);
		for(var i=startX;endX>i;i++)
		{
			for(var j=startY;endY>j;j++)
			{
				loaded=false;
				for(var k=0;this.images.length>k;k++)
					if(this.images[k].coordX==i && this.images[k].coordY==j)
					{
						loaded=true;
						break;
					}
				if(loaded)
					continue;
				var tileUl=this.getLatlng(new GPoint(i*this.tileSize*Math.pow(2,this.scaleArray[this.zoomArray[this.zoom]]),j*this.tileSize*Math.pow(2,this.scaleArray[this.zoomArray[this.zoom]])));
				var tileLr=this.getLatlng(new GPoint((i+1)*this.tileSize*Math.pow(2,this.scaleArray[this.zoomArray[this.zoom]]),(j+1)*this.tileSize*Math.pow(2,this.scaleArray[this.zoomArray[this.zoom]])));
				var bounds=new GBounds(tileUl.x,tileUl.y,tileLr.x,tileLr.y);
				var imageOverlay=new K_ImageOverlay(this.GetUrl(i,j,this.zoomArray[this.zoom]),bounds,0,this.opacity);
				this.Map.addOverlay(imageOverlay);
				imageOverlay.display(true);
				imageOverlay.coordX=i;
				imageOverlay.coordY=j;
				this.images.push(imageOverlay);
			}
		}
	}
	K_ImagesOverlayGroup.prototype.Clear=function(startX,startY,endX,endY)
	{
		for(var i=0;this.images.length>i;i++)
		{
			if(this.images[i].coordX>=startX && endX>=this.images[i].coordX && this.images[i].coordY>=startY && endY>=this.images[i].coordY)
				continue;
			this.Map.removeOverlay(this.images[i]);
			this.images.splice(i,1);
			i--;
		}
	}
	K_ImagesOverlayGroup.prototype.GetUrl=function(x,y,zoom)
	{
		return "http://img.51ditu.com/mapintime/rasterservlet?bx="+x+"&by="+y+"&level="+zoom+"";
	}
	K_ImagesOverlayGroup.prototype.setOpacity=function(opacity)
	{
		this.opacity=opacity;
		for(var i=0;this.images.length>i;i++)
			this.images[i].setOpacity(this.opacity);
	}
//这个是使用灵图API的地图类型对象
	function K_MOSPSpec(serviceUrl,name,userId,password,encryptPointSrv,format)
	{
		this.serviceUrl = serviceUrl;
		this.tileSize=256;
		this.backgroundColor="#e5e3df";
		this.emptyTileURL="http://www.google.com/mapfiles/transparent.gif";
		this.waterTileUrl="http://www.google.com/intl/en_ALL/mapfiles//water.gif";
		this.tileURLAdding="#MOSP";
		this.numZoomLevels=18;
		this.userId=userId;
		this.password=password;
		this.Name = name;
		this.ShortName="MOSP";
		this.encryptPointSrv=encryptPointSrv;
		this.Format = format;
		this.copywrite = "Step1.cn";
		this.errorTileMessage="We are sorry, but we don\'t have maps at this zoom level for this region.<p>Try zooming out for a broader look.</p>";
		this.errorTileMargin=5;
		this.initMercator();
	}
	K_MOSPSpec.prototype.getTileURL=function(a,b,c)
	{
		var cokUrl=K_GetCookie("MOSPImg_"+a+"_"+b+"_"+c);
		if(cokUrl!=null && cokUrl!="")
			return cokUrl;
		(new K_GetMOSPUrl(this,a,b,c)).getUrl();
		return this.emptyTileURL+this.tileURLAdding+'_'+a+'_'+b+'_'+c;
	}
	K_MOSPSpec.prototype.getLinkText=function(){return this.Name;}
	K_MOSPSpec.prototype.getShortLinkText=function(){return this.ShortName;}
	K_MOSPSpec.prototype.hasOverlay=function(){return false;}
	K_MOSPSpec.prototype.getCopyright=function(){return this.copywrite;}
	K_MOSPSpec.prototype.initMercator=_GoogleMapMercSpec.prototype.initMercator;
	K_MOSPSpec.prototype.adjustBitmapX=_GoogleMapMercSpec.prototype.adjustBitmapX;
	K_MOSPSpec.prototype.getBitmapCoordinate=_GoogleMapMercSpec.prototype.getBitmapCoordinate;
	K_MOSPSpec.prototype.getLatLng=_GoogleMapMercSpec.prototype.getLatLng;
	K_MOSPSpec.prototype.getOverlayURL=_GoogleMapMercSpec.prototype.getOverlayURL;
	K_MOSPSpec.prototype.getURLArg=_GoogleMapMercSpec.prototype.getURLArg;
	K_MOSPSpec.prototype.getLowestZoomLevel=_GoogleMapMercSpec.prototype.getLowestZoomLevel;
	K_MOSPSpec.prototype.getPixelsPerDegree=_GoogleMapMercSpec.prototype.getPixelsPerDegree;
	K_MOSPSpec.prototype.zoomBitmapCoord=_GoogleMapMercSpec.prototype.zoomBitmapCoord;
//这是灵图API之中对小块地图进行获取的对象
	function K_GetMOSPUrl(baseObj,a,b,zoom)
	{
		this.baseObj=baseObj;
		this.a=a;
		this.b=b;
		this.zoom=zoom;
		this.url=baseObj.emptyTileURL;
	}
	K_GetMOSPUrl.prototype.getUrl=function()
	{
		var minPoint = this.baseObj.getLatLng(this.a*this.baseObj.tileSize,(this.b+1)*this.baseObj.tileSize,this.zoom);
		var maxPoint = this.baseObj.getLatLng((this.a+1)*this.baseObj.tileSize, this.b*this.baseObj.tileSize,this.zoom);
		this.baseObj.encryptPointSrv.EncryptPoint([minPoint,maxPoint],K_GetCallBack(this,this.getUrlByLTPoint));
	};
	K_GetMOSPUrl.prototype.getUrlByLTPoint=function(points)
	{
		var data;
		width = this.baseObj.tileSize;
		height = this.baseObj.tileSize;
		height=parseInt(height*Math.abs(Math.cos((points[1].y+points[0].y)/36000000*Math.PI)));
		data = '<?xml version="1.0" encoding="utf-8"?>'; 
		data = data + '<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">'; 
		data = data + '<soap:Body>'; 
		data = data + '<getMap xmlns="http://tempuri.org/">'; 
		data = data + '<reqSpec>';
		data = data + 	'<mapViewWidth>'+width+'</mapViewWidth><mapVeiwHeight>'+height+'</mapVeiwHeight><boundMode>1</boundMode><boxBoundMode>';
		data = data + 	  '<minPoint><latitude>'+points[0].y+'</latitude><longitude>'+points[0].x+'</longitude></minPoint>';
		data = data + 	  '<maxPoint><latitude>'+points[1].y+'</latitude><longitude>'+points[1].x+'</longitude></maxPoint>';
		data = data + 	'</boxBoundMode>';
		data = data + '</reqSpec>'; 
		format=1;
		if(this.baseObj.Format!=null && (this.baseObj.Format.toLowerCase().indexOf("jpg")>=0 || this.baseObj.Format.toLowerCase().indexOf("jpeg")>=0))
			format=2;
		else if(this.baseObj.Format!=null && (this.baseObj.Format.toLowerCase().indexOf("bmp")>=0))
			format=3;
		data = data + '<optSpec><mapFormat>'+format+'</mapFormat></optSpec>'; 
		data = data + '<authToken><applicationID>'+this.baseObj.userId+'</applicationID><password>'+this.baseObj.password+'</password></authToken>'; 
		data = data + '</getMap>'; 
		data = data + '</soap:Body>'; 
		data = data + '</soap:Envelope>';

		var xmlLoader=new K_XmlLoader(K_GetCallBack(this,this.setUrlFromXml));
		xmlLoader.Load(this.baseObj.serviceUrl,data);
	}
	K_GetMOSPUrl.prototype.setUrlFromXml=function(xmlLoader)
	{
		if(!xmlLoader.xmlDoc.selectSingleNode("//url"))
			return;
		var url=xmlLoader.xmlDoc.selectSingleNode("//url").text;
		var imageList=document.getElementsByTagName("img");
		var imageListLength=imageList.length;
		for(var i=0;i<imageListLength;i++)
			if(imageList[i].src==this.baseObj.emptyTileURL+this.baseObj.tileURLAdding+'_'+this.a+'_'+this.b+'_'+this.zoom)
			{
				imageList[i].src=url;
				break;
			}
		K_SetCookie("MOSPImg_"+this.a+"_"+this.b+"_"+this.zoom,url);
	}
//显示地图中心十字的对象
	function K_CrossControl(length,size,color,image)
	{
		this.length=length|10;
		this.size=size|2;
		this.color="#000000";
		if(color)
			this.color=color;
		this.image="http://www.step1.cn/map/cross.gif";
		if(image)
			this.image=image;
	}
	K_CrossControl.prototype.initialize=function(a)
	{
		this.Map=a;
		this.lines=[];
		if(browser.type==1)
		{
			this.div=a.ownerDocument.createElement("<v:group coordSize='21600,21600' style='z-index:4;width:"+(2*this.length)+"px;height:"+(2*this.length)+"px;'></v:group>");
			var d=this.Map.ownerDocument.createElement("<v:line from='"+(10800)+","+(0)+"' to='"+10800+","+21600+"' style='z-index:5;'>");
			this.lines.push(d);
			this.div.appendChild(d)
			var d=this.Map.ownerDocument.createElement("<v:line from='"+(0)+","+(10800)+"' to='"+21600+","+10800+"' style='z-index:5;'>");
			this.lines.push(d);
			this.div.appendChild(d)
		}
		else
		{
			this.div=a.ownerDocument.createElement("div");
			var img=a.ownerDocument.createElement("img");
			img.src=this.image;
			img.width=this.length*2;
			img.height=this.length*2;
			this.div.appendChild(img);
			this.div.style.width=this.length*2+"px";
			this.div.style.height=this.length*2+"px";
			this.div.style.zIndex=4;
		}
		a.container.appendChild(this.div);
		this.defaultPosition=new K_ControlPosition();
		this.setDefaultPosition();
		GEvent.bind(a,"resize",this,this.setDefaultPosition);
		return this.div;
	};
	K_CrossControl.prototype.setDefaultPosition=function()
	{
		this.defaultPosition.setPosition(this.Map.container.offsetWidth/2-this.length,this.Map.container.offsetHeight/2-this.length);
		this.defaultPosition.apply(this.div);
	}
	K_CrossControl.prototype.getDefaultPosition=function()
	{
		return this.defaultPosition;
	};
	function K_ControlPosition()
	{
	}
	K_ControlPosition.prototype.setPosition=function(b,c)
	{
		this.x=b||0;
		this.y=c||0;
	}
	K_ControlPosition.prototype.apply=function(a)
	{
		a.style.position="absolute";
		a.style.left=this.x+"px";
		a.style.top=this.y+"px";
	};
//在地图上显示HTML内容的对象
	function K_MiniMapControl(size,position,point,zoom,zoomAdd)
	{
		if(size)
			this.size=size;
		else
			this.size=new GSize(240,150);
		if(position)
			this.position=position;
		else
			this.position=new GControlPosition(3,10,10);
		this.point=point;
		this.zoom=zoom;
		this.zoomAdd=zoomAdd?zoomAdd:4;
		this.minimapRect=null;
	}
	K_MiniMapControl.prototype.initialize=function(a)
	{
		this.Map=a;
		this.div=a.ownerDocument.createElement("div");
		a.applyControlStyles(this.div);
		this.div.style.position="absolute";
		this.div.style.width=this.size.width+"px";
		this.div.style.height=this.size.height+"px";
		this.div.style.border="solid 1 #FFFFFF";
		a.container.appendChild(this.div);
		this.miniMap=new GMap(this.div,null,null,null,true);
		this.miniMap.disableDragging();
		GEvent.bind(this.miniMap,"click",this,this.onClick);
		GEvent.bind(this.Map,"moveend",this,this.onMapMoved);
		GEvent.bind(this.Map,"maptypechanged",this,this.onMapTypeChanged);
		this.onMapMoved();
		return this.div;
	};
	K_MiniMapControl.prototype.getDefaultPosition=function()
	{
		return this.position;
	};
	K_MiniMapControl.prototype.onMapTypeChanged=function()
	{
		this.miniMap.setMapType(this.Map.getCurrentMapType());
	}
	K_MiniMapControl.prototype.getMapRect=function()
	{
		if(this.minimapRect)
			this.miniMap.removeOverlay(this.minimapRect);
		bounds=this.Map.getBoundsLatLng();
		var points=[];
		points.push(new GPoint(bounds.minX,bounds.minY));
		points.push(new GPoint(bounds.minX,bounds.maxY));
		points.push(new GPoint(bounds.maxX,bounds.maxY));
		points.push(new GPoint(bounds.maxX,bounds.minY));
		points.push(new GPoint(bounds.minX,bounds.minY));
		this.minimapRect=new GPolyline(points,"red",1);
		this.miniMap.addOverlay(this.minimapRect);
	}
	K_MiniMapControl.prototype.InitMap=function()
	{
		this.onMapTypeChanged();
		point=this.point?this.point:this.Map.getCenterLatLng();
		zoom=this.zoom?this.zoom:this.Map.getZoomLevel()+this.zoomAdd;
		if(zoom<0)zoom=0;
		if(zoom>17)zoom=17;
		this.miniMap.centerAndZoom(point,zoom);
		this.getMapRect();
		return;
	}
	K_MiniMapControl.prototype.onMapMoved=function()
	{
		if(!this.Map.isLoaded())
			return;
		if(!this.miniMap.isLoaded())
			this.InitMap();
		this.getMapRect();
		if(!this.point)
			this.miniMap.recenterOrPanToLatLng(this.Map.getCenterLatLng());
		zoom=this.zoom?this.zoom:this.Map.getZoomLevel()+this.zoomAdd;
		if(zoom<0)zoom=0;
		if(zoom>17)zoom=17;
		if(zoom!=this.miniMap.getZoomLevel())
			this.miniMap.zoomTo(zoom);
	}
	K_MiniMapControl.prototype.onClick=function(overlay,point)
	{
		this.Map.recenterOrPanToLatLng(point);
		GEvent.trigger(this,"click");
	}
//在地图上显示HTML内容的对象
	function K_HtmlControl(html,position)
	{
		this.html=html;
		if(position)
			this.position=position;
		else
			this.position=new GControlPosition(3,10,10);
	}
	K_HtmlControl.prototype.initialize=function(a)
	{
		this.Map=a;
		this.div=a.ownerDocument.createElement("div");
		a.applyControlStyles(this.div);
		this.div.style.position="absolute";
		this.div.innerHTML=this.html;
		a.container.appendChild(this.div);
		GEvent.addBuiltInListener(this.div,"click",K_GetCallBack(this,this.onClick));
		return this.div;
	};
	K_HtmlControl.prototype.getDefaultPosition=function()
	{
		return this.position;
	};
	K_HtmlControl.prototype.onClick=function()
	{
		GEvent.trigger(this,"click");
	}
//在地图上显示一个小图标的对象
	function K_IconOverlay(imageUrl,point,scale,bounds,color)
	{
		this.imageUrl=imageUrl;
		this.point=point;
		this.scale=scale?scale:1;
		this.bounds=bounds;
		this.color=color;
		this.icon=new Object();
		this.icon.iconSize=new GSize(this.scale*32,this.scale*32);
	}
	K_IconOverlay.prototype.initialize=function(a)
	{
		this.map=a;
		this.div=a.ownerDocument.createElement("img");
		this.div.src=this.imageUrl;
		this.div.style.display='none';
		this.div.style.position="absolute";
		a.markerPane.appendChild(this.div);
		this.div.onload=K_GetCallBack(this,this.setClip);
		if(browser.type==1)
		{
			this.div.unselectable="on";
			this.div.onselectstart=function(){return false};
			this.div.galleryImg="no"
		}
		else
		{
			this.div.style.MozUserSelect="none";
		}
		this.div.style.border="0";
		this.div.style.padding="0";
		this.div.style.margin="0";
		color=(this.color)?this.color:"FFFFFF";
		this.div.style.filter="progid:DXImageTransform.Microsoft.Chroma(color='#"+color+"')";
		this.div.style.cursor="pointer";
		this.div.oncontextmenu=function(){return false};
		GEvent.bindDom(this.div,"mousedown",this,this.onMouseDown);
	};
	K_IconOverlay.prototype.setClip=function()
	{
		this.div.style.display='';
		this.currentSize=new GSize(this.div.offsetWidth,this.div.offsetHeight);
		if(this.bounds)
		{
			this.div.style.clip="rect("+((this.currentSize.height-this.bounds.maxY)*this.scale)+"px "+(this.bounds.maxX*this.scale)+"px "+((this.currentSize.height-this.bounds.minY)*this.scale)+"px "+(this.bounds.minX*this.scale)+"px)";
			this.icon.iconSize=new GSize(this.scale*(this.bounds.maxX-this.bounds.minX),this.scale*(this.bounds.maxY-this.bounds.minY));
		}
		else
			this.icon.iconSize=new GSize(this.scale*this.currentSize.width,this.scale*this.currentSize.height);
		this.div.width=(this.currentSize.width*this.scale);
		this.div.height=(this.currentSize.height*this.scale);
		this.div.style.display='';
		this.redraw(true);
	}
	K_IconOverlay.prototype.redraw=function(a)
	{
		if(!a)return;
		if(!this.currentSize)return;
		var b=this.map.spec.getBitmapCoordinate(this.point.y,this.point.x,this.map.zoomLevel);
		var c=this.map.getDivCoordinate(b.x,b.y);
		if(this.bounds)
		{
			this.div.style.left=(c.x-(this.bounds.maxX+this.bounds.minX)/2*this.scale)+"px";
			this.div.style.top=(c.y-(this.currentSize.height*2-this.bounds.maxY-this.bounds.minY)/2*this.scale)+"px";
		}
		else
		{
			this.div.style.left=(c.x-this.currentSize.width*this.scale/2)+"px";
			this.div.style.top=(c.y-this.currentSize.height*this.scale/2)+"px";
		}
	};
	K_IconOverlay.prototype.onMouseDown=function(a)
	{
		if(browser.type==1)
		{
			window.event.cancelBubble=true;
			window.event.returnValue=false
		}
		else
		{
			a.cancelBubble=true;
			a.preventDefault();
			a.stopPropagation()
		}
		GEvent.trigger(this,"click",this);
		GEvent.trigger(this.map,"click",this)
	};
	K_IconOverlay.prototype.copy=function(){return new K_IconOverlay(this.imageUrl,this.point,this.scale,this.bounds)};
	K_IconOverlay.prototype.remove=function(){if(this.div&&this.div.parentNode){this.div.parentNode.removeChild(this.div)}};
	K_IconOverlay.prototype.display=function(a){if(a)this.div.style.display="";else this.div.style.display="none";};
	K_IconOverlay.prototype.setZIndex=function(a){this.div.style.zIndex=a;};
	K_IconOverlay.prototype.getLatitude=window.GMarker.prototype.getLatitude;
	K_IconOverlay.prototype.openInfoWindow=function(a,b){this.map.openInfoWindow(this.point,a,new GSize(0,0),GEvent.callback(this,this.onInfoWindowOpen),GEvent.callback(this,this.onInfoWindowClose),b)};
	K_IconOverlay.prototype.openInfoWindowHtml=function(a,b){this.map.openInfoWindowHtml(this.point,a,new GSize(0,0),GEvent.callback(this,this.onInfoWindowOpen),GEvent.callback(this,this.onInfoWindowClose),b)};
	K_IconOverlay.prototype.openInfoWindowXslt=function(a,b,c){this.map.openInfoWindowXslt(this.point,a,b,new GSize(0,0),GEvent.callback(this,this.onInfoWindowOpen),GEvent.callback(this,this.onInfoWindowClose),c)};
	K_IconOverlay.prototype.showMapBlowup=function(a,b){this.map.showMapBlowup(this.point,a,b,new GSize(0,0),GEvent.callback(this,this.onInfoWindowOpen),GEvent.callback(this,this.onInfoWindowClose))};
	K_IconOverlay.prototype.onInfoWindowOpen=window.GMarker.prototype.onInfoWindowOpen;
	K_IconOverlay.prototype.onInfoWindowClose=window.GMarker.prototype.onInfoWindowClose;
//自定义的HTML marker对象，以指定点显示HTML内容
	function K_HtmlMarker(icon,point,html)
	{
		this.icon=icon;
		this.point=point;
		this.icon.point=point;
		this.html=html;
	}
	K_HtmlMarker.prototype.initialize=function(a)
	{
		this.map=a;
		this.icon.initialize(a);
		GEvent.bindDom(this.icon,"mousedown",this,this.onMouseDown);
		this.div=a.ownerDocument.createElement("span");
		this.div.align="left";
		this.div.style.position="absolute";
		this.div.style.cursor="default";
		this.div.style.width="200px";
		this.div.innerHTML=this.html;
		a.markerPane.appendChild(this.div);
		GEvent.bind(this.icon,"click",this,this.onMouseDown);
	};
	K_HtmlMarker.prototype.remove=function(){this.icon.remove();if(this.div&&this.div.parentNode){this.div.parentNode.removeChild(this.div)}};
	K_HtmlMarker.prototype.copy=function()
	{
		return new K_HtmlMarker(this.icon.copy(),this.point,this.html)
	};
	K_HtmlMarker.prototype.redraw=function(a)
	{
		this.icon.redraw(a);
		if(!a)return;
		var b=this.map.spec.getBitmapCoordinate(this.point.y,this.point.x,this.map.zoomLevel);
		var c=this.map.getDivCoordinate(b.x,b.y);
		var d=c.x;
		var e=c.y;
		iconSize=this.icon.icon.iconSize?this.icon.icon.iconSize:new GSize(32,32);
		this.div.style.left=(d+iconSize.width/2)+"px";
		this.div.style.top=(e-this.div.offsetHeight/2)+"px";
	};
	K_HtmlMarker.prototype.onMouseDown=function(a)
	{
		if(browser.type==1)
		{
			window.event.cancelBubble=true;
			window.event.returnValue=false
		}
		else
		{
			a.cancelBubble=true;
			a.preventDefault();
			a.stopPropagation()
		}
		GEvent.trigger(this,"click",this);
		GEvent.trigger(this.map,"click",this)
	};
	K_HtmlMarker.prototype.display=function(a){this.icon.display(a);if(a)this.div.style.display="";else this.div.style.display="none";};
	K_HtmlMarker.prototype.getOffsetTop=function(){return this.div.offsetTop};
	K_HtmlMarker.prototype.setZIndex=function(a){this.div.style.zIndex=a;};
	K_HtmlMarker.prototype.addToInfoWindowMask=function(a,b){return;};
	K_HtmlMarker.prototype.getLatitude=window.GMarker.prototype.getLatitude;
	K_HtmlMarker.prototype.openInfoWindow=function(a,b){this.map.openInfoWindow(this.point,a,new GSize(0,0),GEvent.callback(this,this.onInfoWindowOpen),GEvent.callback(this,this.onInfoWindowClose),b)};
	K_HtmlMarker.prototype.openInfoWindowHtml=function(a,b){this.map.openInfoWindowHtml(this.point,a,new GSize(0,0),GEvent.callback(this,this.onInfoWindowOpen),GEvent.callback(this,this.onInfoWindowClose),b)};
	K_HtmlMarker.prototype.openInfoWindowXslt=function(a,b,c){this.map.openInfoWindowXslt(this.point,a,b,new GSize(0,0),GEvent.callback(this,this.onInfoWindowOpen),GEvent.callback(this,this.onInfoWindowClose),c)};
	K_HtmlMarker.prototype.showMapBlowup=function(a,b){this.map.showMapBlowup(this.point,a,b,new GSize(0,0),GEvent.callback(this,this.onInfoWindowOpen),GEvent.callback(this,this.onInfoWindowClose))};
	K_HtmlMarker.prototype.onInfoWindowOpen=window.GMarker.prototype.onInfoWindowOpen;
	K_HtmlMarker.prototype.onInfoWindowClose=window.GMarker.prototype.onInfoWindowClose;
//进行灵图数据格式转换的对象
	function K_MSOPEncryptPointSrv(baseUrl,userId,password)
	{
		this.baseUrl=baseUrl;
		this.userId=userId;
		this.password=password;
	}
	K_MSOPEncryptPointSrv.prototype.EncryptPoint=function(points,handle)
	{
		(new K_MSOPEncryptPointSrvConnection(this,points,handle));
	}
	function K_MSOPEncryptPointSrvConnection(service,points,handle)
	{
		this.service=service;
		this.handle=handle;
		var data;
		data = '<?xml version="1.0" encoding="utf-8"?>'; 
		data = data + '<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">'; 
		data = data + '<soap:Body>'; 
		data = data + '<EncryptPointArray xmlns="http://tempuri.org/">'; 
		for(var i=0;i<points.length;i++)
		{
			data = data + '<in><latitude>'+parseInt(points[i].y*100000)+'</latitude><longitude>'+parseInt(points[i].x*100000)+'</longitude></in>';
		}
		data = data + '</EncryptPointArray>'; 
		data = data + '</soap:Body>'; 
		data = data + '</soap:Envelope>';
		var xmlLoader=new K_XmlLoader(K_GetCallBack(this,this.EncryptPointCallBack));
		xmlLoader.Load(this.service.baseUrl,data);
	}
	K_MSOPEncryptPointSrvConnection.prototype.EncryptPointCallBack=function(xmlLoader)
	{
		var pointsNode=xmlLoader.xmlDoc.getElementsByTagName("Point");
		points=[];
		for(var i=0;i<pointsNode.length;i++)
		{
			points[i]=new GPoint(parseInt(pointsNode[i].getElementsByTagName("longitude")[0].childNodes[0].nodeValue),parseInt(pointsNode[i].getElementsByTagName("latitude")[0].childNodes[0].nodeValue));
			if(points[i].x==0)points[i].x=1;
			if(points[i].y==0)points[i].y=1;
		}
		if(this.handle)
			this.handle.apply(this,[points]);
	}
//载入灵图的地理编码信息对象
	function K_MSOPGeoCodeSrv(baseUrl,userId,password,encryptPointSrv,handle)
	{
		this.baseUrl=baseUrl;
		this.userId=userId;
		this.password=password;
		this.handle=handle;
		this.encryptPointSrv=encryptPointSrv;
		this.status=0;
	}
	K_MSOPGeoCodeSrv.prototype.GetGeoCode=function(point)
	{
		if(73.12667>point.x || point.x>135.21180 || 18.12810>point.y || point.y>55.15600)
		{
			this.status=-1;
			this.handle.apply(this);
			return;
		}
		this.status=1;
		this.point=point;
		this.encryptPointSrv.EncryptPoint([this.point],K_GetCallBack(this,this.GetGeoCodeByLTPoint));
	}
	K_MSOPGeoCodeSrv.prototype.GetGeoCodeByLTPoint=function(points)
	{
		var data;
		data = '<?xml version="1.0" encoding="utf-8"?>'; 
		data = data + '<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">'; 
		data = data + '<soap:Body>'; 
		data = data + '<getAddrByPosition xmlns="http://tempuri.org/">'; 
		data = data + '<p><latitude>'+points[0].y+'</latitude><longitude>'+points[0].x+'</longitude></p>';
		data = data + '<authToken><applicationID>'+this.userId+'</applicationID><password>'+this.password+'</password></authToken>'; 
		data = data + '</getAddrByPosition>'; 
		data = data + '</soap:Body>'; 
		data = data + '</soap:Envelope>';
		var xmlLoader=new K_XmlLoader(K_GetCallBack(this,this.GeoCodeSrvCallBack));
		xmlLoader.Load(this.baseUrl,data);
	};
	K_MSOPGeoCodeSrv.prototype.GeoCodeSrvCallBack=function(xmlLoader)
	{
		this.status=-2;
		if(xmlLoader && xmlLoader.xmlDoc && xmlLoader.xmlDoc.getElementsByTagName("address").length>0 && xmlLoader.xmlDoc.getElementsByTagName("address")[0].text!="")
		{
			this.result=xmlLoader.xmlDoc.getElementsByTagName("address")[0].childNodes[0].nodeValue;
			this.status=2;
		}
		if(this.handle)
			this.handle.call(null,this);
	}
//简单的XML文件读取对象
	function K_XmlLoader(parseHandle)
	{
		this.parseHandle=parseHandle;
		this.xmlhttp =null;
	}
	K_XmlLoader.prototype.Load=function(url,postData)
	{
		this.url=url;
		this.xmlhttp =GXmlHttp.create();
		var method="GET";
		if(postData && postData.length>0)
			method="POST";
		this.xmlhttp.open(method,this.url,true);
		this.xmlhttp.onreadystatechange=K_GetCallBack(this,this.ParseXmlFile);
		if(postData && postData.length>0)
		{
			this.xmlhttp.setRequestHeader ("Content-Type","text/xml; charset=utf-8"); 
			this.xmlhttp.setRequestHeader ("SOAPAction","\"\""); 
		}
		this.xmlhttp.send(postData);
	}
	K_XmlLoader.prototype.ParseXmlFile=function()
	{
		if(this.xmlhttp==null || this.xmlhttp.readyState!=4)
			return;
		this.xmlDoc = this.xmlhttp.responseXML;
		if(this.xmlDoc.documentElement==null && this.xmlhttp.responseText &&　this.xmlhttp.responseText!="")
		{
			try{this.xmlDoc=GXml.parse(this.xmlhttp.responseText);}
			catch(ce){}
		}
		if(this.xmlDoc.documentElement==null)
			this.responseText=this.xmlhttp.responseText;
		this.xmlhttp=null;
		if(this.parseHandle)
			this.parseHandle.call(null,this);
	}
//用来在地图上显示一张图片的控件
	function K_ImageOverlay(imageUrl,bounds,rotation,opacity)
	{
		this.imageUrl=imageUrl;
		this.bounds=bounds;
		this.rotation=-rotation;
		this.opacity=opacity||0.45;
	}
	K_ImageOverlay.prototype.initialize=function(a)
	{
		this.map=a;
		if(this.rotation>5 || this.rotation<-5)
		{
			this.drawElement=a.ownerDocument.createElement("v:Image");
			this.drawElement.style.rotation=this.rotation;
		}
		else
			this.drawElement=a.ownerDocument.createElement("img");
		this.drawElement.title=this.imageUrl;
		this.drawElement.style.position="absolute";
		this.drawElement.style.filter="progid:DXImageTransform.Microsoft.Alpha(opacity="+(this.opacity*100)+");";
		this.drawElement.style.display="none";
		this.drawElement.src=this.imageUrl;
		if(browser.type==1)
		{
			this.drawElement.unselectable="on";
			this.drawElement.onselectstart=function(){return false};
			this.drawElement.galleryImg="no"
		}
		else
		{
			this.drawElement.style.MozUserSelect="none"
		}
		this.drawElement.style.border="0";
		this.drawElement.style.padding="0";
		this.drawElement.style.margin="0";
		this.drawElement.oncontextmenu=function(){return false};
		a.markerPane.appendChild(this.drawElement);
	};
	K_ImageOverlay.prototype.redraw=function(a)
	{
		if(!a)return;
		var b=this.map.spec.getBitmapCoordinate(this.bounds.minY,this.bounds.minX,this.map.zoomLevel);
		var min=this.map.getDivCoordinate(b.x,b.y);
		b=this.map.spec.getBitmapCoordinate(this.bounds.maxY,this.bounds.maxX,this.map.zoomLevel);
		var max=this.map.getDivCoordinate(b.x,b.y);
		this.drawElement.style.left=(min.x)+"px";
		this.drawElement.style.top=(max.y)+"px";
		this.drawElement.style.width=(max.x-min.x)+"px";
		this.drawElement.style.height=(min.y-max.y)+"px";
	};
	K_ImageOverlay.prototype.setOpacity=function(opacity)
	{
		this.opacity=opacity||0.45;
		this.drawElement.style.filter="progid:DXImageTransform.Microsoft.Alpha(opacity="+(this.opacity*100)+");";
	}
	K_ImageOverlay.prototype.copy=function(){return new K_ImageOverlay(this.imageUrl,this.bounds,this.rotation,this.opacity)};
	K_ImageOverlay.prototype.remove=window.GPolyline.prototype.remove;
	K_ImageOverlay.prototype.display=window.GPolyline.prototype.display;
	K_ImageOverlay.prototype.setZIndex=window.GPolyline.prototype.setZIndex;
	K_ImageOverlay.prototype.getLatitude=function(){return 180};


	window.K_LoadJS=K_LoadJS;
	window.K_GetQueryString=K_GetQueryString;
	window.K_GetCallBack=K_GetCallBack;
	window.K_PointMover=K_PointMover;
	window.K_MSOPEncryptPointSrv=K_MSOPEncryptPointSrv;
	window.K_MSOPGeoCodeSrv=K_MSOPGeoCodeSrv;
	window.K_MOSPSpec=K_MOSPSpec;
	window.K_CrossControl=K_CrossControl;
	window.K_MiniMapControl=K_MiniMapControl;
	window.K_HtmlControl=K_HtmlControl;
	window.K_IconOverlay=K_IconOverlay;
	window.K_ImageOverlay=K_ImageOverlay;
	window.K_HtmlMarker=K_HtmlMarker;
	window.K_XmlLoader=K_XmlLoader;
	window.K_UserPosition=K_UserPosition;
	window.K_ImagesOverlayGroup=K_ImagesOverlayGroup;
}
K_ReverterMap();