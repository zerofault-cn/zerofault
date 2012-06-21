<?php
import('RelationModel');
class HotelModel extends RelationModel{
	protected $_link = array(
		'Level' => BELONGS_TO
		);
}
?>