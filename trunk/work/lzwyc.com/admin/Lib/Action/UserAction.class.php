<?php
class UserAction extends BaseAction{
	protected $dao;

	public function _initialize() {
		$this->dao = D('User');
		parent::_initialize();
	}
	public function index(){
		$setting = F('Index-setting', '', APP_PATH.'/../Runtime/Data/');

		$topnavi[]=array(
			'text'=> '用户管理',
			'url' => __APP__.'/User'
			);
		$topnavi[]=array(
			'text'=> (1==intval($_REQUEST['type'])?'普通业主列表':'公司账户列表'),
			);
		$this->assign("topnavi",$topnavi);

		$order = 'id desc';
		$where = array();
		$where['status'] = array('gt', -1);
		if(!empty($_REQUEST['status'])) {
			$where['status'] = intval($_REQUEST['status']);
		}
		if (!empty($_REQUEST['type'])) {
			$where['type'] = intval($_REQUEST['type']);
		}
		$count = $this->dao->where($where)->count();
		import("@.Paginator");
		$limit = 20;
		$p = new Paginator($count,$limit);
		$rs = $this->dao->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();
		foreach ($rs as $i=>$row) {
			if (2 == $row['type']) {
				$tmp_rs = M('Company')->where("user_id=".$row['id'])->find();
				$rs[$i]['company_name'] = $tmp_rs['name'];
				$month = ceil((time() - strtotime($tmp_rs['addtime']))/86400/30);
				$rs[$i]['month_point'] = $month*$setting['point'];
				//额外分配的点数
				$rs[$i]['added_point'] = (int)M('Point')->where("user_id=".$row['id']." and status>0")->sum('point');
				$rs[$i]['used_point'] = M('View')->where("company_id=".$tmp_rs['id'])->count();
				$rs[$i]['available_point'] = $rs[$i]['month_point'] + $rs[$i]['added_point'] - $rs[$i]['used_point'];
			}
		}

		$this->assign('list',$rs);
		$this->assign('page', $p->showMultiNavi());

		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}

	public function point() {
		$topnavi[]=array(
			'text'=> '公司用户管理',
			'url' => __URL__.'/index/type/2'
			);

		$user_id = intval($_REQUEST['user_id']);
		if (empty($user_id)) {
			redirect(__URL__.'/index/type/2');
			exit;
		}
		$topnavi[]=array(
			'text'=> M('Company')->where("user_id=".$user_id)->getField('name')
			);
		$topnavi[]=array(
			'text'=> '购买查看点数',
			);

		$dao = M('Point');
		if(!empty($_POST['submit'])) {
			$point = intval($_REQUEST['point']);
			$point<=0 && self::_error('增加的点数必须大于0！');
			$note = trim($_REQUEST['note']);
			$dao->user_id = $user_id;
			$dao->point = $point;
			$dao->note = $note;
			$dao->add_time = $dao->modify_time = date('Y-m-d H:i:s');
			$dao->status = 1;
			if ($dao->add()) {
				self::_success('添加成功！', __URL__.'/point/user_id/'.$user_id);
			}
			else {
				self::_error('添加失败！'.(C('APP_DEBUG')?$dao->getLastSql():''));
			}
			exit;
		}
		$where = array(
			'user_id' => $user_id
			);
		$rs = $dao->where($where)->order('id desc')->select();
		$this->assign('list',$rs);

		$this->assign("user_id", $user_id);

		$this->assign("topnavi",$topnavi);
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}
	public function update_point() {
		$this->dao = M('Point');
		parent::_update();
	}
	/**
	*
	* 调用基类方法
	*/
	public function update(){
		parent::_update();
	}
	/**
	*
	* 调用基类方法
	*/
	public function delete(){
		parent::_delete();
	}

}
?>