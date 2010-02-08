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
var loc = '';
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
var times = 0;
function myConfirm2(str,num)
{
	times = num;
	jQuery.prompt(str,{submit:mySubmit2,buttons:{Yes:true,Cancel:false}});
}
function mySubmit2(v,m){
	if(v==true)
	{
		jQuery("input[name='confirm']").val(times);
		document.Import.submit();
	}
	else if(document.Import) {
		document.Import.file.value = '';
		document.Import.confirm.value = '';
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
function checkAll() {
	var all_check = document.getElementById('checkall');
	var s_check = document.getElementsByName('chk[]');
	for(var i=0; i<s_check.length; i++) {
		s_check[i].checked=all_check.checked;
	}
}
function updateCheckAll(obj) {
	var all_check = document.getElementById('checkall');
	var s_check = document.getElementsByName('chk[]');
	s_check_count = s_check.length;
	s_checked=0;
	for(var i=0; i<s_check.length; i++) {
		if(s_check[i].checked==true) {
			s_checked++;
		}
		else
		{
			s_checked--;
		}
		if(s_checked==s_check_count)
		{
			all_check.checked=true;
		}
		else
		{
			all_check.checked=false;
		}
	}
}