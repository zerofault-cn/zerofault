<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="zh-cn" />
<meta name="keywords" content="交友; 爱情; 婚姻; 婚介; 交友中心; 世纪佳缘; 世纪家园; 复旦；小龙女;龚海燕;神经元; 上海交友; 北京交友; 广州交友; 杭州交友; 武汉交友;大连交友; 天津交友; 深圳交友; 南京交友;西安交友; 成都交友; 重庆交友; 厦门交友; 哈尔滨交友; 长春交友; 沈阳交友; 济南交友;" />
<meta name="description" content="如果你正在苦苦寻觅你的爱情，那么世纪佳缘也许是最好的选择。世纪佳缘交友网是一个纯洁的以爱情为目的的交友网。其主要特点是：纯洁性（寻觅爱情是唯一的目的），高品味（研究生及以上学历占一半左右）" />
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate" />
<meta http-equiv="expires" content="Wed, 26 Feb 1997 08:21:57 GMT" />
<meta http-equiv="expires" content="0" />

<link href="http://images.love21cn.com/m/usercp/c/myindex.css" rel="stylesheet" type="text/css" media="all" />
<link href="http://images.love21cn.com/m/usercp/c/myzone.css" rel="stylesheet" type="text/css" media="all" />

<script src="http://images.love21cn.com/m/global/j/global.js" type="text/javascript"></script>
<script type="text/javascript" src="http://images.love21cn.com/w/global/j/work_location_array.js"></script>
<script type="text/javascript" src="http://images.love21cn.com/w/global/j/school_array.js"></script>
<script type="text/javascript">
function redirect(object, selectValue, defaultValue, isUniversity)
{
	for (m = object.options.length; m >= 0; m--)
	{
		object.options[m] = null;
	}

	var newOption = '';
	var selected = ''
	var key;
	if (isUniversity)
	{
		for (key in SOK[selectValue])
		{
			newOption = new Option(SOK[selectValue][key], key);
			if (key == defaultValue)
			{
				newOption.id='opt_selected'+object.id;
			}
			object.options.add(newOption);
		}
		if (my_getbyid('opt_selected'+object.id))
		{
			my_getbyid('opt_selected'+object.id).selected = true;
		}
	}
	else
	{
		for (key in COK[selectValue])
		{
			newOption = new Option(COK[selectValue][key], key);
			if (key == defaultValue)
			{
				newOption.id='opt_selected'+object.id;
			}
			object.options.add(newOption);
		}
		if (my_getbyid('opt_selected'+object.id))
		{
			my_getbyid('opt_selected'+object.id).selected = true;
		}
	}
}
function get_edit(id)
{
	my_getbyid('div_'+id).style.display = 'none';
	my_getbyid('div_'+id+'_edit').style.display = 'block';
	if (id == 'language')
	{
		my_getbyid('em_'+id).innerHTML="<a href=\"javascript:doedit('"+id+"',0);\">保存</a>&nbsp;&nbsp;<a href=\"javascript:cancel_edit('"+id+"')\">取消</a>";
	}
	else
	{
		my_getbyid('em_'+id).innerHTML="<a href=\"javascript:doedit('"+id+"',my_getbyid('"+id+"').value);\">保存</a>&nbsp;&nbsp;<a href=\"javascript:cancel_edit('"+id+"')\">取消</a>";
	}
}
function cancel_edit(id)
{
	my_getbyid('div_'+id+'_edit').style.display = 'none';
	my_getbyid('div_'+id).style.display = 'block';
	my_getbyid('em_'+id).innerHTML="<a href=\"javascript:get_edit('"+id+"')\">修改</a>";
}
function doedit(id,value)
{
	var xmlHttp;
	try
	{    // Firefox, Opera 8.0+, Safari    
		xmlHttp=new XMLHttpRequest();
	}
	catch (e)
	{    // Internet Explorer    
		try
		{
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			try
			{
				xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e)
			{
				alert("Your browser does not support AJAX!");
				return false;
			}
		}
	}
	var url;
	if (id == 'work_sublocation')
	{
		url = "/usercp/profiledo.php?id="+id+"&value="+value+"&work_location="+my_getbyid('work_location').value;
	}
	else if (id == 'home_sublocation')
	{
		url = "/usercp/profiledo.php?id="+id+"&value="+value+"&home_location="+my_getbyid('home_location').value;
	}
	else if (id == 'university')
	{
		url = "/usercp/profiledo.php?id="+id+"&value="+value+"&uni_location="+my_getbyid('uni_location').value;
	}
	else if (id == 'language')
	{
		url = "/usercp/profiledo.php?id="+id+"&value=";
		for (i=0;i<29;i++)
		{
			if (my_getbyid('language_'+i) && my_getbyid('language_'+i).checked)
			{
				value+=Math.pow(2,i);
			}
		}
		url += value.toString();
	}
	else if (id == 'true_name' || id == 'id_card' || id == 'mobile' || id == 'phone')
	{
		value = encodeURIComponent(value);
		url = "/usercp/profiledo.php?id="+id+"&value="+value;
	}
	else
	{
		url = "/usercp/profiledo.php?id="+id+"&value="+value;
	}
	xmlHttp.onreadystatechange=function()
	{
		if(xmlHttp.readyState==4)
		{
			if (id == 'true_name' || id == 'id_card' || id == 'mobile' || id == 'phone' || id == 'MSN' || id == 'QQ')
			{
				my_getbyid('div_'+id).innerHTML=decodeURIComponent(xmlHttp.responseText);
			}
			else
			{
				my_getbyid('div_'+id).innerHTML=xmlHttp.responseText;
			}
			my_getbyid('div_'+id).style.display='block';
			my_getbyid('div_'+id+'_edit').style.display='none';
			my_getbyid('em_'+id).innerHTML="<a href=\"javascript:get_edit('"+id+"')\">修改</a>";
		}
	}
	xmlHttp.open("GET",url,true);

	xmlHttp.send(null);
}
</script>

<title>个人详情_佳缘交友_MSN中国</title>
</head>

<body>
<div id="love21cn_layout">
<!-- 插入标准头js -->
<script type="text/javascript" src="http://images.love21cn.com/m/global/j/head.js"></script>
<!-- 页面内容开始 -->
<div id="index_wapper">

<!-- mylove21cntop -->

<div class="mylove21cntop">
<h2><a href="/usercp/status.php">征友状态</a>：征友进行中</h2>
<h3><span><img src="http://images.love21cn.com/m/global/i/new.gif"><a href="/usercp/interest.php">完善资料展现真我&gt;&gt;</a></span><a id="strong_nick" href="/profile/index.php?uidhash=2a873a061e8fd1e9ec447bd405e6d187" target="_blank">zerofault</a> </h3>
</div>

