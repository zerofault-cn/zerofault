<?php
$menu = array();

$menu['Basic&nbsp;Data'] = array(
	'name'	  => 'Supplier',//默认Action:Module.index
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
		'Fixed Asset Entering'		=> 'ProductIn/fixed',
		'Non-Fixed Asset Entering'  => 'ProductIn/nonfixed',
		'Product Return'		=> 'ProductIn/returns',
		)
	);
$menu['Inventory Inquire'] = array(
	'name' => 'Inventory',
	);

$menu['Inventory&nbsp;output Management'] = array(
	'name'	  => 'ProductOut/apply',
	'submenu' => array(
		'Fixed Asset Apply'		=> 'ProductOut/apply',
		'Non-Fixed Asset Apply'	=> 'ProductOut/apply_nonfixed',
		'Product Transfer'		=> 'ProductOut/transfer',
		'Components Release'	=> 'ProductOut/release',
		'Scrap Product'			=> 'ProductOut/scrap',
		'Product Return'		=> 'ProductOut/back',
		)
	);

$menu['My&nbsp;Assets'] = array(
	'name' 	  => 'Asset',
	'submenu' => array(
		'Asset List'			=> 'Asset',
		'Apply'					=> 'Asset/apply',
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