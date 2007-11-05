function countrychange(selectedIndex)
{
	switch(selectedIndex)
	{
		case "0":
			form1.user_from2.length=0;
			form1.user_from2.options.add(new Option("请选择",""));
			break;  
		case "中国":
			form1.user_from2.Length=0;
			form1.user_from2.options.add(new Option("上海","上海"));
			form1.user_from2.options.add(new Option("北京","北京"));
			form1.user_from2.options.add(new Option("天津","天津"));
			form1.user_from2.options.add(new Option("重庆","重庆"));
			form1.user_from2.options.add(new Option("河北","河北"));
			form1.user_from2.options.add(new Option("山西","山西"));
			form1.user_from2.options.add(new Option("辽宁","辽宁"));
			form1.user_from2.options.add(new Option("吉林","吉林"));
			form1.user_from2.options.add(new Option("江苏","江苏"));
			form1.user_from2.options.add(new Option("浙江","浙江"));
			form1.user_from2.options.add(new Option("安徽","安徽"));
			form1.user_from2.options.add(new Option("福建","福建"));
			form1.user_from2.options.add(new Option("江西","江西"));
			form1.user_from2.options.add(new Option("山东","山东"));
			form1.user_from2.options.add(new Option("河南","河南"));
			form1.user_from2.options.add(new Option("湖北","湖北"));
			form1.user_from2.options.add(new Option("湖南","湖南"));
			form1.user_from2.options.add(new Option("广东","广东"));
			form1.user_from2.options.add(new Option("广西","广西"));
			form1.user_from2.options.add(new Option("海南","海南"));
			form1.user_from2.options.add(new Option("四川","四川"));
			form1.user_from2.options.add(new Option("贵州","贵州"));
			form1.user_from2.options.add(new Option("云南","云南"));
			form1.user_from2.options.add(new Option("西藏","西藏"));
			form1.user_from2.options.add(new Option("陕西","陕西"));
			form1.user_from2.options.add(new Option("甘肃","甘肃"));
			form1.user_from2.options.add(new Option("宁夏","宁夏"));
			form1.user_from2.options.add(new Option("青海","青海"));
			form1.user_from2.options.add(new Option("新疆","新疆"));
			form1.user_from2.options.add(new Option("内蒙古","内蒙古"));
			form1.user_from2.options.add(new Option("黑龙江","黑龙江"));
			break;
		case "中国其他":
			form1.user_from2.length=0;
			form1.user_from2.options.add(new Option("香港特区","香港特区"));
			form1.user_from2.options.add(new Option("澳门特区","澳门特区"));
			form1.user_from2.options.add(new Option("台湾","台湾"));
			break;
		case "其他国家":
			form1.user_from2.length=0;
			form1.user_from2.options.add(new Option("其他国家","其他国家"));
			break;          
	}
}