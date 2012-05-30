<?php
import('RelationModel');
class CaseModel extends RelationModel{
	protected $_link = array(
		'Attachment' => array(
			'mapping_type' => HAS_MANY,
			'foreign_key'  => 'model_id',
			'condition'    => "model_name='Case'",
			)
	);
}
?>