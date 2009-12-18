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
		$rs = $this->dao->where(array('LocationProduct.type'=>'staff', 'location_id'=>$_SESSION[C('USER_AUTH_KEY')]))->select();
		$result = array();
		foreach($rs as $item) {
			if(!array_key_exists($item['category_name'], $result)) {
				$result[$item['category_name']] = array();
			}
			if(!isset($default_category)) {
				$default_category = $item['category_name'];
			}
			$result[$item['category_name']][] = $item;
		}
		$this->assign('default_category', $default_category);
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