<?php
// �������ģ����

import('RelationModel');

// ��Ҫ�̳�RelationModelģ����

class RoleModel extends RelationModel{
	// ��������ͳһ�� $_link �����ж���

	protected $_link = array(

		'Node' => array(
			'mapping_type' => MANY_TO_MANY,
			'condition' => 'pid=1'
			),

	);

}

?>