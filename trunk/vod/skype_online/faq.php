<?
ob_start();
$site_title="FAQ";
$page='faq';
include_once "common_function.php";
include_once "mysql_connect.php";
include_once "top.php";

if(!isset($subject_id) || ''==$subject_id)
{
	$subject_id=1;
}
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
		<td align=center valign=top>
		<a name=top></a>
		<table width="90%" border=0 cellpadding=0 cellspacing=0 class=subtopNavigation>
		<tr>
			<td align=center  <?if($subject_id==1)echo 'class="topSelected"'?>><a class=text16 href="?action=faq&subject_id=1">Skype使用说明</a></td>
			<td align=center  <?if($subject_id==2)echo 'class="topSelected"'?>><a class=text16 href="?action=faq&subject_id=2">Skype常见问题</a></td>
			<td align=center  <?if($subject_id==3)echo 'class="topSelected"'?>><a class=text16 href="?action=faq&subject_id=3">SkyMate使用说明</a></td>
		</tr>
		<tr>
			<td colspan=3 height=1 bgcolor=#a5bede></td>
		</tr>
		</table>
		<?
		if($subject_id==1)
		{
			?>
		<table width="90%" border=0 cellpadding=0 cellspacing=0 class=faqLink>
		<tr>
			<td><a href="#1">1.下载Skype</a></td>
			<td><a href="#2">2.安装</a></td>
			<td><a href="#3">3.注册用户</a></td>
		</tr>
		<tr>
			<td><a href="#4">4.填写用户资料</a></td>
			<td><a href="#5">5.添加好友</a></td>
			<td><a href="#6">6.发送即时消息</a></td>
		</tr>
		<tr>
			<td><a href="#7">7.语音呼叫</a></td>
			<td><a href="#8">8.多人语音会议</a></td>
			<td><a href="#9">9.拨打普通电话</a></td>
		</tr>
		<tr>
			<td><a href="#10">10.更改昵称及其他个人资料</a></td>
			<td><a href="#11">11.更改自己的照片</a></td>
			<td></td>
		</tr>
		</table>
		<hr class=dotted size=0.5 width="90%">
		<table width="90%" border=0 cellpadding=0 cellspacing=0>
		<tr>
			<td>
			<a name=1></a><b>1. 下载Skype</b>
			<p>在使用本软件之前，您需要先获得本软件的最新版本，因为只有最新版本的软件才有最好的兼容性。<br>如果您要获得skype软件的最新版本，可以先进入skype的官方网站（如下图，在浏览器中输入skype官方网站的网址<a href="http://www.skype.com" target=_blank>http://www.skype.com</a>）。</p>
			<p align=center><img src="image/faq/image11.jpg"></p>
			<p>点击“DOWNLOAD”图标，</p>
			<p align=center><img src="image/faq/image12.jpg"></p>
			<p>您可以根据您的操作系统选择下载对应的版本.</p>
			<a href="#top"><span style="color:#ff3333">top△</span></a><br>
			</td>
		</tr>
		</table>
		<hr class=dotted size="0.5" width="90%">
		<table width="90%" border=0 cellpadding=0 cellspacing=0>
		<tr>
			<td>
			<a name=2></a><b>2. 安装Skype</b>
			<p>刚才我们下载的软件名称是SkypeSetup.exe，安装的时候只需要用鼠标左键双击它即可以进行软件的安装。</p>
			<p align=center><img src="image/faq/image13.jpg"></p>
			<p>开始安装之后，软件会提示您选择您所使用的语言，默认的是“Chinese(PRC)”，我们只要保持默认即可，如果您需要其他版本可以自行选择。</p>
			<p align=center><img src="image/faq/image14.jpg"></p>
			<p>在安装之前请先接受许可协议，如果您不同意许可协议是无法继续安装的。</p>
			<p align=center><img src="image/faq/image15.jpg"></p>
			<p>选择下一步开始复制文件,复制完成后点击“完成”即可。</p>
			<a href="#top"><span style="color:#ff3333">top△</span></a><br>
			</td>
		</tr>
		</table>
		<hr class=dotted size="0.5" width="90%">
		<table width="90%" border=0 cellpadding=0 cellspacing=0>
		<tr>
			<td>
			<a name=3></a><b>3. 注册用户</b>
			<p>首先需要运行Skype软件,双击桌面上skype的快捷方式即可开始运行.<br></p>
			<p>如果您还没有skype帐户,软件启动后系统会要求您注册一个新的帐户，你只需要把带*的地方填写完整就可以了。</p>
			<p align=center><img src="image/faq/image16.jpg"></p>
			<p>注意：用户名必须以字母开始，可以包含数字，但不能包含空格，同时，一定要接受许可协议才能完成注册。接下来，点击下一步就可以创建用户了，您将可以看到创建用户的滚动条，如果当前用户名已经被占用的话，软件会要求您更换一个，或者使用系统自动分配的用户名。</p>
			<p>如果您的用户名还没有被其他人被注册，那么恭喜您，您的注册成功，您可以进入下一步－－填写用户资料。</p> 
			<a href="#top"><span style="color:#ff3333">top△</span></a><br>
			</td>
		</tr>
		</table>
		<?
		}
		elseif($subject_id==2)
		{
			?>
			<hr class=dotted size="0.5" width="90%">
			<?
		}
		elseif($subject_id==3)
		{
			?>
			<hr class=dotted size="0.5" width="90%">
			<?
		}
		?>
		</td>
	</tr>
	<tr>
		<td height=16></td>
	</tr>
	</table>]
	<td width=12 background="image/border_right.gif"></td>
</tr>
</table>
</center>
<?
include_once "footer.php";
ob_end_flush();
?>
