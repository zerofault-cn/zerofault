<?php
class TaskAction extends BaseAction{

	protected $dao, $config;

	public function _initialize() {
		if ('Node'!= MODULE_NAME) {
			Session::set('top', 'Tasks');
		}
		$this->dao = D('Task');
		parent::_initialize();
		$this->assign('MODULE_TITLE', 'Task System');
		$status_arr = array(
			'0' => 'Open',
			'1' => 'Close',
			'-1' => 'Pending'
		);
		$this->assign('status_arr', $status_arr);
	}
	Public function all() {
		$this->assign('MODULE_TITLE', 'All Task');
		$this->index('all');
	}

	public function index($type='') {
		$where = array();
		if (!empty($_REQUEST['title'])) {
			$title = trim($_REQUEST['title']);
			if (strlen($title)>0) {
				$where['title'] = array('like', '%'.$title.'%');
			}
		}
		if (''==$type) { //my task
			Session::set('sub', MODULE_NAME);
			
			$rs = M('TaskOwner')->where('staff_id='.$_SESSION[C('USER_AUTH_KEY')])->getField('id,task_id');
			$where['_string'] = "creator_id=".$_SESSION[C('USER_AUTH_KEY')]." or id in (".implode(',',  $rs).")";
			
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
			$this->assign('creator_opts', self::genOptions($creator_arr, $category_id, 'realname'));
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

		$total = $this->dao->where($where)->count();
		$p = new Paginator($total,$limit);
		
		$result = (array)$this->dao->relation(true)->where($where)->order('status, id desc')->limit($p->offset.','.$p->limit)->field($field)->select();
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
	
	public function detail() {
		$this->assign('ACTION_TITLE', 'Task detail');
		$id = intval($_REQUEST['id']);
		$info = $this->dao->relation(true)->find($id);
		$owner_list = array();
		foreach($info['owner'] as $key=>$val) {
			$info['owner'][$key]['realname'] = M('Staff')->where('id='.$val['staff_id'])->getField('realname');
			$owner_list[] = $val['staff_id'];
		}
		foreach ($info['comment'] as $key=>$val) {
			$info['comment'][$key]['realname'] = M('Staff')->where('id='.$val['staff_id'])->getField('realname');
		}
		if ($info['press_interval']%86400 == 0) {
			$info['press_unit'] = 'Day';
			$info['press_time'] = $info['press_interval']/86400;
			if ($info['press_time']>1) {
				$info['press_unit'] = 'Days';
			}
		}
		elseif ($info['press_interval']%3600 == 0) {
			$info['press_unit'] = 'Hour';
			$info['press_time'] = $info['press_interval']/3600;
			if ($info['press_time']>1) {
				$info['press_unit'] = 'Hours';
			}
		}
		elseif ($info['press_interval']%60 == 0) {
			$info['press_unit'] = 'Minute';
			$info['press_time'] = $info['press_interval']/60;
			if ($info['press_time']>1) {
				$info['press_unit'] = 'Minutes';
			}
		}
		$this->assign('info', $info);
		$this->assign('owner_list', $owner_list);
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:content');
	}
	public function form() {
		$this->assign('ACTION_TITLE', 'Create a new task');
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		if ($id>0) {
			$info = $this->dao->relation(true)->find($id);
			$this->assign('ACTION_TITLE', 'Edit task');
			$info['category_opts'] = self::genOptions(M('Category')->where(array('type'=>'Task'))->select(), $info['category_id'], 'name');
			if ($info['press_interval']%86400 == 0) {
				$info['press_unit'] = 'day';
				$info['press_time'] = $info['press_interval']/86400;
			}
			elseif ($info['press_interval']%3600 == 0) {
				$info['press_unit'] = 'hour';
				$info['press_time'] = $info['press_interval']/3600;
			}
			elseif ($info['press_interval']%60 == 0) {
				$info['press_unit'] = 'minute';
				$info['press_time'] = $info['press_interval']/60;
			}

			$info['owners_id'] = array();
			foreach($info['owner'] as $i=>$owner) {
				$info['owner'][$i]['realname'] = M('Staff')->where('id='.$owner['staff_id'])->getField('realname');
				$info['owners_id'][] = $owner['staff_id'];
			}
		}
		else {
			$info = array(
				'id' => 0,
				'title' => '',
				'project' => '',
				'category_opts' => self::genOptions(M('Category')->where(array('type'=>'Task'))->select()),
				'create_time' => date('Y-m-d'),
				'due_date' => '',
				'press_time' => 1,
				'press_unit' => 'day',
				'owners' => array(),
				'notification' => '11'
				);
		}
		$this->assign('info', $info);
		$this->assign('MAX_FILE_SIZE', self::MAX_FILE_SIZE());
		$this->assign('upload_max_filesize', min(ini_get('memory_limit'), ini_get('post_max_size'), ini_get('upload_max_filesize')));

		$dept_staff_arr = array();
		$has_other = false;
		$rs = M('Staff')->where('status=1')->distinct(true)->field('dept_id')->select();
		foreach ($rs as $arr) {
			if (0==$arr['dept_id']) {
				$has_other = true;
				continue;
			}
			$dept = M('Department')->find($arr['dept_id']);
			$dept_staff_arr[$dept['name']] = M('Staff')->where(array('id'=>array('neq', $dept['leader_id']), 'dept_id'=>$dept['id'], 'status'=>1))->order('realname')->field('id,realname,email')->select();
			if ($dept['leader_id']>0) {
				array_unshift($dept_staff_arr[$dept['name']], M('Staff')->field('id,realname,email')->find($dept['leader_id']));
			}
		}
		ksort($dept_staff_arr);
		if ($has_other) {
			$dept_staff_arr['No Department'] = M('Staff')->where(array('dept_id'=>0, 'status'=>1))->order('realname')->field('id,realname,email')->select();
		}
		$this->assign('DeptStaff', $dept_staff_arr);

		$this->assign('content', ACTION_NAME);
		$this->display('Layout:ERP_layout');
	}

	public function submit(){
		if (empty($_POST['submit'])) {
			return;
		}
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		$title = trim($_REQUEST['title']);
		empty($title) && self::_error('Input title first!');
		empty($_REQUEST['category_id']) && self::_error('Category must be specified!');
		//empty($_REQUEST['owner']) && self::_error('No owner specified!');
		if ($id>0) {
			$this->dao->find($id);
		}
		else {
			$this->dao->creator_id = $_SESSION[C('USER_AUTH_KEY')];
			$this->dao->create_time = date("Y-m-d H:i:s");
			$this->dao->status = 0;
		}
		$this->dao->title = $title;
		$this->dao->project = trim($_REQUEST['project']);
		$this->dao->category_id = $_REQUEST['category_id'];
		$this->dao->descr = $_REQUEST['description'];
		$this->dao->due_date = $_REQUEST['due_date'];
		$time = intval($_REQUEST['press_time']);
		switch ($_REQUEST['press_unit']) {
			case 'day':
				$interval = $time * 86400;
				break;
			case 'hour':
				$interval = $time * 3600;
				break;
			case 'minute':
				$interval = $time * 60;
				break;
			default:
				//nothing
		}
		$this->dao->press_interval = $interval;
		$this->dao->notification = strval((empty($_REQUEST['chk1'])?'0':'1').(empty($_REQUEST['chk2'])?'0':'1'));
		if ($id>0) {
			if(false !== $this->dao->save()){
				//process multi-owner
				foreach ($_REQUEST['owner'] as $staff_id) {
					$data = array(
						'task_id'=>$id,
						'staff_id'=>$staff_id,
						'status' => 0
						);
					M('TaskOwner')->add($data);
				}
				//process multi-file
				foreach ($_FILES['file']['size'] as $i=>$size) {
					if($size > 0) {
						$data = array(
							'name' => $_FILES['file']['name'][$i],
							'type' => $_FILES['file']['type'][$i],
							'size' => $size,
							'path' => 'Attach/Task/'.uniqid().'_'.$_FILES['file']['name'][$i],
							'model_name' => MODULE_NAME,
							'model_id' => $id,
							'staff_id' => $_SESSION[C('USER_AUTH_KEY')],
							'upload_time' => date('Y-m-d H:i:s'),
							'status' => 1
							);
						if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $data['path'])) {
							if (!M('Attachment')->add($data)) {
								self::_error('Insert fail!'.$this->dao->getLastSql());
							}
						}
						else {
							self::_error('Move '.$_FILES['file']['tmp_name'][$i].' to '.$data['path'].' fail!');
						}
					}
				}
				self::_success('Task information updated!',__URL__);
			}
			else{
				self::_error('Update fail!'.$this->dao->getLastSql());
			}
		}
		else{
			if($id=$this->dao->add()) {
				//process multi-owner
				foreach ($_REQUEST['owner'] as $staff_id) {
					$data = array(
						'task_id'=>$id,
						'staff_id'=>$staff_id,
						'status' => 0
						);
					M('TaskOwner')->add($data);
				}
				//process multi-file
				foreach ($_FILES['file']['size'] as $i=>$size) {
					if($size > 0) {
						$data = array(
							'name' => $_FILES['file']['name'][$i],
							'type' => $_FILES['file']['type'][$i],
							'size' => $size,
							'path' => 'Attach/Task/'.uniqid().'_'.$_FILES['file']['name'][$i],
							'model_name' => MODULE_NAME,
							'model_id' => $id,
							'staff_id' => $_SESSION[C('USER_AUTH_KEY')],
							'upload_time' => date('Y-m-d H:i:s'),
							'status' => 1
							);
						if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $data['path'])) {
							if (!M('Attachment')->add($data)) {
								self::_error('Insert fail!'.$this->dao->getLastSql());
							}
						}
						else {
							self::_error('Move '.$_FILES['file']['tmp_name'][$i].' to '.$data['path'].' fail!');
						}
					}
				}
				self::mail_task('task_add', $id);
				self::_success('Create task success!',__URL__);
			}
			else{
				self::_error('Create task fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
	}
	public function comment() {
		if (!empty($_GET['id'])) {
			die(M('Comment')->where('id='.$_GET['id'])->getField('content'));
		}
		if (empty($_POST['submit'])) {
			return;
		}
		$dao = M('Comment');
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		$task_id = empty($_REQUEST['task_id']) ? 0 : intval($_REQUEST['task_id']);
		$content = trim($_REQUEST['content']);
		!$content && self::_error('Comment can\'t be empty!');
		if ($id>0) {
			$dao->find($id);
		}
		else {
			$dao->model_name = 'Task';
			$dao->model_id = $task_id;
			$dao->staff_id = $_SESSION[C('USER_AUTH_KEY')];
			$dao->create_time = date('Y-m-d H:i:s');
			$dao->status = 1;
		}
		$dao->content = $content;
		if ($id>0) {
			if(false !== $dao->save()){
				$html  = '<script language="JavaScript" type="text/javascript">';
				$html .= 'parent.myAlert("Update comment success!");';
				$html .= 'parent.myOK(500);';
				$html .= 'parent.show_comment('.$id.', "'.str_replace(array("\r\n", "\n"), '<br />', $content).'");';
				$html .= '</script>';
				die($html);
			}
			else{
				self::_error('Update comment fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
			}
		}
		else {
			if($id=$dao->add()) {
				$html  = '<script language="JavaScript" type="text/javascript">';
				$html .= 'parent.myAlert("Post comment success!");';
				$html .= 'parent.myOK(500);';
				$html .= 'parent.show_comment('.$id.', "'.nl2br($content).'");';
				$html .= '</script>';
				die($html);
			}
			else{
				self::_error('Post comment fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
			}
		}
	}
	public function category(){
		Session::set('sub', MODULE_NAME.'/'.ACTION_NAME);
		$type = 'Task';
		$dao = M('Category');
		if (!empty($_POST['submit'])) {
			$name = trim($_REQUEST['name']);
			!$name && self::_error('Category Name required');
			$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
			if ($id>0) {
				$rs = $dao->where(array('type'=>$type,'name'=>$name,'id'=>array('neq',$id)))->find();
				if($rs && sizeof($rs)>0){
					self::_error('Category Name: "'.$name.'" already exists!');
				}
				$dao->find($id);
			}
			else {
				$rs = $dao->where(array('type'=>$type,'name'=>$name))->find();
				if($rs && sizeof($rs)>0){
					self::_error('Category Name: "'.$name.'" already exists!');
				}
			}
			$dao->type = $type;
			$dao->code = '';
			$dao->name = $name;
			if ($id>0) {
				if(false !== $dao->save()){
					self::_success('Category information updated!',__URL__.'/category');
				}
				else{
					self::_error('Update fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
				}
			}
			else {
				if($dao->add()) {
					self::_success('Add category success!',__URL__.'/category');
				}
				else{
					self::_error('Add category fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
				}
			}
		}
		elseif (!empty($_REQUEST['id'])) {
			$id = $_REQUEST['id'];
			$rs = $this->dao->where(array('category_id'=>$id))->select();
			if(!empty($rs) && sizeof($rs)>0) {
				self::_error('It\'s in use, can\'t be deleted!');
			}
			else{
				$this->dao = M('Category');
				self::_delete();
			}
		}
		$this->assign('ACTION_TITLE', 'Task Category');
		$result = $dao->where(array('type'=>'Task'))->order('id')->select();

		$this->assign('result', $result);
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:ERP_layout');
	}

	public function update() {
		$id = $_REQUEST['id'];
		$task_id = $_REQUEST['task_id'];
		$field = $_REQUEST['f'];
		$value = $_REQUEST['v'];
		if ($id > 0) {
			$dao = M('TaskOwner');
			$rs = $dao->where('id='.$id)->setField(array($field, 'action_time'), array($value, date('Y-m-d H:i:s')));
		}
		else {
			$dao = $this->dao;
			$rs = $dao->where('id='.$task_id)->setField(array($field, 'update_time'), array($value, date('Y-m-d H:i:s')));
		}
		if(false !== $rs) {
			self::_success('Update success!');
		}
		else {
			self::_error('Update fail!'.(C('APP_DEBUG')? $dao->getLastSql() : ''));
		}
	}
	public function delete() {
		$id = $_REQUEST['id'];
		M('TaskOwner')->where('task_id='.$id)->delete();
		$rs = (array)M('Attachment')->where(array('model_name'=>'Task', 'model_id'=>$id))->select();
		foreach ($rs as $row) {
			@unlink($row['path']);
			M('Attachment')->where('id='.$row['id'])->delete();
		}
		self::_delete();
	}
	public function delete_owner() {
		$id = $_REQUEST['id'];
		$staff_id = $_REQUEST['staff_id'];
		$dao = M('TaskOwner');
		if (false !== $dao->where(array('task_id'=>$id, 'staff_id'=>$staff_id))->delete()) {
			$html  = '<script language="JavaScript" type="text/javascript">';
			$html .= 'parent.myAlert("Delete success!");';
			$html .= 'parent.myOK(500);';
			$html .= 'parent.remove_owner('.$staff_id.');';
			$html .= '</script>';
			die($html);
		}
		else {
			self::_error('Delete fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
		}
	}
	public function delete_comment() {
		$id = $_REQUEST['id'];
		$dao = M('Comment');
		if($dao->find($id) && $dao->delete()) {
			$html  = '<script language="JavaScript" type="text/javascript">';
			$html .= 'parent.myAlert("Delete comment success!");';
			$html .= 'parent.myOK(500);';
			$html .= 'parent.remove_comment('.$id.');';
			$html .= '</script>';
			die($html);
		}
		else {
			self::_error('Delete comment fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
		}
	}
	public function mail_task($type='', $task_id=0, $owner_ids=array()) {
		if (!defined('APP_ROOT')) {
			define('APP_ROOT', 'http://'.$_SERVER['SERVER_ADDR'].__APP__);
		}
		$smtp_config = C('_smtp_');
		include_once (LIB_PATH.'class.phpmailer.php');
		$mail = new PHPMailer();
		$mail->IsSMTP();
	//	$mail->SMTPDebug  = 1;  // 2 = messages only
		$mail->Host       = $smtp_config['host'];
		$mail->Port       = $smtp_config['port'];
		$mail->SetFrom($smtp_config['from_mail'], $smtp_config['from_name']);

		/*type²ÎÊý£º
			task_add
			owner_add
			owner_remove
			task_status
			owner_status
			remind
			press
		*/
		switch ($type) {
			case 'task_add':
				$info = $this->dao->relation(true)->find($task_id);
				if ($info['press_interval']%86400 == 0) {
					$info['press_unit'] = 'Day';
					$info['press_time'] = $info['press_interval']/86400;
					if ($info['press_time']>1) {
						$info['press_unit'] = 'Days';
					}
				}
				elseif ($info['press_interval']%3600 == 0) {
					$info['press_unit'] = 'Hour';
					$info['press_time'] = $info['press_interval']/3600;
					if ($info['press_time']>1) {
						$info['press_unit'] = 'Hours';
					}
				}
				elseif ($info['press_interval']%60 == 0) {
					$info['press_unit'] = 'Minute';
					$info['press_time'] = $info['press_interval']/60;
					if ($info['press_time']>1) {
						$info['press_unit'] = 'Minutes';
					}
				}
				$creator = M('Staff')->find($info['creator_id']);
				$owner_arr = array();
				foreach($info['owner'] as $val) {
					$owner_arr[] = M('Staff')->find($val['staff_id']);
				}
				$subject = '[Task] Create: '.$info['title'];
				$owners = array();
				foreach ($owner_arr as $staff) {
					$mail->AddAddress($staff['email'], $staff['realname']);
					$owners[] = $staff['realname'];
				}
				if ($info['notification'][0] == '1') {
					$manager_arr = M('Staff')->where(array('id'=>array('in', C('TASK_ADMIN_ID'))))->select();
					foreach ($manager_arr as $staff) {
						$mail->AddCC($staff['email'], $staff['realname']);
					}
				}
				if ($info['notification'][1] == '1') {
					$leader = M('Staff')->find($creator['leader_id']);
					$mail->AddCC($leader['email'], $leader['realname']);
				}

				$body = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body>';
				$body .= '<table border="1" cellspacing="1" cellpadding="7" style="border-collapse:collapse;border:1px solid #999999;">';
				$body .= '<tr bgcolor="#CCCCCC"><td colspan="2">'.$creator['realname'].' Create: '.$info['title'].'</td></tr>';
				$body .= '<tr><td width="120">Task Name: </td><td width="500">'.$info['title'].' (T'.sprintf('%06s', $info['id']).')</td></tr>';
				$body .= '<tr><td>Category: </td><td>'.$info['category']['name'].'</td></tr>';
				$body .= '<tr><td>Project: </td><td>'.$info['project'].'</td></tr>';
				$body .= '<tr><td>Create Time: </td><td>'.$info['create_time'].'</td></tr>';
				$body .= '<tr><td>Creator: </td><td>'.$info['creator']['realname'].'</td></tr>';
				$body .= '<tr><td>Due Date: </td><td>'.$info['due_date'].'</td></tr>';
				$body .= '<tr><td>Press Interval: </td><td>'.$info['press_time'].' '.$info['press_unit'].'</td></tr>';
				$body .= '<tr><td>Owners: </td><td>'.implode(', ', $owners).'</td></tr>';
				$body .= '<tr><td valign="top">Attached Files: </td><td>';
				foreach ($info['attachment'] as $file) {
					$body .= '<a href="'.APP_ROOT.'/../'.$file['path'].'" target="_blank" title="View attachment in new window">'.$file['name'].'</a> <br />';
				}
				$body .= '</td></tr>';
				$body .= '<tr><td valign="top">Description: </td><td>'.nl2br($info['descr']).'</td></tr>';
				$body .= '</table>';
				break;

			case 'task_status':
				$info = $this->dao->relation(true)->find($task_id);
				$creator = M('Staff')->find($info['creator_id']);
				$owner_arr = array();
				foreach($info['owner'] as $val) {
					$owner_arr[] = M('Staff')->find($val['staff_id']);
				}
				$subject = '[Task] Change Status : '.$info['title'];
				if ('0' == $info['status']) {
					$subject .= ' is open';
				}
				elseif ('1' == $info['status']) {
					$subject .= 'is close';
				}
				elseif ('-1' == $info['status']) {
					$subject .= 'is pending';
				}
				$owners = array();
				foreach ($owner_arr as $staff) {
					$mail->AddAddress($staff['email'], $staff['realname']);
					$owners[] = $staff['realname'];
				}
				if ($info['notification'][0] == '1') {
					$manager_arr = M('Staff')->where(array('id'=>array('in', C('TASK_ADMIN_ID'))))->select();
					foreach ($manager_arr as $staff) {
						$mail->AddCC($staff['email'], $staff['realname']);
					}
				}
				if ($info['notification'][1] == '1') {
					$leader = M('Staff')->find($creator['leader_id']);
					$mail->AddCC($leader['email'], $leader['realname']);
				}

				$body = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body>';
				$body .= '<table border="1" cellspacing="1" cellpadding="7" style="border-collapse:collapse;border:1px solid #999999;">';
				$body .= '<tr bgcolor="#CCCCCC"><td colspan="2"> Task Summary</td></tr>';
				$body .= '<tr><td width="120">Task Name: </td><td width="500">'.$info['title'].' (T'.sprintf('%06s', $info['id']).')</td></tr>';
				$body .= '<tr><td>Category: </td><td>'.$info['category']['name'].'</td></tr>';
				$body .= '<tr><td>Project: </td><td>'.$info['project'].'</td></tr>';
				$body .= '<tr><td>Create Time: </td><td>'.$info['create_time'].'</td></tr>';
				$body .= '<tr><td>Creator: </td><td>'.$info['creator']['realname'].'</td></tr>';
				$body .= '<tr><td>Update Time: </td><td>'.$info['create_time'].'</td></tr>';
				$body .= '<tr><td>Current Status: </td><td>'.$status_arr[$info['status']].'</td></tr>';
				$body .= '<tr><td>Owners: </td><td>'.implode(', ', $owners).'</td></tr>';
				$body .= '<tr><td>Due Date: </td><td>'.$info['due_date'].'</td></tr>';
				$body .= '<tr><td valign="top">Description: </td><td>'.nl2br($info['descr']).'</td></tr>';
				$body .= '</table>';
				break;

			case 'owner_add':
				$info = $this->dao->relation(true)->find($task_id);
				$creator = M('Staff')->find($info['creator_id']);
				$owner_arr = M('Staff')->where(array('id', array('in', $info['owner'])))->getField('email', 'realname');
				
				$add_owner_arr = M('Staff')->where(array('id', array('in', $owner_ids)))->getField('email', 'realname');
				$subject = '[Task] Add '.implode(',', $add_owner_arr).' to : '.$info['title'];
				foreach ($add_owner_arr as $email=>$realname) {
					$mail->AddAddress($email, $realname);
				}
				if ($info['notification'][0] == '1') {
					$manager_arr = M('Staff')->where(array('id'=>array('in', C('TASK_ADMIN_ID'))))->select();
					foreach ($manager_arr as $staff) {
						$mail->AddCC($staff['email'], $staff['realname']);
					}
				}
				if ($info['notification'][1] == '1') {
					$leader = M('Staff')->find($creator['leader_id']);
					$mail->AddCC($leader['email'], $leader['realname']);
				}

				$body = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body>';
				$body .= '<table border="1" cellspacing="1" cellpadding="7" style="border-collapse:collapse;border:1px solid #999999;">';
				$body .= '<tr bgcolor="#CCCCCC"><td colspan="2"> Task Summary</td></tr>';
				$body .= '<tr><td width="120">Task Name: </td><td width="500">'.$info['title'].' (T'.sprintf('%06s', $info['id']).')</td></tr>';
				$body .= '<tr><td>Category: </td><td>'.$info['category']['name'].'</td></tr>';
				$body .= '<tr><td>Project: </td><td>'.$info['project'].'</td></tr>';
				$body .= '<tr><td>Create Time: </td><td>'.$info['create_time'].'</td></tr>';
				$body .= '<tr><td>Creator: </td><td>'.$info['creator']['realname'].'</td></tr>';
				$body .= '<tr><td>Current Status: </td><td>'.$status_arr[$info['status']].'</td></tr>';
				$body .= '<tr><td>Current Owners: </td><td>'.implode(', ', $owners).'</td></tr>';
				$body .= '<tr><td>Due Date: </td><td>'.$info['due_date'].'</td></tr>';
				$body .= '<tr><td valign="top">Description: </td><td>'.nl2br($info['descr']).'</td></tr>';
				$body .= '</table>';
				break;

			case 'owner_remove':
				break;

			case 'owner_status':
				break;

			case 'remind':
				break;

			case 'press':
				break;

			default:
				//nothing
		}
		$mail->Subject = $subject;
		$mail->MsgHTML($body);
		if(!$mail->Send()) {
			Log::Write('Mail task Error: '.$mail->ErrorInfo);
			return false;
		}
		Log::Write('Mail task Success: '.$type.' '.$task_id, INFO);
		return true;

	}
}
?>