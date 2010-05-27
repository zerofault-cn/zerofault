var all_check = document.getElementById('checkall');
var s_check = document.getElementsByName('chk[]');
var s_check_count = s_check.length;
var s_checked=0;
$(document).ready(function(){
	reset_form();
});
function reset_form() {
	all_check.checked = false;
	for(var i=0; i<s_check.length; i++) {
		s_check[i].checked = false;
	}
	$("input[name='transfer']").attr("disabled", true);
	$("input[name='release']").attr("disabled", true);
	document.Batch.reset();
}
function batch_form(action) {
	if ('undefined' == typeof(action)) {
		action = 'transfer';
	}
	if ($("input:checked").length==0) {
		alert('You haven\'t select any item');
		return false;
	}
	if ('release'==action || 'return'==action) {
		$("#transfer_to").hide();
	}
	else {
		$("#transfer_to").show();
	}
	$("#batch_form .page_title_text").html('Batch '+action+' Form');
	$("input[name='action']").val(action);
	tb_show('','#TB_inline?width=480&height=360&modal=true&inlineId=batch_form','')
}
function checkAll2() {
	for(var i=0; i<s_check_count; i++) {
		s_check[i].checked = all_check.checked;
		if (s_check[i].checked == true) {
			document.getElementById('tr_'+s_check[i].value).style.display = '';
			document.getElementById('input_'+s_check[i].value).disabled = false;
		}
		else {
			document.getElementById('tr_'+s_check[i].value).style.display = 'none';
			document.getElementById('input_'+s_check[i].value).disabled = true;
		}
	}
	if (s_check_count>0 && all_check.checked == true) {
		$("input[name='transfer']").attr("disabled", false);
		$("input[name='release']").attr("disabled", false);
	}
	else {
		$("input[name='transfer']").attr("disabled", true);
		$("input[name='release']").attr("disabled", true);
	}
}
function updateCheckAll2(obj) {
	if (obj.checked == true) {
		s_checked++;
		document.getElementById('tr_'+obj.value).style.display = '';
		document.getElementById('input_'+obj.value).disabled = false;
	}
	else {
		s_checked--;
		document.getElementById('tr_'+obj.value).style.display = 'none';
		document.getElementById('input_'+obj.value).disabled = true;
	}
	if(s_checked == s_check_count) {
		all_check.checked = true;
	}
	else {
		all_check.checked = false;
	}
	if (s_checked == 0) {
		$("input[name='transfer']").attr("disabled", true);
		$("input[name='release']").attr("disabled", true);
		$("input[name='return']").attr("disabled", true);
	}
	else {
		$("input[name='transfer']").attr("disabled", false);
		$("input[name='release']").attr("disabled", false);
		$("input[name='return']").attr("disabled", false);
	}
}
function select_location(obj) {
	if('staff' == $(obj).val()) {
		$('#staff_opts').show();
		$('#to_type').val('staff');
	}
	else {
		$("#staff_opts").hide();
		$('#to_type').val('location');
		$("#to_id").val($(obj).val());
		
	}
}
function select_staff(obj) {
	$("#to_id").val($(obj).val());
}