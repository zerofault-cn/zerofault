<?php
// �������ģ����
import('RelationModel');

// ��Ҫ�̳�RelationModelģ����
class RoleModel extends RelationModel{

	// ��������ͳһ�� $_link �����ж���
	protected $_link = array(
		'Node' => array(
			'mapping_type' => MANY_TO_MANY,
			'mapping_limit' => 0,
			'mapping_order' => '',
			'relation_foreign_key' => 'node_id',
			'relation_table' => 'erp_role_node',
			'condition' => 'pid=0' 
			)
	);
}

?>