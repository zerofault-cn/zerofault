$(document).ready(function() {
	$(".text_editable").each(function(i) { //设置sort可编辑
		textEditable(this, i);
	});
});

function nameEditable(obj, n) {
	$(obj).append(
		$("<img />").attr({"src": IMAGE_FOLDER+"text_field_edit.png", "alt": "编辑"}).css("cursor","pointer").click(function() {
			var old_name = $(obj).children(":first-child").text();
			var tmp_html='<span><input class="quickedit" type="text" name="name" value="'+old_name+'" size="'+(parseInt(old_name.length)+4)+'"> <i class="submit"><img src="'+IMAGE_FOLDER+'accept.gif" alt="提交" align="absmiddle"/></i><i class="cancel"><img src="'+IMAGE_FOLDER+'cancel.gif" alt="取消" align="absmiddle"/></i></span>';
			$(obj).children(":first-child").hide();
			$(this).after(tmp_html).hide();
			$(this).next().children("input").select().keydown(function(e){
				var keyCode=e.keyCode ||window.event.keyCode;
				if(keyCode==13)//回车键
				{
					submit(this,n);
				}
				else if(keyCode==27)//取消健
				{
					cancel(this,n);
				}
			});
			$(this).next().children(".submit").css("cursor","pointer").click(function(){
				submit(this,n);
			});
			$(this).next().children(".cancel").css("cursor","pointer").click(function(){
				cancel(this,n);
			});
		})
	);
}
function textEditable(obj, n) {
	$(obj).wrapInner(
		$("<label />").attr({'title': '点击即可编辑'}).mouseover(function() {
			$(this).addClass("editable");
		}).mouseout(function() {
			$(this).removeClass("editable");
		}).click(function() {
			var old_value = $(this).text();
			var name = $(obj).attr("name");
			var html = '<span><input class="quickedit" type="text" name="'+name+'" value="'+old_value+'" size="'+(old_value.length+2)+'"><img class="submit" src="'+IMAGE_FOLDER+'accept.gif" alt="提交" align="absmiddle"/><img class="cancel" src="'+IMAGE_FOLDER+'cancel.gif" alt="取消" align="absmiddle"/></span>';
			$(this).after(html).hide();
			$(this).next().children("input").select().keydown(function(e) {
				var keyCode=e.keyCode ||window.event.keyCode;
				if(keyCode==13) {//回车键
					submit_edit(this, n);
				}
				else if(keyCode==27) {//取消健
					cancel_edit(this, n);
				}
			});
			$(this).next().children(".submit").css("cursor","pointer").click(function() {
				submit_edit(this, n);
			});
			$(this).next().children(".cancel").css("cursor","pointer").click(function() {
				cancel_edit(this ,n);
			});
		})
	)
}
function submit_edit(obj, n) {
	$("#_iframe").attr("src", _URL_+"/update/id/"+$(obj).parent().parent().parent().attr('id')+"/f/"+$(obj).parent().parent().attr("name")+"/v/"+$(obj).parent().children("input").val());
}
function cancel_edit(obj, n) {
	$(obj).parent().prev().show();
	$(obj).parent().remove();

}
