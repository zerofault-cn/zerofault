<?php
import('RelationModel');
class CategoryModel extends RelationModel{
	protected $_link = array(
		'Album' => array(
			'mapping_type'=>HAS_MANY,
			'mapping_order'=>'sort, id desc'
			)
		);
}
?>