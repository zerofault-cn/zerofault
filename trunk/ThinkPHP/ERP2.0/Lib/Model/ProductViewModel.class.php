<?php
import('ViewModel');
class ProductViewModel extends ViewModel {
	protected $viewFields = array(
		'ProductFlow' => array('source', 'destination', 'quantity'=>'quantity', 'price', 'supplier_id', 'status'),
		'Product' => array('id'=>'product_id', 'description'=>'product', 'unit_id', '_on'=>'ProductFlow.product_id=Product.id'),
		'Category' => array('id'=>'category_id', '_on'=>'Product.category_id=Category.id'),
		'Options' => array('name'=>'currency', '_on'=>'ProductFlow.currency_id=Options.id and Options.type="currency"'),
	);
}
?>