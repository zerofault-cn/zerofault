<?php
define('IN_MATCH', true);

$root_path = "./";

include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/page.php");
include_once($root_path."profile.inc.php");
$id=$_REQUEST['id'];
$action=$_REQUEST['action'];
if('modify'==$action)
{
	$field=$_REQUEST['field'];
	$value=$_REQUEST['value'];
	$sql="update user_info_ext set ".$field."='".$value."' where id=".$id;
	if($db->sql_query($sql))
	{
		echo '<script>parent.location.reload();</script>';
	}
	else
	{
		echo 'sql:'.$sql;
	}
	exit;
}
if('submit'==$action)
{
	$want_age1=$_REQUEST['input_want_age1'];
	$want_age2=$_REQUEST['input_want_age2'];
	$want_age=$want_age1.'-'.$want_age2;
	$want_height1=$_REQUEST['input_want_height1'];
	$want_height2=$_REQUEST['input_want_height2'];
	$want_height=$want_height1.'-'.$want_height2;
	$want_weight1=$_REQUEST['input_want_weight1'];
	$want_weight2=$_REQUEST['input_want_weight2'];
	$want_weight=$want_weight1.'-'.$want_weight2;
	$want_sex=$_REQUEST['want_sex'];
	$want_graduation=$_REQUEST['input_want_graduation'];
	$sql="update user_info_ext set ";
	if($want_age!='-')
	{
		$sql.="want_age='".$want_age."',";
	}
	if($want_height!='-')
	{
		$sql.="want_height='".$want_height."',";
	}
	if($want_weight!='-')
	{
		$sql.="want_weight='".$want_weight."',";
	}
	$sql.="want_sex='".$want_sex."',want_graduation='".$want_graduation."' where id=".$id;
	if($db->sql_query($sql))
	{
		echo '<script>parent.location.reload();</script>';
	}
	else
	{
		echo 'sql:'.$sql;
	}
	exit;
}
include_once "header.php";
include_once "main.php";

$tpl = new Template($root_path."templates");
$tpl->set_filenames(array(
			'body' => 'request.htm'));
$tpl->assign_vars(array(
	"id"=>$id));
if(checkLogin($row1["blogurl"]))
{
	$tpl->assign_vars(array(
		"DISPLAY"=>''));
}
else
{
	$tpl->assign_vars(array(
		"DISPLAY"=>'none'));
}

$sql="select * from user_info_ext where id=".$id;
$result=$db->sql_query($sql);
$row=$db->sql_fetchrow($result);
$want_age_arr=explode('-',$row['want_age']);
$want_height_arr=explode('-',$row['want_height']);
$want_weight_arr=explode('-',$row['want_weight']);
$tpl->assign_vars(array(
	"want_age1"=>$want_age_arr[0],
	"want_age2"=>$want_age_arr[1],
	"want_age"=>(''==$row['want_age']?'未设置':($want_age_arr[0].'岁～'.$want_age_arr[1].'岁')),
	"want_height1"=>$want_height_arr[0],
	"want_height2"=>$want_height_arr[1],
	"want_height"=>(''==$row['want_height']?'未设置':($want_height_arr[0].'cm～'.$want_height_arr[1].'cm')),
	"want_weight1"=>$want_weight_arr[0],
	"want_weight2"=>$want_weight_arr[1],
	"want_weight"=>(''==$row['want_weight']?'未设置':($want_weight_arr[0].'kg～'.$want_weight_arr[1].'kg')),
	"want_sex"=>(''==$row['want_sex']?'未设置':$row['want_sex']),
	"want_sex_str"=>'<input type="radio" name="want_sex" value="男性" '.('男性'==$row['want_sex']?'checked':'').' onclick="t(\'input_want_sex\').value=this.value;"/> 男性&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="want_sex" value="女性" '.('女性'==$row['want_sex']?'checked':'').' onclick="t(\'input_want_sex\').value=this.value;"/> 女性',
	"want_graduation"=>(''==$row['want_graduation']?'未设置':$row['want_graduation']),
	"want_graduation_options"=>generateOptions('want_graduation'),
	));
$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();

require_once "templates/footer.htm";

function generateOptions0($field) 
{
	$field_arr_name=$field.'_arr';
	global ${$field_arr_name},$row;
	$field_option_str='';
	for($i=0;$i<sizeof(${$field_arr_name});$i++)
	{
		$field_option_str.='<option value="'.${$field_arr_name}[$i].'"';
		if(${$field_arr_name}[$i]==$row[$field])
		{
			$field_option_str.=' selected';
		}
		$field_option_str.='>'.${$field_arr_name}[$i].'</option>';
	}
	return $field_option_str;
}
?>