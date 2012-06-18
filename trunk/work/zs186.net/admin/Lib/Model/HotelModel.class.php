<?php
import('RelationModel');
class HotelModel extends RelationModel{
	protected $_link = array(
		'Category' => BELONGS_TO,
		'Region' => BELONGS_TO,
		'District' => BELONGS_TO,
		'Level' => BELONGS_TO
		);
}
?>