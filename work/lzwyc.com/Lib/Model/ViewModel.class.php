<?php
import('RelationModel');
class ViewModel extends RelationModel{
	protected $_link = array(
		'Invite' => BELONGS_TO
	);
}
?>