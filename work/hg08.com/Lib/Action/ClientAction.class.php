<?php
class ClientAction extends BaseAction {
	protected $dao;

	public function _initialize() {
		parent::_initialize();
	}
	
	public function index() {
		$this->reserve();
	}

	public function reserve() {
		if (!empty($_POST)) {
			$this->dao = M('Reserve');
			
			$name = trim($_REQUEST['name']);
			empty($name) && self::_error('请填写您的姓名以方便我们联系！');
			$qq = trim($_REQUEST['qq']);
			$phone = trim($_REQUEST['phone']);
			empty($phone) && self::_error('联系电话必须填写！');
			strlen($phone)<7 && self::_error('您的电话号码似乎太短！');
			$date = trim($_REQUEST['date']);
			$remark = trim($_REQUEST['remark']);

			$this->dao->name = $name;
			$this->dao->qq = $qq;
			$this->dao->phone = $phone;
			$this->dao->date = $date;
			$this->dao->remark = $remark;
			$this->dao->addtime = date('Y-m-d H:i:s');
			$this->dao->status = 0;

			if ($this->dao->add()) {
				self::_success('提交成功，我们会在第一时间与您联系！');
			}
			else {
				self::_error('提交失败！');
			}
			exit;
		}
		$this->assign('ACTION_TITLE', '在线预约');
		$this->assign('alias', 'reserve');
		
		$left_list = array(
			array(
				'alias' => 'reserve',
				'name'=>'在线预约'
				),
			array(
				'alias' => 'feedback',
				'name' => '访客留言'
				)
			);
		$this->assign('left_list', $left_list);

		$this->assign('content', 'reserve');
		$this->display('Layout:main');
	}

	public function feedback() {
		$this->dao = M('Feedback');
		if (!empty($_POST)) {
			
			$name = trim($_REQUEST['name']);
			empty($name) && self::_error('请填写您的姓名！');
			$content = trim($_REQUEST['content']);

			$this->dao->name = $name;
			$this->dao->content = $content;
			$this->dao->ip = $_SERVER['REMOTE_ADDR'];
			$this->dao->addtime = date('Y-m-d H:i:s');
			$this->dao->status = 0;

			if ($this->dao->add()) {
				self::_success('提交成功，请等待管理员审核！');
			}
			else {
				self::_error('提交失败！');
			}
			exit;
		}
		$this->assign('ACTION_TITLE', '访客留言');
		$this->assign('alias', 'reserve');
		
		$left_list = array(
			array(
				'alias' => 'reserve',
				'name'=>'在线预约'
				),
			array(
				'alias' => 'feedback',
				'name' => '访客留言'
				)
			);
		$this->assign('left_list', $left_list);
		
		$where = array();
		$where['status'] = array('gt', 0);
		$order = 'id desc';
		$count = $this->dao->where($where)->count();
		import("@.Paginator");
		$limit = 10;
		$p = new Paginator($count, $limit);
		$rs = $this->dao->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();
		$this->assign('list', $rs);
		$this->assign('page', $p->showMultiNavi());

		$this->assign('content', 'feedback');
		$this->display('Layout:main');
	}

	public function reminder() {
		if (empty($_SESSION['client_id'])) {
			//显示登录
		}
		else {
			//显示提示
		}
	}
}
?>