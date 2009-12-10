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

	public function index() {
		$rs = M('Options')->where(array('type'=>'unit'))->order('sort')->select();
		$unit = array();
		foreach($rs as $i=>$item) {
			$unit[$item['id']] = $item['name'];
		}
		$this->assign('unit', $unit);

		if(isset($_REQUEST['status'])) {
			$status = $_REQUEST['status'];
		}
		elseif(''!=(Session::get('staff_status'))) {
			$status = Session::get('staff_status');
		}
		else{
			$status = 0;
		}
		Session::set('staff_status', $atatus);
		$this->assign('status', $status);
		
		$where = array(
			'action'=>'enter',
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
	public function returns() {
		Session::set('action', '');
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
		elseif(''!=(Session::get('staff_status'))) {
			$status = Session::get('staff_status');
		}
		else{
			$status = 0;
		}
		Session::set('staff_status', $atatus);
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
	public function confirm() {
		if(empty($_POST['submit'])) {
			return;
		}
		$action = $_REQUEST['action'];
		empty($_POST['chk']) && self::_error('You haven\'t select any item!');
		$rs = false;
		foreach ($_POST['chk'] as $id) {
			$info = $this->dao->find($id);
			$where = array(
				'location_id' => 1,
				'product_id'  => $info['product_id']
			);
			if ('return'!=$action) {
				$lp_id = M('LocationProduct')->where($where)->getField('id');
				//dump($lp_id);
				//exit;
				if(!empty($lp_id)) {
					M('LocationProduct')->setInc('chg_quantity','id='.$lp_id,$info['quantity']); 
				}
				else {
					M('LocationProduct')->location_id = 1;
					M('LocationProduct')->product_id = $info['product_id'];
					M('LocationProduct')->ori_quantity = 0;
					M('LocationProduct')->chg_quantity = $info['quantity'];
					M('LocationProduct')->add();
				}
				
			}
			else {//return action
				$lp_id = M('LocationProduct')->where($where)->getField('id');
				if(!empty($lp_id)) {
					M('LocationProduct')->setDec('chg_quantity','id='.$lp_id,$info['quantity']); 
				}
				else {
					M('LocationProduct')->location_id = 1;
					M('LocationProduct')->product_id = $info['product_id'];
					M('LocationProduct')->ori_quantity = 0;
					M('LocationProduct')->chg_quantity = 0-$info['quantity'];
					M('LocationProduct')->add();
				}
			}
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
		Session::set('action', 'form');
		$id = $_REQUEST['id'];
		$action = $_REQUEST['action'];
		if(!empty($id) && $id>0) {
			$info = $this->dao->relation(true)->find($id);
			$info['category'] = M('Category')->where("id=".$info['product']['category_id'])->getField('name');
			$info['unit'] = M('Options')->where("id=".$info['product']['unit_id'])->getField('name');
			$info['supplier_opts'] = self::genOptions(D('Supplier')->select(), $info['supplier_id']);
			$info['currency_opts'] = self::genOptions(M('Options')->where(array('type'=>'currency'))->order('sort')->select(), $info['currency_id']);
			$code = 'B'.substr($info['code'],1);
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
			$code = 'A'.sprintf("%09d",$max_id+1);
		}
		$this->assign('id', $id);
		$this->assign('action', $action);
		$this->assign('code', $code);

		$this->assign('info', $info);
		$this->assign('ProductList', D('Product')->relation(true)->select());
		$this->assign('content', 'ProductIn:form');
		$this->display('Layout:ERP_layout');
	}
	public function submit() {
		if(empty($_POST['submit'])) {
			return;
		}
		$id = $_REQUEST['id'];
		$action = $_REQUEST['action'];
		empty($_REQUEST['product_id']) && self::_error('Please select a component/board first!');
		empty($_REQUEST['quantity']) && self::_error('Quantity number required!');
		empty($_REQUEST['price']) && self::_error('Price value required!');
		($_REQUEST['quantity']<0) && self::_error('Quantity number must be positive!');
		('return'==$action) && ($_REQUEST['quantity']>$_REQUEST['ori_quantity']) && self::_error('Return quantity can\'t be larger than '.$_REQUEST['ori_quantity']);

		if($action!='return' && !empty($id) && $id>0) {
			$this->dao->find($id);
		}
		else{
			$this->dao->code = $_REQUEST['code'];
			if($action=='return') {
				$this->dao->action = 'return';
			}
			else{
				$this->dao->action = 'enter';
			}
			$this->dao->staff_id = $_SESSION[C('USER_AUTH_KEY')];
			$this->dao->create_time = date("Y-m-d H:i:s");
		}
		$this->dao->product_id = $_REQUEST['product_id'];
		$this->dao->supplier_id = $_REQUEST['supplier_id'];
		$this->dao->project = $_REQUEST['project'];
		$this->dao->currency_id = $_REQUEST['currency_id'];
		$this->dao->quantity = $_REQUEST['quantity'];
		$this->dao->price = $_REQUEST['price'];
		$this->dao->Lot = '';
		$this->dao->accessories = $_REQUEST['accessories'];
		$this->dao->remark = $_REQUEST['remark'];
		if($action!='return' && !empty($id) && $id>0) {
			if(false !== $this->dao->save()){
				self::_success('Product information updated!',__URL__);
			}
			else{
				self::_error('Update fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		else{
			if($this->dao->add()) {
				if($action=='return') {
					self::_success('Product ready for return !',__URL__.'/returns');
				}
				else{
					self::_success('Add product data success!',__URL__);
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
	public function delete() {
		self::_delete();
	}
}
?>