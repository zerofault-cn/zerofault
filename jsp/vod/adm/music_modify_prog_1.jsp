<%@ page language="java" import="java.sql.*,goldsoft.*" %>
<html>
<head>
<title>修改音乐节目</title>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<script language=vbscript>
Set d = CreateObject("Scripting.Dictionary")
d.add "a",-20319
d.add "ai",-20317
d.add "an",-20304
d.add "ang",-20295
d.add "ao",-20292
d.add "ba",-20283
d.add "bai",-20265
d.add "ban",-20257
d.add "bang",-20242
d.add "bao",-20230
d.add "bei",-20051
d.add "ben",-20036
d.add "beng",-20032
d.add "bi",-20026
d.add "bian",-20002
d.add "biao",-19990
d.add "bie",-19986
d.add "bin",-19982
d.add "bing",-19976
d.add "bo",-19805
d.add "bu",-19784
d.add "ca",-19775
d.add "cai",-19774
d.add "can",-19763
d.add "cang",-19756
d.add "cao",-19751
d.add "ce",-19746
d.add "ceng",-19741
d.add "cha",-19739
d.add "chai",-19728
d.add "chan",-19725
d.add "chang",-19715
d.add "chao",-19540
d.add "che",-19531
d.add "chen",-19525
d.add "cheng",-19515
d.add "chi",-19500
d.add "chong",-19484
d.add "chou",-19479
d.add "chu",-19467
d.add "chuai",-19289
d.add "chuan",-19288
d.add "chuang",-19281
d.add "chui",-19275
d.add "chun",-19270
d.add "chuo",-19263
d.add "ci",-19261
d.add "cong",-19249
d.add "cou",-19243
d.add "cu",-19242
d.add "cuan",-19238
d.add "cui",-19235
d.add "cun",-19227
d.add "cuo",-19224
d.add "da",-19218
d.add "dai",-19212
d.add "dan",-19038
d.add "dang",-19023
d.add "dao",-19018
d.add "de",-19006
d.add "deng",-19003
d.add "di",-18996
d.add "dian",-18977
d.add "diao",-18961
d.add "die",-18952
d.add "ding",-18783
d.add "diu",-18774
d.add "dong",-18773
d.add "dou",-18763
d.add "du",-18756
d.add "duan",-18741
d.add "dui",-18735
d.add "dun",-18731
d.add "duo",-18722
d.add "e",-18710
d.add "en",-18697
d.add "er",-18696
d.add "fa",-18526
d.add "fan",-18518
d.add "fang",-18501
d.add "fei",-18490
d.add "fen",-18478
d.add "feng",-18463
d.add "fo",-18448
d.add "fou",-18447
d.add "fu",-18446
d.add "ga",-18239
d.add "gai",-18237
d.add "gan",-18231
d.add "gang",-18220
d.add "gao",-18211
d.add "ge",-18201
d.add "gei",-18184
d.add "gen",-18183
d.add "geng",-18181
d.add "gong",-18012
d.add "gou",-17997
d.add "gu",-17988
d.add "gua",-17970
d.add "guai",-17964
d.add "guan",-17961
d.add "guang",-17950
d.add "gui",-17947
d.add "gun",-17931
d.add "guo",-17928
d.add "ha",-17922
d.add "hai",-17759
d.add "han",-17752
d.add "hang",-17733
d.add "hao",-17730
d.add "he",-17721
d.add "hei",-17703
d.add "hen",-17701
d.add "heng",-17697
d.add "hong",-17692
d.add "hou",-17683
d.add "hu",-17676
d.add "hua",-17496
d.add "huai",-17487
d.add "huan",-17482
d.add "huang",-17468
d.add "hui",-17454
d.add "hun",-17433
d.add "huo",-17427
d.add "ji",-17417
d.add "jia",-17202
d.add "jian",-17185
d.add "jiang",-16983
d.add "jiao",-16970
d.add "jie",-16942
d.add "jin",-16915
d.add "jing",-16733
d.add "jiong",-16708
d.add "jiu",-16706
d.add "ju",-16689
d.add "juan",-16664
d.add "jue",-16657
d.add "jun",-16647
d.add "ka",-16474
d.add "kai",-16470
d.add "kan",-16465
d.add "kang",-16459
d.add "kao",-16452
d.add "ke",-16448
d.add "ken",-16433
d.add "keng",-16429
d.add "kong",-16427
d.add "kou",-16423
d.add "ku",-16419
d.add "kua",-16412
d.add "kuai",-16407
d.add "kuan",-16403
d.add "kuang",-16401
d.add "kui",-16393
d.add "kun",-16220
d.add "kuo",-16216
d.add "la",-16212
d.add "lai",-16205
d.add "lan",-16202
d.add "lang",-16187
d.add "lao",-16180
d.add "le",-16171
d.add "lei",-16169
d.add "leng",-16158
d.add "li",-16155
d.add "lia",-15959
d.add "lian",-15958
d.add "liang",-15944
d.add "liao",-15933
d.add "lie",-15920
d.add "lin",-15915
d.add "ling",-15903
d.add "liu",-15889
d.add "long",-15878
d.add "lou",-15707
d.add "lu",-15701
d.add "lv",-15681
d.add "luan",-15667
d.add "lue",-15661
d.add "lun",-15659
d.add "luo",-15652
d.add "ma",-15640
d.add "mai",-15631
d.add "man",-15625
d.add "mang",-15454
d.add "mao",-15448
d.add "me",-15436
d.add "mei",-15435
d.add "men",-15419
d.add "meng",-15416
d.add "mi",-15408
d.add "mian",-15394
d.add "miao",-15385
d.add "mie",-15377
d.add "min",-15375
d.add "ming",-15369
d.add "miu",-15363
d.add "mo",-15362
d.add "mou",-15183
d.add "mu",-15180
d.add "na",-15165
d.add "nai",-15158
d.add "nan",-15153
d.add "nang",-15150
d.add "nao",-15149
d.add "ne",-15144
d.add "nei",-15143
d.add "nen",-15141
d.add "neng",-15140
d.add "ni",-15139
d.add "nian",-15128
d.add "niang",-15121
d.add "niao",-15119
d.add "nie",-15117
d.add "nin",-15110
d.add "ning",-15109
d.add "niu",-14941
d.add "nong",-14937
d.add "nu",-14933
d.add "nv",-14930
d.add "nuan",-14929
d.add "nue",-14928
d.add "nuo",-14926
d.add "o",-14922
d.add "ou",-14921
d.add "pa",-14914
d.add "pai",-14908
d.add "pan",-14902
d.add "pang",-14894
d.add "pao",-14889
d.add "pei",-14882
d.add "pen",-14873
d.add "peng",-14871
d.add "pi",-14857
d.add "pian",-14678
d.add "piao",-14674
d.add "pie",-14670
d.add "pin",-14668
d.add "ping",-14663
d.add "po",-14654
d.add "pu",-14645
d.add "qi",-14630
d.add "qia",-14594
d.add "qian",-14429
d.add "qiang",-14407
d.add "qiao",-14399
d.add "qie",-14384
d.add "qin",-14379
d.add "qing",-14368
d.add "qiong",-14355
d.add "qiu",-14353
d.add "qu",-14345
d.add "quan",-14170
d.add "que",-14159
d.add "qun",-14151
d.add "ran",-14149
d.add "rang",-14145
d.add "rao",-14140
d.add "re",-14137
d.add "ren",-14135
d.add "reng",-14125
d.add "ri",-14123
d.add "rong",-14122
d.add "rou",-14112
d.add "ru",-14109
d.add "ruan",-14099
d.add "rui",-14097
d.add "run",-14094
d.add "ruo",-14092
d.add "sa",-14090
d.add "sai",-14087
d.add "san",-14083
d.add "sang",-13917
d.add "sao",-13914
d.add "se",-13910
d.add "sen",-13907
d.add "seng",-13906
d.add "sha",-13905
d.add "shai",-13896
d.add "shan",-13894
d.add "shang",-13878
d.add "shao",-13870
d.add "she",-13859
d.add "shen",-13847
d.add "sheng",-13831
d.add "shi",-13658
d.add "shou",-13611
d.add "shu",-13601
d.add "shua",-13406
d.add "shuai",-13404
d.add "shuan",-13400
d.add "shuang",-13398
d.add "shui",-13395
d.add "shun",-13391
d.add "shuo",-13387
d.add "si",-13383
d.add "song",-13367
d.add "sou",-13359
d.add "su",-13356
d.add "suan",-13343
d.add "sui",-13340
d.add "sun",-13329
d.add "suo",-13326
d.add "ta",-13318
d.add "tai",-13147
d.add "tan",-13138
d.add "tang",-13120
d.add "tao",-13107
d.add "te",-13096
d.add "teng",-13095
d.add "ti",-13091
d.add "tian",-13076
d.add "tiao",-13068
d.add "tie",-13063
d.add "ting",-13060
d.add "tong",-12888
d.add "tou",-12875
d.add "tu",-12871
d.add "tuan",-12860
d.add "tui",-12858
d.add "tun",-12852
d.add "tuo",-12849
d.add "wa",-12838
d.add "wai",-12831
d.add "wan",-12829
d.add "wang",-12812
d.add "wei",-12802
d.add "wen",-12607
d.add "weng",-12597
d.add "wo",-12594
d.add "wu",-12585
d.add "xi",-12556
d.add "xia",-12359
d.add "xian",-12346
d.add "xiang",-12320
d.add "xiao",-12300
d.add "xie",-12120
d.add "xin",-12099
d.add "xing",-12089
d.add "xiong",-12074
d.add "xiu",-12067
d.add "xu",-12058
d.add "xuan",-12039
d.add "xue",-11867
d.add "xun",-11861
d.add "ya",-11847
d.add "yan",-11831
d.add "yang",-11798
d.add "yao",-11781
d.add "ye",-11604
d.add "yi",-11589
d.add "yin",-11536
d.add "ying",-11358
d.add "yo",-11340
d.add "yong",-11339
d.add "you",-11324
d.add "yu",-11303
d.add "yuan",-11097
d.add "yue",-11077
d.add "yun",-11067
d.add "za",-11055
d.add "zai",-11052
d.add "zan",-11045
d.add "zang",-11041
d.add "zao",-11038
d.add "ze",-11024
d.add "zei",-11020
d.add "zen",-11019
d.add "zeng",-11018
d.add "zha",-11014
d.add "zhai",-10838
d.add "zhan",-10832
d.add "zhang",-10815
d.add "zhao",-10800
d.add "zhe",-10790
d.add "zhen",-10780
d.add "zheng",-10764
d.add "zhi",-10587
d.add "zhong",-10544
d.add "zhou",-10533
d.add "zhu",-10519
d.add "zhua",-10331
d.add "zhuai",-10329
d.add "zhuan",-10328
d.add "zhuang",-10322
d.add "zhui",-10315
d.add "zhun",-10309
d.add "zhuo",-10307
d.add "zi",-10296
d.add "zong",-10281
d.add "zou",-10274
d.add "zu",-10270
d.add "zuan",-10262
d.add "zui",-10260
d.add "zun",-10256
d.add "zuo",-10254
function g(num)
if num>0 and num<160 then
	g=chr(num)
