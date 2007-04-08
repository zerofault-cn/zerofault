 // for the map
 var map;
 var markers;
 var marker;
 var timeOut = 1000;  // length to wait till next point is plotted
 var i = 0;
 var currentCheckPoint = 0;
 var checkPoints = new Array();
 
 // for display
 var loadingMessage;
 var distanceMessage;
 var speedMessage;
 var timeMessage;
 var bRowColor = false;
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

 
 // for time calculations
 var currentTime = 0;
 var lastTime = 0;
 var totalTime = 0;
 var startTime = 0;
 
 // for speed calculations
 var averageSpeed;

// CREATE MAP & DISPLAY CONTROLS AND STARTING LOCATION //
function onLoad() {

	var map_node = document.getElementById("map");
	map_node.innerHTML = "";
	// kill if safari
	var detect = navigator.userAgent.toLowerCase();
	if((detect.indexOf("safari") + 1)) {
        alert("This currently crashes Safari.  We apologize, and are working on a fix.  Can you try Firefox?")
    }
	else {
    loadingMessage = document.getElementById('progress');
	distanceMessage = document.getElementById('distanceMessage');
	speedMessage = document.getElementById("speedMessage");
	timeMessage = document.getElementById('timeMessage');
	map = new GMap(document.getElementById("map"));
	var mapid = getMapType();
	var mapType = map.getMapTypes()[1];
	if (mapid) {
		mapType = map.getMapTypes()[mapid];
	}
	map.setMapType(mapType);
	var control = new GSmallMapControl();
		
	map.addControl(control);
	map.addControl(new GMapTypeControl());

	loadInfo();
	}
}

function initCheckpoint(){
checkPoint = 1
}

function startOver(opt_file,opt_map,opt_zoom) {
	map.clearOverlays();
	loadInfo(opt_file,opt_map,opt_zoom);
}

// LOAD THE XML FILE AND PLOT THE FIRST POINT //
function loadInfo(opt_file,opt_map,opt_zoom){
	markers = null;
	marker = null;
	var request = GXmlHttp.create();
		
	var file = getFileName();
	var fileName = "";
	if (file) {
		fileName = file;
	} else if (opt_file) {
		fileName = opt_file;
	} else {
		fileName = "latest.xml";
	}

	if (opt_map) {
		mapType = map.getMapTypes()[opt_map];
		map.setMapType(mapType);
	}

	var runlink = document.getElementById('runlink');
	var query = location.search.substring(1);
	var args = getArgs();

	if (query) {
		var runfile = args.file;
		var runfile_wo_ext = runfile.replace(/\.xml/,"");
		var runname = args.name;
		runlink.href = "index.html?" + query;
		if (runname) {
			runlink.innerHTML = runname;
		} else {
			runlink.innerHTML = runfile_wo_ext;
		}
	}
	var runkml = document.getElementById('runkml');

	if (args.file) {
		var runfile = args.file;
		var runfile_wo_ext = runfile.replace(/\.xml/,"");
		runkml.href = "data/" + runfile_wo_ext + ".kml";
	}

	request.open("GET", "data/" + fileName, true);
	request.onreadystatechange = function() {
	if (request.readyState == 4) {
		var xmlDoc = request.responseXML;
		markers = xmlDoc.documentElement.getElementsByTagName("Trackpoint");
		plotPoint()
	}
  }
  request.send(null);
}

function plotPoint(){
	if (i < markers.length ) {			
		var Lat = markers[i].getElementsByTagName("Latitude");
		var Lng = markers[i].getElementsByTagName("Longitude");
			
		Lat = Lat[0].firstChild.nodeValue;
		Lng = Lng[0].firstChild.nodeValue;

		if (Lat > latMax) {
			latMax = Lat;
		} else if (Lat < latMin) {
			latMin = Lat;
		}

		if (Lng > longMax) {
			longMax = Lng;
		} else if (Lng < longMin) {
			longMin = Lng;
		}

		latSum = latSum + Lat;
		longSum = longSum + Lat;
		coordinateCount = coordinateCount + 1;

		var point = new GPoint(Lng, Lat);
		
		marker = createMarker(point,i,markers.length);
			
		if (i < markers.length  && i != 0){
			
			var Lat1 = markers[i-1].getElementsByTagName("Latitude");
			var Lng1 = markers[i-1].getElementsByTagName("Longitude");
				
			Lat1 = Lat1[0].firstChild.nodeValue;
			Lng1 = Lng1[0].firstChild.nodeValue;
					
			var point1 = new GPoint(Lng1, Lat1);

			var points=[point, point1];
			
			//RECENTER MAP EVERY TEN POINTS
			if (i%10==0){map.recenterOrPanToLatLng(point, 2000);}
							
			if (i < markers.length/2){
				map.addOverlay(new GPolyline(points, "#0000ff",3,1));
			}
			else{
				map.addOverlay(new GPolyline(points, "#ff0000",3,1));
			}
			calculateDistance(Lng, Lat, Lng1, Lat1)
		}
		
	    loadingPercentage(i);
		distanceMessage.innerHTML=Math.round(distance*100)/100 + " miles";
		
		if (i < markers.length - 1){
			window.setTimeout(plotPoint,timeOut);
			calculateTime(i);
			//averageSpeed = Math.round((distance / (totalTime/3600))*100)/100;
			var minutesSoFar = totalTime / 60;
			var currentPace = minutesSoFar / distance;
			speedMessage.innerHTML = displayMinutes(currentPace) + " min/mile ";
		}
		i++;
	}
}

