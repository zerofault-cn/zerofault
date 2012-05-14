<?php
import('RelationModel');
class TenderModel extends RelationModel{
	protected $_link = array(
		'Invite' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'invite',
			'foreign_key'  => 'invite_id',
			),
		'Company' => array(
			'mapping_type' => BELONGS_TO,
			'mapping_name' => 'company',
			'foreign_key'  => 'company_id',
			)
	);
}
?>