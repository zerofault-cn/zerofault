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
		$this->index('apply');
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
	public function index($action='') {
		$rs = M('Options')->where(array('type'=>'unit'))->order('sort')->select();
		$unit = array();
		foreach($rs as $i=>$item) {
			$unit[$item['id']] = $item['name'];
		}
		$this->assign('unit', $unit);
		
		if(''==$action) {
			$action = $_REQUEST['action'];
		}
		$this->assign('action', $action);

		if(isset($_REQUEST['status'])) {
			$status = $_REQUEST['status'];
		}
		elseif(''!=(Session::get('enter_status'))) {
			$status = Session::get('enter_status');
		}
		else{
			$status = 0;
		}
		Session::set('enter_status', $atatus);
		$this->assign('status', $status);

		$where = array(
			'action' => $action,
			'status' => $status
			);
		
		$count = $this->dao->where($where)->getField('count(*)');
		import("@.Paginator");
		$limit = 10;
		$p = new Paginator($count,$limit);

		$order = 'id desc';
		$this->assign('result', $this->dao->relation(true)->where($where)->order($order)->limit($p->offset.','.$p->limit)->select());
		$this->assign('page', $p->showMultiNavi());
		$this->assign('content','ProductOut:index');
		$this->display('Layout:ERP_layout');
	}
	
	public function confirm() {
		if(empty($_POST['submit'])) {
			return;
		}
		empty($_POST['chk']) && self::_error('You haven\'t select any item!');
		foreach ($_POST['chk'] as $id) {
			$info = $this->dao->find($id);
			if('back'!=$info['action']) {
				//减库存
				$where = array(
					'type' => 'location',
					'location_id' => 1,
					'product_id'  => $info['product_id'],
					);
				$lp_id = M('LocationProduct')->where($where)->getField('id');
				if (empty($lp_id)) {
					self::_error('Local Storage empty!');
				}
				else {
					if (!M('LocationProduct')->setDec('chg_quantity','id='.$lp_id,$info['quantity'])) {
						self::_error('Change location product fail !'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
					}
				}
			}
			if('apply'==$info['action'] || 'transfer'==$info['action']) {
				//记入个人资产，或公共资产
				$where = array(
					'type'		  => 'apply'==$info['action'] ? 'staff' : 'location',
					'location_id' => 'apply'==$info['action'] ? $info['staff_id'] : $info['to_id'],
					'product_id'  => $info['product_id'],
					);
			}
			elseif('back'==$info['action']) {
				//返回库存
				$where = array(
					'type'		  => 'location',
					'location_id' => 1,
					'product_id'  => $info['product_id'],
					);
			}
			$lp_id = M('LocationProduct')->where($where)->getField('id');
			if(!empty($lp_id)) {
				if (!M('LocationProduct')->setInc('chg_quantity','id='.$lp_id,$info['quantity'])) {
					self::_error('Update location product fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
				}
			}
			else {
				M('LocationProduct')->type = 'apply'==$info['action'] ? 'staff' : 'location';
				M('LocationProduct')->location_id = 'apply'==$info['action'] ? $info['staff_id'] : $info['to_id'];
				M('LocationProduct')->product_id = $info['product_id'];
				M('LocationProduct')->ori_quantity = 0;
				M('LocationProduct')->chg_quantity = $info['quantity'];
				if (!M('LocationProduct')->add()) {
					self::_error('Insert location product fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
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

	public function form() {
		$action = $_REQUEST['action'];
		$id = $_REQUEST['id'];
		if(!empty($id) && $id>0) {
			$info = $this->dao->relation(true)->find($id);
			$info['category'] = M('Category')->where("id=".$info['product']['category_id'])->getField('name');
			$info['unit'] = M('Options')->where("id=".$info['product']['unit_id'])->getField('name');
			if('transfer'==$action) {
				$code = 'T'.substr($info['code'],-9);
			}
			elseif('returns'==$action) {
				$code = 'R'.substr($info['code'], -9);
			}
			else{
				$code = $info['code'];
			}
		}
		else{
			$info = array(
				'product_opts' => self::genOptions(D('Product')->select(),'','MPN'),
				'supplier_opts' => self::genOptions(D('Supplier')->select()),
				'currency_opts' => self::genOptions(M('Options')->where(array('type'=>'currency'))->order('sort')->select()),
				'unit_opts' => self::genOptions(M('Options')->where(array('type'=>'unit'))->order('sort')->select())
			);
			$max_id = $this->dao->getField('max(id) as max_id');
			empty($max_id) && ($max_id = 0);
			$code = 'Out'.sprintf("%09d",$max_id+1);
		}
		$this->assign('id', $id);
		$this->assign('action', $action);
		$this->assign('code', $code);

		$this->assign('info', $info);
		$this->assign('ProductList', D('Product')->relation(true)->select());
		$this->assign('content', 'ProductOut:form');
		$this->display('Layout:ERP_layout');
	}
	public function submit() {
		if(empty($_POST['submit'])) {
			return;
		}
		$id = $_REQUEST['id'];
		$action = $_REQUEST['action'];
		empty($_REQUEST['product_id']) && self::_error('Select a product first!');
		($_REQUEST['quantity']>$_REQUEST['ori_quantity']) && self::_error('Request quantity can\'t be larger than '.$_REQUEST['ori_quantity']);

		if($action!='transfer' && $action!='returns' && !empty($id) && $id>0) {
			$this->dao->find($id);
		}
		else{
			$this->dao->code = $_REQUEST['code'];
			$this->dao->action = $action;
			$this->dao->staff_id = $_SESSION[C('USER_AUTH_KEY')];
			$this->dao->create_time = date("Y-m-d H:i:s");
		}
		$this->dao->product_id = $_REQUEST['product_id'];
		$this->dao->quantity = $_REQUEST['quantity'];
		$this->dao->remark = $_REQUEST['remark'];
		if($action!='transfer' && $action!='returns' && !empty($id) && $id>0) {
			if(false !== $this->dao->save()){
				self::_success('Product information updated!',__URL__.'/'.$action);
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
					self::_success('Transfer success!',__URL__.'/'.$action);
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
}
?>