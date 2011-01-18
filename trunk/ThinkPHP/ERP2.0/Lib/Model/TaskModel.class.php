<?php
import('RelationModel');
class TaskModel extends RelationModel{
	protected $_link = array(
		'Creator' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'creator',
			'class_name'   => 'Staff',
			'foreign_key'  => 'creator_id',
			),
//		'Category' => array(
//			'mapping_type' => BELONGS_TO,
//			'mapping_name' => 'category',
//			'class_name'   => 'Category',
//			),
		'Owner' => array(
			'mapping_type' => HAS_MANY,
			'mapping_name' => 'owner',
			'class_name'   => 'TaskOwner',
			),
		'Attachment' => array(
			'mapping_type' => HAS_MANY,
			'class_name'   => 'Attachment',
			'foreign_key'  => 'model_id',
			'mapping_name' => 'attachment',
			'condition'    => "model_name='Task'",
			),
	);
}
?>