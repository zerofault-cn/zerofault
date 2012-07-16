<?php
class ClientAction extends BaseAction{
	protected $dao;

	public function _initialize() {
		$this->dao = D('Client');
		parent::_initialize();
	}
	public function archived() {
		$this->index();
	}
	public function index(){
		$topnavi[]=array(
			'text'=> '客户进度管理',
			);

		$order = 'id desc';
		$where = array();
		if ('archived' == ACTION_NAME) {
			$where['status'] = -1;
		}
		else {
			$where['status'] = array('gt', 0);
		}
		if (!empty($_REQUEST['s_name'])) {
			$where['name'] = array('LIKE', '%'.trim($_REQUEST['s_name']).'%');
			$this->assign('s_name', $_REQUEST['s_name']);
		}
		$count = $this->dao->where($where)->count();
		import("@.Paginator");
		$limit = 20;
		$p = new Paginator($count,$limit);
		$rs = $this->dao->relation(true)->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();

		$this->assign("topnavi",$topnavi);
		$this->assign('page', $p->showMultiNavi());
		$this->assign('list', $rs);
		$this->assign('content', 'index');
		$this->display('Layout:default');
	}
	public function project() {
		$this->dao = M('Project');
		if (!empty($_POST)) {
			$name = trim($_REQUEST['name']);
			empty($name) && self::_error('名称必须填写！');
			$content = trim($_REQUEST['content']);
			$sort = intval($_REQUEST['sort']);
			
			$this->dao->name = $name;
			$this->dao->content = $content;
			$this->dao->sort = $sort;
			$this->dao->status = 1;
			if ($this->dao->add()) {
				self::_success('添加成功！');
			}
			else {
				self::_error('添加失败！'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		$topnavi[]=array(
			'text'=> '项目步骤设置',
			);
		$this->assign("topnavi",$topnavi);

		$where = array();
		if(!empty($_REQUEST['id'])) {
			$where['id'] = array('neq',$_REQUEST['id']);
			$info = $this->dao->where('id='.$_REQUEST['id'])->find();
		}
		else {
			$info = array(
				'id' => 0,
				'name' => '',
				'content' => '',
				'sort' => 0
				);
		}
		$this->assign('info', $info);
		
		$order = 'sort, id';
		$rs = $this->dao->where($where)->order($order)->select();
		$this->assign('list', $rs);

		$this->assign('content',ACTION_NAME);
		$this->display('Layout:default');
	}
	public function form() {
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);

		if ($id > 0) {
			$info = $this->dao->find($id);
		}
		else {
			$info = array(
				'id' => 0,
				'project_id' => 0
				);
		}
		$this->assign("info", $info);
		$this->assign('project_opts', self::genOptions(M('Project')->where('status>0')->order('sort')->getField('id,name'), $info['project_id']));

		$this->assign('content',ACTION_NAME);
		$this->display();
	}

	public function submit(){
		if(empty($_POST['submit'])) {
			return;
		}
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);

		$name = trim($_REQUEST['name']);
		''==$name && self::_error('客户姓名必须填写！');
		$phone = trim($_REQUEST['phone']);
		$password = trim($_REQUEST['password']);
		''==$password && ($password = 'hg08.com');
		$project_id = intval($_REQUEST['project_id']);
		if($id>0) {
			$rs = $this->dao->where(array('name'=>$name,'id'=>array('neq',$id)))->find();
			if($rs && sizeof($rs)>0) {
				self::_error('此客户姓名已存在！');
			}
			$this->dao->name = $name;
			$this->dao->phone = $phone;
			$this->dao->password = md5($password);
			$this->dao->project_id = $project_id;
			$this->dao->modify_time = date("Y-m-d H:i:s");
			if(false !== $this->dao->where("id=".$id)->save()) {
				self::_success('修改成功！', __URL__);
			}
			else{
				self::_error('修改失败！'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		else {
			$rs = $this->dao->where(array('name'=>$name))->find();
			if(!empty($rs) && sizeof($rs)>0) {
				self::_error('此客户姓名已被添加过！');
			}
			$this->dao->name = $name;
			$this->dao->phone = $phone;
			$this->dao->password = md5($password);
			$this->dao->project_id = $project_id;
			$this->dao->create_time = date("Y-m-d H:i:s");
			$this->dao->modify_time = date("Y-m-d H:i:s");
			$this->dao->status = 1;
			if($this->dao->add()) {
				self::_success('添加成功！', __URL__);
			}
			else {
				self::_error('添加失败！'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
	}
	public function next() {
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		$project_id = $this->dao->where('id='.$id)->getField('project_id');
		$project_info = M('Project')->find($project_id);
		$rs = M('Project')->where("sort=".$project_info['sort']." and id>".$project_id." or sort>".$project_info['sort'])->order('sort, id')->find();
		if (!empty($rs) && count($rs)>0) {
			$next_project_id = $rs['id'];
			if(false === $this->dao->where('id='.$id)->setField(array('project_id', 'modify_time'), array($next_project_id, date('Y-m-d H:i:s')))) {
				self::_error('修改失败！');
			}
			self::_success('修改成功！');
		}
		else {
			if(false === $this->dao->where('id='.$id)->setField(array('status', 'modify_time'), array(-1, date('Y-m-d H:i:s')))) {
				self::_error('修改失败！');
			}
			self::_success('修改成功！<br />已没有后续步骤，现将此客户归档！', __URL__, 3000);
		}
	}
	public function update() {
		parent::_update();
	}
	public function delete() {
		parent::_delete();
	}
}
?>