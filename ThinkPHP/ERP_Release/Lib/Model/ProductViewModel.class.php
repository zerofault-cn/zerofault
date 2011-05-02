<?php
import('ViewModel');
class ProductViewModel extends ViewModel {
	protected $viewFields = array(
		'ProductFlow' => array('product_id'),
		'Product' => array('code', 'MPN', 'Internal_PN', 'description', 'manufacture', 'value', 'project', '_on'=>'ProductFlow.product_id=Product.id'),
		'Category' => array('name'=>'category_name', '_on'=>'Product.category_id=Category.id'),
		'Supplier' => array('name'=>'supplier_name', '_on'=>'Supplier.id=ProductFlow.supplier_id'),
		'Options' => array('name'=>'unit_name', '_on'=>'Product.unit_id=Options.id'),
		
		);
}
?>