<?php
$oAdmin_User=new Admin_User();
$arr=$oAdmin_User->Browse("order by ID");

for($i=0;$i<count($arr['ID']);$i++)
{
	$User_List[] = array(
		'ID'		=> $arr['ID'][$i],
		'Type'		=> $arr['Type'][$i],
		'Role'		=> $arr['Role'][$i],
		'Username'	=> $arr['Username'][$i],
		'Name'		=> $arr['Name'][$i],
		'EMail'		=> $arr['EMail'][$i],
		'Memo'		=> $arr['Memo'][$i],
		'LastLoginTime'=> $arr['LastLoginTime'][$i],
		'LastLoginIP'=> $arr['LastLoginIP'][$i],
	);
}
$smarty->assign('User_List', $User_List);
?>