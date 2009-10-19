<?php
/**
*
* 出库，退库
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class ProductOutAction extends BaseAction{

	protected $dao;

	public function _initialize() {
		$this->dao = D('ProductFlow');
		parent::_initialize();
	}
	Public function apply() {
		$this->index('apply');
	}
	Public function transfer() {
		$this->index('transfer');
	}
	Public function release() {
		$this->index('release');
	}
	Public function send() {
		$this->index('send');
	}
	Public function scrap() {
		$this->index('scrap');
	}
	Public function returns() {
		$this->index('returns');
	}
	public function index($action='') {
		if(''==$action) {
			$action = $_REQUEST['action'];
		}
		$this->assign('action', $action);
		$rs = M('Options')->where(array('type'=>'unit'))->order('sort')->select();
		$unit = array();
		foreach($rs as $i=>$item) {
			$unit[$item['id']] = $item['title'];
		}
		$this->assign('unit', $unit);

		$where = array();
		switch ($action) {
			case 'apply':
				$where['source'] = 'Storage';
				$where['destination'] = 'Staff';
				break;
			case 'transfer':
				$where['source'] = 'Staff';
				$where['destination'] = 'Staff';
				break;
			case 'release':
				$where['source'] = 'Storage';
				$where['destination'] = 'Manufactory';
				break;
			case 'send':
				$where['source'] = 'Storage';
				$where['destination'] = 'Customer';
				break;
			case 'scrap':
				$where['source'] = 'Storage';
				$where['destination'] = 'Scrap';
				break;
			case 'returns':
				$where['source'] = 'Manufactory';
				$where['destination'] = 'Storage';
				break;
			default:
				$where['source'] = 'Storage';
				$where['destination'] = 'Staff';
				break;
		}
		$this->assign('result', $this->dao->relation(true)->where($where)->select());
		$this->assign('content','ProductOut:index');
		$this->display('Layout:ERP_layout');
	}
	
	public function confirm() {
		if(empty($_POST['submit'])) {
			return;
		}
		empty($_POST['chk']) && self::_error('You hadn\'t got any item selected');
		if($this->dao->where("id in (".implode(',',$_POST['chk']).")")->setField(array('confirm_time', 'confirmed_staff_id', 'confirmed_quantity', 'status'), array(date("Y-m-d H:i:s"), $_SESSION[C('USER_AUTH_KEY')], 0, 1)) && self::update_quantity($_REQUEST['product_id'])) {
			self::_success('Confirm success','',1000);
		}
		else{
			self::_error('Something wrong!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
		}
	}

	public function form() {
		$action = $_REQUEST['action'];
		$id = $_REQUEST['id'];
		if(!empty($id) && $id>0) {
			$info = $this->dao->relation(true)->find($id);
			$info['commodity'] = M('Commodity')->where("id=".$info['product']['commodity_id'])->getField('name');
			$info['unit'] = M('Options')->where("id=".$info['product']['unit_id'])->getField('title');
			if('transfer'==$action) {
				$code = 'T'.substr($info['code'],-9);
			}
			elseif('returns'==$action) {
				$code = 'R'.substr($info['code'], -9);
			}
			else{
				$code = $info['code'];
			}
		}
		else{
			$info = array(
				'product_opts' => self::genOptions(D('Product')->select(),'','MPN'),
				'supplier_opts' => self::genOptions(D('Supplier')->select(),'','name'),
				'currency_opts' => self::genOptions(M('Options')->where(array('type'=>'currency'))->order('sort')->select(), '', 'title'),
				'unit_opts' => self::genOptions(M('Options')->where(array('type'=>'unit'))->order('sort')->select(), '', 'title')
			);
			$max_id = $this->dao->getField('max(id) as max_id');
			empty($max_id) && ($max_id = 0);
			$code = 'Out'.sprintf("%09d",$max_id+1);
		}
		$this->assign('id', $id);
		$this->assign('action', $action);
		$this->assign('code', $code);

		$this->assign('info', $info);
		$this->assign('ProductList', D('Product')->relation(true)->select());
		$this->assign('content', 'ProductOut:form');
		$this->display('Layout:ERP_layout');
	}
	public function submit() {
		if(empty($_POST['submit'])) {
			return;
		}
		$id = $_REQUEST['id'];
		$action = $_REQUEST['action'];
		empty($_REQUEST['product_id']) && self::_error('Select a product first!');
		($_REQUEST['quantity']>$_REQUEST['ori_quantity']) && self::_error('Request quantity can\'t be larger than '.$_REQUEST['ori_quantity']);

		if($action!='transfer' && $action!='returns' && !empty($id) && $id>0) {
			$this->dao->find($id);
		}
		else{
			$this->dao->code = $_REQUEST['code'];
			switch ($action) {
				case 'apply':
					$this->dao->source = 'Storage';
					$this->dao->destination = 'Staff';
					break;
				case 'transfer':
					$this->dao->source = 'Staff';
					$this->dao->destination = 'Staff';
					break;
				case 'release':
					$this->dao->source = 'Storage';
					$this->dao->destination = 'Manufactory';
					break;
				case 'send':
					$this->dao->source = 'Storage';
					$this->dao->destination = 'Customer';
					break;
				case 'scrap':
					$this->dao->source = 'Storage';
					$this->dao->destination = 'Scrap';
					break;
				case 'returns':
					$this->dao->source = 'Manufactory';
					$this->dao->destination = 'Storage';
					break;
				default:
					$this->dao->source = 'Storage';
					$this->dao->destination = 'Staff';
					break;
			}
			$this->dao->staff_id = $_SESSION[C('USER_AUTH_KEY')];
			$this->dao->create_time = date("Y-m-d H:i:s");
		}
		$this->dao->product_id = $_REQUEST['product_id'];
		$this->dao->quantity = $_REQUEST['quantity'];
		$this->dao->remark = $_REQUEST['remark'];
		if($action!='transfer' && $action!='returns' && !empty($id) && $id>0) {
			if(false !== $this->dao->save()){
				self::_success('Product information updated!',__URL__.'/'.$action);
			}
			else{
				self::_error('Update fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		else{
			if($this->dao->add()) {
				if($action=='apply') {
					self::_success('Product Request success !',__URL__.'/'.$action);
				}
				elseif('transfer'==$action) {
					self::_success('Transfer success!',__URL__.'/'.$action);
				}
				else{
					self::_success('Add product data success!',__URL__.'/'.$action);
				}
			}
			else{
					self::_error('Product entering fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
	}
}
?>