$(document).ready(function(){
	$(".addForm input.submit_addSite").click(function(){ //点击提交
		submit_addSite(this);
	});

	$("img.logo").each(function(i){
		$(this).css("cursor","pointer").click(function(){
			var site_id = $(this).attr('id');
			var attach_type = 'logo';
			var attach_ext = '.gif';
			showAttachEdit(this,site_id,attach_type,attach_ext);
		});
	});

	$(".site_info img.edit_info").each(function(i){ //设置站点资料可编辑
		setInfoEditable(this,i);
	});

	$(".site_info img.thumb").each(function(i){
		$(this).css("cursor","pointer").mouseover(function(){
			$(this).next(".showThumb").children("div").show();
		}).mouseout(function(){
			$(this).next(".showThumb").children("div").hide();
		}).click(function(){
			$(this).next(".showThumb").children("div").hide();
			var site_id = $(this).attr('id');
			var attach_type = 'thumb';
			var attach_ext = '.jpg';
			showAttachEdit(this,site_id,attach_type,attach_ext);
		});
	});

	$(".site_func>label").each(function(i){ //设置排序数字的可编辑
		setSortEditable(this,i,'Website');
	});
});

function submit_addSite(obj){ //提交新的分类
	if(''==$(".addForm .site_name").val())
	{
		myAlert('站点名称不能为空');
		$(".addForm .site_name").focus();
		return false;
	}
	$.post(_URL_+"/add",{
		'table':'Website',
		'cate_id':$(".addForm .cate_id").val(),
		'name': $(".addForm .site_name").val(),
		'url' : $(".addForm .site_url").val(),
		'sort': $(".addForm .site_sort").val(),
		'descr': $(".addForm .site_descr").val()
	},function(str){
			if(str=='-1')
			{
				myAlert("该名称已经添加过了!");
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

function showAttachEdit(obj,site_id,attach_type,attach_ext){
	if(attach_type=='logo'){
		var title = '上传Logo图片(Gif格式,宽100像素)';
	}
	else{
		var title = '上传网站缩略图(Jpg格式,宽400像素)';
	}
	$(".editAttach").remove();
	var html = '<span class="editAttach"><div>';
	html += title+'<br />';
	html += '<img id="loading" src="'+IMAGE_FOLDER+'ajaxloading.gif" style="position:absolute;left:36px;top:60px;display:none;z-index:999;" aligh="middle">';
	html += '<form name="form" action="" method="POST" enctype="multipart/form-data">';
	html += '<input type="file" id="attach" class="file" name="attach" /><br />'
	html += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="上传" class="submit"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="取消" class="cancel"/>';
	html += '</form>';
	html += '</div></span>';
	$(obj).after(html);
	$(".editAttach>div").show('slow');
	$(".editAttach input.cancel").click(function(){
		$(".editAttach>div").hide('slow');
	});
	$(".editAttach input.submit").click(function(){
		if(checkFileExt($("#attach").val(),attach_ext)==false){
			return false;
		}
		$("#loading").ajaxStart(function(){
			$(this).show();
		}).ajaxComplete(function(){
			$(this).hide();
		});
		$.ajaxFileUpload({
			url:_APP_+'/Attach/upload/t/'+attach_type+'/id/'+site_id+'/', 
			secureuri:false,
			fileElementId:'attach',
			dataType: 'text',
			success: function (data, status)
			{
				if(data=='1'){
					myAlert('上传成功！');
					$(".editAttach").remove();
					
					if(attach_type!='logo'){
						$(obj).attr('src',IMAGE_FOLDER+'picture.gif');
						$(obj).next(".showThumb").show();
						$(obj).next(".showThumb").children("div").hide();
					
						obj = $(obj).next().children('div').children('img');
					}
					$(obj).attr('src',_APP_+'/../Html/Attach/'+attach_type+'/'+site_id+attach_ext+'?'+Math.random());
					myOK(1200);
				}
				else{
					myAlert('上传失败!<br />'+data);
				}
			},
			error: function (data, status, e)
			{
				myAlert(e);
			}
		});
	});
	$(document).keydown(function(e){
		var keyCode=e.keyCode ||window.event.keyCode;
		if(keyCode==27)//取消健
		{
			$(".editAttach>div").hide('slow');
		}
	});
}
function checkFileExt(filename,allowed_ext){
	var fileext = filename.substr(filename.lastIndexOf('.')).toLowerCase();
	if(fileext != allowed_ext){
		myAlert("只能上传 "+allowed_ext+" 格式的图片！");
		return false;
	}
	return true;
}

function setInfoEditable(obj,i){
	$(obj).css("cursor","pointer").click(function(){
		var cate_id = $(this).prev().attr('name');
		var site_id = $(this).prev().attr('id');
		var site_name = $(this).prev().text();
		var site_url = $(this).prev().attr('href');
		var site_descr = $(this).prev().attr('title');
		var site_sort = $(this).parent().parent().children(".site_func").text();
		$(".editForm").remove();
		var html = '<span class="editForm"><div>';
		html +='<fieldset><legend>编辑网站信息</legend>';
		html += '所属分类：<select name="cate_id" class="cate_id">';
		$(".addForm .cate_id").children().each(function(i){
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
		html += '&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="提交" class="submit_editSite"/> <input type="button" value="取消" class="cancel_editSite"/><br />';
		html += '网站名称：<input type="text" class="site_name" name="site_name" value="'+site_name+'" tabindex="1"/>';
		html += ' 排序：<input type="text" class="site_sort" name="site_sort" value="'+site_sort+'" tabindex="4"><br />';
		html += '网站地址：<input type="text" class="site_url" name="site_url" value="'+site_url+'" tabindex="2"/><br />';
		html += '网站简介：<textarea class="site_descr" name="site_descr" cols="40" rows="4" tabindex="3" >'+site_descr+'</textarea>';
		html += '</fieldset></div></span>';
		
		$(this).after(html);
		$(".editForm>div").show('slow');
		$(".editForm input.submit_editSite").click(function(){
			$.post(_URL_+"/add",{
				'table':'Website',
				'cate_id':$(".editForm .cate_id").val(),
				'site_id':site_id,
				'name': $(".editForm .site_name").val(),
				'url' : $(".editForm .site_url").val(),
				'sort': $(".editForm .site_sort").val(),
				'descr': $(".editForm .site_descr").val()
			},function(str){
					if(str=='-1')
					{
						myAlert("该名称已经添加过了!");
					}
					else if(str=='1')
					{
						myAlert("更新成功!");
						myLocation("",1500);
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
		$(document).keydown(function(e){
			var keyCode=e.keyCode ||window.event.keyCode;
			if(keyCode==27)//取消健
			{
				$(".editForm>div").hide('slow');
			}
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
		html1='<span><input class="quickedit" type="text" value="'+html0+'" size="'+html0.length+'"> <i class="submit"><img src="'+IMAGE_FOLDER+'accept.gif" alt="提交" align="absmiddle"/></i><i class="cancel"><img src="'+IMAGE_FOLDER+'cancel.gif" alt="取消" align="absmiddle"/></i></span>';
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
