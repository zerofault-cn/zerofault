<?php
import('RelationModel');
class ProductModel extends RelationModel{
	protected $_link = array(
		'Supplier' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'supplier',
			'class_name'   => 'Supplier',
			'foreign_key'  => 'supplier_id'
			),
		'Category' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'category',
			'class_name'   => 'Category',
			'foreign_key'  => 'category_id'
			),
		'Option1' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'currency',
			'class_name'   => 'Options',
			'foreign_key'  => 'currency_id'
			),
		'Option2' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'unit',
			'class_name'   => 'Options',
			'foreign_key'  => 'unit_id'
			),
		'Option3' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'status',
			'class_name'   => 'Options',
			'foreign_key'  => 'status_id'
			)

	);
}

?>