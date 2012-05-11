<?php
import('RelationModel');
class UserModel extends RelationModel{
	protected $_link = array(
		'Company' => array(
			'mapping_type' => HAS_ONE,
			'mapping_name' => 'company',
			'foreign_key'  => 'user_id',
			)
	);
}
?>