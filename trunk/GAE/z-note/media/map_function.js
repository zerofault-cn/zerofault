var map; //GMap2 对象

var points; //轨迹点集合,json格式

var timeOut = 500; //初始的轨迹行进延时时间
var TO; //setTimeOut返回值，用于暂停和继续操作
var i = 0;
var currentCheckPoint = 0;//当前标注点
var checkPoints = new Array();//所有标注点
var checkPointCount = 1;

// for display
var loadingMessage;
var distanceMessage;
var speedMessage;
var timeMessage;

// for distance calculations
var distance = 0;
var checkPoint = 1; //公里标记单位，默认1公里一个标记
var checkPointDistance = 0;
var coordinateCount = 0;

var lastLat;
var lastLon;
var lastMileMinutes1;//上一英里耗时
// for time calculations
var totalTime = 0;
var startTime = 0;
var timeSpan=0;//已耗时间

//一组google提供的ICON
var baseIcon = new GIcon();
baseIcon.shadow = "http://labs.google.com/ridefinder/images/mm_20_shadow.png";
baseIcon.iconSize = new GSize(24, 38);
baseIcon.shadowSize = new GSize(40, 38);
baseIcon.iconAnchor = new GPoint(10, 34);
baseIcon.infoWindowAnchor = new GPoint(9, 5);
var icon_Green= new GIcon(baseIcon);
icon_Green.image = "http://labs.google.com/ridefinder/images/mm_20_green.png";
var icon_Blue= new GIcon(baseIcon);
icon_Blue.image = "http://labs.google.com/ridefinder/images/mm_20_blue.png";
var icon_Red= new GIcon(baseIcon);
icon_Red.image = "http://labs.google.com/ridefinder/images/mm_20_red.png";

//自定义的汽车图标
var icon_car=new GIcon();
icon_car.image='media/target.png';
icon_car.iconSize=new GSize(16,16);

var playing = false; //是否在播放中
var paused = false; //是否已暂停

var geoip_latitude = 30.206935;
var geoip_longitude = 120.212853;
function initialize() {
	loadingMessage = document.getElementById('progress');
	distanceMessage = document.getElementById('distanceMessage');
	speedMessage = document.getElementById("speedMessage");
	timeMessage = document.getElementById('timeMessage');

	if (GBrowserIsCompatible()) {
		map = new GMap2(document.getElementById("gmap"));
		map.setMapType(G_SATELLITE_MAP);//设置地图类型：卫星地图（注，大陆地区的街道地图与卫星地图存在错位）
		//map.addControl(new GSmallZoomControl());//仅有放大和缩小两个控制按钮
		//map.addControl(new GOverviewMapControl());//在右下角创建可折叠的迷你型概览地图
		map.enableScrollWheelZoom(); //鼠标滚轮缩放
		map.enableContinuousZoom();
		//map.addControl(new GMapTypeControl());

		$.getJSON("getloc", function(json){
			geoip_latitude = json.location.latitude;
			geoip_longitude = json.location.longitude;
		});
		
		var init_point = new GLatLng(geoip_latitude, geoip_longitude);
		map.setCenter(init_point, 16);
		
		var init_marker = new GMarker(init_point);
		map.addOverlay(init_marker);
		GEvent.addListener(init_marker, "click", function(){
			init_marker.openInfoWindowHtml("您现在的位置！");
		});
	}
}

