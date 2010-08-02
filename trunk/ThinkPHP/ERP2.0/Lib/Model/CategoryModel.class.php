<?php
import('RelationModel');

class CategoryModel extends RelationModel{

	protected $_link = array(
		'Staff' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'manager',
			'class_name'   => 'Staff',
			'foreign_key'  => 'manager_id'
			)
	);
}

?>