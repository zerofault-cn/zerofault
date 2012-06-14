$(document).ready(function() {

	$(".name_editable").each(function(i) { //设置name可编辑
		nameEditable(this, i);
	});

	$(".sort_editable").each(function(i) { //设置sort可编辑
		sortEditable(this, i);
	});
});

function nameEditable(obj, n) {
	if ($(obj).children("a").length > 0) {
		
	}
	//	 <img class="edit" src="../Public/Images/form_edit.gif" alt="编辑" align="absmiddle"/>
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
function submit(obj,n) {
	$("#_iframe").attr("src", _URL_+"/update/id/"+$(obj).parent().parent().parent().attr('id')+"/f/"+$(obj).attr("name")+"/v/"+$(obj).parent().children("input").val());
}
function cancel_cateName(obj,n){//取消修改分类名称
	$(obj).parent().prev().prev().show();
	$(obj).parent().prev().show();
	$(obj).parent().remove();
}

function sortEditable(obj, n) {
	$(obj).wrapInner(
		$("<label />").attr({'title': '点击即可编辑'}).mouseover(function() {
			$(this).addClass("editable");
		}).mouseout(function() {
			$(this).removeClass("editable");
		}).click(function() {
			html0=$(this).html();
			html1='<span><input class="quickedit" type="text" value="'+html0+'" size="'+html0.length+'"> <i class="submit"><img src="'+IMAGE_FOLDER+'accept.gif" alt="提交" align="absmiddle"/></i><i class="cancel"><img src="'+IMAGE_FOLDER+'cancel.gif" alt="取消" align="absmiddle"/></i></span>';
			$(this).after(html1).hide();
			$(this).next().children("input").select().keydown(function(e){
				var keyCode=e.keyCode ||window.event.keyCode;
				if(keyCode==13)//回车键
				{
					submit_sort(this,n);
				}
				else if(keyCode==27)//取消健
				{
					cancel_sort(this,n);
				}
			});
			$(this).next().children(".submit").css("cursor","pointer").click(function(){
				submit_sort(this,n);
			});
			$(this).next().children(".cancel").css("cursor","pointer").click(function(){
				cancel_sort(this,n);
			});
		})
	)
}
function submit_sort(obj,n){//提交新的分类排序,公用
	$("#_iframe").attr("src", _URL_+"/update/id/"+$(obj).parent().prev().attr('id')+"/f/sort/v/"+$(obj).parent().children("input").val());
}
function cancel_sort(obj,n){//取消更改分类排序,公用
	$(obj).parent().prev().show();
	$(obj).parent().remove();

}