function plotPoint()
{
	if (i < points.length )
	{
		var Lat = points[i].point.lat;
		var Lng = points[i].point.lon;
		var point = new GLatLng(Lat, Lng);
		
		if (i < points.length - 1){
			TO = window.setTimeout(plotPoint,timeOut);
			calculateTime(i);
			if(parseInt(points[i].elevation)>0) {
				$("#currentElevation").html('当前海拔：'+points[i].elevation+' 米（数据由GPS设备提供）');
			}
			if(parseInt(points[i].speed)>0) {
				$("#currentSpeed").html('当前速度：'+points[i].speed+' 公里/小时（数据由GPS设备提供）');
			}
			var averageSpeed = Math.round((distance / (totalTime/3600))*100)/100;
			var minutesSoFar = totalTime / 60;
			var currentPace = minutesSoFar / distance;//每公里耗时多少分钟
			
			$("#averageSpeed").html('平均速度：'+averageSpeed+' 公里/小时');
		}
		else{
			playing = false;
			$("input#pause").attr('disabled',true);
		}

		var marker = createMarker(point,i);
		if(i == 0) {
			lastLat = Lat;
			lastLon = Lng;
		}
		if (i != 0) {
			var Lat1 = lastLat;//points[i-1].position.lat;
			var Lng1 = lastLon;//points[i-1].position.lon;
			var point1 = new GLatLng(Lat1, Lng1);
			var poly=[point, point1];

			lastLat = Lat;
			lastLon = Lng;
			
			if (i%2==0)
			{
				map.panTo(point);
			}

			if (i < points.length/2)
			{
				map.addOverlay(new GPolyline(poly, "#0000ff",3,1));
			}
			else
			{
				map.addOverlay(new GPolyline(poly, "#ff0000",3,1));
			}
/*
			if (lastMileMinutes1 > 10)
			{
				map.addOverlay(new GPolyline(poly, "#ff0000",3,1));
			}
			else
			{
				map.addOverlay(new GPolyline(poly, "#0000ff",3,1));
			}
*/		
			calculateDistance(Lng, Lat, Lng1, Lat1);
		}
		
		loadingPercentage(i);
		$("#distance").html('已&nbsp;行&nbsp;驶：'+Math.round(distance*100)/100 + " 公里");
		i += 1;
		i = Math.min(points.length,i);
	}
}
// GET THE APPROPRIATE MARKER FOR START, FINISH, CHECKPOINT, AND LINE
function createMarker(point, i) {
	if (i == 0 ){
		checkPoints[currentCheckPoint] = {
			timestamp: points[i].time
		};
		map.panTo(point);
		
		var marker = new GMarker(point,icon_Green);
		map.addOverlay(marker);
		GEvent.addListener(marker, "click", function(){
			marker.openInfoWindowHtml("启程！<br />时间："+points[i].time);
			});
		return marker;
	}
	else if(i == points.length -1){
		var marker = new GMarker(point,icon_Red);
		map.addOverlay(marker);
		GEvent.addListener(marker, "click", function(){
			marker.openInfoWindowHtml("到达！<br />时间："+points[i].time);
			});
		map.panTo(point);
		return marker;
	}

	if (checkPointDistance - checkPoint >= 0 && checkPoint != 0) {
		currentCheckPoint = currentCheckPoint + 1;
		checkPoints[currentCheckPoint] = {
			timestamp: points[i].time
		};

		var thisCheckPointDuration = getTimeBetweenCheckPoints(checkPoints[currentCheckPoint-1].timestamp,checkPoints[currentCheckPoint].timestamp);
		var thisCheckPoint = currentCheckPoint;
		var lastMileMinutes = thisCheckPointDuration / 60;
		var mileTime = displayMinutes(lastMileMinutes);
		var timeSpan1=timeSpan;
		lastMileMinutes1=lastMileMinutes;

		var icon = new GIcon(baseIcon);
		var img_id=thisCheckPoint>39?0:thisCheckPoint;
		if (lastMileMinutes < 2) {
			icon.image = "media/images/red" + img_id + ".png";
		}
		else {
			icon.image = "media/images/green" + img_id + ".png";
		}
		var distance1 = checkPointDistance;
		var marker = new GMarker(point,icon);
		map.addOverlay(marker);
		GEvent.addListener(marker, "click", function() {
			marker.openInfoWindowHtml("行程: " + thisCheckPoint + "公里<br>前1公里耗时:" + mileTime+'<br>行驶时间:'+timeSpan1);
			});
		checkPointDistance = 0;
		checkPointCount += 1;
	}
	else{
		marker = new GMarker(point);
	}
	return marker;
}
function getTimeBetweenCheckPoints(lastCheckPoint,thisCheckPoint) {
	var secondsBetween = secondsBetweenDates(lastCheckPoint,thisCheckPoint);
	return secondsBetween;
}

