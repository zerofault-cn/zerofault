<?php
$menu = array();

$menu['Basic&nbsp;Data'] = array(
	'name'	  => 'Supplier',//Ĭ�ϲ���Module.index
	'submenu' => array(
		'Supplier information'	=> 'Supplier',
		'Department information'=> 'Dept',
		'Staff information'		=> 'Staff',
		'Category'				=> 'Category',
		'Component and Fixed assets'=> 'Product',
		'Board Data'			=> 'Board',
		)
	);

$menu['Inventory&nbsp;Input Management'] = array(
	'name'	  => 'ProductIn',
	'submenu' => array(
		'Product Entering'		=> 'ProductIn',
		'Product Return'		=> 'ProductIn/returns',
		)
	);
$menu['Inventory Inquire'] = array(
	'name' => 'Inventory',
	);

$menu['Inventory&nbsp;output Management'] = array(
	'name'	  => 'ProductOut/apply',
	'submenu' => array(
		'Product Apply'			=> 'ProductOut/apply',
		'Product Transfer'		=> 'ProductOut/transfer',
		'Components Release'	=> 'ProductOut/release',
		'Scrap Product'			=> 'ProductOut/scrap',
		'Product Return'		=> 'ProductOut/back',
		)
	);

$menu['My&nbsp;Assets'] = array(
	'name' 	  => 'Asset',
	'submenu' => array(
		'Apply'				=> 'Asset',
		'Transfer In'			=> 'Asset/transferIn',
		'Transfer Out'			=> 'Asset/transferOut',
		)
	);

$menu['System'] = array(
	'name' => 'Setting',
	'submenu' => array(
		'Location'				=> 'Location',
		'Setting'				=> 'Setting',
		'Role'					=> 'Role',
		'Node'					=> 'Node',
		)
	);

return array('menu'=>$menu);
?>