<?
ob_start();
error_reporting("E_ALL & ~E_NOTICE");
setcookie("last_uri",$_SERVER['REQUEST_URI']);
include_once "../include/mysql_connect.php";
include_once "../include/getplaypath.php";
$content=$_REQUEST["content"];
//print_r($_COOKIE);
//include_once "message_alert.php";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>EBOX��������Դ����[<?=substr(strrchr($_SERVER["SERVER_ADDR"],"."),1)?>]</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>

<body topmargin=0>
<a name="#top"></a>
<center>
<!-- top -->
<table width="760" border="0" cellpadding="0" cellspacing="0" style="border-width:0.2">
<!-- <tr>
	<td width="170" height="80" align=center bgcolor="#ffff00"><span class=big16>����ͨ��Դ����</span></td>
	<td width="590" align=center bgcolor="#ccff66"><span class=big14>��ɫ��Ϣ�ҵ��������ȫ����������</span></td>
</tr> -->
<tr>
	<td><img src="image/topbar.jpg"></td>
</tr>
<tr>
	<td height="20" valign="top" colspan=2 bgcolor="#ffffcc"><marquee scrolldelay="200"></marquee></td>
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
		<td width="100%"><img src='image/linepoint.gif' height=1 width="100%"></td>
	</tr>
	<tr>
		<td width="100%" align=center>
		<?
		if(!isset($_COOKIE["goldsoft_admin"])||$_COOKIE["goldsoft_admin"]=="")
		{
			echo "����δ��¼";
		}
		else
		{
			include "server_info.php";
		}
		?></td>
	</tr>
	<tr>
		<td width="100%"><img src='image/linepoint.gif' height=1 width="100%"></td>
	</tr>
	<tr>
		<td width="100%"><?include "function.php";?></td>
	</tr>
	</table><!-- /left table -->
	</td>
	<td width=10 align=middle height='100%'><img height="100%" src="image/linepoint.gif" width=1></td>
	<!-- right -->
	<td rowspan=2 width=580 valign=top>
	<?
	if(!isset($_COOKIE["goldsoft_admin"])||$_COOKIE["goldsoft_admin"]=="")
	{
		include "login_1.php";
	}
	else
	{
		if(!isset($content)||$content=="")
		{
			include "user_online_view.php";//Ĭ����ʾ����
		}
		elseif(substr($content,0,7)=='mp3_add_ok')
		{
			echo '<br><br><br><br><h3 style="color:red">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;��̨ά����,��ͣMP3�ϴ�</h3>';
		}
		else
		{
			include $content.".php";
		}
	}
	?>
	</td><!-- /right -->
</tr>
</table>
<!-- /center -->

<!-- bottom -->
<div valign="bottom">
<hr width="80%" size='0.6' noshade>
����֧�֣�028-85493331  E-mail��zerofault@163.com<br>
��Ȩ���У��Ĵ����ʿƼ����޹�˾ copyright &copy; 2004 all rights reserved<br>
ע��:Ϊ������ʹ��ҳ���ṩ�Ĺ���,��ʹ�û���<span style="color:red">IE</span>�ں˵������
</div>
<!-- /bottom -->

</center>
</body>
</html>
<?
ob_end_flush();
?>