<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title>��ǰĿ¼:<?=$dir?></title>
<link rel="stylesheet" href="../main.css" type="text/css">
</head>
<script language="JavaScript" type="text/javascript">
function bbimg(o)
{
	var zoom=parseInt(o.style.zoom, 10)||100;zoom+=event.wheelDelta/12;
	if (zoom>0) o.style.zoom=zoom+'%';return false;
}
</script>
<body>
<?php
//*****************************************************************
//���ļ����Ϊ�Զ������о�ͼƬ��ÿ��5��
//�Ѿ��޸�ͼƬ�����Ϊ160,ϣ�����Ի���ҳ������ʱ���Ĵ���ϵͳ��Դ
//����Ŀ¼���ļ����������ڽ��!
//*****************************************************************
if(!isset($dir)||$dir=='.')
{
	$dir='.';//��ʼ��Ŀ¼
	echo 'һ���ļ�������еĹ���!�п������ҳ���ʽ�ϵĲ�һ��!<BR><br>';
}

$handle=opendir($dir);
?>
<font size=5>��ǰĿ¼:<span class=blue><?=$dir?></span><br></font>
<button onclick="javascript:window.location='?dir=<?=substr($dir,0,strrpos($dir,'/'))?>'">�ϼ�Ŀ¼</button>
<table border=0 width=770 cellspacing=0 cellpadding=0>
<tr><td align=left>

<ol>
<table border=1 cellspacing=1 cellpadding=1 bordercolor=white wrap=auto>
<?
$i=0;
$table_width=160;
while($file=readdir($handle))
{
	if($dir!='.'&&($i-2)%5==0)
		echo '<tr>';
	if($dir!='.'&&$i!=0&&$i!=1)
		echo '<td width='.$table_width.'>';
	if(is_dir($dir.'/'.$file)&&($file!='.')&&($file!='..')&&$file!='pic_upload'&&$file!='ico'&&$file!='personal'&&$file!='yabbcn_upload')//����ĳЩĿ¼
	{
		$subdir=$dir.'/'.$file;
		static $list_I=1;
		?>
		<li type=I value='<?=$list_I++?>'>
		<form action='<?=$PHP_SELF?>' method=get name=readdir>
		������Ŀ¼:<span class=blue><?=$subdir?></span>
		<input type=hidden name='dir' value='<?=$subdir?>'>
		<INPUT TYPE="submit" value="����">
		</form>
		<?
	}
	elseif(is_file($dir.'/'.$file)&&strrchr($file,'.')!='.php'&&strrchr($file,'.')!='.txt'&&$file!='Thumbs.db'&&$file!='thumbs.db'&&$file!='desktop.ini'&&$file!='Desktop.ini'&&$file!='.'&&$file!='..')//����ĳЩ�ļ�,Ҳ�����ó�ֻ��ʾĳЩ��׺���ļ�
	{
		$filesize=filesize($dir.'/'.$file)/1024;
		$filesize=sprintf ('%.1f', $filesize);
		static $list_1=1;
		$imgsize= GetImageSize($dir.'/'.$file);
		$realsize=$imgsize[0].'��'.$imgsize[1];
		if($imgsize[0]>=$table_width)
			$width=$table_width;
		else
			$width=$imgsize[0];
		$tempdir=str_replace('+',' ',str_replace('%2F','/',urlencode($dir)));//����url����,Ȼ��ת�������ַ�
		$tempfile=str_replace('+',' ',urlencode($file));
		?>
		<table border=0 width='<?=$table_width?>' cellspacing=0 cellpadding=0>
		<tr><td valign=top align=center><span class=blue><?=$list_1++?></span><br><?=$file?></td></tr>
		<tr><td valign=top align=center>
			<?
			if($imgsize[0]>=$table_width)
			{
				?>
				<a href='<?=$tempdir?>/<?=$tempfile?>' target=_blank>
				<img src='<?=$tempdir?>/<?=$tempfile?>' border=0 alt='���´����д�ԭ��СͼƬ' width='<?=$width?>' onmousewheel='return bbimg(this)'></a>
				<?
			}
			else
			{
				?>
				<img src='<?=$tempdir?>/<?=$tempfile?>' border=0 alt='<?=$realsize?>' width='<?=$width?>' onmousewheel='return bbimg(this)'>
				<?
			}
			?>
			</td></tr>
		<tr><td width=<?=$table_width?>>�ļ���С:<?=$filesize?> KB<br>ͼƬ�ߴ�:<?=$realsize?></td></tr>
		</table>
		<?
	}
	if($dir!='.'&&$i!=0&&$i!=1)
		echo '</td>';
	if($dir!='.'&&($i-2)%5==4)
		echo '</tr>';
	$i++;
}
closedir($handle);
?>
</table>
<?
//��������
if($dir=='.')
{
	?>
	<br>
	<button name=upload  style="border:1px solid #000000; font-size:14px; background-color:#EBEADB;" onclick="javascript:window.location='pic_upload/index.php'">�ϴ�ͼƬ</button>&nbsp;&nbsp;
	<button name=upload style="border:1px solid #000000; font-size:14px; background-color:#EBEADB;" onclick="javascript:window.location='pic_upload/index.php'">�鿴�ϴ�ͼƬ</button>
	<br>
	<a href='/phpbbs/utilities/show_source.php'>��ҳԴ����</a><br>
	<?
}
else
{
	?>
	<br>
	<button onclick="javascript:history.go(-1)">����</button>
	<?
}
?>

</td></tr>
</table>
<br>
<button onclick="javascript:window.location='?dir=<?=substr($dir,0,strrpos($dir,'/'))?>'">�ϼ�Ŀ¼</button>
<br>
</body>
</html>
