<?php
import('RelationModel');
class StatusStatusModel extends RelationModel{
	protected $_link = array(
		'StatusItem' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'item',
			'class_name'   => 'StatusItem',
			'foreign_key'  => 'item_id',
		),
		'Staff1' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'owner',
			'class_name'   => 'Staff',
			'foreign_key'  => 'owner_id',
		),
		'Staff2' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'substitute',
			'class_name'   => 'Staff',
			'foreign_key'  => 'substitute_id',
		),
	);
}

?>