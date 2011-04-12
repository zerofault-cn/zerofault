<?php
import('RelationModel');
class TaskParticipantModel extends RelationModel{
	protected $_link = array(
		'Staff' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'staff',
			'class_name'   => 'Staff',
			)
	);
}

?>