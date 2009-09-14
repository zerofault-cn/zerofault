<?php
import('RelationModel');
class StaffModel extends RelationModel{
	protected $_link = array(
		'Department' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'dept',
			'class_name'   => 'Department',
			'foreign_key'  => 'dept_id',
			),
		'Staff' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'leader',
			'class_name'   => 'Staff',
			'parent_key'  => 'leader_id',
			)
	);
}
?>