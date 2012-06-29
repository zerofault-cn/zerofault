<?php
import('RelationModel');
class CompanyModel extends RelationModel{
	protected $_link = array(
		'User' => BELONGS_TO,
		'Case' => array(
			'mapping_type' => HAS_MANY,
			'mapping_order'=>'sort, id desc'
			),
		'Talk' => array(
			'mapping_type' => HAS_MANY,
			'mapping_order'=>'id desc'
			),
		'Feedback' => HAS_MANY
	);
}
?>