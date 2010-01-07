<?php
/**
*
* 入库，退货
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class ProductInAction extends BaseAction{

	protected $dao;

	public function _initialize() {
		$this->dao = D('ProductFlow');
		parent::_initialize();
	}
	Public function fixed() {
		$this->index(1);
	}
	Public function floating() {
		$this->index(0);
	}
	public function index($fixed=1) {
		$rs = M('Options')->where(array('type'=>'unit'))->order('sort')->select();
		$unit = array();
		foreach($rs as $i=>$item) {
			$unit[$item['id']] = $item['name'];
		}
		$this->assign('unit', $unit);

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
			'fixed' => $fixed,
			'action'=>'enter',
			'status'=> $status
			);
		$count = $this->dao->where($where)->getField('count(*)');
		import("@.Paginator");
		$limit = 10;
		$p = new Paginator($count,$limit);

		$order = 'id desc';
		$result = array();
		foreach($this->dao->relation(true)->where($where)->order($order)->limit($p->offset.','.$p->limit)->select() as $item) {
			$item['returned_quantity'] = $this->dao->where(array('code'=>'R'.substr($item['code'],-9),'status'=>1))->sum('quantity');
			empty($item['returned_quantity']) && ($item['returned_quantity']=0);
			$result[] = $item;
		}
		$this->assign('result', $result);
		$this->assign('page', $p->showMultiNavi());
		$this->assign('content','ProductIn:index');
		$this->display('Layout:ERP_layout');
	}
	public function returns() {
		//Session::set('action', '');
		$this->assign('action', 'return');

		$rs = M('Options')->where(array('type'=>'unit'))->order('sort')->select();
		$unit = array();
		foreach($rs as $i=>$item) {
			$unit[$item['id']] = $item['name'];
		}
		$this->assign('unit', $unit);

		if(isset($_REQUEST['status'])) {
			$status = $_REQUEST['status'];
		}
		elseif(''!=(Session::get('return_status'))) {
			$status = Session::get('return_status');
		}
		else{
			$status = 0;
		}
		Session::set('return_status', $atatus);
		$this->assign('status', $status);

		$where = array(
			'action'=>'return',
			'status'=> $status
			);
		$count = $this->dao->where($where)->getField('count(*)');
		import("@.Paginator");
		$limit = 10;
		$p = new Paginator($count,$limit);

		$order = 'id desc';
		$this->assign('result', $this->dao->relation(true)->where($where)->order($order)->limit($p->offset.','.$p->limit)->select());
		$this->assign('page', $p->showMultiNavi());
		$this->assign('content','ProductIn:index');
		$this->display('Layout:ERP_layout');
	}
	public function form() {
		//Session::set('action', 'form');
		$id = $_REQUEST['id'];
		$fixed = $_REQUEST['fixed'];
		$action = $_REQUEST['action'];
		if(!empty($id) && $id>0) {
			$info = $this->dao->relation(true)->find($id);
			$info['category'] = M('Category')->where("id=".$info['product']['category_id'])->getField('name');
			$info['unit'] = M('Options')->where("id=".$info['product']['unit_id'])->getField('name');
			$info['supplier_opts'] = self::genOptions(D('Supplier')->select(), $info['supplier_id']);
			$info['currency_opts'] = self::genOptions(M('Options')->where(array('type'=>'currency'))->order('sort')->select(), $info['currency_id']);
			if ('return'==$action) {//new return
				$code = 'R'.substr($info['code'],-9);
				$info['quantity'] = $info['ori_quantity'] = M("LocationProduct")->where(array('type'=>'location', 'location_id'=>1, 'product_id'=>$info['product_id']))->getField('`ori_quantity`+`chg_quantity`');
				$id = 0;
			}
			elseif ('return'==$info['action']) {//edit return
				$code = $info['code'];
				$action = $info['action'];
				$info['ori_quantity'] =  M("LocationProduct")->where(array('type'=>'location', 'location_id'=>1, 'product_id'=>$info['product_id']))->getField('`ori_quantity`+`chg_quantity`');
			}
			else {//edit enter
				$code = $info['code'];
			}
		}
		else{//new enter
			$info = array(
				'supplier_opts' => self::genOptions(D('Supplier')->select()),
				'currency_opts' => self::genOptions(M('Options')->where(array('type'=>'currency'))->order('sort')->select()),
			);
			$max_code = $this->dao->where(array('action'=>'enter'))->max('code');
			empty($max_code) && ($max_code = 'A'.sprintf("%09d",0));
			$code = ++ $max_code;
		}
		$this->assign('id', $id);
		$this->assign('action', $action);
		$this->assign('fixed', $fixed);
		$this->assign('code', $code);

		$this->assign('info', $info);
		$this->assign('content', 'ProductIn:form');
		$this->display('Layout:ERP_layout');
	}
	public function submit() {
		if(empty($_POST['submit'])) {
			return;
		}
		$id = $_REQUEST['id'];
		$fixed = $_REQUEST['fixed'];
		$action = $_REQUEST['action'];
		empty($_REQUEST['product_id']) && self::_error('Please select a component/board first!');
		empty($_REQUEST['supplier_id']) && self::_error('Please select the supplier!');
		empty($_REQUEST['currency_id']) && self::_error('Please select the currency type!');
		empty($_REQUEST['quantity']) && self::_error('Quantity number required!');
		//empty($_REQUEST['price']) && self::_error('Price value required!');

		($_REQUEST['quantity']<0) && self::_error('Quantity number must be larger than 0!');
		('return'==$action) && ($_REQUEST['quantity']>$_REQUEST['ori_quantity']) && self::_error('Return quantity can\'t be larger than '.$_REQUEST['ori_quantity']);

		if(!empty($id) && $id>0) {//from edit
			$this->dao->find($id);
		}
		else{//from new
			if($action=='return') {
				$this->dao->code = $_REQUEST['code'];
				$this->dao->action = 'return';
				$this->dao->from_type = 'location';
				$this->dao->from_id = 1;
			}
			else{
				$max_code = $this->dao->where(array('action'=>'enter'))->max('code');
				empty($max_code) && ($max_code = 'A'.sprintf("%09d",0));
				$code = ++ $max_code;
				$this->dao->code = $code;
				$this->dao->action = 'enter';
				$this->dao->to_type = 'location';
				$this->dao->to_id = 1;
			}
			$this->dao->fixed = $fixed;
			$this->dao->staff_id = $_SESSION[C('USER_AUTH_KEY')];
			$this->dao->create_time = date("Y-m-d H:i:s");
		}
		$this->dao->product_id = $_REQUEST['product_id'];
		$this->dao->supplier_id = $_REQUEST['supplier_id'];
		$this->dao->currency_id = $_REQUEST['currency_id'];
		$this->dao->quantity = $_REQUEST['quantity'];
		$this->dao->price = $_REQUEST['price'];
		$this->dao->Lot = '';
		$this->dao->accessories = $_REQUEST['accessories'];
		$this->dao->remark = $_REQUEST['remark'];
		if(!empty($id) && $id>0) {
			if(false !== $this->dao->save()){
				self::_success('Product information updated!',__URL__.('return'==$this->dao->action?'/returns':''));
			}
			else{
				self::_error('Update fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		else{
			if($this->dao->add()) {
				if($action=='return') {
					self::_success('Product ready for return!',__URL__.'/returns');
				}
				else{
					self::_success('Product ready for entering!', __URL__ . ($fixed ? '/fixed' : '/floating'));
				}
			}
			else{
				if($action=='return') {
					self::_error('Product return fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
				}
				else{
					self::_error('Product entering fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
				}
			}
		}
	}
	public function confirm() {
		if(empty($_POST['submit'])) {
			return;
		}
		empty($_POST['chk']) && self::_error('You haven\'t select any item!');
		foreach ($_POST['chk'] as $id) {
			$info = $this->dao->find($id);
			$where = array(
				'type' => 'location',
				'location_id' => 1,
				'product_id'  => $info['product_id']
			);
			if ('return'!=$info['action']) {
				$lp_id = M('LocationProduct')->where($where)->getField('id');
				if(!empty($lp_id)) {
					if (!M('LocationProduct')->setInc('chg_quantity','id='.$lp_id,$info['quantity'])) {
						self::_error('Update location product fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
					}
				}
				else {
					M('LocationProduct')->type = 'location';
					M('LocationProduct')->location_id = 1;
					M('LocationProduct')->product_id = $info['product_id'];
					M('LocationProduct')->ori_quantity = 0;
					M('LocationProduct')->chg_quantity = $info['quantity'];
					if (!M('LocationProduct')->add()) {
						self::_error('Insert location product fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
					}
				}

			}
			else {//return action
				$lp_id = M('LocationProduct')->where($where)->getField('id');
				if(!empty($lp_id)) {
					if (!M('LocationProduct')->setDec('chg_quantity','id='.$lp_id,$info['quantity'])) {
						self::_error('Update location product fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
					}
				}
				else {
					M('LocationProduct')->type = 'location';
					M('LocationProduct')->location_id = 1;
					M('LocationProduct')->product_id = $info['product_id'];
					M('LocationProduct')->ori_quantity = 0;
					M('LocationProduct')->chg_quantity = 0-$info['quantity'];
					if (!M('LocationProduct')->add()) {
						self::_error('Insert location product fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
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