function secondsBetweenDates(first_date,second_date) {
	//begin year/month/day
	var largeDate = second_date.split(" ");
	var date = largeDate[0];
	date = date.split("-");
	var beforeYear = date[0];
	var beforeMonth = date[1];
	var beforeDay = date[2];
	
	//end year/month/day
	var largeDate1 = first_date.split(" ");
	var date1 = largeDate1[0];
	date1 = date1.split("-");
	var afterYear = date1[0];
	var afterMonth = date1[1];
	var afterDay = date1[2];
	
	//begin hour/min/seconds
	var after = largeDate[1];
	afterArray = after.split(":");
	var hour = afterArray[0];
	var minute = afterArray[1];
	var second = afterArray[2];

	//end hour/min/seconds
	var after1 = largeDate1[1];
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
// LOADING BAR //
function loadingPercentage(currentPoint){
	var percentage = Math.round((currentPoint/(points.length - 1)) * 100);
	loadingMessage.style.width = percentage +"%";
	$("#progressMsg").html('播放进度：'+percentage +"%");
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
function calculateTime(i) {
	if (startTime == 0) {
		startTime = points[0].time
	}

	var current_timestamp = points[i].time

	var secondsBetween = secondsBetweenDates(startTime,current_timestamp);
	totalTime = secondsBetween;
	timeSpan=convertSeconds(secondsBetween);
	$("#timespan").html('行驶时间：'+timeSpan);

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
function changeSpeed() {
	timeOut = 1001-parseInt($('input#speed').val());
	clearTimeout( TO );
	TO = window.setTimeout(plotPoint,timeOut);

}
function getlist() {
	$.get('getlist?'+Math.random(),{},function(str){
		$("#controller").html(str);
		if(str.length==0) {
			return;
		}
		form_widget_amount_slider('slider_speed',document.getElementById('speed'),300,1,1000,"changeSpeed()");
		$("input#play").click(function(){
			if(''==$("select#key").val()) { 
				alert('未选择行动轨迹');
				return;
			}
			$.getJSON("load?key="+$("select#key").val(), function(json){
				TO = null;
				playing = false;
				paused = false;
				i = 0;
				currentCheckPoint = 0;
				checkPoints = new Array();
				checkPointCount = 1;
				distance = 0;
				checkPointDistance = 0;
				coordinateCount = 0;
				lastMileMinutes1 = 0;
				totalTime = 0;
				startTime = 0;
				timeSpan = 0;
				map.clearOverlays();
				points = json;
				timeOut = 1001-parseInt($('input#speed').val());
				plotPoint();
				playing = true;
				$("input#pause").val('暂停').attr('disabled',false);
			});
		});

		$("input#pause").click(function(){
			if(playing && !paused) {
				clearTimeout( TO );
				$(this).val('继续');
				paused = true;
			}
			else if(playing && paused){
				TO = window.setTimeout(plotPoint,timeOut);
				$(this).val('暂停');
				paused = false;
			}
		});
		$("input#delete").click(function(){
			$.get("delete",{
				'key':$("select#key").val()
			},function(str){
					if(str=='1') {
						alert('删除成功!');
						getlist();
					}
					else{
						alert('删除失败');
					}
				});
		});
		$("input#pub").click(function(){
			$.get("set",{
				'key' : $("select#key").val(),
				'private' : 0
			},function(str){
					if(str=='1') {
						alert('设置成功!');
						getlist();
					}
					else{
						alert('设置失败');
					}
				});
		});
		$("input#hold").click(function(){
			$.get("set",{
				'key' : $("select#key").val(),
				'private' : 1
			},function(str){
					if(str=='1') {
						alert('设置成功!');
						getlist();
					}
					else{
						alert('设置失败');
					}
				});
		});
		$("select#key").change(function(){
			if($("select#key").val() && playing) {
				if(!paused) {
					clearTimeout( TO );
					$("input#pause").val('继续');
					paused = true;
				}
			}
			if($("select#key option:selected").attr('id')){
				$("input#delete").show();
				if($("select#key option:selected").attr('id')=='True'){
					$("input#pub").show();
				}
				else{
					$("input#hold").show();
				}
			}
		});
	});
}
jQuery(function($){
	initialize();
	
	getlist();
	$("input#upload").click(function(){
		$.ajaxFileUpload({
			url:'/upload?'+Math.random(), 
			secureuri:false,
			fileElementId:'data',
			dataType: 'text',
			success: function (data, status)
			{
				if(data=='1'){
					alert('上传成功！');
					getlist();
				}
				else{
					//alert('上传失败!<br />'+data);
					var oNewWin = window.open("about:blank","_blank");
					oNewWin.document.open();
					oNewWin.document.write(data);
					oNewWin.document.close();


				}
			},
			error: function (data, status, e)
			{
				alert(e);
			}
		});
	});
});
jQuery(window).unload(GUnload());