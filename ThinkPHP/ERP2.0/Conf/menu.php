<?php
$menu = array();

$menu['Basic Data'] = array(
	'name'	  => 'Supplier',//Ĭ�ϲ���Module.index
	'submenu' => array(
		'Supplier information'	=> 'Supplier',
		'Department information'=> 'Dept',
		'Staff information'		=> 'Staff',
		'Commodity'	=> 'Commodity',
		'Products Data'		=> 'Product'
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