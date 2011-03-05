function init() {
}
function load(module) {
	$.get(module+'.inc',
		function(html) {
			$("#right_wrapper").html(html);
		});
}