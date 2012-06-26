function show_msg(id, msg) {
	$("#"+id).html(msg);
}
function hide_msg(id, intval) {
	if(intval=='') {
		intval = 2000;
	}
	setTimeout(function() {
		$("#"+id).html("");
	}, intval);
}
function myAlert(msg) {
	$.prompt(msg);
}
function myOK(intval) {
	if(intval=='') {
		intval = 2000;
	}
	setTimeout(function() {
		$("#cleanbluebox").remove();
	}, intval);
}
function myLocation(loc, intval) {
	if(intval=='') {
		intval = 2000;
	}
	setTimeout(function() {
		window.location.href= (loc==''? window.location.href : loc);
		},intval);
}
function myConfirm(str, url) {
	$.prompt(str, {
		submit: function(v, m) {
			if (v) {
				$("#_iframe").attr("src", url);
			}
			return true;
		},
		buttons: {'确定':true, '取消':false}
	});
	return true;
}

$(document).ready(function() {
	if ($("#begin_date").length > 0) {
		$("#begin_date").calendar();
	}
	if ($("#end_date").length > 0) {
		$("#end_date").calendar();
	}

	if($("#calendar_block").length < 1){
		$("<div></div>",{"id":"calendar_block"}).appendTo("body");
	};
	var calendar_block=$("#calendar_block");
	calendar_block.click(function() {
		if ($("dl#hotel_dl").length>0) {
			$("dl#hotel_dl").hide();
		}
	});

	var eg = "如：桃花岭饭店";
	$("input#keyword").val(eg).click(function() {
		if (eg == $(this).val()) {
			$(this).val("");
		}
		else if ($("dl#hotel_dl").length>0) {
			$("dl#hotel_dl").show();
			calendar_block.show();
		}
	}).change(function() {
		var obj = $(this);
		if (""==$.trim($(this).val())) {
			$(this).val(eg);
		}
		else {
			//query
			var category_id = $("input[name=category_id]").val();
			var region_id = $("select[name=region_id]").val();
			$.getJSON(_APP_+"/Book/query", {"category_id": category_id, "region_id": region_id, "keyword": $(this).val()}, function(json) {
				$("dl#hotel_dl").remove();
				var dl = $("<dl />").attr("id", "hotel_dl");
				var n=0;
				$.each(json, function(i, item) {
					var dd = $("<dd />");
					var radio = $("<input />").attr({"type": "radio", "name": "tmp_name", "value": item.id, "id": "hotel_id_"+item.id}).click(function() {
						obj.val($(this).next().children(":eq(0)").html());
						$("input[name=hotel_id]").val($(this).val());
					}).blur(function() {
						$("dl#hotel_dl").hide();
						calendar_block.hide();
					});
					if (0==n) {
						radio.attr("checked", true).focus();
						obj.val(item.name);
					}
					var label = $("<label />").attr({"for": "hotel_id_"+item.id}).html("<span>"+item.name+"</span>"+"&nbsp;("+item.Level.name+")");
					dd.append(radio).append(label);
					n++;
					dl.append(dd);
				});
				if (n>0) {
					calendar_block.css({width:$(window).width(),height:$(document).height()}).show();
					obj.next().append(dl);
				}
			});
		}
	});
	$("input[name=category_id]").each(function() {
		$(this).click(function() {
			if ($(this).attr("checked")) {
				var val = $(this).val();
				var class_name = $(this).attr("class");
				$("input[name=category_id]").val(val);
				$("input[name=alias]").val(class_name);
				if ("meeting" == class_name) {
					$("input[name=begin_date]").parent().prev().text("入住日期：");
					$("input[name=end_date]").parent().parent().show();
					$("input[name=number]").parent().prev().text("会议人数：");
					$("input[name=number]").next().text("人");
				}
				else {
					$("input[name=begin_date]").parent().prev().text("宴会日期：");
					$("input[name=end_date]").parent().parent().hide();
					$("input[name=number]").parent().prev().text("宴会桌数：");
					$("input[name=number]").next().text("桌");
				}
			}
		});
	});
});


