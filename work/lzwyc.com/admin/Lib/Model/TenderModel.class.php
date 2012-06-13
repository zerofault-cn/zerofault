<?php
import('RelationModel');
class TenderModel extends RelationModel{
	protected $_link = array(
		'Company' => BELONGS_TO
	);
}
?>