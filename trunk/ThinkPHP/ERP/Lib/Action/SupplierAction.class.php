<?php
/**
*
* 供应商
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class SupplierAction extends BaseAction{

	protected $dao;

	public function _initialize() {
		$this->dao = D('Supplier');
		parent::_initialize();
	}

	public function index(){
		if(!empty($_POST['Search'])) {
			$where = array();
			if(!empty($_REQUEST['s_name'])) {
				$where['name'] = array('like', '%'.trim($_REQUEST['s_name']).'%');
			}
			elseif(!empty($_REQUEST['s_code'])) {
				$where['code'] = array('like', '%'.trim($_REQUEST['s_code']));
			}
			$this->assign('result', $this->dao->where($where)->select());
		}
		$this->assign('content','Supplier:index');
		$this->display('Layout:ERP_layout');
	}

	public function form() {
		$s_id = $_REQUEST['id'];
		if(!empty($s_id) && $s_id>0) {
			$supplier = $this->dao->find($s_id);
			$s_code = $rs['code'];
		}
		else{
			$supplier = array(
				'id'=>0,
				'name'=>'',
				'characters'=>'',
				'address'=>'',
				'contact'=>'',
				'postcode'=>'',
				'telephone'=>'',
				'cellphone'=>'',
				'fax'=>'',
				'email'=>'',
				'bank'=>'',
				'account'=>'',
				'payment_terms'=>'',
				'tax'=>'',
				'currency'=>'',
				'website'=>'',
				'remark'=>''
				);
			$max_id = $this->dao->getField('max(id) as max_id');
			empty($max_id) && ($max_id = 0);
			$s_code = 'S'.sprintf("%05d",$max_id+1);
		}
		$dOptions = D('Options');
		$rs = $dOptions->where(array('name'=>'character'))->order('sort')->select();
		$this->assign('s_code', $s_code);
		$this->assign('supplier', $supplier);
		$this->assign('content', 'Supplier:form');
		$this->display('Layout:ERP_layout');
	}
	public function submit() {
		if(empty($_POST['submit'])) {
			return;
		}
		$s_id = $_REQUEST['s_id'];
		$name = trim($_REQUEST['name']);
		empty($name) && self::_error('Supplier Name required');
		if(!empty($s_id) && $s_id>0) {
			$rs = $this->dao->where(array('name'=>$name,'id'=>array('neq',$s_id)))->find();
			if($rs && sizeof($rs)>0){
				self::_error('Supplier Name: '.$name.' exists already!');
			}
			$this->dao->find($s_id);
		}
		else{
			$rs = $this->dao->where(array('name'=>$name))->find();
			if($rs && sizeof($rs)>0){
				self::_error('Supplier Name: '.$name.' exists already!');
			}
			$this->dao->code = $_REQUEST['code'];
		}
		$this->dao->name = $name;
		$this->dao->characters = $_REQUEST['character'];
		$this->dao->address = $_REQUEST['address'];
		$this->dao->contact = $_REQUEST['contact'];
		$this->dao->postcode = $_REQUEST['postcode'];
		$this->dao->telephone = $_REQUEST['telephone'];
		$this->dao->cellphone = $_REQUEST['cellphone'];
		$this->dao->fax = $_REQUEST['fax'];
		$this->dao->email = $_REQUEST['email'];
		$this->dao->bank = $_REQUEST['bank'];
		$this->dao->account = $_REQUEST['account'];
		$this->dao->payment_terms = $_REQUEST['payment_terms'];
		$this->dao->tax = $_REQUEST['tax'];
		$this->dao->currency = $_REQUEST['curr_code'];
		$this->dao->website = $_REQUEST['website'];
		$this->dao->remark = $_REQUEST['remark'];
		if(!empty($s_id) && $s_id>0) {
			if($this->dao->save()){
				self::_success('Supplier information updated!',__URL__);
			}
			else{
				self::_error('Update fail!'.$this->dao->getLastSql());
			}
		}
		else{
			if($this->dao->add()) {
				self::_success('Add supplier success!',__URL__);
			}
			else{
				self::_error('Add supplier fail!'.$this->dao->getLastSql());
			}
		}
		
	}
}
?>