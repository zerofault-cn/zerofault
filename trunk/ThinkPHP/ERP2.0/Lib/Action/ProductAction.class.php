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
		Session::set('top', 'Basic Data');
		Session::set('sub', MODULE_NAME);
		$this->dao = D('Product');
		parent::_initialize();
		$this->assign('MODULE_TITLE', 'Component');
	}

	public function index() {
		$this->assign('ACTION_TITLE', 'List');
		$this->assign('result', $this->dao->where(array('type'=>'Component','fixed'=>0))->relation(true)->order('id')->select());
		$this->assign('content','Product:index');
		$this->display('Layout:ERP_layout');
	}

	public function form() {
		$this->assign('ACTION_TITLE', 'Add New Component');
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		if ($id>0) {
			$this->assign('ACTION_TITLE', 'Edit Component');
			$info = $this->dao->find($id);
			$info['category_opts'] = self::genOptions(M('Category')->where(array('type'=>'Component'))->select(),$info['category_id'],'name');
			$info['currency_opts'] = self::genOptions(M('Options')->where(array('type'=>'currency'))->order('sort')->select(), $info['currency_id']);
			$info['unit_opts'] = self::genOptions(M('Options')->where(array('type'=>'unit'))->order('sort')->select(), $info['unit_id']);
			$code = $info['code'];
		}
		else{
			$info = array(
				'id' => 0,
				'fixed' => 0,
				'category_opts' => self::genOptions(M('Category')->where(array('type'=>'Component'))->select()),
				'currency_opts' => self::genOptions(M('Options')->where(array('type'=>'currency'))->order('sort')->select()),
				'unit_opts' => self::genOptions(M('Options')->where(array('type'=>'unit'))->order('sort')->select())
				);
			$max_code = $this->dao->where(array('type'=>'Component'))->max('code');
			empty($max_code) && ($max_code = 'C'.sprintf("%09d",0));
			$code = ++ $max_code;
		}
		$this->assign('code', $code);
		$this->assign('info', $info);
		$this->assign('MAX_FILE_SIZE', self::MAX_FILE_SIZE());
		$this->assign('upload_max_filesize', min(ini_get('memory_limit'), ini_get('post_max_size'), ini_get('upload_max_filesize')));
		$this->assign('content', 'Product:form');
		$this->display('Layout:ERP_layout');
	}

	public function submit() {
		if(empty($_POST['submit'])) {
			return;
		}
		$PN = trim($_REQUEST['PN']);
		!$PN && self::_error('Internal PN required');
		if ('1'==$_REQUEST['fixed'] && ''==trim($_REQUEST['description'])) {
			self::_error('description is required for Fixed-Assets');
		}
		empty($_REQUEST['category_id']) && self::_error('Category must be specified!');
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		if ($id>0) {
			$rs = $this->dao->where(array('Internal_PN'=>$PN,'id'=>array('neq',$id)))->find();
			if($rs && sizeof($rs)>0){
				self::_error('Internal PN: '.$PN.' has been used by another component!');
			}
			$this->dao->find($id);
		}
		else {
			$rs = $this->dao->where(array('Internal_PN'=>$PN))->find();
			if($rs && sizeof($rs)>0){
				self::_error('Internal PN: '.$PN.' has been used by another component!');
			}
			$max_code = $this->dao->where(array('type'=>'Component'))->max('code');
			empty($max_code) && ($max_code = 'C'.sprintf("%09d",0));
			$code = ++ $max_code;
			$this->dao->code = $code;
		}
		$this->dao->type = 'Component';
		$this->dao->fixed = $_REQUEST['fixed'];
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
		$file = $_FILES['attachment'];
		if($file['size']>0) {
			$file_path = 'Attach/Product/';
			$file_name = $this->dao->code.'.'.pathinfo($file['name'], PATHINFO_EXTENSION);
			if(!move_uploaded_file($file['tmp_name'], $file_path.$file_name)) {
				self::_error('Attachment upload fail!');
			}
			$this->dao->attachment = $file_path.$file_name;
		}
		$this->dao->remark = $_REQUEST['remark'];
		if ($id>0) {
			if(false !== $this->dao->save()){
				self::_success('Component information updated!',__URL__);
			}
			else{
				self::_error('Update fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		else {
			if($this->dao->add()) {
				self::_success('Add component data success!',__URL__);
			}
			else{
				self::_error('Add component data fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
	}
	public function select() {
		$action = $_REQUEST['action'];
		$fixed = $_REQUEST['fixed'];
		if(!empty($_REQUEST['id'])) {
			echo json_encode($this->dao->relation(true)->find($_REQUEST['id']));
			return;
		}
		if(!empty($_POST['submit'])) {
			$this->assign('submit', 1);
			$where = array();
			if(''!=$fixed) {
				$where['fixed'] = $fixed;
			}
			$where['type'] = $_REQUEST['type'];
			$this->assign('type', $_REQUEST['type']);

			if(!empty($_REQUEST['Internal_PN'])) {
				$where['Internal_PN'] = array('like', '%'.trim($_REQUEST['Internal_PN']).'%');
			}
			if(!empty($_REQUEST['description'])) {
				$where['description'] = array('like', '%'.trim($_REQUEST['description']).'%');
			}
			if(!empty($_REQUEST['manufacture'])) {
				$where['manufacture'] = array('like', '%'.trim($_REQUEST['manufacture']).'%');
			}
			if(!empty($_REQUEST['MPN'])) {
				$where['MPN'] = array('like', '%'.trim($_REQUEST['MPN']).'%');
			}
			if(''==$action || 'enter'==$action) {
				$this->assign('result', $this->dao->where($where)->group('description')->select());
			}
			elseif('apply'==$action) {
				$result = array();
				foreach($this->dao->relation(true)->where($where)->select() as $item) {
					if(!empty($item) && ($item['location_product'][0]['ori_quantity']+$item['location_product'][0]['chg_quantity'])>0) {
						$result[] = $item;
					}
				}
				$this->assign('result', $result);
			}
			else {
				//else
			}
		}
		$this->assign('action', $action);
		$this->assign('fixed', $fixed);
		$this->assign('content', 'Product:select');
		$this->display('Layout:content');
	}
	public function info() {
		$id = $_REQUEST['id'];
		$this->assign("info", $this->dao->relation(true)->find($id));
		$this->assign('content', 'Product:info');
		$this->display('Layout:content');
	}
	public function delete() {
		//判断是否已被使用
		$id = $_REQUEST['id'];
		$rs = M('ProductFlow')->where(array('product_id'=>$id))->select();
		if(!empty($rs) && sizeof($rs)>0) {
			self::_error('It\'s in use, can\'t be deleted!');
		}
		else{
			self::_delete();
		}
	}
}
?>