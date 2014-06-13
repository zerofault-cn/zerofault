<?php
import('RelationModel');
class StatusBoardModel extends RelationModel{
	protected $_link = array(
		'Staff' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'owner',
			'class_name'   => 'Staff',
			'foreign_key'  => 'owner_id',
		),
		'StatusFlow' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'flow',
			'class_name'   => 'StatusFlow',
			'foreign_key'  => 'flow_id',
		)
	);
}

?>