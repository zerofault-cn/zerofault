<?php
import('RelationModel');
class PhotoModel extends RelationModel{
	protected $_link = array(
		'Album' => BELONGS_TO,
		'Category' => BELONGS_TO
		);
}
?>