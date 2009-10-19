<?php
import('ViewModel');
class ProductViewModel extends ViewModel {
	protected $viewFields = array(
		'ProductFlow' => array('source', 'destination', 'moved_quantity'=>'quantity', 'price', 'supplier_id', 'status'),
		'Product' => array('id'=>'product_id', 'description'=>'product', 'unit_id', '_on'=>'ProductFlow.product_id=Product.id'),
		'Commodity' => array('id'=>'commodity_id', '_on'=>'Product.commodity_id=Commodity.id'),
		'Options' => array('title'=>'currency', '_on'=>'ProductFlow.currency_id=Options.id and Options.type="currency"'),
	);
}
?>