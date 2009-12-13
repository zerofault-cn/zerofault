<?php
/**
*
* Asset
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class AssetAction extends BaseAction{


	public function _initialize() {
		$this->dao = D('ProductFlow');
		parent::_initialize();
	}

	public function index(){
		self::apply();
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

}
?>