<!--   -->
<div class="mylove21cn">
<div class="mylove21cn_data">
<h2>
<div class="mylove21cn_title">
<div class="mylove21cn_nav_b mylove21cn_nav_v_on"><a href="/usercp/profile.php">&nbsp;个人详情</a></div>
<div class="mylove21cn_nav_a"><a href="/usercp/note.php">&nbsp;内心独白</a></div>
<div class="mylove21cn_nav_c"><a href="/usercp/interest.php">&nbsp;兴趣生活</a></div>
<div class="mylove21cn_nav_e"><a href="/usercp/article.php">&nbsp;我的日记</a></div>
</div>
</h2>

<form id="frmedit" method="post" action="profileedit.php">
<h3>个人详情--真实的我</h3>
<ul>
<li><span>用户名：</span><div id="name">zerofault@gmail.com</div></li>
<li><span>昵称：</span><div id="nickname">zerofault</div></li>
<li><span>性别：</span><div id="sex">男</div></li>
<li><span>出生日期：</span><div id="birthday">1981-12-17</div></li>
<li><span>星座：</span><div id="zodiac">射手座</div></li>
<li><span>生肖：</span><div id="animal">鸡</div></li>
<li>
	<em id="em_marriage"><a href="javascript:get_edit('marriage')">修改</a></em>
	<span>婚姻状况：</span>
	<div id="div_marriage">未婚</div>
	<div id="div_marriage_edit" class="divedit"><select name="marriage" id="marriage"><option label="未婚" value="1" selected="selected">未婚</option>
<option label="离异" value="2">离异</option>
<option label="丧偶" value="3">丧偶</option>
</select></div>
</li>
<li>
	<em id="em_children"><a href="javascript:get_edit('children')">修改</a></em>
	<span>有否子女：</span>
	<div id="div_children">无小孩</div>
	<div id="div_children_edit" class="divedit"><select name="children" id="children"><option value="0">--保密--</option><option label="无小孩" value="1" selected="selected">无小孩</option>
<option label="有小孩" value="2">有小孩</option>
<option label="有小孩未在一起" value="3">有小孩未在一起</option>
</select></div>
</li>
<li>
	<em id="em_education"><a href="javascript:get_edit('education')">修改</a></em>
	<span>学历：</span>
	<div id="div_education">本科</div>
	<div id="div_education_edit" class="divedit"><select name="education" id="education"><option label="大专" value="1">大专</option>
<option label="本科" value="2" selected="selected">本科</option>
<option label="硕士" value="3">硕士</option>
<option label="博士" value="4">博士</option>
<option label="博士后" value="5">博士后</option>
<option label="双学士" value="6">双学士</option>
</select></div>
</li>
<li>
	<em id="em_university"><a href="javascript:get_edit('university')">修改</a></em>
	<span>毕业学校：</span>
	<div id="div_university">四川&nbsp;四川大学</div>
	<div id="div_university_edit" class="divedit"><select id="uni_location" name="uni_location" onchange="redirect(my_getbyid('university'), this.options[this.options.selectedIndex].value, 0, true);"><option value="0">--保密--</option><option label="北京" value="11">北京</option>
<option label="天津" value="12">天津</option>
<option label="河北" value="13">河北</option>
<option label="山西" value="14">山西</option>
<option label="内蒙古" value="15">内蒙古</option>
<option label="辽宁" value="21">辽宁</option>
<option label="吉林" value="22">吉林</option>
<option label="黑龙江" value="23">黑龙江</option>
<option label="上海" value="31">上海</option>
<option label="江苏" value="32">江苏</option>
<option label="浙江" value="33">浙江</option>
<option label="安徽" value="34">安徽</option>
<option label="福建" value="35">福建</option>
<option label="江西" value="36">江西</option>
<option label="山东" value="37">山东</option>
<option label="河南" value="41">河南</option>
<option label="湖北" value="42">湖北</option>
<option label="湖南" value="43">湖南</option>
<option label="广东" value="44">广东</option>
<option label="广西" value="45">广西</option>
<option label="海南" value="46">海南</option>
<option label="重庆" value="50">重庆</option>
<option label="四川" value="51" selected="selected">四川</option>
<option label="贵州" value="52">贵州</option>
<option label="云南" value="53">云南</option>
<option label="西藏" value="54">西藏</option>
<option label="陕西" value="61">陕西</option>
<option label="甘肃" value="62">甘肃</option>
<option label="青海" value="63">青海</option>
<option label="宁夏" value="64">宁夏</option>
<option label="新疆" value="65">新疆</option>
<option label="台湾" value="71">台湾</option>
<option label="香港" value="81">香港</option>
<option label="澳门" value="82">澳门</option>
<option label="外国" value="99">外国</option>
</select><select id="university" name="university" style="width:200px;"><option value="0">--请选择--</option></select></div>
</li>
<li>
	<em id="em_industry"><a href="javascript:get_edit('industry')" title="提示：
新版网站对“职业类型”进行了专业化的更新。
请您重新设定：">修改</a></em>
	<span>职业类型：</span>
	<div id="div_industry">计算机/互联网/IT</div>
	<div id="div_industry_edit" class="divedit"><select name="industry" id="industry"><option value="0">--保密--</option><option label="在校学生" value="1">在校学生</option>
<option label="计算机/互联网/IT" value="2" selected="selected">计算机/互联网/IT</option>
<option label="电子/半导体/仪表仪器" value="3">电子/半导体/仪表仪器</option>
<option label="通信技术" value="4">通信技术</option>
<option label="销售" value="5">销售</option>
<option label="市场拓展" value="6">市场拓展</option>
<option label="公关/商务" value="7">公关/商务</option>
<option label="采购/贸易" value="8">采购/贸易</option>
<option label="客户服务/技术支持" value="9">客户服务/技术支持</option>
<option label="人力资源/行政/后勤" value="10">人力资源/行政/后勤</option>
<option label="高级管理" value="11">高级管理</option>
<option label="生产/加工/制造" value="12">生产/加工/制造</option>
<option label="质控/安检" value="13">质控/安检</option>
<option label="工程机械" value="14">工程机械</option>
<option label="技工" value="15">技工</option>
<option label="财会/审计/统计" value="16">财会/审计/统计</option>
<option label="金融/证券/投资/保险" value="17">金融/证券/投资/保险</option>
<option label="房地产/装修/物业" value="18">房地产/装修/物业</option>
<option label="仓储/物流" value="19">仓储/物流</option>
<option label="普通劳动力/家政服务" value="20">普通劳动力/家政服务</option>
<option label="普通服务行业" value="21">普通服务行业</option>
<option label="航空服务业" value="22">航空服务业</option>
<option label="教育/培训" value="23">教育/培训</option>
<option label="咨询/顾问" value="24">咨询/顾问</option>
<option label="学术/科研" value="25">学术/科研</option>
<option label="法律" value="26">法律</option>
<option label="设计/创意" value="27">设计/创意</option>
<option label="文学/传媒/影视" value="28">文学/传媒/影视</option>
<option label="餐饮/旅游" value="29">餐饮/旅游</option>
<option label="化工" value="30">化工</option>
<option label="能源/地质勘查" value="31">能源/地质勘查</option>
<option label="医疗/护理" value="32">医疗/护理</option>
<option label="保健/美容" value="33">保健/美容</option>
<option label="生物/制药/医疗器械" value="34">生物/制药/医疗器械</option>
<option label="体育工作者" value="35">体育工作者</option>
<option label="翻译" value="36">翻译</option>
<option label="公务员/国家干部" value="37">公务员/国家干部</option>
<option label="私营业主" value="38">私营业主</option>
<option label="农/林/牧/渔业" value="39">农/林/牧/渔业</option>
<option label="武警/警察/消防/军人" value="40">武警/警察/消防/军人</option>
<option label="自由职业者" value="41">自由职业者</option>
<option label="其他" value="42">其他</option>
</select></div>
</li>
<li>
	<em id="em_company"><a href="javascript:get_edit('company')">修改</a></em>
	<span>公司类型：</span>
	<div id="div_company">事业单位 </div>
	<div id="div_company_edit" class="divedit"><select name="company" id="company"><option value="0">--保密--</option><option label="政府机关" value="1">政府机关</option>
