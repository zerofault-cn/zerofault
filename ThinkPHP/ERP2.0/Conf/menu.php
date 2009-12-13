<?php
$menu = array();

$menu['Basic&nbsp;Data'] = array(
	'name'	  => 'Supplier',//Ĭ�ϲ���Module.index
	'submenu' => array(
		'Supplier information'	=> 'Supplier',
		'Department information'=> 'Dept',
		'Staff information'		=> 'Staff',
		'Category'				=> 'Category',
		'Component Data'		=> 'Product',
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
$menu['Storage inventory'] = array(
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
		'Applied'				=> 'Asset/apply',
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