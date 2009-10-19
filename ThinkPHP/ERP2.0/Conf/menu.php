<?php
$menu = array();

$menu['Basic&nbsp;Data'] = array(
	'name'	  => 'Supplier',//д╛хо╡ывВModule.index
	'submenu' => array(
		'Supplier information'	=> 'Supplier',
		'Department information'=> 'Dept',
		'Staff information'		=> 'Staff',
		'Commodity'				=> 'Commodity',
		'Products Data'			=> 'Product'
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

$menu['Purchase management'] = array(
	'name' => 'Feedback',
	);

$menu['System'] = array(
	'name' => 'Node',
	'submenu' => array(
		'Node' => 'Node',
		'Role' => 'Role',
		)
	);

return $menu;
?>