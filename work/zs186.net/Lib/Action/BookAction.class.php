<?php
class BookAction extends BaseAction {
	protected $dao;

	public function _initialize() {
		$this->dao = D('Book');
		parent::_initialize();
	}

	public function index() {


	}
	public function submit() {
		if (empty($_POST['submit'])) {
			return;
		}
		$category_id = intval($_REQUEST['category_id']);
		$alias = trim($_REQUEST['alias']);
		$region_id = intval($_REQUEST['region_id']);
		empty($region_id) && self::_error('区域必须选择！');
		
		if (isset($_REQUEST['begin_date'])) {
			$begin_date = trim($_REQUEST['begin_date']);
			empty($begin_date) && self::_error('入住日期必须填写！');
			$end_date = trim($_REQUEST['end_date']);
			empty($end_date) && self::_error('退房日期必须填写！');
		}
		
		$number = intval($_REQUEST['number']);
		empty($number) && self::_error(('meeting'==$alias?'会议人数':'宴会桌数').'必须填写！');
		
		empty($phone) && self::_error('联系电话必须填写！');
		!preg_match("/^1[3458]{1}[0-9]{9}$/",$phone) && self::_error('手机号码格式不正确！');

	}
	public function detail() {
		$options = C('_options_');

		$id = intval($_REQUEST['id']);

		$rs = $this->dao->find($id);
		$rs['tender_count'] = M('Tender')->where("invite_id=".$id." and status>0")->count();
		$rs['budget_num'] = $rs['budget']*10000;
		$rs['region'] = M('Region')->where("id=".$rs['district'])->getField('name');
		$rs['type_str'] = $options['type'][$rs['type']];
		$rs['space_str'] = $options['space'][$rs['space']];
		$rs['room_str'] = $options['room'][$rs['room']];
		if (!empty($_SESSION['company_id'])) {
			$view_rs = M('View')->where("invite_id=".$id." and company_id=".$_SESSION['company_id'])->count();
			if ($view_rs > 0) {
				$rs['view'] = 1;
			}
		}
		$rs['view_count'] = M('View')->where("invite_id=".$id)->count();
		$this->assign('info', $rs);

		$this->assign('ACTION_TITLE', $rs['region'].' '.$rs['address'].' '.$rs['room_str'].' '.round($rs['area'], 1).'M2');
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:main');
	}

	public function tender() {
		//检验是否公司帐号
		if (empty($_SESSION[C('USER_ID')]) || $_SESSION['user_type']!=2 || empty($_SESSION['company_id'])) {
			self::error('您还没有登录公司帐号，请登录后再投标！<br /><br /><a href="'.__APP__.'/User/login">登录</a>');
		}

		$dao = M('Tender');
		$id = intval($_REQUEST['id']);
		//检验是否已达到招标名额
		$count = $dao->where("invite_id=".$id." and status>0")->count();
		if ($count>=3) {
			self::error('招标已结束！');
		}

		//检查是否重复投标
		$rs = $dao->where("invite_id=".$id." and company_id=".$_SESSION['company_id'])->count();
		if (!empty($rs) && $rs>0) {
			self::error('贵公司已经投标，请等待业主确认！');
		}
		$data = array();
		$data['invite_id'] = $id;
		$data['company_id'] = $_SESSION['company_id'];
		$data['action_time'] = date('Y-m-d H:i:s');
		$data['status'] = 1;
		if ($dao->data($data)->add()) {
			$addtime = M('Company')->where("id=".$_SESSION['company_id'])->getField('addtime');
			$month = ceil((time() - strtotime($addtime))/86400/30);
			$point = $month*$this->setting['point'];
			//额外分配的点数
			$point += (int)M('Point')->where("user_id=".$_SESSION[C('USER_ID')]." and status>0")->sum('point');
			//检查点数
			$count = (int)M('View')->where("company_id=".$_SESSION['company_id'])->sum('point');
			if ($count < $point) {
				unset($data['status']);
				$data['point'] = (M('View')->where("invite_id=".$id)->count()>=3)?2:1;
				M('View')->data($data)->add();
			}
			self::success('投标成功，请等待业主确认！');
		}
	}
	public function view() {
		//检验是否公司帐号
		if (empty($_SESSION[C('USER_ID')]) || $_SESSION['user_type']!=2 || empty($_SESSION['company_id'])) {
			self::error('您还没有登录公司帐号，请登录后再查看！<br /><br /><a href="'.__APP__.'/User/login">登录</a>');
		}
		//检查账号等级
		$user_info = M('User')->find($_SESSION[C('USER_ID')]);
		if ($user_info['status']<2) {
			self::error('您的账号还未通过认证，不能查看用户信息！');
		}

		$dao = M('View');
		$id = intval($_REQUEST['id']);
		//检验是否已看过
		$count = $dao->where("invite_id=".$id." and company_id=".$_SESSION['company_id'])->count();
		if (!empty($count) && $count>0) {
			self::error('您已登记过，请刷新页面查看！');
		}
		//获取公司注册时间
		$addtime = M('Company')->where("id=".$_SESSION['company_id'])->getField('addtime');
		$month = ceil((time() - strtotime($addtime))/86400/30);
		$point = $month*$this->setting['point'];
		//额外分配的点数
		$point += (int)M('Point')->where("user_id=".$_SESSION[C('USER_ID')]." and status>0")->sum('point');
		//检查点数
		$count = (int)$dao->where("company_id=".$_SESSION['company_id'])->sum('point');
		if ($count >= $point) {
			self::error('您的查看点数已用完！');
		}

		$view_count = M('View')->where("invite_id=".$id)->count();
		if ($view_count >= 5) {
			self::error('已超过查看名额限制！');
		}
		$dao->invite_id = $id;
		$dao->company_id = $_SESSION['company_id'];
		$dao->action_time = date('Y-m-d H:i:s');
		$dao->point = ($view_count>=3)?2:1;
		if ($dao->add()) {
			self::success('登记成功，请刷新页面查看！');
		}
	}
}
?>