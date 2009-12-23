<?php
import('RelationModel');
class ProductFlowModel extends RelationModel{
	protected $_link = array(
		'Product' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'product',
			'class_name'   => 'Product',
			'foreign_key'  => 'product_id',
			),
		'Supplier' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'supplier',
			'class_name'   => 'Supplier',
			'foreign_key'  => 'supplier_id',
			),
		'Staff' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'staff',
			'class_name'   => 'Staff',
			'foreign_key'  => 'staff_id',
			),
		'Staff2' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'confirmed_staff',
			'class_name'   => 'Staff',
			'foreign_key'  => 'confirmed_staff_id',
			),
		'Options' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'currency',
			'class_name'   => 'Options',
			'foreign_key'  => 'currency_id',
			),
		'Options2' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'unit',
			'class_name'   => 'Options',
			'foreign_key'  => 'unit_id',
			)
	);
}

?>