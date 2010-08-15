<?php
import('RelationModel');
class AbsenceModel extends RelationModel{
	protected $_link = array(
		'Staff1' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'staff',
			'class_name'   => 'Staff',
			'parent_key'  => 'staff_id',
			),
		'Staff2' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'creator',
			'class_name'   => 'Staff',
			'parent_key'  => 'creator_id',
			),
		'Staff3' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'deputy',
			'class_name'   => 'Staff',
			'parent_key'  => 'deputy_id',
			),
		'Staff4' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'approver',
			'class_name'   => 'Staff',
			'parent_key'  => 'approver_id',
			)

	);
}
?>