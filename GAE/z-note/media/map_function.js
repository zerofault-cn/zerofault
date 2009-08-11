// for the map
var map;
var markers;//历史线路上的标注
var marker;
var marker1;//汽车位置临时标注
var lat0=100;//纬度最大不超过90
var lng0=200;//经度最大不超过180

var timeOut = 1000;  // length to wait till next point is plotted
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
baseIcon.iconAnchor = new GLatLng(10,6);
baseIcon.infoWindowAnchor = new GLatLng(1, 5);
icon_Green= new GIcon(baseIcon);
icon_Green.image = "http://labs.google.com/ridefinder/images/mm_20_green.png";
icon_Blue= new GIcon(baseIcon);
icon_Blue.image = "http://labs.google.com/ridefinder/images/mm_20_blue.png";
icon_Red= new GIcon(baseIcon);
icon_Red.image = "http://labs.google.com/ridefinder/images/mm_20_red.png";

//自定义的汽车图标
icon_car=new GIcon();
icon_car.image='media/target.png';
icon_car.iconSize=new GSize(20,20);
icon_car.iconAnchor = new GLatLng(10,10);
icon_car.infoWindowAnchor=new GLatLng(10,10);


function initialize() {
	loadingMessage = document.getElementById('progress');
	distanceMessage = document.getElementById('distanceMessage');
	speedMessage = document.getElementById("speedMessage");
	timeMessage = document.getElementById('timeMessage');

	if (GBrowserIsCompatible()) {
		map = new GMap2(document.getElementById("gmap"));
		map.setCenter(new GLatLng(geoip_latitude, geoip_longitude), 14);

		map.setMapType(G_SATELLITE_MAP);

		map.addControl(new GLargeMapControl());
		map.addControl(new GMapTypeControl());

	}
}


function plotPoint()
{
	if (i < markers.length )
	{
		var Lat = markers[i].position.lat;
		var Lng = markers[i].position.lon;
	
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

		var point = new GLatLng(Lat, Lng);
		
		if (i < markers.length - 1){
			window.setTimeout(plotPoint,timeOut);
			calculateTime(i);
			averageSpeed = Math.round((distance / (totalTime/3600))*100)/100;
			var minutesSoFar = totalTime / 60;
			var currentPace = minutesSoFar / distance;
			//speedMessage.innerHTML = '每英里耗时:'+displayMinutes(currentPace);
			speedMessage.innerHTML = '平均速度:'+averageSpeed+'公里/小时 ';
		}

		marker = createMarker(point,i,markers.length);
	
		if (i < markers.length && i != 0)
		{
			
			var Lat1 = markers[i-1].position.lat;
			var Lng1 = markers[i-1].position.lon;
				
					
			var point1 = new GLatLng(Lat1, Lng1);

			var points=[point, point1];
			
			//RECENTER MAP EVERY TEN POINTS
			if (i%3==0)
			{
				map.panTo(point);
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

	icon.iconAnchor = new GLatLng(34, 10);    
	icon.infoWindowAnchor = new GLatLng(5, 9);
						
	if (i == 0 ){
		checkPoints[currentCheckPoint] = {
			timestamp: markers[i].time
		};
		map.setCenter(point, 15,G_HYBRID_MAP);
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
		map.panTo(point, 2000);
		return marker;
	}		

	if (checkPointDistance - checkPoint >= 0 && checkPoint != 0){
		currentCheckPoint = currentCheckPoint + 1;
		checkPoints[currentCheckPoint] = {
			timestamp: markers[i].time
		};

		var thisCheckPointDuration = getTimeBetweenCheckPoints(checkPoints[currentCheckPoint-1].timestamp,checkPoints[currentCheckPoint].timestamp);
		var thisCheckPoint = currentCheckPoint;
		var lastMileMinutes = thisCheckPointDuration / 60;
		var mileTime = displayMinutes(lastMileMinutes);
		var timeSpan1=timeSpan;
		lastMileMinutes1=lastMileMinutes;

		var img_id=thisCheckPoint>39?0:thisCheckPoint;
		if (lastMileMinutes < 2) {
			icon.image = "media/images/red" + img_id + ".png";
		} else {
			icon.image = "media/images/green" + img_id + ".png";
		}
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
function secondsBetweenDates(first_date,second_date) {
	//begin year/month/day
	var largeDate = second_date.toString().split(" ");
	var date = largeDate[0];
	date = date.split("-");
	var beforeYear = date[0];
	var beforeDay = date[2];
	//beforeDay = beforeDay.replace("0","");
	var beforeMonth = date[1];
	//beforeMonth = beforeMonth.replace("0","");

	//end year/month/day
	var largeDate1 = first_date.toString().split(" ");
	var date1 = largeDate1[0];
	date1 = date1.split("-");
	var afterYear = date1[0];
	var afterDay = date1[2];
	//afterDay = afterDay.replace("0","");
	var afterMonth = date1[1];
	//afterMonth = afterMonth.replace("0","");

	//begin hour/min/seconds
	var after = largeDate[1].replace(" ","");
	after = largeDate[1].replace(" ","");	

	afterArray = after.split(":");
	var hour = afterArray[0];
	var minute = afterArray[1];
	var second = afterArray[2];

	//end hour/min/seconds
	var after1 = largeDate1[1].replace(" ","");
	after1 = largeDate1[1].replace(" ","");	

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
		startTime = markers[0].time
	}

	var current_timestamp = markers[i].time

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
jQuery(function($){
	initialize();
	$("a.track").each(function(){
		$(this).css("cursor","pointer").click(function(){
			$.getJSON("load?key="+$(this).attr('id'), function(json){
				//alert("JSON Data: " + json[0].position.lat);
				markers = json
				plotPoint()
			});
		});
	});
});
jQuery(window).unload(GUnload());