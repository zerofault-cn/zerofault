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
		$this->dao = M('Options');
		parent::_initialize();
	}

	public function index(){
		$arr = $this->dao->group('type')->field('type')->select();
		$result = array();
		foreach($arr as $val) {
			$result[$val['type']] = $this->dao->where(array('type'=>$val['type']))->select();
		}
		//dump($result);
		$this->assign('result',$result);
		$this->assign('content','Setting:index');
		$this->display('Layout:ERP_layout');
	}

	public function form() {
		$id = $_REQUEST['id'];
		if(!empty($id) && $id>0) {
			$info = $this->dao->find($id);
			$code = $info['code'];
		}
		else{
			$info = array(
				'id'=>0,
				'name'=>'',
				);
			$max_id = $this->dao->getField('max(id) as max_id');
			empty($max_id) && ($max_id = 0);
			$code = 'P'.sprintf("%03d",$max_id+1);
		}
		$this->assign('code', $code);
		$this->assign('info', $info);
		$this->assign('content', 'Category:form');
		$this->display('Layout:ERP_layout');
	}
	public function submit() {
		if(empty($_POST['submit'])) {
			return;
		}
		$id = $_REQUEST['id'];
		$name = trim($_REQUEST['name']);
		empty($name) && self::_error('Category Name required');
		if(!empty($id) && $id>0) {
			$rs = $this->dao->where(array('name'=>$name,'id'=>array('neq',$id)))->find();
			if($rs && sizeof($rs)>0){
				self::_error('Category Name: '.$name.' exists already!');
			}
			$this->dao->find($id);
		}
		else{
			$rs = $this->dao->where(array('name'=>$name))->find();
			if($rs && sizeof($rs)>0){
				self::_error('Category Name: '.$name.' exists already!');
			}
			$this->dao->code = $_REQUEST['code'];
		}
		$this->dao->name = $name;
		if(!empty($id) && $id>0) {
			if(false !== $this->dao->save()){
				self::_success('Category information updated!',__URL__);
			}
			else{
				self::_error('Update fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		else{
			if($this->dao->add()) {
				self::_success('Add category success!',__URL__);
			}
			else{
				self::_error('Add category fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		
	}
}
?>