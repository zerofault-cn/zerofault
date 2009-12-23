<?php
import('RelationModel');
class DepartmentModel extends RelationModel{
	protected $_link = array(
		'Staff' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'leader',
			'class_name'   => 'Staff',
			'foreign_key'  => 'leader_id',
			)
	);
}

?>