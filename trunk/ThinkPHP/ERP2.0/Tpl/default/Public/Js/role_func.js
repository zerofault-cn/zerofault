$(document).ready(function(){
	$(".addForm input.node").each(function(){
		$(this).click(function(){
			check($(this));
		});
	});

	$(".addForm input.submit").click(function(){
		submit_addForm(this);
	});
	
	$("img.edit").each(function(i){
		editRole(this, i);
	});

	$("img.delete").each(function(i){
		confirmDelete(this, i);
	});

});

function check(obj) {
	//var obj = $(this);
	if(obj.attr('name')=='module_node') {
		obj.parent().next().children("input:checkbox").each(function(){
			$(this).attr("checked",obj.attr('checked'));
		});
	}
	else if(obj.attr('name')=='action_node') {
		var parent_node = obj.parent().prev().children("input:checkbox");
		var check = false;
		obj.parent().children("input:checkbox").each(function(){
			check = check || $(this).attr("checked");
		});
		parent_node.attr('checked',check);
	}
}

function submit_addForm(){
	if(''==$(".addForm input.name").val()){
		myAlert('Name Required!');
		$(".addForm input.name").focus();
		return false;
	}
//	var node_sel = new Array();
//	$(".addForm input:checked").each(function(){
//		node_sel.push($(this).val());
//	});
	var node_ids = $(".addForm input:checked").map(function(){
		return $(this).val();
	}).get().join(',');
	if(''!=$(".addForm input.role_id").val()) {
		$.post(_URL_+"/edit",{
			'id' : $(".addForm input.role_id").val(),
			'name'    : $(".addForm input.name").val(),
			'node_ids': node_ids
		},function(str){
				if(str=='1')
				{
					myAlert("Update success!");
					loc = window.location.href;
					myLocation(loc.substring(0,loc.lastIndexOf('/')-3),1200);
				}
				else
				{
					myAlert(str);
				}
			});
	}
	else{
		$.post(_URL_+"/add",{
			'name'    : $(".addForm input.name").val(),
			'node_ids': node_ids
		},function(str){
				if(str=='-1')
				{
					myAlert("The role name has existed!");
				}
				else if(str=='1')
				{
					myAlert("Add success!");
					myLocation("",1200);
				}
				else
				{
					myAlert(str);
				}
			});
	}
}
function confirmDelete(obj,n) {
	$(obj).css("cursor","pointer").click(function(){
		myConfirm('Confirm to delete the role: '+$(obj).attr('name')+' ', _URL_+'/delete/id/'+$(obj).attr('id'));
	});
}


