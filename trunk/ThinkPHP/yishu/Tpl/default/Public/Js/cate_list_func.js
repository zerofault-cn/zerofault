$(document).ready(function(){
	$("input#submit_addCate").click(function(){ //点击提交
		submit_addCate(this);
	});

	$(".cate_info>label").each(function(i){ //设置分类名称的可编辑功能
		setCateNameEditable(this,i);
	});

	$(".cate_func>label").each(function(i){ //设置分类的排序数字的可编辑功能
		setSortEditable(this,i,'category');
	});

	$(".cate_func a.show").each(function(i){ //设置分类的显示与隐藏功能
		setShowFlagFunc(this,i,'Category');
	});

	$(".cate_func a.delete").each(function(i){ //设置分类的删除功能
		setDeleteFunc(this,i,'Category');
	});

});

function submit_addCate(){ //提交新的分类
	if(''==$("input#cate_name").val())
	{
		alert('分类名称不能为空');
		$("input#cate_name").focus();
		return false;
	}
	$.post("add",{
		'name': $("input#cate_name").val(),
		'sort': $("input#cate_sort").val(),
	},function(str){
			if(str=='-1')
			{
				alert("该名称已经添加过了!");
			}
			else if(str=='1')
			{
				location.reload();
			}
			else
			{
				alert(str);
			}
		});
}
function setCateNameEditable(obj,n){ //设置分类名称可编辑功能
	$(obj).mouseover(function(){
		$(this).addClass("editable");
	}).mouseout(function(){
		$(this).removeClass("editable");
	}).click(function(){
		html0=$(this).html();
		html1='<span><input tyle="text" value="'+html0+'" size="'+2*html0.length+'"> <i class="submit">提交</i>/<i class="cancel">取消</i></span>';
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
	$.post("update",{
		'table'	:'category',
		'id'	:$(obj).parent().prev().attr('id'),
		'field'	:'name',
		'value'	:$(obj).parent().children("input").val()
	},function(str){
			if(str==1)
			{
			//	alert('修改成功');
				$(obj).parent().prev().html($(obj).parent().children("input").val()).show();
				$(obj).parent().remove();
			}
			else
			{
				alert(str);
			}
		});
}
function cancel_cateName(obj,n){//取消修改分类名称
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
		html1='<span><input tyle="text" value="'+html0+'" size="'+html0.length+'"> <i class="submit">提交</i>/<i class="cancel">取消</i></span>';
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
//	alert($(obj).parent().prev().attr('id'));
//	return false;
	$.post("update",{
		'table'	:table,
		'id'	:$(obj).parent().prev().attr('id'),
		'field'	:'sort',
		'value'	:$(obj).parent().children("input").val()
	},function(str){
			if(str==1)
			{
			//	alert('修改成功');
			//	location.reload();
				$(obj).parent().prev().html($(obj).parent().children("input").val()).show();
				$(obj).parent().remove();
			}
			else
			{
				alert(str);
			}
		});
}
function cancel_sort(obj,n){//取消更改分类排序,公用
//	alert($(obj).html());
//	return false;
	$(obj).parent().prev().show();
	$(obj).parent().remove();

}
function setShowFlagFunc(obj,n,table){
	//设置显示与隐藏功能,公用
	$(obj).click(function(){
		$.post("update",{
			'table'	:table,
			'id'	:$(obj).attr('id'),
			'field'	:$(obj).attr('name'),
			'value'	:$(obj).attr('val')
		},function(str){
				if(str==1) //后台处理成功
				{
					if($(obj).attr("val")==0)//当前点击的是隐藏/普通
					{
						$(obj).attr("val",1);
						if($(obj).attr('class')=='show')
						{
							$(obj).html('显示');
							$(obj).parent().parent().addClass('gray');
						}
						else if($(obj).attr('class').indexOf('mark')>=0)
						{
							$(obj).html('醒目');
							$(obj).parent().removeClass('red');
							$(obj).parent().parent().next().children(":first").removeClass("red");
						}
					}
					else//当前点击的是显示/突出
					{
						$(obj).attr("val",0);
						if($(obj).attr('class')=='show')
						{
							$(obj).html('隐藏');
							$(obj).parent().parent().removeClass('gray');
						}
						else if($(obj).attr('class')=='mark')
						{
							$(obj).html('普通');
							$(obj).parent().addClass('red');
							$(obj).parent().parent().next().children(":first").addClass("red");
						}
					}
				//	location.reload();
				}
				else
				{
					alert(str);
				}
			});
	});
}
function setDeleteFunc(obj,n,table){ //设置删除功能,公用
	$(obj).click(function(){
		if(confirm('确定删除？'))
		{
			$.post("update",{
					table:table,
					id:$(obj).attr('id'),
					field:'flag',
					value:-1
				},function(str){
					if(str==-1)
					{
						alert('此分类下还有记录，不能删除！');
					}
					else if(str==1)
					{
						$(obj).parent().parent().parent().remove();
					}
					else
					{
						alert(str);
					}
				});
		}
		else
		{
			return false;
		}
	});
}
