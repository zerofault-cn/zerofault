function myAlert(msg)
{
	$.prompt(msg);
}

function myLocation(loc)
{
	
	setTimeout(function() {
		window.location.href= (loc==''? window.location.href : loc);
		},2000);
}
function myConfirm(str,url)
{
	loc=url;
	$.prompt(str,{submit:mySubmit,buttons:{Yes:true,Cancel:false}});
}
function mySubmit(v,m){
	if(v==true)
	{
		document.getElementById('_iframe').src=loc;
	}
	return true;
}