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
		Session::set('top', 'Inventory Inquire');
		$this->dao = D('ProductView');
		parent::_initialize();
		$this->assign('MODULE_TITLE', 'Inventory Inquire');
	}
	
	public function batch() {
		if(empty($_POST['submit'])) {
			return;
		}
		if (empty($_REQUEST['quantity'])) {
			self::_error('No product selected!');
		}
		$data = array();
		$data['action'] = $_REQUEST['action'];
		$data['from_type'] = $_REQUEST['from_type'];
		$data['from_id'] = $_REQUEST['from_id'];
		$data['to_type'] = 'location';
		$data['to_id'] = 0;
		$data['staff_id'] = $_SESSION[C('USER_AUTH_KEY')];
		$data['create_time'] = date("Y-m-d H:i:s");
		if ('transfer' == $_REQUEST['action']) {
			$data['to_type'] = $_REQUEST['to_type'];
			if (empty($_REQUEST['to_id'])) {
				self::_error('Transfer target must be specified!');
			}
			$data['to_id'] = $_REQUEST['to_id'];
		}
		$where = array(
			'type' => $_REQUEST['from_type'],
			'location_id' => $_REQUEST['from_id']
			);
		$success_arr = $fail_arr = array();
		foreach ($_REQUEST['quantity'] as $product_id=>$quantity) {
			$product = M('Product')->find($product_id);
			if ($quantity<=0) {
				self::_error('The quantity of '.$product['Internal_PN'].' can\'t be less than 0');
			}
			$where['product_id'] = $product_id;
			$q = M('LocationProduct')->where($where)->getField('`ori_quantity`+`chg_quantity`');
			if ($quantity>$q) {
				self::_error('The quantity of '.$product['Internal_PN'].' can\'t be more than '.$q);
			}
			if ('transfer' == $data['action']) {
				$max_code = M('ProductFlow')->where(array('code'=>array('like','T%')))->max('code');
				empty($max_code) && ($max_code = 'T'.sprintf("%09d",0));
			}
			elseif ('return' == $data['action']) {
				$max_code = M('ProductFlow')->where(array('code'=>array('like','R%')))->max('code');
				empty($max_code) && ($max_code = 'R'.sprintf("%09d",0));
			}
			else {
				$max_code = M('ProductFlow')->where(array('code'=>array('like','Out%')))->max('code');
				empty($max_code) && ($max_code = 'Out'.sprintf("%09d",0));
			}
			$data['code'] = ++$max_code;
			$data['fixed'] = $product['fixed'];
			$data['product_id'] = $product_id;
			$data['quantity'] = $quantity;
			if ($flow_id = M('ProductFlow')->add($data)) {
				self::_mail($flow_id, 'new');
				$success_arr[] = $product;
			}
			else {
				$fail_arr[] = $product;
			}
		}
		$msg  = 'Batch '.$data['action'].' result:<br />';
		$msg .= '<strong>&nbsp;&nbsp;Success:</strong><br /><font class=\'blue\'>';
		foreach ($success_arr as $product) {
			$msg .= '&nbsp;&nbsp;&nbsp;&nbsp;'.$product['Internal_PN'].'<br />';
		}
		$msg .= '</font><strong>&nbsp;&nbsp;Failure:</strong><br /><font class=\'red\'>';
		foreach ($fail_arr as $product) {
			$msg .= '&nbsp;&nbsp;&nbsp;&nbsp;'.$product['Internal_PN'].'<br />';
		}
		$msg .= '</font><br />page will auto-redirect after 8 seconds.';
		$url = '';
		if (count($success_arr)>0) {
			$url = __APP__.'/ProductOut/'.$data['action'];
			if ('return'==$data['action']) {
				$url = __APP__.'/ProductOut/returns';
			}
			if (!empty($_REQUEST['from_page']) && 'Asset'==$_REQUEST['from_page']) {
				$url = __APP__.'/Asset/transferOut';
				if ('return'==$data['action']) {
					$url = __APP__.'/Asset/returns';
				}
			}
		}
		self::_success($msg, $url, 8000);
	}

	public function index() {
		Session::set('sub', MODULE_NAME.'/'.ACTION_NAME);
		$this->assign('ACTION_TITLE', 'List');
		$this->assign('category_opts', self::genOptions(M('Category')->select(), $_REQUEST['category_id']) );
		$this->assign('supplier_opts', self::genOptions(D('Supplier')->select(), $_REQUEST['supplier_id']));

		//for batch transfer
		$info = array();
		$location_arr = M('Location')->where(array('id'=>array('gt',1)))->select();
		$location_arr[] = array('id' => 'staff', 'name' => 'Staff');
		$info['location_opts'] = self::genOptions($location_arr);
		$info['staff_opts'] = self::genOptions(M('Staff')->where(array('status'=>1, 'id'=>array('neq',$_SESSION[C('USER_AUTH_KEY')])))->select(), '', 'realname');
		$this->assign('info', $info);
		
		import("@.Paginator");
		$limit = 50;
		if (!empty($_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_limit'])) {
			$limit = $_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_limit'];
		}
		if (!empty($_REQUEST['limit'])) {
			$limit = $_REQUEST['limit'];
		}
		$_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_limit'] = $limit;

		$where = array();
		$where['action'] = 'enter';
		$where['status'] = 1;
		$result = array();
		if(!empty($_POST['submit'])) {
			(''!=$_REQUEST['category_id']) && ($where['category_id'] = $_REQUEST['category_id']);
			(''!=$_REQUEST['supplier_id']) && ($where['supplier_id'] = $_REQUEST['supplier_id']);
			(''!=trim($_REQUEST['Internal_PN'])) && ($where['Internal_PN'] = array('like', '%'.trim($_REQUEST['Internal_PN']).'%'));
			(''!=trim($_REQUEST['description'])) && ($where['description'] = array('like', '%'.trim($_REQUEST['description']).'%'));
			(''!=trim($_REQUEST['manufacture'])) && ($where['manufacture'] = array('like', '%'.trim($_REQUEST['manufacture']).'%'));
			(''!=trim($_REQUEST['MPN'])) 		 && ($where['MPN'] 		   = array('like', '%'.trim($_REQUEST['MPN']).'%'));
			(''!=trim($_REQUEST['value'])) 		 && ($where['value'] 	   = trim($_REQUEST['value']));
			(''!=trim($_REQUEST['project'])) 	 && ($where['project'] 	   = array('like', '%'.trim($_REQUEST['project']).'%'));
			if (count($where)>2) {
				$limit = 1000;
			}
		}
		$rs = $this->dao->where($where)->group('product_id')->select();
		$p = new Paginator(count($rs),$limit);

		$result = $this->dao->field("Options.name as unit_name, Category.name as category_name, Product.id as product_id, Product.fixed as fixed, Product.type as type, Product.Internal_PN as Internal_PN, Product.description as description, group_concat(distinct Supplier.name) as supplier_names")->where($where)->group('product_id')->order('Internal_PN')->limit($p->offset.','.$p->limit)->select();
		foreach ($result as $i=>$val) {
			$where = array();
			$where['product_id'] = $val['product_id'];
			$where['status'] = 1;
			$where['_string'] = "(from_type='location' and from_id=1) or (to_type='location' and to_id=1)";
			$result[$i]['quantity'] = M('ProductFlow')->where($where)->group('action')->getField('action,sum(quantity)');

			//获取物品库存
			//$result[$i]['remain'] = $result[$i]['quantity']['enter'] - $result[$i]['quantity']['reject'] - $result[$i]['quantity']['apply'] - $result[$i]['quantity']['transfer'] - $result[$i]['quantity']['release'] - $result[$i]['quantity']['scrap'] + $result[$i]['quantity']['return'];
			$where = array();
			$where['product_id'] = $val['product_id'];
			$where['type'] = 'location';
			$where['location_id'] =1;
			$result[$i]['inventory'] = M('LocationProduct')->where($where)->find();
			//物品的所有供应商
			$result[$i]['suppliers'] = explode(',', $val['supplier_names']);
			//获取物品的最后入库时间
			$where = array();
			$where['product_id'] = $val['product_id'];
			$where['action'] = 'enter';
			$result[$i]['last_enter_time'] = M('ProductFlow')->where($where)->getField('max(confirm_time)');
			//获取物品的Owner
			$where = array();
			$where['product_id'] = $val['product_id'];
			$where['chg_quantity'] = array('gt',0);
			$where['_string'] = "(type='location' and location_id!=1) or type='staff'";
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
		
		//dump($_SESSION);
		$this->assign('request', $_REQUEST);
		$this->assign('result', $result);
		$this->assign('page', $p->showMultiNavi());
		$this->assign('content','Inventory:index');
		$this->display('Layout:ERP_layout');
	}

	public function location() {
		//for batch transfer
		$info = array();
		$location_arr = M('Location')->where(array('id'=>array('gt',1)))->select();
		$location_arr[] = array('id' => 'staff', 'name' => 'Staff');
		$info['location_opts'] = self::genOptions($location_arr);
		$info['staff_opts'] = self::genOptions(M('Staff')->where(array('status'=>1, 'id'=>array('neq',$_SESSION[C('USER_AUTH_KEY')])))->select(), '', 'realname');
		$this->assign('info', $info);

		$location_id = intval($_REQUEST['id']);
		$this->assign('location_id', $location_id);
		Session::set('sub', MODULE_NAME.'/'.ACTION_NAME.'/id/'.$location_id);
		$rs = D('LocationProduct')->relation(true)->where(array('type'=>'location','location_id'=>$location_id,'chg_quantity'=>array('gt',0)))->select();
		empty($rs) && ($rs = array());
		$result = array();
		foreach ($rs as $item) {
			$lastRemark = self::getLastComment($item['product_id'])."\n";
			$item['lastRemark'] = substr($lastRemark, 0, strpos($lastRemark, "\n"));
			$item['unit_name'] = M('Options')->where('id='.$item['product']['unit_id'])->getField('name');
			//获取物品的最后入库时间
			$where = array();
			$where['product_id'] = $item['product_id'];
			$where['action'] = 'transfer';
			$where['to_type'] = 'location';
			$where['to_id'] = $location_id;
			$item['last_enter_time'] = M('ProductFlow')->where($where)->getField('max(confirm_time)');
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
		$staff_id = empty($_REQUEST['staff_id']) ? 0 : intval($_REQUEST['staff_id']);
		$this->assign('staff_opts', self::genOptions(M('Staff')->where(array('status'=>1))->select(), $staff_id, 'realname'));
		$category_id = empty($_REQUEST['category_id']) ? 0 : intval($_REQUEST['category_id']);
		$this->assign('category_opts', self::genOptions(M('Category')->select(), $category_id));
		$where = array();
		$result = array();
		if(!empty($_POST['submit'])) {
			$where['erp_location_product.chg_quantity'] = array('gt',0);
			$where['erp_location_product.type'] = 'staff';
			$where['erp_location_product.location_id'] = $staff_id;
			$category_id>0 && ($where['erp_category.id'] = $category_id);
			(''!=trim($_REQUEST['Internal_PN'])) && ($where['erp_product.Internal_PN'] = array('like', '%'.trim($_REQUEST['Internal_PN']).'%'));
			(''!=trim($_REQUEST['description'])) && ($where['erp_product.description'] = array('like', '%'.trim($_REQUEST['description']).'%'));
			(''!=trim($_REQUEST['manufacture'])) && ($where['erp_product.manufacture'] = array('like', '%'.trim($_REQUEST['manufacture']).'%'));
			(''!=trim($_REQUEST['MPN'])) 		 && ($where['erp_product.MPN'] 		   = array('like', '%'.trim($_REQUEST['MPN']).'%'));
			(''!=trim($_REQUEST['value'])) 		 && ($where['erp_product.value'] 	   = trim($_REQUEST['value']));
			(''!=trim($_REQUEST['project'])) 	 && ($where['erp_product.project'] 	   = array('like', '%'.trim($_REQUEST['project']).'%'));
			
			$result = M('LocationProduct')->field('erp_location_product.id,erp_location_product.product_id,erp_location_product.chg_quantity,erp_product.type,erp_product.fixed,erp_product.Internal_PN,erp_product.description,erp_category.name as category_name,erp_options.name as unit_name')->where($where)->join('erp_product on erp_product.id=erp_location_product.product_id')->join('erp_category on erp_category.id=erp_product.category_id')->join('erp_options on erp_options.id=erp_product.unit_id')->select();
			foreach ($result as $i=>$val) {
				//获取最后一次Remark
				$lastRemark = self::getLastComment($val['product_id'])."\n";
				$result[$i]['lastRemark'] = substr($lastRemark, 0, strpos($lastRemark, "\n"));
				//获取物品的最后入库时间
				$where = array();
				$where['product_id'] = $val['product_id'];
				$where['to_type'] = 'staff';
				$where['to_id'] = $staff_id;
				$result[$i]['last_enter_time'] = M('ProductFlow')->where($where)->getField('max(confirm_time)');
			}
		}
		if ($_SESSION[C('ADMIN_AUTH_NAME')]) {
			//for batch transfer
			$info = array();
			$location_arr = M('Location')->where(array('id'=>array('gt',1)))->select();
			$location_arr[] = array('id' => 'staff', 'name' => 'Staff');
			$info['location_opts'] = self::genOptions($location_arr);
			$info['staff_opts'] = self::genOptions(M('Staff')->where(array('status'=>1, 'id'=>array('neq',$_SESSION[C('USER_AUTH_KEY')])))->select(), '', 'realname');
			$this->assign('info', $info);
		}
		$this->assign('request', $_REQUEST);
		$this->assign('result', $result);
		$this->assign('content','Inventory:staff');
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