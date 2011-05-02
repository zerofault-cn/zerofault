<?php
$menu = array();

$menu['Basic&nbsp;Data'] = array(
	'name'    => 'Supplier',//默认Action:Module.index
	'submenu' => array(
		'Supplier information'	=> 'Supplier',
		'Department information'=> 'Dept',
		'Staff information'		=> 'Staff',
		'Category'				=> 'Category',
		'Component Data'		=> 'Product',
		'Board and Fixed-Assets'=> 'Board'
		)
	);

$menu['Inventory&nbsp;Input Management'] = array(
	'name'    => 'ProductIn',
	'submenu' => array(
		'Fixed-Assets Enter'	=> 'ProductIn/fixed',
		'Floating-Assets Enter' => 'ProductIn/floating',
		'Product Reject'		=> 'ProductIn/reject'
		)
	);
$menu['Inventory Inquire'] = array(
	'name'    => 'Inventory',
	'submenu' => array(
		'Local Inventory'		=> 'Inventory/index'
		)
	);

$menu['Inventory&nbsp;Output Management'] = array(
	'name'    => 'ProductOut/apply',
	'submenu' => array(
		'Fixed-Asset Apply'		=> 'ProductOut/applyFixed',
		'Floating-Asset Apply'	=> 'ProductOut/applyFloating',
		'Product Transfer'		=> 'ProductOut/transfer',
		'Components Release'	=> 'ProductOut/release',
		'Product Scrap'			=> 'ProductOut/scrap',
		'Product Return'		=> 'ProductOut/returns'
		)
	);

$menu['Assets Management'] = array(
	'name'    => 'Asset',
	'submenu' => array(
		'My Asset List'			=> 'Asset',
		'My Apply'				=> 'Asset/apply',
		'Transfer To Me'		=> 'Asset/transferIn',
		'My Transfer Out'		=> 'Asset/transferOut',
		'My Returns'			=> 'Asset/returns'
		)
	);

$menu['Absence'] = array(
	'name'    => 'Absence',
	'submenu' => array(
		'Apply Leave'			=> 'Absence',
		'Today Absence'			=> 'Absence/today',
		'My Absence'			=> 'Absence/history',
		'Team Absence'			=> 'Absence/manage'
		)
	);

$menu['Test Log'] = array(
	'name'    => 'Test',
	);

$menu['Tasks'] = array(
	'name' => 'Task',
	'submenu' => array(
		'My Tasks'				=> 'Task',
		'All Tasks'				=> 'Task/all',
		)
	);
$menu['System'] = array(
	'name'    => 'Setting',
	'submenu' => array(
		'Location'				=> 'Location',
		'Mail Template'			=> 'Template',
		'Options Setting'		=> 'Setting',
		'Leave Type'			=> 'Leave',
		'Role'					=> 'Role',
		'Node'					=> 'Node',
		'Operation Logs'		=> 'ProductFlow'
		)
	);

return array('menu'=>$menu);
?>