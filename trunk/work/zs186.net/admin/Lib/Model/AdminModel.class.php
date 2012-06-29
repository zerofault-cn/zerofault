<?php
import('RelationModel');
class AdminModel extends RelationModel{
	protected $_link = array(
		'Role' => array(
			'mapping_type' => MANY_TO_MANY,
			'mapping_limit' => 0,
			'mapping_order' => '',
			'relation_foreign_key' => 'role_id',
			'relation_table' => 'zs_admin_role'
			)
		);
}
?>