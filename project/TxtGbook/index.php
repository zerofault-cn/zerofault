<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title>NetX���԰�</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<!-- һ�������ı������԰�,�ɹ���,�ɻظ� -->
<script language="javascript">
/**
*�����û������Ƿ�Ϸ�
*/
function check()
{
	if(document.board.username.value=="")
	{
		alert("����д�����ǳƣ�");
		document.board.username.focus();
		return false;
	}
	if(document.board.email.value!="" && !ismail(document.board.email.value))
	{
		alert("����E-Mail��ַ�Ƿ���");
		document.board.email.focus();
		return false;
	}

	if(document.board.content.value=="")
	{
		alert("������д��������");
		document.board.content.focus();
		return false;
	}
	return true;
}
/**
*�����ʼ���ַ�Ƿ�Ϸ�
*/
function ismail(mail) 
{
	return(new RegExp(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/).test(mail)); 
}
/**
*��ʾ�ظ���
*/
function showReply(id)
{
	if(document.getElementById(id).style.display=='none')
	{
		document.getElementById(id).style.display='';
	//	alert(document.reply_2006-11-11_14-51-52_1153.refer.value);
	//	eval('document.reply_'+id).reContent.focus();
	}
	else
	{
		document.getElementById(id).style.display='none';
	}
}
/**
*������л�����
*/
function changeText(it)
{
	if(it.innerHTML=='�ظ�')
	{
		it.innerHTML='ȡ���ظ�';
	}
	else
	{
		it.innerHTML='�ظ�';
	}
}
/**
*ȷ��ɾ��
*/
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
/**
*����ͷ��
*/
include_once "../header.php";
?>
<div id="form">
<!-- �û����Ա� -->
<form method="post" action="insert_2.php" name="board" onsubmit="return check();">
<div id="caption">��д����</div>
<div id="tr"><span id="field1">�� ��:</span><span id="field2"><input type=text name="username" size="18"><input type="checkbox" onclick="if(this.checked)document.board.username.value='����';else document.board.username.value='';">����</span></div>
<div id="tr"><span id="field1">EMail:</span><span id="field2"><input type="text" name="email" size="18"><span style="font-size:11px;">(������⹫��)</span></div>
<div id="tr"><span id="field1">�� ��:</span><span id="field2"><input type="text" name="title" size="18"></span></div>
<div id="tr"><span id="field1">�� ��:</span><span id="field2"><textarea name="content" rows="5" cols="29"></textarea></span></div>
<div id="tr"><span id="field3"><input type="submit" value="�ύ">&nbsp;&nbsp;<input type="reset" value="��д"></span></div>
<input type="hidden" name="refer" value="<?=$_SERVER["REQUEST_URI"]?>">
</form>

<?
/**
*���������ļ�
*/
include_once "config.php";
/**
*�жϹ���Ա�Ƿ��ѵ�½
*/
if(''==$_SESSION['boardadmin'])
{
	?>
<form action="login.php" method="post" name="login">
<div id="caption">����Ա��¼</div>
<div id="tr"><span id="field1">����Ա:</span><span id="field2"><input type="text" name="admin" size="18"></span></div>
<div id="tr"><span id="field1">��&emsp;��:</span><span id="field2"><input type="password" name="passwd" size="18"></span></div>
<div id="tr"><span id="field3"><input type="hidden" name="refer" value="<?=$_SERVER["REQUEST_URI"]?>">
<input type="submit" name="submit" value="��¼"></span></div>
</form>
	<?
}
/**
*���������
*/
include_once 'count.php';
?>
</div><!-- div#form end -->
<div id="msg">
<?
$offset=$_REQUEST['offset'];//��ҳoffset
if($offset=="")
{
	$offset=0;
}
$j=0;//��ǰ��ȡ��������
$k=0;//����ʾ���Ե�����
static $n=0;
$msgCount=count(file($index_file));//ȡ���������Ե�����

$fp=fopen($index_file,"r");
while($line=trim(fgets($fp,1024)))//���ж�ȡ�������ļ����ļ�����
{
	$j++;
	if(''==$line || substr($line,0,1)=='#')
	{
		continue;//�������к���"#"��ͷ��ע����
	}
	elseif($j<=$offset)
	{
		continue;//����offset,ʵ�ַ�ҳ
	}
	else
	{
		showMsg($line);//��ʾ��������ļ�������
		$k++;
		if($k>=$pageitem)
		{
			break;//�����趨��ҳ�����������ѭ��
		}
	}
}
/**
*��ʾĳ���ļ����е�������Ϣ
*/
function showMsg($filename)
{
	global $msgDir,$msgFileExt,$echoEmail;
	global $k,$offset;
	global $n;
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
		echo '&nbsp;&nbsp;[<a href="#" onclick="confirmdel(\''.$filename.'\')">ɾ��</a>]&nbsp;[<a href="javascript:void(0)" onclick="showReply(\''.$filename.'\'),changeText(this);document.reply_'.$n.'.reContent.focus();">�ظ�</a>]</div>';
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
	echo '<form name="reply_'.$n.'" action="reply.php" method="post" style="margin:0">';
	echo '<div id="msgReply">����Ա�ظ���</div>';
	echo '<textarea rows="4" cols="60" name="reContent"></textarea>';
	echo '<input type="hidden" name="refer" value="'.$_SERVER["REQUEST_URI"].'">';
	echo '<input type="hidden" name="msgFilename" value="'.$filename.'">';
	echo '<input type="submit" name="submit" value="�ύ">';
	echo '</form>';
	echo '</div>';
	echo '</div>';
	$n++;
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
