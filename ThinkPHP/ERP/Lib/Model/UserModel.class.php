<?php
import('RelationModel');
class UserModel extends RelationModel{
	protected $_link = array(
		'Role' => array(
			'mapping_type' => MANY_TO_MANY,
			'mapping_limit' => 0,
			'mapping_order' => '',
			'relation_foreign_key' => 'role_id',
			'relation_table' => 'erp_user_role'
			)
	);
}
?>