<?php
/**
*
* 部门
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class DeptAction extends BaseAction{

	protected $dao;

	public function _initialize() {
		Session::set('top', 'Basic Data');
		Session::set('sub', MODULE_NAME);
		$this->dao = D('Department');
		parent::_initialize();
		$this->assign('MODULE_TITLE', 'Department');
	}

	public function index(){
		$this->assign('ACTION_TITLE', 'List');
		$max_code = $this->dao->max('code');
		empty($max_code) && ($max_code = 'D'.sprintf("%03d",0));
		$code = ++ $max_code;

		$this->assign('code', $code);
		$this->assign('leader_opts', self::genOptions(M('Staff')->where(array('is_leader'=>1,'status'=>1))->select(),'','realname'));
		$this->assign('result', $this->dao->relation(true)->order('id')->select());
		$this->assign('content','Dept:index');
		$this->display('Layout:ERP_layout');
	}

	/**
	* useless
	*/
	private function form() {
		$dStaff = D('Staff');
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		if ($id>0) {
			$info = $this->dao->find($id);
			$info['leader_opts'] = self::genOptions($dStaff->where(array('is_leader'=>1))->select(), $info['leader_id'],'realname');
			$code = $info['code'];
		}
		else {
			$info = array(
				'id'=>0,
				'name'=>'',
				'function'=>'',
				'leader_opts'=>self::genOptions($dStaff->where(array('is_leader'=>1))->select(),'','realname')
				);
			$max_id = $this->dao->getField('max(id) as max_id');
			empty($max_id) && ($max_id = 0);
			$code = 'D'.sprintf("%03d",$max_id+1);
		}
		$this->assign('code', $code);
		$this->assign('info', $info);
		$this->assign('content', 'Dept:form');
		$this->display('Layout:ERP_layout');
	}
	public function submit() {
		if(empty($_POST['submit'])) {
			return;
		}
		$name = trim($_REQUEST['name']);
		!$name && self::_error('Department Name required');
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		if ($id>0) {
			$rs = $this->dao->where(array('name'=>$name,'id'=>array('neq',$id)))->find();
			if($rs && sizeof($rs)>0){
				self::_error('Department Name: '.$name.' exists already!');
			}
			$this->dao->find($id);
		}
		else {
			$rs = $this->dao->where(array('name'=>$name))->find();
			if($rs && sizeof($rs)>0){
				self::_error('Department Name: '.$name.' exists already!');
			}
			$max_id = $this->dao->getField('max(id) as max_id');
			empty($max_id) && ($max_id = 0);
			$code = 'D'.sprintf("%03d",$max_id+1);
			$this->dao->code = $code;
		}
		$this->dao->name = $name;
		$this->dao->function = $_REQUEST['function'];
		$this->dao->leader_id = $_REQUEST['leader_id'];
		if ($id>0) {
			if(false !== $this->dao->save()){
				self::_success('Department information updated!',__URL__);
			}
			else{
				self::_error('Update fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		else{
			if($this->dao->add()) {
				self::_success('Add department success!',__URL__);
			}
			else{
				self::_error('Add department fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
	}
	public function delete() {
		//判断是否已被使用
		$id = $_REQUEST['id'];
		$rs = M('Staff')->where(array('dept_id'=>$id))->select();
		if(!empty($rs) && sizeof($rs)>0) {
			self::_error('It\'s in use, can\'t be deleted!');
		}
		else{
			self::_delete();
		}
	}
}
?>