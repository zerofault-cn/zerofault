function infen(var1){
	var fentip=new Array("","很差，浪费生命","很差，浪费生命","不喜欢","不喜欢","一般，不妨一看","一般，不妨一看","一般，不妨一看","喜欢，值得推荐","喜欢，值得推荐","非常喜欢，不容错过");
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
						myAlert("您已经给该网站评过分了!");
					}
					else if(str=='1')
					{
						location.reload();
					}
					else
					{
						myAlert(str);
					}
				});
		});
	});
});