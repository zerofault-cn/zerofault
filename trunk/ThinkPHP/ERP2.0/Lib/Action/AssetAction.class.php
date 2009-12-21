<?php
/**
*
* Asset
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class AssetAction extends BaseAction{

	protected $dao;
	
	public function _initialize() {
		$this->dao = D('LocationProductView');
		parent::_initialize();
	}

	public function index(){
		$rs = $this->dao->distinct(true)->where(array('LocationProduct.type'=>'staff', 'location_id'=>$_SESSION[C('USER_AUTH_KEY')]))->select();
		if(empty($rs)) {
			$rs = array();
		}
		$result = array(array(),array());
		foreach($rs as $item) {
			$key = $item['fixed'];
			if('Board'==$item['type']) {
				$key  = 1;
			}
			$result[$key][] = $item;
		}
		krsort($result);
		$this->assign('fixed_arr', array('Floating Assets', 'Fixed Assets'));
		$this->assign('default_fixed', 1);
		$this->assign('result', $result);
		$this->assign('content', 'Asset:index');
		$this->display('Layout:ERP_layout');
	}
	public function transfer() {
		R('ProductOut', 'transfer');
	}
	public function transferIn() {
		R('ProductOut', 'transfer');
	}
	public function transferOut() {
		R('ProductOut', 'transfer');
	}
	public function back() {
		$this->index();
	}
	public function apply() {
		R('ProductOut', 'apply');
	}
	public function form() {
		R('ProductOut', 'form');
	}
	public function submit() {
		R('ProductOut', 'submit');
	}
	public function confirm() {
		R('ProductOut', 'confirm');
	}
	public function select() {
		R('Product', 'select');
	}
	public function profile() {
		R('Staff', 'profile');
	}
}
?>