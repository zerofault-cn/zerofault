$(document).ready(function(){
	
	$(".addForm input.submit").click(function(){
		submit_addForm(this);
	});

	$("table td label").each(function(i){
		setNameEditable(this,i);
	});
	
	$("img.edit").each(function(i){
		editRole(this, i);
	});

	$("img.delete").each(function(i){
		confirmDelete(this, i);
	});

});

function submit_addForm(){
	if(''==$(".addForm input.name").val()){
		myAlert('名称必须填写');
		$(".addForm input.name").focus();
		return false;
	}
	var role_sel = new Array();
	$(".addForm input.role_sel:checked").each(function(){
		role_sel.push($(this).val());
	});
	$.post(_URL_+"/add",{
		'account' : $(".addForm input.account").val(),
		'name'    : $(".addForm input.name").val(),
		'password': $(".addForm input.password").val(),
		'role_ids': role_sel.join(',')
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

