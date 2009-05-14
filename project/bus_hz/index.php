<?php
include_once("config.php");
$tpl->set_filenames(array(
			'body' => 'index.htm')
		);
$action=$_REQUEST['action'];
if(empty($action))
{
	$tpl->pparse('body');
	$tpl->destroy();
	exit;
}
if('query_line'==$action)
{
	if(!empty($_REQUEST['id']))
	{
		line_info($_REQUEST['id']);
	}
	else
	{
		$line_name=trim($_REQUEST['line_name']);
		if(!empty($line_name))
		{
			echo $sql1="select * from ".LINE_TABLE." l where l.number='".$line_name."' or l.name='".$line_name."'";
			$result1=$db->sql_query($sql1);
			while($row1=$db->sql_fetchrow($result1))
			{
				$line_list[]=$row1;
			}
			if(count($line_list)==0)
			{
				$result = '��ʱû�д���·����Ϣ<br />';
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
	$tpl->assign_var("RESULT",$result);
	$tpl->pparse('body');
	$tpl->destroy();
}
if('query_site'==$action)
{
	include_once($root_path."site_info.php");
	if(!empty($_REQUEST['id']))
	{
		site_info($_REQUEST['id']);
	}
	elseif(strlen(trim($_REQUEST['site_name']))>0)
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
				echo '��<a href="site_id_'.$site_arr['id'].'.html">'.$site_arr['name'].'</a><br />';
			}
		}
	}
}
if('query_transfer'==$action)
{
	include_once($root_path."trans_search.php");
	$from=$_REQUEST['from'];
	$to=$_REQUEST['to'];
	$from_sid=$_REQUEST['from_sid'];
	$to_sid=$_REQUEST['to_sid'];
	
	if(strlen($from)>0 && strlen($to)>0)
	{
		$sql1="select * from ".$site_table." where binary name like '%".$from."%'";
		$result1=$db->sql_query($sql1);
		while($row1=$db->sql_fetchrow($result1))
		{
			$from_site_list_arr[]=$row1;
		}
		$sql2="select * from ".$site_table." where binary name like '%".$to."%'";
		$result2=$db->sql_query($sql2);
		while($row2=$db->sql_fetchrow($result2))
		{
			$to_site_list_arr[]=$row2;
		}
		if(count($from_site_list_arr)==0 || count($to_site_list_arr)==0)
		{
			echo '��ʱû�о����������յ�Ĺ�����·!';
		}
		elseif(count($from_site_list_arr)==1 && count($to_site_list_arr)==1)
		{
			$from_sid = $from_site_list_arr[0]['id'];
			$to_sid   = $to_site_list_arr[0]['id'];
		}
		else
		{
			echo '<form action="index.php" method="get">';
			echo '<input type="hidden" name="action" value="query_transfer" />';
			echo '����ѯ�������յ��ж�����ܣ���ѡ����׼ȷ��һ����<br />';
			echo '��ѡ����㣺';
			foreach($from_site_list_arr as $key=>$site_arr)
			{
				echo '<input type="radio" name="from_sid" value="'.$site_arr['id'].'" checked="true" />'.$site_arr['name'].'&nbsp;';
			}
			echo '<hr>��ѡ���յ㣺';
			foreach($to_site_list_arr as $key=>$site_arr)
			{
				echo '<input type="radio" name="to_sid" value="'.$site_arr['id'].'" checked="true" />'.$site_arr['name'].'&nbsp;';
			}
			echo '<br /><input type="submit" value="��ʼ��ȷ��ѯ" />';
			echo '</form>';
		}
		
		
	}
	if($from_sid>0 && $to_sid>0)
	{
		getResult($from_sid,$to_sid);
	}
}

?>
