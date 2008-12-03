$(document).ready(function(){  //这个就是传说的ready,页面载入完成即执行
	$("div#addCateForm").hide("fast");//隐藏添加分类的表单

	$("input#toAddCate").click(function(){//点击添加按钮,隐藏此按钮,显示添加分类的表单
		$(this).hide('slow');
		$("div#addCateForm").show("slow");
	});

	$("input#cancel_addCate").click(function(){//点击取消按钮,隐藏添加分类的表单,显示添加按钮
		$("div#addCateForm").hide("slow");
		$("input#toAddCate").show('slow');
	});

	$("input#submit_addCate").click(function(){//点击提交
		submit_addCate(this);
	});

	$("ol.cate_list>li>div").mouseover(function(){//鼠标在分类上时切换行背景
		$(this).css("background-color","#B4B9F5");
	}).mouseout(function(){
		$(this).css("background-color","");
	});
	$("ol.site_list>li").mouseover(function(){//鼠标在网址列表上时切换行背景
		$(this).css("background-color","#CCE7CB");
	}).mouseout(function(){
		$(this).css("background-color","");
	});

	$("ol.site_list").each(function(i){
		hideOverflowSite(this,i);
	});
	$("a.toShowSite").each(function(i){
		showHideAllSite(this,i);
	});

	$(".cate_info>label").each(function(i){//设置分类名称的可编辑功能
		setCateNameEditable(this,i);
	});

	$(".cate_info>a.toAddSite").each(function(i){//点击添加网站,显示添加网站的表单
		showAddSiteForm(this,i);
	});

	$(".cate_func>label").each(function(i){//设置分类的排序数字的可编辑功能
		setSortEditable(this,i,'url_category');
	});

	$(".cate_func a.show").each(function(i){//设置分类的显示与隐藏功能
		setShowFlagFunc(this,i,'url_category');
	});

	$(".cate_func a.delete").each(function(i){//设置分类的删除功能
		setDeleteFunc(this,i,'url_category');
	});

	$(".site_func>label").each(function(i){//设置网址的排序数字的可编辑功能
		setSortEditable(this,i,'url_website');
	});
	$(".site_func a.show").each(function(i){//设置网址的显示与隐藏功能
		setShowFlagFunc(this,i,'url_website');
	});
	$(".site_func a.mark").each(function(i){//设置网址的突出标记功能
		if($(this).attr("value")==0)
		{
			$(this).addClass('red');
		}
		setShowFlagFunc(this,i,'url_website');
	});

	$(".site_func a.delete").each(function(i){//设置网址删除功能
		setDeleteFunc(this,i,'url_website');
	});

	$(".site_info>a.toEditSite").each(function(i){
		setSiteEditable(this,i);
	});
});

