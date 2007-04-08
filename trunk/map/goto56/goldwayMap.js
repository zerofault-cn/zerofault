// for the map

var markers;//历史线路上的标注
var marker;
var marker1;//汽车位置临时标注
var lat0=100;//纬度最大不超过90
var lng0=200;//经度最大不超过180

var timeOut = 500;  // length to wait till next point is plotted
var i = 0;
var currentCheckPoint = 0;//当前标注点
var checkPoints = new Array();//所有标注点

// for display
var loadingMessage;
var distanceMessage;
var speedMessage;
var timeMessage;
var checkPointCount = 1;

// for distance calculations
var distance = 0;
var checkPoint; 
var checkPointDistance = 0;
var latMax = 0;
var latMin = 0;
var longMax = 0;
var longMin = 0;
var latSum = 0;
var longSum = 0;
var coordinateCount = 0;

var lastMileMinutes1;//上一英里耗时
// for time calculations
var totalTime = 0;
var startTime = 0;
var timeSpan=0;//已耗时间

var enabled = 0;//设定是否自动刷新当前汽车位置

var searchOverlayTree;
var dynamicOverlayTreeNode,tempTreeNode,kmlFileOverlayTreeNode;
//var dynamicOverlay=new K_DynamicOverlay("K_Reverter.kml");
var imageOverlay;
//一组google提供的ICON
var baseIcon = new GIcon();
baseIcon.shadow = "http://labs.google.com/ridefinder/images/mm_20_shadow.png";
baseIcon.iconSize = new GSize(12, 20);
baseIcon.shadowSize = new GSize(22, 20);
baseIcon.iconAnchor = new GPoint(6, 10);
baseIcon.infoWindowAnchor = new GPoint(5, 1);
icon_Green= new GIcon(baseIcon);
icon_Green.image = "http://labs.google.com/ridefinder/images/mm_20_green.png";
icon_Blue= new GIcon(baseIcon);
icon_Blue.image = "http://labs.google.com/ridefinder/images/mm_20_blue.png";
icon_Red= new GIcon(baseIcon);
icon_Red.image = "http://labs.google.com/ridefinder/images/mm_20_red.png";

//自定义的汽车图标
icon_car=new GIcon();
icon_car.image='car.gif';
icon_car.iconSize=new GSize(20,20);
icon_car.iconAnchor = new GPoint(10,10);
icon_car.infoWindowAnchor=new GPoint(10,10);

function onLoad()
{
	loadingMessage = document.getElementById('progress');
	distanceMessage = document.getElementById('distanceMessage');
	speedMessage = document.getElementById("speedMessage");
	timeMessage = document.getElementById('timeMessage');

	var file = getFileName();
	if (file)
	{
		loadInfo();
	}
}

function K_GetQueryString(key)
{
	var returnValue =""; 
	var sURL = window.document.URL;
	if (sURL.indexOf("?") > 0)
	{
		var arrayParams = sURL.split("?");
		var arrayURLParams = arrayParams[1].split("&");
		for (var j = 0; j < arrayURLParams.length; j++)
		{
			var sParam =  arrayURLParams[j].split("=");

			if ((sParam[0] ==key) && (sParam[1] != ""))
				returnValue=sParam[1];
		}
	}
	return returnValue;
}

function CreateMarker1(point,icon,html)
{
	marker = new GMarker(point,icon);
	if(html && html!="")
	{
		GEvent.addListener(marker, "click", function()
			{
				marker.openInfoWindowHtml(html);
			}
		);
	}
	map.addOverlay(marker);
	return marker;
}


