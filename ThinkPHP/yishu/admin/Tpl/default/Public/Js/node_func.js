$(document).ready(function(){

	$("img.edit").each(function(i){ //设置节点信息可编辑
		setNodeEditable(this,i);
	});

});

function setNodeEditable(obj,i){
	var level_arr = new Array();
	level_arr['1'] = '项目节点';
	level_arr['2'] = '模块节点';
	level_arr['3'] = '方法节点';
	$(obj).css("cursor","pointer").click(function(){
		var id = $(this).prev().attr('id');
		var pid= $(this).prev().attr('pid');
		var name = $(this).prev().attr('name');
		var title = $(this).prev().attr('title');
		var descr = $(this).prev().attr('descr');
		var level = $(this).prev().attr('level');
		$(".editForm").remove();
		var html = '<span class="editForm"><div>';
		html +='<fieldset><legend>编辑节点信息</legend>';
		html += '<label>属性：</label>'+level_arr[level]+'<br />';
		html += '<label>标识：</label>'+name+'<br />';
		html += '<label>别名：</label><input type="text" class="title" value="'+title+'"><br />';
		html += '<label>描述：</label><input type="text" class="descr" value="'+descr+'"><br />';
		html += '<label>　　　</label><input type="button" value="提交" class="submit"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="取消" class="cancel"/><br />';
		html += '</fieldset></div></span>';
		
		$(this).after(html);
		$(".editForm div").show('slow');
		$(".editForm input.submit").click(function(){
			title = $(".editForm .title").val();
			descr = $(".editForm .descr").val();
			$.post(_URL_+"/update",{
				'id'   : id,
				'pid'  : pid,
				'name' : name,
				'title': title,
				'descr': descr,
				'level': level
			},function(str){
					if(str.substr(0,1)=='1')
					{
						id = str.substr(2);
						$(obj).prev().attr('class', 'c'+id);
						$(obj).prev().attr('id', id);
						$(obj).prev().attr('title', title);
						$(obj).prev().attr('descr', descr);
						$(obj).prev().html(''==title ? name : title);
						$(obj).attr('src',IMAGE_FOLDER+'form_edit.gif');
						$(".editForm").remove();
						myAlert("提交成功!");
						myLocation('',1000);
					}
					else
					{
						myAlert(str);
					}
				});
		});
		$(".editForm input.cancel").click(function(){
			$(".editForm div").hide('slow');
		});
		$(document).keydown(function(e){
			var keyCode=e.keyCode ||window.event.keyCode;
			if(keyCode==27)//Esc
			{
				$(".editForm div").hide('slow');
			}
		});
	});
}


