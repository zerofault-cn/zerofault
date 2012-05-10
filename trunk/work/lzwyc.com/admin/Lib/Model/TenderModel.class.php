<?php
import('RelationModel');
class TenderModel extends RelationModel{
	protected $_link = array(
		'Invite' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'invite',
			'class_name'   => 'Invite',
			'foreign_key'  => 'invite_id',
			),
		'Company' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'company',
			'class_name'   => 'Company',
			'foreign_key'  => 'company_id',
			)
	);
}
?>