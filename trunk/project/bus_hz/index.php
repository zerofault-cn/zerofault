<?php
include_once("config.php");
include_once("function.php");

$tpl->set_filenames(array(
			'body' => 'index.htm')
		);
$action=$_REQUEST['action'];
$curl_search = $_REQUEST['curl_search'];
if(empty($action))
{
	$tpl->pparse('body');
	$tpl->destroy();
	exit;
}
if($curl_search)
{
	curl_search($action);
}
elseif('query_line'==$action)
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
			$sql1="select * from ".LINE_TABLE." l where l.number='".$line_name."' or l.name='".$line_name."'";
			$result1=$db->sql_query($sql1);
			while($row1=$db->sql_fetchrow($result1))
			{
				$line_list[]=$row1;
			}
			if(count($line_list)==0)
			{
				$html = '暂时没有此线路的信息<br />';
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
elseif('query_site'==$action)
{
	$site_name = trim($_REQUEST['site_name']);
	if(!empty($_REQUEST['id']))
	{
		site_info($_REQUEST['id']);
	}
	elseif(strlen($site_name)>0)
	{
		$sql="select * from ".SITE_TABLE." where binary name like '%".$site_name."%'";
		$result=$db->sql_query($sql);
		while($row=$db->sql_fetchrow($result))
		{
			$site_list_arr[]=$row;
		}
	//	checkvar($site_list_arr);
		if(count($site_list_arr)==0)
		{
			$html .= '暂时没有经过此处的公交线路!';
		}
		else if(count($site_list_arr)==1)
		{
			site_info($site_list_arr[0]['id']);
		}
		else
		{
			$html .= '您查询的关键字有多个可能，请选择最接近的一个：<br />';
			foreach($site_list_arr as $key=>$site_arr)
			{
				$html .= sprintf("%2d",$key+1);
				$html .= '：<a href="?action=query_site&id='.$site_arr['id'].'">'.$site_arr['name'].'</a><br />';
			}
		}
	}
}
elseif('query_transfer'==$action)
{
	$from=$_REQUEST['from'];
	$to=$_REQUEST['to'];
	$from_sid=$_REQUEST['from_sid'];
	$to_sid=$_REQUEST['to_sid'];
	
	if(strlen($from)>0 && strlen($to)>0)
	{
		$sql1="select * from ".SITE_TABLE." where binary name like '%".$from."%'";
		$result1=$db->sql_query($sql1);
		while($row1=$db->sql_fetchrow($result1))
		{
			$from_site_list_arr[]=$row1;
		}
		$sql2="select * from ".SITE_TABLE." where binary name like '%".$to."%'";
		$result2=$db->sql_query($sql2);
		while($row2=$db->sql_fetchrow($result2))
		{
			$to_site_list_arr[]=$row2;
		}
		if(count($from_site_list_arr)==0 || count($to_site_list_arr)==0)
		{
			$html .= '暂时没有经过此起点或终点的公交线路!';
		}
		elseif(count($from_site_list_arr)==1 && count($to_site_list_arr)==1)
		{
			$from_sid = $from_site_list_arr[0]['id'];
			$to_sid   = $to_site_list_arr[0]['id'];
		}
		else
		{
			$html .= '<form method="get">';
			$html .= '<input type="hidden" name="action" value="query_transfer" />';
			$html .= '您查询的起点或终点有多个可能，请选择最准确的一个：<br />';
			$html .= '请选择起点：';
			foreach($from_site_list_arr as $key=>$site_arr)
			{
				$html .= '<input type="radio" name="from_sid" value="'.$site_arr['id'].'" checked="true" />'.$site_arr['name'].'&nbsp;';
			}
			$html .= '<hr>请选择终点：';
			foreach($to_site_list_arr as $key=>$site_arr)
			{
				$html .= '<input type="radio" name="to_sid" value="'.$site_arr['id'].'" checked="true" />'.$site_arr['name'].'&nbsp;';
			}
			$html .= '<br /><input type="submit" value="开始精确查询" />';
			$html .= '</form>';
		}
	}
	if($from_sid>0 && $to_sid>0)
	{
		getResult($from_sid,$to_sid);
	}
}
$tpl->assign_var("LINE_NAME",$line_name);
$tpl->assign_var("SITE_NAME",$site_name);
$tpl->assign_var("FROM",$from);
$tpl->assign_var("TO",$to);
$tpl->assign_var("HTML",$html);
$tpl->pparse('body');
$tpl->destroy();

?>
