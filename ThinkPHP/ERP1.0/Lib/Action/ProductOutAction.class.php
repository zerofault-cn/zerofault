<?php
/**
*
* 出库，退库
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class ProductOutAction extends BaseAction{

	protected $dao;

	public function _initialize() {
		$this->dao = D('ProductFlow');
		parent::_initialize();
	}
	Public function apply() {
		$this->index('apply',1);
	}
	Public function applyFloating() {
		$this->index('apply',0);
	}
	Public function transfer() {
		$this->index('transfer');
	}
	Public function release() {
		$this->index('release');
	}
	Public function scrap() {
		$this->index('scrap');
	}
	Public function back() {
		$this->index('back');
	}
	public function index($action='apply',$fixed='') {
		$rs = M('Options')->where(array('type'=>'unit'))->order('sort')->select();
		$unit = array();
		foreach($rs as $i=>$item) {
			$unit[$item['id']] = $item['name'];
		}
		$this->assign('unit', $unit);
		
		if(!empty($_REQUEST['action'])) {
			$action = $_REQUEST['action'];
		}
		$this->assign('action', $action);

		if(isset($_REQUEST['status'])) {
			$status = $_REQUEST['status'];
		}
		elseif(''!=(Session::get($action.'_status'))) {
			$status = Session::get($action.'_status');
		}
		else{
			$status = 0;
		}
		Session::set($action.'_status', $atatus);
		$this->assign('status', $status);

		
		$where = array(
			'action' => $action,
			'status' => $status
			);
		if(strlen($fixed)!=0) {
			$where['fixed'] = $fixed;
		}
		if(MODULE_NAME == 'Asset') {
			if(ACTION_NAME == 'transferIn') {
				$where['to_type'] = 'staff';
				$where['to_id'] = $_SESSION[C('USER_AUTH_KEY')];
			}
			elseif (ACTION_NAME == 'transferOut') {
				$where['from_type'] = 'staff';
				$where['from_id'] = $_SESSION[C('USER_AUTH_KEY')];
			}
			else {
				$where['_string'] = "(from_type='staff' and to_id =".$_SESSION[C('USER_AUTH_KEY')].") or (to_type='staff' and to_id = ".$_SESSION[C('USER_AUTH_KEY')].") or staff_id = ".$_SESSION[C('USER_AUTH_KEY')];
			}
		}
		elseif(!$_SESSION[C('ADMIN_AUTH_KEY')]) {
		//	$where['_string'] = "(from_type='staff' and to_id =".$_SESSION[C('USER_AUTH_KEY')].") or (to_type='staff' and to_id = ".$_SESSION[C('USER_AUTH_KEY')].") or staff_id = ".$_SESSION[C('USER_AUTH_KEY')];
		}
		$count = $this->dao->where($where)->getField('count(*)');
		import("@.Paginator");
		$limit = 10;
		$p = new Paginator($count,$limit);

		$order = 'id desc';
		$result = array();
		foreach($this->dao->relation(true)->where($where)->order($order)->limit($p->offset.','.$p->limit)->select() as $item) {
			$item['backed_quantity'] = $this->dao->where(array('code'=>'R'.substr($item['code'],-9),'status'=>1))->sum('quantity');
			empty($item['backed_quantity']) && ($item['backed_quantity']=0);
			$item['transfered_quantity'] = $this->dao->where(array('code'=>'T'.substr($item['code'],-9),'status'=>1))->sum('quantity');
			empty($item['transfered_quantity']) && ($item['transfered_quantity']=0);
			$result[] = $item;
		}
		$this->assign('result', $result);
		$this->assign('page', $p->showMultiNavi());
		$this->assign('content','ProductOut:index');
		$this->display('Layout:ERP_layout');
	}

	public function form() {
		$id = $_REQUEST['id'];
		$action = $_REQUEST['action'];
		if(''==$action) {
		//	$action = 'apply';
		}
		if(!empty($id) && $id>0) {
			$info = $this->dao->relation(true)->find($id);
			$info['category'] = M('Category')->where("id=".$info['product']['category_id'])->getField('name');
			$info['unit'] = M('Options')->where("id=".$info['product']['unit_id'])->getField('name');
			if('transfer'==$action) {//new transfer
				$code = 'T'.substr($info['code'],-9);
				$location_arr = M('Location')->where(array('id'=>array('gt',1)))->select();
				$location_arr[] = array('id' => 'staff', 'name' => 'Staff');
				$info['location_opts'] = self::genOptions($location_arr, 'location'==$info['to_type'] ? $info['to_id'] : 'staff');
				$info['staff_opts'] = self::genOptions(M('Staff')->where(array('status'=>1))->select(), $info['to_id'], 'realname');
				
				$backed_quantity = $this->dao->where(array('code'=>'R'.substr($code,-9),'status'=>1))->sum('quantity');
				$transfered_quantity = $this->dao->where(array('code'=>'T'.substr($code,-9),'status'=>1))->sum('quantity');
				$info['quantity'] = $info['ori_quantity'] = $info['quantity'] - $backed_quantity - $transfered_quantity;
				
				$info['from_type'] = 'staff';
				$info['from_id'] = $info['staff_id'];
				
				$id = 0;
			}
			elseif ('back'==$action) {//new back
				$code = 'R'.substr($info['code'], -9);
				$backed_quantity = $this->dao->where(array('code'=>'R'.substr($code,-9),'status'=>1))->sum('quantity');
				$transfered_quantity = $this->dao->where(array('code'=>'T'.substr($code,-9),'status'=>1))->sum('quantity');
				$info['quantity'] = $info['ori_quantity'] = $info['quantity'] - $backed_quantity - $transfered_quantity;
				
				$info['from_type'] = 'staff';
				$info['from_id'] = $info['staff_id'];
				
				$id = 0;
			}
			elseif ('transfer'==$info['action'] || 'back' == $info['action']) {//edit transfer/back
				$code = $info['code'];
				$action = $info['action'];

				$location_arr = M('Location')->where(array('id'=>array('gt',1)))->select();
				$location_arr[] = array('id' => 'staff', 'name' => 'Staff');
				$info['location_opts'] = self::genOptions($location_arr, 'location'==$info['to_type'] ? $info['to_id'] : 'staff');
				$info['staff_opts'] = self::genOptions(M('Staff')->where(array('status'=>1))->select(), $info['to_id'], 'realname');
				
				$from_quantity = $this->dao->where(array('code'=>'Out'.substr($code, -9),'status'=>1))->getField('quantity');
				$transfered_quantity = $this->dao->where(array('code'=>'T'.substr($code, -9),'status'=>1))->sum('quantity');
				$backed_quantity = $this->dao->where(array('code'=>'R'.substr($code, -9),'status'=>1))->sum('quantity');
				$info['ori_quantity'] = $from_quantity - $transfered_quantity - $transfered_quantity;
			}
			else{//edit apply
				$code = $info['code'];
				$rs = D('Product')->relation(true)->find($info['product_id']);
				$info['ori_quantity'] = $rs['location_product'][0]['ori_quantity'] + $rs['location_product'][0]['chg_quantity'];
			}
		}
		else{//new apply/transfer/release/scrap
			$info = array();
			$location_arr = M('Location')->where(array('id'=>array('gt',1)))->select();
			$location_arr[] = array('id' => 'staff', 'name' => 'Staff');
			$info['location_opts'] = self::genOptions($location_arr);
			$info['staff_opts'] = self::genOptions(M('Staff')->where(array('status'=>1))->select(), '', 'realname');
			$info['from_type'] = 'location';
			$info['from_id'] = 1;
			$max_code = $this->dao->where(array('code'=>array('like','Out%')))->max('code');
			empty($max_code) && ($max_code = 'Out'.sprintf("%09d",0));
			$code = ++ $max_code;
			
			if(!empty($_REQUEST['lp_id'])) {
				$lp_info = M('LocationProduct')->find($_REQUEST['lp_id']);
				$this->assign('product_id', $lp_info['product_id']);
				$info['product'] = M('Product')->find($lp_info['product_id']);
				$info['category'] = M('Options')->where('id='.$info['product']['category_id'])->getField('name');
				$info['unit'] = M('Options')->where('id='.$info['product']['unit_id'])->getField('name');
				$info['ori_quantity'] = $lp_info['ori_quantity']+$lp_info['chg_quantity'];
				$info['from_type'] = $lp_info['type'];
				$info['from_id'] = $lp_info['location_id'];
			
				if('transfer'==$action) {
					$max_code = $this->dao->where(array('code'=>array('like','T%')))->max('code');
					empty($max_code) && ($max_code = 'T'.sprintf("%09d",0));
				}
				elseif('back'==$action) {
					$max_code = $this->dao->where(array('code'=>array('like','R%')))->max('code');
					empty($max_code) && ($max_code = 'R'.sprintf("%09d",0));
				
				}
				$code = ++ $max_code;
				
			}
		}
		//dump($info);
		$this->assign('id', $id);
		$this->assign('action', $action);
		$this->assign('code', $code);

		$this->assign('info', $info);
		$this->assign('content', 'ProductOut:form');
		$this->display('Layout:ERP_layout');
	}
	public function submit() {
		if(empty($_POST['submit'])) {
			return;
		}
		$id = $_REQUEST['id'];
		$action = $_REQUEST['action'];
		empty($_REQUEST['product_id']) && self::_error('Select a Component/Board first!');
		empty($_REQUEST['quantity']) && self::_error('Quantity must be inputed');
		($_REQUEST['quantity']>$_REQUEST['ori_quantity']) && self::_error(ucfirst($action).'quantity can\'t be larger than '.$_REQUEST['ori_quantity']);

		if(!empty($id) && $id>0) {//from edit
			$this->dao->find($id);
		}
		else{//from new
			$max_code = $this->dao->where(array('code'=>array('like','Out%')))->max('code');
			empty($max_code) && ($max_code = 'Out'.sprintf("%09d",0));
			$code = ++ $max_code;
			$this->dao->code = $code;
			if('transfer'==$action || 'back'==$action) {
				$rs = $this->dao->where(array('code'=>$_REQUEST['code'],'status'=>0))->select();
				if(!empty($rs)) {
					self::_error('Last '.$action.' haven\'t confirmed yet!');
				}
			}
			$this->dao->action = $action;
			
			$this->dao->from_type = 'location'; //new apply
			$this->dao->from_id = 1;//new apply
			$this->dao->to_type = 'staff'; //new apply
			$this->dao->to_id = $_SESSION[C('USER_AUTH_KEY')];//new apply
			$this->dao->staff_id = $_SESSION[C('USER_AUTH_KEY')];
			$this->dao->create_time = date("Y-m-d H:i:s");
		}
		if('transfer'==$action) {
			$this->dao->code = $_REQUEST['code'];
			$this->dao->from_type = $_REQUEST['from_type'];
			$this->dao->from_id = $_REQUEST['from_id'];
			$this->dao->to_type = $_REQUEST['to_type'];
			$this->dao->to_id = $_REQUEST['to_id'];
		}
		if('back'==$action) {
			$this->dao->code = $_REQUEST['code'];
			$this->dao->from_type = $_REQUEST['from_type'];
			$this->dao->from_id = $_REQUEST['from_id'];
			$this->dao->to_type = 'location';
			$this->dao->to_id = 1;
		}
		$this->dao->fixed = $_REQUEST['fixed'];
		$this->dao->product_id = $_REQUEST['product_id'];
		$this->dao->quantity = $_REQUEST['quantity'];
		$this->dao->remark = $_REQUEST['remark'];
		if(!empty($id) && $id>0) {
			if(false !== $this->dao->save()){
				self::_success('Product information updated!',__URL__.'/'.(''==$action ? $this->dao->action : (MODULE_NAME=='Asset'?'':$action)));
			}
			else{
				self::_error('Update fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		else{
			if($this->dao->add()) {
				if($action=='apply') {
					self::_success('Apply success !',__URL__.'/'.$action);
				}
				elseif('transfer'==$action) {
					self::_success('Transfer success!',__URL__.'/'.(MODULE_NAME=='Asset'?'':$action));
				}
				else{
					self::_success('Operation success!',__URL__.'/'.$action);
				}
			}
			else{
					self::_error('Operation fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
	}
	public function confirm() {
		if(empty($_POST['submit'])) {
			return;
		}
		empty($_POST['chk']) && self::_error('You haven\'t select any item!');
		sort($_POST['chk']);//先提交的先confirm
		//dump($_POST['chk']);
		foreach ($_POST['chk'] as $id) {
			$info = $this->dao->find($id);
			if('back' != $info['action']) {
				//减库存，或减资产
				$where = array(
					'type' => $info['from_type'],
					'location_id' => $info['from_id'],
					'product_id'  => $info['product_id'],
					);
				$rs = M('LocationProduct')->where($where)->find();
				if (empty($rs)) {
					self::_error('Inventory empty fail!');
				}
				elseif ($rs['ori_quantity']+$rs['chg_quantity']<$info['quantity']) {
					self::_error('Inventory insufficient!');
				}
				else {
					if (!M('LocationProduct')->setDec('chg_quantity','id='.$rs['id'], $info['quantity'])) {
						self::_error('Update inventory fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
					}
				}
			}
			if('release' != $info['action'] && 'scrap' != $info['action']) {
				//加个人资产，或公共资产
				$where = array(
					'type'		  => $info['to_type'],
					'location_id' => $info['to_id'],
					'product_id'  => $info['product_id'],
					);
				$lp_id = M('LocationProduct')->where($where)->getField('id');
				if(!empty($lp_id)) {
					if (!M('LocationProduct')->setInc('chg_quantity','id='.$lp_id,$info['quantity'])) {
						self::_error('Update inventory fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
					}
				}
				else {
					M('LocationProduct')->id = 0;
					M('LocationProduct')->type = $info['to_type'];
					M('LocationProduct')->location_id = $info['to_id'];
					M('LocationProduct')->product_id = $info['product_id'];
					M('LocationProduct')->ori_quantity = 0;
					M('LocationProduct')->chg_quantity = $info['quantity'];
					if (!M('LocationProduct')->add()) {
						self::_error('Insert inventory fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
					}
				}
			}

			$data = array();
			$data['id'] = $id;
			$data['confirm_time'] = date("Y-m-d H:i:s");
			$data['confirmed_staff_id'] = $_SESSION[C('USER_AUTH_KEY')];
			$data['status'] = 1;
			if (!$this->dao->save($data)) {
				self::_error('Confirm fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		self::_success('Confirm success','',1000);
	}
	public function select() {
		R('Product', 'select');
	}

	public function delete() {
		self::_delete();
	}
}
?>