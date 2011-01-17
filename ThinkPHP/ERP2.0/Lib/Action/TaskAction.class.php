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
			'1' => 'Close'
		);
		$this->assign('status_arr', $status_arr);
	}

	public function index() {
		Session::set('sub', MODULE_NAME);

		$this->assign('category_opts', self::genOptions(M('Category')->where(array('type'=>'Task'))->select(), $_REQUEST['category_id']) );
		import("@.Paginator");
		$limit = 10;
		if (!empty($_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_limit'])) {
			$limit = $_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_limit'];
		}
		if (!empty($_REQUEST['limit'])) {
			$limit = $_REQUEST['limit'];
		}
		$_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_limit'] = $limit;

		$where = array();
		$total = $this->dao->where($where)->count();
		$p = new Paginator($total,$limit);
		
		$result = (array)$this->dao->where($where)->order('id desc')->limit($p->offset.','.$p->limit)->field($field)->select();

		$this->assign('request', $_REQUEST);
		$this->assign('result', $result);

		$this->assign('page', $p->showLinkNavi());

		$this->assign('ACTION_TITLE', 'All Tasks');
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:ERP_layout');
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
				'category_opts' => self::genOptions(M('Category')->where(array('type'=>'Task'))->select()),
				'create_time' => date('Y-m-d'),
				'due_date' => '',
				'press_time' => 1,
				'press_unit' => 'day',
				'owners' => array(),
				);
		}
	//	dump($info);
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
		empty($_REQUEST['owner']) && self::_error('No owner specified!');
		if ($id>0) {
			$this->dao->find($id);
		}
		else {
			$this->dao->creator_id = $_SESSION[C('USER_AUTH_KEY')];
			$this->dao->create_time = date("Y-m-d H:i:s");
			$this->dao->status = 0;
		}
		$this->dao->title = $title;
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
		if ($id>0) {
			if(false !== $this->dao->save()){
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
							M('Attachment')->add($data);
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
						if (!move_uploaded_file($_FILES['file']['tmp_name'][$i], $data['path'])) {
							M('Attachment')->add($data);
						}
					}
				}
				self::_success('Create task success!',__URL__);
			}
			else{
				self::_error('Create task fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		


	}
	public function update(){
		parent::_update();
	}
}
?>