function centerAtEnd() {
	var avgLat = latSum / coordinateCount;
	var avgLong = longSum / coordinateCount;
	var the_center = new GPoint(avgLong, avgLat);
	map.recenterOrPanToLatLng(the_center, 2000);
}

function displayMinutes(num_seconds,do_alert) {
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

	var displayString = a[0] + ":" + leadingZero(secondsPlace);
	return displayString;
}

function leadingZero(x){
	return (x>9)?x:'0'+x;
}

// GET THE APPROPRIATE MARKER FOR START, FINISH, CHECKPOINT, AND LINE
function createMarker(point, i, markerLength) {

	var icon = new GIcon();
	icon.shadow = "mm_20_shadow.png";
	icon.iconSize = new GSize(24, 38);
	icon.shadowSize = new GSize(22, 20);

	icon.iconAnchor = new GPoint(10, 34);    
	icon.infoWindowAnchor = new GPoint(9, 5);
						
	if (i == 0 ){
		checkPoints[currentCheckPoint] = {
			timestamp: markers[i].getElementsByTagName('Time')[0].firstChild.nodeValue
		};
		map.centerAndZoom(point, 2);
		icon.image = "mm_20_green.png";
		var marker = new GMarker(point,icon);
		map.addOverlay(marker);
		GEvent.addListener(marker, "click", function() {
		marker.openInfoWindowHtml("¿ªÊ¼");});
		return marker;
	} else if(i == markers.length -1){
		icon.image = "mm_20_red.png";
		var marker = new GMarker(point,icon);
		map.addOverlay(marker);
		GEvent.addListener(marker, "click", function() {
		marker.openInfoWindowHtml("½áÊø");});
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
		if (lastMileMinutes < 6.5) {
			icon.image = "images/red" + thisCheckPoint + ".png";
		} else {
			icon.image = "images/green" + thisCheckPoint + ".png";
		}
		var distance1 = checkPointDistance;
		var marker = new GMarker(point,icon);
		map.addOverlay(marker);
		GEvent.addListener(marker, "click", function() {
		marker.openInfoWindowHtml("Distance: " + thisCheckPoint + " mi.<br/>Last Mile " + mileTime);});
		checkPointDistance = 0;
		checkPointCount += 1;
	} else {
		var marker = new GMarker(point, icon);
	}
		
	return marker;
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

function calculateDistance(point1y, point1x, point2y, point2x) {  // Vincenty formula

  traveled = LatLong.distVincenty(new LatLong(point2x, point2y), new LatLong(point1x, point1y));
  traveled = traveled * 0.000621371192;  // Convert to miles from meters

  distance = distance + traveled;
  checkPointDistance = checkPointDistance + traveled;
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
	timeMessage.innerHTML=convertSeconds(secondsBetween); 

}

function convertSeconds(seconds) {
	 //find hours
	 if(seconds > 3600) {
		hours = Math.round(((seconds / 3600)*10)/10) - Math.round((((seconds % 3600)*10)/3600)/10);
		seconds = seconds - (hours * 3600);
		hours += " hrs ";
	 }
	 else {
		hours = "";
	 }
	 //find minutes
	 if(seconds > 60) {
		minutes = Math.round(((seconds / 60)*10)/10) - Math.round((((seconds % 60)*10)/60)/10);
		seconds = seconds - (minutes * 60);
		minutes += " mins ";
	 }
	 else {
		minutes = "";
	 }
	
	return hours + minutes + seconds + " secs ";
}

function getFileName () {
	var args = getArgs();
	return args.file;
}

function getMapType () {
	var args = getArgs();
	return args.map;
}

function getArgs(  ) {
    var args = new Object(  );
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

window.onload = function(){
initCheckpoint();
onLoad();
}
