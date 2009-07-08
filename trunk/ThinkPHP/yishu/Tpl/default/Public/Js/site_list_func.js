$(document).ready(function(){
	$("input#submit_addSite").click(function(){ //点击提交
		submit_addSite(this);
	});

	$(".site_info>label").each(function(i){ //设置分类名称的可编辑功能
		setSiteNameEditable(this,i);
	});

	$(".Site_func>label").each(function(i){ //设置分类的排序数字的可编辑功能
		setSortEditable(this,i,'Website');
	});
});

function submit_addSite(){ //提交新的分类
	if(''==$("input#site_name").val())
	{
		myAlert('站点名称不能为空');
		$("input#site_name").focus();
		return false;
	}
	$.post(_URL_+"/add",{
		'table':'Website',
		'name': $("input#site_name").val(),
		'sort': $("input#site_sort").val(),
	},function(str){
			if(str=='-1')
			{
				myAlert("该名称已经添加过了!");
			}
			else if(str=='1')
			{
				myAlert("添加成功!");
				location.reload();
			}
			else
			{
				myAlert(str);
			}
		});
}
function setSiteNameEditable(obj,n){ //设置分类名称可编辑功能
	$(obj).mouseover(function(){
		$(this).addClass("editable");
	}).mouseout(function(){
		$(this).removeClass("editable");
	}).click(function(){
		html0=$(this).html();
		html1='<span><input class="quickedit" type="text" value="'+html0+'" size="'+2*html0.length+'"> <i class="submit"><img src="'+APP_PUBLIC_URL+'/Images/sign_tick.png" alt="提交" align="absmiddle"/></i><i class="cancel"><img src="'+APP_PUBLIC_URL+'/Images/sign_cancel.png" alt="取消" align="absmiddle"/></i></span>';
		$(this).after(html1).hide();
		$(this).next().children("input").select().keydown(function(e){
			var keyCode=e.keyCode ||window.event.keyCode;
			if(keyCode==13)//回车键
			{
				submit_siteName(this,n);
			}
			else if(keyCode==27)//取消健
			{
				cancel_siteName(this,n);
			}
		});
		$(this).next().children(".submit").css("cursor","pointer").click(function(){
			submit_siteName(this,n);
		});
		$(this).next().children(".cancel").css("cursor","pointer").click(function(){
			cancel_siteName(this,n);
		});
	});
}
function submit_siteName(obj,n){//提交新的分类名称
	$("#_iframe").attr("src", _URL_+"/update?t=Website&id="+$(obj).parent().prev().attr('id')+"&f=name&v="+$(obj).parent().children("input").val());
}
function cancel_siteName(obj,n){//取消修改分类名称
	$(obj).parent().prev().show();
	$(obj).parent().remove();
}

function setSortEditable(obj,n,table){//设置分类排序数字可编辑功能,公用
	$(obj).mouseover(function(){
		$(this).addClass("editable");
	}).mouseout(function(){
		$(this).removeClass("editable");
	}).click(function(){
		html0=$(this).html();
		html1='<span><input class="quickedit" type="text" value="'+html0+'" size="'+html0.length+'"> <i class="submit"><img src="'+APP_PUBLIC_URL+'/Images/sign_tick.png" alt="提交" align="absmiddle"/></i><i class="cancel"><img src="'+APP_PUBLIC_URL+'/Images/sign_cancel.png" alt="取消" align="absmiddle"/></i></span>';
		$(this).after(html1).hide();
		$(this).next().children("input").select().keydown(function(e){
			var keyCode=e.keyCode ||window.event.keyCode;
			if(keyCode==13)//回车键
			{
				submit_sort(this,n,table);
			}
			else if(keyCode==27)//取消健
			{
				cancel_sort(this,n,table);
			}
		});
		$(this).next().children(".submit").css("cursor","pointer").click(function(){
			submit_sort(this,n,table);
		});
		$(this).next().children(".cancel").css("cursor","pointer").click(function(){
			cancel_sort(this,n,table);
		});

	});
}
function submit_sort(obj,n,table){//提交新的分类排序,公用
	$("#_iframe").attr("src", _URL_+"/update?t="+table+"&id="+$(obj).parent().prev().attr('id')+"&f=sort&v="+$(obj).parent().children("input").val());
}
function cancel_sort(obj,n){//取消更改分类排序,公用
	$(obj).parent().prev().show();
	$(obj).parent().remove();

}
