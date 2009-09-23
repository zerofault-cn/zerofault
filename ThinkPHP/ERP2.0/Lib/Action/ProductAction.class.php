<?php
/**
*
* 货品资料
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class ProductAction extends BaseAction{

	protected $dao;

	public function _initialize() {
		$this->dao = D('Product');
		parent::_initialize();
	}
	/**
	*
	* 节点列表
	*/
	public function index(){
		$this->assign('result', $this->dao->relation(true)->select());
		$this->assign('content','Product:index');
		$this->display('Layout:ERP_layout');
	}
	public function form() {
		$id = $_REQUEST['id'];
		if(!empty($id) && $id>0) {
			$info = $this->dao->find($id);
			$info['supplier_opts'] = self::genOptions(D('Supplier')->select(),$info['supplier_id'],'name');
			$info['commodity_opts'] = self::genOptions(M('Commodity')->select(),$info['commodity_id'],'name');
			$info['currency_opts'] = self::genOptions(M('Options')->where(array('type'=>'currency'))->order('sort')->select(), $info['currency_id'], 'title');
		}
		else{
			$info = array(
				'id'=>0,
				'supplier_opts' => self::genOptions(D('Supplier')->select(),'','name'),
				'commodity_opts' => self::genOptions(M('Commodity')->select(),'','name'),
				'currency_opts' => self::genOptions(M('Options')->where(array('type'=>'currency'))->order('sort')->select(), '', 'title')
				);
		}
		$this->assign('info', $info);
		$this->assign('content', 'Product:form');
		$this->display('Layout:ERP_layout');
	}

	public function submit() {
		if(empty($_POST['submit'])) {
			return;
		}
		$id = $_REQUEST['id'];
		$PN = trim($_REQUEST['PN']);
		empty($PN) && self::_error('Internal PN required');
		if(!empty($id) && $id>0) {
			$rs = $this->dao->where(array('Internal_PN'=>$PN,'id'=>array('neq',$id)))->find();
			if($rs && sizeof($rs)>0){
				self::_error('Internal PN: '.$PN.' has been used by another product!');
			}
			$this->dao->find($id);
		}
		else{
			$rs = $this->dao->where(array('Internal_PN'=>$PN))->find();
			if($rs && sizeof($rs)>0){
				self::_error('Internal PN: '.$PN.' has been used by another product!');
			}
		}
		$this->dao->Internal_PN = $PN;
		$this->dao->description = $_REQUEST['description'];
		$this->dao->manufacture = $_REQUEST['manufacture'];
		$this->dao->MPN = $_REQUEST['MPN'];
		$this->dao->supplier_id = $_REQUEST['supplier_id'];
		$this->dao->value = $_REQUEST['value'];
		$this->dao->commodity_id = $_REQUEST['commodity_id'];
		$this->dao->unit = $_REQUEST['unit'];
		$this->dao->Rohs = $_REQUEST['Rohs'];
		$this->dao->LT_days = $_REQUEST['LT_days'];
		$this->dao->MOQ = $_REQUEST['MOQ'];
		$this->dao->SPQ = $_REQUEST['SPQ'];
		$this->dao->MSL = $_REQUEST['MSL'];
		$this->dao->project = $_REQUEST['project'];
		$this->dao->inventory_limit = $_REQUEST['inventory_limit'];
		$this->dao->currency_id = $_REQUEST['currency_id'];
		$this->dao->price = $_REQUEST['price'];
		$this->dao->accessories = $_REQUEST['accessories'];
		$this->dao->attachment = '';
		$file = $_FILES['attachment'];
		if($file['size']>0) {
			$file_path = 'Attach/Product/';
			$file_name = $PN.'.'.pathinfo($file['name'], PATHINFO_EXTENSION);
			if(!move_uploaded_file($file['tmp_name'], $file_path.$file_name)) {
				self::_error('Attachment upload fail!');
			}
			$this->dao->attachment = $file_path.$file_name;
		}
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
				self::_error('Add product data fail!'.(C('DEBUG_MODE')?$this->dao->getLastSql():''));
			}
		}
		
	}
}
?>