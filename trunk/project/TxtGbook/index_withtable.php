<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title>NetX留言板</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<script language="javascript">
function check()
{
	if(window.document.board.username.value=="")
	{
		alert("请填写您的昵称！");
		document.board.username.focus();
		return false;
	}
	if(window.document.board.email.value!="" && !ismail(window.document.board.email.value))
	{
		alert("您的E-Mail地址非法！");
		document.board.email.focus();
		return false;
	}

	if(window.document.board.content.value=="")
	{
		alert("您忘了写留言内容");
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
	if(it.innerText=='回复')
	{
		it.innerText='取消回复';
	}
	else
	{
		it.innerText='回复';
	}
}
function confirmdel(id)
{
	if(confirm("确定删除？"))
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
<div id="caption">填写留言</div>
<table>
<form method="post" action="insert_2.php" name="board" onsubmit="return check();">
<tr>
	<td align="right">昵 称:</td>
	<td><input type=text name="username" size="18"><input type="checkbox" onclick="if(this.checked)document.board.username.value='匿名';else document.board.username.value='';">匿名</td>
</tr>
<tr>
	<td align="right">EMail:</td>
	<td><input type="text" name="email" size="18"><span style="font-size:11px;">(不会对外公开)</span></td>
</tr>
<tr>
	<td align="right">标 题:</td>
	<td><input type="text" name="title" size="18"></td>
</tr>
<tr>
	<td align="right">内 容:</td>
	<td><textarea name="content" rows="5" cols="29"></textarea></td>
</tr>
<tr>
	<td></td>
	<td><input type="hidden" name="refer" value="<?=$_SERVER["REQUEST_URI"]?>">
	<input type="submit" value="提交">&nbsp;&nbsp;<input type="reset" value="重写"></td>
</tr>
</form>
</table>

<?
include_once "config.php";
if(''==$_SESSION['boardadmin'])
{
	?>
<div id="caption">管理员登录</div>
<table>
<form action="login.php" method="post" name="login">
<tr>
	<td align="right">管理员:</td>
	<td><input type="text" name="admin" size="18"></td>
</tr>
<tr>
	<td align="right">口 令:</td>
	<td><input type="password" name="passwd" size="18"></td>
</tr>
<tr>
	<td></td>
	<td><input type="hidden" name="refer" value="<?=$_SERVER["REQUEST_URI"]?>">
	<input type="submit" name="submit" value="登录"></td>
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
	$j++;//当前读取行数
	if(''==$line || substr($line,0,1)=='#')
	{
		continue;//跳过注释
	}
	elseif($j<=$offset)
	{
		continue;//实现翻页
	}
	else
	{
		showMsg($line);
		$k++;//已显示留言的行数
		if($k>=$pageitem)
		{
			break;//限制页面条目
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
		echo '无题';
	}
	else
	{
		echo $msgFile[4];
	}
	if(''!=$_SESSION['boardadmin'])
	{
		echo '&nbsp;&nbsp;[<a href="#" onclick="confirmdel(\''.$filename.'\')">删除</a>]&nbsp;[<a href="javascript:void(0)" onclick="showReply(\''.$filename.'\'),changeText(this)">回复</a>]</div>';
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
			echo '&lt;E_mail已隐藏&gt;';
		}
	}
	echo '&nbsp;发表于'.$msgFile[2];
	echo '&nbsp;来自'.substr($msgFile[3],0,strrpos($msgFile[3],'.')).'.*';
	echo '</div>';
	if(''!=$msgFile[6])
	{
		for($i=6;$i<count($msgFile);$i++)
		{
			$replyArr=explode("|><|",$msgFile[$i]);
			echo '<div id="msgReply">管理员回复于'.$replyArr[0].'</div>';
			echo '<div id="msgContent">'.$replyArr[1].'</div>';
		}
	}
	echo '<div id='.$filename.' style="display:none">';
	echo '<form name="reply" action="reply.php" method="post" style="margin:0">';
	echo '<div id="msgReply">管理员回复：</div>';
	echo '<textarea rows="4" cols="60" name="reContent"></textarea>';
	echo '<input type="hidden" name="refer" value="'.$_SERVER["REQUEST_URI"].'">';
	echo '<input type="hidden" name="msgFilename" value="'.$filename.'">';
	echo '<input type="submit" name="submit" value="提交">';
	echo '</form>';
	echo '</div>';
	echo '</div>';
}

if($offset!=0)
{
	echo '<a href="?offset=0">【最前】</a>&nbsp;&nbsp;';
	$preoffset=($offset-$pageitem)>0?($offset-$pageitem):0;
	echo '<a href="?offset='.$preoffset.'">【前一页】</a>&nbsp;&nbsp;';
}
else
{
	echo '【最前】&nbsp;&nbsp;';
	echo '【前一页】&nbsp;&nbsp;';
}
if(($offset+$pageitem)<$msgCount)
{
	$newoffset=$offset+$pageitem;
	$endpage=$msgCount-$pageitem;
	echo '<a href="?offset='.$newoffset.'">【后一页】</a>&nbsp;&nbsp;';
	echo '<a href="?offset='.$endpage.'">【最后】</a>&nbsp;&nbsp;';
}
else
{
	echo '【后一页】&nbsp;&nbsp;';
	echo '【最后】&nbsp;&nbsp;';
}
echo ' 当前'.(ceil($offset/$pageitem)+1).'/'.ceil($msgCount/$pageitem).',共'.$msgCount.'条,每页'.$pageitem.'条<br />';

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
