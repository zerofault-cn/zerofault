<?php
import('RelationModel');
class BundleModel extends RelationModel{
	protected $_link = array(
		'Staff' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'staff',
			'class_name'   => 'Staff',
			),
	/*	'BundleEntry' => array(
			'mapping_type' => HAS_MANY,
			'class_name'   => 'BundleEntry',
			'mapping_name' => 'entry'
			)*/
	);
}
?>