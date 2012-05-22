<?php
class DesignerAction extends BaseAction{
	protected $dao;

	public function _initialize() {
		$this->dao = D('Designer');
		parent::_initialize();
	}

	public function index(){
		$topnavi[]=array(
			'text'=> '设计师管理',
			'url' => __APP__.'/Designer'
			);

		$order = 'id desc';
		$topnavi[]=array(
			'text'=> '设计师列表',
			);

		$where = array();
		$where['status'] = array('gt', -1);
		if(!empty($_REQUEST['status'])) {
			$where['status'] = $_REQUEST['status'];
			$order = 'id desc';
		}
		if (!empty($_REQUEST['s_name'])) {
			$where['name'] = array('LIKE', '%'.trim($_REQUEST['s_name']).'%');
			$this->assign('s_name', $_REQUEST['s_name']);
		}
		$count = $this->dao->where($where)->getField('count(*)');
		import("@.Paginator");
		$limit = 20;
		$p = new Paginator($count,$limit);
		$rs = $this->dao->relation(true)->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();

		$this->assign("topnavi",$topnavi);
		$this->assign('page', $p->showMultiNavi());
		$this->assign('list', $rs);
		$this->assign('content',ACTION_NAME);
		$this->display('Layout:default');
	}
	public function case_form() {
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		$dao = M('Case');
		if(!empty($_POST['submit'])) {
			$designer_id = intval($_REQUEST['designer_id']);
			$name = trim($_REQUEST['name']);
			''==$name && self::_error('案例名称必须填写！');
			$url = trim($_REQUEST['url']);
			if ($id>0) {
				$dao->name = $name;
				$dao->url = $url;
				if($dao->where("id=".$id)->save()) {
					if ($_FILES['thumb']['size']>0) {
						move_uploaded_file($_FILES['thumb']['tmp_name'], 'html/Attach/case_thumb/'.$id.'.jpg');
					}
					self::_success('修改成功！', __URL__);
				}
				else{
					self::_error('修改失败！'.(C('APP_DEBUG')?$dao->getLastSql():''));
				}
			}
			else {
				$dao->designer_id = $designer_id;
				$dao->name = $name;
				$dao->url = $url;
				$dao->status = 1;
				if($case_id = $dao->add()) {
					if ($_FILES['thumb']['size']>0) {
						move_uploaded_file($_FILES['thumb']['tmp_name'], 'html/Attach/case_thumb/'.$case_id.'.jpg');
					}
					self::_success('添加成功！', __URL__);
				}
				else {
					self::_error('添加失败！'.(C('APP_DEBUG')?$dao->getLastSql():''));
				}
			}
			exit;
		}
		if ($id > 0) {
			$topnavi[]=array(
				'text'=> '修改案例信息',
				);
			$info = $dao->find($id);
		}
		else {
			$topnavi[]=array(
				'text'=> '添加案例',
				);
			$info = array('id' => 0);
			$info['designer_id'] = intval($_REQUEST['designer_id']);
			$max_sort = $dao->getField("max(sort)");//获取最大sort值，用于分配给新增记录的默认sort值
			$info['sort'] = $max_sort+2;
		}
		$this->assign("topnavi", $topnavi);
		$this->assign("info", $info);

		$this->assign('content',ACTION_NAME);
		$this->display('Layout:default');
	}
	public function form() {
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);

		if ($id > 0) {
			$topnavi[]=array(
				'text'=> '修改设计师资料',
				);
			$info = $this->dao->find($id);
		}
		else {
			$topnavi[]=array(
				'text'=> '添加设计师',
				);
			$info = array('id' => 0);
			$max_sort = $this->dao->getField("max(sort)");//获取最大sort值，用于分配给新增记录的默认sort值
			$info['sort'] = $max_sort+2;
		}
		$this->assign("topnavi", $topnavi);
		$this->assign("info", $info);

		$this->assign('content',ACTION_NAME);
		$this->display('Layout:default');
	}

	public function submit(){
		if(empty($_POST['submit'])) {
			return;
		}
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);

		$name = trim($_REQUEST['name']);
		''==$name && self::_error('设计师姓名必须填写！');
		$feature = trim($_REQUEST['feature']);
		$workdate = trim($_REQUEST['workdate']);
		''==$workdate && ($workdate=date('Y-m-d'));
		$title = trim($_REQUEST['title']);
		$introduction = trim($_REQUEST['introduction']);
		$sort = intval($_REQUEST['sort']);
		if($id>0) {
			$rs = $this->dao->where(array('name'=>$name,'id'=>array('neq',$id)))->find();
			if($rs && sizeof($rs)>0){
				self::_error('此设计师已被添加过！');
			}
			$this->dao->name = $name;
			$this->dao->feature = $feature;
			$this->dao->workdate = $workdate;
			$this->dao->title = $title;
			$this->dao->introduction = $introduction;
			$this->dao->sort = $sort;
			if($this->dao->where("id=".$id)->save()) {
				self::_success('修改成功！', __URL__);
			}
			else{
				self::_error('修改失败！'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		else {
			$rs = $this->dao->where(array('name'=>$name))->find();
			if(!empty($rs) && sizeof($rs)>0) {
				self::_error('此设计师已被添加过！');
			}
			$this->dao->name = $name;
			$this->dao->feature = $feature;
			$this->dao->workdate = $workdate;
			$this->dao->title = $title;
			$this->dao->introduction = $introduction;
			$this->dao->sort = $sort;
			$this->dao->addtime = date("Y-m-d H:i:s");
			$this->dao->status = 1;
			if($this->dao->add()) {
				self::_success('添加成功！', __URL__);
			}
			else {
				self::_error('添加失败！'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
	}
	/**
	*
	* 调用基类方法
	*/
	public function update(){
		parent::_update();
	}
	/**
	*
	* 调用基类方法
	*/
	public function delete(){
		parent::_delete();
	}
}
?>