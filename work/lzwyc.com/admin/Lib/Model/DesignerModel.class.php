<?php
import('RelationModel');
class DesignerModel extends RelationModel{
	protected $_link = array(
		'Case' => HAS_MANY
		);
}
?>