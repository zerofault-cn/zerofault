<?php
/**
*
* 货品类别
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class CommodityAction extends BaseAction{

	protected $dao;

	public function _initialize() {
		$this->dao = D('Commodity');
		parent::_initialize();
	}

	public function index(){
		$this->assign('result', $this->dao->select());
		$this->assign('content','Commodity:index');
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
		$this->assign('content', 'Commodity:form');
		$this->display('Layout:ERP_layout');
	}
	public function submit() {
		if(empty($_POST['submit'])) {
			return;
		}
		$id = $_REQUEST['id'];
		$name = trim($_REQUEST['name']);
		empty($name) && self::_error('Commodity Name required');
		if(!empty($id) && $id>0) {
			$rs = $this->dao->where(array('name'=>$name,'id'=>array('neq',$id)))->find();
			if($rs && sizeof($rs)>0){
				self::_error('Commodity Name: '.$name.' exists already!');
			}
			$this->dao->find($id);
		}
		else{
			$rs = $this->dao->where(array('name'=>$name))->find();
			if($rs && sizeof($rs)>0){
				self::_error('Commodity Name: '.$name.' exists already!');
			}
			$this->dao->code = $_REQUEST['code'];
		}
		$this->dao->name = $name;
		if(!empty($id) && $id>0) {
			if($this->dao->save()){
				self::_success('Commodity information updated!',__URL__);
			}
			else{
				self::_error('Update fail!'.(C('DEBUG_MODE')?$this->dao->getLastSql():''));
			}
		}
		else{
			if($this->dao->add()) {
				self::_success('Add commodity success!',__URL__);
			}
			else{
				self::_error('Add commodity fail!'.(C('DEBUG_MODE')?$this->dao->getLastSql():''));
			}
		}
		
	}
}
?>