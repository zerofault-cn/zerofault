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
	if(intval == 0) {
		window.location.href = (loc==''? window.location.href : loc);
	}
	if(intval=='') {
		intval = 2000;
	}
	setTimeout(function() {
		window.location.href= (loc==''? window.location.href : loc);
		},intval);
}
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
function switchTab(id) {
	$("td.clsTab").each(function(){
		if($(this).attr("id") == id) {
			$(this).addClass("current");
		}
		else{
			$(this).removeClass("current");
		}
	});
	$("table.clsTab").each(function(){
		if($(this).attr("id") == id) {
			$(this).show();
		}
		else{
			$(this).hide();
		}
	});
}