function submit_addCate() {//提交新的分类
	if(''==$("input#cate_name").val())
	{
		alert('分类名称不能为空');
		$("input#cate_name").focus();
		return false;
	}
	$.post("?action=add",{
		'name': $("input#cate_name").val(),
		'sort': $("input#cate_sort").val(),
		'descr':$("input#cate_descr").val()
	},function(str){
			if(str=='-1')
			{
				alert("该条目已经添加过了!");
			}
			else if(str=='1')
			{
				location.reload();
			//	addsite('.$id.');
			}
			else
			{
				alert(str);
			}
		});
}
function setCateNameEditable(obj,n){//设置分类名称可编辑功能
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
	$.post("?action=modify",{
		'table'	:'url_category',
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

function showAddSiteForm(obj,n){//显示添加网站的表单
	$(obj).click(function(){
		if($(this).attr('value')=='0')
		{
			$(this).html('取消添加');
			$(this).attr('value',1);
			$(this).parent().parent().next().children(".addSiteForm").show("slow");

			$(this).parent().parent().next().children(".addSiteForm").children(".submit").click(function(){
				submit_addSite(this,n);
			});
			$(this).parent().parent().next().children(".addSiteForm").children(".cancel").click(function(){
				cancel_addSite(this,n);
			});
		}
		else
		{
			cancel_addSite(this,n);
		}
	});
}

function submit_addSite(obj,n) {//提交新的网站
//	alert($(obj).prev().prev().val());
//	return false;
	if(''==$(obj).prev().prev().val())
	{
		alert('网站名称不能为空');
		$(obj).prev().prev().focus();
		return false;
	}
	if(''==$(obj).next().next().next().val())
	{
		alert('网址不能为空');
		$(obj).next().next().next().focus();
		return false;
	}

	$.post("?action=add",{
		'table'	:'url_website',
		'cate_id':$(obj).parent().attr("id"),
		'name'	:$(obj).prev().prev().val(),
		'url'	:$(obj).next().next().next().val(),
		'sort'	:$(obj).prev().val(),
		'descr'	:$(obj).next().next().next().next().next().val()
	},function(str){
			if(str=='-1')
			{
				alert("该条目已经添加过了!");
			}
			else if(str=='1')
			{
				location.reload();
			//	addsite('.$id.');
			}
			else
			{
				alert(str);
			}
		});
}
function cancel_addSite(obj,n){//取消添加网站
	$(obj).html('添加网站');
	$(obj).attr('value',0);
	$(obj).parent().parent().next().children(".addSiteForm").hide("slow");
}
function hideOverflowSite(obj,n){//隐藏超过10个的网站
	site_num=$(obj).children("li").size();
	if(site_num>10)
	{
		$(obj).children('li').slice(0,site_num-10).hide();
		$(obj).children('li:eq(0)').before('<div><a href="javascript:void(0)" class="show_hiddenSite">……这里隐藏了个'+(site_num-10)+'个……</a></div>');
		$(obj).children("div:eq(1)").click(function(){
			$(this).hide();
			$(obj).children('li').show();
			$(obj).prev().find('a.toShowSite').attr('id',1).html('[显示最新添加]');
		})
	}
}
function showHideAllSite(obj,n){//设置显示与隐藏超过10行的站点列表的功能
	$(obj).click(function(){
		if($(this).attr('id')==0)
		{
			$(this).attr('id',1);
			$(this).html('[显示最新添加]');
			$(this).parent().parent().next().children('li').show();
			$(this).parent().parent().next().children('div:eq(1)').hide();
		}
		else if($(this).attr('id')==1)
		{
			$(this).attr('id',0);
			site_num=$(this).parent().parent().next().children('li').size();
			$(this).html('[显示全部'+site_num+'个网站]');
			$(this).parent().parent().next().children('li').slice(0,site_num-10).hide();
			$(this).parent().parent().next().children('div:eq(1)').show();
		}
	});
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
	$.post("?action=modify",{
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
function setShowFlagFunc(obj,n,table){//设置显示与隐藏功能,公用
	$(obj).click(function(){
		$.post("?action=modify",{
			'table'	:table,
			'id'	:$(obj).attr('id'),
			'field'	:($(obj).attr('class')=='show'?'show_flag':'mark'),
			'value'	:$(obj).attr('value')
		},function(str){
				if(str==1)//后台处理成功
				{
					if($(obj).attr('value')==0)//当前点击的是隐藏/普通
					{
						$(obj).attr("value",1);
						if($(obj).attr('class')=='show')
						{
							$(obj).html('显示');
							$(obj).parent().parent().parent().addClass('gray');
						}
						else if($(obj).attr('class')=='mark')
						{
							$(obj).html('突出');
							$(obj).parent().removeClass('red');
							$(obj).parent().parent().next().children(":first").removeClass("red");
						}
					}
					else//当前点击的是显示/突出
					{
						$(obj).attr("value",0);
						if($(obj).attr('class')=='show')
						{
							$(obj).html('隐藏');
							$(obj).parent().parent().parent().removeClass('gray');
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

function setDeleteFunc(obj,n,table){//设置删除功能,公用
	$(obj).click(function(){
		if(confirm('确定删除？'))
		{
			$.post("?action=del",{
					table:table,
					id:$(obj).attr('id')
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

function setSiteEditable(obj,n){
	$(obj).click(function(){
		name=$(this).prev().html();
		url=$(this).prev().attr('href');
		descr=$(this).prev().attr('title');
		html='<span>网站：<input type="text" value="'+name+'" size="10"> <input type="button" value="提交" class="submit"> <input type="button" value="取消" class="cancel"><br />网址：<input type="text" value="'+url+'" size="20"><br />简介：<input type="text" value="'+descr+'" size="40">';
		$(this).prev().before(html).hide().nextAll().hide();
		$(this).prev().prev().children(".submit").click(function(){
			submit_siteInfo(this,n);
		});
		$(this).prev().prev().children(".cancel").click(function(){
			cancel_siteInfo(this,n);
		});
	});
}
function submit_siteInfo(obj,n){
	var name=$(obj).prev().val();
	var id=$(obj).parent().parent().parent().attr("id");
	var url=$(obj).next().next().next().val();
	var descr=$(obj).next().next().next().next().next().val();
	$.post("?action=add",{
		'table'	:'url_website',
		'name'	:name,
		'site_id':id,
		'url'	:url,
		'descr'	:descr
	},function(str){
			if(str==-1)
			{
				alert('有重名冲突');
			}
			else if(str==1)
			{
				$(obj).parent().next().attr("href",url).attr("title",descr).html($(obj).prev().val()).show().next().show();
				$(obj).parent().remove();
			}
			else
			{
				alert(str);
			}
		});
}
function cancel_siteInfo(obj,n){
	$(obj).parent().next().show().next().show();
	$(obj).parent().remove();
}
function copy(url){
	clipboardData.setData('Text',url);
	alert('内容已复制到剪贴板');
}
