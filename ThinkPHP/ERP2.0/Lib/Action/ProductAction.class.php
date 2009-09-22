<?php
/**
*
* 货品资料
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class ProductAction extends BaseAction{

	protected $dao;

	public function _initialize() {
		$this->dao = M('Product');
		parent::_initialize();
	}
	/**
	*
	* 节点列表
	*/
	public function index(){
		$this->assign('content','Product:index');
		$this->display('Layout:ERP_layout');
	}
}
?>