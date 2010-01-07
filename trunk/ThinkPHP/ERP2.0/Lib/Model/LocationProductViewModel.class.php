<?php
import('ViewModel');
class LocationProductViewModel extends ViewModel {
	public $viewFields = array(
		'LocationProduct' => array('id'=>'lp_id', 'product_id', 'ori_quantity', 'chg_quantity'),
		'Product' => array('code', 'type', 'fixed', 'MPN', 'Internal_PN', 'description', 'manufacture', 'value', 'project', '_on'=>'LocationProduct.product_id=Product.id'),
		'ProductFlow' => array('_on'=>'ProductFlow.product_id=Product.id'),
		'Category' => array('name'=>'category_name', '_on'=>'Product.category_id=Category.id'),
		'Options' => array('name'=>'unit_name', '_on'=>'Product.unit_id=Options.id'),
		);
}
?>