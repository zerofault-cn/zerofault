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
		$this->dao = D('ProductView');
		parent::_initialize();
	}

	public function index() {
		$this->assign('category_opts', self::genOptions(M('Category')->select(), $_REQUEST['category_id']) );
		$this->assign('supplier_opts', self::genOptions(D('Supplier')->select(), $_REQUEST['supplier_id']));
		$where = array();
		$where['action'] = 'enter';
		$where['status'] = 1;
		$result = array();
		if(!empty($_POST['submit'])) {
			!empty($_REQUEST['category_id']) && ($where['category_id'] = $_REQUEST['category_id']);
			!empty($_REQUEST['supplier_id']) && ($where['supplier_id'] = $_REQUEST['supplier_id']);
			!empty($_REQUEST['Internal_PN']) && ($where['Internal_PN'] = array('like', '%'.trim($_REQUEST['Internal_PN']).'%'));
			!empty($_REQUEST['description']) && ($where['description'] = array('like', '%'.trim($_REQUEST['description']).'%'));
			!empty($_REQUEST['manufacture']) && ($where['manufacture'] = array('like', '%'.trim($_REQUEST['manufacture']).'%'));
			!empty($_REQUEST['MPN']) 		 && ($where['MPN'] 		   = array('like', '%'.trim($_REQUEST['MPN']).'%'));
			!empty($_REQUEST['value']) 		 && ($where['value'] 	   = trim($_REQUEST['value']));
			!empty($_REQUEST['project']) 	 && ($where['project'] 	   = array('like', '%'.trim($_REQUEST['project']).'%'));
			$result = $this->dao->field("Options.name as unit_name, Category.name as category_name, Product.id as product_id, Product.fixed as fixed, Product.value as value, Product.project as project, Product.MPN as MPN, Product.Internal_PN as Internal_PN, Product.description as description, Product.manufacture as manufacture, group_concat(Supplier.name SEPARATOR '<br />') as supplier_name")->where($where)->group('product_id')->select();
			foreach ($result as $i=>$val) {
				$where = array();
				$where['product_id'] = $val['product_id'];
				$where['status'] = 1;
				$where['_string'] = "(from_type='location' and from_id=1) or (to_type='location' and to_id=1)";
				$result[$i]['quantity'] = M('ProductFlow')->where($where)->group('action')->getField('action,sum(quantity)');
			}
		}
		$this->assign('request', $_REQUEST);
		$this->assign('result', $result);
		$this->assign('content','Inventory:index');
		$this->display('Layout:ERP_layout');
	}
	public function query() {
		$id = $_REQUEST['id'];
		$action = $_REQUEST['action'];
		$where['product_id'] = $id;
		$where['action'] = $action;
		$where['status'] = 1;
		if ('transfer' == $action) {
			$where['_string'] = "(from_type='location' and from_id=1) or (to_type='location' and to_id=1)";
		}
		$rs = M('ProductFlow')->where($where)->select();
		foreach ($rs as $i=>$val) {
			if ('location' == $val['to_type']) {
				$rs[$i]['to_name'] = M('Location')->where('id='.$val['to_id'])->getField('name');
			}
			else {
				$rs[$i]['to_name'] = M('Staff')->where('id='.$val['to_id'])->getField('name');
			}
			$rs[$i]['supplier_name'] = M('Supplier')->where('id='.$val['supplier_id'])->getField('name');
			$rs[$i]['staff_name'] = M('Staff')->where('id='.$val['staff_id'])->getField('name');
			$rs[$i]['confirm_name'] = M('Staff')->where('id='.$val['confirmed_staff_id'])->getField('name');
			$rs[$i]['remark2'] = D('Remark2')->relation(true)->where(array('flow_id'=>$val['id']))->select();
		}
		$this->assign('id', $id);
		$this->assign('result', $rs);
		$this->assign('action', $action);
		$this->assign('content', 'Inventory:query');
		$this->display('Layout:content');
	}

}
?>