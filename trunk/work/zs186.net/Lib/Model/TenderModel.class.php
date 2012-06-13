<?php
import('RelationModel');
class TenderModel extends RelationModel{
	protected $_link = array(
		'Invite' => BELONGS_TO,
		'Company' => BELONGS_TO
	);
}
?>