else if num<-20319 or num>-10247 then
	g=""
else
	a=d.Items
	b=d.keys
for i=d.count-1 to 0 step -1
	if a(i)<=num then exit for
	next
g=b(i)
end if
end if
end function
function c(str)
c=""
for i=1 to len(str)
	c=c&g(asc(mid(str,i,1)))
	next
end function 
</script>
<body>
<%
Opendb opendb = new Opendb();
String prog_id=request.getParameter("prog_id");
String sql1="select * from prog_info,singer_info where prog_id='"+prog_id+"'";
ResultSet rs=opendb.executeQuery(sql1);
rs.next();
//取得各列数据
int depre_id=rs.getInt("depre_id");//折旧编号,(新片,旧片)对应depreciate表depre_id
String prog_name=rs.getString("prog_name").trim();
int prog_stype=rs.getInt("prog_stype");//服务类型(bod),对应dict_entry表dtype_id=20
int prog_format=rs.getInt("prog_format");//文件格式(mp4,mp3),对应dict_entry表dtype_id=10
int prog_kindfir=rs.getInt("prog_kindfir");//播放方式,(广播,多播,单播),对应dict_entry表dtype_id=30
int prog_kindsec=rs.getInt("prog_kindsec");//节目种类,对应dict_entry表dtype_id=40,且dentry_id>1000
int prog_kindthr=rs.getInt("prog_kindthr");//内容分类,对应dict_entry表dtype_id=50
int prog_kindfor=rs.getInt("prog_kindfor");//节目类别,对应dict_entry表dtype_id=60
String prog_path=rs.getString("prog_path").trim();
int prog_size=rs.getInt("prog_size");
int prog_timespan=rs.getInt("prog_timespan");
String publisher=rs.getString("publisher").trim();
String pubdate=rs.getString("pubdate").trim();
String director=rs.getString("director").trim();
String prog_acot=rs.getString("prog_acot").trim();
String prog_describe=rs.getString("prog_describe").trim();
int del_flag=rs.getInt("del_flag");//删除标志
int prog_limit=rs.getInt("prog_limit");//影片级别,对应dict_entry表dtype_id=90,即用户级别(user_limit)
%>
<form action="prog_modify.jsp" method=post name=modify><p>
<table width="100%" border=0 rules=rows cellspacing=1 cellpadding=0 bgcolor=black>
<caption>修改节目信息:<%=prog_id%><span class=small>(<span style="color:red">*</span>项不要随意修改)</span></caption>
<tr bgcolor=white>
	<td align=right>节目新旧:</td>
	<td><select name=depre_id>
		<%
		rs=null;
		rs=opendb.executeQuery("select depre_id,depre_name from depreciate where del_flag=1 order by depre_id");
		int tmp_depre_id=0;
		String tmp_depre_name="";
		while(rs.next())
		{
			tmp_depre_id=rs.getInt(1);
			tmp_depre_name=rs.getString(2).trim();
			%>
			<option value="<%=tmp_depre_id%>" 
			<%
			if(depre_id==tmp_depre_id)
				out.print(" selected");
			%>
			><%=tmp_depre_name%></option>
			<%
		}
		%>
		</select>
	</td>
