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
		global $MODULE;
		if (empty($MODULE)) {
			Session::set('top', 'Inventory Output Management');
		}
		//else $MODULE='Asset'
		$this->dao = D('ProductFlow');
		parent::_initialize();
	}
	Public function request() {
		$this->index('apply');
	}
	Public function apply() {
		$this->assign('MODULE_TITLE', 'Product Apply');
		$this->index('apply');
	}
	Public function applyFixed() {
		$this->assign('MODULE_TITLE', 'Fixed-Assets Apply');
		$this->index('apply',1);
	}
	Public function applyFloating() {
		$this->assign('MODULE_TITLE', 'Floating-Assets Apply');
		$this->index('apply',0);
	}
	Public function transfer() {
		$this->assign('MODULE_TITLE', 'Product Transfer');
		$this->index('transfer');
	}
	Public function release() {
		$this->assign('MODULE_TITLE', 'Component Release');
		$this->index('release');
	}
	Public function scrap() {
		$this->assign('MODULE_TITLE', 'Product Scrap');
		$this->index('scrap');
	}
	Public function returns() {
		$this->assign('MODULE_TITLE', 'Product Return');
		$this->index('return');
	}
	private function index($action='apply', $fixed='') {
		global $location_id;
		if (!empty($location_id)) {
			Session::set('sub', MODULE_NAME.'/'.ACTION_NAME.'/id/'.$location_id);
		}
		else {
			Session::set('sub', MODULE_NAME.'/'.ACTION_NAME);
		}
		$this->assign('ACTION_TITLE', 'List');

		//prepare unit.id=>unit.name
		$this->assign('unit', M('Options')->where(array('type'=>'unit'))->getField('id,name'));
		//prepare category.id=>category.name
		$this->assign('category', M('Category')->getField('id,name'));

		if(!empty($_REQUEST['action'])) {
			$action = $_REQUEST['action'];
		}
		$this->assign('action', $action);

		if(isset($_REQUEST['status'])) {
			$status = $_REQUEST['status'];
		}
		elseif(''!=(Session::get(ACTION_NAME.'_status'))) {
			$status = Session::get(ACTION_NAME.'_status');
		}
		else{
			$status = 0;
			if ((MODULE_NAME == 'Asset' && ACTION_NAME == 'apply' && $_SESSION[C('STAFF_AUTH_NAME')]['leader_id']>0) || (ACTION_NAME == 'request')) {
				$status = -2;
			}
		}
		//Session::set(ACTION_NAME.'_status', $status);

		import("@.Paginator");
		$limit = 20;
		if (!empty($_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_limit'])) {
			$limit = $_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_limit'];
		}
		if (!empty($_REQUEST['limit'])) {
			$limit = $_REQUEST['limit'];
		}
		$_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_limit'] = $limit;


		$where = array(
			'action' => $action,
			'status' => $status
			);
		if(''!=$fixed) {
			$where['fixed'] = $fixed;
		}
		if (MODULE_NAME == 'Asset') {
			if(ACTION_NAME == 'transferIn') {
				$where['to_type'] = 'staff';
				$where['to_id'] = $_SESSION[C('USER_AUTH_KEY')];
			}
			elseif (ACTION_NAME == 'transferOut') {
				$where['from_type'] = 'staff';
				$where['from_id'] = $_SESSION[C('USER_AUTH_KEY')];
			}
			elseif (ACTION_NAME == 'request') {
				$lead_staff_arr = M('Staff')->where(array('leader_id'=>$_SESSION[C('USER_AUTH_KEY')],'status'=>1))->getField('id,name');
				$where['_string'] = "staff_id in (".implode(',', array_keys($lead_staff_arr)).")";
			}
			elseif (ACTION_NAME == 'location') {
				if (strlen($_SESSION[C('LMANAGER_AUTH_NAME')][$location_id]['fixed'])==1) {
					$where['fixed'] = $_SESSION[C('LMANAGER_AUTH_NAME')][$location_id]['fixed'];
				}
				$where['to_type'] = 'location';
				$where['to_id'] = $location_id;
			}
			else {
				$where['_string'] = "(from_type='staff' and from_id =".$_SESSION[C('USER_AUTH_KEY')].") or (to_type='staff' and to_id = ".$_SESSION[C('USER_AUTH_KEY')].") or staff_id = ".$_SESSION[C('USER_AUTH_KEY')];
			}
		}
		elseif (!empty($_SESSION[C('CMANAGER_AUTH_NAME')])) {
			if (count($_SESSION[C('CMANAGER_AUTH_NAME')]) == 1) {
				$where['category_id'] = array_keys($_SESSION[C('CMANAGER_AUTH_NAME')]);
			}
			else {
				$where['category_id'] = array('In', array_keys($_SESSION[C('CMANAGER_AUTH_NAME')]));
			}
		}
		$count = $this->dao->where($where)->getField('count(*)');
		$p = new Paginator($count,$limit);

		$order = 'id desc';
		$result = array();
		$rs = $this->dao->relation(true)->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();
		empty($rs) && ($rs = array());
		foreach($rs as $item) {
			$item['returned_quantity'] = $this->dao->where(array('code'=>'R'.substr($item['code'],-9),'status'=>1))->sum('quantity');
			empty($item['returned_quantity']) && ($item['returned_quantity']=0);
			$item['transfered_quantity'] = $this->dao->where(array('code'=>'T'.substr($item['code'],-9),'status'=>1))->sum('quantity');
			empty($item['transfered_quantity']) && ($item['transfered_quantity']=0);

			$item['from_name'] = M(ucfirst($item['from_type']))->where('id='.$item['from_id'])->getField('location'==$item['from_type']?'name':'realname');
			$item['to_name'] = M(ucfirst($item['to_type']))->where('id='.$item['to_id'])->getField('location'==$item['to_type']?'name':'realname');

			//$item['remark2'] = M('Remark2')->where(array('flow_id'=>$item['id'], 'status'=>1))->select();
			$result[] = $item;
		}
		$this->assign('status', $status);
		$this->assign('result', $result);
		$this->assign('page', $p->showMultiNavi());

		$this->assign('content','ProductOut:index');
		$this->display('Layout:ERP_layout');
	}
	public function export() {
		header("Content-type:application/vnd.ms-excel;charset=iso-8859-1");
		header("Content-Disposition:filename=Product_".('return'==$_REQUEST['action']?'Return':'Out')."_".date("Ymd").".csv");
		echo "Date&Time,Action,Type,Fixed Assets,Category,Internal P/N,Description,Manufacture,MPN,Quantity,Unit,From,To,Value/Package,RoHS,LT days,MOQ,SPQ,MSL,Project,Accessories,Remark\r\n";

		$UnitArray = M('Options')->where(array('type'=>'unit'))->getField('id,name');
		$FixedArray = array('No', 'Yes');
		$where = array();
		if (!empty($_REQUEST['action'])) {
			$where['action'] = $_REQUEST['action'];
		}
		else {
			$where['action'] = array('not in', array('enter','reject','return'));
		}
		$where['status'] = 1;
		$rs = $this->dao->relation(true)->where($where)->select();
		empty($rs) && ($rs = array());
		foreach($rs as $row) {
			echo $row['create_time'].',';
			echo ucfirst($row['action']).',';
			echo $row['product']['type'].',';
			echo $FixedArray[$row['fixed']].',';
			echo $row['category']['name'].',';
			echo $row['product']['Internal_PN'].',';
			echo $row['product']['description'].',';
			echo $row['product']['manufacture'].',';
			echo $row['product']['MPN'].',';
			echo $row['quantity'].',';
			echo $UnitArray[$row['product']['unit_id']].',';
			
			if ('location' == $row['from_type']) {
				echo M('Location')->where('id='.$row['from_id'])->getField('name').',';
			}
			else {
				echo M('Staff')->where('id='.$row['from_id'])->getField('realname').',';
			}
			if ('location' == $row['to_type']) {
				echo M('Location')->where('id='.$row['to_id'])->getField('name').',';
			}
			else {
				echo M('Staff')->where('id='.$row['to_id'])->getField('realname').',';
			}
			echo $row['product']['value'].',';
			echo $row['product']['Rohs'].',';
			echo $row['product']['LT_days'].',';
			echo $row['product']['MOQ'].',';
			echo $row['product']['SPQ'].',';
			echo $row['product']['MSL'].',';
			echo $row['product']['project'].',';
			echo $row['accessories'].',';
			echo '"'.iconv("UTF-8","GB2312", $row['remark'])." \"\r\n";
		}
		exit;
	}

	public function form() {
		$action = $_REQUEST['action'];
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		if ($id>0) {
			$info = $this->dao->relation(true)->find($id);
			$info['category'] = M('Category')->where("id=".$info['product']['category_id'])->getField('name');
			$info['unit'] = M('Options')->where("id=".$info['product']['unit_id'])->getField('name');
			if('transfer'==$action) {//new transfer
				$this->assign('ACTION_TITLE', 'Transfer Form');
				$code = 'T'.substr($info['code'],-9);
				$location_arr = M('Location')->where(array('id'=>array('gt',1)))->select();
				$location_arr[] = array('id' => 'staff', 'name' => 'Staff');
				$info['location_opts'] = self::genOptions($location_arr, 'location'==$info['to_type'] ? $info['to_id'] : 'staff');
				$info['staff_opts'] = self::genOptions(M('Staff')->where(array('status'=>1, 'id'=>array('neq',$_SESSION[C('USER_AUTH_KEY')])))->select(), $info['to_id'], 'realname');

				$returned_quantity = $this->dao->where(array('code'=>'R'.substr($code,-9),'status'=>1))->sum('quantity');
				$transfered_quantity = $this->dao->where(array('code'=>'T'.substr($code,-9),'status'=>1))->sum('quantity');
				$info['quantity'] = $info['ori_quantity'] = $info['quantity'] - $returned_quantity- $transfered_quantity;

				$info['from_type'] = 'staff';
				$info['from_id'] = $info['staff_id'];

				$id = 0;
			}
			elseif ('return'==$action) {//new return
				$this->assign('ACTION_TITLE', 'Return Form');
				$code = 'R'.substr($info['code'], -9);
				$returned_quantity = $this->dao->where(array('code'=>'R'.substr($code,-9),'status'=>1))->sum('quantity');
				$transfered_quantity = $this->dao->where(array('code'=>'T'.substr($code,-9),'status'=>1))->sum('quantity');
				$info['quantity'] = $info['ori_quantity'] = $info['quantity'] - $returned_quantity - $transfered_quantity;

				$info['from_type'] = 'staff';
				$info['from_id'] = $info['staff_id'];

				$id = 0;
			}
			elseif ('transfer'==$info['action'] || 'return' == $info['action']) {//edit transfer/return
				$code = $info['code'];
				$action = $info['action'];

				$location_arr = M('Location')->where(array('id'=>array('gt',1)))->select();
				$location_arr[] = array('id' => 'staff', 'name' => 'Staff');
				$info['location_opts'] = self::genOptions($location_arr, 'location'==$info['to_type'] ? $info['to_id'] : 'staff');
				$info['staff_opts'] = self::genOptions(M('Staff')->where(array('status'=>1, 'id'=>array('neq',$_SESSION[C('USER_AUTH_KEY')])))->select(), $info['to_id'], 'realname');

				//$from_quantity = $this->dao->where(array('code'=>'Out'.substr($code, -9),'status'=>1))->getField('quantity');
				//$transfered_quantity = $this->dao->where(array('code'=>'T'.substr($code, -9),'status'=>1))->sum('quantity');
				//$backed_quantity = $this->dao->where(array('code'=>'R'.substr($code, -9),'status'=>1))->sum('quantity');
				//$info['ori_quantity'] = $from_quantity - $transfered_quantity - $transfered_quantity;
				$info['ori_quantity'] = M("LocationProduct")->where(array('type'=>$info['from_type'], 'location_id'=>$info['from_id'], 'product_id'=>$info['product_id']))->getField('`ori_quantity`+`chg_quantity`');
			//	if ($info['staff_id'] != $_SESSION[C('USER_AUTH_KEY')]) {//不是当前用户所创建的记录
			//		$info['remark'] = M('Remark2')->where(array('flow_id'=>$id, 'staff_id'=>$_SESSION[C('USER_AUTH_KEY')]))->getField('remark');
			//	}
			}
			else {//edit apply/release/scrap
				$code = $info['code'];
				$action = $info['action'];
				$this->assign('ACTION_TITLE', ucfirst($action).' Form');
				$this->assign('fixed', $info['fixed']);
				//$rs = D('Product')->relation(true)->find($info['product_id']);
				//$info['ori_quantity'] = $rs['location_product'][0]['ori_quantity'] + $rs['location_product'][0]['chg_quantity'];
				$info['ori_quantity'] = M("LocationProduct")->where(array('type'=>$info['from_type'], 'location_id'=>$info['from_id'], 'product_id'=>$info['product_id']))->getField('`ori_quantity`+`chg_quantity`');
			//	if ($info['staff_id'] != $_SESSION[C('USER_AUTH_KEY')]) {//不是当前用户所创建的记录
			//		$info['remark'] = M('Remark2')->where(array('flow_id'=>$id, 'staff_id'=>$_SESSION[C('USER_AUTH_KEY')]))->getField('remark');
			//	}
			}
		}
		else {//new apply/transfer/release/scrap
			$this->assign('ACTION_TITLE', ucfirst($action).' Form');
			$info = array();
			$location_arr = M('Location')->where(array('id'=>array('gt',1)))->select();
			$location_arr[] = array('id' => 'staff', 'name' => 'Staff');
			$info['location_opts'] = self::genOptions($location_arr);
			$info['staff_opts'] = self::genOptions(M('Staff')->where(array('status'=>1, 'id'=>array('neq',$_SESSION[C('USER_AUTH_KEY')])))->select(), '', 'realname');
			$info['from_type'] = 'location';
			$info['from_id'] = 1;

			if (!empty($_REQUEST['lp_id'])) {//act from asset list
				$lp_info = M('LocationProduct')->find($_REQUEST['lp_id']);
				$this->assign('product_id', $lp_info['product_id']);
				$info['product'] = M('Product')->find($lp_info['product_id']);
				$info['category'] = M('Options')->where('id='.$info['product']['category_id'])->getField('name');
				$info['unit'] = M('Options')->where('id='.$info['product']['unit_id'])->getField('name');
				$info['ori_quantity'] = $lp_info['ori_quantity']+$lp_info['chg_quantity'];
				$info['from_type'] = $lp_info['type'];
				$info['from_id'] = $lp_info['location_id'];

				if('transfer'==$action) {
					Session::set('sub', MODULE_NAME.'/transferOut');
				}
				elseif('return'==$action) {
					Session::set('sub', MODULE_NAME.'/returns');
				}
				$code = ++ $max_code;
			}
			if('transfer'==$action) {
				$max_code = $this->dao->where(array('code'=>array('like','T%')))->max('code');
				empty($max_code) && ($max_code = 'T'.sprintf("%09d",0));
			}
			elseif('return'==$action) {
				$max_code = $this->dao->where(array('code'=>array('like','R%')))->max('code');
				empty($max_code) && ($max_code = 'R'.sprintf("%09d",0));
			}
			else {
				$max_code = $this->dao->where(array('code'=>array('like','Out%')))->max('code');
				empty($max_code) && ($max_code = 'Out'.sprintf("%09d",0));
			}
			$code = ++ $max_code;
		}
		//dump($info);
		$this->assign('id', $id);
		$this->assign('action', $action);
		$this->assign('code', $code);
		$this->assign('info', $info);

		$this->assign('content', 'ProductOut:form');
		$this->display('Layout:ERP_layout');
	}
	public function submit() {
		if(empty($_POST['submit'])) {
			return;
		}

		$email_arr = array();
		$action = $_REQUEST['action'];
		empty($_REQUEST['product_id']) && self::_error('Select a Component/Board first!');
		$product_id = $_REQUEST['product_id'];
		$product_info = M('product')->find($product_id);
		
		intval($_REQUEST['quantity'])<=0 && self::_error('Quantity number must be larger than 0.');
		($_REQUEST['quantity']>$_REQUEST['ori_quantity']) && self::_error(ucfirst($action).'quantity can\'t be larger than '.$_REQUEST['ori_quantity']);

		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		if ($id>0) {//from edit
			$this->dao->find($id);
			if (MODULE_NAME=='Asset' && (-1==$this->dao->status || 1==$this->dao->status || (0==$this->dao->status && !empty($this->dao->confirmed_staff_id)))) {
				self::_error('This ER has been approved/confirmed, can\'t submit.');
			}
		}
		else {//from new
			$max_code = $this->dao->where(array('code'=>array('like','Out%')))->max('code');
			empty($max_code) && ($max_code = 'Out'.sprintf("%09d",0));
			$code = ++ $max_code;
			$this->dao->code = $code;
			if('transfer'==$action || 'return'==$action) {
				$rs = $this->dao->where(array('code'=>$_REQUEST['code'],'status'=>0))->select();
				if(!empty($rs)) {
					self::_error('Last '.$action.' haven\'t confirmed yet!');
				}
			}
			$this->dao->action = $action;

			$this->dao->from_type = 'location'; //new apply
			$this->dao->from_id = 1;//new apply
			$this->dao->to_type = 'staff'; //new apply
			$this->dao->to_id = $_SESSION[C('USER_AUTH_KEY')];//new apply
			$this->dao->staff_id = $_SESSION[C('USER_AUTH_KEY')];

			if ('apply' == $action) {
				//如果有Leader，则将status置为-2，Approve后置为0，Reject置为-1
				if ($_SESSION[C('STAFF_AUTH_NAME')]['leader_id']>0) {
					$this->dao->status = -2;
				}
			}
			$this->dao->create_time = date("Y-m-d H:i:s");
		}
		if ('transfer'==$action) {
			$this->dao->code = $_REQUEST['code'];
			$this->dao->from_type = $_REQUEST['from_type'];
			$this->dao->from_id = $_REQUEST['from_id'];
			$this->dao->to_type = $_REQUEST['to_type'];
			if (empty($_REQUEST['to_id'])) {
				self::_error('Transfer target must be specified!');
			}
			$this->dao->to_id = $_REQUEST['to_id'];
		}
		if ('return'==$action) {
			$this->dao->code = $_REQUEST['code'];
			$this->dao->from_type = $_REQUEST['from_type'];
			$this->dao->from_id = $_REQUEST['from_id'];
			$this->dao->to_type = 'location';
			$this->dao->to_id = 1;
		}
		$this->dao->fixed = $product_info['fixed'];
		$this->dao->category_id = $product_info['category_id'];
		$this->dao->product_id = $product_id;
		$this->dao->quantity = $_REQUEST['quantity'];
		//check quantity again
		switch ($this->dao->action) {
			case 'apply':
				$q0 = M('LocationProduct')->where(array('type'=>'location','location_id'=>1,'product_id'=>$this->dao->product_id))->getField('`ori_quantity`+`chg_quantity`');//库存余量
				$q1 = M('ProductFlow')->where(array('action'=>'apply','product_id'=>$this->dao->product_id,'_string'=>('status!=-1 and status!=1')))->sum('quantity');//未确认的
				if (($q0 - $q1) < $this->dao->quantity) {
					self::_error('The product you applied maybe not enough.');
				}
				break;
			case 'transfer':
				break;
			case 'release':
				break;
			case 'scrap':
				break;
			case 'return':
				break;
			default:
				//nothing
		}
		$this->dao->remark = trim($_REQUEST['remark']);
		if ($id>0) {//for edit
			if (false !== $this->dao->save()) {
				self::_mail($id, 'edit');
				$action = $this->dao->action;
				if ('apply'==$this->dao->action) {
					if (MODULE_NAME!='Asset') {
						if (1 == $this->dao->fixed) {
							$action = 'applyFixed';
						}
						else {
							$action = 'applyFloating';
						}
					}
				}
				elseif ('transfer' == $this->dao->action) {
					if (MODULE_NAME=='Asset') {
						if ($this->dao->from_type = 'staff' && $this->dao->from_id = $_SESSION[C('USER_AUTH_KEY')]) {
							$action = 'transferOut';
						}
						elseif ($this->dao->to_type = 'staff' && $this->dao->to_id = $_SESSION[C('USER_AUTH_KEY')]) {
							$action = 'transferIn';
						}
						else {
							//nothing
						}
					}
				}
				elseif ('return'==$action) {
					$action = 'returns';
				}
				self::_success('Product information updated!',__URL__.'/'.$action);
			}
			else {
				self::_error('Update fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		else {//for new
			if ($flow_id = $this->dao->add()) {
				self::_mail($flow_id, 'new');
				if($action=='apply') {
					self::_success('Apply request is ready for confirm!',__URL__.'/'.$action);
				}
				elseif('transfer'==$action) {
					self::_success('Transfer request is ready for confirm!',__URL__.'/'.(MODULE_NAME=='Asset'?'transferOut':$action));
				}
				elseif ('return' == $action) {
					if ('Asset'!=MODULE_NAME) {
						//Session::set('top', 'Inventory Output Management');
					}
					self::_success('Request is ready for confirm!',__URL__.'/returns');
				}
				else{
					self::_success('Operation success!',__URL__.'/'.$action);
				}
			}
			else {
				self::_error('Operation fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
	}
	public function confirm() {
		if (empty($_POST['confirm']) && empty($_POST['reject']) && empty($_POST['approve'])) {
			return;
		}
		empty($_POST['chk']) && self::_error('You haven\'t select any item!');
		sort($_POST['chk']);//先提交的先confirm

		if (!empty($_POST['reject'])) {
			foreach ($_POST['chk'] as $id) {
				if (!$this->dao->where('id='.$id)->setField(array('confirmed_staff_id','status'),array($_SESSION[C('USER_AUTH_KEY')], -1))) {
					self::_error('Reject fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
				}
				self::_mail($id, 'reject');
			}
			self::_success('Reject success','',1000);
			return;
		}
		elseif (!empty($_POST['approve'])) {
			foreach ($_POST['chk'] as $id) {
				if (!$this->dao->where('id='.$id)->setField(array('confirmed_staff_id','status'),array($_SESSION[C('USER_AUTH_KEY')], 0))) {
					self::_error('Approve fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
				}
				self::_mail($id, 'approve');
			}
			self::_success('Approve success','',1000);
			return;
		}
		foreach ($_POST['chk'] as $id) {
			$info = $this->dao->find($id);
			//减库存，或减资产
			$where = array(
				'type' => $info['from_type'],
				'location_id' => $info['from_id'],
				'product_id'  => $info['product_id'],
				);
			$rs = M('LocationProduct')->where($where)->find();
			if (empty($rs)) {
				self::_error('Inventory empty fail!');
			}
			elseif ($rs['ori_quantity']+$rs['chg_quantity']<$info['quantity']) {
				self::_error('Inventory insufficient!');
			}
			else {
				if (!M('LocationProduct')->setDec('chg_quantity','id='.$rs['id'], $info['quantity'])) {
					self::_error('Update inventory fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
				}
			}
			if('release' != $info['action'] && 'scrap' != $info['action']) {
				//加个人资产，或公共资产
				$where = array(
					'type'		  => $info['to_type'],
					'location_id' => $info['to_id'],
					'product_id'  => $info['product_id'],
					);
				$lp_id = M('LocationProduct')->where($where)->getField('id');
				if(!empty($lp_id)) {
					if (!M('LocationProduct')->setInc('chg_quantity','id='.$lp_id,$info['quantity'])) {
						self::_error('Update inventory fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
					}
				}
				else {
					M('LocationProduct')->id = 0;
					M('LocationProduct')->type = $info['to_type'];
					M('LocationProduct')->location_id = $info['to_id'];
					M('LocationProduct')->product_id = $info['product_id'];
					M('LocationProduct')->ori_quantity = 0;
					M('LocationProduct')->chg_quantity = $info['quantity'];
					if (!M('LocationProduct')->add()) {
						self::_error('Insert inventory fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
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
			self::_mail($id, 'confirm');
		}
		self::_success('Confirm success','',1000);
	}

	public function select() {
		R('Product', 'select');
	}

	public function delete() {
		$id = intval($_REQUEST['id']);
		$rs = M('ProductFlow')->find($id);
		if (MODULE_NAME=='Asset' && (($rs['confirmed_staff_id']>0 && $rs['status']==0) || -1==$rs['status'] || 1==$rs['status'])) {
			self::_error('This ER has been approved/confirmed, can\'t delete!');
		}
		else{
			self::_mail($id, 'delete');
			self::_delete();
		}
	}
}
?>