function showInfo()
{
	var zoom=map.getZoom();

	var num=parseInt(Math.log(1/map.spec.pixelsPerLonDegree[zoom])/Math.log(10));
	alert(num);
	var point=map.getCenter();
	var px=point.x.toString();
//	px=px.substring(0,px.indexOf(".")-num+2);
	var py=point.y.toString();
//	py=py.substring(0,py.indexOf(".")-num+2);
	document.getElementById("I_Center").value =px+","+py;
	document.getElementById("I_ZoomLevel").value = zoom;
//	document.getElementById("I_MapType").value = map.getCurrentMapType().getShortLinkText();
//	setMinimapRect();
}
function readGPS()
{
	var request = false;
	var xmlDoc;
	var point1;
	var polyline;
	var lat1;
	var lng1;
	var datetime,date,time;

	request = GXmlHttp.create();
	request.open("GET","getXML.php?type=point", true);
	request.send(null);
	request.onreadystatechange = function()
	{
		if (request.readyState == 4)
		{
			if (request.status == 200)
			{
				xmlDoc = request.responseXML;
				lng1=xmlDoc.documentElement.getElementsByTagName("Longitude");
				lng1=lng1[0].firstChild.nodeValue;
				lng1=parseFloat(lng1);
				lat1=xmlDoc.documentElement.getElementsByTagName("Latitude");
				lat1=lat1[0].firstChild.nodeValue;
				lat1=parseFloat(lat1);
				if(lng1<-180 || lng1>180)
				{
					alert('经度值超过界限');
					return;
				}
				if(lat1<-90 || lat1>90)
				{
					alert('纬度值超过界限');
					return;
				}
				datetime=xmlDoc.documentElement.getElementsByTagName("Time");
				datetime=datetime[0].firstChild.nodeValue;
				date=datetime.substring(0,10);
				time=datetime.substring(11,19);
				
				if(marker1!=null)
				{
					map.removeOverlay(marker1);
				//	map.clearOverlays()
				}
				
				point1=new GPoint(lng1,lat1);
				map.recenterOrPanToLatLng(point1);

				if(lng0==200 && lat0==100)//初始位置
				{
					map.centerAndZoom(point1,2);//将起点位置居中,并放大地图到合适等级,设置合适地图类型
					CreateMarker1(point1,icon_Red,'起点<br>'+date+'<br>'+time);
				}
				else if(lat0!=lat1 || lng0!=lng1)//周期时间内有移动,先创建折线,再添加汽车标识
				{
					polyline = new GPolyline([new GPoint(lng0,lat0),new GPoint(lng1,lat1)], "#0000ff", 3,1);
					map.addOverlay(polyline);
					marker1=CreateMarker1(point1,icon_car,'当前时间:<br>'+date+'<br>'+time);
				}
				else//周期时间内未移动,只添加汽车标识
				{
					marker1=CreateMarker1(point1,icon_car,'停留<br>'+date+'<br>'+time);
				}
				
				lng0=lng1;
				lat0=lat1;
			}
		}
	}
	

//	window.setTimeout(function(){readGPS();},5000);
}
function TOfunc()
{
	var space=parseInt(document.clock.space.value);
	TO = window.setTimeout( "TOfunc()", space );
	readGPS();
}
function initCheckpoint()
{
	checkPoint = 1
}

// LOAD THE XML FILE AND PLOT THE FIRST POINT //
function loadInfo()
{
	markers = null;
	marker = null;
	var request = GXmlHttp.create();

	var fileName = getFileName();

	request.open("GET", fileName, true);
	request.onreadystatechange = function()
	{
		if (request.readyState == 4)
		{
			var xmlDoc = request.responseXML;
			markers = xmlDoc.documentElement.getElementsByTagName("Trackpoint");
			plotPoint();
		}
	}
	request.send(null);
}

function plotPoint()
{
	if (i < markers.length )
	{
		var Lat = markers[i].getElementsByTagName("Latitude");
		var Lng = markers[i].getElementsByTagName("Longitude");
		Lat = Lat[0].firstChild.nodeValue;
		Lng = Lng[0].firstChild.nodeValue;

		if (Lat > latMax) 
		{
			latMax = Lat;
		}
		else if (Lat < latMin) 
		{
			latMin = Lat;
		}

		if (Lng > longMax)
		{
			longMax = Lng;
		}
		else if (Lng < longMin)
		{
			longMin = Lng;
		}

		latSum = latSum + Lat;
		longSum = longSum + Lat;
		coordinateCount = coordinateCount + 1;

		var point = new GPoint(Lng,Lat);
		
		if (i < markers.length - 1){
			window.setTimeout(plotPoint,timeOut);
			calculateTime(i);
			averageSpeed = Math.round((distance / (totalTime/3600))*100)/100;
			var minutesSoFar = totalTime / 60;
			var currentPace = minutesSoFar / distance;
		//	speedMessage.innerHTML = '每英里耗时:'+displayMinutes(currentPace);
			speedMessage.innerHTML = '平均速度:'+averageSpeed+'公里/小时 ';
		}

		marker = createMarker(point,i,markers.length);
	
		if (i < markers.length && i != 0)
		{
			
			var Lat1 = markers[i-1].getElementsByTagName("Latitude");
			var Lng1 = markers[i-1].getElementsByTagName("Longitude");
				
			Lat1 = Lat1[0].firstChild.nodeValue;
			Lng1 = Lng1[0].firstChild.nodeValue;
					
			var point1 = new GPoint(Lng1,Lat1);

			var points=[point, point1];
			
			//RECENTER MAP EVERY TEN POINTS
			if (i%3==0)
			{
				map.recenterOrPanToLatLng(point);
			}
/*
			if (i < markers.length/2)
			{
				map.addOverlay(new GPolyline(points, "#0000ff",3,1));
			}
			else
			{
				map.addOverlay(new GPolyline(points, "#ff0000",3,1));
			}
*/
			if (lastMileMinutes1 > 10)
			{
				map.addOverlay(new GPolyline(points, "#ff0000",3,1));
			}
			else
			{
				map.addOverlay(new GPolyline(points, "#0000ff",3,1));
			}
		
			calculateDistance(Lng, Lat, Lng1, Lat1);
		}
		
		loadingPercentage(i);
		distanceMessage.innerHTML=Math.round(distance*100)/100 + "公里 ";
		
		i++;
	}
}


