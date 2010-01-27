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
		Session::set('sub', MODULE_NAME);
		$this->dao = D('Location');
		parent::_initialize();
		$this->assign('MODULE_TITLE', 'Location');
	}

	public function index(){
		$this->assign('ACTION_TITLE', 'Setting');
		$this->assign('staff_opts', self::genOptions(M('Staff')->where(array('status'=>1))->select(), '', 'realname'));
		
		$result = $this->dao->relation(true)->order('id')->select();
		//dump($result);
		$this->assign('result', $result);
		$this->assign('content','Location:index');
		$this->display('Layout:ERP_layout');
	}
	
	public function submit() {
		if(empty($_POST['submit'])) {
			return;
		}
		$id = intval($_REQUEST['id']);
		$name = trim($_REQUEST['name']);
		$descr = trim($_REQUEST['descr']);
		$staff1_id = intval($_REQUEST['staff1_id']);
		$staff0_id = intval($_REQUEST['staff0_id']);
		empty($name) && self::_error('Location Name required!');
		if ($id>0) {
			$rs = $this->dao->where(array('name'=>$name,'id'=>array('neq',$id)))->find();
			if($rs && sizeof($rs)>0){
				self::_error('Location name: '.$name.' exists already!');
			}
			$this->dao->find($id);
			M("LocationManager")->where(array('location_id'=>$id))->delete();
		}
		else{
			$rs = $this->dao->where(array('name'=>$name))->find();
			if($rs && sizeof($rs)>0){
				self::_error('Location name: '.$name.' exists already!');
			}
		}
		$this->dao->name = $name;
		$this->dao->descr = $descr;
		if ($id>0) {
			if(false !== $this->dao->save()){
				M("LocationManager")->add(array('location_id'=>$id,'fixed'=>1,'staff_id'=>$staff1_id));
				M("LocationManager")->add(array('location_id'=>$id,'fixed'=>0,'staff_id'=>$staff0_id));
				self::_success('Location info updated!',__URL__);
			}
			else{
				self::_error('Update fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		else{
			if($id = $this->dao->add()) {
				M("LocationManager")->add(array('location_id'=>$id,'fixed'=>1,'staff_id'=>$staff1_id));
				M("LocationManager")->add(array('location_id'=>$id,'fixed'=>0,'staff_id'=>$staff0_id));
				self::_success('Add location success!',__URL__);
			}
			else{
				self::_error('Add location fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
	}
	public function delete() {
		//判断是否已被使用
		$id = intval($_REQUEST['id']);
		$rs = M('ProductFlow')->where(array('from_id'=>$id,'to_id'=>$id,'_logic'=>'or'))->select();
		if(!empty($rs) && sizeof($rs)>0) {
			self::_error('It\'s in use, can\'t be deleted!');
		}
		else{
			M("LocationManager")->where(array('location_id'=>$id))->delete();
			self::_delete();
		}
	}
}
?>