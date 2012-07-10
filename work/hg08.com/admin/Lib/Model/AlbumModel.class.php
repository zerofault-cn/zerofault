<?php
import('RelationModel');
class AlbumModel extends RelationModel{
	protected $_link = array(
		'Category' => BELONGS_TO,
		'Photo' => array(
			'mapping_type'=>HAS_MANY,
			'mapping_order'=>'sort, id desc'
			)
		);
}
?>