<?php
import('RelationModel');

class LocationModel extends RelationModel{

	protected $_link = array(
		'Product' => array(
			'mapping_type' => MANY_TO_MANY,
			'mapping_limit' => 0,
			'mapping_order' => '',
			'relation_foreign_key' => 'product_id',
			'relation_table' => 'erp_location_product',
			)
	);
}

?>