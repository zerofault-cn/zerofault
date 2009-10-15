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
	'name'	=> 'ProductIn',
	'submenu' => array(
		'Products Entering'		=> 'ProductIn',
		'Products Returns'		=> 'ProductIn/returns'
		)
	);
$menu['Storage inventory'] = array(
	'name' => 'Storage',
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