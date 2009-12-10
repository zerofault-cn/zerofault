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
		'Apply Product'			=> 'ProductOut/apply',
		'Product Transfer'		=> 'ProductOut/transfer',
		'Components Release'	=> 'ProductOut/release',
		'Scrap Product'			=> 'ProductOut/scrap',
		'Product Return'		=> 'ProductOut/returns',
		)
	);

$menu['Assets'] = array(
	'name' 	  => 'Asset',
	'submenu' => array(
		'My Assets'				=> 'Asset',
		'Apply Assets'			=> 'Asset/apply',
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