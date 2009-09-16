<?php
import('RelationModel');
class SupplierModel extends RelationModel{
	protected $_link = array(
		'Options' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'character',
			'class_name'   => 'Options',
			'foreign_key'  => 'character_id',
			),
		'Options2' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'currency',
			'class_name'   => 'Options',
			'foreign_key'  => 'currency_id',
			)
	);
}

?>