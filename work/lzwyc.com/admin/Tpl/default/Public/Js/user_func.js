$(document).ready(function(){
	$("img.password").each(function(i){
		showPasswordEdit(this, i);
	});
});


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