<?php
class CompanyAction extends BaseAction {
	protected $dao;

	public function _initialize() {
		$this->dao = D('Company');
		parent::_initialize();

		$id = intval($_REQUEST['id']);
		$info = $this->dao->relation(true)->find($id);
		$options = C('_options_');
		$info['qq'] = $options['admin_qq'];
		$this->assign('info', $info);
	}

	public function index($category_id=1) {

		$this->assign('MODULE_TITLE', '装修公司');
		$where = array(
			'status' => array('gt', 0)
			);
		$order = 'id desc';
		$count = $this->dao->where($where)->getField('count(*)');
		import("@.Paginator");
		$limit = 8;
		$p = new Paginator($count, $limit);
		$rs = $this->dao->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();
		$this->assign('list', $rs);
		$this->assign('page', $p->showMultiNavi());

		$this->assign('content', 'index');
		$this->display('Layout:main');
	}
	public function detail() {
		$id = intval($_REQUEST['id']);
		$this->dao->setInc('view', 'id='.$id);

		$this->assign('content', 'detail');
		$this->display('Layout:company');
	}
	public function introduction() {
		$this->assign('content', 'introduction');
		$this->display('Layout:company');
	}
	public function caselist() {
		$id = intval($_REQUEST['id']);
		$info = $this->dao->find($id);
		$this->assign('info', $info);
		$this->assign('content', 'case');
		$this->display('Layout:company');
	}
	public function feedback() {
		if (!empty($_POST['post'])) {
			if($_SESSION['verify']!=md5(trim($_REQUEST['verify']))) {
				self::_error('验证码错误!');
			}
			$dao = M('Feedback');
			$data['company_id'] = $_REQUEST['company_id'];
			$name = trim($_REQUEST['name']);
			empty($name) && self::_error('您的称呼必须填写！');
			$data['name'] = $name;
			$phone = trim($_REQUEST['phone']);
			empty($phone) && self::_error('联系方式必须填写！');
			$data['phone'] = $_REQUEST['phone'];
			$content = trim($_REQUEST['content']);
			empty($content) && self::_error('留言内容必须填写！');
			$data['content'] = $content;
			$data['ip'] = $_SERVER['REMOTE_ADDR'];
			$data['addtime'] = date("Y-m-d H:i:s");
			$data['status'] = 1;
			if($dao->add($data)) {
				self::_success('提交成功，请等待管理员回复！');
			}
			else{
				self::_error('提交失败！');
			}
		}
		elseif (!empty($POST['reply'])) {
		}
		$id = intval($_REQUEST['id']);
		//提取留言
		$rs = M('Feedback')->where("company_id=".$id)->select();
		$this->assign('list', $rs);

		$this->assign('content', 'feedback');
		$this->display('Layout:company');
	}
	public function contact() {
		$this->assign('content', 'contact');
		$this->display('Layout:company');
	}

}
?>