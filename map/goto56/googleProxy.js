function googleMap()
{    
    return parent.document.googleMap
}
function refresh()
{
    window.location = window.location ;
}
function ShowMsgOnMap(x,y,msg)
{
   googleMap().setCentor(x,y);
   googleMap().openInfoWindow(x,y,msg);
}
function ShowMsgOnMap1(msg)
{
   googleMap().openInfoWindow(114.07001,22.53191,msg);
}
function ShowMsgOnBestPlace(msg)
{
   googleMap().centerAndZoom(114.07001,22.53191,0);
   googleMap().openInfoWindow(114.07001,22.53191,msg);
}
function showMobileInfo(x,y,deviceID,boradNum,speed,phonenum)
{
    msg="<span style ='color :red '>���ƺţ�</span><span>"+boradNum+"</span><br>";
    msg += "<image src=/gps/images/car.jpg> <br/><hr width=200px>";
    msg+="<span style ='color :green '>GPS�豸�ţ�</span>"+deviceID+"<br/>";
    msg+="<span style ='color :green '>��ǰ�ٶȣ�</span>"+speed+"<br/>";  
    msg+="<span style ='color :green '>��ϵ�绰��</span>"+phonenum+"<br/>";   
    googleMap().openInfoWindow(x,y,msg);   
}
function createMarker(x,y,html)
{
     googleMap().createMarker(x,y,html);
}
function createUrlMarker(x,y,url,w,h)
{
     googleMap().createUrlMarker(x,y,url,w,h);
}

function clearOverlays()
{
    googleMap().clearOverlays();
}
function removeCurMarker()
{
    googleMap().removeCurMarker();
}