<option label="事业单位 " value="2" selected="selected">事业单位 </option>
<option label="外企企业 " value="3">外企企业 </option>
<option label="世界500强 " value="4">世界500强 </option>
<option label="上市公司 " value="5">上市公司 </option>
<option label="国营企业 " value="6">国营企业 </option>
<option label="私营企业 " value="7">私营企业 </option>
<option label="自有公司" value="8">自有公司</option>
</select></div>
</li>
<li>
	<em id="em_income"><a href="javascript:get_edit('income')">修改</a></em>
	<span>月薪：</span>
	<div id="div_income">3000～4000元</div>
	<div id="div_income_edit" class="divedit"><select name="income" id="income"><option label="少于1000元" value="1">少于1000元</option>
<option label="1000～2000元" value="2">1000～2000元</option>
<option label="2000～3000元" value="3">2000～3000元</option>
<option label="3000～4000元" value="4" selected="selected">3000～4000元</option>
<option label="4000～6000元" value="5">4000～6000元</option>
<option label="6000～8000元" value="6">6000～8000元</option>
<option label="8000～12000元" value="7">8000～12000元</option>
<option label="12000～20000元" value="8">12000～20000元</option>
<option label="20000～50000元" value="9">20000～50000元</option>
<option label="50000元以上" value="10">50000元以上</option>
</select></div>
</li>
<li>
	<em id="em_nationality"><a href="javascript:get_edit('nationality')">修改</a></em>
	<span>国籍：</span>
	<div id="div_nationality">未填</div>
	<div id="div_nationality_edit" class="divedit"><select name="nationality" id="nationality"><option value="0">--保密--</option><option label="中国大陆" value="1">中国大陆</option>
