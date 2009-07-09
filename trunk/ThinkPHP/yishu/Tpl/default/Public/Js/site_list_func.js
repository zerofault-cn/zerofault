$(document).ready(function(){
	$(".addform>input#submit_addSite").click(function(){ //点击提交
		submit_addSite(this);
	});

	$(".site_info>img").each(function(i){ //设置分类名称的可编辑功能
		show_editsite(this,i);
	});

	$(".site_func>label").each(function(i){ //设置分类的排序数字的可编辑功能
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
		'cate_id':$("select#cate_id").val(),
		'name': $("input#site_name").val(),
		'url' : $("input#site_url").val(),
		'sort': $("input#site_sort").val(),
		'descr': $("input#site_descr").val()
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
function show_editsite(obj,i){
	$(obj).css("cursor","pointer").click(function(){
		cate_id = $(this).prev().attr('name');
		site_id = $(this).prev().attr('id');
		site_name = $(this).prev().text();
		site_url = $(this).prev().attr('href');
		site_sort = $(this).parent().parent().children(".site_func").text();
		$(".editForm").remove();
		html = '<span class="editForm"><div>';
		html += '所属分类：<select name="cate_id" class="cate_id">';
		$(".addForm>#cate_id").children().each(function(i){
			if(''!=$(this).val()){
				if(cate_id == $(this).val()){
					html += '<option value="'+$(this).val()+'" style="'+$(this).attr('style')+'" selected>'+$(this).text()+'</option>';
				}
				else{
					html += '<option value="'+$(this).val()+'" style="'+$(this).attr('style')+'">'+$(this).text()+'</option>';
				}
			}
		});
		html += '</select>';
		html += '&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="提交" class="submit_editSite"> <input type="button" value="取消" class="cancel_editSite"><br />';
		html += '站点名称：<input type="text" class="site_name" name="site_name" value="'+site_name+'" tabindex="1"/>';
		html += ' 排序：<input type="text" class="site_sort" name="site_sort" value="'+site_sort+'" tabindex="4"><br />';
		html += '站点网址：<input type="text" class="site_url" name="site_url" value="'+site_url+'" tabindex="2"/><br />';
		html += '站点简介：<textarea class="site_descr" name="site_descr" cols="40" rows="4" tabindex="3" ></textarea>';
		html += '</div></span>';
		
		$(this).after(html);
		$(".editForm>div").show('slow');
		$(".editForm input.submit_editSite").click(function(){
			$.post(_URL_+"/add",{
				'table':'Website',
				'cate_id':$(".editForm select.cate_id").val(),
				'site_id':site_id,
				'name': $(".editForm input.site_name").val(),
				'url' : $(".editForm input.site_url").val(),
				'sort': $(".editForm input.site_sort").val(),
				'descr': $(".editForm input.site_descr").val()
			},function(str){
					if(str=='-1')
					{
						myAlert("该名称已经添加过了!");
					}
					else if(str=='1')
					{
						myAlert("更新成功!");
						myLocation("");
					}
					else
					{
						myAlert(str);
					}
				});
		});
		$(".editForm input.cancel_editSite").click(function(){
			$(".editForm>div").hide('slow');
		});
	});
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
