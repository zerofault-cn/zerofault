<?php
/**
*
* 库存管理
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class StorageAction extends BaseAction{

	protected $dao;

	public function _initialize() {
		$this->dao = D('Product');
		parent::_initialize();
	}

	public function index() {
		$this->assign('result', $this->dao->relation(true)->select());
		$this->assign('content','Product:index');
		$this->display('Layout:ERP_layout');
	}

}
?>