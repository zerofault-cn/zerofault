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
		Session::set('top', 'Assets Management');
		global $MODULE;
		$MODULE = 'Asset';
		$this->dao = M('LocationProduct');
		parent::_initialize();
		$this->assign('MODULE_TITLE', 'Assets Management');
	}

	public function index(){
		Session::set('sub', MODULE_NAME);
		$this->assign('ACTION_TITLE', 'My Asset List');
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
		krsort($result);

		//for batch transfer
		$info = array();
		$location_arr = M('Location')->where(array('id'=>array('gt',1)))->select();
		$location_arr[] = array('id' => 'staff', 'name' => 'Staff');
		$info['location_opts'] = self::genOptions($location_arr);
		$info['staff_opts'] = self::genOptions(M('Staff')->where(array('status'=>1, 'id'=>array('neq',$_SESSION[C('USER_AUTH_KEY')])))->select(), '', 'realname');
		$this->assign('info', $info);

		$this->assign('fixed_arr', array('Floating Assets', 'Fixed Assets'));
		$this->assign('default_fixed', 1);
		$this->assign('result', $result);
		$this->assign('content', 'Asset:index');
		$this->display('Layout:ERP_layout');
	}
	public function location() {
		global $location_id;
		$location_id = intval($_REQUEST['id']);
		$this->assign('id', $location_id);
		R('ProductOut', 'transfer');
	}
	public function category() {
		global $category_id;
		$action = $_REQUEST['action'];
		empty($action) && ($action='enter');
		switch ($action) {
			case 'enter':
			case 'reject':
				$module = 'ProductIn';
				Session::set('top', 'Inventory Input Management');
				break;
			default :
				$module = 'ProductOut';
				Session::set('top', 'Inventory Output Management');
		}
		$category_id = intval($_REQUEST['id']);
		$this->assign('id', $category_id);
		R($module, $action);
	}
	public function request() {
		R('ProductOut', 'request');
	}
	public function apply() {
		$this->assign('MODULE_TITLE', 'My Apply');
		R('ProductOut', 'apply');
	}
	public function transfer() {
		self::transferOut();
	}
	public function transferIn() {
		R('ProductOut', 'transfer');
	}
	public function transferOut() {
		R('ProductOut', 'transfer');
	}
	public function returns() {
		R('ProductOut', 'returns');
	}
	public function form() {
		//Session::set('sub', 'Asset/apply');
		empty($_REQUEST['action']) && self::_error('No action parameter');
		$action = $_REQUEST['action'];
		switch ($action) {
			case 'enter':
			case 'reject':
				$module = 'ProductIn';
				break;
			default :
				$module = 'ProductOut';
		}
		R($module, 'form');
	}
	public function submit() {
		R('ProductOut', 'submit');
	}
	public function confirm() {
		empty($_REQUEST['action']) && self::_error('No action parameter');
		$action = $_REQUEST['action'];
		switch ($action) {
			case 'enter':
			case 'reject':
				$module = 'ProductIn';
				break;
			default :
				$module = 'ProductOut';
		}
		R($module, 'confirm');
	}
	public function select() {
		R('Product', 'select');
	}
	public function delete() {
		R('ProductOut', 'delete');
	}
}
?>