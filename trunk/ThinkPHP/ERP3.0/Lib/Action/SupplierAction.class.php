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
		session('top', 'Basic Data');
		session('sub', MODULE_NAME);
		$this->dao = D('Supplier');
		parent::_initialize();
		$this->assign('MODULE_TITLE', 'Supplier');
	}

	public function index(){
		$this->assign('ACTION_TITLE', 'List');
		$this->assign('result', $this->dao->relation(true)->order('id')->select());
		$this->display();
	}

	public function form() {
		$this->assign('ACTION_TITLE', 'Add New Supplier');
		$dOptions = M('Options');
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		if ($id>0) {
			$this->assign('ACTION_TITLE', 'Edit Supplier');
			$info = $this->dao->find($id);
			$info['character_opts'] = self::genOptions($dOptions->where(array('type'=>'character'))->order('sort')->select(), $info['character_id']);
			$info['payment_opts'] = self::genOptions($dOptions->where(array('type'=>'payment_terms'))->order('sort')->select(), $info['payment_terms_id']);
			$info['tax_opts'] = self::genOptions($dOptions->where(array('type'=>'tax'))->order('sort')->select(), $info['tax_id']);
			$info['currency_opts'] = self::genOptions($dOptions->where(array('type'=>'currency'))->order('sort')->select(), $info['currency_id']);
			$code = $info['code'];
		}
		else{
			$info = array(
				'id'=>0,
				'name'=>'',
				'character_opts' => self::genOptions($dOptions->where(array('type'=>'character'))->order('sort')->select()),
				'address'=>'',
				'contact'=>'',
				'postcode'=>'',
				'telephone'=>'',
				'cellphone'=>'',
				'fax'=>'',
				'email'=>'',
				'bank'=>'',
				'account'=>'',
				'payment_opts' => self::genOptions($dOptions->where(array('type'=>'payment_terms'))->order('sort')->select()),
				'tax_opts' => self::genOptions($dOptions->where(array('type'=>'tax'))->order('sort')->select()),
				'currency_opts' => self::genOptions($dOptions->where(array('type'=>'currency'))->order('sort')->select()),
				'website'=>'',
				'remark'=>''
				);
			$max_id = $this->dao->getField('max(id) as max_id');
			empty($max_id) && ($max_id = 0);
			$code = 'S'.sprintf("%05d", $max_id + 1);
		}
		$this->assign('code', $code);
		$this->assign('info', $info);
		$this->display();
	}
	public function submit() {
		if(empty($_POST['submit'])) {
			return;
		}
		$name = trim($_REQUEST['name']);
		!$name && self::_error('Supplier Name required');
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		if ($id>0) {
			$rs = $this->dao->where(array('name'=>$name,'id'=>array('neq',$id)))->find();
			if($rs && sizeof($rs)>0){
				self::_error('Supplier Name: '.$name.' exists already!');
			}
			$this->dao->find($id);
		}
		else {
			$rs = $this->dao->where(array('name'=>$name))->find();
			if($rs && sizeof($rs)>0){
				self::_error('Supplier Name: '.$name.' exists already!');
			}
			$max_id = $this->dao->getField('max(id) as max_id');
			empty($max_id) && ($max_id = 0);
			$code = 'S'.sprintf("%05d", $max_id + 1);
			$this->dao->code = $code;
		}
		$this->dao->name = $name;
		$this->dao->character_id = $_REQUEST['character_id'];
		$this->dao->address = $_REQUEST['address'];
		$this->dao->contact = $_REQUEST['contact'];
		$this->dao->postcode = $_REQUEST['postcode'];
		$this->dao->telephone = $_REQUEST['telephone'];
		$this->dao->cellphone = $_REQUEST['cellphone'];
		$this->dao->fax = $_REQUEST['fax'];
		$this->dao->email = $_REQUEST['email'];
		$this->dao->bank = $_REQUEST['bank'];
		$this->dao->account = $_REQUEST['account'];
		$this->dao->payment_terms_id = $_REQUEST['payment_terms_id'];
		$this->dao->tax_id = $_REQUEST['tax_id'];
		$this->dao->currency_id = $_REQUEST['currency_id'];
		$this->dao->website = $_REQUEST['website'];
		$this->dao->remark = $_REQUEST['remark'];
		if ($id>0) {
			if(false !== $this->dao->save()){
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
				self::_error('Add supplier fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
	}
	public function delete() {
		//判断是否已被使用
		$id = $_REQUEST['id'];
		$rs = M('ProductFlow')->where(array('supplier_id'=>$id))->select();
		if(!empty($rs) && sizeof($rs)>0) {
			self::_error('It\'s in use, can\'t be deleted!');
		}
		else{
			self::_delete();
		}
	}
}
?>