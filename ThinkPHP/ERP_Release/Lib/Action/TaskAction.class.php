<?php
class TaskAction extends BaseAction{

	protected $dao, $config, $status_arr;

	public function _initialize() {
		if ('Node'!= MODULE_NAME) {
			Session::set('top', 'Tasks');
		}
		$this->dao = D('Task');
		parent::_initialize();
		$this->assign('MODULE_TITLE', 'Task System');
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
		$this->assign('ACTION_TITLE', 'Task List');
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
	
	public function detail() {
		$this->assign('ACTION_TITLE', 'Task detail');
		$id = intval($_REQUEST['id']);
		$info = $this->dao->relation(true)->find($id);
		$owner_list = array();
		foreach($info['owner'] as $key=>$val) {
			$info['owner'][$key]['realname'] = M('Staff')->where('id='.$val['staff_id'])->getField('realname');
		}
		foreach($info['participant'] as $key=>$val) {
			$participants[] = M('Staff')->where('id='.$val['staff_id'])->getField('realname');
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
		$this->assign('participants', implode(', ', $participants));
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
			foreach($info['participant'] as $i=>$participant) {
				$info['participant'][$i]['realname'] = M('Staff')->where('id='.$participant['staff_id'])->getField('realname');
				$info['participants_id'][] = $participant['staff_id'];
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
			if (empty($dept_staff_arr[$dept['name']])) {
				$dept_staff_arr[$dept['name']] = array();
			}
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
		$this->dao->notification = strval((empty($_REQUEST['chk0'])?'0':'1').(empty($_REQUEST['chk1'])?'0':'1').(empty($_REQUEST['chk2'])?'0':'1').(empty($_REQUEST['chk3'])?'0':'1'));
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
				//process multi-participant
				foreach ($_REQUEST['participant'] as $staff_id) {
					$data = array(
						'task_id'=>$id,
						'staff_id'=>$staff_id,
						'status' => 0
						);
					M('TaskParticipant')->add($data);
				}
				//process multi-file
				foreach ($_FILES['file']['size'] as $i=>$size) {
					if($size > 0) {
						$data = array(
							'name' => $_FILES['file']['name'][$i],
							'type' => $_FILES['file']['type'][$i],
							'size' => $size,
							'path' => 'Attach/Task/'.date("YmdHis").substr(microtime(),1,7).'.'.strtolower(pathinfo($_FILES['file']['name'][$i], PATHINFO_EXTENSION)),
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
				if (!empty($_REQUEST['owner']) && count($_REQUEST['owner'])>0) {
					self::mail_task('owner_add', $id, $_REQUEST['owner']);
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
				//process multi-participant
				foreach ($_REQUEST['participant'] as $staff_id) {
					$data = array(
						'task_id'=>$id,
						'staff_id'=>$staff_id,
						'status' => 0
						);
					M('TaskParticipant')->add($data);
				}
				//process multi-file
				foreach ($_FILES['file']['size'] as $i=>$size) {
					if($size > 0) {
						$data = array(
							'name' => $_FILES['file']['name'][$i],
							'type' => $_FILES['file']['type'][$i],
							'size' => $size,
							'path' => 'Attach/Task/'.date("YmdHis").substr(microtime(),1,7).'.'.strtolower(pathinfo($_FILES['file']['name'][$i], PATHINFO_EXTENSION)),
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
		empty($_REQUEST['task_id']) && self::_error('No task id specified!');
		$task_id = intval($_REQUEST['task_id']);
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
				self::mail_task('comment_modify', $task_id, $_SESSION[C('USER_AUTH_KEY')]);
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
				$html .= 'parent.show_comment('.$id.', "'.str_replace(array("\r\n", "\n"), '<br />', $content).'");';
				$html .= '</script>';
				self::mail_task('comment_add', $task_id, $_SESSION[C('USER_AUTH_KEY')]);
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
					self::_error('Category Name: \''.$name.'\' already exists!');
				}
				$dao->find($id);
			}
			else {
				$rs = $dao->where(array('type'=>$type,'name'=>$name))->find();
				if($rs && sizeof($rs)>0){
					self::_error('Category Name: \''.$name.'\' already exists!');
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
		$staff_id = $_REQUEST['staff_id'];
		$task_id = $_REQUEST['task_id'];
		$field = $_REQUEST['f'];
		$value = $_REQUEST['v'];
		if ($staff_id > 0) {
			//改变Owner状态
			$dao = M('TaskOwner');
			$info = $dao->where("task_id=".$task_id." and staff_id=".$staff_id)->find();
			$rs = true;
			if ($info[$field] != $value) {
				$rs = $dao->where('id='.$info['id'])->setField(array($field, 'action_time'), array($value, date('Y-m-d H:i:s')));
				self::mail_task('owner_status', $task_id, $staff_id);
			}
			if ('status'==$field && 0==$value) {
				//有Owner改变状态为Open，则检查Task状态，如果为Close，则自动Open
				if (1 == $this->dao->where('id='.$task_id)->getField('status')) {
					$this->dao->where('id='.$task_id)->setField(array('status', 'update_time'), array(0, date('Y-m-d H:i:s')));
					self::mail_task('task_status', $task_id);
				}
			}
			else {
				//检查是否已没有Open或Pending
				if ($dao->where("task_id=".$task_id." and (status=0 or status=-1)")->count() == 0) {
					$this->dao->where('id='.$task_id)->setField(array('status', 'update_time'), array(1, date('Y-m-d H:i:s')));
					self::mail_task('task_status', $task_id);
				}
			}
		}
		else {
			//改变Task状态
			$dao = $this->dao;
			$info = $dao->where('id='.$task_id)->find();
			$rs = true;
			if ($info[$field] != $value) {
				$dao->where('id='.$task_id)->setField(array($field, 'update_time'), array($value, date('Y-m-d H:i:s')));
				self::mail_task('task_status', $task_id);
			}
			if ('status'==$field && 1==$value) {
				//总任务Close，则全部Owner状态自动Close
				M('TaskOwner')->where('task_id='.$task_id)->setField(array('status', 'action_time'), array(1, date('Y-m-d H:i:s')));
			}
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
		//delete comment
		M('Comment')->where(array('model_name'=>MODULE_NAME, 'model_id'=>$id))->delete();

		//delete attachment
		$rs = (array)M('Attachment')->where(array('model_name'=>'Task', 'model_id'=>$id))->select();
		foreach ($rs as $row) {
			@unlink($row['path']);
			M('Attachment')->where('id='.$row['id'])->delete();
		}
		self::_delete();
	}
	public function delete_owner() {
		$task_id = $_REQUEST['id'];
		$staff_id = $_REQUEST['staff_id'];
		$dao = M('TaskOwner');
		if (false !== $dao->where(array('task_id'=>$task_id, 'staff_id'=>$staff_id))->delete()) {
			self::mail_task('owner_remove', $task_id, $staff_id);
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
	public function delete_participant() {
		$task_id = $_REQUEST['id'];
		$staff_id = $_REQUEST['staff_id'];
		$dao = M('TaskParticipant');
		if (false !== $dao->where(array('task_id'=>$task_id, 'staff_id'=>$staff_id))->delete()) {
		//	self::mail_task('owner_remove', $task_id, $staff_id);
			$html  = '<script language="JavaScript" type="text/javascript">';
			$html .= 'parent.myAlert("Delete success!");';
			$html .= 'parent.myOK(500);';
			$html .= 'parent.remove_participant('.$staff_id.');';
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
			self::mail_task('comment_delete', $dao->model_id, $dao->staff_id);
			die($html);
		}
		else {
			self::_error('Delete comment fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
		}
	}
	public function mail_task($type='', $task_id=0, $owner_id) {
		if (!defined('APP_ROOT')) {
			define('APP_ROOT', 'http://'.$_SERVER['SERVER_ADDR'].__APP__);
		}
		$this->status_arr = array(
			'0' => 'Open',
			'1' => 'Closed',
			'-1' => 'Pending'
		);
		$smtp_config = C('_smtp_');
		include_once (LIB_PATH.'class.phpmailer.php');
		$mail = new PHPMailer();
		$mail->IsSMTP();
	//	$mail->SMTPDebug  = 1;  // 2 = messages only
		$mail->Host       = $smtp_config['host'];
		$mail->Port       = $smtp_config['port'];
		$mail->SetFrom($smtp_config['from_mail'], 'ERP Task');

		/*type参数：
			task_add
			task_status
			owner_add
			owner_remove
			owner_status
			remind
			press
		*/
		$info = $this->dao->relation(true)->find($task_id);
		$creator = M('Staff')->find($info['creator_id']);
		$all_owner_name = array();
		foreach ($info['owner'] as $i=>$owner) {
			$tmp = M('Staff')->find($owner['staff_id']);
			$info['owner'][$i]['email'] = $tmp['email'];
			$info['owner'][$i]['realname'] = $tmp['realname'];
			$info['owner'][$i]['leader_id'] = $tmp['leader_id'];
			$all_owner_name[] = $tmp['realname'];
		}
		$all_participant_name = array();
		foreach ($info['participant'] as $i=>$owner) {
			$tmp = M('Staff')->find($owner['staff_id']);
			$info['participant'][$i]['email'] = $tmp['email'];
			$info['participant'][$i]['realname'] = $tmp['realname'];
			$all_participant_name[] = $tmp['realname'];
		}
		foreach ($info['comment'] as $key=>$val) {
			$info['comment'][$key]['realname'] = M('Staff')->where('id='.$val['staff_id'])->getField('realname');
		}
		$body = "<style>\ntd.Open{color: #339900;font-weight:bold;} \ntd.Pending{color: #0000FF;font-weight:bold;} \ntd.Closed{color: #FF0000;font-weight:bold;} \ndt{padding:3px;border-left:3px solid #CC0000;background-color:#BEBEBE;} \ndd{padding:3px;margin:0;word-wrap:break-word;word-break:break-all;} \ndt span{float:right;}\n</style>\n";
		$body .= '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body>'."\n";
		switch ($type) {
			case 'task_add':
				if ($info['press_interval']%86400 == 0) {
					$info['press_unit'] = ' Day';
					$info['press_time'] = $info['press_interval']/86400;
					if ($info['press_time']>1) {
						$info['press_unit'] = ' Days';
					}
				}
				elseif ($info['press_interval']%3600 == 0) {
					$info['press_unit'] = ' Hour';
					$info['press_time'] = $info['press_interval']/3600;
					if ($info['press_time']>1) {
						$info['press_unit'] = ' Hours';
					}
				}
				elseif ($info['press_interval']%60 == 0) {
					$info['press_unit'] = ' Minute';
					$info['press_time'] = $info['press_interval']/60;
					if ($info['press_time']>1) {
						$info['press_unit'] = ' Minutes';
					}
				}
				$subject = '[Task] Create: '.$info['title'];
				foreach ($info['owner'] as $owner) {
					$mail->AddAddress($owner['email'], $owner['realname']);
				}

				$body .= "Hi all, ".$creator['realname']." has created a new task: ".$info['title']."<br />\n";
				$body .= '<table border="1" cellspacing="1" cellpadding="7" style="border-collapse:collapse;border:1px solid #999999;">'."\n";
				$body .= '<tr bgcolor="#CCCCCC">'."\n".'<td colspan="2">Task Summary (T'.sprintf('%06s', $info['id']).")</td>\n</tr>\n";
				$body .= "<tr>\n".'<td width="120">Task Name: </td><td width="500">'.$info['title']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Category: </td><td>".$info['category']['name']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Project: </td><td>".$info['project']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Create Time: </td><td>".$info['create_time']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Creator: </td><td>".$info['creator']['realname']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Due Date: </td><td>".$info['due_date'].'</td>'."\n</tr>\n";
				$body .= "<tr>\n<td>Press Interval: </td><td>".$info['press_time'].$info['press_unit']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Owners: </td><td>".implode(', ', $all_owner_name)."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Participants: </td><td>".implode(', ', $all_participant_name)."</td>\n</tr>\n";
				$body .= "<tr>\n".'<td valign="top">Attached Files: </td><td>';
				foreach ($info['attachment'] as $file) {
					$body .= '<a href="'.APP_ROOT.'/../'.$file['path'].'" target="_blank" title="View attachment in new window">'.$file['name']."</a><br />\n";
				}
				$body .= "</td>\n</tr>\n";
				break;

			case 'task_status':
				$subject = '[Task] Change Status of Task: '.$info['title'].' to '.$this->status_arr[$info['status']];
				foreach ($info['owner'] as $owner) {
					$mail->AddAddress($owner['email'], $owner['realname']);
				}

				$body .= "Hi all, ".$_SESSION[C('STAFF_AUTH_NAME')]['realname']." has changed the task status.<br />\n";
				$body .= '<table border="1" cellspacing="1" cellpadding="7" style="border-collapse:collapse;border:1px solid #999999;">'."\n";
				$body .= '<tr bgcolor="#CCCCCC">'."\n".'<td colspan="2">Task Summary (T'.sprintf('%06s', $info['id']).")</td>\n</tr>\n";
				$body .= "<tr>\n".'<td width="120">Task Name: </td><td width="500">'.$info['title']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Category: </td><td>".$info['category']['name']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Project: </td><td>".$info['project']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Create Time: </td><td>".$info['create_time']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Creator: </td><td>".$info['creator']['realname']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Update Time: </td><td>".$info['update_time']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Current Status: </td><td class='".$this->status_arr[$info['status']]."'>".$this->status_arr[$info['status']]."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Owners: </td><td>";
				$body .= "\n\t<table>\n";
				foreach ($info['owner'] as $owner) {
					$body .= "<tr>\n".'<td width="100" nowrap="nowrap">'.$owner['realname'].'</td><td width="60" class="'.$this->status_arr[$owner['status']].'">'.$this->status_arr[$owner['status']]."</td>\n</tr>\n";
				}
				$body .= "</table>\n";
				$body .= "</td>\n</tr>\n";
				$body .= "<tr>\n<td>Participants: </td><td>".implode(', ', $all_participant_name)."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Due Date: </td><td>".$info['due_date']."</td>\n</tr>\n";
				break;

			case 'owner_add':
				$owner_arr = M('Staff')->where(array('id' => array('in', $owner_id)))->getField('realname,email');
				$subject = '[Task] Add Owner to Task: '.$info['title'];
				foreach ($owner_arr as $realname=>$email) {
					$mail->AddAddress($email, $realname);
				}

				$body .= "Hi ".implode('/', array_keys($owner_arr)).", you have been added to the task.<br />";
				$body .= '<table border="1" cellspacing="1" cellpadding="7" style="border-collapse:collapse;border:1px solid #999999;">'."\n";
				$body .= '<tr bgcolor="#CCCCCC">'."\n".'<td colspan="2">Task Summary (T'.sprintf('%06s', $info['id']).")</td>\n</tr>\n";
				$body .= "<tr>\n".'<td width="120">Task Name: </td><td width="500">'.$info['title']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Category: </td><td>".$info['category']['name']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Project: </td><td>".$info['project']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Create Time: </td><td>".$info['create_time']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Creator: </td><td>".$info['creator']['realname']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Status: </td><td class='".$this->status_arr[$info['status']]."'>".$this->status_arr[$info['status']]."</td></tr>\n";
				$body .= "<tr>\n<td>Current Owners: </td><td>";
				$body .= "\n\t<table>\n";
				foreach ($info['owner'] as $owner) {
					$body .= "<tr>\n".'<td width="100" nowrap="nowrap">'.$owner['realname'].'</td><td width="60" class="'.$this->status_arr[$owner['status']].'">'.$this->status_arr[$owner['status']]."</td>\n</tr>\n";
				}
				$body .= "</table>\n";
				$body .= "</td>\n</tr>\n";
				$body .= "<tr>\n<td>Participants: </td><td>".implode(', ', $all_participant_name)."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Due Date: </td><td>".$info['due_date']."</td>\n</tr>\n";
				break;

			case 'owner_remove':
				$staff = M('Staff')->find($owner_id);
				$subject = '[Task] Remove '.$staff['realname'].' from : '.$info['title'];
				$mail->AddAddress($staff['email'], $staff['realname']);

				$body .= 'Hi '.$s_owner['realname'].", you have been removed from the task.<br />\n";
				$body .= '<table border="1" cellspacing="1" cellpadding="7" style="border-collapse:collapse;border:1px solid #999999;">'."\n";
				$body .= '<tr bgcolor="#CCCCCC">'."\n".'<td colspan="2">Task Summary (T'.sprintf('%06s', $info['id']).")</td>\n</tr>\n";
				$body .= "<tr>\n".'<td width="120">Task Name: </td><td width="500">'.$info['title']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Category: </td><td>".$info['category']['name']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Project: </td><td>".$info['project']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Create Time: </td><td>".$info['create_time']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Creator: </td><td>".$info['creator']['realname']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Status: </td><td class='".$this->status_arr[$info['status']]."'>".$this->status_arr[$info['status']]."</td></tr>\n";
				$body .= "<tr>\n<td>Current Owners: </td><td>";
				$body .= "\n\t<table>\n";
				foreach ($info['owner'] as $owner) {
					$body .= "<tr>\n".'<td width="100" nowrap="nowrap">'.$owner['realname'].'</td><td width="60" class="'.$this->status_arr[$owner['status']].'">'.$this->status_arr[$owner['status']]."</td>\n</tr>\n";
				}
				$body .= "</table>\n";
				$body .= "</td>\n</tr>\n";
				$body .= "<tr>\n<td>Participants: </td><td>".implode(', ', $all_participant_name)."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Due Date: </td><td>".$info['due_date']."</td>\n</tr>\n";
				break;

			case 'owner_status':
				$subject = '[Task] Owner Change Status : '.$info['title'];
				$owner_info = M('TaskOwner')->where("task_id=".$task_id." and staff_id=".$owner_id)->find();
				$owner = M('Staff')->find($owner_id);
				$body .= $owner['realname'] .' has changed his status to '.$this->status_arr[$owner_info['status']].'<br />';
				$mail->AddAddress($creator['email'], $creator['realname']);
				if ($info['notification'][3] == '1') {
					foreach ($info['owner'] as $owner) {
						$mail->AddCC($owner['email'], $owner['realname']);
					}
				}

				$body .= '<table border="1" cellspacing="1" cellpadding="7" style="border-collapse:collapse;border:1px solid #999999;">'."\n";
				$body .= '<tr bgcolor="#CCCCCC">'."\n".'<td colspan="2">Task Summary (T'.sprintf('%06s', $info['id']).")</td>\n</tr>\n";
				$body .= "<tr>\n".'<td width="120">Task Name: </td><td width="500">'.$info['title']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Category: </td><td>".$info['category']['name']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Project: </td><td>".$info['project']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Create Time: </td><td>".$info['create_time']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Creator: </td><td>".$info['creator']['realname']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Status: </td><td class='".$this->status_arr[$info['status']]."'>".$this->status_arr[$info['status']]."</td></tr>\n";
				$body .= "<tr>\n<td>Owners: </td><td>";
				$body .= "\n\t<table>\n";
				foreach ($info['owner'] as $owner) {
					$body .= "<tr>\n".'<td width="100" nowrap="nowrap">'.$owner['realname'].'</td><td width="60" class="'.$this->status_arr[$owner['status']].'">'.$this->status_arr[$owner['status']]."</td>\n</tr>\n";
				}
				$body .= "</table>\n";
				$body .= "</td>\n</tr>\n";
				$body .= "<tr>\n<td>Participants: </td><td>".implode(', ', $all_participant_name)."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Due Date: </td><td>".$info['due_date']."</td>\n</tr>\n";
				break;

			case 'remind':
				$endTime = strtotime($info['due_date'])+86400;
				$time = $endTime - time();
				$subject = '[Task] Remind: '.self::formatSecond($time).' Left for Task: '.$info['title'];

				if (!empty($owner_id)) {
					$staff = M('Staff')->find($owner_id);
					$mail->AddAddress($staff['email'], $staff['realname']);
					$staff_name = $staff['realname'];
				}
				else {
					$staff_name_arr = array();
					foreach ($info['owner'] as $i=>$owner) {
						if (0!=$owner['status']) {
							continue;
						}
						$tmp = M('Staff')->find($owner['staff_id']);
						$mail->AddAddress($tmp['email'], $tmp['realname']);
						$staff_name_arr[] = $tmp['realname'];
					}
					$staff_name = implode('/', $staff_name_arr);
				}


				$body .= 'Hi '.$staff_name .', its '.self::formatSecond($time)."' left for you to close the task.<br />\n";
				$body .= '<table border="1" cellspacing="1" cellpadding="7" style="border-collapse:collapse;border:1px solid #999999;">'."\n";
				$body .= '<tr bgcolor="#CCCCCC">'."\n".'<td colspan="2">Task Summary (T'.sprintf('%06s', $info['id']).")</td>\n</tr>\n";
				$body .= "<tr>\n".'<td width="120">Task Name: </td><td width="500">'.$info['title']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Category: </td><td>".$info['category']['name']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Project: </td><td>".$info['project']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Create Time: </td><td>".$info['create_time']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Creator: </td><td>".$info['creator']['realname']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Status: </td><td class='".$this->status_arr[$info['status']]."'>".$this->status_arr[$info['status']]."</td></tr>\n";
				$body .= "<tr>\n<td>Owners: </td><td>";
				$body .= "\n\t<table>\n";
				foreach ($info['owner'] as $i=>$owner) {
					$body .= "<tr>\n".'<td width="100" nowrap="nowrap">'.$owner['realname'].'</td><td width="60" class="'.$this->status_arr[$owner['status']].'">'.$this->status_arr[$owner['status']]."</td>\n</tr>\n";
					if (0!=$owner['status']) {
						unset($info['owner'][$i]);
					}
				}
				$body .= "</table>\n";
				$body .= "</td>\n</tr>\n";
				$body .= "<tr>\n<td>Participants: </td><td>".implode(', ', $all_participant_name)."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Due Date: </td><td>".$info['due_date']."</td>\n</tr>\n";
				break;

			case 'press':
				$endTime = strtotime($info['due_date'])+86400;
				$time = time() - $endTime;
				$subject = '[Task] Exceed Time Limit: '.self::formatSecond($time).' for Task: '.$info['title'];

				if (!empty($owner_id)) {
					$staff = M('Staff')->find($owner_id);
					$mail->AddAddress($staff['email'], $staff['realname']);
				}
				else {
					$staff_name_arr = array();
					foreach ($info['owner'] as $i=>$owner) {
						if (0!=$owner['status']) {
							continue;
						}
						$tmp = M('Staff')->find($owner['staff_id']);
						$mail->AddAddress($tmp['email'], $tmp['realname']);
						$staff_name_arr[] = $tmp['realname'];
					}
					$staff_name = implode('/', $staff_name_arr);
				}
				$body .= 'Hi '.$staff_name .', its '.self::formatSecond($time)." exceeded the time limit of the task.<br />\n";
				$body .= '<table border="1" cellspacing="1" cellpadding="7" style="border-collapse:collapse;border:1px solid #999999;">'."\n";
				$body .= '<tr bgcolor="#CCCCCC">'."\n".'<td colspan="2">Task Summary (T'.sprintf('%06s', $info['id']).")</td>\n</tr>\n";
				$body .= "<tr>\n".'<td width="120">Task Name: </td><td width="500">'.$info['title']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Category: </td><td>".$info['category']['name']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Project: </td><td>".$info['project']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Create Time: </td><td>".$info['create_time']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Creator: </td><td>".$info['creator']['realname']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Status: </td><td class='".$this->status_arr[$info['status']]."'>".$this->status_arr[$info['status']]."</td></tr>\n";
				$body .= "<tr>\n<td>Current Owners: </td><td>";
				$body .= "\n\t<table>\n";
				foreach ($info['owner'] as $owner) {
					$body .= "<tr>\n".'<td width="100" nowrap="nowrap">'.$owner['realname'].'</td><td width="60" class="'.$this->status_arr[$owner['status']].'">'.$this->status_arr[$owner['status']]."</td>\n</tr>\n";
					if (0!=$owner['status']) {
						unset($info['owner'][$i]);
					}
				}
				$body .= "</table>\n";
				$body .= "</td>\n</tr>\n";
				$body .= "<tr>\n<td>Participants: </td><td>".implode(', ', $all_participant_name)."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Due Date: </td><td>".$info['due_date']."</td>\n</tr>\n";
				break;
			
			case 'comment_add':
				$subject = '[Task] Post Comment to Task: '.$info['title'];
				$staff = M('Staff')->find($owner_id);
				$header = 'Hi all, '.$staff['realname']." has posted a new comment to the task.<br />\n";
			case 'comment_modify':
				empty($subject) && ($subject = '[Task] Modify Comment of Task: '.$info['title']);
				$staff = M('Staff')->find($owner_id);
				empty($header) && ($header = 'Hi all, '.$staff['realname']." has modified one of his comments to the task.<br />\n");
			case 'comment_delete':
				empty($subject) && ($subject = '[Task] Delete Comment of Task: '.$info['title']);
				$staff = M('Staff')->find($owner_id);
				empty($header) && ($header = 'Hi all, '.$staff['realname']." has deleted one of his comments to the task.<br />\n");

				foreach ($info['owner'] as $owner) {
					$mail->AddAddress($owner['email'], $owner['realname']);
				}
				$body .= $header;
				$body .= '<table border="1" cellspacing="1" cellpadding="7" style="border-collapse:collapse;border:1px solid #999999;">'."\n";
				$body .= '<tr bgcolor="#CCCCCC">'."\n".'<td colspan="2">Task Summary (T'.sprintf('%06s', $info['id']).")</td>\n</tr>\n";
				$body .= "<tr>\n".'<td width="120">Task Name: </td><td width="500">'.$info['title']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Category: </td><td>".$info['category']['name']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Project: </td><td>".$info['project']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Create Time: </td><td>".$info['create_time']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Creator: </td><td>".$info['creator']['realname']."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Status: </td><td class='".$this->status_arr[$info['status']]."'>".$this->status_arr[$info['status']]."</td></tr>\n";
				$body .= "<tr>\n<td>Owners: </td><td>";
				$body .= "\n\t<table>\n";
				foreach ($info['owner'] as $owner) {
					$body .= "<tr>\n".'<td width="100" nowrap="nowrap">'.$owner['realname'].'</td><td width="60" class="'.$this->status_arr[$owner['status']].'">'.$this->status_arr[$owner['status']]."</td>\n</tr>\n";
				}
				$body .= "</table>\n";
				$body .= "</td>\n</tr>\n";
				$body .= "<tr>\n<td>Participants: </td><td>".implode(', ', $all_participant_name)."</td>\n</tr>\n";
				$body .= "<tr>\n<td>Due Date: </td><td>".$info['due_date']."</td>\n</tr>\n";
				break;

			default:
				//nothing
		}
		$body .= "<tr>\n".'<td valign="top">Description: </td><td>'.nl2br($info['descr'])."</td>\n</tr>\n";
		$body .= "<tr>\n<td colspan='2'>\n";
		if (empty($info['comment'])) {
			$body .= '<p class="center">No Comment</p>';
		}
		else {
			$body .= "<dl>\n";
			foreach ($info['comment'] as $item) {
				$body .= '<dt><span>'.$item['create_time'].'</span>&nbsp;&nbsp;'.$item['realname'].'</dt>'."\n";
				$body .= '<dd>'.nl2br($item['content']).'</dd>'."\n";
			}
			$body .= "</dl>\n";
		}
		$body .= "</td></tr>\n";
		$body .= "</table>\n";
		$body .= '<br /><br />For more information, please visit <a target="_blank" href="'.APP_ROOT.'/Task">ERP Task System</a>';
		$body .= '<br /><br />Best Regards,<br />'.C('ERP_TITLE');

		if ($info['notification'][0] == '1') {
			$manager_arr = M('Staff')->where(array('id'=>array('in', C('TASK_ADMIN_ID'))))->select();
			foreach ($manager_arr as $staff) {
				$mail->AddCC($staff['email'], $staff['realname']);
			}
		}
		if ($info['notification'][1] == '1') {
			if ('task_add' == $type) {
				$leader = M('Staff')->find($creator['leader_id']);
				$mail->AddCC($leader['email'], $leader['realname']);
			}
			if ('owner_remove' == $type || (in_array($type, array('remind', 'press')) && !empty($owner_id))) {
				$leader = M('Staff')->find($staff['leader_id']);
				$mail->AddCC($leader['email'], $leader['realname']);
			}
			else {
				foreach ($info['owner'] as $owner) {
					$leader = M('Staff')->find($owner['leader_id']);
					$mail->AddCC($leader['email'], $leader['realname']);
				}
			}
		}
		if ($info['notification'][2] == '1') {
			foreach ($info['participant'] as $owner) {
				$mail->AddCC($owner['email'], $owner['realname']);
			}
		}
		$mail->Subject = $subject;
		$mail->MsgHTML($body);
		if(!$mail->Send()) {
			Log::Write('Mail task Error: '.$mail->ErrorInfo, LOG::ERR);
			return false;
		}
		Log::Write('Mail task Success: '.$type.' '.$task_id, LOG::INFO);
		return true;
	}
	private function formatSecond($second) {
		if ($second>=86400) {
			$unit = ' Day';
			$number = round($second/86400);
		}
		elseif ($second>=3600) {
			$unit = ' Hour';
			$number = round($second/3600);
		}
		elseif ($second>=60) {
			$unit = ' Minute';
			$number = round($second/60);
		}
		else {
			$unit = ' Second';
			$number = $second;
		}
		if ($number>1) {
			$unit .= 's';
		}
		return $number.$unit;
	}
	public function notify(){
		echo "======== [".date("Y-m-d H:i:s").'] '.MODULE_NAME.'.'.ACTION_NAME." ========\n";
		$where = array(
			'status' => 0,
			'due_date' => array('neq', '0000-00-00')
			);
		$rs = $this->dao->relation(true)->where($where)->select();
		if (empty($rs)) {
			echo 'No task to notify';
			return;
		}
		echo 'Get '.count($rs)." records.\n";
		$dao = M('TaskOwner');
		foreach ($rs as $item) {
			echo "For Task ID: ".$item['id']."\n";
			$endTime = strtotime($item['due_date'])+86400;
			$press_interval = $item['press_interval'];
			foreach ($item['owner'] as $owner) {
				echo "\tStaff ID: ".$owner['staff_id']."\t";
				if ($owner['status'] != 0) {
					echo $this->status_arr[$owner['status']]." Skip\n";
					continue;
				}
				$lastMailTime = intval($owner['mail_time']);
				if ($lastMailTime==0) {
					$lastMailTime = strtotime($item['create_time']);
				}
				$tmp = $lastMailTime+round(($endTime-$lastMailTime)*0.382);
				if (time()>=$tmp && time()<$endTime && time()-$lastMailTime>86400) {//提醒
					echo "remind\t";
					if (self::mail_task('remind', $item['id'])) {
						if(false !== $dao->where('task_id='.$item['id'].' and status=0')->setField('mail_time', time())) {
							echo "Success!\n";
							Log::Write('Notify task:'.$item['id'].'/staff:'.$owner['staff_id'].' success', LOG::INFO);
						}
						else {
							echo 'SQL error'.(C('APP_DEBUG')?$dao->getLastSql():'');
						}
					}
					else {
						echo "Fail\n";
					}
				}
				elseif ($press_interval>0 && time()>=$endTime && time()-$lastMailTime+10>=$press_interval && date('G')>=9 && date('G')<18 && date('N')<=5) {//催促
					echo "press\t";
					if (self::mail_task('press', $item['id'])) {
						if(false !== $dao->where('task_id='.$item['id'].' and status=0')->setField('mail_time', time())) {
							echo "Success!\n";
							Log::Write('Notify task:'.$item['id'].'/staff:'.$owner['staff_id'].' success', LOG::INFO);
						}
						else {
							echo 'SQL error'.(C('APP_DEBUG')?$dao->getLastSql():'');
						}
					}
					else {
						echo "Fail\n";
					}
				}
				else {
					echo "nothing\n";
				}
				break;
			}
		}
		echo "\n";
	}

}
?>