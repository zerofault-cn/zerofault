<?php
/*********************************************/
//������ҳ����ʴ�����س���
//���������ݿ��в�����Ҫ���ӵ�ҳ���url,Ȼ����ÿ�����־�ļ��в��Һ��д�url����,��������Ӧ����ͳ��,��ͳ�ƽ��д�����ݿ�
//ҳ��ǰ����ʾʱ����ͨ����ѯ���ݿ�ֱ��ȡ�ô�ҳ��ķ�����(������������,����,���µ�ʱ������ͳ��)
/*********************************************/
function indexOf($haystack,$needle,$offset=0)
{ 
	//Ѱ���ַ���haystack��needle���ȳ��ֵ�λ�� 
	//�÷���strpos��ͬ��myStrPos(string haystack��string needle��int [offset]); 
	$lenSource=strlen($haystack); 
	$lenKey=strlen($needle); 
	$find=0; 
	for($i=$offset;$i<($lenSource-$lenKey+1);$i++) 
	{
		if(substr($haystack,$i,$lenKey)==$needle)
		{ 
			$find=1;//�ҵ��˳�ѭ�� 
			break; 
		} 
	}
	if($find)
		return $i; //�ҵ��򷵻صڼ���λ�� ,0Ϊ�������
	else 
		return 0;//û�ҵ��ͷ���0 
}
if(!isset($dir)||$dir=='')
{
	$dir='daily';
}
$log_dir='../logs/'.$dir;
$handle=opendir($log_dir);
$show=1;//ֱ����ʾ
$insert=0;//�������ݿ�
$extend=' where del_flag=1';
if(isset($id)&&$id!='')
{
	$extend=' where id='.$id;
}
include_once "../include/mysql_connect.php";
$sql1="select * from server_stat_path ".$extend;
while($log_files=readdir($handle))
{
	$log_file=$log_dir.'/'.$log_files;
	if(is_file($log_file)&&($log_files!=".")&&($log_files!=".."))
	{
		$time=date("Y-m-d H:i:s",substr($log_file,-10));
		if($show)
		{
			?>
			<table width="100%" border=0 cellspacing=1 cellpadding=0 bgcolor=black>
			<caption align=top>
			<?
			if($dir=='daily')
			{
				if(isset($id)&&$id!='')
				{
					$url_ext='&id='.$id;
				}
				?>
				<a href='index.php?content=server_stat&dir=<?=date("Ymd",substr($log_file,-10)).$url_ext?>'><?=$time?></a>
				<?
			}
			else
			{
				echo $time;
			}
			?></caption>
			<tr bgcolor=white><td>ͳ����Ŀ��</td><td align=center>��Ӧ·��</td><td>���ʴ���</td></tr>
			<?
		}
		$result1=mysql_query($sql1);
		while($r=mysql_fetch_array($result1))
		{
			$i=0;
		//	$id=$r["id"];
			$name=$r["name"];
			$path=$r["path"];
			if(strpos($path,'?'))
			{
				$tmp_path=substr($path,0,strpos($path,'?'));
			}
			else
			{
				$tmp_path=$path;
			}
			$fp=fopen($log_file,"r");
			while($log_line=fgets($fp,4096))
			{
				if((substr($log_line,0,3)==200) && (indexOf($log_line,$path)!=0))
				{
					$i++;
				}
			}
			if($bgcolor!='#d0d0d0')
			{
				$bgcolor='#d0d0d0';
			}
			else
			{
				$bgcolor='#f0f0f0';
			}
			if($show)
			{
				?>
				<tr bgcolor=<?=$bgcolor?>><td><?=$name?></td><td><a title='<?=urldecode($path)?>'><?=$tmp_path?></a></td><td><?=$i?></td></tr>
				<?
			}
			if($insert)
			{
				echo $sql2="insert into server_stat_count(path_id,time,count) values('".$r["id"]."','".$time."','".$i."')";
				echo '<br>';
				mysql_query($sql2);
			}
		}
		if($show)
		{
			echo '</table>';
		}
	}
}

?>
