<?php
class TestAction extends BaseAction{

	protected $dao, $config;

	public function _initialize() {
		if ('Node'!= MODULE_NAME) {
			Session::set('top', 'Test Log');
		}
		$this->dao = D('Test');
		$this->config = C('_test_');
		parent::_initialize();
		$this->assign('MODULE_TITLE', 'Test Log');
	}

	public function index() {
		Session::set('sub', MODULE_NAME);
		
		$max_name = $this->dao->max('name');
		empty($max_name) && ($max_name = 'T'.sprintf("%08d", 0));
		$new_name = ++ $max_name;
		$this->assign('new_name', $new_name);

		$M = new Model();
		$rs = $M->query("select * from erp_staff where id in (select distinct staff_id from erp_test)");
		$this->assign('staff_opts', self::genOptions($rs, empty($_REQUEST['staff_id'])?0:$_REQUEST['staff_id'], 'realname'));

		import("@.Paginator");
		$limit = 10;
		if (!empty($_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_limit'])) {
			$limit = $_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_limit'];
		}
		if (!empty($_REQUEST['limit'])) {
			$limit = $_REQUEST['limit'];
		}
		$_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_limit'] = $limit;

		$result = array();
		$where = array();
		$wild_search = false;
		if (!empty($_REQUEST['name'])) {
			$where['name'] = array('like', '%'.trim($_REQUEST['name']).'%');
		}
		if (!empty($_REQUEST['staff_id'])) {
			$where['staff_id'] = $_REQUEST['staff_id'];
		}
		if (!empty($_REQUEST['project'])) {
			$where['project'] = array('like', '%'.trim($_REQUEST['project']).'%');
		}
		$join = '';
		$field = '*';
		if(!empty($_REQUEST['string'])) {
			$wild_search = true;
			$limit = 300;
			$string = trim($_REQUEST['string']);
			$join = "inner join erp_test_entry entry on entry.test_id=erp_test.id and entry.string like '%".$string."%'";
			$field = "distinct erp_test.*";
		}
		if (''!=$join) {
			$total = $this->dao->where($where)->join($join)->getField("count(distinct erp_test.id)");
		}
		else {
			$total = $this->dao->where($where)->count();
		}

		$p = new Paginator($total,$limit);
		if (''!=$join) {
			$result = $this->dao->relation(true)->where($where)->join($join)->order('id desc')->limit($p->offset.','.$p->limit)->field($field)->select();
		}
		else {
			$result = $this->dao->relation(true)->where($where)->order('id desc')->limit($p->offset.','.$p->limit)->field($field)->select();
		}
		foreach ($result as $i=>$item) {
			$rs = M('TestEntry')->where('test_id='.$item['id'])->select();
			empty($rs) && ($rs = array());
			$entry = array_combine($this->config['y-axis'], array_fill(0, count($this->config['y-axis']), array()));
			foreach ($rs as $arr) {
				if ($wild_search) {
					$arr['string'] = eregi_replace('('.$string.')', '<em>\\1</em>', $arr['string']);
				}
				$entry[$arr['y']][$arr['x']] = array(
					'id' => $arr['id'],
					'string' => $arr['string']
					);
			}
			$result[$i]['entry'] = $entry;
		}
		$this->assign('request', $_REQUEST);
		$this->assign('result', $result);

		$this->assign('x_axis', $this->config['x-axis']);
		$this->assign('y_axis', $this->config['y-axis']);
		$this->assign('page', $p->showMultiNavi());

		$this->assign('ACTION_TITLE', '');
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