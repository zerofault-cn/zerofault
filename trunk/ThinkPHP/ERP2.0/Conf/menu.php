<?php
$menu = array();

$menu['Basic&nbsp;Data'] = array(
	'name'	  => 'Supplier',//д╛хо╡ывВModule.index
	'submenu' => array(
		'Supplier information'	=> 'Supplier',
		'Department information'=> 'Dept',
		'Staff information'		=> 'Staff',
		'Category'				=> 'Category',
		'Component Data'		=> 'Product'
		)
	);

$menu['Inventory&nbsp;Input Management'] = array(
	'name'	  => 'ProductIn',
	'submenu' => array(
		'Product Entering'		=> 'ProductIn',
		'Product Return'		=> 'ProductIn/returns'
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
		'Sending Components'	=> 'ProductOut/send',
		'Scrap Product'			=> 'ProductOut/scrap',
		'Product Return'		=> 'ProductOut/returns'
		)
	);

$menu['My&nbsp;Inbox'] = array(
	'name' => 'Feedback',
	);

$menu['System'] = array(
	'name' => 'Setting',
	'submenu' => array(
		'Setting' => 'Setting',
		'Role' => 'Role',
		'Node' => 'Node',
		)
	);

return array('menu'=>$menu);
?>