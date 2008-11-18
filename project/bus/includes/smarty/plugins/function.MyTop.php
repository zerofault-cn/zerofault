<?php
/*
#          File :   ""
#          Type :   ""
#          Name :   ""
#       Version :   "1.0"
#  Created Date :   "May 12, 2005"
# Modified Date :   "May 12, 2005"
#       Include :   ""
#   Global Vars :   ""
#      Template :   ""
#        Author :   "Dio <dio@xodtec.com>"
#        Others :   
#    
*/
function smarty_function_MyTop($params,&$smarty)
{
	$Type		= 'txt';							//txt/image
	$imgID		= 'logopic';
	$WidthIE	= 60;
	$HeightIE	= 25;
	$WidthNS	= 40;
	$HeightNS	= 25;
	$layerID	= 'LayerLogo';
	$divID		= 'divLogo';
	$Value		= 'Top';
	$Anchor		= '';
	$URL        = '';
   
    
    foreach($params as $key=>$val)
    {
        switch($key)
        {
            case 'MyData':

				if($val != '')
				{
					foreach($val as $key2=>$val2)
					{
						$$key2 = (string)trim($val2);
					}
				}

                break;

            case 'Type':
				if($val != '')
				{
					$$key = (string)trim($val);
				}else{
				}

                break;

            default:
                $smarty->trigger_error("[MyGraph] unknown parameter $key", E_USER_WARNING);
				exit;
        }
    }

	if($Type == 'img')
	{
$script = "
if(ns4){
logoW=document.getElementById('$imgID').width;
logoH=document.getElementById('$imgID').height;
}else{
logoW=document.getElementById('$imgID').width;
logoH=document.getElementById('$imgID').height;
}";

		$data = '<img id="' . $imgID . '" src="' . $Value . '" border="0">';
	}else{
$script = "
if(ns4){
logoW = $WidthNS;
logoH = $HeightNS;
}else{
logoW = $WidthIE;
logoH = $HeightIE;
}";

		$data = '<b>' . $Value . '</b>';
	}

	if(trim($URL) != '')
	{
		$URL = 'http://' . $URL;
	}else{
	}

echo <<<end
<script type="text/javascript">
var w3c=(document.getElementById)?true:false;
var ns4=(document.layers)?true:false;
var ie4=(document.all && !w3c)?true:false;
var ie5=(document.all && w3c)?true:false;
var x,y,sx,sy,logo,logoW,logoH;

function getwindowsize(){
if(ie4||ie5){
x=document.body.clientWidth-logoW-10;
y=document.body.clientHeight-logoH-10;
}else{
x=window.innerWidth-logoW-25;
y=window.innerHeight-logoH-10;
}
setInterval('movelogo()',100);
}

function movelogo(){
if(ie4||ie5){
sx=document.body.scrollLeft;
sy=document.body.scrollTop;
}else{
sx=pageXOffset;
sy=pageYOffset;
}
if(ns4)logo.moveTo((x+sx),(y+sy));
else{
document.getElementById("$divID").style.left=x+sx+'px';
document.getElementById("$divID").style.top=y+sy+'px';
}}

window.onload=function(){
logo=(ns4)?document.layers[$divID]:(ie4)?document.all[$divID]:document.getElementById("$divID");

$script

getwindowsize();
}


window.onresize=function(){
if(ns4)setTimeout('history.go(0)', 400);
else getwindowsize();
}
</script>


<div id="$divID" style="position:absolute; left:0px; top:-100px "><a href="$URL#$Anchor">$data</a></div>
end;

}
?>