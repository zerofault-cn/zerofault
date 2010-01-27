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
		$this->assign('MODULE_TITLE', 'Inventory Inquire');
	}

	public function index() {
		Session::set('sub', MODULE_NAME.'/'.ACTION_NAME);
		$this->assign('ACTION_TITLE', 'Search');
		$this->assign('category_opts', self::genOptions(M('Category')->select(), $_REQUEST['category_id']) );
		$this->assign('supplier_opts', self::genOptions(D('Supplier')->select(), $_REQUEST['supplier_id']));
		$where = array();
		$where['action'] = 'enter';
		$where['status'] = 1;
		$result = array();
		if(!empty($_POST['submit'])) {
			$this->assign('ACTION_TITLE', 'Result');
			(''!=$_REQUEST['category_id']) && ($where['category_id'] = $_REQUEST['category_id']);
			(''!=$_REQUEST['supplier_id']) && ($where['supplier_id'] = $_REQUEST['supplier_id']);
			(''!=trim($_REQUEST['Internal_PN'])) && ($where['Internal_PN'] = array('like', '%'.trim($_REQUEST['Internal_PN']).'%'));
			(''!=trim($_REQUEST['description'])) && ($where['description'] = array('like', '%'.trim($_REQUEST['description']).'%'));
			(''!=trim($_REQUEST['manufacture'])) && ($where['manufacture'] = array('like', '%'.trim($_REQUEST['manufacture']).'%'));
			(''!=trim($_REQUEST['MPN'])) 		 && ($where['MPN'] 		   = array('like', '%'.trim($_REQUEST['MPN']).'%'));
			(''!=trim($_REQUEST['value'])) 		 && ($where['value'] 	   = trim($_REQUEST['value']));
			(''!=trim($_REQUEST['project'])) 	 && ($where['project'] 	   = array('like', '%'.trim($_REQUEST['project']).'%'));
			$result = $this->dao->field("Options.name as unit_name, Category.name as category_name, Product.id as product_id, Product.fixed as fixed, Product.type as type, Product.Internal_PN as Internal_PN, Product.description as description, group_concat(distinct Supplier.name) as supplier_names")->where($where)->group('product_id')->select();
			foreach ($result as $i=>$val) {
				$where = array();
				$where['product_id'] = $val['product_id'];
				$where['status'] = 1;
				$where['_string'] = "(from_type='location' and from_id=1) or (to_type='location' and to_id=1)";
				$result[$i]['quantity'] = M('ProductFlow')->where($where)->group('action')->getField('action,sum(quantity)');
				$result[$i]['suppliers'] = explode(',', $val['supplier_names']);

				$where = array();
				$where['product_id'] = $val['product_id'];
				$where['chg_quantity'] = array('gt',0);
				$where['_string'] = "(type='location' and location_id!=1) or type='staff'";
				//获取物品的最终归属
				$owner_arr = M('LocationProduct')->where($where)->select();
				if (empty($owner_arr)) {
					$owner = array();
				}
				else {
					$owner = array();
					$owner['quantity'] = $owner_arr[0]['chg_quantity'];
					if ('location' == $owner_arr[0]['type']) {
						$owner['name'] = M('Location')->where('id='.$owner_arr[0]['location_id'])->getField('name');
					}
					else {
						$owner['name'] = M('Staff')->where('id='.$owner_arr[0]['location_id'])->getField('realname');
					}
					if (count($owner_arr)>1) {
						$owner['more'] = 1;
					}
				}
				/*
				foreach ($owner_arr as $j=>$owner) {
					if ('location' == $owner['type']) {
						$owner_arr[$j]['name'] = M('Location')->where('id='.$owner['location_id'])->getField('name');
					}
					else {
						$owner_arr[$j]['name'] = M('Staff')->where('id='.$owner['location_id'])->getField('realname');
					}
				}*/
				$result[$i]['owner'] = $owner;
				//获取最后一次Remark
				$lastRemark = self::getLastComment($val['product_id'])."\n";
				$result[$i]['lastRemark'] = substr($lastRemark, 0, strpos($lastRemark, "\n"));
			}
		}
		//dump($result);
		$this->assign('request', $_REQUEST);
		$this->assign('result', $result);
		$this->assign('content','Inventory:index');
		$this->display('Layout:ERP_layout');
	}

	public function location() {
		$location_id = intval($_REQUEST['id']);
		Session::set('sub', MODULE_NAME.'/'.ACTION_NAME.'/id/'.$location_id);
		$rs = D('LocationProduct')->relation(true)->where(array('type'=>'location','location_id'=>$location_id,'chg_quantity'=>array('gt',0)))->select();
		empty($rs) && ($rs = array());
		$result = array();
		foreach ($rs as $item) {
			$lastRemark = self::getLastComment($item['product_id'])."\n";
			$item['lastRemark'] = substr($lastRemark, 0, strpos($lastRemark, "\n"));
			$item['unit_name'] = M('Options')->where('id='.$item['product']['unit_id'])->getField('name');
			$result[] = $item;
		}
		//dump($rs);
		$this->assign('result', $result);
		$this->assign('content','Inventory:location');
		$this->display('Layout:ERP_layout');
	}
	public function staff() {
		Session::set('sub', MODULE_NAME.'/'.ACTION_NAME);
		$this->assign('ACTION_TITLE', 'Staff Assets Inquire');
		$this->assign('category_opts', self::genOptions(M('Category')->select(), $_REQUEST['category_id']) );
		$where = array();
		$result = array();
		if(!empty($_POST['submit'])) {
			(''!=$_REQUEST['staff_id']) && ($where['staff_id'] = $_REQUEST['staff_id']);
			(''!=$_REQUEST['category_id']) && ($where['category_id'] = $_REQUEST['category_id']);
			(''!=trim($_REQUEST['Internal_PN'])) && ($where['Internal_PN'] = array('like', '%'.trim($_REQUEST['Internal_PN']).'%'));
			(''!=trim($_REQUEST['description'])) && ($where['description'] = array('like', '%'.trim($_REQUEST['description']).'%'));
			(''!=trim($_REQUEST['manufacture'])) && ($where['manufacture'] = array('like', '%'.trim($_REQUEST['manufacture']).'%'));
			(''!=trim($_REQUEST['MPN'])) 		 && ($where['MPN'] 		   = array('like', '%'.trim($_REQUEST['MPN']).'%'));
			(''!=trim($_REQUEST['value'])) 		 && ($where['value'] 	   = trim($_REQUEST['value']));
			(''!=trim($_REQUEST['project'])) 	 && ($where['project'] 	   = array('like', '%'.trim($_REQUEST['project']).'%'));
			$result = M('LocationProduct')->select();
			foreach ($result as $i=>$val) {
				$where = array();
				$where['product_id'] = $val['product_id'];
				$where['status'] = 1;
				$where['_string'] = "(from_type='location' and from_id=1) or (to_type='location' and to_id=1)";
				$result[$i]['quantity'] = M('ProductFlow')->where($where)->group('action')->getField('action,sum(quantity)');
				$result[$i]['suppliers'] = explode(',', $val['supplier_names']);

				$where = array();
				$where['product_id'] = $val['product_id'];
				$where['chg_quantity'] = array('gt',0);
				$where['_string'] = "(type='location' and location_id!=1) or type='staff'";
				//获取物品的最终归属
				$owner_arr = M('LocationProduct')->where($where)->select();
				if (empty($owner_arr)) {
					$owner = array();
				}
				else {
					$owner = array();
					$owner['quantity'] = $owner_arr[0]['chg_quantity'];
					if ('location' == $owner_arr[0]['type']) {
						$owner['name'] = M('Location')->where('id='.$owner_arr[0]['location_id'])->getField('name');
					}
					else {
						$owner['name'] = M('Staff')->where('id='.$owner_arr[0]['location_id'])->getField('realname');
					}
					if (count($owner_arr)>1) {
						$owner['more'] = 1;
					}
				}
				/*
				foreach ($owner_arr as $j=>$owner) {
					if ('location' == $owner['type']) {
						$owner_arr[$j]['name'] = M('Location')->where('id='.$owner['location_id'])->getField('name');
					}
					else {
						$owner_arr[$j]['name'] = M('Staff')->where('id='.$owner['location_id'])->getField('realname');
					}
				}*/
				$result[$i]['owner'] = $owner;
				//获取最后一次Remark
				$lastRemark = self::getLastComment($val['product_id'])."\n";
				$result[$i]['lastRemark'] = substr($lastRemark, 0, strpos($lastRemark, "\n"));
			}
		}
		//dump($result);
		$this->assign('request', $_REQUEST);
		$this->assign('result', $result);
		$this->assign('content','Inventory:index');
		$this->display('Layout:ERP_layout');
	}
	public function info() {
		R('Product', 'info');
	}

	public function query() {
		$product_id = $_REQUEST['product_id'];
		$action = $_REQUEST['action'];
		$where['product_id'] = $product_id;
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
				$rs[$i]['to_name'] = M('Staff')->where('id='.$val['to_id'])->getField('realname');
			}
			$rs[$i]['supplier_name'] = M('Supplier')->where('id='.$val['supplier_id'])->getField('name');
			$rs[$i]['staff_name'] = M('Staff')->where('id='.$val['staff_id'])->getField('realname');
			$rs[$i]['confirm_name'] = M('Staff')->where('id='.$val['confirmed_staff_id'])->getField('realname');
		}
		$this->assign('product_id', $product_id);
		$this->assign('result', $rs);
		$this->assign('action', $action);
		$this->assign('content', 'Inventory:query2');
		$this->display('Layout:content');
	}
	public function owner() {
		$product_id = intval($_REQUEST['product_id']);
		$where = array();
		$where['product_id'] = $product_id;
		$where['chg_quantity'] = array('gt',0);
		$where['_string'] = "(type='location' and location_id!=1) or type='staff'";
		//获取物品的最终归属
		$owner_arr = M('LocationProduct')->where($where)->select();
		if (empty($owner_arr)) {
			$owner_arr = array();
		}
		foreach ($owner_arr as $j=>$owner) {
			if ('location' == $owner['type']) {
				$owner_arr[$j]['name'] = M('Location')->where('id='.$owner['location_id'])->getField('name');
			}
			else {
				$owner_arr[$j]['name'] = M('Staff')->where('id='.$owner['location_id'])->getField('realname');
			}
		}
		$this->assign("result", $owner_arr);
		$this->display();
	}
	protected function getLastComment($product_id) {
		$remark2 = M('Remark2')->where(array('product_id'=>$product_id, 'status'=>1))->order('id desc')->getField('remark');
		if (!empty($remark2)) {
			return $remark2;
		}
		$remark1 = M('ProductFlow')->where('product_id='.$product_id)->order('id desc')->getField('remark');
		if (!empty($remark1)) {
			return $remark1;
		}
		return M('Product')->where('id='.$product_id)->getField('remark');
	}
	/*
	* useless
	*/
	private function query_remark() {
		$product_id = $_REQUEST['product_id'];
		$flow_id = $_REQUEST['flow_id'];
		$remark = M('Product')->field('remark')->where('id='.$product_id)->select();
		$remark1 = M('ProductFlow')->field('staff_id,create_time,remark')->where('id='.$flow_id)->select();
		$remark2 = M('Remark2')->where(array('flow_id'=>$flow_id, 'status'=>1))->select();
		if (empty($remark2)) {
			$remark2 = array();
		}
		$remark_all = array();
		foreach (array_merge($remark, $remark1, $remark2) as $item) {
			if (''==trim($item['remark'])) {
				continue;
			}
			if (!empty($item['staff_id'])) {
				 $item['staff_name'] = M('Staff')->where('id='.$item['staff_id'])->getField('realname');
			}
			$item['remark'] = nl2br($item['remark']);
			$remark_all[] = $item;
		}
		echo json_encode($remark_all);
		return;
	}

}
?>