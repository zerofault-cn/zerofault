<?php
define('IN_MATCH', true);

$root_path = "./";

include_once($root_path."config.php");
include_once($root_path."functions.php");
include_once($root_path."includes/db.php");
include_once($root_path."includes/template.php");
include_once($root_path."includes/page.php");
include_once($root_path."profile.inc.php");
$action=$_REQUEST['action'];
if('modify'==$action)
{
	$id=$_REQUEST['id'];
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
	$id=$_REQUEST['id'];
	$nickname=$_REQUEST['input_nickname'];
	$realname=$_REQUEST['input_realname'];
	$height=intval($_REQUEST['input_height']);
	$weight=intval($_REQUEST['input_weight']);
	$year=$_REQUEST['input_year'];
	$month=$_REQUEST['input_month'];
	$day=$_REQUEST['input_day'];
	$birthday=$year.'-'.$month.'-'.$day;
	$astro=$_REQUEST['input_astro'];
	$bloodtype=$_REQUEST['input_bloodtype'];
	$graduation=$_REQUEST['input_graduation'];
	$school=$_REQUEST['input_school'];
	$vocation=$_REQUEST['input_vocation'];
	$income=$_REQUEST['input_income'];
	$smoke=$_REQUEST['input_smoke'];
	$drink=$_REQUEST['input_drink'];
	$marry=$_REQUEST['input_marry'];
	$location1=$_REQUEST['input_location1'];
	$location2=$_REQUEST['input_location2'];
	if('ÇëÑ¡Ôñ'==$location2)
	{
		$location2='';
	}
	$location=$location1.'-'.$location2;
	$intro=format($_REQUEST['input_intro']);
	$motto=format($_REQUEST['input_motto']);
	$characters=implode(',',$_REQUEST['input_characters']);
	$interest=implode(',',$_REQUEST['input_interest']);
	$movie=implode(',',$_REQUEST['input_movie']);
	$music=implode(',',$_REQUEST['input_music']);
	$book=implode(',',$_REQUEST['input_book']);
	$sql="update user_info_ext set nickname='".$nickname."',realname='".$realname."',height=".$height.",weight=".$weight.",birthday='".$birthday."',astro='".$astro."',bloodtype='".$bloodtype."',graduation='".$guaduation."',school='".$school."',vocation='".$vocation."',income='".$income."',smoke='".$smoke."',drink='".$drink."',marry='".$marry."',location='".$location."',intro='".$intro."',motto='".$motto."',characters='".$characters."',interest='".$interest."',movie='".$movie."',music='".$music."',book='".$book."' where id=".$id;
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
$id=$_REQUEST['id'];
include_once "header.php";
include_once "main.php";

$tpl = new Template($root_path."templates");
$tpl->set_filenames(array(
			'body' => 'info.htm'));

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

$sql2="select * from user_info_ext where id=".$id;
$result2=$db->sql_query($sql2);
$row2=$db->sql_fetchrow($result2);
while(list($key,$val)=each($row2))
{
	if(''==$val || '0'==$val || '0000-00-00'==$val)
	{
		$row2[$key]='Î´ÌîÐ´';
	}
	if($key=='sex')
	{
		$row2[$key]=$sex_arr[$row2[$key]];
	}
	if($key=='location')
	{
		$row2[$key]=str_replace('-','',$row2[$key]);
	}
}
$tpl->assign_vars($row2);
$year_option_str='<option value="0000">----</option>';
$month_option_str='<option value="00">--</option>';
$day_option_str='<option value="00">--</option>';

for($i=date("Y")-50;$i<=date("Y")-18;$i++)
{
	$year_option_str.='<option value="'.$i.'"';
	if($i==substr($row2['birthday'],0,4))
	{
		$year_option_str.=' selected';
	}
	$year_option_str.='>'.$i.'</option>';
}
for($i=1;$i<=12;$i++)
{
	$month_option_str.='<option value="'.sprintf("%02d",$i).'"';
	if($i==substr($row2['birthday'],5,2))
	{
		$month_option_str.=' selected';
	}
	$month_option_str.='>'.sprintf("%02d",$i).'</option>';
}
for($i=1;$i<=31;$i++)
{
	$day_option_str.='<option value="'.sprintf("%02d",$i).'"';
	if($i==substr($row2['birthday'],8,2))
	{
		$day_option_str.=' selected';
	}
	$day_option_str.='>'.sprintf("%02d",$i).'</option>';
}


$tpl->assign_vars(array(
	"year_options"=>$year_option_str,
	"month_options"=>$month_option_str,
	"day_options"=>$day_option_str,
	"astro_options"=>generateOptions('astro'),
	"bloodtype_options"=>generateOptions('bloodtype'),
	"graduation_options"=>generateOptions('graduation'),
	"vocation_options"=>generateOptions('vocation'),
	"income_options"=>generateOptions('income'),
	"smoke_options"=>generateOptions('smoke'),
	"drink_options"=>generateOptions('drink'),
	"marry_options"=>generateOptions('marry'),
	"location1_options"=>generateOptions('location1'),
	"location2_options"=>(''!=$row2['location'])?'<option value="">'.substr($row2['location'],strpos($row2['location'],'-')+1).'</option>':'',
	"characters_checkbox"=>generateCheckbox('characters'),
	"interest_checkbox"=>generateCheckbox('interest'),
	"movie_checkbox"=>generateCheckbox('movie'),
	"music_checkbox"=>generateCheckbox('music'),
	"book_checkbox"=>generateCheckbox('book')
	));
$db->sql_close();
$tpl->pparse('body');
$tpl->destroy();

require_once "templates/footer.htm";
?>