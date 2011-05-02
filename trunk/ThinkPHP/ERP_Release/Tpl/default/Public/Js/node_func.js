$(document).ready(function(){

	$("img.edit").each(function(i){ //设置节点信息可编辑
		setNodeEditable(this,i);
	});

});

function setNodeEditable(obj,i){
	$(obj).css("cursor","pointer").click(function(){
		var id = $(this).prev().attr('id');
		var pid= $(this).prev().attr('pid');
		var name = $(this).prev().attr('name');
		var title = $(this).prev().attr('title');
		if(''==title) {
			title = name;
		}
		$(".editForm").remove();
		var html = '<span class="editForm"><div>';
		html +='<fieldset><legend>Edit Node Info</legend>';
		html += '<label>Name: </label>'+name+'<br />';
		html += '<label>Title: </label><input type="text" class="title" value="'+title+'"><br />';
		html += '<label>　　　</label><input type="button" value="Submit" class="submit"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" class="cancel"/><br />';
		html += '</fieldset></div></span>';
		
		$(this).after(html);
		$(".editForm div").show('slow');
		$(".editForm input.submit").click(function(){
			title = $(".editForm .title").val();
			$.post(_URL_+"/update",{
				'id'   : id,
				'pid'  : pid,
				'name' : name,
				'title': title
			},function(str){
					if(str.substr(0,1)=='1')
					{
						if('0'==pid) {
							myAlert("Submit success!");
							myLocation('',1000);
						}
						else{
							id = str.substr(2);
							$(obj).prev().attr('class', 'c'+id);
							$(obj).prev().attr('id', id);
							$(obj).prev().attr('title', title);
							$(obj).prev().html(''==title ? name : title);
							$(obj).attr('src',IMAGE_FOLDER+'form_edit.gif');
							$(".editForm").remove();
							myAlert("Submit success!");
							myOK(1000);
						}
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


