<?php
$menu = array();

$menu['Basic Data'] = array(
	'name'	  => 'Category',//Ä¬ÈÏ²Ù×÷Module.index
	'submenu' => array(
		'Supplier infroamtion'	=> 'Supplier',
		'Department information'=> 'Dept',
		'Staff information'		=> 'Staff',
		'Commodity'	=> 'Commodity',
		'Products Data'		=> 'Products'
		)
	);

$menu['Inventory Input<br />Management'] = array(
	'name'	=> 'Inbound',
	'submenu' => array(
		'Products entering information'	=> 'Bill',
		'details of inventory'		=> 'Bill',
		'return goods amount'		=> 'Bill'
		)
	);
$menu['Storage inventory'] = array(
	'name' => 'Stock',
	'submenu' => array(
		'Stock List'=>'Stock'
		)
	);

$menu['Inventory output<br />Management'] = array(
	'name' => 'Outbound',
	'submenu' => array(
		'Product Request'	=> 'Requisition',
		'Return'		=> 'Return'
		)
	);

$menu['Purchase<br />management'] = array(
	'name' => 'feedback',
	);

$menu['System'] = array(
	'name' => 'Node',
	'submenu' => array(
		'Node' => 'Node',
		'Role' => 'Role',
		'User' => 'User'
		)
	);

return $menu;
?>