<FORM action='<?=$PHP_SELF?>' method=post>
<INPUT TYPE="hidden" name=sign value=search>
软件搜索:<INPUT name=keyword size=13>
<SELECT name=newsearchtype>
	<option value=multi>搜索类型</option>
	<option value=服务器类>服务器类</option>
	<option value=编程语言>编程语言</option>
	<option value=病毒防治>病毒防治</option>
	<option value=电子词典>电子词典</option>
	<option value=媒体播放>媒体播放</option>
	<option value=屏幕保护>屏幕保护</option>
	<option value=驱动程序>驱动程序</option>
	<option value=输入法>输入法</option>
	<option value=图形图像>图形图像</option>
	<option value=网络工具>网络工具</option>
	<option value=网页制作>网页制作</option>
	<option value=文本编辑>文本编辑</option>
	<option value=系统测试>系统测试</option>
	<option value=系统软件>系统软件</option>
	<option value=虚拟光驱>虚拟光驱</option>
	<option value=游戏娱乐>游戏娱乐</option>
	<option value=源代码>源代码</option>
	<option value=multi>模糊</option>
</select> 在<SELECT name=section>
	<option value=multi>搜索字段</option>
	<option value=name>软件名称</option>
	<option value=info>软件简介</option>
	<option value=multi>所有字段</option>
</select> 中<INPUT type=submit value="搜索" class=button></FORM>