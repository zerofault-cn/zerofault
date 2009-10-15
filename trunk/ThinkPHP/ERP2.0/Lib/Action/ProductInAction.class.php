<?php
/**
*
* 入库，退库
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
		$this->assign('result', $this->dao->relation(true)->where(array('source'=>'Supplier','destination'=>'Storage'))->select());
		$this->assign('content','ProductIn:index');
		$this->display('Layout:ERP_layout');
	}
	public function returns() {
		$this->assign('result', $this->dao->relation(true)->where(array('source'=>'Storage','destination'=>'Supplier'))->select());
		$this->assign('content','ProductIn:returns');
		$this->display('Layout:ERP_layout');
	}
	public function form() {
		$id = $_REQUEST['id'];
		$action = $_REQUEST['action'];
		if(!empty($id) && $id>0) {
			$info = $this->dao->relation(true)->find($id);
			$info['commodity'] = M('Commodity')->where("id=".$info['product']['commodity_id'])->getField('name');
			$info['unit'] = M('Options')->where("id=".$info['product']['unit_id'])->getField('title');
			
			$info['currency_opts'] = self::genOptions(M('Options')->where(array('type'=>'currency'))->order('sort')->select(), $info['currency_id'], 'title');
			$code = 'B'.substr($info['code'],1);
		}
		else{
			$info = array(
				'product_opts' => self::genOptions(D('Product')->select(),'','MPN'),
				'supplier_opts' => self::genOptions(D('Supplier')->select(),'','name'),
				'currency_opts' => self::genOptions(M('Options')->where(array('type'=>'currency'))->order('sort')->select(), '', 'title'),
				'unit_opts' => self::genOptions(M('Options')->where(array('type'=>'unit'))->order('sort')->select(), '', 'title')
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
	public function confirm() {
		if(empty($_POST['submit'])) {
			return;
		}
		empty($_POST['chk']) && self::_error('You hadn\'t got any item selected');
		if($this->dao->where("id in (".implode(',',$_POST['chk']).")")->setField(array('confirm_time','confirm_staff_id'),array(date("Y-m-d H:i:s"),$_SESSION[C('USER_AUTH_KEY')]))) {
			self::_success('Confirm success','',1000);
		}
		else{
			self::_error('Something wrong!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
		}
	}

	public function submit() {
		if(empty($_POST['submit'])) {
			return;
		}
		$id = $_REQUEST['id'];
		$action = $_REQUEST['action'];
		empty($_REQUEST['product_id']) && self::_error('Select a product first!');
		if($action!='return' && !empty($id) && $id>0) {
			$this->dao->find($id);
		}
		else{
			$this->dao->code = $_REQUEST['code'];
			if($action=='return') {
				$this->dao->source = 'Storage';
				$this->dao->destination = 'Supplier';
			}
			else{
				$this->dao->source = 'Supplier';
				$this->dao->destination = 'Storage';
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
}
?>