</tr>
<tr bgcolor=white>
	<td align=right>节目名称:</td>
	<td><input type=text name=prog_name value="<%=prog_name%>"></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>服务类型:</td>
	<td><select name=prog_stype>
		<%
		rs=null;
		rs=opendb.executeQuery("select dentry_id,dentry_name from dict_entry where dtype_id=20 and del_flag=1 order by dentry_id");
		int tmp_dentry_id=0;
		String tmp_dentry_name="";
		while(rs.next())
		{
			tmp_dentry_id=rs.getInt(1);
			tmp_dentry_name=rs.getString(2).trim();
			%>
			<option value="<%=tmp_dentry_id%>" 
			<%
			if(prog_stype==tmp_dentry_id)
				out.print(" selected");
			%>
			><%=tmp_dentry_name%></option>
			<%
		}
		%>
		</select>
	</td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>文件格式:</td>
	<td><select name=prog_format>
		<%
		rs=null;
		rs=opendb.executeQuery("select dentry_id,dentry_name from dict_entry where dtype_id=10 and del_flag=1 order by dentry_id");
		while(rs.next())
		{
			tmp_dentry_id=rs.getInt(1);
			tmp_dentry_name=rs.getString(2).trim();
			%>
			<option value="<%=tmp_dentry_id%>" 
			<%
			if(prog_format==tmp_dentry_id)
				out.print(" selected");
			%>
			><%=tmp_dentry_name%></option>
			<%
		}
		%>
		</select>
	</td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>播放方式:</td>
	<td><select name=prog_kindfir>
		<%
		rs=null;
		rs=opendb.executeQuery("select dentry_id,dentry_name from dict_entry where dtype_id=30 and del_flag=1 order by dentry_id");
		while(rs.next())
		{
			tmp_dentry_id=rs.getInt(1);
			tmp_dentry_name=rs.getString(2).trim();
			%>
			<option value="<%=tmp_dentry_id%>" 
			<%
			if(prog_kindfir==tmp_dentry_id)
				out.print(" selected");
			%>
			><%=tmp_dentry_name%></option>
			<%
		}
		%>
		</select>
	</td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>节目种类:</td>
	<td><select name=prog_kindsec>
		<option value="1026">MTV</option>
		</select>
	</td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>内容分类:</td>
	<td><select name=prog_kindthr>
		<option value="1026">MTV</option>
		</select>
	</td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>节目类别:</td>
	<td><select name=prog_kindfor>
		<%
		rs=null;
		rs=opendb.executeQuery("select dentry_id,dentry_name from dict_entry where dtype_id=60 and del_flag=1 order by dentry_id");
		if(rs!=null&&rs.next())
		{
			do
			{
				tmp_dentry_id=rs.getInt(1);
				tmp_dentry_name=rs.getString(2).trim();
				%>
				<option value="<%=tmp_dentry_id%>" 
				<%
				if(prog_kindfor==tmp_dentry_id)
					out.print(" selected");
				%>
				><%=tmp_dentry_name%></option>
				<%
			}while(rs.next());
		}
		else
		{
			%>
			<option value="<%=prog_kindfor%>">尚未配置</option>
			<%
		}
		%>
		</select>
	</td>
