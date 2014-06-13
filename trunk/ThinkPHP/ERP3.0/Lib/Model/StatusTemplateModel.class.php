<?php
import('RelationModel');
class StatusTemplateModel extends RelationModel{
	protected $_link = array(
		'Staff' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'creator',
			'class_name'   => 'Staff',
			'foreign_key'  => 'creator_id',
			)
	);
}

?>