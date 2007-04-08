//K_ReverterKmlTree 0.1
function K_ReverterKmlTree()
{
//Kml的样式对象
	function K_KmlStyle(){}
	K_KmlStyle.prototype.copy=function()
	{
		var kmlStyle=new K_KmlStyle();
		for(var key in this)
		{
			if(typeof(this[key])=="function")
				continue;
			if(this[key].isKmlStyle)
				kmlStyle[key]=this[key].copy();
			else
				kmlStyle[key]=this[key];
		}
		return kmlStyle;
	}
	K_KmlStyle.prototype.isKmlStyle=function(){return true;}
//将标注显示在K_Tree之中的对象
	function K_OverlayTree(map,treeNode,handle)
	{
		this.Map=map;
		this.treeNode=treeNode;
		if(this.treeNode)
			this.treeNodes=[];
		this.overlays=[];
		this.styles=[];
		this.handle=handle;
		this.defaultStyle=new K_KmlStyle();
		this.defaultStyle.IconStyle=new K_KmlStyle();
		this.defaultStyle.IconStyle.Icon=new K_KmlStyle();
		this.defaultStyle.IconStyle.Icon.href="K_Tree/palette-3.png";
		this.defaultStyle.IconStyle.Icon.bounds=new GBounds(224,0,256,32);
		this.defaultStyle.LabelStyle=new K_KmlStyle();
		this.defaultStyle.LabelStyle.color="FFFFFFFF";
	}
	K_OverlayTree.prototype.ParseKml=function(xmlLoader)
	{
		this.ParseKmlNode(xmlLoader.xmlDoc.documentElement,this.defaultStyle,this.treeNode);
		if(this.handle)
			this.handle.call();
	}
	K_OverlayTree.prototype.ParseKmlNode=function(kmlNode,kmlStyle,parentNode)
	{
		switch(kmlNode.nodeName)
		{
			case "kml":
			case "Document":
			case "Folder":
				this.ParseKmlFolder(kmlNode,kmlStyle,parentNode);
				break;
			case "Placemark":
				this.ParseKmlPlace(kmlNode,kmlStyle,parentNode);
				break;
			case "GroundOverlay":
				this.ParseKmlImage(kmlNode,kmlStyle,parentNode);
				break;
			case "Style":
				this.ParseKmlStyle(kmlNode,kmlStyle,parentNode);
		}
	}
	K_OverlayTree.prototype.ParseKmlPlace=function(placeMark,kmlStyle,parentNode)
	{
		var style=this.GetCurrentStyle(placeMark,kmlStyle);
		if(placeMark.selectSingleNode("Point"))
		{
			name="未命名地点";
			
			if(placeMark.selectSingleNode("name")!=null)
				name=placeMark.selectSingleNode("name").text;
			p=placeMark.selectSingleNode("Point").text.split(",");
			if(p.length<2)
				return;
			point=new GLatLng(parseFloat(p[1]),parseFloat(p[0]));
			size=(style.IconStyle.scale && style.IconStyle.scale>0)?style.IconStyle.scale:1;
			var icon=new K_IconOverlay(style.IconStyle.Icon.href,null,size,style.IconStyle.Icon.bounds);
			var color=(style && style.LabelStyle && style.LabelStyle.color && style.LabelStyle.color.length==8)?"#"+style.LabelStyle.color.substr(2):"#FFFFFF";
			fontSize=16;
			if(style && style.LabelStyle && style.LabelStyle.scale)
				fontSize=style.LabelStyle.scale*fontSize;
			var marker=new K_HtmlMarker(icon,point,'<FONT style="filter:glow(color=#000000,strength=2);font-size:'+fontSize+'px;WIDTH:100%; COLOR:'+color+';">'+name+'</FONT>');
			this.Map.addOverlay(marker);
			if(p.length>=3 && (placeMark.selectSingleNode("LookAt") || placeMark.selectSingleNode("View")))
			{
				if(placeMark.selectSingleNode("LookAt"))lookAt=placeMark.selectSingleNode("LookAt");
				else lookAt=placeMark.selectSingleNode("View");
				x=(parseFloat(lookAt.selectSingleNode("longitude").text)-parseFloat(p[0]))*120.0;
				y=(parseFloat(lookAt.selectSingleNode("latitude").text)-parseFloat(p[1]))*120.0;
				z=parseFloat(lookAt.selectSingleNode("range").text)-parseFloat(p[2]);
				range=Math.sqrt(Math.pow(x,2)+Math.pow(y,2)+Math.pow(z,2));
				var zoom=parseInt(Math.log(range/300)/Math.log(2));
				if(zoom<0)zoom=0;
				if(zoom>17)zoom=17;
				marker.K_DefaultZoom=zoom;
			}
			if(parentNode)
			{
				marker.K_TreeNode=parentNode.AddNode('<input type="checkBox" checked="true"/><a href="javascript:">'+name+'</a>',name);
				marker.K_TreeNode.span.childNodes[0].onclick=K_GetCallBack(marker.K_TreeNode,this.PointDisplayCallBack);
				marker.K_TreeNode.span.children.item(1).onclick=K_GetCallBack(marker.K_TreeNode,this.PointClickCallBack);
				marker.K_TreeNode.Map=this.Map;
				marker.K_TreeNode.Marker=marker;
				this.treeNodes.push(marker.K_TreeNode);
			}
			var description="";
			if(placeMark.attributes.getNamedItem("id"))
				description='<iframe src="./MiniPlaceInfo.htm?id='+placeMark.attributes.getNamedItem("id").nodeValue+'" frameBorder="0" scrolling="no" width="300" height="200"></iframe>';
			else if(placeMark.selectSingleNode("description")!=null)
				description=placeMark.selectSingleNode("description").text;
			if(description!="")
				GEvent.addListener(marker,"click",function(){marker.openInfoWindowHtml(description);});
			this.overlays.push(marker);
		}
		if(placeMark.selectSingleNode("LineString"))
		{
			var color="#F09898";
			var width=1;
			if(placeMark.selectSingleNode("styleUrl")!=null && placeMark.selectSingleNode("styleUrl").text.length>1 && placeMark.selectSingleNode("styleUrl").text.indexOf("#")==0)
			{
				var styleNode=placeMark.ownerDocument.selectSingleNode("//Style[@id='"+placeMark.selectSingleNode("styleUrl").text.substr(1)+"']");
				if(styleNode!=null)
				{
					if(styleNode.selectSingleNode("LineStyle/color")!=null)
						color=styleNode.selectSingleNode("LineStyle/color").text;
					if(styleNode.selectSingleNode("LineStyle/width")!=null)
						width=styleNode.selectSingleNode("LineStyle/width").width;
				}
			}
			var p=placeMark.selectSingleNode("LineString/coordinates").text.split(" ");
			var pNumber=p.length;
			for(var j=0;j<pNumber;j++)
			{
				ps=p[j].split(",");
				p[j]=new GLatLng(parseFloat(ps[1]),parseFloat(ps[0]));
			}
			var line=new GPolyline(p,color,width);
			this.Map.addOverlay(line);
			this.overlays.push(line);
		}
	}
	K_OverlayTree.prototype.ParseKmlImage=function(placeMark,kmlStyle,parentNode)
	{
		if(placeMark.selectSingleNode("LatLonBox") && placeMark.selectSingleNode("Icon/href"))
		{
			if(parentNode)
				for(var i=0;i<parentNode.children.length;i++)
					if(parentNode.children[i].Marker && parentNode.children[i].Marker.imageUrl==placeMark.selectSingleNode("Icon/href").text)
						return;
			name="未命名图片";
			latLonBox=placeMark.selectSingleNode("LatLonBox");
			if(placeMark.selectSingleNode("name")!=null)
				name=placeMark.selectSingleNode("name").text;
			var bounds=new GBounds(parseFloat(latLonBox.selectSingleNode("west").text),parseFloat(latLonBox.selectSingleNode("south").text),parseFloat(latLonBox.selectSingleNode("east").text),parseFloat(latLonBox.selectSingleNode("north").text));
			var rotation=0;
			if(latLonBox.selectSingleNode("rotation")!=null)
				rotation=parseInt(latLonBox.selectSingleNode("rotation").text);
			var imageOverlay=new K_ImageOverlay(placeMark.selectSingleNode("Icon/href").text,bounds,rotation,0.5);
			if(parentNode)
			{
				imageOverlay.K_TreeNode=parentNode.AddNode('<input type="checkBox"/>'+name+'(<a href="javascript:" title="'+placeMark.selectSingleNode("Icon/href").text+'">切换透明</a>)',name);
				imageOverlay.K_TreeNode.span.childNodes[0].onclick=K_GetCallBack(imageOverlay.K_TreeNode,this.PointDisplayCallBack);
				imageOverlay.K_TreeNode.span.children.item(1).onclick=K_GetCallBack(imageOverlay.K_TreeNode,this.ImageTransportCallBack);
				imageOverlay.K_TreeNode.Marker=imageOverlay;
				this.treeNodes.push(imageOverlay.K_TreeNode);
			}
			this.Map.addOverlay(imageOverlay);
			imageOverlay.display(false);
			this.overlays.push(imageOverlay);
		}
	}
	K_OverlayTree.prototype.ParseKmlFolder=function(kmlFolder,kmlStyle,parentNode)
	{
		var style=this.GetCurrentStyle(kmlFolder,kmlStyle);
		var num=kmlFolder.childNodes.length;
		var currentTreeNode=null;
		if(parentNode)
		{
			if(kmlFolder==kmlFolder.ownerDocument.documentElement)
				currentTreeNode=parentNode;
			else
			{
				name="";
				if(kmlFolder.selectSingleNode("name")!=null)
					name=kmlFolder.selectSingleNode("name").text;
				currentTreeNode=parentNode.SelectNodeByName(name)
				if(currentTreeNode==null)
				{
					currentTreeNode=parentNode.AddNode('<input type="checkBox" checked="true"/>'+name,name);
					currentTreeNode.span.childNodes[0].onclick=K_GetCallBack(currentTreeNode,this.FolderDisplayCallBack);;
				}
			}
		}
		for(var i=0;i<num;i++)
		{
			this.ParseKmlNode(kmlFolder.childNodes[i],style,currentTreeNode);
		}
	}
	K_OverlayTree.prototype.ParseKmlStyle=function(styleNode,kmlStyle,parentNode)
	{
		var styleId=styleNode.getAttribute("id");
		if(styleId==null || styleId=="")
			return;
		var newStyle=this.defaultStyle.copy();
		this.ChangeStyleByNode(newStyle,styleNode);
		this.styles[styleId]=newStyle;
	}
	K_OverlayTree.prototype.ChangeStyleByNode=function(kmlStyle,styleNode)
	{
		var node=styleNode.selectSingleNode("IconStyle");
		if(node!=null)
		{
			if(!kmlStyle.IconStyle)
				kmlStyle.IconStyle=new K_KmlStyle();
			var iconNode=node.selectSingleNode("Icon");
			if(iconNode!=null)
			{
				if(!kmlStyle.IconStyle.Icon)
					kmlStyle.IconStyle.Icon=new K_KmlStyle();
				if(iconNode.selectSingleNode("href")!=null)
				{
					kmlStyle.IconStyle.Icon.href=iconNode.selectSingleNode("href").text.replace("root://","/Map/");
					kmlStyle.IconStyle.Icon.bounds=null;
				}
				if(iconNode.selectSingleNode("w")!=null && iconNode.selectSingleNode("h")!=null && iconNode.selectSingleNode("x")!=null && iconNode.selectSingleNode("y")!=null)
					kmlStyle.IconStyle.Icon.bounds=new GBounds(iconNode.selectSingleNode("x").text*1,iconNode.selectSingleNode("y").text*1,iconNode.selectSingleNode("x").text*1+iconNode.selectSingleNode("w").text*1,iconNode.selectSingleNode("y").text*1+iconNode.selectSingleNode("h").text*1);
			}
			if(node.selectSingleNode("scale"))
				kmlStyle.IconStyle.scale=node.selectSingleNode("scale").text*1;
		}
		var node=styleNode.selectSingleNode("LabelStyle");
		if(node!=null)
		{
			if(!kmlStyle.LabelStyle)
				kmlStyle.LabelStyle=new K_KmlStyle();
			if(node.selectSingleNode("color"))
				kmlStyle.LabelStyle.color=node.selectSingleNode("color").text;
			if(node.selectSingleNode("colorMode"))
				kmlStyle.LabelStyle.colorMode=node.selectSingleNode("colorMode").text;
			if(node.selectSingleNode("scale"))
				kmlStyle.LabelStyle.scale=node.selectSingleNode("scale").text;
		}
	}
	K_OverlayTree.prototype.GetCurrentStyle=function(kmlNode,kmlStyle)
	{
		var style=kmlStyle;
		if(kmlNode.selectSingleNode("styleUrl")!=null && kmlNode.selectSingleNode("styleUrl").text.length>0 && kmlNode.selectSingleNode("styleUrl").text.substr(0,1)=="#")
		{
			var styleUrl=kmlNode.selectSingleNode("styleUrl").text.substr(1);
			if(this.styles[styleUrl]!=null)
				style=this.styles[styleUrl];
		}
		if(kmlNode.selectSingleNode("Style")!=null)
		{
			style=style.copy();
			this.ChangeStyleByNode(style,kmlNode.selectSingleNode("Style"));
		}
		return style;
	}
	K_OverlayTree.prototype.PointDisplayCallBack=function()
	{
		this.Marker.display(this.span.childNodes[0].checked);
	}
	K_OverlayTree.prototype.PointClickCallBack=function()
	{
		if(this.Marker.K_DefaultZoom)
		{
			if(this.Marker.K_DefaultZoom==this.Map.getZoomLevel())
				this.Map.recenterOrPanToLatLng(this.Marker.point);
			else
				this.Map.centerAndZoom(this.Marker.point,this.Marker.K_DefaultZoom);
		}
		else
			this.Map.recenterOrPanToLatLng(this.Marker.point);
	}
	K_OverlayTree.prototype.ImageTransportCallBack=function()
	{
		if(this.Marker.opacity==1)
			this.Marker.setOpacity(0.5);
		else
			this.Marker.setOpacity(1);
	}
	K_OverlayTree.prototype.FolderDisplayCallBack=function()
	{
		for(var i=0;i<this.children.length;i++)
		{
			this.children[i].span.childNodes[0].checked=!this.span.childNodes[0].checked;
			this.children[i].span.childNodes[0].click();
		}
	}
	K_OverlayTree.prototype.clear=function()
	{
		if(this.overlays)
		{
			for(var j=0;j<this.overlays.length;j++)
			{
				this.Map.removeOverlay(this.overlays[j]);
				this.overlays[j]=null;
			}
			this.overlays=null;
		}
		if(this.treeNodes)
		{
			for(var j=0;j<this.treeNodes.length;j++)
			{
				this.treeNodes[j].parent.RemoveNode(this.treeNodes[j]);
				this.treeNodes[j]=null;
			}
			this.treeNodes=null;
		}
		this.handle=null;
	}

	function K_Tree(divId,rootName)
	{
		this.imageFolder="K_Tree/";
		this.imageSize=20;
		this.div=document.getElementById(divId);
		this.root=new K_TreeNode(this,null,rootName,0);
		this.div.appendChild(this.root.div);
	}
	function K_TreeNode(tree,parent,html,grade,name)
	{
		this.tree=tree;
		this.parent=parent;
		this.grade=grade;
		this.hasNextNode=false;
		this.hasChildNode=false;
		this.children=[];
		this.Name=name;

		this.div=document.createElement("div");
		this.div.style.position="relative";

		for(var i=0;i<grade-1;i++)
		{
			var spaceImage=document.createElement("img");
			spaceImage.src=this.tree.imageFolder+"L4.gif";
			spaceImage.width=this.tree.imageSize;
			spaceImage.height=this.tree.imageSize;
			this.div.appendChild(spaceImage);
		}

		this.image=document.createElement("img");
		frontImage="L2.gif";
		if(grade==0)
		{
			frontImage="root.gif";
			this.image.style.cursor="pointer";
		}
		this.image.src=this.tree.imageFolder+frontImage;
		this.image.width=this.tree.imageSize;
		this.image.height=this.tree.imageSize;
		this.image.onclick=this.GetClickCallBack(this);
		this.div.appendChild(this.image);

		this.span=document.createElement("span");
		this.span.innerHTML=html;
		this.span.style.fontSize=13;
		this.span.style.position="absolute";
		if(grade>0)
			this.span.style.left=this.tree.imageSize*(grade);
		else
			this.span.style.left=this.tree.imageSize;
		this.span.style.top=0;
		this.span.style.height=this.tree.imageSize;
		this.span.style.overflowY="hidden";
		this.div.appendChild(this.span);
		this.childrenDiv=document.createElement("div");
		this.childrenDiv.style.display="none";
		this.div.appendChild(this.childrenDiv);

	}
	K_TreeNode.prototype.GetClickCallBack=function(obj)
	{
		return function(){K_TreeNode.prototype.ClickCallBack.apply(obj,arguments)};
	}
	K_TreeNode.prototype.ClickCallBack=function()
	{
		if(this.childrenDiv.style.display=="none")
		{
			this.childrenDiv.style.display="";
			if(this.grade==0 || !this.hasChildNode)return;
			if(this.hasNextNode)
				this.image.src=this.tree.imageFolder+"M1.gif";
			else
				this.image.src=this.tree.imageFolder+"M2.gif";
		}
		else
		{
			this.childrenDiv.style.display="none";
			if(this.grade==0 || !this.hasChildNode)return;
			if(this.hasNextNode)
				this.image.src=this.tree.imageFolder+"P1.gif";
			else
				this.image.src=this.tree.imageFolder+"P2.gif";
		}
	}
	K_TreeNode.prototype.SetImage=function()
	{
		if(this.grade==0)
			return;
		if(this.hasChildNode)
		{
			if(this.hasNextNode)
			{
				if(this.childrenDiv.style.display=='none')
					frontImage="P1.gif";
				else
					frontImage="M1.gif";
			}
			else
			{
				if(this.childrenDiv.style.display=='none')
					frontImage="P2.gif";
				else
					frontImage="M2.gif";
			}
			this.image.style.cursor="pointer";
		}
		else
		{
			if(this.hasNextNode)
				frontImage="L1.gif";
			else
				frontImage="L2.gif";
			this.image.style.cursor="auto";
		}
		this.image.src=this.tree.imageFolder+frontImage;
	}
	K_TreeNode.prototype.AddNode=function(html,name)
	{
		var child=new K_TreeNode(this.tree,this,html,this.grade+1,name);
		this.childrenDiv.appendChild(child.div);
		len=this.children.length;
		if(len>0)
		{
			this.children[len-1].hasNextNode=true;
			this.children[len-1].SetImage();
		}
		else
		{
			this.hasChildNode=true;
			this.SetImage();
		}
		this.children.push(child);
		return child;
	}
	K_TreeNode.prototype.RemoveNode=function(child)
	{
		this.childrenDiv.removeChild(child.div);
		var num,len=this.children.length;
		for(num=0;num<len;num++)
		{
			if(this.children[num]==child)
				break;
		}
		this.children.splice(num,1);
		if(num==length-1 && num>0)
		{
			this.children[len-1].hasNextNode=false;
			this.children[len-1].SetImage();
		}
		if(num==0 && len==1)
		{
			this.hasChildNode=false;
			this.SetImage();
		}
	}
	K_TreeNode.prototype.SelectNodeByName=function(name)
	{
		var len=this.children.length;
		for(var num=0;num<len;num++)
			if(this.children[num].Name==name)
				return this.children[num];
		return null;
	}
//动态载入标记的对象
	function K_DynamicOverlay(baseUrl)
	{
		this.baseUrl=baseUrl;
		this.binded=false;
		this.overlayTree=[];
		this.treeNodesHandle=[];
		this.times=0;
	}
	K_DynamicOverlay.prototype.Bind=function(map,rootTreeNode)
	{
		this.moveListener=GEvent.bind(map,"moveend",this,this.Load);
		this.binded=true;
		this.Map=map;
		this.treeNode=rootTreeNode;
		this.Load();
	}
	K_DynamicOverlay.prototype.Load=function()
	{
		var tileImages=this.Map.sortImagesFromCenter(this.Map.tileImages);
		var tileNumber=tileImages.length;
		var nameFlagPre=this.Map.getCurrentMapType().getShortLinkText();
		this.times++;
		zoom=this.Map.getZoomLevel();
		for(var i=0;i<tileNumber;i++)
		{
			a=tileImages[i].coordX+this.Map.topLeftTile.x;
			b=tileImages[i].coordY+this.Map.topLeftTile.y;
			var nameFlag=nameFlagPre+"_"+zoom+"_"+a+"_"+b;
			if(!this.overlayTree[nameFlag])
			{
				this.overlayTree[nameFlag]=new K_OverlayTree(this.Map,this.treeNode);
				var ts=this.Map.spec.tileSize;
				var ul = this.Map.spec.getLatLng(a*ts,(b+1)*ts, zoom);
				var lr = this.Map.spec.getLatLng((a+1)*ts, b*ts, zoom);
				var lookAt=this.Map.spec.getLatLng((a+0.5)*ts, (b+0.5)*ts, zoom);
				range=300*Math.pow(2,zoom);
				var bbox = ul.x + "," + ul.y + "," + lr.x + "," + lr.y+","+lookAt.x+","+lookAt.y+","+range+",0,0";
				var kmlLoad=new K_XmlLoader(K_GetCallBack(this,this.KmlCallBack));
				kmlLoad.nameFlag=nameFlag;
				kmlLoad.Load(this.baseUrl+"bbox="+bbox+"");
			}
			this.overlayTree[nameFlag].times=this.times;
		}
		this.clear();
	}
	K_DynamicOverlay.prototype.unBind=function()
	{
		GEvent.removeListener(this.moveListener);
		this.clear();
		this.binded=false;
	}
	K_DynamicOverlay.prototype.clear=function()
	{
		for(var key in this.overlayTree)
		{
			overlayTree=this.overlayTree[key];
			if(overlayTree!=null && overlayTree.times!=this.times)
			{
				this.overlayTree[key].clear();
				this.overlayTree[key]=null;
			}
		}
	}
	K_DynamicOverlay.prototype.KmlCallBack=function(xmlLoader)
	{
		if(this.overlayTree[xmlLoader.nameFlag])
			this.overlayTree[xmlLoader.nameFlag].ParseKml(xmlLoader);
	}
//载入图片标记的对象
	function K_ImageTileOverlay(baseUrl)
	{
		this.baseUrl=baseUrl;
		this.binded=false;
	}
	K_ImageTileOverlay.prototype.Bind=function(map)
	{
		this.Map=map;
		this.Spec=this.Map.spec;
		this.Spec.K_IO_hasOverlay=this.Spec.hasOverlay;
		this.Spec.K_IO_getOverlayURL=this.Spec.getOverlayURL;
		this.Spec.K_IO_baseUrl=this.baseUrl;
		this.Spec.getOverlayURL=function(a,b,c)
		{
			var ts=this.tileSize;
			var ul = this.getLatLng(a*ts,(b+1)*ts, c);
			var lr = this.getLatLng((a+1)*ts, b*ts, c);
			var bbox = ul.x + "," + ul.y + "," + lr.x + "," + lr.y;
			return this.K_IO_baseUrl+"bbox="+bbox+"&width="+ts+"&height="+ts+"&zoom="+c+"";
		};
		this.Spec.hasOverlay=function(){return true;};
		this.Map.removeTilesFromDiv(this.Map.overlayImages);
		this.Map.overlayImages=[];
		this.Map.loadTileImagesLayer(this.Map.overlayImages,true)
		this.listener=GEvent.bind(map,"maptypechanged",this,this.reBindImageOverlay);
		this.binded=true;
	}
	K_ImageTileOverlay.prototype.unBind=function()
	{
		this.Spec.hasOverlay=this.Spec.K_IO_hasOverlay;
		this.Spec.getOverlayURL=this.Spec.K_IO_getOverlayURL;
		this.Spec.K_IO_hasOverlay=null;
		this.Spec.K_IO_getOverlayURL=null;
		this.Spec.K_IO_baseUrl=null;
		GEvent.removeListener(this.listener);
		this.listener=null;
		this.Map.removeTilesFromDiv(this.Map.overlayImages);
		this.overlayImages=null
		this.binded=false;
	}
	K_ImageTileOverlay.prototype.reBindImageOverlay=function()
	{
		this.unBind();
		this.Bind(this.Map);
	}

	window.K_Tree=K_Tree;
	window.K_TreeNode=K_TreeNode;
	window.K_OverlayTree=K_OverlayTree;
	window.K_DynamicOverlay=K_DynamicOverlay;
	window.K_ImageTileOverlay=K_ImageTileOverlay;

}
K_ReverterKmlTree();    