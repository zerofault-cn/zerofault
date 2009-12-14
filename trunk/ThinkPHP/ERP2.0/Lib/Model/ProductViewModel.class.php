<?php
import('ViewModel');
class ProductViewModel extends ViewModel {
	protected $viewFields = array(
		'ProductFlow' => array('type', 'quantity', 'price', 'supplier_id', 'status'),
		'Product' => array('id'=>'product_id','Code', 'MPN', 'Internal_PN', 'description', 'manufacture', 'unit_id', '_on'=>'ProductFlow.product_id=Product.id'),
		'Category' => array('id'=>'category_id', '_on'=>'Product.category_id=Category.id'),
		'Options' => array('name'=>'currency', '_on'=>'ProductFlow.currency_id=Options.id and Options.type="currency"'),
	);
}
?>