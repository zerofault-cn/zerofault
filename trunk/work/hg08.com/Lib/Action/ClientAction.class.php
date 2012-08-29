<?php
class ClientAction extends BaseAction {
	protected $dao;

	public function _initialize() {
		parent::_initialize();
		$this->dao = D('Client');
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
			strlen($phone)<7 && self::_error('请填写正确的电话号码！');
			$date = trim($_REQUEST['date']);
			$set = intval($_REQUEST['set']);
			empty($set) && self::_error('请选择套系！');
			$remark = trim($_REQUEST['remark']);

			$this->dao->set = $set;
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
		$category_id = M('Category')->where("alias='set'")->getField('id');
		$this->assign('set_list', M('Article')->where("category_id=".$category_id." and status>0")->order('sort')->field('id,title')->select());
		$this->assign('set_id', empty($_REQUEST['set_id'])?0:intval($_REQUEST['set_id']));

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

		$this->display('Layout:main');
	}

	public function reminder() {
		$this->assign('alias', 'reminder');
		if (!empty($_POST)) {
			//处理登录
			$name = trim($_REQUEST['name']);
			empty($name) && self::_error('请输入您的姓名！');
			$password = trim($_REQUEST['password']);
			empty($password) && self::_error('请输入您的密码！');
			$where = array(
				'name' => $name,
				'password' => md5($password)
				);
			$info = $this->dao->relation(true)->where($where)->find();
			if(empty($info)) {
				self::_error('验证失败，请检查您的姓名和密码是否输入有误！');
			}
			else{
				if ($info['status'] == 0) {
					self::_error('此账号已被禁用！');
				}
				$_SESSION['client_id'] = $info['id'];
				$_SESSION['client_name'] = $info['name'];
				self::_success('登录成功，正在提取提示信息');
			}
		}
		if (empty($_SESSION['client_id'])) {
			//显示登录
			$this->assign('content', 'login');
		}
		else {
			//显示提示
			if (empty($info)) {
				$info = $this->dao->relation(true)->find($_SESSION['client_id']);
			}
			$this->assign('info', $info);
		}
		$this->display('Layout:reminder');
	}
	public function logout(){
		Session::clear();
		self::_success('退出成功！');
	}

}
?>