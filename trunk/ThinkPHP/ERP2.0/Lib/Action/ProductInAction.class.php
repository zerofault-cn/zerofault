<?php
/**
*
* 入库
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
	/**
	*
	* 节点列表
	*/
	public function index(){
		$this->assign('result', $this->dao->relation(true)->select());
		$this->assign('content','ProductIn:index');
		$this->display('Layout:ERP_layout');
	}
	public function form() {
		$id = $_REQUEST['id'];
		if(!empty($id) && $id>0) {
			$info = $this->dao->relation(true)->find($id);
			$info['product_opts'] = self::genOptions(D('Product')->select(),$info['product_id'],'MPN');
			$info['supplier_opts'] = self::genOptions(D('Supplier')->select(),$info['supplier_id'],'name');
			$info['currency_opts'] = self::genOptions(M('Options')->where(array('type'=>'currency'))->order('sort')->select(), $info['currency_id'], 'title');
			$info['unit_opts'] = self::genOptions(M('Options')->where(array('type'=>'unit'))->order('sort')->select(), $info['unit_id'], 'title');
			$code = $info['code'];
		}
		else{
			$info = array(
				'id'=>0,
				'product_opts' => self::genOptions(D('Product')->select(),'','MPN'),
				'supplier_opts' => self::genOptions(D('Supplier')->select(),'','name'),
				'currency_opts' => self::genOptions(M('Options')->where(array('type'=>'currency'))->order('sort')->select(), '', 'title'),
				'unit_opts' => self::genOptions(M('Options')->where(array('type'=>'unit'))->order('sort')->select(), '', 'title')
			);
			$max_id = $this->dao->getField('max(id) as max_id');
			empty($max_id) && ($max_id = 0);
			$code = 'A'.sprintf("%09d",$max_id+1);
		}
		$this->assign('code', $code);
		$this->assign('info', $info);
		$this->assign('product', D('Product')->relation(true)->select());
		$this->assign('content', 'ProductIn:form');
		$this->display('Layout:ERP_layout');
	}

	public function submit() {
		if(empty($_POST['submit'])) {
			return;
		}
		$id = $_REQUEST['id'];
		empty($_REQUEST['product_id']) && self::_error('Select a product first!');
		if(!empty($id) && $id>0) {
			$this->dao->find($id);
		}
		else{
			$this->dao->code = $_REQUEST['code'];
			$this->dao->source = '';
			$this->dao->destination = '';
			$this->dao->staff_id = $_SESSION[C('USER_AUTH_KEY')];
			$this->dao->create_time = date("Y-m-d H:i:s");
		}
		$this->dao->product_id = $_REQUEST['product_id'];
		$this->dao->supplier_id = $_REQUEST['supplier_id'];
		$this->dao->project = $_REQUEST['project'];
		$this->dao->currency_id = $_REQUEST['currency_id'];
		$this->dao->unit_id = $_REQUEST['unit_id'];
		$this->dao->quantity = $_REQUEST['quantity'];
		$this->dao->price = $_REQUEST['price'];
		$this->dao->Lot = '';
		$this->dao->accessories = $_REQUEST['accessories'];
		$this->dao->remark = $_REQUEST['remark'];
		if(!empty($id) && $id>0) {
			if(false !== $this->dao->save()){
				self::_success('Product information updated!',__URL__);
			}
			else{
				self::_error('Update fail!'.(C('DEBUG_MODE')?$this->dao->getLastSql():''));
			}
		}
		else{
			if($this->dao->add()) {
				self::_success('Add product data success!',__URL__);
			}
			else{
				self::_error('Product entering fail!'.(C('DEBUG_MODE')?$this->dao->getLastSql():''));
			}
		}
		
	}
}
?>