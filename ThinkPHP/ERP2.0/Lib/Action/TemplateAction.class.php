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
		Session::set('top', 'System');
		Session::set('sub', MODULE_NAME);
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

		$result = array();
		foreach($this->dao->select() as $item) {
			if (!array_key_exists($item['action'], $result)) {
				$result[$item['action']] = array();
			}
			$result[$item['action']][$item['do']] = array(
				'id' => $item['id'],
				'subject' => $item['subject'],
				'body'    => str_replace(array("  ","\n","\r\n","\t"), array('&nbsp;&nbsp;','<br />','<br />','<tt>&nbsp;&nbsp;&nbsp;&nbsp;</tt>'), $item['body']),
				'status' => $item['status']
				);
		}
		

		$this->assign('result', $result);
		$this->assign('content','Template:index');
		$this->display('Layout:ERP_layout');
	}
	public function form() {
		$this->assign('ACTION_TITLE', 'Edit');
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		$this->assign('info', $this->dao->find($id));
		$this->assign('content', 'Template:form');
		$this->display('Layout:ERP_layout');
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
		return;
	}
	public function update(){
		parent::_update();
	}

}
?>