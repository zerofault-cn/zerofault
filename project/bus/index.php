<html>
<head>
<title>���ݹ�����·��ѯ���ֻ���</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<meta name="description" content="���ݹ���������·��ѯ���뺼�ݹ���������վ����ͬ��" />
<meta name="keywords" content="���� ������ ��· ���� ��ѯ �ֻ�����" />
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="form1" action="" method="get">
<input type="hidden" name="action" value="query_line" />
������·��ţ�<input type="text" name="line_name" size="3" value="<?=$_REQUEST['line_name']?>" /><input type="submit" value="��ѯ��·��Ϣ" />
</form>
<form name="form1" action="" method="get">
<input type="hidden" name="action" value="query_site" />
����վ�����ƣ�<input type="text" name="site_name" size="6" value="<?=$_REQUEST['site_name']?>" /><input type="submit" value="��ѯ������·" />
</form>
<form name="form1" action="" method="get">
<input type="hidden" name="action" value="query_transfer" />
������㣺<input type="text" name="from" size="8" value="<?=$_REQUEST['from']?>" /><br />
�����յ㣺<input type="text" name="to" size="8" value="<?=$_REQUEST['to']?>" /><input type="submit" value="���˲�ѯ" />
</form>
<?php
$action=$_REQUEST['action'];
if(!empty($action))
{
	define('IN_MATCH', true);
	$root_path="./";
	include_once($root_path."config.php");
	include_once($root_path."includes/db.php");
}
if('query_line'==$action)
{
	include_once($root_path."line_info.php");
	if(!empty($_REQUEST['id']))
	{
		line_info($_REQUEST['id']);
	}
	else
	{
		$line_name=trim($_REQUEST['line_name']);
		if(!empty($line_name)>0)
		{
			$sql1="select * from ".$line_table." l where l.number='".$line_name."' or l.name='".$line_name."'";
			$result1=$db->sql_query($sql1);
			while($row1=$db->sql_fetchrow($result1))
			{
				$line_list[]=$row1;
			}
			if(count($line_list)==0)
			{
				echo '��ʱû�д���·����Ϣ<br />';
			}
			else
			{
				foreach($line_list as $key=>$line_arr)
				{
					line_info($line_arr['id']);
				}
			}
		}
	}
}
if('query_site'==$action)
{
	include_once($root_path."site_info.php");
	if(!empty($_REQUEST['id']))
	{
		site_info($_REQUEST['id']);
	}
	else
	{
		$sql="select * from ".$site_table." where binary name like '%".$_REQUEST['site_name']."%'";
		$result=$db->sql_query($sql);
		while($row=$db->sql_fetchrow($result))
		{
			$site_list_arr[]=$row;
		}
	//	checkvar($site_list_arr);
		if(count($site_list_arr)==0)
		{
			echo '��ʱû�о����˴��Ĺ�����·!';
		}
		else if(count($site_list_arr)==1)
		{
			site_info($site_list_arr[0]['id']);
		}
		else
		{
			echo '����ѯ�Ĺؼ����ж�����ܣ���ѡ����ӽ���һ����<br />';
			foreach($site_list_arr as $key=>$site_arr)
			{
				printf("%2d",$key+1);
				echo '��<a href="?action=query_site&site_name='.$_REQUEST['site_name'].'&id='.$site_arr['id'].'">'.$site_arr['name'].'</a><br />';
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
echo '<br /><br /><br />������Դ�ں��ݹ���������վ(http://www.hzbus.com.cn)�����ݲɼ�����:2008-11-20';
?>
<br />
<a href="http://blog.haozhanwang.com/" target="_blank">�ҵ�BLOG</a>
</body>
</html>