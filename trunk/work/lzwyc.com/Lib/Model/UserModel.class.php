<?php
import('RelationModel');
class UserModel extends RelationModel{
	protected $_link = array(
		'Company' => HAS_ONE
	);
}
?>