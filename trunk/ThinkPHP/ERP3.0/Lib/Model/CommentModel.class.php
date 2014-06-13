<?php
import('RelationModel');
class CommentModel extends RelationModel{
	protected $_link = array(
		'Staff' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'staff',
			'class_name'   => 'Staff',
			'foreign_key'  => 'staff_id',
		),
		'Attachment' => array(
			'mapping_type' => HAS_MANY,
			'class_name'   => 'Attachment',
			'mapping_name' => 'attachment',
			'foreign_key'  => 'model_id',
			'condition'    => "model_name='Comment' and status='1'",
		)
	);
}
?>