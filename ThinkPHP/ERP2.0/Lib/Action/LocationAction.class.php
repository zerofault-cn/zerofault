<?php
/**
*
* 存储地管理
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class LocationAction extends BaseAction{

	protected $dao;

	public function _initialize() {
		$this->dao = M('Location');
		parent::_initialize();
	}

	public function index(){
		$this->assign('result', $this->dao->select());
		$this->assign('content','Location:index');
		$this->display('Layout:ERP_layout');
	}

	public function submit() {
		if(empty($_POST['submit'])) {
			return;
		}
		$id = $_REQUEST['id'];
		$name = trim($_REQUEST['name']);
		$descr = trim($_REQUEST['descr']);
		empty($name) && self::_error('Location Name required!');
		if(!empty($id) && $id>0) {
			$rs = $this->dao->where(array('name'=>$name,'id'=>array('neq',$id)))->find();
			if($rs && sizeof($rs)>0){
				self::_error('Location name: '.$name.' exists already!');
			}
			$this->dao->find($id);
		}
		else{
			$rs = $this->dao->where(array('name'=>$name))->find();
			if($rs && sizeof($rs)>0){
				self::_error('Location name: '.$name.' exists already!');
			}
		}
		$this->dao->name = $name;
		$this->dao->descr = $descr;
		if(!empty($id) && $id>0) {
			if(false !== $this->dao->save()){
				self::_success('Location info updated!',__URL__);
			}
			else{
				self::_error('Update fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		else{
			if($this->dao->add()) {
				self::_success('Add location success!',__URL__);
			}
			else{
				self::_error('Add location fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
	}
	public function delete() {
		//判断是否已被使用
		$id = $_REQUEST['id'];
		$rs = M('ProductFlow')->where(array('from_id'=>$id,'to_id'=>$id,'_logic'=>'or'))->select();
		if(!empty($rs) && sizeof($rs)>0) {
			self::_error('It\'s in use, can\'t be deleted!');
		}
		else{
			self::_delete();
		}
	}
}
?>