<?php
/**
*
* 库存管理
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class InventoryAction extends BaseAction{

	protected $dao;

	public function _initialize() {
		$this->dao = D('ProductView');
		parent::_initialize();
	}

	public function index() {
		$this->assign('commodity_opts', self::genOptions(M('Commodity')->select(), $_REQUEST['commodity_id']) );
		$this->assign('product_opts', self::genOptions(M('Product')->select(), $_REQUEST['product_id'], 'description') );
		$this->assign('supplier_opts', self::genOptions(D('Supplier')->select(), $_REQUEST['supplier_id']) );
		$where = array();
		$where['status'] = 1;
		$result = array();
		if(!empty($_POST['submit'])) {

			$rs = M('Options')->where(array('type'=>'unit'))->order('sort')->select();
			$unit = array();
			foreach($rs as $i=>$item) {
				$unit[$item['id']] = $item['title'];
			}
			$this->assign('unit', $unit);

			!empty($_REQUEST['commodity_id']) && ($where['commodity_id'] = $_REQUEST['commodity_id']);
			!empty($_REQUEST['product_id']) && ($where['product_id'] = $_REQUEST['product_id']);
			!empty($_REQUEST['supplier_id']) && ($where['supplier_id'] = $_REQUEST['supplier_id']);
			$rs = $this->dao->where($where)->select();
			if(empty($rs)) {
				$rs = $result;
			}
			foreach($rs as $item) {
				if(!array_key_exists($item['product_id'], $result)) {
					$result[$item['product_id']] = array(
						'product' => $item['product'],
						'unit_id' => $item['unit_id'],
						'currency'=> $item['currency'],
						'quantity' => (('Storage'==$item['destination'])?1:-1)*$item['quantity'],
						'total' => (('Storage'==$item['destination'])?1:-1)*$item['quantity']*$item['price']
						);
					continue;
				}
				$result[$item['product_id']]['quantity'] += (('Storage'==$item['destination'])?1:-1)*$item['quantity'];
				$result[$item['product_id']]['total'] += (('Storage'==$item['destination'])?1:-1)*$item['quantity']*$item['price'];
			}
		}
		
		$this->assign('result', $result);
		$this->assign('content','Inventory:index');
		$this->display('Layout:ERP_layout');
	}

}
?>