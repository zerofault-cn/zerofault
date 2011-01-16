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
			$info = $this->dao->find($id);
			$this->assign('ACTION_TITLE', 'Edit task');
			$info['category_opts'] = self::genOptions(M('Category')->where(array('type'=>'Board'))->select(), $info['category_id'], 'name');
			$info['supplier_opts'] = self::genOptions(D('Supplier')->select());
			$info['currency_opts'] = self::genOptions(M('Options')->where(array('type'=>'currency'))->order('sort')->select(), $info['currency_id']);
			$info['unit_opts'] = self::genOptions(M('Options')->where(array('type'=>'unit'))->order('sort')->select(), $info['unit_id']);
			$info['status_opts'] = self::genOptions(M('Options')->where(array('type'=>'status'))->order('sort')->select(), $info['status_id']);
			$code = $info['code'];
		}
		else {
			$info = array(
				'id' => 0,
				'' => self::genOptions(M('Category')->where(array('type'=>'Board'))->select()),
				'supplier_opts' => self::genOptions(D('Supplier')->select()),
				'currency_opts' => self::genOptions(M('Options')->where(array('type'=>'currency'))->order('sort')->select()),
				'unit_opts' => self::genOptions(M('Options')->where(array('type'=>'unit'))->order('sort')->select()),
				'status_opts' => self::genOptions(M('Options')->where(array('type'=>'status'))->order('sort')->select())
				);
			$max_code = $this->dao->where(array('type'=>'Board'))->max('code');
			empty($max_code) && ($max_code = 'B'.sprintf("%09d",0));
			$code = ++ $max_code;
		}
		$this->assign('code', $code);
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

	public function edit(){
		if (empty($_POST['id'])) {
			return;
		}
		$id = intval($_REQUEST['id']);
		if ($id==0) {
			return;
		}
		$this->dao->find($id);
		$this->dao->project = trim($_REQUEST['project']);
		$this->dao->comment = trim($_REQUEST['comment']);
		unset($this->dao->edit_time);
		if(false !== $this->dao->save()) {
			foreach ($_REQUEST['entry'] as $key=>$val) {
				if (is_array($val)) {
					//create new entry
					foreach ($val as $y=>$string) {
						if (''==trim($string)) {
							continue;
						}
						$entry = new Model('TestEntry');
						$entry->test_id = $id;
						$entry->x = $key;
						$entry->y = $y;
						$entry->string = $string;
						$entry->edit_time = date('Y-m-d H:i:s');
						if (false === $entry->add()) {
							self::_error('Insert fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
						}
					}
				}
				elseif (is_numeric($key)) {
					$entry = new Model('TestEntry');
					$entry->find($key);
					$entry->string = $val;
					unset($entry->edit_time);
					if(false === $entry->save()) {
						self::_error('Update fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
					}
				}
			}
			self::_success('Update success!');
		}
		else {
			self::_error('Update fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
		}
	}
	public function update(){
		parent::_update();
	}
}
?>