// GET THE APPROPRIATE MARKER FOR START, FINISH, CHECKPOINT, AND LINE
function createMarker(point, i, markerLength) {

	var icon = new GIcon();
	icon.shadow = "http://labs.google.com/ridefinder/images/mm_20_shadow.png";
	icon.iconSize = new GSize(24, 38);
	icon.shadowSize = new GSize(40, 38);

	icon.iconAnchor = new GPoint(10, 34);    
	icon.infoWindowAnchor = new GPoint(9, 5);
						
	if (i == 0 ){
		checkPoints[currentCheckPoint] = {
			timestamp: markers[i].getElementsByTagName('Time')[0].firstChild.nodeValue
		};
		map.centerAndZoom(point, 2);
		icon.image = "http://labs.google.com/ridefinder/images/mm_20_green.png";
		marker = new GMarker(point,icon);
		map.addOverlay(marker);
		GEvent.addListener(marker, "click", function() {
		marker.openInfoWindowHtml("开始");});
		return marker;
	} else if(i == markers.length -1){
		icon.image = "http://labs.google.com/ridefinder/images/mm_20_red.png";
		marker = new GMarker(point,icon);
		map.addOverlay(marker);
		GEvent.addListener(marker, "click", function() {
		marker.openInfoWindowHtml("结束");});
		map.recenterOrPanToLatLng(point, 2000);
		return marker;
	}		

	if (checkPointDistance - checkPoint >= 0 && checkPoint != 0){
		currentCheckPoint = currentCheckPoint + 1;
		checkPoints[currentCheckPoint] = {
			timestamp: markers[i].getElementsByTagName('Time')[0].firstChild.nodeValue
		};

		var thisCheckPointDuration = getTimeBetweenCheckPoints(checkPoints[currentCheckPoint-1].timestamp,checkPoints[currentCheckPoint].timestamp);
		var thisCheckPoint = currentCheckPoint;
		var lastMileMinutes = thisCheckPointDuration / 60;
		var mileTime = displayMinutes(lastMileMinutes);
		var timeSpan1=timeSpan;
		lastMileMinutes1=lastMileMinutes;

		var img_id=thisCheckPoint>39?0:thisCheckPoint;
	//	if (lastMileMinutes < 10) {
			icon.image = "images/red" + img_id + ".png";
	//	} else {
	//		icon.image = "images/green" + img_id + ".png";
	//	}
		var distance1 = checkPointDistance;
		marker = new GMarker(point,icon);
		map.addOverlay(marker);
		GEvent.addListener(marker, "click", function() {
		marker.openInfoWindowHtml("行程: " + thisCheckPoint + "公里<br>前1公里耗时:" + mileTime+'<br>行驶时间:'+timeSpan1);});
		checkPointDistance = 0;
		checkPointCount += 1;
	} else {
		marker = new GMarker(point, icon);
	}
	return marker;
}

function displayMinutes(num_seconds,do_alert)
{
	if (do_alert) {
		alert("seconds " + num_seconds);
	}
	currentPace = num_seconds.toString();
	var a = currentPace.split('.');
	var myregex = new RegExp("^\\d{1,3}");
	var minuteParts = myregex.exec(a[1]);
	while (minuteParts < 100 && minuteParts != 0) {
		minuteParts = minuteParts * 10;
	}
	if (do_alert) {
		alert("mintes " + a[0] + " parts " + minuteParts);
	}
	var secondsPlace = Math.round(minuteParts/10) * 60 / 100;
	if (do_alert) {
		alert("secondsPlace " + secondsPlace);
	}

	var displayString = a[0] + "分" + leadingZero(secondsPlace)+'秒';
	return displayString;
}

