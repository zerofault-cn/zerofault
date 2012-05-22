<?php
import('RelationModel');
class CompanyModel extends RelationModel{
	protected $_link = array(
		'User' => BELONGS_TO
		);
}
?>