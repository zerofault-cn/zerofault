<?php
class DesignerAction extends BaseAction {
	protected $dao;

	public function _initialize() {
		$this->dao = D('Designer');
		parent::_initialize();
	}

	public function index() {

		$this->assign('MODULE_TITLE', '设计师列表');
		$where = array(
			'status' => array('gt', 0)
			);
		$order = 'sort, id desc';
		$count = $this->dao->where($where)->getField('count(*)');
		import("@.Paginator");
		$limit = 10;
		$p = new Paginator($count, $limit);
		$rs = $this->dao->relation(true)->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();
		foreach ($rs as $i=>$row) {
			$rs[$i]['workage'] = ceil((date('Y')+date('m')/12)-substr($row['workdate'], 0, 4)-substr($row['workdate'], 5,2)/12);
		}

		$this->assign('list', $rs);
		$this->assign('page', $p->showMultiNavi());

		$this->assign('content', 'index');
		$this->display('Layout:main');
	}
	public function reserve() {
		$designer_id = intval($_REQUEST['designer_id']);
		$this->assign('designer_id', $designer_id);
		if (!empty($_POST['submit'])) {
			$this->dao = M('Reserve');
			$area = floatval($_REQUEST['area']);
			empty($area) && self::_error('建筑面积必须填写！');
			!is_numeric($area) && self::_error('建筑面积必须填写数字！');
			$program_number = intval($_REQUEST['program_number']);
			$type = intval($_REQUEST['type']);
			empty($type) && self::_error('房屋类型必须选择！');
			$district = intval($_REQUEST['district']);
			empty($district) && self::_error('所在区域必须选择！');
			$name = trim($_REQUEST['name']);
			$qq = trim($_REQUEST['qq']);
			$phone = trim($_REQUEST['phone']);
			empty($phone) && self::_error('联系电话必须填写！');
			!preg_match("/^1[3458]{1}[0-9]{9}$/",$phone) && self::_error('手机号码格式不正确！');
			$demand = trim($_REQUEST['demand']);

			$this->dao->designer_id = $designer_id;
			$this->dao->area = $area;
			$this->dao->program_number = $program_number;
			$this->dao->type = $type;
			$this->dao->district = $district;
			$this->dao->name = $name;
			$this->dao->qq = $qq;
			$this->dao->phone = $phone;
			$this->dao->demand = $demand;
			$this->dao->addtime = date('Y-m-d H:i:s');
			$this->dao->status = 0;

			if ($this->dao->add()) {
				self::_success('提交成功，我们会在第一时间与您联系！', __URL__, 3000);
			}
			else {
				self::_error('提交失败！');
			}
			exit;
		}

		$this->assign('district_opts', self::genOptions(M('Region')->where("pid=2")->getField('id,name')));
		$this->assign('type_radios', self::genRadios(M('Building')->getField('id,name'), '', 'type', ' ', 7));

		$this->assign('content', 'reserve');
		$this->display('Layout:thickbox');
	}
}
?>