<?
ob_start();
$site_title="SkyCall Product";
$page='product';
include_once "common_function.php";
include_once "mysql_connect.php";
include_once "top.php";
?>

<center>
<table width="770" border=0 cellpadding=0 cellspacing=0 bgcolor="#F4F8FF">
<tr>
	<td width=12 height="100%" background="image/border_left.gif"></td>
	<td align=center valign=top>
	<table width="100%" border=0 cellpadding=0 cellspacing=0>
	<tr>
		<td height=16></td>
	</tr>
	<tr>
		<td width=400 align=right valign=top>
		<table width="100%" border=0 cellpadding=0 cellspacing=0 bgcolor="#E5F4FF" style="line-height:130%">
		<tr>
			<td width=20 height=30><img src="image/table_top_left.gif"></td>
			<td colspan=2 background="image/table_top.gif" valign=bottom><img src="image/favorite_logo.gif"><img src="image/ecard_title1.gif"></td>
			<td width=18><img src="image/table_top_right.gif"></td>
		</tr>
		<tr>
			<td rowspan=2 background="image/table_left.gif"></td>
			<td colspan=2></td>
			<td rowspan=2 background="image/table_right.gif"></td>
		</tr>
		<tr>
			<td colspan=2 class=content>
			<div style="margin-left:2em;">
			<p><span class=tag>eCard</span>(������:�׿�)����������Ƭ���Ǳ����������ϵ�һ����Ƭ�����ȴ�ͳ����Ƭ�����㡣ֻҪ������վ��ע�ᣬȡ������<span class=tag>EPN</span>(Electronic Personal Number)���룬����ӵ����һ������ȫ����ĸ��˵�����Ƭ����ֻ��Ҫ������EPN������ߺ��ѣ��Ժ�һ��������ϵ��Ϣ�����䶯��ֻҪ�����ǵ���վ�ϸ���һ�����ĸ������ϼ��ɣ�����һһ֪ͨ���ĺ��ѣ����Ƕ���ͨ������֪����������ϵ��ʽ�����Skypeʹ�ã������ṩSkype״̬��ʱ��ʾ��������Ҫ��������ѣ�֪�����������ϵ���㡣��<a href="register.php">����</a>��ʼע�ᡣ</p>
			<p>��ֻ��Ҫ����ҳ����̳��Ƕ��һ�δ��룬��δ��뽫��ʾһ��eCard�ձ꣬����ձ�ȿ������ӵ�����eCard��ͬʱ������ʾ������Skype������״̬����������ߵ�����ͼ�꣬��������eCard��</p>
			<p>Ч����ʾ��<a href="eCard.php?epn=13823147901" title="�����eCard" target=_blank><img src="get_ecard_pic.php?s=goldsoft-lifeng" border="0" align=top></a></p>
			</div>
			</td>
		</tr>
		<tr>
			<td><img src="image/table_bottom_left.gif"></td>
			<td colspan=2 background="image/table_bottom.gif"></td>
			<td><img src="image/table_bottom_right.gif"></td>
		</tr>
		</table>
		</td>
		<td width=10></td>
		<td valign=bottom>
		<table width="100%" border=0 cellpadding=0 cellspacing=0>
		<tr>
			<td align=center>eCard��ʽ</td>
		</tr>
		<tr>
			<td align=center><img src="image/ecard_fig.gif" width=250></td>
		</tr>
		</table>
		<table width="100%" border=0 cellpadding=0 cellspacing=0 bgcolor="#E5F4FF" style="line-height:130%">
		<tr>
			<td width=20 height=30><img src="image/table_top_left.gif"></td>
			<td colspan=2 background="image/table_top.gif" valign=bottom><img src="image/ecard_logo2.gif"><img src="image/ecard_title2.gif"></td>
			<td width=18><img src="image/table_top_right.gif"></td>
		</tr>
		<tr>
			<td rowspan=2 background="image/table_left.gif"></td>
			<td colspan=2></td>
			<td rowspan=2 background="image/table_right.gif"></td>
		</tr>
		<tr>
			<td colspan=2 class=content>
			<div style="margin-left:2em;">	<p>�������ȡһ��HTML���룬����ճ����������վ�ϻ������κ���̳�ϵĸ���ǩ�������ɡ�</p>
			<p>����eCard����ʾ����Skype������״̬���������ߵ��ͼ�꣬���ᵯ������eCard��Ϣ������������߿���������������ͨ��Skype����Ҳ���Ը�������Skype��ʱ��Ϣ��</p>
			</div>
			</td>
		</tr>
		<tr>
			<td><img src="image/table_bottom_left.gif"></td>
			<td colspan=2 background="image/table_bottom.gif"></td>
			<td><img src="image/table_bottom_right.gif"></td>
		</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td colspan=3>
		<table width="100%" border=0 cellpadding=0 cellspacing=0 bgcolor="#E5F4FF" style="line-height:130%">
		<tr>
			<td width=20 height=30><img src="image/table_top_left.gif"></td>
			<td colspan=2 background="image/table_top.gif" valign=bottom><img src="image/ecard_logo3.gif"><img src="image/ecard_title3.gif"></td>
			<td width=18><img src="image/table_top_right.gif"></td>
		</tr>
		<tr>
			<td rowspan=2 background="image/table_left.gif"></td>
			<td colspan=2></td>
			<td rowspan=2 background="image/table_right.gif"></td>
		</tr>
		<tr>
			<td colspan=2 class=content>
			<?
			if(!isset($_COOKIE['cookie_user_id']) || !isset($_COOKIE['cookie_user_account']) || ''==$_COOKIE['cookie_user_account'])
			{
				setcookie('cookie_returnUrl',$_SERVER['REQUEST_URI']);
				?>
				<div align=center><span class=errormsg>��û��<a href="login.php">��¼</a>,����ʹ�ô˹���<br><br>�������û��ע��,���<a href="register.php">����</a>���ע��<br><br></span></div>
				<?
			}
			else
			{
				$sql1="select user_account,user_skype from user_info where user_id=".$_COOKIE['cookie_user_id'];
				$result1=mysql_query($sql1);
				$user_account=mysql_result($result1,0,0);
				$user_skype=mysql_result($result1,0,1);
			?>
			<SCRIPT language=JavaScript>
			function htmlcode()
			{
				document.getElementById("MyCode").innerText="<a href=\"http://www.skycall.cn/get_ecardx.php?epn=<?=$user_account?>\" title=\"������ҵ�eCard\" target=\"_blank\"><img src=\"http://www.skycall.cn/get_ecard_pic.php?s=<?=$user_skype?>\" border=0></a>";
			}
			function bbscode()
			{
				document.getElementById("MyCode").innerText="[url=http://www.skycall.cn/get_ecard.php?epn=<?=$user_account?>][img]http://www.skycall.cn/get_ecard_pic.php?s=<?=$user_skype?>[/img][/url]";
			}
			function copyText(obj) {
			var rng = document.body.createTextRange();
			rng.moveToElementText(obj);
			rng.scrollIntoView();
			rng.select();
			rng.execCommand("Copy");
			rng.collapse(false);
			}
			</script>
			<div style="margin-left:2em;">
			<p>����һ��ȷ������Skype�Ѿ���ӡ�<span style="color:red">goldsoft01</span>��Ϊ���ѡ�</p>
			<p>���������д��ȷ����ϵ��ʽ�����<a href="eCard_profile.php">����</a>�༭��</p>
			<p>�������������Ӧ�İ�ť����������Ҫ�Ĵ��롣</p>
			<table border=0 cellpadding=0 cellspacing=0>
			<tr>
				<td width=24></td>
				<td>
				<span style="margin-left:4em;">
				<a onclick="htmlcode()" style="cursor:hand"><img src="image/ecard_btn1.gif"></a>&nbsp;&nbsp;
				<a onclick="bbscode()" style="cursor:hand"><img src="image/ecard_btn2.gif"></a></span>
				</td>
				<td align=right><a onclick="javascript:copyText(document.all.MyCode);" style="cursor:hand"><img src="image/ecard_btn3.gif" border="0"></a>
				</td>
			</tr>
			<tr>
				<td></td>
				<td colspan=2>
				<span style="margin-left:4em;"><textarea cols=70 rows=6 id="MyCode" name="MyCode">������Ӧ��ť��������Ӧ���룡</textarea></span>
				</td>
			</tr>
			</table>
			<p>�����ģ�������ġ����ƴ��롱��ť��Ȼ��ճ�������Լ�����վ����̳�ϡ�</p>
			<p>�����壺<a href="get_ecard.php?epn=<?=$_COOKIE['cookie_user_account']?>">eCardԤ��</a></p>
			</div>
			<?
			}
			?>
			</td>
		</tr>
		<tr>
			<td><img src="image/table_bottom_left.gif"></td>
			<td colspan=2 background="image/table_bottom.gif"></td>
			<td><img src="image/table_bottom_right.gif"></td>
		</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td height=16></td>
	</tr>
	</table>
	<td width=12 background="image/border_right.gif"></td>
</tr>
</table>
</center>
<?
include_once "footer.php";
ob_end_flush();
?>
