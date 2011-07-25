<?php
import('RelationModel');
class ShareModel extends RelationModel{
	protected $_link = array(
		'Staff' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'staff',
			'class_name'   => 'Staff',
			'foreign_key'  => 'staff_id',
			),
		'Dept' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'dept',
			'class_name'   => 'Department',
			'foreign_key'  => 'dept_id',
			),
		'Category' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'category',
			'class_name'   => 'Category',
			),
		'Project' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'project',
			'class_name'   => 'Category',
			'foreign_key'  => 'project_id',
			),
	);
}
?>