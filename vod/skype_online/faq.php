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
			<td align=center  <?if($subject_id==1)echo 'class="topSelected"'?>><a class=text16 href="?action=faq&subject_id=1">Skypeʹ��˵��</a></td>
			<td align=center  <?if($subject_id==2)echo 'class="topSelected"'?>><a class=text16 href="?action=faq&subject_id=2">Skype��������</a></td>
			<td align=center  <?if($subject_id==3)echo 'class="topSelected"'?>><a class=text16 href="?action=faq&subject_id=3">SkyMateʹ��˵��</a></td>
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
			<td><a href="#1">1.����Skype</a></td>
			<td><a href="#2">2.��װ</a></td>
			<td><a href="#3">3.ע���û�</a></td>
		</tr>
		<tr>
			<td><a href="#4">4.��д�û�����</a></td>
			<td><a href="#5">5.��Ӻ���</a></td>
			<td><a href="#6">6.���ͼ�ʱ��Ϣ</a></td>
		</tr>
		<tr>
			<td><a href="#7">7.��������</a></td>
			<td><a href="#8">8.������������</a></td>
			<td><a href="#9">9.������ͨ�绰</a></td>
		</tr>
		<tr>
			<td><a href="#10">10.�����ǳƼ�������������</a></td>
			<td><a href="#11">11.�����Լ�����Ƭ</a></td>
			<td></td>
		</tr>
		</table>
		<hr class=dotted size=0.5 width="90%">
		<table width="90%" border=0 cellpadding=0 cellspacing=0>
		<tr>
			<td>
			<a name=1></a><b>1. ����Skype</b>
			<p>��ʹ�ñ����֮ǰ������Ҫ�Ȼ�ñ���������°汾����Ϊֻ�����°汾�����������õļ����ԡ�<br>�����Ҫ���skype��������°汾�������Ƚ���skype�Ĺٷ���վ������ͼ���������������skype�ٷ���վ����ַ<a href="http://www.skype.com" target=_blank>http://www.skype.com</a>����</p>
			<p align=center><img src="image/faq/image11.jpg"></p>
			<p>�����DOWNLOAD��ͼ�꣬</p>
			<p align=center><img src="image/faq/image12.jpg"></p>
			<p>�����Ը������Ĳ���ϵͳѡ�����ض�Ӧ�İ汾.</p>
			<a href="#top"><span style="color:#ff3333">top��</span></a><br>
			</td>
		</tr>
		</table>
		<hr class=dotted size="0.5" width="90%">
		<table width="90%" border=0 cellpadding=0 cellspacing=0>
		<tr>
			<td>
			<a name=2></a><b>2. ��װSkype</b>
			<p>�ղ��������ص����������SkypeSetup.exe����װ��ʱ��ֻ��Ҫ��������˫���������Խ�������İ�װ��</p>
			<p align=center><img src="image/faq/image13.jpg"></p>
			<p>��ʼ��װ֮���������ʾ��ѡ������ʹ�õ����ԣ�Ĭ�ϵ��ǡ�Chinese(PRC)��������ֻҪ����Ĭ�ϼ��ɣ��������Ҫ�����汾��������ѡ��</p>
			<p align=center><img src="image/faq/image14.jpg"></p>
			<p>�ڰ�װ֮ǰ���Ƚ������Э�飬�������ͬ�����Э�����޷�������װ�ġ�</p>
			<p align=center><img src="image/faq/image15.jpg"></p>
			<p>ѡ����һ����ʼ�����ļ�,������ɺ�������ɡ����ɡ�</p>
			<a href="#top"><span style="color:#ff3333">top��</span></a><br>
			</td>
		</tr>
		</table>
		<hr class=dotted size="0.5" width="90%">
		<table width="90%" border=0 cellpadding=0 cellspacing=0>
		<tr>
			<td>
			<a name=3></a><b>3. ע���û�</b>
			<p>������Ҫ����Skype���,˫��������skype�Ŀ�ݷ�ʽ���ɿ�ʼ����.<br></p>
			<p>�������û��skype�ʻ�,���������ϵͳ��Ҫ����ע��һ���µ��ʻ�����ֻ��Ҫ�Ѵ�*�ĵط���д�����Ϳ����ˡ�</p>
			<p align=center><img src="image/faq/image16.jpg"></p>
			<p>ע�⣺�û�����������ĸ��ʼ�����԰������֣������ܰ����ո�ͬʱ��һ��Ҫ�������Э��������ע�ᡣ�������������һ���Ϳ��Դ����û��ˣ��������Կ��������û��Ĺ������������ǰ�û����Ѿ���ռ�õĻ��������Ҫ��������һ��������ʹ��ϵͳ�Զ�������û�����</p>
			<p>��������û�����û�б������˱�ע�ᣬ��ô��ϲ��������ע��ɹ��������Խ�����һ��������д�û����ϡ�</p> 
			<a href="#top"><span style="color:#ff3333">top��</span></a><br>
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
