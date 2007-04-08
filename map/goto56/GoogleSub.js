function CreateGoogleMap() {    
    document.googleMap=new Object ();    
    document.googleMap.Map=function()
    {        
        return map;        
    } 
 
    document.googleMap.openInfoWindow=function(x,y,html)
    {    
        div=document.createElement("div");
        div.innerHTML=html;
        var point = new GPoint(x,y);
        map.openInfoWindow(point,div);   
    }  
    document.googleMap.createUrlMarker=function(x,y,url,w,h)
    {                     
        html="<iframe allowtransparency='true' frameborder='no' scrolling='no' width={0} height={1} src='{2}'></iframe>";
        html=html.replace("{0}",w );  
        html=html.replace("{1}",h  );  
        html=html.replace("{2}",url  );  
        
        point=new GPoint(x,y);
        var marker = new GMarker(point);
        map.addOverlay(marker);
        marker.html=html;
        GEvent.addListener(marker, 'click', function() {
          document.googleMap.curMarker=marker; 

          marker.openInfoWindowHtml(marker.html);
        });        
    } 
    document.googleMap.removeCurMarker=function()
    {
         map.removeOverlay(document.googleMap.curMarker);
    }
    document.googleMap.ShowDialogOnClick=function(width,height,url,callback)
    {            
        mapdialog.url=url;
        mapdialog.width=width;
        mapdialog.height =height;
         
        html="<iframe allowtransparency='true' frameborder='no' scrolling='no' width={0} height={1} src='{2}&x={3}&y={4}'></iframe>";
        html=html.replace("{0}",mapdialog.width );  
        html=html.replace("{1}",mapdialog.height  );  
        html=html.replace("{2}",mapdialog.url  );  
        point=map.getCenterLatLng();
        html=html.replace("{3}",point.x   );  
        html=html.replace("{4}",point.y   );  
        div=document.createElement("div");
        div.innerHTML=html;                        
        map.openInfoWindow(point,div);  
		
		if(mapdialog.listener)
		{
            GEvent.removeListener(mapdialog.listener );
            mapdialog.callback=null;
        }	
          			         
        if(typeof(callback) != 'undefined'	 )	    
	    {
	        mapdialog.callback=callback;
	    }	
	    else
	         mapdialog.callback =null;			     
       mapdialog.listener=GEvent.addListener(this.Map(), 'click', function (overlay,point)
        {
            html="<iframe allowtransparency='true' frameborder='no' scrolling='no' width={0} height={1} src='{2}&x={3}&y={4}'></iframe>";
            html=html.replace("{0}",mapdialog.width );  
            html=html.replace("{1}",mapdialog.height  );  
            html=html.replace("{2}",mapdialog.url  );  
            html=html.replace("{3}",point.x   );  
            html=html.replace("{4}",point.y   );  
            div=document.createElement("div");
            div.innerHTML=html;                        
            map.openInfoWindow(point,div);        
        });
    } 
    document.googleMap.CloseDialogOnClick=function()
    {  
        try 
        {
            if(mapdialog.callback!=null)
                    mapdialog.callback();
            if(mapdialog.listener)
            {
                GEvent.removeListener(mapdialog.listener );
                mapdialogcallback=null;
            }
            mapdialog.listener =null;  
        }
        catch(error)
         {
        }
　　}
　　//**************************************
　　document.googleMap.GPoint=function(x,y)
    {                
       return new GPoint(x,y);
    } 
    document.googleMap.GPolyline=function(pts,pa1,pa2)
    {                
       return new GPolyline(pts,pa1,pa2);
    }
    document.googleMap.centerAndZoom=function (x,y,zoom)
    {
        map.centerAndZoom(new GPoint(x, y), zoom);       
    }
    document.googleMap.setCentor=function (x,y)
    {
        map.centerAtLatLng(new GPoint(x, y));       
    }
    
　　document.googleMap.OnMapClick=function(fc)
    {   
        if(mapdialog.listener)
            GEvent.removeListener(mapdialog.listener );                               
        mapdialog.listener=GEvent.addListener(this.Map(), 'click', fc);
    } 
    document.googleMap.createMarker=function(x,y,html)
    {           
        point=new GPoint(x,y);
        var marker = new GMarker(point);
        map.addOverlay(marker);
        marker.html=html;
        GEvent.addListener(marker, 'click', function() {
         marker.openInfoWindowHtml(marker.html);
        });
    }
    document.googleMap.clearOverlays=function()
    {           
       map.clearOverlays();
    }
}
var mapdialog=new Mapdialog();
function Mapdialog()
{
    this.callback=null;
    this.url="";
    this.width=0;
    this.height=0; 
    this.listener=null;       
}    



 