</tr>
<tr bgcolor=white>
	<td align=right>播放路径</td>
	<td><input type=text name=prog_path size=40 value="<%=prog_path%>"></td>
</tr>
<tr bgcolor=white>
	<td align=right>文件大小:</td>
	<td><input type=text name=prog_size value=<%=prog_size%> size=3>M</td>
</tr>
<tr bgcolor=white>
	<td align=right>歌名字数:</td>
	<td><input type=text name=prog_timespan value="<%=prog_timespan%>" size=4><input type=button value="<< 请点击生成字数" onclick="javascript:this.form.prog_timespan.value=this.form.prog_name.value.length;"></td>
</tr>
<tr bgcolor=white>
	<td align=right>歌手:</td>
	<td><select name=publisher>
		<%
		rs=null;
		rs = opendb.executeQuery("select singer_id,singer_name from singer_info order by type_other_id desc,binary singer_name");
		int singer_id=0;
		String singer_name="";
		while(rs != null && rs.next())
		{
			singer_id=rs.getInt(1);
			singer_name=rs.getString(2).trim();
			%>
			<option value="<%=singer_id%>"
			<%
			if(java.lang.Integer.parseInt(publisher)==singer_id)
				out.print(" selected");
			%>
			><%=singer_name%></option>
			<%
		}
		%>
		</select></td>
