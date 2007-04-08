var _mSiteName = 'Google Local';
var _mZoomIn = 'Zoom In';
var _mZoomOut = 'Zoom Out';
var _mZoomSet = 'Click to set zoom level';
var _mZoomDrag = 'Drag to zoom';
var _mPanWest = 'Go left';
var _mPanEast = 'Go right';
var _mPanNorth = 'Go up';
var _mPanSouth = 'ÏòÏÂ';
var _mLastResult = 'Return to the last result';
var _mGoogleCopy = '&#169;2005 Google';
var _mDataCopy = 'Map data &#169;2005 ';
var _mNavteq = 'NAVTEQ&#8482;';
var _mTeleAtlas = 'Tele Atlas';
var _mZenrin = 'ZENRIN';
var _mZenrinCopy = 'Map &#169;2005 ';
var _mNormalMap = 'Map';
var _mNormalMapShort = 'Map';
var _mHybridMap = 'Hybrid';
var _mHybridMapShort = 'Hyb';
var _mNew = 'New!';
var _mTerms = 'Terms of Use';
var _mKeyholeMap = 'Satellite';
var _mKeyholeMapShort = 'Sat';
var _mKeyholeCopy = 'Imagery &#169;2005 ';
var _mScale = 'Scale at the center of the map';
var _mKilometers = 'km';
var _mMiles = 'mi';
var _mMeters = 'm';
var _mFeet = 'ft';
var _mDecimalPoint = '.';
var _mThousandsSeparator = ',';
var _mMapErrorTile = 'We are sorry, but we don\'t have maps at this zoom level for this region.<p>Try zooming out for a broader look.</p>';
var _mKeyholeErrorTile = 'We are sorry, but we don\'t have imagery at this zoom level for this region.<p>Try zooming out for a broader look.</p>';
var _mTermsURL = 'http://www.google.com/intl/en_ALL/help/terms_local.html';
var _mStaticPath = 'http://www.google.com/intl/en_ALL/mapfiles/';
var _mDomain = 'google.com';
var _apiHash = '5f87579ff86792cf982d095a4228e3de6cdaf562';
var _apiKey = 'ABQIAAAA7nPTPXCvzWYxyKdmbFQfTxRfh1ef-GeSz5gtCVpCKOPebNr1YhR23M_jRfeqAugNMsW3pZQJAwfCFw';
var _mApiBadKey = 'The Google Maps API key used on this web site was registered for a different web site. You can generate a new key for this web site at http://www.google.com/apis/maps/.';
function createMapSpecs() 
{
	var mt = 'http://mt%1$d.google.com/mt?n=404';
	var mtd = '4';
	var tv = 'w2.9';
	var lrtv = 't2.2';
	var apitv = 'ap.4';
	var lrapitv = 'tap.2';
	var hmt = 'http://mt%1$d.google.com/mt?n=404';
	var hmtd = '4';
	var htv = 'w2t.4';
	var lrhtv = 't2t.2';
	var apihtv = 'apt.3';
	var lrapihtv = 'tapt.2';
	var kmt = 'http://kh%1$d.google.com/kh?n=404';
	var kmtd = '4';
	var kdomain = 'google.com';
	var ktv = '3';
	var kdisable = false;
	var khauth = 'fzwq2tTFhLHFZ74U5ckS9FFkL2Y9qcJ7BtNUYQ';
	var kjapandatumhack = false;
	var hybrid = (htv != '');
	if (!arguments.callee.mapSpecs) 
	{
		var mapSpecs = [];
		var tileVersion = window._apiKey ? apitv : tv;
		var lrTileVersion = window._apiKey ? lrapitv : lrtv;
		var hTileVersion = window._apiKey ? apihtv : htv;
		var lrHTileVersion = window._apiKey ? lrapihtv : lrhtv;
		var mapCopy = (tileVersion != tv) ? G_MAP_API_COPYRIGHTS :G_MAP_DEFAULT_COPYRIGHTS;
		var hybridCopy = (hTileVersion != htv) ? G_MAP_API_COPYRIGHTS :G_MAP_DEFAULT_COPYRIGHTS;_GOOGLE_MAP_TYPE = new _GoogleMapMercSpec(mt, mtd, tileVersion, mapCopy,lrTileVersion);mapSpecs.push(_GOOGLE_MAP_TYPE);
		if (!kdisable) 
		{
			_SATELLITE_TYPE = new _KeyholeMapMercSpec(kmt, kmtd, kdomain, ktv,khauth, kjapandatumhack);mapSpecs.push(_SATELLITE_TYPE);
			if (hybrid)
			{
				_HYBRID_TYPE = new _HybridMapSpec(kmt, kmtd, kdomain, ktv, khauth,kjapandatumhack, hmt, hmtd,hTileVersion, hybridCopy,lrHTileVersion);mapSpecs.push(_HYBRID_TYPE);
			}
		}
		arguments.callee.mapSpecs = mapSpecs;
	}
	return arguments.callee.mapSpecs;
}
var _u = navigator.userAgent.toLowerCase();
function _ua(t)
{
	return _u.indexOf(t) != -1;
}
function _uan(t)
{
	if(!window.RegExp)
	{
		return 0;
	}
	var r = new RegExp(t+'([0-9]*)');
	var s = r.exec(_u);
	var ret = 0;
	if (s.length >= 2)
	{
		ret = s[1];
	}
	return ret;
}