<option label="中国台湾" value="56">中国台湾</option>
<option label="中国香港" value="190">中国香港</option>
<option label="中国澳门" value="143">中国澳门</option>
<option label="韩国" value="41">韩国</option>
<option label="朝鲜" value="39">朝鲜</option>
<option label="瑙鲁" value="49">瑙鲁</option>
<option label="印度尼西亚" value="50">印度尼西亚</option>
<option label="美国" value="3">美国</option>
<option label="加拿大" value="4">加拿大</option>
<option label="日本" value="128">日本</option>
<option label="俄罗斯" value="25">俄罗斯</option>
<option label="英国" value="7">英国</option>
<option label="德国" value="8">德国</option>
<option label="意大利" value="110">意大利</option>
<option label="法国" value="6">法国</option>
<option label="芬兰" value="166">芬兰</option>
<option label="瑞典" value="150">瑞典</option>
<option label="瑞士" value="151">瑞士</option>
<option label="南非" value="43">南非</option>
<option label="蒙古" value="175">蒙古</option>
<option label="越南" value="181">越南</option>
<option label="缅甸" value="162">缅甸</option>
<option label="泰国" value="139">泰国</option>
<option label="老挝" value="164">老挝</option>
<option label="菲律宾" value="171">菲律宾</option>
<option label="西班牙" value="176">西班牙</option>
<option label="葡萄牙" value="174">葡萄牙</option>
<option label="阿尔巴尼亚" value="186">阿尔巴尼亚</option>
<option label="阿尔及利亚" value="185">阿尔及利亚</option>
<option label="阿富汗" value="184">阿富汗</option>
<option label="阿根廷" value="188">阿根廷</option>
<option label="阿拉伯联合酋长国" value="189">阿拉伯联合酋长国</option>
<option label="阿拉伯叙利亚共和国" value="54">阿拉伯叙利亚共和国</option>
<option label="阿鲁巴" value="17">阿鲁巴</option>
<option label="阿曼" value="187">阿曼</option>
<option label="阿塞拜疆" value="183">阿塞拜疆</option>
<option label="埃及" value="73">埃及</option>
<option label="埃塞俄比亚" value="74">埃塞俄比亚</option>
<option label="爱尔兰" value="144">爱尔兰</option>
<option label="爱沙尼亚" value="145">爱沙尼亚</option>
<option label="安道尔" value="90">安道尔</option>
<option label="安哥拉" value="88">安哥拉</option>
<option label="安圭拉" value="22">安圭拉</option>
<option label="安提瓜和巴布达" value="89">安提瓜和巴布达</option>
<option label="奥地利" value="85">奥地利</option>
<option label="澳大利亚" value="5">澳大利亚</option>
<option label="巴巴多斯" value="33">巴巴多斯</option>
<option label="巴布亚新几内亚" value="99">巴布亚新几内亚</option>
<option label="巴哈马" value="97">巴哈马</option>
<option label="巴基斯坦" value="98">巴基斯坦</option>
<option label="巴勒斯坦" value="96">巴勒斯坦</option>
<option label="巴拉圭" value="100">巴拉圭</option>
<option label="巴林" value="101">巴林</option>
<option label="巴拿马" value="42">巴拿马</option>
<option label="巴西" value="103">巴西</option>
<option label="白俄罗斯" value="153">白俄罗斯</option>
<option label="百慕大" value="48">百慕大</option>
<option label="保加利亚" value="26">保加利亚</option>
<option label="北马里亚纳" value="66">北马里亚纳</option>
<option label="贝宁" value="178">贝宁</option>
<option label="比利时" value="132">比利时</option>
<option label="冰岛" value="67">冰岛</option>
<option label="波多黎各" value="84">波多黎各</option>
<option label="波兰" value="137">波兰</option>
<option label="波斯尼亚和黑塞哥维那" value="138">波斯尼亚和黑塞哥维那</option>
<option label="玻利维亚" value="148">玻利维亚</option>
<option label="伯利兹" value="24">伯利兹</option>
<option label="博茨瓦纳" value="44">博茨瓦纳</option>
<option label="不丹" value="9">不丹</option>
<option label="布基纳法索" value="105">布基纳法索</option>
<option label="布隆迪" value="106">布隆迪</option>
<option label="布维岛" value="83">布维岛</option>
<option label="赤道几内亚" value="180">赤道几内亚</option>
<option label="大阿拉伯利比亚民众国" value="34">大阿拉伯利比亚民众国</option>
<option label="丹麦" value="11">丹麦</option>
<option label="东帝汶" value="109">东帝汶</option>
<option label="多哥" value="82">多哥</option>
<option label="多米尼加共和国" value="102">多米尼加共和国</option>
<option label="多米尼克" value="104">多米尼克</option>
<option label="厄瓜多尔" value="52">厄瓜多尔</option>
<option label="厄立特里亚" value="53">厄立特里亚</option>
<option label="法罗群岛" value="111">法罗群岛</option>
<option label="梵蒂冈城国" value="117">梵蒂冈城国</option>
<option label="斐济" value="122">斐济</option>
<option label="佛得角" value="123">佛得角</option>
<option label="冈比亚" value="28">冈比亚</option>
<option label="刚果" value="32">刚果</option>
<option label="哥伦比亚" value="60">哥伦比亚</option>
<option label="哥斯达黎加" value="61">哥斯达黎加</option>
<option label="格林纳达" value="131">格林纳达</option>
<option label="格陵兰" value="69">格陵兰</option>
<option label="格鲁吉亚" value="182">格鲁吉亚</option>
<option label="古巴" value="55">古巴</option>
<option label="关岛" value="177">关岛</option>
<option label="圭亚那" value="71">圭亚那</option>
<option label="哈萨克斯坦" value="59">哈萨克斯坦</option>
<option label="海地" value="142">海地</option>
<option label="荷兰" value="169">荷兰</option>
<option label="荷属安的列斯" value="192">荷属安的列斯</option>
<option label="赫德和麦克唐纳群岛" value="195">赫德和麦克唐纳群岛</option>
<option label="洪都拉斯" value="141">洪都拉斯</option>
<option label="基里巴斯" value="75">基里巴斯</option>
<option label="吉布提" value="58">吉布提</option>
<option label="吉尔吉斯斯坦" value="57">吉尔吉斯斯坦</option>
<option label="几内亚" value="29">几内亚</option>
<option label="几内亚比绍" value="30">几内亚比绍</option>
<option label="加纳" value="36">加纳</option>
<option label="加蓬" value="37">加蓬</option>
<option label="柬埔寨" value="130">柬埔寨</option>
<option label="捷克共和国" value="115">捷克共和国</option>
<option label="津巴布韦" value="140">津巴布韦</option>
<option label="喀麦隆" value="62">喀麦隆</option>
<option label="卡塔尔" value="45">卡塔尔</option>
<option label="开曼群岛" value="199">开曼群岛</option>
<option label="科摩罗" value="155">科摩罗</option>
<option label="科特迪瓦" value="200">科特迪瓦</option>
<option label="科威特" value="154">科威特</option>
<option label="克罗地亚" value="27">克罗地亚</option>
<option label="肯尼亚" value="165">肯尼亚</option>
<option label="库克群岛" value="201">库克群岛</option>
<option label="拉脱维亚" value="113">拉脱维亚</option>
<option label="莱索托" value="202">莱索托</option>
<option label="黎巴嫩" value="198">黎巴嫩</option>
<option label="立陶宛" value="158">立陶宛</option>
<option label="利比里亚" value="35">利比里亚</option>
<option label="列支敦士登" value="31">列支敦士登</option>
<option label="卢森堡" value="47">卢森堡</option>
<option label="卢旺达" value="46">卢旺达</option>
<option label="罗马尼亚" value="163">罗马尼亚</option>
<option label="马达加斯加" value="196">马达加斯加</option>
<option label="马尔代夫" value="203">马尔代夫</option>
<option label="马耳他" value="204">马耳他</option>
<option label="马拉维" value="193">马拉维</option>
<option label="马来西亚" value="194">马来西亚</option>
<option label="马里" value="197">马里</option>
<option label="马绍尔群岛" value="205">马绍尔群岛</option>
<option label="毛里求斯" value="134">毛里求斯</option>
<option label="毛利塔尼亚" value="133">毛利塔尼亚</option>
<option label="蒙特塞拉特" value="206">蒙特塞拉特</option>
<option label="孟加拉国" value="87">孟加拉国</option>
<option label="秘鲁" value="156">秘鲁</option>
<option label="密克罗尼西亚联邦" value="91">密克罗尼西亚联邦</option>
<option label="摩尔多瓦" value="116">摩尔多瓦</option>
<option label="摩洛哥" value="118">摩洛哥</option>
<option label="摩纳哥" value="119">摩纳哥</option>
<option label="莫桑比克" value="170">莫桑比克</option>
<option label="墨西哥" value="81">墨西哥</option>
<option label="纳米比亚" value="161">纳米比亚</option>
<option label="南极洲" value="207">南极洲</option>
<option label="南斯拉夫" value="40">南斯拉夫</option>
<option label="尼泊尔" value="95">尼泊尔</option>
<option label="尼加拉瓜" value="92">尼加拉瓜</option>
<option label="尼日尔" value="94">尼日尔</option>
<option label="尼日利亚" value="93">尼日利亚</option>
<option label="纽埃" value="208">纽埃</option>
<option label="挪威" value="114">挪威</option>
<option label="诺福克岛" value="209">诺福克岛</option>
<option label="帕劳群岛" value="108">帕劳群岛</option>
<option label="皮特凯恩" value="210">皮特凯恩</option>
<option label="前南斯拉夫马其顿共和国" value="191">前南斯拉夫马其顿共和国</option>
<option label="萨尔瓦多" value="172">萨尔瓦多</option>
<option label="萨摩亚" value="173">萨摩亚</option>
<option label="塞拉利昂" value="78">塞拉利昂</option>
<option label="塞内加尔" value="77">塞内加尔</option>
<option label="塞浦路斯" value="79">塞浦路斯</option>
<option label="塞舌尔" value="80">塞舌尔</option>
<option label="沙特阿拉伯" value="136">沙特阿拉伯</option>
<option label="圣诞岛" value="211">圣诞岛</option>
<option label="圣多美和普林西比" value="68">圣多美和普林西比</option>
<option label="圣赫勒拿" value="212">圣赫勒拿</option>
<option label="圣基茨和尼维斯" value="213">圣基茨和尼维斯</option>
<option label="圣卢西亚" value="214">圣卢西亚</option>
<option label="圣马力诺" value="70">圣马力诺</option>
<option label="斯里兰卡" value="126">斯里兰卡</option>
<option label="斯洛伐克共和国" value="124">斯洛伐克共和国</option>
<option label="斯洛文尼亚" value="125">斯洛文尼亚</option>
<option label="斯瓦尔巴岛和扬马延岛" value="215">斯瓦尔巴岛和扬马延岛</option>
<option label="斯威士兰" value="216">斯威士兰</option>
<option label="苏丹" value="167">苏丹</option>
<option label="苏里南" value="168">苏里南</option>
<option label="所罗门群岛" value="112">所罗门群岛</option>
<option label="索马里" value="159">索马里</option>
<option label="塔吉克斯坦" value="76">塔吉克斯坦</option>
<option label="坦桑尼亚" value="72">坦桑尼亚</option>
<option label="汤加" value="135">汤加</option>
<option label="特克斯和凯科斯群岛" value="217">特克斯和凯科斯群岛</option>
<option label="特立尼达和多巴哥" value="147">特立尼达和多巴哥</option>
<option label="突尼斯" value="157">突尼斯</option>
<option label="图瓦卢" value="63">图瓦卢</option>
<option label="土耳其" value="65">土耳其</option>
<option label="土库曼斯坦" value="64">土库曼斯坦</option>
<option label="托克劳" value="218">托克劳</option>
<option label="瓦努阿图" value="1152">瓦努阿图</option>
<option label="危地马拉" value="51">危地马拉</option>
<option label="委内瑞拉" value="86">委内瑞拉</option>
<option label="文莱" value="121">文莱</option>
<option label="乌干达" value="14">乌干达</option>
<option label="乌克兰" value="12">乌克兰</option>
<option label="乌拉圭" value="15">乌拉圭</option>
<option label="乌兹别克斯坦" value="13">乌兹别克斯坦</option>
<option label="西撒哈拉" value="120">西撒哈拉</option>
<option label="希腊" value="107">希腊</option>
<option label="新加坡" value="2">新加坡</option>
<option label="新西兰" value="127">新西兰</option>
<option label="匈牙利" value="38">匈牙利</option>
<option label="牙买加" value="146">牙买加</option>
<option label="亚美尼亚" value="19">亚美尼亚</option>
<option label="也门" value="18">也门</option>
<option label="伊拉克" value="21">伊拉克</option>
<option label="伊朗伊斯兰共和国" value="23">伊朗伊斯兰共和国</option>
<option label="以色列" value="20">以色列</option>
<option label="约旦" value="160">约旦</option>
<option label="赞比亚" value="179">赞比亚</option>
<option label="扎伊尔" value="219">扎伊尔</option>
<option label="乍得" value="16">乍得</option>
<option label="直布罗陀" value="220">直布罗陀</option>
<option label="智利" value="129">智利</option>
<option label="中非共和国 " value="10">中非共和国 </option>
</select></div>
</li>
<li>
	<em id="em_home_sublocation"><a href="javascript:get_edit('home_sublocation')">修改</a></em>
	<span>户口地区：</span>
	<div id="div_home_sublocation">湖北宜昌</div>
	<div id="div_home_sublocation_edit" class="divedit"><select id="home_location" name="home_location" onchange="redirect(my_getbyid('home_sublocation'), this.options[this.options.selectedIndex].value, 0, false);"><option value="0">--保密--</option><option label="北京" value="11">北京</option>
