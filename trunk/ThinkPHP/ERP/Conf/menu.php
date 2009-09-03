<?php
$menu = array();

$menu['Profile'] = array(
	'name'	  => 'Category',//д╛хо╡ывВModule.index
	'submenu' => array(
		'Supplier Profile'	=> 'Supplier',
		'Department Profile'=> 'Dept',
		'Staff Profile'		=> 'Staff',
		'Goods Category'	=> 'Category',
		'Goods Profile'		=> 'Goods'
		)
	);

$menu['Inbound'] = array(
	'name'	=> 'Inbound',
	'submenu' => array(
		'Inbound Bill'	=> 'Bill',
		'Back Bill'		=> 'Bill'
		)
	);

$menu['Outbound'] = array(
	'name' => 'Outbound',
	'submenu' => array(
		'Requisition'	=> 'Requisition',
		'Return'		=> 'Return'
		)
	);

$menu['Stock'] = array(
	'name' => 'Stock',
	'submenu' => array(
		'Stock List'=>'Stock'
		)
	);

$menu['Rbac'] = array(
	'name' => 'Node',
	'submenu' => array(
		'Node' => 'Node',
		'Role' => 'Role',
		'User' => 'User'
		)
	);

return $menu;
?>