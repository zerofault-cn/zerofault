<html>
<head>
<title>EBOX�������˹���ҳ��</title>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<link rel="stylesheet" href="style.css" type="text/css">
</head>

<body>
<a name="#top"></a>
<center>
<!-- top -->
<table width="760" border="0" cellpadding="0" cellspacing="0" style="border-width:0.2">
<tr>
	<td width="170" height="80" align=center bgcolor="#ffff00"><span class=big16>����ͨ��Դ����</span></td>
	<td width="590" align=center bgcolor="#ccff66"><span class=big14>��ɫ��Ϣ�ҵ��������ȫ����������</span></td>
</tr>
<tr>
	<td height="20" valign="top" colspan=2 bgcolor="#ffffcc"><marquee scrolldelay="200">�ٴ�����:�ϴ����ļ���<span style="color:red;font-size:12pt">���ܰ�������</span>��Ĭ����ӵļ�¼����Ч��,<span style="color:red;font-size:12pt">���ļ��ϴ�������ֶ���Ϊ��Ч</span></marquee></td>
</tr>
<tr>
	<td height="1" valign="top" colspan=2 bgcolor="#cccccc"></td>
</tr>
</table>
<!-- /top -->
<!-- center -->
<table width="760" border="0" cellpadding="0" cellspacing="0">
<tr>
	<td width=170 align=center valign=top><!-- left table -->
	<table width=170 border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width=100% align=center>
		<script language=javascript>
		today=new Date();
		function initarray()
		{
			this.length=initarray.arguments.length
			for(var i=0;i<this.length;i++)
				this[i+1]=initarray.arguments[i]  
		}
		var d=new initarray(" ������"," ����һ"," ���ڶ�"," ������"," ������"," ������"," ������");
		document.write("<font color=#ff0000 style='font-size:10pt;font-family: ����'> ",today.getYear(),"��",today.getMonth()+1,"��",today.getDate(),"��",d[today.getDay()+1],"</font>" ); 
		</script></td>
	</tr>
	<tr>
		<td width=100%><img src='image/linepoint.gif' height=1 width=100%></td>
	</tr>
	<tr>
		<td width=100%  align=center>
		<%
		if(session.getAttribute("goldsoft_admin")==null)
		{
			out.println("����δ��¼");
		}
		else
		{
			%>
			<jsp:include page="server_info.jsp"/>
			<%
		}
		%></td>
	</tr>
	<tr>
		<td width=100%><img src='image/linepoint.gif' height=1 width=100%></td>
	</tr>
	<tr>
		<td width=100%><jsp:include page="function.jsp"/></td>
	</tr>
	</table><!-- /left table -->
	</td>
	
	<td width=10 align=middle height=100%><img height="100%" src="image/linepoint.gif" width=1></td>
	<!-- right -->
	<td width=580 align=left valign=top>
	<%
	if(session.getAttribute("goldsoft_admin")==null)
	{
		%>
		<jsp:include page="login_1.jsp"/>
		<%
	}
	else
	{
		if(request.getParameter("content")==null)
		{
			%>
			<jsp:include page="vod_prog.jsp"/>
			<%
		}
		else
		{
			String mainfile=request.getParameter("content")+".jsp";
			session.setMaxInactiveInterval(300);
			String var1=request.getParameter("var1");
			String value1=request.getParameter("value1");
			String var2=request.getParameter("var2");
			String value2=request.getParameter("value2");
			if(var1!=null)
				session.setAttribute(var1,value1);
			if(var2!=null)
				session.setAttribute(var2,value2);
			%>
			<jsp:include page="<%=mainfile%>"/>
			<%
		}
	}
	%>
	</td><!-- /right -->
</tr>
</table>
<!-- /center -->

<!-- bottom -->
<div valign="bottom">
<hr width=80% size='0.6' noshade>
����֧�֣�028-85493331  E-mail��zerofault@163.com<br>
��Ȩ���У��Ĵ����ʿƼ����޹�˾ copyright &copy; 2004-2005 all rights reserved
</div>
<!-- /bottom -->

</center>
</body>
</html>
