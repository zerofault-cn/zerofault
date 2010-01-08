<?php
import('RelationModel');
class Remark2Model extends RelationModel{
	protected $_link = array(
		'Staff' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'staff',
			'class_name'   => 'Staff',
			'foreign_key'  => 'staff_id',
			)
	);
}
?>