function leadingZero(x){
	return (x>9)?x:'0'+x;
}



function getTimeBetweenCheckPoints(lastCheckPoint,thisCheckPoint) {
	var secondsBetween = secondsBetweenDates(lastCheckPoint,thisCheckPoint);
	return secondsBetween;
}

// LOADING BAR //
function loadingPercentage(currentPoint){
	var percentage = Math.round((currentPoint/(markers.length - 1)) * 100);
	loadingMessage.style.width = percentage +"%"; 
}

// Function based on Vincenty formula 
// Website referenced: http://www.movable-type.co.uk/scripts/LatLongVincenty.html
// Thanks Chris Veness for this!
//Also a big thank you to Steve Conniff for taking the time to intruoduce to this more accurate method of calculating distance

function calculateDistance(point1y, point1x, point2y, point2x)
{
	// Vincenty formula
	traveled = LatLong.distVincenty(new LatLong(point2x, point2y), new LatLong(point1x, point1y));
//	traveled = traveled * 0.000621371192;  // Convert to miles from meters
	traveled = traveled * 0.001; //转换米到公里
	distance = distance + traveled;
	checkPointDistance = checkPointDistance + traveled;
//	alert(checkPointDistance);
}



/*
 * LatLong constructor:
 *
 *   arguments are in degrees, either numeric or formatted as per LatLong.degToRad
 *   returned lat -pi/2 ... +pi/2, E = +ve
 *   returned lon -pi ... +pi, N = +ve
 */
function LatLong(degLat, degLong) {
  if (typeof degLat == 'number' && typeof degLong == 'number') {  // numerics
    this.lat = degLat * Math.PI / 180;
    this.lon = degLong * Math.PI / 180;
  } else if (!isNaN(Number(degLat)) && !isNaN(Number(degLong))) { // numerics-as-strings
    this.lat = degLat * Math.PI / 180;
    this.lon = degLong * Math.PI / 180;
  } else {                                                        // deg-min-sec with dir'n
    this.lat = LatLong.degToRad(degLat);
    this.lon = LatLong.degToRad(degLong);
  }
}

/*
 * Calculate geodesic distance (in m) between two points specified by latitude/longitude.
 *
 * from: Vincenty inverse formula - T Vincenty, "Direct and Inverse Solutions of Geodesics on the 
 *       Ellipsoid with application of nested equations", Survey Review, vol XXII no 176, 1975
 *       http://www.ngs.noaa.gov/PUBS_LIB/inverse.pdf
 */
LatLong.distVincenty = function(p1, p2) {
  var a = 6378137, b = 6356752.3142,  f = 1/298.257223563;
  var L = p2.lon - p1.lon;
  var U1 = Math.atan((1-f) * Math.tan(p1.lat));
  var U2 = Math.atan((1-f) * Math.tan(p2.lat));
  var sinU1 = Math.sin(U1), cosU1 = Math.cos(U1);
  var sinU2 = Math.sin(U2), cosU2 = Math.cos(U2);
  var lambda = L, lambdaP = 2*Math.PI;
  var iterLimit = 20;
  while (Math.abs(lambda-lambdaP) > 1e-12 && --iterLimit>0) {
    var sinLambda = Math.sin(lambda), cosLambda = Math.cos(lambda);
    var sinSigma = Math.sqrt((cosU2*sinLambda) * (cosU2*sinLambda) + 
      (cosU1*sinU2-sinU1*cosU2*cosLambda) * (cosU1*sinU2-sinU1*cosU2*cosLambda));
    if (sinSigma==0) return 0;  // co-incident points
    var cosSigma = sinU1*sinU2 + cosU1*cosU2*cosLambda;
    var sigma = Math.atan2(sinSigma, cosSigma);
    var alpha = Math.asin(cosU1 * cosU2 * sinLambda / sinSigma);
    var cosSqAlpha = Math.cos(alpha) * Math.cos(alpha);
    var cos2SigmaM = cosSigma - 2*sinU1*sinU2/cosSqAlpha;
    var C = f/16*cosSqAlpha*(4+f*(4-3*cosSqAlpha));
    lambdaP = lambda;
    lambda = L + (1-C) * f * Math.sin(alpha) *
      (sigma + C*sinSigma*(cos2SigmaM+C*cosSigma*(-1+2*cos2SigmaM*cos2SigmaM)));
  }
  if (iterLimit==0) return NaN  // formula failed to converge
  var uSq = cosSqAlpha * (a*a - b*b) / (b*b);
  var A = 1 + uSq/16384*(4096+uSq*(-768+uSq*(320-175*uSq)));
  var B = uSq/1024 * (256+uSq*(-128+uSq*(74-47*uSq)));
  deltaSigma = B*sinSigma*(cos2SigmaM+B/4*(cosSigma*(-1+2*cos2SigmaM*cos2SigmaM)-
    B/6*cos2SigmaM*(-3+4*sinSigma*sinSigma)*(-3+4*cos2SigmaM*cos2SigmaM)));
  s = b*A*(sigma-deltaSigma);
  s = s.toFixed(3); // round to 1mm precision
  return s;
}

