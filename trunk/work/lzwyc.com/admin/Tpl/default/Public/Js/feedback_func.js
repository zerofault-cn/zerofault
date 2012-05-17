var reply_btn = null;
$(document).ready(function(){
	//新的回复
	$("input.reply").each(function(i) {
		$(this).click(function(){
			//关闭已打开的编辑框
			if (null != reply_btn) {
				$("fieldset.reply").remove();
				reply_btn.next().hide();
				reply_btn.show();
			}
			reply_btn = $(this);
			var html = '';
			html +='<fieldset style="border:1px dashed red;color:red;" class="reply"><legend>管理员回复</legend>';
			html += '<textarea class="reply" name="reply" cols="40" rows="4"></textarea>';
			html += '&nbsp;&nbsp;<input type="button" value="提交" class="submit"/>&nbsp;<input type="button" value="取消" class="cancel"/>';
			html += '</fieldset>';
			reply_btn.before(html);
			reply_btn.hide();
			
			$("fieldset.reply input.submit").click(function(){
				$.post(_URL_+"/reply",{
					'id' : reply_btn.parent().parent().attr('id'),
					'reply': $("fieldset.reply textarea.reply").val()
				},function(str){
						if(str=='1')
						{
							myAlert("回复成功!");
							myLocation("",1500);
						}
						else
						{
							myAlert(str);
						}
					});
			});
			$("fieldset.reply input.cancel").click(function() {
				$("fieldset.reply").remove();
				reply_btn.show();
			});
		});
	});
	//编辑回复
	$("fieldset div.reply").each(function(i) {
		$(this).mouseover(function(){
			$(this).addClass("editable");
		}).mouseout(function(){
			$(this).removeClass("editable");
		}).click(function() {
			//关闭已打开的编辑框
			if (null != reply_btn) {
				$("fieldset.reply").remove();
				reply_btn.next().hide();
				reply_btn.show();
			}
			reply_btn = $(this);
			reply_btn.hide();
			reply_btn.next().show();

			$("fieldset input.submit").click(function(){
				$.post(_URL_+"/reply",{
					'id' : reply_btn.parent().parent().attr('id'),
					'reply': reply_btn.next().children("textarea").val()
				},function(str){
						if(str=='1')
						{
							myAlert("回复成功!");
							myLocation("",1500);
						}
						else
						{
							myAlert(str);
						}
					});
			});
			$("fieldset input.cancel").click(function() {
				reply_btn.next().hide();
				reply_btn.show();
			});
		});
	});
});