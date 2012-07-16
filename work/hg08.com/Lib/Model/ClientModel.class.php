<?php
import('RelationModel');
class ClientModel extends RelationModel{
	protected $_link = array(
		'Project' => BELONGS_TO
		);
}
?>