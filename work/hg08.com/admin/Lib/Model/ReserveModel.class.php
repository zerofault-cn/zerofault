<?php
import('RelationModel');
class ReserveModel extends RelationModel{
	protected $_link = array(
		'Article' => array(
			'mapping_type' => BELONGS_TO,
			'foreign_key' => 'set'
			)
		);
}
?>