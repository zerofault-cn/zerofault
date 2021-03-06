<?php
/**
*
* 系统设置
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/11/27
*/
class SettingAction extends BaseAction{

	protected $dao;

	public function _initialize() {
		Session::set('top', 'System');
		Session::set('sub', MODULE_NAME);
		$this->dao = M('Options');
		parent::_initialize();
		$this->assign('MODULE_TITLE', 'Options');
	}

	public function index(){
		$this->assign('ACTION_TITLE', 'Setting');
		$arr = $this->dao->group('type')->field('type')->select();
		$result = array(
			'currency'	=> array(),
			'unit'		=> array(),
			'character'	=> array(),
			'payment_terms' => array(),
			'tax'		=> array(),
			'status'	=> array()
		);
		foreach($arr as $val) {
			$result[$val['type']] = $this->dao->where(array('type'=>$val['type']))->select();
		}
		$default_option_type = Session::get('default_option_type');
		empty($default_option_type) && ($default_option_type = 'currency');
		$this->assign('result', $result);
		$this->assign('default_type', $default_option_type);
		$this->assign('content','Setting:index');
		$this->display('Layout:ERP_layout');
	}

	public function submit() {
		if(empty($_POST['submit'])) {
			return;
		}
		$type =  $_REQUEST['type'];
		Session::set('default_option_type', $type);
		$id = $_REQUEST['id'];
		$name = trim($_REQUEST['name']);
		$code = trim($_REQUEST['code']);
		$sort = trim($_REQUEST['sort']);
		empty($name) && self::_error('Option Name required');
		if(!empty($id) && $id>0) {
			$rs = $this->dao->where(array('type'=>$type,'name'=>$name,'id'=>array('neq',$id)))->find();
			if($rs && sizeof($rs)>0){
				self::_error('Option Name: '.$name.' exists already!');
			}
			$this->dao->find($id);
		}
		else{
			$rs = $this->dao->where(array('type'=>$type,'name'=>$name))->find();
			if($rs && sizeof($rs)>0){
				self::_error('Option Name: '.$name.' exists already!');
			}
		}
		$this->dao->type = $type;
		$this->dao->name = $name;
		$this->dao->code = $code;
		$this->dao->sort = $sort;
		if(!empty($id) && $id>0) {
			if(false !== $this->dao->save()){
				self::_success(ucfirst($type).' option updated!',__URL__);
			}
			else{
				self::_error('Update fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		else{
			if($this->dao->add()) {
				self::_success('Add '.ucfirst($type).' option success!',__URL__);
			}
			else{
				self::_error('Add '.ucfirst($type).' option fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
	}
	public function delete() {
		$type =  $_REQUEST['type'];
		Session::set('default_option_type', $type);
		//判断是否已被使用
		$id = $_REQUEST['id'];
		switch ($type) {
			case 'unit':
			case 'status':
				$rs = M('Product')->where(array($type.'_id'=>$id))->select();
				if(!empty($rs) && sizeof($rs)>0) {
					self::_error('It\'s in use, can\'t be deleted!');
				}
				break;
			
			case 'currency':
				$rs = M('Product')->where(array($type.'_id'=>$id))->select();
				if(!empty($rs) && sizeof($rs)>0) {
					self::_error('It\'s in use, can\'t be deleted!');
				}
				$rs = M('ProductFlow')->where(array($type.'_id'=>$id))->select();
				if(!empty($rs) && sizeof($rs)>0) {
					self::_error('It\'s in use, can\'t be deleted!');
				}
				break;
				
			case 'character':
			case 'payment_terms':
			case 'tax':
				$rs = M('Product')->where(array($type.'_id'=>$id))->select();
				if(!empty($rs) && sizeof($rs)>0) {
					self::_error('It\'s in use, can\'t be deleted!');
				}
				break;
				
			default:
				//nothing
		}
		self::_delete();
	}
}
?>