<option label="天津" value="12">天津</option>
<option label="河北" value="13">河北</option>
<option label="山西" value="14">山西</option>
<option label="内蒙古" value="15">内蒙古</option>
<option label="辽宁" value="21">辽宁</option>
<option label="吉林" value="22">吉林</option>
<option label="黑龙江" value="23">黑龙江</option>
<option label="上海" value="31">上海</option>
<option label="江苏" value="32">江苏</option>
<option label="浙江" value="33">浙江</option>
<option label="安徽" value="34">安徽</option>
<option label="福建" value="35">福建</option>
<option label="江西" value="36">江西</option>
<option label="山东" value="37">山东</option>
<option label="河南" value="41">河南</option>
<option label="湖北" value="42" selected="selected">湖北</option>
<option label="湖南" value="43">湖南</option>
<option label="广东" value="44">广东</option>
<option label="广西" value="45">广西</option>
<option label="海南" value="46">海南</option>
<option label="重庆" value="50">重庆</option>
<option label="四川" value="51">四川</option>
<option label="贵州" value="52">贵州</option>
<option label="云南" value="53">云南</option>
<option label="西藏" value="54">西藏</option>
<option label="陕西" value="61">陕西</option>
<option label="甘肃" value="62">甘肃</option>
<option label="青海" value="63">青海</option>
<option label="宁夏" value="64">宁夏</option>
<option label="新疆" value="65">新疆</option>
<option label="台湾" value="71">台湾</option>
<option label="香港" value="81">香港</option>
<option label="澳门" value="82">澳门</option>
<option label="外国" value="99">外国</option>
</select><select id="home_sublocation" name="home_sublocation"><option value="0">--保密--</option></select></div>
</li>
<li>
	<em id="em_work_sublocation"><a href="javascript:get_edit('work_sublocation')">修改</a></em>
	<span>所在地区：</span>
	<div id="div_work_sublocation">北京海淀</div>
	<div id="div_work_sublocation_edit" class="divedit"><select id="work_location" name="work_location" onchange="redirect(my_getbyid('work_sublocation'), this.options[this.options.selectedIndex].value, 0, false);"><option label="北京" value="11" selected="selected">北京</option>
<option label="天津" value="12">天津</option>
<option label="河北" value="13">河北</option>
<option label="山西" value="14">山西</option>
<option label="内蒙古" value="15">内蒙古</option>
<option label="辽宁" value="21">辽宁</option>
<option label="吉林" value="22">吉林</option>
<option label="黑龙江" value="23">黑龙江</option>
<option label="上海" value="31">上海</option>
<option label="江苏" value="32">江苏</option>
<option label="浙江" value="33">浙江</option>
<option label="安徽" value="34">安徽</option>
<option label="福建" value="35">福建</option>
<option label="江西" value="36">江西</option>
<option label="山东" value="37">山东</option>
<option label="河南" value="41">河南</option>
<option label="湖北" value="42">湖北</option>
<option label="湖南" value="43">湖南</option>
<option label="广东" value="44">广东</option>
<option label="广西" value="45">广西</option>
<option label="海南" value="46">海南</option>
<option label="重庆" value="50">重庆</option>
<option label="四川" value="51">四川</option>
<option label="贵州" value="52">贵州</option>
<option label="云南" value="53">云南</option>
<option label="西藏" value="54">西藏</option>
<option label="陕西" value="61">陕西</option>
<option label="甘肃" value="62">甘肃</option>
<option label="青海" value="63">青海</option>
<option label="宁夏" value="64">宁夏</option>
<option label="新疆" value="65">新疆</option>
<option label="台湾" value="71">台湾</option>
<option label="香港" value="81">香港</option>
<option label="澳门" value="82">澳门</option>
<option label="外国" value="99">外国</option>
</select><select id="work_sublocation" name="work_sublocation"></select></div>
</li>
<li>
	<em id="em_bloodtype"><a href="javascript:get_edit('bloodtype')">修改</a></em>
	<span>血型：</span>
	<div id="div_bloodtype">未填</div>
	<div id="div_bloodtype_edit" class="divedit"><select name="bloodtype" id="bloodtype"><option value="0">--保密--</option><option label="A型" value="1">A型</option>
