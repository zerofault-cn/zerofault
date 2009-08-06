<?php
import('RelationModel');
class NodeModel extends RelationModel{
	
	protected $_link = array(

		'Node' => array(
			'mapping_type' => HAS_MANY,
			'foreign_key'  => 'pid'
			),

	);
}

?>