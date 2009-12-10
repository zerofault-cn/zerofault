<?php
import('RelationModel');
class LocationProductModel extends RelationModel{
	protected $_link = array(
		
		'Product' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'product',
			'class_name'   => 'Product',
			'foreign_key'  => 'product_id',
			),
		
	);
}

?>