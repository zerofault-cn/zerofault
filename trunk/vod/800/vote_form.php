<?
include_once "../include/db_connect.php";
$today=date("Y-m-d");
$sql1="select * from vote_subject where begin_date>=curdate() and begin_date<=end_date order by id desc limit 1";
$result1=$db->sql_query($sql1);
if($result1!='' && $db->sql_numrows($result1)>0)
{
	$subject_id=$db->sql_fetchfield(0,0,$result1);
	if($v!='again' && isset($_COOKIE['voted_id'])&&$_COOKIE['voted_id']==$subject_id)
	{
		echo '您已经投过一次了,';
		echo '<a href="?v=again">再投一次</a>';
	}
	else
	{
		?>
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
		<link rel="stylesheet" href="style.css" type="text/css">
		<title>统计</title>
		</head>
		<body leftMargin=0 topMargin=0 bgcolor="#6699cc" background="image/other/vote_bg.jpg" onload="onfoc(0)" style="background-Attachment:fixed;background-repeat:no-repeat;">
		<table width="800" height="590" border="1" cellpadding="0" cellspacing="0">
		<tr>
			<td width=20 height=10></td>
			<td width=760></td>
			<td width=20></td>
		</tr>
		<tr>
			<td height=560>&nbsp;</td>
			<td valign=top>
			<!--************************************ 可视面积:嵌入内容 *************************************************-->
		<table width="760" border="1" cellpadding="0" cellspacing="0">
		<tr>
			<td width=30 height=60></td>
			<td width=720></td>
			<td width=10></td>
		</tr>
		<tr>
			<td height="400"></td>
			<td>
			<table width="100%" height="350" border=0 cellpadding=0 cellspacing=0>
			<form name=vote method=post action="vote_submit.php">
			<?
			$title=$db->sql_fetchfield(1,0,$result1);
			$begin_date=$db->sql_fetchfield(2,0,$result1);
			$end_date=$db->sql_fetchfield(3,0,$result1);
			$mode=$db->sql_fetchfield(4,0,$result1);
			?>
			<caption class=style32b><?=$title?></caption>
			<?
			$i=0;
			$sql2="select * from vote_item where subject_id='".$subject_id."' order by id";
			$result2=$db->sql_query($sql2);
			$rows=$db->sql_numrows($result2);
			while($row=$db->sql_fetchrow($result2))
			{
				$i++;
				$item_id=$row[0];
				$item_title=$row[2];
				?>
				<tr>
					<td width=160 height="<?=min(300/$rows,50)?>"></td>
					<td><input type="<?=$mode?>" name="item[]" value=<?=$item_id?>></td>
					<td id="<?=$i-1?>" class=style30b><?=$i?>.<?=$item_title?></td>
					<td width=50></td>
				</tr>
				<?
			}
			?>
			<tr>
				<td align=center colspan=4><input type=hidden name=subject_id value=<?=$subject_id?>><span class=style32b id=msg></span></td>
			</tr>
			</form>
			</table></td>
			<td></td>
		</tr>
		</table>
		<!--********************************************* 可视面积 ***********************************************-->
		</td>
		<td>&nbsp;</td>
		</tr>
		<tr>
			<td height=15></td>
			<td></td>
			<td></td>
		</tr>
		</table>
		</body>
		<script language="JavaScript" type="text/JavaScript">
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
function onfoc(n)
{
	t1=document.getElementById(n);
	t1.style.backgroundColor='#006699';
	t1.style.color="white";
}
function losefoc(n)
{
	t1 = document.getElementById(n);
	t1.style.backgroundColor='';
	t1.style.color="black";
}

var key2=0;
var numChecked=0;
var i=0;
var checked_id='';
function keyDown(e)
{
	var keycode=e.which
	var key1 = keycode -48
	if(keycode==36)
	{
		location ="menu_1.php";
	}
	if(keycode==35)
	{
		msg_span=document.getElementById('msg');
		if(numChecked<1)
		{
			
			msg_span.innerHTML='您还没有做任何选择！';
		//	window.setTimeout('',3000);
		//	msg_span.innerHTML='【确定】键选择，【输入】键提交';
		}
		else
		{
			var f=document.vote;
			for(i=0;i<f.elements.length;i++)
			{
				if(f.elements[i].name.substr(0,4)=='item')
				{
					if(f.elements[i].checked==true)
					{
						checked_id+=f.elements[i].value+'|';
					}
				}
			}
			if(checked_id.length>1)
			{
				checked_id=checked_id.substr(0,checked_id.length-1);
			}
			msg_span.innerHTML='非常感谢您的支持和参与！';
			window.setTimeout('',3000);
			location='vote_submit.php?subject_id=<?=$subject_id?>&checked_id='+checked_id;
		//	document.vote.submit();
		}
	}
	if(keycode==13)
	{
		var e=document.vote.elements[key2];
		if(e.checked==true)
		{
			e.checked=false;
			numChecked--;
		}
		else
		{
			e.checked=true;
			numChecked++;
		}
	}
	if(keycode==38)
	{
		losefoc(key2);
		key2=key2 - 1;
		if(key2<0)
		{
			key2=<?=$i-1?>;
		}
		onfoc(key2)
	}
	if(keycode==40)
	{
		losefoc(key2);
		key2=key2 + 1;
		if(key2><?=$i-1?>) 
		{
			key2=0;
		}
		onfoc(key2);
	}
}
document.onkeydown=keyDown
//-->
</script>
		</html>
		<?
		exit;
	}
}
else
{
//	echo "nothing to vote";
}
?>