<option label="B型" value="2">B型</option>
<option label="O型" value="3">O型</option>
<option label="AB型" value="4">AB型</option>
<option label="其它" value="5">其它</option>
</select></div>
</li>
<li>
	<em id="em_nation"><a href="javascript:get_edit('nation')">修改</a></em>
	<span>民族：</span>
	<div id="div_nation">汉族</div>
	<div id="div_nation_edit" class="divedit"><select name="nation" id="nation"><option value="0">--保密--</option><option label="汉族" value="1" selected="selected">汉族</option>
<option label="藏族" value="2">藏族</option>
<option label="朝鲜族" value="3">朝鲜族</option>
<option label="蒙古族" value="4">蒙古族</option>
<option label="回族" value="5">回族</option>
<option label="满族" value="6">满族</option>
<option label="维吾尔族" value="7">维吾尔族</option>
<option label="壮族" value="8">壮族</option>
<option label="彝族" value="9">彝族</option>
<option label="苗族" value="10">苗族</option>
<option label="其它民族" value="11">其它民族</option>
</select></div>
</li>
<li>
	<em id="em_belief"><a href="javascript:get_edit('belief')">修改</a></em>
	<span>宗教信仰：</span>
	<div id="div_belief">无宗教信仰</div>
	<div id="div_belief_edit" class="divedit"><select name="belief" id="belief"><option value="0">--保密--</option><option label="无宗教信仰" value="1" selected="selected">无宗教信仰</option>
<option label="大乘佛教显宗" value="2">大乘佛教显宗</option>
<option label="大乘佛教密宗" value="3">大乘佛教密宗</option>
<option label="小乘佛教" value="4">小乘佛教</option>
<option label="道教" value="5">道教</option>
<option label="儒教" value="6">儒教</option>
<option label="基督教天主教派" value="7">基督教天主教派</option>
<option label="基督教东正教派" value="8">基督教东正教派</option>
<option label="基督教新教派" value="9">基督教新教派</option>
<option label="犹太教" value="10">犹太教</option>
<option label="伊斯兰教什叶派" value="11">伊斯兰教什叶派</option>
<option label="伊斯兰教逊尼派" value="12">伊斯兰教逊尼派</option>
<option label="印度教" value="13">印度教</option>
<option label="神道教" value="14">神道教</option>
<option label="萨满教" value="15">萨满教</option>
<option label="其它宗教信仰" value="16">其它宗教信仰</option>
</select></div>
</li>
<li>
	<em id="em_language"><a href="javascript:get_edit('language')">修改</a></em>
	<span>语言能力：</span>
	<div id="div_language"></div>
	<div id="div_language_edit" class="mylove21cn_databox divedit">
请勾选您要修改的项<br />
<label for="language_1"><input type="checkbox" name="language_1" id="language_1"/>&nbsp;中文(普通话)</label>
<label for="language_2"><input type="checkbox" name="language_2" id="language_2"/>&nbsp;中文(广东话)</label>
<label for="language_3"><input type="checkbox" name="language_3" id="language_3"/>&nbsp;英语</label>
<label for="language_4"><input type="checkbox" name="language_4" id="language_4"/>&nbsp;法语</label>
<label for="language_5"><input type="checkbox" name="language_5" id="language_5"/>&nbsp;日语</label>
<label for="language_6"><input type="checkbox" name="language_6" id="language_6"/>&nbsp;韩语</label>
<label for="language_7"><input type="checkbox" name="language_7" id="language_7"/>&nbsp;德语</label>
<label for="language_8"><input type="checkbox" name="language_8" id="language_8"/>&nbsp;意大利语</label>
<label for="language_9"><input type="checkbox" name="language_9" id="language_9"/>&nbsp;俄语</label>
<label for="language_10"><input type="checkbox" name="language_10" id="language_10"/>&nbsp;芬兰语</label>
<label for="language_11"><input type="checkbox" name="language_11" id="language_11"/>&nbsp;荷兰语</label>
<label for="language_12"><input type="checkbox" name="language_12" id="language_12"/>&nbsp;葡萄牙语</label>
<label for="language_13"><input type="checkbox" name="language_13" id="language_13"/>&nbsp;西班牙语</label>
<label for="language_14"><input type="checkbox" name="language_14" id="language_14"/>&nbsp;越南语</label>
<label for="language_15"><input type="checkbox" name="language_15" id="language_15"/>&nbsp;阿拉伯语</label>
<label for="language_16"><input type="checkbox" name="language_16" id="language_16"/>&nbsp;泰国语</label>
<label for="language_17"><input type="checkbox" name="language_17" id="language_17"/>&nbsp;印度尼希亚语</label>
<label for="language_18"><input type="checkbox" name="language_18" id="language_18"/>&nbsp;印度语</label>
<label for="language_19"><input type="checkbox" name="language_19" id="language_19"/>&nbsp;丹麦语</label>
<label for="language_20"><input type="checkbox" name="language_20" id="language_20"/>&nbsp;希腊语</label>
<label for="language_21"><input type="checkbox" name="language_21" id="language_21"/>&nbsp;伊朗语</label>
<label for="language_22"><input type="checkbox" name="language_22" id="language_22"/>&nbsp;匈牙利语</label>
<label for="language_23"><input type="checkbox" name="language_23" id="language_23"/>&nbsp;土耳其语</label>
<label for="language_24"><input type="checkbox" name="language_24" id="language_24"/>&nbsp;挪威语</label>
<label for="language_25"><input type="checkbox" name="language_25" id="language_25"/>&nbsp;捷克语</label>
<label for="language_26"><input type="checkbox" name="language_26" id="language_26"/>&nbsp;波兰语</label>
<label for="language_27"><input type="checkbox" name="language_27" id="language_27"/>&nbsp;瑞典语</label>
<label for="language_28"><input type="checkbox" name="language_28" id="language_28"/>&nbsp;缅甸语</label>
<label for="language_29"><input type="checkbox" name="language_29" id="language_29"/>&nbsp;罗马尼亚语</label>
</div>
</li>
<li>
	<em id="em_characters"><a href="javascript:get_edit('characters')">修改</a></em>
	<span>个性：</span>
	<div id="div_characters">忠厚老实</div>
	<div id="div_characters_edit" class="divedit"><select name="characters" id="characters"><option value="0">--保密--</option><option label="浪漫迷人" value="1">浪漫迷人</option>
