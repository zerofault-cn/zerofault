/*
日期选择器
http://code.ciaoca.cn/
日期：2011-11-16

settings 参数说明
-----
begin_year:开始年份
end_year:结束年份
date:默认日期
type:日期格式
hyphen:日期链接符
wday:周第一天
------------------------------ */
(function($){
	$.fn.calendar=function(settings){
		if(this.length<1){return;};

		// 默认值
		settings=$.extend({
			begin_year:1950,
			end_year:2030,
			date:new Date(),
			type:"yyyy-mm-dd",
			hyphen:"-",
			wday:0
		},settings);

		var date_obj=this;

		// 获取默认日期
		if(date_obj.val().length>0){
			settings.date=date_obj.val();
			settings.date=settings.date.replace(/\./g,"/");
			settings.date=settings.date.replace(/-/g,"/");
			settings.date=settings.date.replace(/\//g,"/");
			settings.date=Date.parse(settings.date);
		};
		settings.date=new Date(settings.date);
		if(isNaN(settings.date.getFullYear())){
			settings.date=new Date();
		};
		settings.date.setHours(0);
		settings.date.setMinutes(0);
		settings.date.setSeconds(0);

		var def_year=settings.date.getFullYear();
		var def_month=settings.date.getMonth()+1;
		var def_day=settings.date.getDate();

		// 判断闰年
		var leapYear=function(y){
			return ((y%4==0 && y%100!=0) || y%400==0) ? 1 : 0;
		};

		// 定义每月的天数
		var date_name_month=new Array(31,28+leapYear(def_year),31,30,31,30,31,31,30,31,30,31);

		// 定义每周的日期
		var date_name_week=["日","一","二","三","四","五","六"];

		// 定义周末
		var saturday=6-settings.wday;
		var sunday=(7-settings.wday>=7) ? 0 : (7-settings.wday);

		// 创建选择器
		var date_pane,date_title,date_table,temp_html;
		date_pane=$("<div></div>",{"class":"html_calendar"}).appendTo("body");
		date_title=$("<h5></h5>",{"class":"title"}).appendTo($(date_pane));
		date_table=$("<table></table>").appendTo($(date_pane));

		if($("#calendar_block").length<1){
			$("<div></div>",{"id":"calendar_block"}).appendTo("body");
		};
		var calendar_block=$("#calendar_block");

		temp_html="<select class='year'>";
		for(var i=settings.begin_year;i<=settings.end_year;i++){
			temp_html+="<option value='"+i+"'>"+i+"</option>";
		};
		temp_html+="</select><span>年</span><select class='month'>";
		for(var i=1;i<=12;i++){
			temp_html+="<option value='"+i+"'>"+i+"</option>";
		};
		temp_html+="</select><span>月</span>";
		date_title.html(temp_html);

		var select_year,select_month,date_exit;
		select_year=date_title.find("select.year");
		select_month=date_title.find("select.month");
		date_exit=date_title.find("em");

		select_year.val(def_year);
		select_month.val(def_month);

		temp_html="<thead><tr>";
		for(var i=0;i<7;i++){
			temp_html+= (i+settings.wday<7) ? "<th>"+date_name_week[i+settings.wday]+"</th>" : "<th>"+date_name_week[i+settings.wday-7]+"</th>";
		};
		temp_html+="</tr></thead>";
		temp_html+="<tfoot><td colspan='2'><a class='pre'>&lt;&lt;</a></td><td colspan='3'><a class='clear'>清除</a></td><td colspan='2'><a class='next'>&gt;&gt;</a></td></tfoot>";
		temp_html+="<tbody></tbody>";
		date_table.html(temp_html);

		// 高亮周末
		var table_th=date_table.find("thead").find("th");
		table_th.eq(saturday).addClass("sat");
		table_th.eq(sunday).addClass("sun");

		// 上一月、下一月、清除
		var date_pre,date_next,date_clear;
		date_pre=date_table.find("tfoot").find(".pre");
		date_next=date_table.find("tfoot").find(".next");
		date_clear=date_table.find("tfoot").find(".clear");

		// 更改日历函数
		var dateChange=function(y,m){
			if(m<1){
				y--;
				m=12;
			}else if(m>12){
				y++;
				m=1;
			};
			m--;

			if(y<settings.begin_year){
				y=settings.end_year;
			}else if(y>settings.end_year){
				y=settings.begin_year;
			};

			date_name_month[1]=28+leapYear(y);
			temp_html="";
			var temp_date=new Date(y,m,1);
			var now_date=new Date();
			now_date.setHours(0);
			now_date.setMinutes(0);
			now_date.setSeconds(0);

			var val_date=new Date();
			val_date.setHours(0);
			val_date.setMinutes(0);
			val_date.setSeconds(0);
			val_date=date_obj.val();
			val_date=val_date.replace(/\./g,"/");
			val_date=val_date.replace(/-/g,"/");
			val_date=val_date.replace(/\//g,"/");
			val_date=new Date(Date.parse(val_date));
			if(isNaN(val_date.getFullYear())){
				val_date=null;
			};

			// 获取当月第一天
			var firstday=(temp_date.getDay()-settings.wday<0) ? temp_date.getDay()-settings.wday+7 : temp_date.getDay()-settings.wday;
			// 每月所需要的行数
			//var tr_row=Math.ceil((date_name_month[m]+firstday)/7);
			var tr_row=6;
			var td_num,day_num,diff_now,diff_set;

			for(var i=0;i<tr_row;i++){
				temp_html+="<tr>";
				for(var k=0;k<7;k++){
					td_num=i*7+k;
					day_num=td_num-firstday+1;
					day_num=(day_num<=0 || day_num>date_name_month[m]) ? "" : td_num-firstday+1;

					temp_html+="<td ";

					// 高亮今天和选中日期
					diff_now=null;
					diff_set=null;
					if(typeof(day_num)=="number"){
						temp_date=new Date(y,m,day_num);
						diff_now=Date.parse(now_date)-Date.parse(temp_date);
						diff_set=Date.parse(val_date)-Date.parse(temp_date);
						temp_html+=(" data-set='num' title='"+y+settings.hyphen+m+settings.hyphen+day_num+"'");
					};

					if(diff_set==0){
						temp_html+=" class='selected'";
					}else if(diff_now==0){
						temp_html+=" class='now'";
					};
					temp_html+=(">"+day_num+"</td>");

				};
				temp_html+="</tr>";
			};
			date_table.find("tbody").html(temp_html);

			var table_tr=date_table.find("tbody").find("tr");
			var table_td=date_table.find("tbody").find("td[data-set='num']");
			table_td.addClass("num").bind("click",function(){
				table_td.removeClass("selected");
				$(this).addClass("selected");
				dateSelect($(this).text());
			});

			// 高亮周末
			table_tr.find("td:eq("+saturday+")").addClass("sat");
			table_tr.find("td:eq("+sunday+")").addClass("sun");

			select_year.val(y);
			select_month.val(m+1);
		};

		// 第一次初始化
		dateChange(def_year,def_month);

		// 选择日期函数
		var dateSelect=function(d){
			var temp_month,temp_day;
				temp_month=select_month.val();
				temp_day=d;
			if(settings.type=="yyyy-mm-dd"){
				temp_month="0"+select_month.val();
				temp_day="0"+d;
				temp_month=temp_month.substr((temp_month.length-2),temp_month.length);
				temp_day=temp_day.substr((temp_day.length-2),temp_day.length);
			};
			date_obj.val(select_year.val()+settings.hyphen+temp_month+settings.hyphen+temp_day);
			dateExit();
		};

		// 关闭日期函数
		var dateExit=function(){
			date_pane.hide();
			calendar_block.hide();
		};

		// 显示面板事件
		date_obj.bind("click",function(){
			var win=$(window);
			var win_w=win.width();
			var win_h=win.height();
			var doc=$(document);
			var doc_w=doc.width();
			var doc_h=doc.height();
			var pane_w=date_pane.outerWidth();
			var pane_h=date_pane.outerHeight();
			var pane_top=date_obj.offset().top;
			var pane_left=date_obj.offset().left;
			var obj_w=date_obj.outerWidth();
			var obj_h=date_obj.outerHeight();
			
			pane_top=((pane_top+pane_h+obj_h)>doc_h) ? pane_top-pane_h : pane_top+obj_h;
			pane_left=((pane_left+pane_w)>doc_w) ? pane_left-(pane_w-obj_w) : pane_left;
			
			date_pane.css({"top":pane_top,"left":pane_left}).show();
			calendar_block.css({width:$(window).width(),height:$(document).height()}).show();
		});

		// 更改年月事件
		select_year.bind("change",function(){
			dateChange(select_year.val(),select_month.val());
		});
		select_month.bind("change",function(){
			dateChange(select_year.val(),select_month.val());
		});

		// 上月、下月事件
		date_pre.bind("click",function(){
			dateChange(select_year.val(),parseInt(select_month.val())-1);
		});
		date_next.bind("click",function(){
			dateChange(select_year.val(),parseInt(select_month.val())+1);
		});

		// 清除事件
		date_clear.bind("click",function(){
			date_obj.val("");
			dateChange(def_year,def_month);
			dateExit();
		});

		// 关闭面板事件
		calendar_block.bind("click",function(){
			dateExit();
		});
	};
})(jQuery);