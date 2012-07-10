<?php
import('RelationModel');
class AdminModel extends RelationModel{
	protected $_link = array(
		'Role' => MANY_TO_MANY
		);
}
?>