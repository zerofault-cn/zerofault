<?php
class BundleAction extends BaseAction{

	protected $dao, $config;

	public function _initialize() {
		Session::set('top', 'Test Bundle');
		$this->dao = D('Bundle');
		$this->config = C('_bundle_');
		parent::_initialize();
		$this->assign('MODULE_TITLE', 'Test Bundle');
	}

	public function index() {
		Session::set('sub', MODULE_NAME);
		
		$max_name = $this->dao->max('name');
		empty($max_name) && ($max_name = 'BN_'.sprintf("%03d", 0));
		$new_name = ++ $max_name;
		$this->assign('new_name', $new_name);

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
		if(!empty($_REQUEST['key'])) {
			$limit = 1000;
			$key = trim($_REQUEST['key']);
			$rs = $this->dao->join("inner join erp_bundle_entry entry on entry.bundle_id=erp_bundle.id and entry.string like '%".$key."%'")->field("distinct erp_bundle.*")->select();
		}
		else {
			$rs = $this->dao->select();
		}
		$p = new Paginator(count($rs),$limit);

		if(!empty($key)) {
			$result = $this->dao->relation(true)->join("inner join erp_bundle_entry entry on entry.bundle_id=erp_bundle.id and entry.string like '%".$key."%'")->order('id desc')->limit($p->offset.','.$p->limit)->field("distinct erp_bundle.*")->select();
		}
		else {
			$result = $this->dao->relation(true)->order('id desc')->limit($p->offset.','.$p->limit)->field("distinct erp_bundle.*")->select();
		}
		foreach ($result as $i=>$item) {
			$rs = M('BundleEntry')->where('bundle_id='.$item['id'])->select();
			$entry = array_combine($this->config['versions'], array_fill(0, count($this->config['versions']), array()));
			foreach ($rs as $arr) {
				if(!empty($key)) {
					$arr['string'] = str_replace($key, '<em>'.$key.'</em>', $arr['string']);
				}
				$entry[$arr['version_type']][$arr['part_type']] = $arr['string'];
				if (!in_array($arr['part_type'], $this->config['parts'])) {
					array_push($this->config['parts'], $arr['part_type']);
				}
			}
			$result[$i]['entry'] = $entry;
		}
		$this->assign('request', $_REQUEST);
		$this->assign('result', $result);
		$this->assign('parts', $this->config['parts']);
		$this->assign('page', $p->showMultiNavi());

		$this->assign('ACTION_TITLE', 'List');
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:ERP_layout');
	}
	
	public function add() {
		if (empty($_REQUEST['submit'])) {
			return;
		}
		$name = $_REQUEST['name'];
		if (''==trim($name)) {
			self::_error('Test No. can\'t be empty!');
		}
		$rs = $this->dao->where("name='".$name."'")->find();
		if (count($rs)>0) {
			self::_error('The test No.: '.$name.' has been used');
		}
		$this->dao->name = $name;
		$this->dao->staff_id = $_SESSION[C('USER_AUTH_KEY')];
		$this->dao->addtime = date('Y-m-d H:i:s');
		$this->dao->status = 0;
		$this->dao->result = 0;
		if($this->dao->add()) {
			self::_success('Create new test bundle success!',__URL__);
		}
		else{
			self::_error('Create fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
		}
	}
}
?>