</tr>
<tr bgcolor=white>
	<td align=right>出版日期:</td>
	<td><input type=text name=pubdate value=<%=pubdate%>></td>
</tr>
<tr bgcolor=white>
	<td align=right><!-- 主要演员 -->歌名拼音:</td>
	<td><input type=text name=prog_acot value=<%=prog_acot%>><input type=button value="<< 请点击生成拼音" onclick="javascript:this.form.prog_acot.value=c(this.form.prog_name.value);"></td>
</tr>
<tr bgcolor=white>
	<td align=right>有效标志:</td>
	<td><select name=del_flag>
		<option value="1" 
		<%
		if(del_flag==1)
			out.print(" selected");
		%>
		>有效</option>
		<option value="-1" 
		<%
		if(del_flag==-1)
			out.print(" selected");
		%>
		>无效</option></select><span class=small>(只有设置为有效用户才能看到)</span></td>
</tr>
<tr bgcolor=white>
	<td align=right>影片级别:</td>
	<td><select name=prog_limit>
		<%
		rs=null;
		rs=opendb.executeQuery("select dentry_id,dentry_name from dict_entry where dtype_id=90 and del_flag=1 order by dentry_id");
		while(rs.next())
		{
			tmp_dentry_id=rs.getInt(1);
			tmp_dentry_name=rs.getString(2).trim();
			%>
			<option value="<%=tmp_dentry_id%>" 
			<%
			if(prog_limit==tmp_dentry_id)
				out.print(" selected");
			%>
			><%=tmp_dentry_name%></option>
			<%
		}
		%>
		</select>
	</td>
</tr>


<tr bgcolor=white>
	<td colspan=2 align=center><input type=submit value=提交修改>&nbsp;&nbsp;<input type=reset value="重置">&nbsp;&nbsp;<input type=button onclick="javascript:window.close()" value="取消修改"></td>
</tr>
</table>
<input type=hidden name=prog_id value="<%=prog_id%>">
<input type=hidden name=director value="<%=director%>">
<input type=hidden name=prog_describe value="noneed">
</form>
</body>
</html>
<%
opendb.dbclose();
%>