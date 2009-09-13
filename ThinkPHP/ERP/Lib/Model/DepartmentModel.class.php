<?php
import('RelationModel');
class NodeModel extends RelationModel{
	protected $_link = array(
		'Staff' => array(
			'mapping_type' => HAS_ONE,
			'mapping_name' => 'subNode',
			'mapping_limit' => 0,
			'mapping_order' => '',
			'parent_key' => 'pid'
			)
	);
}

?>