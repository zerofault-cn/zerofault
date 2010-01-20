<?php
import('RelationModel');

class LocationModel extends RelationModel{

	protected $_link = array(
		'Staff' => array(
			'mapping_type' => MANY_TO_MANY,
			'class_name' => 'Staff',
			'mapping_name' => 'fixed_manager',
			'mapping_limit' => 0,
			'mapping_order' => '',
			'relation_foreign_key' => 'staff_id',
			'relation_table' => 'erp_location_manager',
			'condition' => 'a.fixed = 1'
			),
		'Staff2' => array(
			'mapping_type' => MANY_TO_MANY,
			'class_name' => 'Staff',
			'mapping_name' => 'floating_manager',
			'mapping_limit' => 0,
			'mapping_order' => '',
			'relation_foreign_key' => 'staff_id',
			'relation_table' => 'erp_location_manager',
			'condition' => 'a.fixed = 0'
			)
	);
}

?>