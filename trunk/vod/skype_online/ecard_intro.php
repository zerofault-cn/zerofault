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
			<p><span class=tag>eCard</span>(中文名:易卡)，即电子名片，是保存在网络上的一种名片，它比传统的名片更方便。只要您在网站上注册，取得您的<span class=tag>EPN</span>(Electronic Personal Number)号码，您就拥有了一张漫游全世界的个人电子名片，您只需要把您的EPN号码告诉好友，以后一旦您的联系信息发生变动，只要在我们的网站上更新一下您的个人资料即可，不必一一通知您的好友，他们都能通过它获知您的最新联系方式；配合Skype使用，我们提供Skype状态即时显示，让马上要找你的朋友，知道现在如何联系到你。点<a href="register.php">这里</a>开始注册。</p>
			<p>您只需要在网页或论坛中嵌入一段代码，这段代码将显示一个eCard徽标，这个徽标既可以链接到您的eCard，同时它还显示出您的Skype的在线状态，如果访问者点击这个图标，将打开您的eCard。</p>
			<p>效果演示：<a href="eCard.php?epn=13823147901" title="点击打开eCard" target=_blank><img src="get_ecard_pic.php?s=goldsoft-lifeng" border="0" align=top></a></p>
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
			<td align=center>eCard样式</td>
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
			<div style="margin-left:2em;">	<p>从这里获取一段HTML代码，将他粘贴到您的网站上或其它任何论坛上的个人签名处即可。</p>
			<p>您的eCard将显示您的Skype的在线状态，当访问者点击图标，将会弹出您的eCard信息，在上面访问者可以立即呼叫您（通过Skype），也可以给您发送Skype即时消息。</p>
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
				<div align=center><span class=errormsg>您没有<a href="login.php">登录</a>,不能使用此功能<br><br>如果您还没有注册,请点<a href="register.php">这里</a>免费注册<br><br></span></div>
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
				document.getElementById("MyCode").innerText="<a href=\"http://www.skycall.cn/get_ecardx.php?epn=<?=$user_account?>\" title=\"点击打开我的eCard\" target=\"_blank\"><img src=\"http://www.skycall.cn/get_ecard_pic.php?s=<?=$user_skype?>\" border=0></a>";
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
			<p>步骤一：确认您的Skype已经添加“<span style="color:red">goldsoft01</span>”为好友。</p>
			<p>步骤二：填写正确的联系方式，请点<a href="eCard_profile.php">这里</a>编辑。</p>
			<p>步骤三：点击相应的按钮生成您所需要的代码。</p>
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
				<span style="margin-left:4em;"><textarea cols=70 rows=6 id="MyCode" name="MyCode">请点击相应按钮，生成相应代码！</textarea></span>
				</td>
			</tr>
			</table>
			<p>步骤四：点上面的“复制代码”按钮，然后粘贴到您自己的网站或论坛上。</p>
			<p>步骤五：<a href="get_ecard.php?epn=<?=$_COOKIE['cookie_user_account']?>">eCard预览</a></p>
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
