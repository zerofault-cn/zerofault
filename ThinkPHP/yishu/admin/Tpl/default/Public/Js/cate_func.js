$(document).ready(function(){
	$("#table").tablesorter({
		headers: { 4: { sorter: false}}, 
		sortMultiSortKey : 'ctrlKey'
	}); 
	
	$(".addForm input.submit").click(function(){ //点击提交
		submit_addCate(this);
	});

	$("table td img.edit").each(function(i){ //设置分类名称的可编辑功能
		setCateNameEditable(this,i);
	});

	$("table td label").each(function(i){ //设置分类的排序数字的可编辑功能
		setSortEditable(this,i);
	});
});

function submit_addCate(){ //提交新的分类
	if(''==$("input.name").val()){
		myAlert('分类名称不能为空');
		$("input.name").focus();
		return false;
	}
	$.post(_URL_+"/add",{
		'name': $("input.name").val(),
		'sort': $("input.sort").val()
	},function(str){
			if(str=='-1')
			{
				myAlert("该分类已经添加过了!");
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
function setCateNameEditable(obj,n){ //设置分类名称可编辑功能
	$(obj).css("cursor","pointer").click(function(){
		html0=$(this).prev().html();
		html1='<span><input class="quickedit" type="text" value="'+html0+'" size="'+2*html0.length+'"> <i class="submit"><img src="'+IMAGE_FOLDER+'accept.gif" alt="提交" align="absmiddle"/></i><i class="cancel"><img src="'+IMAGE_FOLDER+'cancel.gif" alt="取消" align="absmiddle"/></i></span>';
		$(this).prev().hide();
		$(this).after(html1).hide();
		$(this).next().children("input").select().keydown(function(e){
			var keyCode=e.keyCode ||window.event.keyCode;
			if(keyCode==13)//回车键
			{
				submit_cateName(this,n);
			}
			else if(keyCode==27)//取消健
			{
				cancel_cateName(this,n);
			}
		});
		$(this).next().children(".submit").css("cursor","pointer").click(function(){
			submit_cateName(this,n);
		});
		$(this).next().children(".cancel").css("cursor","pointer").click(function(){
			cancel_cateName(this,n);
		});
	});
}
function submit_cateName(obj,n){//提交新的分类名称
	$("#_iframe").attr("src", _URL_+"/update?id="+$(obj).parent().prev().prev().attr('id')+"&f=name&v="+$(obj).parent().children("input").val());
}
function cancel_cateName(obj,n){//取消修改分类名称
	$(obj).parent().prev().prev().show();
	$(obj).parent().prev().show();
	$(obj).parent().remove();
}

function setSortEditable(obj,n){//设置分类排序数字可编辑功能,公用
	$(obj).mouseover(function(){
		$(this).addClass("editable");
	}).mouseout(function(){
		$(this).removeClass("editable");
	}).click(function(){
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

	});
}
function submit_sort(obj,n){//提交新的分类排序,公用
	$("#_iframe").attr("src", _URL_+"/update?id="+$(obj).parent().prev().attr('id')+"&f=sort&v="+$(obj).parent().children("input").val());
}
function cancel_sort(obj,n){//取消更改分类排序,公用
	$(obj).parent().prev().show();
	$(obj).parent().remove();

}
