<?php
class StatusAction extends BaseAction{

	protected $dao, $config, $status_arr;

	public function _initialize() {
		if ('Node'!= MODULE_NAME) {
			Session::set('top', 'Board Status');
		}
		$this->dao = D('Task');
		parent::_initialize();
		$this->assign('MODULE_TITLE', 'Board Status');
		$this->status_arr = array(
			'0' => 'Open',
			'1' => 'Closed',
			'-1' => 'Pending'
		);
		$this->assign('status_arr', $this->status_arr);
	}
	Public function all() {
		$this->assign('MODULE_TITLE', 'All Task');
		$this->index('all');
	}

	public function index($type='') {
		$this->assign('ACTION_TITLE', ' List');
		$where = array();
		if (!empty($_REQUEST['title'])) {
			$title = trim($_REQUEST['title']);
			if (strlen($title)>0) {
				$where['title'] = array('like', '%'.$title.'%');
			}
		}
		if (''==$type) { //my task
			Session::set('sub', MODULE_NAME);
			$where['_string'] = "creator_id=".$_SESSION[C('USER_AUTH_KEY')];
			$rs = M('TaskOwner')->where('staff_id='.$_SESSION[C('USER_AUTH_KEY')])->getField('id,task_id');
			if (!empty($rs)) {
				$where['_string'] .= " or id in (".implode(',',  $rs).")";
			}
		}
		else {
			Session::set('sub', MODULE_NAME.'/all');

			if (!empty($_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_category_id'])) {
				$category_id = $_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_category_id'];
			}
			if (isset($_REQUEST['category_id'])) {
				$category_id = intval($_REQUEST['category_id']);
			}
			$_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_category_id'] = $category_id;
			$this->assign('category_opts', self::genOptions(M('Category')->where(array('type'=>'Task'))->select(), $category_id));
			if (!empty($category_id)) {
				$where['category_id'] = $category_id;
			}

			if (!empty($_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_creator_id'])) {
				$creator_id = $_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_creator_id'];
			}
			if (isset($_REQUEST['creator_id'])) {
				$creator_id = intval($_REQUEST['creator_id']);
			}
			$_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_creator_id'] = $creator_id;
			$creator_arr = $this->dao->join("Inner Join erp_staff on erp_staff.id=erp_task.creator_id")->distinct(true)->field("erp_staff.id as id, erp_staff.realname as realname")->order("realname")->select();
			$this->assign('creator_opts', self::genOptions($creator_arr, $creator_id, 'realname'));
			if (!empty($creator_id)) {
				$where['creator_id'] = $creator_id;
			}

			if (!empty($_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_owner_id'])) {
				$owner_id = $_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_owner_id'];
			}
			if (isset($_REQUEST['owner_id'])) {
				$owner_id = intval($_REQUEST['owner_id']);
			}
			$_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_owner_id'] = $owner_id;
			$owner_arr = M('TaskOwner')->join("Inner Join erp_staff on erp_staff.id=erp_task_owner.staff_id")->distinct(true)->field("erp_staff.id as id, erp_staff.realname as realname")->order("realname")->select();
			$this->assign('owner_opts', self::genOptions($owner_arr, $owner_id, 'realname'));
			if (!empty($owner_id)) {
				$rs = M('TaskOwner')->where('staff_id='.$owner_id)->getField('id,task_id');
				$where['id'] = array('in', array_values($rs));
			}
			
		}
		import("@.Paginator");
		$limit = 20;
		if (!empty($_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_limit'])) {
			$limit = $_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_limit'];
		}
		if (!empty($_REQUEST['limit'])) {
			$limit = $_REQUEST['limit'];
		}
		$_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_limit'] = $limit;

		$total = $this->dao->where($where)->count();
		$p = new Paginator($total,$limit);
		
		$result = $this->dao->relation(true)->where($where)->order('status, id desc')->limit($p->offset.','.$p->limit)->select();
		empty($result) && ($result = array());
		foreach ($result as $i=>$row) {
			foreach($row['owner'] as $key=>$val) {
				$result[$i]['owner'][$key]['realname'] = M('Staff')->where('id='.$val['staff_id'])->getField('realname');
			}
			if ($row['status'] == 0) {
				$rs = M('TaskOwner')->where(array('task_id'=>$row['id']))->getField('id,status');
				if (in_array(-1, $rs)) {
					$status = -1;
				}
				elseif (in_array(0, $rs)) {
					$status = 0;
				}
				else {
					$status = 1;
				}
			//	$result[$i]['status'] = $status;
			}
		}

		$this->assign('request', $_REQUEST);
		$this->assign('result', $result);

		$this->assign('page', $p->showMultiNavi());

		$this->assign('type', $type);
		$this->assign('content', 'index');
		$this->display('Layout:ERP_layout');
	}
	
	public function board() {
		Session::set('sub', MODULE_NAME.'/'.ACTION_NAME);

		$dao = D('StatusBoard');
		if (!empty($_POST['submit'])) {
			$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
			$name = trim($_REQUEST['name']);
			!$name && self::_error('Board name required!');
			if ($id>0) {
				$rs = $dao->where(array('name'=>$name, 'id'=>array('neq',$id)))->find();
				if($rs && sizeof($rs)>0){
					self::_error('The board: \''.$name.'\' already exists!');
				}
				$dao->find($id);
			}
			else {
				$rs = $dao->where(array('name'=>$name))->find();
				if($rs && sizeof($rs)>0){
					self::_error('The board: \''.$name.'\' already exists!');
				}
			}
			$dao->name = $name;
			$dao->information = trim($_REQUEST['information']);
			if ($id>0) {
				if(false !== $dao->save()){
					self::_success('Board information updated!',__URL__.'/'.ACTION_NAME);
				}
				else{
					self::_error('Update fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
				}
			}
			else {
				if($dao->add()) {
					self::_success('Add board success!',__URL__.'/'.ACTION_NAME);
				}
				else{
					self::_error('Add board fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
				}
			}
		}
		elseif (!empty($_REQUEST['id'])) {
			$id = intval($_REQUEST['id']);
			$count = M('Status')->where(array('board_id'=>$id))->count();
			if($count>0) {
				self::_error('It\'s in use, can\'t be deleted!');
			}
			else{
				$this->dao = $dao;
				self::_delete();
			}
		}

		$result = $dao->order('name')->select();
		$this->assign('result', $result);

		$this->assign('ACTION_TITLE', 'Board Basic Info');
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:ERP_layout');
	}
	
	public function slot() {
		Session::set('sub', MODULE_NAME.'/'.ACTION_NAME);

		$dao = D('StatusSlot');
		if (!empty($_POST['submit'])) {
			$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
			$name = trim($_REQUEST['name']);
			!$name && self::_error('Slot name required');
			$type = $_REQUEST['type'];
			if ($id>0) {
				$rs = $dao->where(array('type'=>$type, 'name'=>$name, 'id'=>array('neq',$id)))->find();
				if($rs && sizeof($rs)>0){
					self::_error('The slot: \''.$name.'\' already exists!');
				}
				$dao->find($id);
			}
			else {
				$rs = $dao->where(array('type'=>$type, 'name'=>$name))->find();
				if($rs && sizeof($rs)>0){
					self::_error('The slot: \''.$name.'\' already exists!');
				}
			}
			$dao->name = $name;
			$dao->description = trim($_REQUEST['description']);
			$dao->owner_id = intval($_REQUEST['owner_id']);
			$dao->type = $type;
			$dao->sort = max(1, intval($_REQUEST['sort']));
			if ($id>0) {
				if(false !== $dao->save()){
					self::_success('Slot information updated!',__URL__.'/'.ACTION_NAME);
				}
				else{
					self::_error('Update fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
				}
			}
			else {
				if($dao->add()) {
					self::_success('Add slot success!',__URL__.'/'.ACTION_NAME);
				}
				else{
					self::_error('Add slot fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
				}
			}
		}
		elseif (!empty($_REQUEST['id'])) {
			$id = intval($_REQUEST['id']);
			$count1 = M('StatusTemplate')->where(array('slot_id'=>$id))->count();
			$count2 = M('StatusFlow')->where(array('slot_id'=>$id))->count();
			if($count1>0 || $count2>0) {
				self::_error('It\'s in use, can\'t be deleted!');
			}
			else{
				$this->dao = $dao;
				self::_delete();
			}
		}

		$this->assign('staff_opts', self::genOptions(M('Staff')->where(array('status'=>1))->order('realname')->select(), '', 'realname'));
		
		$result = $dao->relation(true)->order('sort')->select();
		$this->assign('result', $result);

		$this->assign('ACTION_TITLE', 'Flow Slot');
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:ERP_layout');
	}

	public function template() {
		Session::set('sub', MODULE_NAME.'/'.ACTION_NAME);
		$dao = D('StatusTemplate');

		if (!empty($_POST['submit'])) {
			$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
			$name = trim($_REQUEST['name']);
			!$name && self::_error('Template name required');
			empty($_REQUEST['slot_id']) && self::_error('You must add at least one slot!');
			if ($id>0) {
				$dao->find($id);
			}
			else {
				$dao->create_time = date('Y-m-d H:i:s');
			}
			$dao->name = $name;
			$dao->slot_ids = implode(',', $_REQUEST['slot_id']);
			$dao->owner_ids = implode(',', $_REQUEST['owner_id']);
			$dao->creator_id = $_SESSION[C('USER_AUTH_KEY')];
			$dao->update_time = date('Y-m-d H:i:s');
			if ($id>0) {
				if(false !== $dao->save()){
					self::_success('Template information updated!',__URL__.'/'.ACTION_NAME);
				}
				else{
					self::_error('Update fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
				}
			}
			else {
				if($dao->add()) {
					self::_success('Template defined success!',__URL__.'/'.ACTION_NAME);
				}
				else{
					self::_error('Template defined fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
				}
			}
		}
		elseif (!empty($_REQUEST['op'])) {
			$op = trim($_REQUEST['op']);

			if ('form' == $op) {
				$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
				if ($id>0) {
					$info = $dao->find($id);
					$slot_arr = explode(',', $info['slot_ids']);
					$owner_arr = explode(',', $info['owner_ids']);
					$info['slot_list'] = array();
					foreach ($slot_arr as $i=>$slot_id) {
						$slot = D('StatusSlot')->find($slot_id);
						$info['slot_list'][] = array(
							'id' => $slot_id,
							'name' => $slot['name'],
							'staff_opts' => self::genOptions(M('Staff')->where(array('status'=>1))->order('realname')->select(), $owner_arr[$i], 'realname')
						);
					}
				}
				else {
					$info = array(
						'id' => 0,
						'name' => '',
						'slot_list' => array()
					);
				}
				$this->assign('info', $info);
				//load slot
				$this->assign('slot_list', D('StatusSlot')->relation(true)->order('sort')->select());
				$this->assign('content', ACTION_NAME.'_form');
			}
			elseif ('get_slot' == $op) {
				$id = intval($_REQUEST['id']);
				$slot = D('StatusSlot')->find($id);
				$arr = array(
					'id' => $id,
					'name' => $slot['name'],
					'staff_opts' => self::genOptions(M('Staff')->where(array('status'=>1))->order('realname')->select(), $slot['owner_id'], 'realname')
				);
				die(json_encode($arr));
			}
			elseif ('delete' == $op) {
				if (!empty($_REQUEST['id'])) {
					$id = intval($_REQUEST['id']);
					$this->dao = $dao;
					self::_delete();
				}
			}
		}
		else {
			$result = $dao->relation(true)->order('id')->select();
			$this->assign('result', $result);
			$this->assign('content', ACTION_NAME);
		}
		$this->assign('ACTION_TITLE', 'Flow Template');
		$this->display('Layout:ERP_layout');
	}
}
?>