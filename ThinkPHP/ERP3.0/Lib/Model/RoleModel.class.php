<?php
// 引入关联模型类
import('RelationModel');

// 需要继承RelationModel模型类
class RoleModel extends RelationModel{

	// 关联定义统一在 $_link 属性中定义
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