<option label="成熟稳重" value="2">成熟稳重</option>
<option label="风趣幽默" value="3">风趣幽默</option>
<option label="乐天达观" value="4">乐天达观</option>
<option label="活泼可爱" value="5">活泼可爱</option>
<option label="忠厚老实" value="6" selected="selected">忠厚老实</option>
<option label="淳朴害羞" value="7">淳朴害羞</option>
<option label="温柔体贴" value="8">温柔体贴</option>
<option label="多愁善感" value="9">多愁善感</option>
<option label="新潮时尚" value="10">新潮时尚</option>
<option label="热辣动感" value="11">热辣动感</option>
<option label="豪放不羁" value="12">豪放不羁</option>
</select></div>
</li>
<li>
	<em id="em_smoke_type"><a href="javascript:get_edit('smoke_type')">修改</a></em>
	<span>您经常吸烟么：</span>
	<div id="div_smoke_type">未填</div>
	<div id="div_smoke_type_edit" class="divedit"><select name="smoke_type" id="smoke_type"><option value="0">--保密--</option><option label="不吸，很反感吸烟" value="1">不吸，很反感吸烟</option>
<option label="不吸，但不反感" value="2">不吸，但不反感</option>
<option label="社交时偶尔吸" value="3">社交时偶尔吸</option>
<option label="每周吸几次" value="4">每周吸几次</option>
<option label="每天都吸" value="5">每天都吸</option>
<option label="有烟瘾" value="6">有烟瘾</option>
</select></div>
</li>
<li>
	<em id="em_drink_type"><a href="javascript:get_edit('drink_type')">修改</a></em>
	<span>您经常喝酒么：</span>
	<div id="div_drink_type">未填</div>
	<div id="div_drink_type_edit" class="divedit"><select name="drink_type" id="drink_type"><option value="0">--保密--</option><option label="不喝" value="1">不喝</option>
<option label="社交需要时喝" value="2">社交需要时喝</option>
<option label="有兴致时喝" value="3">有兴致时喝</option>
<option label="每天都离不开酒" value="4">每天都离不开酒</option>
</select></div>
</li>
<li>
	<em id="em_house"><a href="javascript:get_edit('house')">修改</a></em>
	<span>居住情况：</span>
	<div id="div_house">与人合租</div>
	<div id="div_house_edit" class="divedit"><select name="house" id="house"><option value="0">--保密--</option><option label="暂未购房" value="1">暂未购房</option>
<option label="已购住房" value="2">已购住房</option>
<option label="与人合租" value="3" selected="selected">与人合租</option>
<option label="独自租房" value="4">独自租房</option>
<option label="与父母同住" value="5">与父母同住</option>
<option label="住亲朋家" value="6">住亲朋家</option>
<option label="住单位房" value="7">住单位房</option>
</select></div>
</li>
<li>
	<em id="em_auto"><a href="javascript:get_edit('auto')">修改</a></em>
	<span>购车情况：</span>
	<div id="div_auto">未填</div>
	<div id="div_auto_edit" class="divedit"><select name="auto" id="auto"><option value="0">--保密--</option><option label="暂未购车" value="1">暂未购车</option>
<option label="已经购车" value="2">已经购车</option>
</select></div>
</li>
</ul>
<h3>关于外貌</h3>
<ul>
<li><span>身高：</span><div id="height">173厘米</div></li>
<li>
	<em id="em_weight"><a href="javascript:get_edit('weight')">修改</a></em>
	<span>体重：</span>
	<div id="div_weight">63公斤</div>
	<div id="div_weight_edit" class="divedit"><input type="text" name="weight" id="weight" value="63" /></div>
</li>
<li>
	<em id="em_hair_type"><a href="javascript:get_edit('hair_type')">修改</a></em>
	<span>发型：</span>
	<div id="div_hair_type">未填</div>
	<div id="div_hair_type_edit" class="divedit"><select name="hair_type" id="hair_type"><option value="0">--保密--</option><option label="顺直长发" value="1">顺直长发</option>
<option label="卷曲长发" value="2">卷曲长发</option>
<option label="中等长度" value="3">中等长度</option>
<option label="短发" value="4">短发</option>
<option label="很短" value="5">很短</option>
<option label="光头" value="6">光头</option>
<option label="其它" value="7">其它</option>
</select></div>
</li>
<li>
	<em id="em_hair_color"><a href="javascript:get_edit('hair_color')">修改</a></em>
	<span>发色：</span>
	<div id="div_hair_color">未填</div>
	<div id="div_hair_color_edit" class="divedit"><select name="hair_color" id="hair_color"><option value="0">--保密--</option><option label="黑色" value="1">黑色</option>
<option label="金色" value="2">金色</option>
<option label="褐色" value="3">褐色</option>
<option label="栗色" value="4">栗色</option>
<option label="灰色" value="5">灰色</option>
<option label="红色" value="6">红色</option>
<option label="白色" value="7">白色</option>
<option label="挑染" value="8">挑染</option>
<option label="光头" value="9">光头</option>
<option label="其它" value="10">其它</option>
</select></div>
</li>
<li>
	<em id="em_face_type"><a href="javascript:get_edit('face_type')">修改</a></em>
	<span>脸型：</span>
	<div id="div_face_type">未填</div>
	<div id="div_face_type_edit" class="divedit"><select name="face_type" id="face_type"><option value="0">--保密--</option><option label="圆脸型" value="1">圆脸型</option>
<option label="方脸型" value="2">方脸型</option>
<option label="长脸型" value="3">长脸型</option>
<option label="瓜子脸型" value="4">瓜子脸型</option>
<option label="鸭蛋脸型" value="5">鸭蛋脸型</option>
<option label="国字脸型" value="6">国字脸型</option>
<option label="三角脸型" value="7">三角脸型</option>
<option label="菱形脸型" value="8">菱形脸型</option>
<option label="保密" value="9">保密</option>
</select></div>
</li>
<li>
	<em id="em_shape"><a href="javascript:get_edit('shape')">修改</a></em>
	<span>体型：</span>
	<div id="div_shape">未填</div>
	<div id="div_shape_edit" class="divedit"><select name="shape" id="shape"><option value="0">--保密--</option><option label="瘦" value="1">瘦</option>
