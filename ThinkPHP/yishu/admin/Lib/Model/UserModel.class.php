<?php
import('RelationModel');
class UserModel extends RelationModel{
	protected $_link = array(

		'Role' => array(
			'mapping_type' => MANY_TO_MANY,
			),

	);
}

?>