<?php
import('RelationModel');
class ViewModel extends RelationModel{
	protected $_link = array(
		'Company' => BELONGS_TO
	);
}
?>