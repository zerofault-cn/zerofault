<?php
/**
*
* 邮件模板
*
* @author zerofault <zerofault@gmail.com>
* @since 2010/1/30
*/
class TemplateAction extends BaseAction{

	protected $dao;

	public function _initialize() {
		session('top', 'System');
		session('sub', MODULE_NAME);
		$this->dao = M('Template');
		parent::_initialize();
		$this->assign('MODULE_TITLE', 'Mail Template');
		$tags = array(
			'[code]' => 'ER Code',
			'[staff]' => 'The staff who launch the request',
			'[from_staff]' => 'The staff who the transference come from',
			'[to_staff]' => 'The staff who the transference go to',
			'[leader]' => 'The staff\'s leader',
			'[manager]' => 'The storage manager of the product',
			'[product]' => 'The Internal P/N or Board Name of the product',
			'[quantity]' => 'The quantity of request',
			'[unit]' => 'The unit name of the product',
			'[remark]' => 'The remark of the ER',
			'[url]' => 'The direct access link'
			);
		$this->assign('tags', $tags);
	}

	public function index(){
		$this->assign('ACTION_TITLE', 'List');

		$result = array(
			'apply' => array(
				'new' => array(),
				'edit' => array(),
				'delete' => array(),
				'approve' => array(),
				'reject' => array(),
				'confirm' => array()
				),
			'transfer' => array(
				'new' => array(),
				'edit' => array(),
				'delete' => array(),
				'reject' => array(),
				'confirm' => array()
				),
			'return' => array(
				'new' => array(),
				'edit' => array(),
				'delete' => array(),
				'confirm' => array()
				)
			);
		foreach($this->dao->select() as $item) {
			$result[$item['action']][$item['do']] = array(
				'id' => $item['id'],
				'subject' => $item['subject'],
				'body'    => str_replace(array("  ","\n","\r\n","\t"), array('&nbsp;&nbsp;','<br />','<br />','<tt>&nbsp;&nbsp;&nbsp;&nbsp;</tt>'), $item['body']),
				'status' => $item['status']
				);
		}
		

		$this->assign('result', $result);
		$this->display();
	}
	public function form() {
		$this->assign('ACTION_TITLE', 'Edit');
		if (empty($_REQUEST['id'])) {
			$this->assign('info', array('action'=>$_REQUEST['action'],'do'=>$_REQUEST['do']));
		}
		else {
			$id = intval($_REQUEST['id']);
			$this->assign('info', $this->dao->find($id));
		}
		$this->display();
	}
	public function submit() {
		if(empty($_POST['submit'])) {
			return;
		}
		$id = intval($_REQUEST['id']);
		$subject = trim($_REQUEST['subject']);
		$body = trim($_REQUEST['body']);
		empty($subject) && self::_error('Subject is empty!');
		empty($body) && self::_error('Body is empty!');
		if ($id>0) {
			$this->dao->find($id);
			$this->dao->subject = $subject;
			$this->dao->body = $body;
			if(false !== $this->dao->save()){
				self::_success('Template updated!',__URL__);
			}
			else{
				self::_error('Update fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		else {
			$data = array();
			$data['action'] = $_REQUEST['action'];
			$data['do'] = $_REQUEST['do'];
			$data['subject'] = trim($_REQUEST['subject']);
			$data['body'] =  trim($_REQUEST['body']);
			$data['status'] = 1;
			if ($this->dao->add($data)) {
				self::_success('Template created!', __URL__);
			}
			else {
				self::_error('Create fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		return;
	}
	public function update(){
		parent::_update();
	}
}
?>