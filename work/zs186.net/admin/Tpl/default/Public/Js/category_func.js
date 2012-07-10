$(document).ready(function(){

	$("img.add").each(function (i) {
		setCategoryForm(this, i);
	});

});

function setCategoryForm(obj, i) {
	$(obj).css("cursor","pointer").click(function(){
		var pid = $(this).parent().parent().attr("id");
		var type = $(this).parent().parent().attr("type");
		$(".editForm").remove();
		var html = '<span class="editForm"><div>';
		html +='<fieldset><legend>添加子分类</legend>';
		html += '<label>名称：</label><input type="text" class="name" value=""><br />';
		html += '<label>排序：</label><input type="text" class="sort" value=""><br />';
		html += '<label>　　　</label><input type="button" value="提交" class="submit"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="取消" class="cancel"/><br />';
		html += '</fieldset></div></span>';
		
		$(this).after(html);
		$(".editForm div").show();
		$(".editForm input.submit").click(function(){
			name = $(".editForm .name").val();
			sort = $(".editForm .sort").val();
			$.post(_URL_+"/add",{
				'pid'  : pid,
				'type': type,
				'name' : name,
				'sort': sort
			},function(str){
					if(str.substr(0,1)=='1') {
						$(".editForm").remove();
						myAlert("提交成功!");
						myLocation('',1000);
					}
					else {
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


