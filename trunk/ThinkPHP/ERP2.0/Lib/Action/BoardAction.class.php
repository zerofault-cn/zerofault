<?php
/**
*
* 板子资料
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class BoardAction extends BaseAction{

	protected $dao;

	public function _initialize() {
		$this->dao = D('Product');
		parent::_initialize();
	}

	public function index(){
		$this->assign('result', $this->dao->relation(true)->select());
		$this->assign('content','Product:index');
		$this->display('Layout:ERP_layout');
	}
	public function form() {
		$id = $_REQUEST['id'];
		if(!empty($id) && $id>0) {
			$info = $this->dao->find($id);
			$info['category_opts'] = self::genOptions(M('Category')->select(),$info['category_id'],'name');
			$info['currency_opts'] = self::genOptions(M('Options')->where(array('type'=>'currency'))->order('sort')->select(), $info['currency_id']);
			$info['unit_opts'] = self::genOptions(M('Options')->where(array('type'=>'unit'))->order('sort')->select(), $info['unit_id']);
			$code = $info['code'];
		}
		else{
			$info = array(
				'id'=>0,
				'category_opts' => self::genOptions(M('Category')->select()),
				'currency_opts' => self::genOptions(M('Options')->where(array('type'=>'currency'))->order('sort')->select()),
				'unit_opts' => self::genOptions(M('Options')->where(array('type'=>'unit'))->order('sort')->select())
				);
			$max_id = $this->dao->getField('max(id) as max_id');
			empty($max_id) && ($max_id = 0);
			$code = 'C'.sprintf("%09d",$max_id+1);
		}
		$this->assign('code', $code);
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
				self::_error('Internal PN: '.$PN.' has been used by another component!');
			}
			$this->dao->find($id);
		}
		else{
			$rs = $this->dao->where(array('Internal_PN'=>$PN))->find();
			if($rs && sizeof($rs)>0){
				self::_error('Internal PN: '.$PN.' has been used by another component!');
			}
			$this->dao->code = $_REQUEST['code'];
		}
		$this->dao->Internal_PN = $PN;
		$this->dao->description = $_REQUEST['description'];
		$this->dao->manufacture = $_REQUEST['manufacture'];
		$this->dao->MPN = $_REQUEST['MPN'];
		$this->dao->value = $_REQUEST['value'];
		$this->dao->category_id = $_REQUEST['category_id'];
		$this->dao->unit_id = $_REQUEST['unit_id'];
		$this->dao->RoHS = $_REQUEST['Rohs'];
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
				self::_success('Component information updated!',__URL__);
			}
			else{
				self::_error('Update fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		else{
			if($this->dao->add()) {
				self::_success('Add component data success!',__URL__);
			}
			else{
				self::_error('Add component data fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		
	}
}
?>