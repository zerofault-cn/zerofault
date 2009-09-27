<?php
$menu = array();

$menu['Basic&nbsp;Data'] = array(
	'name'	  => 'Supplier',//д╛хо╡ывВModule.index
	'submenu' => array(
		'Supplier information'	=> 'Supplier',
		'Department information'=> 'Dept',
		'Staff information'		=> 'Staff',
		'Commodity'	=> 'Commodity',
		'Products Data'		=> 'Product'
		)
	);

$menu['Inventory&nbsp;Input Management'] = array(
	'name'	=> 'ProductIn',
	'submenu' => array(
		'Products entering'	=> 'ProductIn',
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

$menu['Inventory&nbsp;output Management'] = array(
	'name' => 'Outbound',
	'submenu' => array(
		'Product Request'	=> 'Requisition',
		'Return'		=> 'Return'
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