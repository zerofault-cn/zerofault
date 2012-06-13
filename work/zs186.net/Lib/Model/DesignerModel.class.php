<?php
import('RelationModel');
class DesignerModel extends RelationModel{
	protected $_link = array(
		'Case' => array(
			'mapping_type'=>HAS_MANY,
			'mapping_order'=>'id desc'
			)

		);
}
?>