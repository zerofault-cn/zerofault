<html>
<head>
<title>���ݹ�����·��ѯ���ֻ���</title>
<meta http-equiv="Content-Type" content="text/html; charset=GBK">
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="form1" action="" method="get">
<input type="hidden" name="action" value="query_line" />
������·��ţ�<input type="text" name="line_name" size="3" value="<?=$_REQUEST['line_name']?>" /><input type="submit" value="��ѯ" />
</form>
<form name="form1" action="" method="get">
<input type="hidden" name="action" value="query_transfer" />
������㣺<input type="text" name="term1" size="8" value="<?=$_REQUEST['term1']?>" /><br />
�����յ㣺<input type="text" name="term2" size="8" value="<?=$_REQUEST['term2']?>" /><input type="submit" value="���˲�ѯ" />
</form>
<?php
$action=$_REQUEST['action'];
if('query_line'==$action)
{
	define('IN_MATCH', true);
	$root_path="./";
	include_once($root_path."config.php");
	include_once($root_path."includes/db.php");

	$line_name=intval(trim($_REQUEST['line_name']));
	if($line_name>0)
	{
		$sql1="select * from ".$line_table." l where l.number='".$line_name."' or l.name='".$line_name."'";
		$result1=$db->sql_query($sql1);
		while($row1=$db->sql_fetchrow($result1))
		{
			$line_arr[$row1['name']]['line_info']=$row1;
			$sql2="select r.direction as dir,s.name as name from ".$site_table." s,".$route_table." r where r.lid=".$row1['id']." and s.id=r.sid order by r.i";
			$result2=$db->sql_query($sql2);
			while($row2=$db->sql_fetchrow($result2))
			{
				$line_arr[$row1['name']]['dir'][$row2['dir']][]=$row2['name'];
			}
		}
		if(sizeof($line_arr)==0)
		{
			echo '����·��δ��ͨ��';
		}
		else
		{
			foreach($line_arr as $line_name=>$line_info)
			{
				echo '��·����:'.$line_name.'<br>';
				echo '���վ:'.getSname($line_info['line_info']['term1']).'('.$line_info['line_info']['start_time1'].'-'.$line_info['line_info']['end_time1'].')<br>';
				echo '�յ�վ:'.getSname($line_info['line_info']['term2']).'('.$line_info['line_info']['start_time2'].'-'.$line_info['line_info']['end_time2'].')<br>';
				echo 'Ʊ��:'.$line_info['line_info']['fare_norm'].' '.$line_info['line_info']['fare_cond'].'<br>';
				echo '��ʹ�ù�����:'.$line_info['line_info']['ic_card'].'<br>';
				foreach($line_info['dir'] as $dir=>$route_arr)
				{
						echo '<span style="color:blue">';
						if($dir==1)
						{
							echo '����';
						}
						else
						{
							echo '����';
						}
						echo '��</span><br />';
						foreach($route_arr as $index=>$name)
					{
				
						echo $name;
						if($index!=(sizeof($route_arr)-1))
						{
							echo '��';
						}
					}
					echo '</br />';
				}
			}
		}
	}
}
if('query_transfer'==$action)
{
	define('IN_MATCH', true);
	$root_path="./";
	include_once($root_path."config.php");
	include_once($root_path."includes/db.php");

	include_once($root_path."trans_search.php");
	$term1=$_REQUEST['term1'];
	$term2=$_REQUEST['term2'];
	$s_sid=getSid($term1);
	$e_sid=getSid($term2);
	$result=findNext($s_sid);
	getResult($result);
}
echo '<br /><br /><br />������Ŀǰ����������Դ�ں��ݹ���������վ(http://www.hzbus.com.cn)�����˽���ѧϰ�����ã���Ȩ����ԭ��վ<br />';
echo '���ݲɼ�����:2008-11-20';
?>
<br />
<a href="http://blog.haozhanwang.com/" target="_blank">�ҵ�BLOG</a>
</body>
</html>