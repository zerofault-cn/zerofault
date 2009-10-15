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
		$this->assign('result', $this->dao->relation(true)->select());
		$this->assign('content','Supplier:index');
		$this->display('Layout:ERP_layout');
	}

	public function form() {
		$dOptions = M('Options');
		$id = $_REQUEST['id'];
		if(!empty($id) && $id>0) {
			$info = $this->dao->find($id);
			$info['character_opts'] = self::genOptions($dOptions->where(array('type'=>'character'))->order('sort')->select(), $info['character_id'], 'title', 'id');
			$info['payment_opts'] = self::genOptions($dOptions->where(array('type'=>'payment_terms'))->order('sort')->select(), $info['payment_terms_id'], 'title', 'id');
			$info['tax_opts'] = self::genOptions($dOptions->where(array('type'=>'tax'))->order('sort')->select(), $info['tax_id'], 'title', 'id');
			$info['currency_opts'] = self::genOptions($dOptions->where(array('type'=>'currency'))->order('sort')->select(), $info['currency_id'], 'title', 'id');
			$code = $info['code'];
		}
		else{
			$info = array(
				'id'=>0,
				'name'=>'',
				'character_opts' => self::genOptions($dOptions->where(array('type'=>'character'))->order('sort')->select(), '', 'title', 'id'),
				'address'=>'',
				'contact'=>'',
				'postcode'=>'',
				'telephone'=>'',
				'cellphone'=>'',
				'fax'=>'',
				'email'=>'',
				'bank'=>'',
				'account'=>'',
				'payment_opts' => self::genOptions($dOptions->where(array('type'=>'payment_terms'))->order('sort')->select(), '', 'title', 'id'),
				'tax_opts' => self::genOptions($dOptions->where(array('type'=>'tax'))->order('sort')->select(), '', 'title', 'id'),
				'currency_opts' => self::genOptions($dOptions->where(array('type'=>'currency'))->order('sort')->select(), '', 'title', 'value'),
				'website'=>'',
				'remark'=>''
				);
			$max_id = $this->dao->getField('max(id) as max_id');
			empty($max_id) && ($max_id = 0);
			$code = 'S'.sprintf("%05d",$max_id+1);
		}
		$this->assign('code', $code);
		$this->assign('info', $info);
		$this->assign('content', 'Supplier:form');
		$this->display('Layout:ERP_layout');
	}
	public function submit() {
		if(empty($_POST['submit'])) {
			return;
		}
		$id = $_REQUEST['id'];
		$name = trim($_REQUEST['name']);
		empty($name) && self::_error('Supplier Name required');
		if(!empty($id) && $id>0) {
			$rs = $this->dao->where(array('name'=>$name,'id'=>array('neq',$id)))->find();
			if($rs && sizeof($rs)>0){
				self::_error('Supplier Name: '.$name.' exists already!');
			}
			$this->dao->find($id);
		}
		else{
			$rs = $this->dao->where(array('name'=>$name))->find();
			if($rs && sizeof($rs)>0){
				self::_error('Supplier Name: '.$name.' exists already!');
			}
			$this->dao->code = $_REQUEST['code'];
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
		if(!empty($id) && $id>0) {
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
}
?>