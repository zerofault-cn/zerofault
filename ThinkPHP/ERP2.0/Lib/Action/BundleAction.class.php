<?php
class BundleAction extends BaseAction{

	protected $dao, $config;

	public function _initialize() {
		Session::set('top', 'Bundle Test');
		$this->dao = D('Bundle');
		$this->config = C('_bundle_');
		parent::_initialize();
		$this->assign('MODULE_TITLE', 'Bundle Test');
	}

	public function index() {
		Session::set('sub', MODULE_NAME);
		$this->assign('ACTION_TITLE', 'List');

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
			$entry = array();
			foreach ($rs as $arr) {
				if (!array_key_exists($arr['version_type'], $entry)) {
					$entry[$arr['version_type']] = array();
				}
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

		$this->assign('content', ACTION_NAME);
		$this->display('Layout:ERP_layout');
	}

}
?>