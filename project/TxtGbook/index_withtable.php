<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title>NetX���԰�</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<script language="javascript">
function check()
{
	if(window.document.board.username.value=="")
	{
		alert("����д�����ǳƣ�");
		document.board.username.focus();
		return false;
	}
	if(window.document.board.email.value!="" && !ismail(window.document.board.email.value))
	{
		alert("����E-Mail��ַ�Ƿ���");
		document.board.email.focus();
		return false;
	}

	if(window.document.board.content.value=="")
	{
		alert("������д��������");
		document.board.content.focus();
		return false;
	}
	return true;
}
function ismail(mail) 
{
	return(new RegExp(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/).test(mail)); 
}
function showReply(id)
{
	if(document.getElementById(id).style.display=='none')
	{
		document.getElementById(id).style.display='';
	}
	else
	{
		document.getElementById(id).style.display='none';
	}
}
function changeText(it)
{
	if(it.innerText=='�ظ�')
	{
		it.innerText='ȡ���ظ�';
	}
	else
	{
		it.innerText='�ظ�';
	}
}
function confirmdel(id)
{
	if(confirm("ȷ��ɾ����"))
	{
		window.location="delete.php?id="+id;
	}
	else
	{
		return;
	}
}
</script>

<body>
<div id="main">
<?
include_once "../header.php";
?>
<div id="form">
<div id="caption">��д����</div>
<table>
<form method="post" action="insert_2.php" name="board" onsubmit="return check();">
<tr>
	<td align="right">�� ��:</td>
	<td><input type=text name="username" size="18"><input type="checkbox" onclick="if(this.checked)document.board.username.value='����';else document.board.username.value='';">����</td>
</tr>
<tr>
	<td align="right">EMail:</td>
	<td><input type="text" name="email" size="18"><span style="font-size:11px;">(������⹫��)</span></td>
</tr>
<tr>
	<td align="right">�� ��:</td>
	<td><input type="text" name="title" size="18"></td>
</tr>
<tr>
	<td align="right">�� ��:</td>
	<td><textarea name="content" rows="5" cols="29"></textarea></td>
</tr>
<tr>
	<td></td>
	<td><input type="hidden" name="refer" value="<?=$_SERVER["REQUEST_URI"]?>">
	<input type="submit" value="�ύ">&nbsp;&nbsp;<input type="reset" value="��д"></td>
</tr>
</form>
</table>

<?
include_once "config.php";
if(''==$_SESSION['boardadmin'])
{
	?>
<div id="caption">����Ա��¼</div>
<table>
<form action="login.php" method="post" name="login">
<tr>
	<td align="right">����Ա:</td>
	<td><input type="text" name="admin" size="18"></td>
</tr>
<tr>
	<td align="right">�� ��:</td>
	<td><input type="password" name="passwd" size="18"></td>
</tr>
<tr>
	<td></td>
	<td><input type="hidden" name="refer" value="<?=$_SERVER["REQUEST_URI"]?>">
	<input type="submit" name="submit" value="��¼"></td>
</tr>
</form>
</table>
	<?
}
include_once 'count.php';
?>
</div><!-- div#form end -->
<div id="msg">
<?
$offset=$_REQUEST['offset'];
if($offset=="")
{
	$offset=0;
}
$j=0;
$k=0;
$msgCount=count(file($index_file));

$fp=fopen($index_file,"r");
while($line=trim(fgets($fp,1024)))
{
	$j++;//��ǰ��ȡ����
	if(''==$line || substr($line,0,1)=='#')
	{
		continue;//����ע��
	}
	elseif($j<=$offset)
	{
		continue;//ʵ�ַ�ҳ
	}
	else
	{
		showMsg($line);
		$k++;//����ʾ���Ե�����
		if($k>=$pageitem)
		{
			break;//����ҳ����Ŀ
		}
	}
}

function showMsg($filename)
{
	global $msgDir,$msgFileExt,$echoEmail;
	global $k,$offset;
	$msgFile=file($msgDir.$filename.$msgFileExt);
	for($i=0;$i<count($msgFile);$i++)
	{
		$msgFile[$i]=substr($msgFile[$i],0,strlen($msgFile[$i])-2);
	}
	echo '<div id="msgItem">';
	echo '<div id="msgTitle">';
	if(''==$msgFile[4])
	{
		echo '����';
	}
	else
	{
		echo $msgFile[4];
	}
	if(''!=$_SESSION['boardadmin'])
	{
		echo '&nbsp;&nbsp;[<a href="#" onclick="confirmdel(\''.$filename.'\')">ɾ��</a>]&nbsp;[<a href="javascript:void(0)" onclick="showReply(\''.$filename.'\'),changeText(this)">�ظ�</a>]</div>';
	}
	else
	{
		echo '</div>';
	}
	echo '<div id="msgContent">'.$msgFile[5].'</div>';
	echo '<div id="msgInfo">'.$msgFile[0];
	if(''!=$msgFile[1])
	{
		if($echoEmail)
		{
			echo '&lt;<a href="mailto://'.$msgFile[1].'">'.$msgFile[1].'</a>&gt;';
		}
		else
		{
			echo '&lt;E_mail������&gt;';
		}
	}
	echo '&nbsp;������'.$msgFile[2];
	echo '&nbsp;����'.substr($msgFile[3],0,strrpos($msgFile[3],'.')).'.*';
	echo '</div>';
	if(''!=$msgFile[6])
	{
		for($i=6;$i<count($msgFile);$i++)
		{
			$replyArr=explode("|><|",$msgFile[$i]);
			echo '<div id="msgReply">����Ա�ظ���'.$replyArr[0].'</div>';
			echo '<div id="msgContent">'.$replyArr[1].'</div>';
		}
	}
	echo '<div id='.$filename.' style="display:none">';
	echo '<form name="reply" action="reply.php" method="post" style="margin:0">';
	echo '<div id="msgReply">����Ա�ظ���</div>';
	echo '<textarea rows="4" cols="60" name="reContent"></textarea>';
	echo '<input type="hidden" name="refer" value="'.$_SERVER["REQUEST_URI"].'">';
	echo '<input type="hidden" name="msgFilename" value="'.$filename.'">';
	echo '<input type="submit" name="submit" value="�ύ">';
	echo '</form>';
	echo '</div>';
	echo '</div>';
}

if($offset!=0)
{
	echo '<a href="?offset=0">����ǰ��</a>&nbsp;&nbsp;';
	$preoffset=($offset-$pageitem)>0?($offset-$pageitem):0;
	echo '<a href="?offset='.$preoffset.'">��ǰһҳ��</a>&nbsp;&nbsp;';
}
else
{
	echo '����ǰ��&nbsp;&nbsp;';
	echo '��ǰһҳ��&nbsp;&nbsp;';
}
if(($offset+$pageitem)<$msgCount)
{
	$newoffset=$offset+$pageitem;
	$endpage=$msgCount-$pageitem;
	echo '<a href="?offset='.$newoffset.'">����һҳ��</a>&nbsp;&nbsp;';
	echo '<a href="?offset='.$endpage.'">�����</a>&nbsp;&nbsp;';
}
else
{
	echo '����һҳ��&nbsp;&nbsp;';
	echo '�����&nbsp;&nbsp;';
}
echo ' ��ǰ'.(ceil($offset/$pageitem)+1).'/'.ceil($msgCount/$pageitem).',��'.$msgCount.'��,ÿҳ'.$pageitem.'��<br />';

echo '<br>';

?>
<br />
</div>
<? 
include_once '../tail.php';
?>
<!-- div#msg end -->
</div><!-- div#main end -->
</body>
</html>
