<?php
/**
*
* 入库，退货
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class ProductInAction extends BaseAction{

	protected $dao;

	public function _initialize() {
		Session::set('top', 'Inventory Input Management');
		$this->dao = D('ProductFlow');
		parent::_initialize();
	}
	Public function fixed() {
		$this->assign('MODULE_TITLE', 'Fixed-Assets Enter');
		$this->index('enter', 1);
	}
	Public function floating() {
		$this->assign('MODULE_TITLE', 'Floating-Assets Enter');
		$this->index('enter', 0);
	}
	public function enter() {
		$this->assign('MODULE_TITLE', 'Product Enter');
		$this->index('enter');
	}
	public function reject() {
		$this->assign('MODULE_TITLE', 'Product Reject');
		$this->index('reject');
	}
	private function index($action='enter', $fixed='') {
		Session::set('sub', MODULE_NAME.'/'.ACTION_NAME);
		$this->assign('ACTION_TITLE', 'List');
		// unit.id=>unit.name
		$this->assign('unit', M('Options')->where(array('type'=>'unit'))->getField('id,name'));
		// category.id=>category.name
		$this->assign('category', M('Category')->getField('id,name'));

		if(isset($_REQUEST['status'])) {
			$status = $_REQUEST['status'];
		}
		elseif(''!=(Session::get(ACTION_NAME.'_status'))) {
			$status = Session::get(ACTION_NAME.'_status');
		}
		else{
			$status = 0;
		}
		//Session::set(ACTION_NAME.'_status', $status);//用于保存Tab选中状态
		$this->assign('status', $status);
		
		$where = array();
		$where['status'] = $status;
		if(''!=$fixed) {
			$where['fixed'] = $fixed;
		}
		if (!empty($_SESSION[C('CMANAGER_AUTH_NAME')])) {
			if (count($_SESSION[C('CMANAGER_AUTH_NAME')]) == 1) {
				$where['category_id'] = array_keys($_SESSION[C('CMANAGER_AUTH_NAME')]);
			}
			else {
				$where['category_id'] = array('In', array_keys($_SESSION[C('CMANAGER_AUTH_NAME')]));
			}
		}
		$where['action'] = $action;
		$this->assign('action', $action);

		import("@.Paginator");
		$limit = 20;
		if (!empty($_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_limit'])) {
			$limit = $_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_limit'];
		}
		if (!empty($_REQUEST['limit'])) {
			$limit = $_REQUEST['limit'];
		}
		$_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_limit'] = $limit;

		$count = $this->dao->where($where)->getField('count(*)');
		$p = new Paginator($count,$limit);

		$order = 'id desc';
		$rs = $this->dao->relation(true)->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();
		empty($rs) && ($rs = array());
		$result = array();
		foreach($rs as $item) {
			$item['rejected_quantity'] = $this->dao->where(array('code'=>'B'.substr($item['code'],-9),'status'=>1))->sum('quantity');
			empty($item['rejected_quantity']) && ($item['rejected_quantity']=0);
			$result[] = $item;
		}
		$this->assign('result', $result);
		$this->assign('page', $p->showMultiNavi());

		$this->assign('content', 'ProductIn:index');
		$this->display('Layout:ERP_layout');
	}

	public function form() {
		$this->assign('ACTION_TITLE', 'Enter new Product');
		$fixed = isset($_REQUEST['fixed']) ? trim($_REQUEST['fixed']) : '';
		if('0' == $fixed) {
			$this->assign('ACTION_TITLE', 'Enter new Floating-Assets');
		}
		elseif ('1' == $fixed) {
			$this->assign('ACTION_TITLE', 'Enter new Fixed-Assets');
		}
		$action = empty($_REQUEST['action']) ? 'enter' : trim($_REQUEST['action']);
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		if ($id>0) {
			$info = $this->dao->relation(true)->find($id);
			$info['category'] = M('Category')->where("id=".$info['product']['category_id'])->getField('name');
			$info['unit'] = M('Options')->where("id=".$info['product']['unit_id'])->getField('name');
			$info['supplier_opts'] = self::genOptions(D('Supplier')->select(), $info['supplier_id']);
			$info['currency_opts'] = self::genOptions(M('Options')->where(array('type'=>'currency'))->order('sort')->select(), $info['currency_id']);
			if ('reject'==$action) {//new reject
				Session::set('sub', MODULE_NAME.'/reject');
				$this->assign('ACTION_TITLE', 'Reject Product');
				$code = 'B'.substr($info['code'],-9);
				$info['quantity'] = $info['ori_quantity'] = M("LocationProduct")->where(array('type'=>'location', 'location_id'=>1, 'product_id'=>$info['product_id']))->getField('chg_quantity');
				$id = 0;
			}
			elseif ('reject'==$info['action']) {//edit reject
				Session::set('sub', MODULE_NAME.'/reject');
				$this->assign('ACTION_TITLE', 'Edit Reject Request');
				$code = $info['code'];
				$action = $info['action'];
				$info['ori_quantity'] =  M("LocationProduct")->where(array('type'=>'location', 'location_id'=>1, 'product_id'=>$info['product_id']))->getField('chg_quantity');
			}
			else {//edit enter
				$this->assign('ACTION_TITLE', 'Edit Product Entering');
				if(0 == $info['fixed']) {
					$this->assign('ACTION_TITLE', 'Edit Floating-Assets Entering');
				}
				elseif (1 == $info['fixed']) {
					$this->assign('ACTION_TITLE', 'Edit Fixed-Assets Entering');
				}
				$code = $info['code'];
				$info['ori_quantity'] = 0;
			}
		}
		else {//new enter
			$info = array(
				'supplier_opts' => self::genOptions(D('Supplier')->select()),
				'currency_opts' => self::genOptions(M('Options')->where(array('type'=>'currency'))->order('sort')->select())
				);
			$max_code = $this->dao->where(array('action'=>'enter'))->max('code');
			empty($max_code) && ($max_code = 'A'.sprintf("%09d",0));
			$code = ++ $max_code;
		}
		$this->assign('id', $id);
		$this->assign('action', $action);
		$this->assign('fixed', $fixed);
		$this->assign('code', $code);
		$this->assign('info', $info);

		$this->assign('content', 'ProductIn:form');
		$this->display('Layout:ERP_layout');
	}
	public function submit() {
		if(empty($_POST['submit'])) {
			return;
		}
		$action = $_REQUEST['action'];
		empty($_REQUEST['product_id']) && self::_error('Please select a component/board first!');
		$product_id = $_REQUEST['product_id'];
		$product_info = M('product')->find($product_id);
		$PN = trim($_REQUEST['Internal_PN']);
		$MPN = trim($_REQUEST['MPN']);//board series number
		empty($_REQUEST['supplier_id']) && self::_error('Please select the supplier!');
		//empty($_REQUEST['currency_id']) && self::_error('Please select the currency type!');
		
		intval($_REQUEST['quantity'])<=0 && self::_error('Quantity number must be larger than 0.');
		'reject'==$action && ($_REQUEST['quantity']>$_REQUEST['ori_quantity']) && self::_error('reject quantity can\'t be larger than '.$_REQUEST['ori_quantity']);

		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		if ($id>0) {//from edit
			$this->dao->find($id);
		}
		else{//from new
			if($action=='reject') {
				$this->dao->code = $_REQUEST['code'];
				$this->dao->action = 'reject';
				$this->dao->from_type = 'location';
				$this->dao->from_id = 1;
			}
			else{
				$max_code = $this->dao->where(array('action'=>'enter'))->max('code');
				empty($max_code) && ($max_code = 'A'.sprintf("%09d",0));
				$code = ++ $max_code;
				$this->dao->code = $code;
				$this->dao->action = 'enter';
				$this->dao->to_type = 'location';
				$this->dao->to_id = 1;

				if (empty($_POST['direct_input'])) {
					if ('Board'==$product_info['type'] && $PN!=$product_info['Internal_PN']) {//save new board
						$product_info['id'] = 0;
						$product_info['Internal_PN'] = $PN;
						$product_info['MPN'] = $MPN;

						$max_code = M('Product')->where(array('type'=>'Board'))->max('code');
						empty($max_code) && ($max_code = 'B'.sprintf("%09d",0));
						$data['code'] = ++$max_code;

						$product_id = M('Product')->add($data);
					}
				}
			}
			$this->dao->staff_id = $_SESSION[C('USER_AUTH_KEY')];
			$this->dao->create_time = date("Y-m-d H:i:s");
		}
		$this->dao->fixed = $product_id['fixed'];
		$this->dao->category_id = $product_id['category_id'];
		$this->dao->product_id = $product_id;
		$this->dao->supplier_id = $_REQUEST['supplier_id'];
		$this->dao->currency_id = $_REQUEST['currency_id'];
		$this->dao->quantity = $_REQUEST['quantity'];
		$this->dao->price = $_REQUEST['price'];
		$this->dao->Lot = '';
		$this->dao->accessories = $_REQUEST['accessories'];
		$this->dao->remark = $_REQUEST['remark'];
		if ($id>0) {
			if(false !== $this->dao->save()){
				if (!empty($_POST['direct_input'])) {
					$loc = __APP__.'/Board';
				}
				else {
					$loc = __URL__.('reject'==$this->dao->action?'/reject':(empty($_SESSION[C('CMANAGER_AUTH_NAME')])?($this->dao->fixed ? '/fixed' : '/floating'):'/enter'));
				}
				self::_success('Product information updated!', $loc);
			}
			else{
				self::_error('Update fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		else {
			if($this->dao->add()) {
				if($action=='reject') {
					self::_success('Product reject request ready for confirm!',__URL__.'/reject');
				}
				else{
					if (!empty($_POST['direct_input'])) {
						$loc = __APP__.'/Board';
					}
					else {
						$loc = __URL__.(''==$_REQUEST['fixed'] ? '/enter':('1'==$_REQUEST['fixed']?'/fixed' : '/floating'));
					}
					self::_success('Product entering request ready for confirm!', $loc);
				}
			}
			else{
				if($action=='reject') {
					self::_error('Product reject fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
				}
				else{
					self::_error('Product entering fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
				}
			}
		}
	}
	public function import() {
		//define header
		$header_arr = array(
			'Type',
			'Internal P/N',
			'Description',
			'Manufacture',
			'MPN',
			'Value/Package',
			'Supplier',
			'Quantity',
			'Unit',
			'Category',
			'Fixed Assets',
			'RoHS',
			'LT days',
			'MOQ',
			'SPQ',
			'MSL',
			'Project',
			'Currency',
			'Price',
			'Accessories',
			'Attachment',
			'Remark'
			);
		//define the map of csv_field=>table_column
		$fields_arr = array(
			'type',
			'Internal_PN',
			'description',
			'manufacture',
			'MPN',
			'value',
			'supplier_name',
			'quantity',
			'unit_name',
			'category_name',
			'Fixed',
			'Rohs',
			'LT_days',
			'MOQ',
			'SPQ',
			'MSL',
			'project',
			'currency_name',
			'price',
			'accessories',
			'attachment',
			'remark'
			);
		//do upload
		if (empty($_FILES['file']) || $_FILES['file']['size']==0) {
			self::_error('Please select a file to upload.');
		}
		$confirm = $_REQUEST['confirm'];
		$Fixed = $_REQUEST['Fixed'];

		$file = $_FILES['file'];
		$file_name = $file['name'];
		$fp = fopen($file['tmp_name'], "r");
		$i=0;
		$values_arr = array();//to save the validated line array
		while($value_arr = fgetcsv($fp)) {
			if (empty($value_arr)) {
				continue;
			}
			if ($i == 0) {
				if ($value_arr != $header_arr) {
					self::_error('The imported file\'s header isn\'t right.');
				}
			}
			else {
				if (count($value_arr) != count($header_arr)) {
					self::_error('The imported file isn\'t well-formatted. (Line:'.($i+1).')');
				}
				$values_arr[$i] = array_combine($fields_arr, $value_arr);
				if ('All'!=strtoupper($Fixed) && strtoupper($Fixed) != strtoupper($values_arr[$i]['Fixed'])) {
					self::_error('The product in line '.($i+1).' is not '.('YES'==strtoupper($Fixed)?'Fixed-Assets':'Floating-Assets'));
				}
			}
			$i++;
		}
		//validate upload data
		if (empty($values_arr)) {
			self::_error('There is no record in the file.');
		}
		if (empty($confirm)) {
			//confirm once
			self::_confirm2('Batch Entering product into the system?<br /><br />Record count: <i>'.($i-1).'</i> ;', 1);
		}
		else {
		}
		$duplicated = 0;
		$imported = 0;
		$failure_line_arr = array();
		foreach ($values_arr as $i=>$value_arr) {
			$supplier_data = array('name'=>$value_arr['supplier_name']);
			if(!($supplier_id = M('Supplier')->where($supplier_data)->getField('id'))) {
				$max_code = M('Supplier')->max('code');
				empty($max_code) && ($max_code = 'S'.sprintf("%05d",0));
				$supplier_data['code'] = ++ $max_code;
				$supplier_id = M('Supplier')->add($supplier_data);
			}
			unset($value_arr['supplier_name']);
			$quantity = $value_arr['quantity'];
			unset($value_arr['quantity']);

			$currency_data = array('type'=>'currency','code'=>$value_arr['currency_name']);
			if(!($currency_id = M('Options')->where($currency_data)->getField('id'))) {
				$currency_data['name'] = $value_arr['currency_name'];
				$currency_data['sort'] = M('Options')->where("type='currency'")->max('sort')+1;
				$currency_id = M('Options')->add($currency_data);
			}
			unset($value_arr['currency_name']);

			//check exists
			$where = array();
			//$where['type'] = $value_arr['type'];
			$where['Internal_PN'] = $value_arr['Internal_PN'];
			//$where['description'] = $value_arr['description'];
			//$where['manufacture'] = $value_arr['manufacture'];
			//$where['MPN'] = $value_arr['MPN'];
			$product_id = M('Product')->where($where)->getField('id');

			$category_data = array('type'=>$value_arr['type'],'name'=>$value_arr['category_name']);
			if(!($category_id = M('Category')->where($category_data)->getField('id'))) {
				$max_code = M('Category')->max('code');
				empty($max_code) && ($max_code = 'P'.sprintf("%03d",0));
				$category_data['code'] = ++ $max_code;
				$category_id = M('Category')->add($category_data);
			}
			unset($value_arr['category_name']);
			$value_arr['category_id'] = $category_id;

			$value_arr['fixed'] = 0;
			if ('YES' == strtoupper($value_arr['Fixed']) || 'Y'== strtoupper($value_arr['Fixed'])) {
				$value_arr['fixed'] = 1;
			}
			unset($value_arr['Fixed']);
			if (empty($product_id)) {
				//parse field: unit_name,category_name,Fixed,status_name,currency_name
				$unit_data = array('type'=>'unit','name'=>$value_arr['unit_name']);
				if(!($unit_id = M('Options')->where($unit_data)->getField('id'))) {
					$unit_data['code'] = '';
					$unit_data['sort'] = M('Options')->where("type='unit'")->max('sort')+1;
					$unit_id = M('Options')->add($unit_data);
				}
				unset($value_arr['unit_name']);
				$value_arr['unit_id'] = $unit_id;

				$value_arr['status_id'] = 0;

				$value_arr['currency_id'] = $currency_id;

				//do insert
				$max_code = M('Product')->where(array('type'=>$value_arr['type']))->max('code');
				if ('Component'==$value_arr['type']) {
					empty($max_code) && ($max_code = 'C'.sprintf("%09d",0));
				}
				else{
					empty($max_code) && ($max_code = 'B'.sprintf("%09d",0));
				}
				$value_arr['code'] = ++ $max_code;
				$product_id = M('Product')->add($value_arr);
				if (empty($product_id)) {
					$failure_line_arr[] = $i;
					echo M('Product')->getLastSql()."\n";
					continue;
				}
			}
			$max_code = $this->dao->where(array('action'=>'enter'))->max('code');
			empty($max_code) && ($max_code = 'A'.sprintf("%09d",0));
			$code = ++ $max_code;
			$this->dao->code = $code;
			$this->dao->action = 'enter';
			$this->dao->to_type = 'location';
			$this->dao->to_id = 1;

			$this->dao->fixed = $value_arr['fixed'];
			$this->dao->staff_id = $_SESSION[C('USER_AUTH_KEY')];
			$this->dao->create_time = date("Y-m-d H:i:s");
			$this->dao->category_id = $category_id;
			$this->dao->product_id = $product_id;
			$this->dao->supplier_id = $supplier_id;
			$this->dao->currency_id = $currency_id;
			$this->dao->quantity = $quantity;
			$this->dao->price = $value_arr['price'];
			$this->dao->Lot = '';
			$this->dao->accessories = $value_arr['accessories'];
			$this->dao->remark = $value_arr['remark'];
			if ($this->dao->add()) {
				$imported ++;
			}
			else{
				$failure_line_arr[] = $i;
				echo $this->dao->getLastSql()."\n";
				continue;
			}
		}
		$msg  = 'Batch entering result:<br />';
		$msg .= '&nbsp;&nbsp;Total records: '.(count($values_arr)).'<br />';
		$msg .= '&nbsp;&nbsp;Entered records: '.$imported.'<br />';
		$msg .= '&nbsp;&nbsp;Failure records: '.(count($failure_line_arr)>0 ? '<i>'.count($failure_line_arr).'</i>' : 0);
		count($failure_line_arr)>0 && ($msg .= ' <i>(Line: '.implode(', ', $failure_line_arr).')</i>.');
		$msg .= '<br /><br />This page will auto-refresh after 8 seconds.';
		self::_success($msg, '', 8000);
	}
	public function confirm() {
		if(empty($_POST['submit'])) {
			return;
		}
		empty($_POST['chk']) && self::_error('You haven\'t select any item!');
		foreach ($_POST['chk'] as $id) {
			$info = $this->dao->find($id);
			$where = array(
				'type' => 'location',
				'location_id' => 1,
				'product_id'  => $info['product_id']
			);
			if ('reject'!=$info['action']) {
				$lp_id = M('LocationProduct')->where($where)->getField('id');
				if(!empty($lp_id)) {
					if (!M('LocationProduct')->setInc('chg_quantity','id='.$lp_id,$info['quantity'])) {
						self::_error('Update location product fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
					}
				}
				else {
					M('LocationProduct')->type = 'location';
					M('LocationProduct')->location_id = 1;
					M('LocationProduct')->product_id = $info['product_id'];
					M('LocationProduct')->ori_quantity = 0;
					M('LocationProduct')->chg_quantity = $info['quantity'];
					if (!M('LocationProduct')->add()) {
						self::_error('Insert location product fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
					}
				}

			}
			else {//reject action
				$lp_id = M('LocationProduct')->where($where)->getField('id');
				if(!empty($lp_id)) {
					if (!M('LocationProduct')->setDec('chg_quantity','id='.$lp_id,$info['quantity'])) {
						self::_error('Update location product fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
					}
				}
				else {
					M('LocationProduct')->type = 'location';
					M('LocationProduct')->location_id = 1;
					M('LocationProduct')->product_id = $info['product_id'];
					M('LocationProduct')->ori_quantity = 0;
					M('LocationProduct')->chg_quantity = 0-$info['quantity'];
					if (!M('LocationProduct')->add()) {
						self::_error('Insert location product fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
					}
				}
			}
			$data = array();
			$data['id'] = $id;
			$data['confirm_time'] = date("Y-m-d H:i:s");
			$data['confirmed_staff_id'] = $_SESSION[C('USER_AUTH_KEY')];
			$data['status'] = 1;
			if (!$this->dao->save($data)) {
				self::_error('Confirm fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		self::_success('Confirm success','',1000);
	}

	public function select() {
		R('Product', 'select');
	}

	public function delete() {
		self::_delete();
	}
}
?>