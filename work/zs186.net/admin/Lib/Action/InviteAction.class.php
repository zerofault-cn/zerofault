<?php
class InviteAction extends BaseAction {
	protected $dao;

	public function _initialize() {
		$this->dao = D('Invite');
		parent::_initialize();
	}

	public function index() {

		$options = C('_options_');

		$topnavi[]=array(
			'text'=> '招标管理',
			'url' => __APP__.'/Designer'
			);

		$order = 'id desc';
		$topnavi[]=array(
			'text'=> '招标列表',
			);
		$this->assign("topnavi",$topnavi);

		$where = array();
		$where['status'] = 0;
		if(!empty($_REQUEST['status'])) {
			$where['status'] = $_REQUEST['status'];
		}

		$count = $this->dao->where($where)->count();
		import("@.Paginator");
		$limit = 20;
		$p = new Paginator($count, $limit);
		$rs = $this->dao->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();
		foreach ($rs as $i=>$row) {
			$rs[$i]['budget_num'] = $row['budget']*10000;
			$rs[$i]['region'] = M('Region')->where("id=".$row['district'])->getField('name');
			$rs[$i]['type_str'] = $options['type'][$row['type']];
			$rs[$i]['space_str'] = $options['space'][$row['space']];
			$rs[$i]['room_str'] = $options['room'][$row['room']];
			$rs[$i]['tender_count'] = M('Tender')->where("invite_id=".$row['id']." and status>0")->count();
		}
		$this->assign('list', $rs);
		$this->assign('page', $p->showMultiNavi());

		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}
	public function form() {
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);

		if ($id > 0) {
			$topnavi[]=array(
				'text'=> '修改招标信息',
				);
			$info = $this->dao->find($id);
		}
		else {
			$topnavi[]=array(
				'text'=> '添加招标',
				);
			$info = array('id' => 0);
		}
		$this->assign("topnavi", $topnavi);

		$options = C('_options_');
		$this->assign('district_opts', self::genOptions(M('Region')->where("pid=2")->getField('id,name'), $info['district']));
		$this->assign('type_radios', self::genRadios($options['type'], $info['type'], 'type'));
		$this->assign('space_options', self::genOptions($options['space'], $info['space']));
		$this->assign('room_options', self::genOptions($options['room'], $info['room']));

		$this->assign("info", $info);

		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}

	public function submit() {
		if (empty($_POST['submit'])) {
			return;
		}
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);

		$district = intval($_REQUEST['district']);
		empty($district) && self::_error('地点区域必须选择！');
		$address = trim($_REQUEST['address']);
		empty($_REQUEST['quick_form'])&&(empty($address)||'如：××小区'==$address) && self::_error('小区地址必须填写！');
		$type = intval($_REQUEST['type']);
		empty($_REQUEST['quick_form'])&&empty($type) && self::_error('装修类型必须选择！');
		$space = intval($_REQUEST['space']);
		empty($_REQUEST['quick_form'])&&empty($space) && self::_error('户型必须选择！');
		$room = intval($_REQUEST['room']);
		empty($_REQUEST['quick_form'])&&empty($room) && self_error('空间类型必须选择！');
		$area = intval($_REQUEST['area']);
		empty($area) && self::_error('面积必须填写！');
		!is_numeric($area) && self::_error('面积必须填写数字！');
		$budget = intval($_REQUEST['budget']);
		empty($budget) && self::_error('预算必须填写！');
		!is_numeric($budget) && self::_error('预算必须填写数字！');
		$demand = trim($_REQUEST['demand']);
		$demand = str_replace('请简单描述您对装修设计的要求', '', $demand);
		$name = trim($_REQUEST['name']);
		empty($name) && self::_error('姓名必须填写！');
		$qq = trim($_REQUEST['qq']);
		//empty($qq) && self::_error('QQ必须填写！');
		$reserve_date = trim($_REQUEST['reserve_date']);
		empty($_REQUEST['quick_form'])&&empty($reserve_date) && self::_error('预约装修时间必须填写！');
		empty($_REQUEST['quick_form'])&&strtotime($reserve_date)<=0 && self::_error('预约装修时间格式错误！');
		empty($reserve_date) && ($reserve_date=date('Y-m-d'));
		$phone = trim($_REQUEST['phone']);
		empty($phone) && self::_error('联系电话必须填写！');

		$this->dao->find($id);
		$this->dao->district = $district;
		$this->dao->address = $address;
		$this->dao->type = $type;
		$this->dao->space = $space;
		$this->dao->room = $room;
		$this->dao->area = $area;
		$this->dao->budget = $budget;
		$this->dao->demand = $demand;
		$this->dao->name = $name;
		$this->dao->qq = $qq;
		$this->dao->reserve_date = $reserve_date;
		$this->dao->phone = $phone;

		if ($this->dao->save()) {
			self::_success('修改成功！', __URL__.'/index/status/'.$this->dao->status);
		}
		else {
			self::_error('修改失败！'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
		}
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