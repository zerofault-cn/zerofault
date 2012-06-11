<?php
import('RelationModel');
class ReserveModel extends RelationModel{
	protected $_link = array(
		'Designer' => BELONGS_TO,
		'Region' => array(
			'mapping_type' => BELONGS_TO,
			'foreign_key'  => 'district'
			),
		'Building' => array(
			'mapping_type' => BELONGS_TO,
			'foreign_key'  => 'type'
			)
		);
}
?>