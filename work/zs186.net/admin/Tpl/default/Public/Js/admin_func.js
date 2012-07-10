$(document).ready(function(){
	
	$(".addForm input.submit").click(function(){
		submit_addForm(this);
	});

	$("img.password").each(function(i){
		showPasswordEdit(this, i);
	});
	$("img.delete").each(function(i){
		confirmDelete(this, i);
	});

});

function submit_addForm(){
	if(''==$(".addForm input.username").val()){
		myAlert('帐号不能为空');
		$(".addForm input.username").focus();
		return false;
	}
	if(''==$(".addForm input.password").val()){
		myAlert('密码必须设置');
		$(".addForm input.password").focus();
		return false;
	}
	var role_sel = new Array();
	$(".addForm input.role_sel:checked").each(function(){
		role_sel.push($(this).val());
	});
	if(''!=$(".addForm input.user_id").val()) {
		$.post(_URL_+"/edit",{
			'id' : $(".addForm input.user_id").val(),
			'realname' : $(".addForm input.realname").val(),
			'role_ids': role_sel.join(',')
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
			'username' : $(".addForm input.username").val(),
			'realname'    : $(".addForm input.realname").val(),
			'password': $(".addForm input.password").val(),
			'role_ids': role_sel.join(',')
		},function(str){
				if(str=='-1')
				{
					myAlert("该帐号已存在!");
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
		myConfirm('确认彻底删除 '+$(obj).attr('name')+' 的帐号？', _URL_+'/delete/id/'+$(obj).attr('id'));
	});
}

function showPasswordEdit(obj,n) {
	$(obj).css("cursor","pointer").click(function(){
		var id = $(this).attr('id');
		$(".editForm").remove();
		var html = '<span class="editForm"><div style="left:-160px;top:-80px;width:200px;text-align:center;"><fieldset>';
		html += '<legend>给 '+$(this).parent().prev().prev().prev().prev().text()+' 设置新密码</legend>';
		html += '<input type="password" class="password" name="password" size="15"/><br />'
		html += '<input type="button" value="提交" class="submit"/>&nbsp;&nbsp;<input type="button" value="取消" class="cancel"/>';
		html += '</fieldset></div></span>';
		$(this).after(html);
		$(".editForm>div").show('slow');
		$(".editForm input.cancel").click(function(){
			$(".editForm>div").hide('slow');
		});
		$(".editForm input.submit").click(function(){
			$("#_iframe").attr("src", _URL_+"/update/id/"+id+"/f/password/v/"+$(".editForm input.password").val());
		});
		$(document).keydown(function(e){
			var keyCode=e.keyCode ||window.event.keyCode;
			if(keyCode==27)//取消健
			{
				$(".editForm>div").hide('slow');
			}
		});
	});
}