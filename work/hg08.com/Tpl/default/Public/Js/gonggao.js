//滚动公告
function AutoScroll(obj){
	$(obj).find("ul:first").animate({
		marginTop:"-25px"
		},500,function() {
			$(this).css({marginTop:"0px"}).find("li:first").appendTo(this);
		});
}
var s = true;
var t=0;
function startli() {
	if(s) {
		t = setInterval('AutoScroll(".scrollDiv")',2000);
	}
}

$(document).ready(function(){
	startli();
	$(".scrollDiv").hover(
		function() {
			clearInterval(t);
			var s = false;
		},
		function() {
			s = true;
			startli();
		});
})

