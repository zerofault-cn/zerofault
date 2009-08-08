<?php
import('RelationModel');
class NodeModel extends RelationModel{
	protected $_link = array(
		'Node' => array(
			'mapping_type' => HAS_MANY,
			'mapping_name' => 'subNode',
			'mapping_limit' => 0,
			'mapping_order' => '',
			'parent_key' => 'pid'
			)
	);
}

?>