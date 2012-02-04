<?php
import('RelationModel');
class StatusItemModel extends RelationModel{
	protected $_link = array(
		'Staff' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'owner',
			'class_name'   => 'Staff',
			'foreign_key'  => 'owner_id',
			)
	);
}

?>