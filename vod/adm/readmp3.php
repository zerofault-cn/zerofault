<html>
<head>
<meta HTTP-EQUIV="content-type" content="text/html;charset=gb2312">
<title>��ǰĿ¼:<?=$dir?></title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<?php
//*****************************************************************
//���ļ����Ϊ��ĳ��Ŀ¼��(������Ŀ¼)������mp3�Զ��г��Թ�����
//*****************************************************************
if(!isset($dir)||$dir=='.')
{
	$dir='/dpfs/bod/server15_3/mp3';//��ʼ��Ŀ¼
}
$handle=opendir($dir);
?>
<font size=5>��ǰĿ¼:<span class=blue><?=$dir?></span><br></font>
<?
if(strlen($dir)>24)
{
	?>
	<button onclick="javascript:window.location='?dir=<?=substr($dir,0,strrpos($dir,'/'))?>'">�ϼ�Ŀ¼</button>
	<?
}
?>
<table border=0 width=760 cellspacing=0 cellpadding=0>
<tr><td align=left>

<ol>
<?
$i=0;
while($file=readdir($handle))
{
	if(is_dir($dir.'/'.$file)&&($file!='.')&&($file!='..'))
	{
		$subdir=$dir.'/'.$file;
		static $list_I=1;
		?>
		<li type=1 value='<?=$list_I++?>'>
		<form action='<?=$PHP_SELF?>' method=get name=readdir>
		������Ŀ¼:<span class=blue><?=$subdir?></span>
		<input type=hidden name='dir' value='<?=$subdir?>'>
		<INPUT TYPE="submit" value="����">
		</form>
		<?
	}
	elseif(is_file($dir.'/'.$file))//����ĳЩ�ļ�,Ҳ�����ó�ֻ��ʾĳЩ��׺���ļ�
	{
		$filesize=filesize($dir.'/'.$file)/1024;
		$filesize=sprintf ('%.1f', $filesize);
		static $list_1=1;
		$tempdir=str_replace('+',' ',str_replace('%2F','/',urlencode($dir)));//����url����,Ȼ��ת�������ַ�
		$tempfile=str_replace('+',' ',urlencode($file));
//��ý�巽ʽ
		$play_path1='rtsp://'.$_SERVER["SERVER_ADDR"].':555'.str_replace('/dpfs/','/',$tempdir).'/'.$tempfile;
//http��ʽ
		$play_path2='http://'.$_SERVER["HTTP_HOST"].str_replace('/dpfs/','/',$tempdir).'/'.$tempfile;
		$play_list1[]=$play_path1;
		$play_list2[]=$play_path2;
		?>
		<span class=blue><?=$list_1++?>:</span><?=$file?>(<?=$filesize?> KB[<a href="<?=$play_path1?>">rtsp</a>/<a href="<?=$play_path2?>">http]</a><br>
		<?
		
	}
}
closedir($handle);
?>
<?
//��������
if($dir!='.')
{
	?>
	<br>
	<button onclick="javascript:history.go(-1)">����</button>
	<?
}
if(sizeof($play_list1)>0)
{
	$str_play_list1=implode('|',$play_list1);
	?>
	<button onclick="javascript:window.location='playmp3.php?str_play_list=<?=$str_play_list1?>'">RTSP��ʽ�������ű�ҳ����</button>
	<?
}
if(sizeof($play_list2)>0)
{
	$str_play_list2=implode('|',$play_list2);
	?>
	<button onclick="javascript:window.location='playmp3.php?str_play_list=<?=$str_play_list2?>'">HTTP��ʽ�������ű�ҳ����</button>
	<?
}
?>
</td></tr>
</table>
<br>
<?
if(strlen($dir)>24)
{
	?>
	<button onclick="javascript:window.location='?dir=<?=substr($dir,0,strrpos($dir,'/'))?>'">�ϼ�Ŀ¼</button>
	<?
}
?>
</body>
</html>
