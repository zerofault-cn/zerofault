function myAlert(msg)
{
	jQuery.prompt(msg);
}
function myOK(intval)
{
	if(intval==''){
		intval = 2000;
	}
	setTimeout(function() {
		jQuery("#cleanbluebox").remove();
	}, intval);
}
function myLocation(loc,intval)
{
	if(intval==''){
		intval = 2000;
	}
	setTimeout(function() {
		window.location.href= (loc==''? window.location.href : loc);
		},intval);
}
var loc;
function myConfirm(str,url)
{
	loc=url;
	jQuery.prompt(str,{submit:mySubmit,buttons:{Yes:true,Cancel:false}});
}
function mySubmit(v,m){
	if(v==true)
	{
		document.getElementById('_iframe').src=loc;
	}
	return true;
}