<?php
import('RelationModel');
class CompanyModel extends RelationModel{
	protected $_link = array(
		'User' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'user',
			'foreign_key'  => 'user_id',
			)
	);
}
?>