/*
 * Create GoogleMap WMS (transparent) layers on any GoogleMap.
 *
 * Just van den Broecke - just AT justobjects.nl - www.justobjects.nl - www.geoskating.com
 * version: $Id: gmap-wms.js,v 1.6 2005/09/16 21:29:20 just Exp $
 *
 * This (experimental) code can be downloaded from
 * http://www.geoskating.com/gmap/gmap-wms.js
 * Examples in http://www.geoskating.com/gmap
 * This code may break when Google changes the Google Maps API!!
 *
 * LICENSE
 * Free for any use as long as label in map is preserved ;)
 *
 * CREDITS
 * This code is based on and inspired by:
 * Brian Flood - http://www.spatialdatalogic.com/cs/blogs/brian_flood/archive/2005/07/11/39.aspx and
 * Kyle Mulka - http://blog.kylemulka.com/?p=287
 * I have merely merged the two approaches taken by each of these great minds !
 *
 * EXAMPLE
 *   // Fake WMS server to be used for overlaying map with transparent GIF
 *   // Use a real WMS server here.
 *   var WMS_URL_ROUTE='http://www.geoskating.com/gmap/route-wms.jsp?';
 *
 *   // Create WMSSpec
 *   // need: wmsURL, gName, gShortName, wmsLayers, wmsStyles, wmsFormat, [wmsVersion], [wmsBgColor], [wmsSrs]
 *   var G_MAP_WMS_SPEC = createWMSSpec(WMS_URL_ROUTE, "MyWMS", "MyWMS", "routes", "default", "image/gif", "1.0.0");
 *
 *   // Use WMSSpec to create transparent overlay on a standard Google MapSpec
 *   var G_MAP_WMS_OVERLAY_SPEC = createWMSOverlaySpec(G_SATELLITE_TYPE, G_MAP_WMS_SPEC, "MyOvWMS", "MyOvWMS");
 *
 *   // Create mapspecs array
 *   var mapSpecs = [];
 *   mapSpecs.push(G_SATELLITE_TYPE);
 *   mapSpecs.push(G_MAP_WMS_SPEC);
 *   mapSpecs.push(G_MAP_WMS_OVERLAY_SPEC);
 *
 *   // Setup the map
 *   var map = new GMap(document.getElementById("map"), mapSpecs);
 *   map.addControl(new GMapTypeControl());
 *   map.addControl(new GSmallMapControl());
 *   map.setMapType(G_SATELLITE_TYPE);
 *   map.centerAndZoom(new GPoint(4.9, 52.35), 10);
 */


/** Create WMS type spec as a GMap Spec. */
function createWMSSpec(wmsURL, gName, gShortName, wmsLayers, wmsStyles, wmsFormat, wmsVersion, wmsBgColor, wmsSrs) {
  // Copy all GMap-spec object members (attrs+functions)
  var wmsSpec = new GGoogleMapMercSpec();

  // Override GmapSpec-specific attrs (not future-proof!)
  wmsSpec.Name = gName;
  wmsSpec.ShortName = gShortName;

  // Set internal WMS parameters
  wmsSpec.wmsURL = wmsURL;
  wmsSpec.wmsLayers = wmsLayers;
  wmsSpec.wmsStyles = wmsStyles;
  wmsSpec.wmsFormat = wmsFormat;

  // Optional projection/datum
  wmsSpec.wmsVersion = (wmsVersion ? wmsVersion : "1.1.1");
  wmsSpec.wmsBgColor = (wmsBgColor ? wmsBgColor : "0xFFFFFF");
  wmsSpec.wmsSrs = (wmsSrs ? wmsSrs : "EPSG:4326");
  wmsSpec.wmsTransparent = "TRUE"; // ?? should be made optional parm ??

  // Override GmapSpec function: no overlay here.
  wmsSpec.hasOverlay = function () {
    return false;
  };

  // Override GmapSpec function: Gets URL for map tile image
  wmsSpec.getTileURL = function (x, y, zoom){
    var ts = this.tileSize;
    var ul = this.getLatLng(x*ts,(y+1)*ts, zoom);
    var lr = this.getLatLng((x+1)*ts,y*ts, zoom);
    var bbox = ul.x + "," + ul.y + "," + lr.x + "," + lr.y;
    var url = this.wmsURL + "VERSION=" + this.wmsVersion + "&REQUEST=GetMap&LAYERS=" + this.wmsLayers + "&STYLES=" + this.wmsStyles + "&SRS="+ this.wmsSrs + "&BBOX=" + bbox + "&WIDTH=" + ts +"&HEIGHT=" + ts + "&FORMAT=" + this.wmsFormat + "&TRANSPARENT=" + this.wmsTransparent + '&EXCEPTIONS=INIMAGE&'+'&x='+x+'&y='+y+'&zoom='+zoom;
    return url;
   };

  wmsSpec.getLinkText = function() {
    return this.Name;
  };

  wmsSpec.getShortLinkText = function() {
    return this.ShortName;
  };

  wmsSpec.getCopyright = function() {
    return SIG;
  };

  return wmsSpec;
}

/** Create transparent WMS overlay layer on standard GMap Spec. */
function createWMSOverlaySpec(gSpec, wmsSpec, gName, gShortName) {
  // New object
  var overlaySpec = new Object();
  // Override with members of wmsSpec
  for (var m in wmsSpec) {
    overlaySpec[m] = wmsSpec[m];
  }

  // Copy all GMap-spec (e.g. G_SATELLITE_TYPE) object members (attrs+functions)
  for (var m in gSpec) {
    overlaySpec[m] = gSpec[m];
  }

  // Override GmapSpec-specific attrs (not future-proof!)
  overlaySpec.Name = gName;
  overlaySpec.ShortName = gShortName;

  // Override GmapSpec function: Having overlay is the whole purpose!
  overlaySpec.hasOverlay = function () {
    return true;
  };

  // Override GmapSpec function: Gets URL for overlayed tile
  overlaySpec.getOverlayURL = wmsSpec.getTileURL;

  overlaySpec.getLinkText = wmsSpec.getLinkText;

  overlaySpec.getShortLinkText = wmsSpec.getShortLinkText;

  overlaySpec.getCopyright = function() {
   return SIG;
  };

  return overlaySpec;
}
var SIG='';


