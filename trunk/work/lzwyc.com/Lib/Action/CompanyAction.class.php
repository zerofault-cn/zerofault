<?php
class CompanyAction extends BaseAction {
	protected $dao;

	public function _initialize() {
		$this->dao = D('Company');
		parent::_initialize();

		if ('index'!=ACTION_NAME) {
			$id = intval($_REQUEST['id']);
			$info = $this->dao->relation(true)->find($id);
			if ($info['status'] >0) {
				$this->assign('info', $info);
				$this->assign('MODULE_TITLE', '装修公司');
				$this->assign('ACTION_TITLE', $info['name']);
			}
			else {
				redirect(__URL__);
				exit;
			}
		}
	}

	public function index() {
		$where = array(
			'status' => array('gt', 0)
			);
		$order = 'sort, id desc';
		$count = $this->dao->where($where)->getField('count(*)');
		import("@.Paginator");
		$limit = 8;
		$p = new Paginator($count, $limit);
		$rs = $this->dao->relation(true)->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();
		$this->assign('list', $rs);
		$this->assign('page', $p->showMultiNavi());

		$this->assign('content', ACTION_NAME);
		$this->display('Layout:main');
	}
	public function detail() {
		$id = intval($_REQUEST['id']);
		$this->dao->setInc('view', 'id='.$id);

		$this->assign('content', ACTION_NAME);
		$this->display('Layout:company');
	}
	public function introduction() {
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:company');
	}
	public function case_list() {
		$id = intval($_REQUEST['id']);
		$dao = M('Case');
		$where = array(
			'company_id' => $id,
			'status' => array('gt', 0)
			);
		$order = 'sort, id desc';
		$count = $dao->where($where)->count();
		import("@.Paginator");
		$limit = 20;
		$p = new Paginator($count, $limit);
		$rs = $dao->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();
		$this->assign('list', $rs);
		$this->assign('page', $p->showMultiNavi());

		$this->assign('content', ACTION_NAME);
		$this->display('Layout:company');
	}
	public function case_detail() {
		$case_id = intval($_REQUEST['case_id']);
		$dao = D('Case');
		$rs = $dao->relation(true)->find($case_id);
		$this->assign('case_info', $rs);
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:company');
	}
	public function talk_detail() {
		$talk_id = intval($_REQUEST['talk_id']);
		$dao = D('Talk');
		$rs = $dao->find($talk_id);
		$this->assign('talk_info', $rs);
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:company');
	}
	public function feedback() {
		$dao = M('Feedback');
		if (!empty($_POST['post'])) {
			if($_SESSION['verify']!=md5(trim($_REQUEST['verify']))) {
				self::_error('验证码错误!');
			}
			$data['company_id'] = $_REQUEST['id'];
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
			$data['status'] = 0;
			if($dao->add($data)) {
				self::_success('提交成功，请等待管理员审核！');
			}
			else{
				self::_error('提交失败！');
			}
		}
		elseif (!empty($POST['reply'])) {
		}
		$id = intval($_REQUEST['id']);
		//提取留言
		$where = array();
		$where['company_id'] = $id;
		$where['status'] = array('gt', 0);
		$order = 'id desc';
		$count = $dao->where($where)->count();
		import("@.Paginator");
		$limit = 10;
		$p = new Paginator($count, $limit);
		$rs = $dao->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();
		$this->assign('list', $rs);
		$this->assign('page', $p->showMultiNavi());

		$this->assign('content', ACTION_NAME);
		$this->display('Layout:company');
	}
	public function contact() {
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:company');
	}

}
?>