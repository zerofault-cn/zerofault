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
	
	public function create() {
		if (empty($_REQUEST['submit'])) {
			return;
		}
		$name = trim($_REQUEST['name']);
		if ('' == $name) {
			self::_error('Test NO. can\'t be empty!');
		}
		$rs = $this->dao->where("name='".$name."'")->find();
		if (count($rs)>0) {
			self::_error('The test NO.: '.$name.' has been used');
		}
		$this->dao->name = $name;
		$this->dao->staff_id = $_SESSION[C('USER_AUTH_KEY')];
		$this->dao->create_time = date('Y-m-d H:i:s');
		$this->dao->project = trim($_REQUEST['project']);
		$this->dao->result = 0;
		$this->dao->status = 0;
		if($this->dao->add()) {
			self::_success('Create  success!',__URL__);
		}
		else{
			self::_error('Create fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
		}
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