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
		$this->dao = M('LocationProduct');
		parent::_initialize();
	}

	public function index(){
		$rs = $this->dao->where(array('type'=>'staff', 'location_id'=>$_SESSION[C('USER_AUTH_KEY')], '`ori_quantity`+`chg_quantity`'=>array('gt', 0)))->select();
		//dump($rs);
		if(empty($rs)) {
			$rs = array();
		}
		$result = array(array(),array());
		foreach($rs as $item) {
			$item['product'] = M('Product')->find($item['product_id']);
			//dump($item['product']);
			$item['unit_name'] = M('Options')->where('id='.$item['product']['unit_id'])->getField('name');
			//dump($item['unit_name']);
			$i = $item['product']['fixed'];
			if('Board'==$item['type']) {
				$i  = 1;
			}
			$result[$i][] = $item;
		}
		//dump($result);
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
	public function apply() {
		R('ProductOut', 'apply');
	}
	public function returns() {
		R('ProductOut', 'returns');
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
	public function delete() {
		R('ProductOut', 'delete');
	}
}
?>