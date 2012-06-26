<?php
import('RelationModel');
class BookModel extends RelationModel{
	protected $_link = array(
		'Category' => BELONGS_TO,
		'Region' => BELONGS_TO,
		'Hotel' => BELONGS_TO,
		);
}
?>