<?php
/**
*
* 库存管理
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class InventoryAction extends BaseAction{

	protected $dao;

	public function _initialize() {
		$this->dao = D('LocationProductView');
		parent::_initialize();
	}

	public function index() {
		$this->assign('category_opts', self::genOptions(M('Category')->select(), $_REQUEST['category_id']) );
		$this->assign('supplier_opts', self::genOptions(D('Supplier')->select(), $_REQUEST['supplier_id']));
		$where = array();
		$where['LocationProduct.type'] = 'location';
		$where['location_id'] = 1;
		$result = array();
		if(!empty($_POST['submit'])) {
			!empty($_REQUEST['category_id']) && ($where['category_id'] = $_REQUEST['category_id']);
			!empty($_REQUEST['supplier_id']) && ($where['supplier_id'] = $_REQUEST['supplier_id']);
			!empty($_REQUEST['Internal_PN']) && ($where['Internal_PN'] = array('like', '%'.trim($_REQUEST['Internal_PN']).'%'));
			!empty($_REQUEST['description']) && ($where['description'] = array('like', '%'.trim($_REQUEST['description']).'%'));
			!empty($_REQUEST['manufacture']) && ($where['manufacture'] = array('like', '%'.trim($_REQUEST['manufacture']).'%'));
			!empty($_REQUEST['MPN']) 		 && ($where['MPN'] 		   = array('like', '%'.trim($_REQUEST['MPN']).'%'));
			!empty($_REQUEST['value']) 		 && ($where['value'] 	   = array('like', '%'.trim($_REQUEST['value']).'%'));
			!empty($_REQUEST['project']) 	 && ($where['project'] 	   = array('like', '%'.trim($_REQUEST['project']).'%'));
			$result = $this->dao->distinct(true)->where($where)->select();
			
		}
		$this->assign('request', $_REQUEST);
		$this->assign('result', $result);
		$this->assign('content','Inventory:index');
		$this->display('Layout:ERP_layout');
	}

}
?>