<?php
/**
*
* 货品类别
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class CategoryAction extends BaseAction{

	protected $dao;

	public function _initialize() {
		Session::set('sub', MODULE_NAME);
		$this->dao = M('Category');
		parent::_initialize();
		$this->assign('MODULE_TITLE', 'Category');
	}

	public function index(){
		$this->assign('ACTION_TITLE', 'List');
		$arr = $this->dao->group('type')->field('type')->select();
		$result = array('Component'=>array(), 'Board'=>array());
		foreach($arr as $val) {
			$result[$val['type']] = $this->dao->where(array('type'=>$val['type']))->order('id')->select();
		}
		$default_category_type = Session::get('default_category_type');
		empty($default_category_type) && ($default_category_type = 'Component');

		$max_code = $this->dao->max('code');
		empty($max_code) && ($max_code = 'P'.sprintf("%03d",0));
		$code = ++ $max_code;

		$this->assign('result', $result);
		$this->assign('default_type', $default_category_type);
		$this->assign('code', $code);
		$this->assign('content','Category:index');
		$this->display('Layout:ERP_layout');
	}

	/**
	* useless
	*/
	private function form() {
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		if ($id>0) {
			$info = $this->dao->find($id);
			$code = $info['code'];
		}
		else {
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
		$type =  $_REQUEST['type'];
		Session::set('default_category_type', $type);
		$name = trim($_REQUEST['name']);
		!$name && self::_error('Category Name required');
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		if ($id>0) {
			$rs = $this->dao->where(array('type'=>$type,'name'=>$name,'id'=>array('neq',$id)))->find();
			if($rs && sizeof($rs)>0){
				self::_error('Category Name: '.$name.' exists already!');
			}
			$this->dao->find($id);
		}
		else {
			$rs = $this->dao->where(array('type'=>$type,'name'=>$name))->find();
			if($rs && sizeof($rs)>0){
				self::_error('Category Name: '.$name.' exists already!');
			}
			$max_code = $this->dao->max('code');
			empty($max_code) && ($max_code = 'P'.sprintf("%03d",0));
			$code = ++ $max_code;
			$this->dao->code = $code;
		}
		$this->dao->type = $type;
		$this->dao->name = $name;
		if ($id>0) {
			if(false !== $this->dao->save()){
				self::_success('Category information updated!',__URL__);
			}
			else{
				self::_error('Update fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		else {
			if($this->dao->add()) {
				self::_success('Add category success!',__URL__);
			}
			else{
				self::_error('Add category fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
	}
	public function delete() {
		//判断是否已被使用
		$id = $_REQUEST['id'];
		$rs = M('Product')->where(array('category_id'=>$id))->select();
		if(!empty($rs) && sizeof($rs)>0) {
			self::_error('It\'s in use, can\'t be deleted!');
		}
		else{
			self::_delete();
		}
	}
}
?>