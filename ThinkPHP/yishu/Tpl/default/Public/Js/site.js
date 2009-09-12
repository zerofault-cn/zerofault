function infen(var1){
	var fentip=new Array("","很差，浪费生命","很差，浪费时间","不喜欢","不好看","一般，可看可不看","没事可以看一看","还可以，不妨一看","喜欢，值得推荐","精彩，值得推荐","非常喜欢，不容错过");
	if (var1>0){
		GI("pfno").innerHTML=var1+"分 ";
		GI("pftip").innerHTML=fentip[var1];
		GI("currentrating").style.display="none";
	}
	else{
		GI("pfno").innerHTML="";
		GI("pftip").innerHTML="";
		GI("currentrating").style.display="block";
	}
}
function GI(id){
	return document.getElementById(id);
}
function getPage(p){
	get_comment(p);
}
function get_comment(p){
	jQuery("#comment").html('<img style="padding:20px;" src="'+APP_PUBLIC_URL+'/Images/ajaxloading.gif"/>');
	jQuery.get(_URL_+"/get_comment",{
		'site_id':site_id,
		'p':p
	},function(str){
			jQuery("#comment").html(str);
		});
	document.comment_form.content.value='';
	document.comment_form.verify.value='';
	jQuery("#comment_form img").attr('src',_URL_+'/verify?r='+Math.random());
}
jQuery.noConflict();
jQuery(document).ready(function(){
	jQuery(".starrating li a").each(function(i){
		jQuery(this).click(function(){
			jQuery.post(_URL_+"/vote",{
				'site_id': site_id,
				'vote': jQuery(this).text()
			},function(str){
					if(str=='-1')
					{
						myAlert("您已经给该网站评过分了，谢谢您的热心参与！");
						myOK(2000);
					}
					else if(str=='0')
					{
						myAlert('有错误发生，请稍后再试！');
					}
					else
					{
						myAlert("评分成功，谢谢您的热心参与！");
						myOK(1500);
						var arr = str.split('|');
						jQuery("#vote_count").text(arr[0]);
						jQuery("#vote").html(arr[1].substr(0,1)+'<small>'+arr[1].substr(1)+'</small>');
						jQuery("#currentrating").css("width",arr[2]+'px');
					}
				});
		});
	});
	jQuery.get(_URL_+"/get_comment",{
		'site_id':site_id
	},function(str){
			jQuery("#comment").html(str);
		});
	jQuery("span#username input:checkbox").click(function(){
		if(jQuery(this).attr("checked")) {
			jQuery("span#username").html('<input type="hidden" name="name" value="匿名"/><input type="checkbox" name="anonymous" value="1" checked="true"/>匿名发表');
		}
		else{
			jQuery("span#username").html('称呼：<input type="text" name="name" value="匿名" size="8" maxlength="20"/>');
		}
	});
});