<option label="较瘦" value="2">较瘦</option>
<option label="匀称" value="3">匀称</option>
<option label="苗条" value="4">苗条</option>
<option label="高挑" value="5">高挑</option>
<option label="丰满" value="6">丰满</option>
<option label="健壮" value="7">健壮</option>
<option label="魁梧" value="8">魁梧</option>
<option label="胖" value="9">胖</option>
<option label="较胖" value="10">较胖</option>
</select></div>
</li>
<li>
	<em id="em_beau"><a href="javascript:get_edit('beau')">修改</a></em>
	<span>综合评价自己的外貌：</span>
	<div id="div_beau">比较帅</div>
	<div id="div_beau_edit" class="divedit"><select name="beau" id="beau"><option value="0">--保密--</option><option label="青蛙" value="1">青蛙</option>
<option label="平平" value="2">平平</option>
<option label="中等" value="3">中等</option>
<option label="比较帅" value="4" selected="selected">比较帅</option>
<option label="帅呆了" value="5">帅呆了</option>
</select></div>
</li>
<li>
	<em id="em_best_part"><a href="javascript:get_edit('best_part')">修改</a></em>
	<span>自我感觉最有魅力的部位：</span>
	<div id="div_best_part">未填</div>
	<div id="div_best_part_edit" class="divedit"><select name="best_part" id="best_part"><option value="0">--保密--</option><option label="笑容" value="1">笑容</option>
<option label="眉毛" value="2">眉毛</option>
<option label="眼睛" value="3">眼睛</option>
<option label="头发" value="4">头发</option>
<option label="鼻梁" value="5">鼻梁</option>
<option label="嘴唇" value="6">嘴唇</option>
<option label="牙齿" value="7">牙齿</option>
<option label="颈部" value="8">颈部</option>
<option label="耳朵" value="9">耳朵</option>
<option label="手" value="10">手</option>
<option label="胳膊" value="11">胳膊</option>
<option label="胸部" value="12">胸部</option>
<option label="腰部" value="17">腰部</option>
<option label="臀部" value="13">臀部</option>
<option label="腿" value="14">腿</option>
<option label="脚" value="15">脚</option>
<option label="没有太特别的" value="16">没有太特别的</option>
</select></div>
</li>
</ul>
<h3>以下部分保密：<span>仅供本网站客户服务使用，为您保密，请放心填写</span></h3>
<ul>
<li>
	<em id="em_true_name"><a href="javascript:if((my_getbyid('true_name').value)){doedit('true_name',my_getbyid('true_name').value);}else{alert('请填写真实姓名');}">保存</a></em>
	<span>真实姓名：</span>
		<div id="div_true_name" class="divedit"></div>
	<div id="div_true_name_edit"><input type="text" name="true_name" id="true_name" /></div>
	</li>
<li>
	<em id="em_id_card"><a href="javascript:if((my_getbyid('id_card').value)){doedit('id_card',my_getbyid('id_card').value);}else{alert('请填写身份证件号码');}">保存</a></em>
	<span>身份证号：</span>
		<div id="div_id_card" class="divedit"></div>
	<div id="div_id_card_edit"><input type="text" name="id_card" id="id_card" /></div>
	</li>
<li>
		<em id="em_mobile"><a href="javascript:doedit('mobile',my_getbyid('mobile').value);">保存</a></em>
	<span>手机号码：</span>
	<div id="div_mobile" class="divedit"></div>
	<div id="div_mobile_edit"><input type="text" name="mobile" id="mobile" /></div>
	</li>
<li>
		<em id="em_phone"><a href="javascript:doedit('phone',my_getbyid('phone').value);">保存</a></em>
	<span>电话号码：</span>
	<div id="div_phone" class="divedit"></div>
	<div id="div_phone_edit"><input type="text" name="phone" id="phone" /></div>
	</li>
</ul>
</form>
<h4>亲爱的用户，完善自己的资料，是邂逅美好姻缘的基础<br /><strong>(小提示：您更新内容后，网站将在24小时内进行人工审核，请放心等待)</strong></h4>
</div>

<script type="text/javascript">
if (my_getbyid('work_sublocation')) redirect(my_getbyid('work_sublocation'), 11, 1108, false);
if (my_getbyid('home_sublocation')) redirect(my_getbyid('home_sublocation'), 42, 4205, false);
if (my_getbyid('university'))redirect(my_getbyid('university'), 51, 51680, true);
</script>

</div>

<!-- menu -->
<div class="mylove21cn_menu">
<div class="mylove21cn_menuover"><a href="/msg/judge.php">我的邮箱<em>(新1)</em></a></div>
<div class="mylove21cn_menuon">我的空间<em>(48%完整)</em></div>
<div class="mylove21cn_menuopenlist">
<ul>
	<li class="mylove21cn_menuopenliston"><span>个人详情</span></li>	<li class="mylove21cn_menuopenlistover"><a href="/usercp/note.php">内心独白</a></li>	<li class="mylove21cn_menuopenlistover"><a href="/usercp/interest.php">兴趣生活</a></li>	<li class="mylove21cn_menuopenlistover"><a href="/usercp/article.php">我的日记</a></li></ul>
</div>
<div class="mylove21cn_menuover"><a href="/usercp/paper/ques_list.php">爱情测试</a></div>
<div class="mylove21cn_menuover"><a href="/usercp/photo.php">我的相册<em></em></a></div>
<div class="mylove21cn_menuover"><a href="/usercp/certificate.php">我的信用<em><span></span></em></a></div>
<div class="mylove21cn_menuover"><a href="/usercp/match.php">征友操作</a></div>
<div class="mylove21cn_menuover"><a href="/usercp/friends.php">征友记录</a></div>
<div class="mylove21cn_menuopen">佳缘服务</div>
<div class="mylove21cn_menuopenlist">
<ul>
<!--<li><a href="#">申请佳缘牵线</a></li>
<li><a href="#">申请约会1+1</a></li>-->
<li class="mylove21cn_menuopenlistover"><a href="/usercp/charge/sso_1.php">申请高级会员</a></li><li class="mylove21cn_menuopenlistover"><a href="/usercp/brightlist.php">申请光明榜</a></li><li class="mylove21cn_menuopenlistover"><a href="/usercp/priority.php">申请排名提前</a></li></ul>
</div>
<!--<div class="mylove21cn_menuover"><a href="#">我的邮票</a></div>
<div class="mylove21cn_menuover"><a href="#">我的帐户</a></div>-->
<div class="mylove21cn_menudown">
<div class="mylove21cn_menudownover"><a href="/usercp/password.php">修改密码</a></div><div class="mylove21cn_menudownover"><a href="/usercp/contact.php">联系客服</a></div><div class="mylove21cn_menudownover"><a href="/help/">新手指南</a></div></div>
</div>

<!-- menu end -->


<!-- 插入标准尾js -->
<script type="text/javascript" src="http://images.love21cn.com/m/global/j/foot.js"></script>
<!-- 页面内容结束 -->
</div>
</div>

</body>
</html>