function _noActiveX()
{
	if(!_ua('msie') || !document.all || _ua('opera'))
	{
		return false;
	}
	var s = false;
	eval('try { new ActiveXObject("Microsoft.XMLDOM"); }'+'catch (e) { s = true; }');
	return s;
}

function _compat()
{
	return ((_ua('opera') &&parseInt(new RegExp("opera.(\\d+)").exec(_u)[1]) > 7 ) ||(_ua('safari') && _uan('safari/') >= 125) ||(_ua('msie') &&!_ua('msie 4') && !_ua('msie 5.0') && !_ua('msie 5.1') &&!_ua('msie 3') && !_ua('msie 5.5') && !_ua('powerpc')) ||(document.getElementById && window.XSLTProcessor &&window.XMLHttpRequest && !_ua('netscape6') &&!_ua('netscape/7.0')));
}
_fc = false;
_c = _fc || _compat();
function _browserIsCompatible()
{
	return _c;
}

function GBrowserIsCompatible()
{
	return _c;
}
function _havexslt()
{
	if (typeof GetObject != 'undefined' ||(typeof XMLHttpRequest != 'undefined' &&typeof DOMParser != 'undefined' &&typeof XSLTProcessor != 'undefined')) 
	{
		return true;
	}
	else 
	{
		return false;
	}
}

function _script(src)
{
	var src_name = src.split("/").pop();var aTimer = '<'+'script type="text/javascript">' +'if (typeof TS_load_timers == "object") ' +'TS_load_timers.start("load '+src_name+'", "glm_'+src_name+'");' +'<'+'/script>';document.write(aTimer);var ret='<'+'script src="'+src+'"'+' type="text/javascript"><'+'/script>';document.write(ret);aTimer = '<'+'script type="text/javascript">' +'if (typeof TS_load_timers == "object") TS_load_timers.end();' +'<'+'/script>';document.write(aTimer);
}
function GLoadMapsScript()
{
	if (_havexslt()){_script("http://maps.google.com/mapfiles/maps.30a.js");} else if (_ua('safari')){_script("http://maps.google.com/mapfiles/maps.30a.safari.js");} else{_script("http://maps.google.com/mapfiles/maps.30a.xslt.js");}
}
if (_c && !_noActiveX())
{
	document.write('<style type="text/css" media="screen">.noscreen {display: none}</style>');document.write('<style type="text/css" media="print">.noprint {display: none}</style>');GLoadMapsScript();
}