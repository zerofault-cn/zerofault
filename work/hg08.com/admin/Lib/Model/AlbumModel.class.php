<?php
import('RelationModel');
class AlbumModel extends RelationModel{
	protected $_link = array(
		'Category' => BELONGS_TO,
		'Photo' => array(
			'mapping_type'=>HAS_MANY,
		//	'condition' => 'status>0',
			'mapping_order'=>'sort, id desc'
			)
		);
}
?>