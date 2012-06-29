<?php
class FeedbackAction extends BaseAction {
	protected $dao;

	public function _initialize() {
		$this->dao = D('Feedback');
		parent::_initialize();
	}
	public function index() {
		if (!empty($_POST)) {
			$name = trim($_REQUEST['name']);
			empty($name) && self::_error('您的称呼必须填写！', 'feedback_message_box');
			$data['name'] = $name;
			$phone = trim($_REQUEST['phone']);
			empty($phone) && self::_error('联系方式必须填写！', 'feedback_message_box');
			$data['phone'] = $_REQUEST['phone'];
			$content = trim($_REQUEST['content']);
			empty($content) && self::_error('留言内容必须填写！', 'feedback_message_box');
			$data['content'] = $content;
			$data['ip'] = $_SERVER['REMOTE_ADDR'];
			$data['addtime'] = date("Y-m-d H:i:s");
			$data['status'] = 0;
			$data['referer'] = $_SERVER["HTTP_REFERER"];
			if($this->dao->add($data)) {
				setcookie('feedback_pop_zs186', 0, time()+10*86400, '/');
				self::_success('发送成功，谢谢！', '', 0, 'feedback_message_box');
			}
			else{
				self::_error('提交失败！', 'feedback_message_box');
			}
		}
	}
}