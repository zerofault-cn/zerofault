$(document).ready(function(){
	
	$(".addForm input.node").each(function(){
		$(this).click(function(){
			checkAll(this);
		});
	});

	$(".addForm input.submit").click(function(){
		submit_addForm(this);
	});

	$("table#table td label").each(function(i){
		setNameEditable(this,i);
	});
	
	$("img.edit").each(function(i){
		editRole(this, i);
	});

	$("img.delete").each(function(i){
		confirmDelete(this, i);
	});

});

function checkAll(obj) {
	if($(obj).attr('name')=='module_node') {
		$("dd#node_"+$(obj).val()).children("input:checkbox").each(function(){
			$(this).attr("checked",$(obj).attr('checked'));
		});
	}
	else if($(obj).attr('name')=='action_node') {
		var parent_node = $(obj).parent().prev().children("input:checkbox");
		var check = false;
		$(obj).parent().children("input:checkbox").each(function(){
			check = check || $(this).attr("checked");
		});
		$(parent_node).attr('checked',check);
	}

}

function submit_addForm(){
	if(''==$(".addForm input.name").val()){
		myAlert('名称必须填写');
		$(".addForm input.name").focus();
		return false;
	}
	var node_sel = new Array();
	$(".addForm input:checked").each(function(){
		node_sel.push($(this).val());
	});
	if(''!=$(".addForm input.role_id").val()) {
		$.post(_URL_+"/update",{
			'id' : $(".addForm input.role_id").val(),
			'name'    : $(".addForm input.name").val(),
			'node_ids': node_sel.join(',')
		},function(str){
				if(str=='1')
				{
					myAlert("更新成功!");
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
			'node_ids': node_sel.join(',')
		},function(str){
				if(str=='-1')
				{
					myAlert("该角色名已存在!");
				}
				else if(str=='1')
				{
					myAlert("添加成功!");
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
		myConfirm('确认彻底删除 '+$(obj).attr('name')+' 角色？', _URL_+'/delete/id/'+$(obj).attr('id'));
	});
}

function setNameEditable(obj,n){
	$(obj).mouseover(function(){
		$(this).addClass("editable");
	}).mouseout(function(){
		$(this).removeClass("editable");
	}).click(function(){
		html0=$(this).html();
		html1='<span><input class="quickedit" type="text" value="'+html0+'" size="'+2*html0.length+'"><br /> <i class="submit"><img src="'+IMAGE_FOLDER+'accept.gif" alt="提交" align="absmiddle"/></i><i class="cancel"><img src="'+IMAGE_FOLDER+'cancel.gif" alt="取消" align="absmiddle"/></i></span>';
		$(this).after(html1).hide();
		$(this).next().children("input").select().keydown(function(e){
			var keyCode=e.keyCode ||window.event.keyCode;
			if(keyCode==13)//回车键
			{
				submit_name(this,n);
			}
			else if(keyCode==27)//取消健
			{
				cancel_name(this,n);
			}
		});
		$(this).next().children(".submit").css("cursor","pointer").click(function(){
			submit_name(this,n);
		});
		$(this).next().children(".cancel").css("cursor","pointer").click(function(){
			cancel_name(this,n);
		});

	});
}
function submit_name(obj,n){
	$("#_iframe").attr("src", _URL_+"/update/id/"+$(obj).parent().prev().attr('id')+"/f/name/v/"+$(obj).parent().children("input").val());
}
function cancel_name(obj,n){
	$(obj).parent().prev().show();
	$(obj).parent().remove();
}

function editRole(obj,n) {
}

