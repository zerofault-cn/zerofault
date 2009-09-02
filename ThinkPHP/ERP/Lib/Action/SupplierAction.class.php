<?php
/**
*
* 供应商
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class SupplierAction extends BaseAction{
	/**
	*
	* 构造函数
	*/
	public function _initialize() {
		parent::_initialize();
	}
	/**
	*
	* 节点列表
	*/
	public function index(){
		$this->assign('content','Node:index');
		$this->display('Layout:ERP_layout');
	}
}
?>