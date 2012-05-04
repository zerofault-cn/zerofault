$(document).ready(function(){

	$("img.thumb").each(function(i){
		$(this).css("cursor","pointer").mouseover(function(){
			$(this).next(".showThumb").children("div").show();
		}).mouseout(function(){
			$(this).next(".showThumb").children("div").hide();
		}).click(function(){
			$(this).next(".showThumb").children("div").hide();
			var site_id = $(this).attr('id');
			var attach_type = $(this).attr('name');
			var attach_ext = '.jpg';
			showAttachEdit(this,site_id,attach_type,attach_ext);
		});
	});

	$("table td label").each(function(i){ //设置排序数字可编辑
		setSortEditable(this,i);
	});
});



function showAttachEdit(obj,site_id,attach_type,attach_ext){
	if(attach_type=='photo'){
		var title = '上传形象照(JPG格式,宽150像素)';
	}
	else{
		var title = '上传公司Logo(JPG格式,宽150像素)';
	}
	$(".editAttach").remove();
	var html = '<span class="editAttach"><div>';
	html += title+'<br />';
	html += '<img id="loading" src="'+IMAGE_FOLDER+'loadingAnimation.gif" style="position:absolute;left:36px;top:60px;display:none;z-index:999;" aligh="middle">';
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
			url:_APP_+'/Attach/upload/t/'+attach_type+'/id/'+site_id, 
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
	$("#_iframe").attr("src", _URL_+"/update/id/"+$(obj).parent().prev().attr('id')+"/f/sort/v/"+$(obj).parent().children("input").val());
}
function cancel_sort(obj,n){//取消更改分类排序,公用
	$(obj).parent().prev().show();
	$(obj).parent().remove();

}
