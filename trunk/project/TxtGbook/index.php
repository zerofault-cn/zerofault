<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title>NetX留言板</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<!-- 一个基于文本的留言板,可管理,可回复 -->
<script language="javascript">
/**
*检验用户输入是否合法
*/
function check()
{
	if(document.board.username.value=="")
	{
		alert("请填写您的昵称！");
		document.board.username.focus();
		return false;
	}
	if(document.board.email.value!="" && !ismail(document.board.email.value))
	{
		alert("您的E-Mail地址非法！");
		document.board.email.focus();
		return false;
	}

	if(document.board.content.value=="")
	{
		alert("您忘了写留言内容");
		document.board.content.focus();
		return false;
	}
	return true;
}
/**
*检验邮件地址是否合法
*/
function ismail(mail) 
{
	return(new RegExp(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/).test(mail)); 
}
/**
*显示回复表单
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
*点击后切换文字
*/
function changeText(it)
{
	if(it.innerHTML=='回复')
	{
		it.innerHTML='取消回复';
	}
	else
	{
		it.innerHTML='回复';
	}
}
/**
*确认删除
*/
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
/**
*引用头部
*/
include_once "../header.php";
?>
<div id="form">
<!-- 用户留言表单 -->
<form method="post" action="insert_2.php" name="board" onsubmit="return check();">
<div id="caption">填写留言</div>
<div id="tr"><span id="field1">昵 称:</span><span id="field2"><input type=text name="username" size="18"><input type="checkbox" onclick="if(this.checked)document.board.username.value='匿名';else document.board.username.value='';">匿名</span></div>
<div id="tr"><span id="field1">EMail:</span><span id="field2"><input type="text" name="email" size="18"><span style="font-size:11px;">(不会对外公开)</span></div>
<div id="tr"><span id="field1">标 题:</span><span id="field2"><input type="text" name="title" size="18"></span></div>
<div id="tr"><span id="field1">内 容:</span><span id="field2"><textarea name="content" rows="5" cols="29"></textarea></span></div>
<div id="tr"><span id="field3"><input type="submit" value="提交">&nbsp;&nbsp;<input type="reset" value="重写"></span></div>
<input type="hidden" name="refer" value="<?=$_SERVER["REQUEST_URI"]?>">
</form>

<?
/**
*引入配置文件
*/
include_once "config.php";
/**
*判断管理员是否已登陆
*/
if(''==$_SESSION['boardadmin'])
{
	?>
<form action="login.php" method="post" name="login">
<div id="caption">管理员登录</div>
<div id="tr"><span id="field1">管理员:</span><span id="field2"><input type="text" name="admin" size="18"></span></div>
<div id="tr"><span id="field1">口&emsp;令:</span><span id="field2"><input type="password" name="passwd" size="18"></span></div>
<div id="tr"><span id="field3"><input type="hidden" name="refer" value="<?=$_SERVER["REQUEST_URI"]?>">
<input type="submit" name="submit" value="登录"></span></div>
</form>
	<?
}
/**
*引入计数器
*/
include_once 'count.php';
?>
</div><!-- div#form end -->
<div id="msg">
<?
$offset=$_REQUEST['offset'];//翻页offset
if($offset=="")
{
	$offset=0;
}
$j=0;//当前读取到的行数
$k=0;//已显示留言的行数
static $n=0;
$msgCount=count(file($index_file));//取得已有留言的条数

$fp=fopen($index_file,"r");
while($line=trim(fgets($fp,1024)))//按行读取出留言文件的文件名名
{
	$j++;
	if(''==$line || substr($line,0,1)=='#')
	{
		continue;//跳过空行和已"#"开头的注释行
	}
	elseif($j<=$offset)
	{
		continue;//跳过offset,实现翻页
	}
	else
	{
		showMsg($line);//显示这个留言文件的内容
		$k++;
		if($k>=$pageitem)
		{
			break;//超过设定的页面条数则结束循环
		}
	}
}
/**
*显示某个文件名中的留言信息
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
		echo '无题';
	}
	else
	{
		echo $msgFile[4];
	}
	if(''!=$_SESSION['boardadmin'])
	{
		echo '&nbsp;&nbsp;[<a href="#" onclick="confirmdel(\''.$filename.'\')">删除</a>]&nbsp;[<a href="javascript:void(0)" onclick="showReply(\''.$filename.'\'),changeText(this);document.reply_'.$n.'.reContent.focus();">回复</a>]</div>';
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
	echo '<form name="reply_'.$n.'" action="reply.php" method="post" style="margin:0">';
	echo '<div id="msgReply">管理员回复：</div>';
	echo '<textarea rows="4" cols="60" name="reContent"></textarea>';
	echo '<input type="hidden" name="refer" value="'.$_SERVER["REQUEST_URI"].'">';
	echo '<input type="hidden" name="msgFilename" value="'.$filename.'">';
	echo '<input type="submit" name="submit" value="提交">';
	echo '</form>';
	echo '</div>';
	echo '</div>';
	$n++;
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