function secondsBetweenDates(first_date,second_date) {
	//begin year/month/day
	var largeDate = second_date.toString().split("T");
	var date = largeDate[0];
	date = date.split("-");
	var beforeYear = date[0];
	var beforeDay = date[2];
	//beforeDay = beforeDay.replace("0","");
	var beforeMonth = date[1];
	//beforeMonth = beforeMonth.replace("0","");

	//end year/month/day
	var largeDate1 = first_date.toString().split("T");
	var date1 = largeDate1[0];
	date1 = date1.split("-");
	var afterYear = date1[0];
	var afterDay = date1[2];
	//afterDay = afterDay.replace("0","");
	var afterMonth = date1[1];
	//afterMonth = afterMonth.replace("0","");

	//begin hour/min/seconds
	var after = largeDate[1].replace("T","");
	after = largeDate[1].replace("Z","");	

	afterArray = after.split(":");
	var hour = afterArray[0];
	var minute = afterArray[1];
	var second = afterArray[2];

	//end hour/min/seconds
	var after1 = largeDate1[1].replace("T","");
	after1 = largeDate1[1].replace("Z","");	

	afterArray1 = after1.split(":");
	var hour1 = afterArray1[0];
	var minute1 = afterArray1[1];
	var second1 = afterArray1[2];

	var before =new Date(beforeYear, beforeMonth, beforeDay, hour, minute, second);
	var after =new Date(afterYear, afterMonth, afterDay, hour1, minute1, second1);
	var seconds = 1000;
	var secondsBetween = Math.ceil((before.getTime()-after.getTime())/(seconds));
	return secondsBetween;
}

function calculateTime(i) {
	if (startTime == 0) {
		startTime = markers[0].getElementsByTagName("Time");
		startTime = startTime[0].firstChild.nodeValue;
	}

	var current_timestamp = markers[i].getElementsByTagName("Time");
	current_timestamp = current_timestamp[0].firstChild.nodeValue;

	var secondsBetween = secondsBetweenDates(startTime,current_timestamp);
	totalTime = secondsBetween;
	timeSpan=convertSeconds(secondsBetween);
	timeMessage.innerHTML='已行驶时间:'+timeSpan;

}

function convertSeconds(seconds) {
	 //find hours
	 if(seconds > 3600) {
		hours = Math.round(((seconds / 3600)*10)/10) - Math.round((((seconds % 3600)*10)/3600)/10);
		seconds = seconds - (hours * 3600);
		hours += "小时";
	 }
	 else {
		hours = "";
	 }
	 //find minutes
	 if(seconds > 60) {
		minutes = Math.round(((seconds / 60)*10)/10) - Math.round((((seconds % 60)*10)/60)/10);
		seconds = seconds - (minutes * 60);
		minutes += "分";
	 }
	 else {
		minutes = "";
	 }
	
	return hours + minutes + seconds + "秒";
}

function getFileName () {
	var args = getArgs();
	return args.file;
}

function getMapType () {
	var args = getArgs();
	return args.map;
}

function getArgs() {
    var args = new Object();
    var query = location.search.substring(1);     // Get query string
    var pairs = query.split("&");                 // Break at comma
    for(var i = 0; i < pairs.length; i++) {
        var pos = pairs[i].indexOf('=');          // Look for "name=value"
        if (pos == -1) continue;                  // If not found, skip
        var argname = pairs[i].substring(0,pos);  // Extract the name
        var value = pairs[i].substring(pos+1);    // Extract the value
        args[argname] = unescape(value);          // Store as a property
        // In JavaScript 1.5, use decodeURIComponent(  ) instead of unescape(  )
    }
    return args;                                  // Return the object
}

function getAveragePace (mph) {
	mph = mph.toString();
	var a = mph.split('.');
	var seconds = Math.round(a[1] * 60 / 100);
	return a[0] + ":" + seconds;
}

window.onload = function()
{
	initCheckpoint();
	onLoad();
	
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

	window.K_ImageOverlay=K_ImageOverlay;


