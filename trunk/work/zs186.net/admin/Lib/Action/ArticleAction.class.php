<?php
class ArticleAction extends BaseAction{
	protected $dao, $topnavi;

	public function _initialize() {
		parent::_initialize();
		$this->dao = D('Article');
	}

	public function index(){
		$topnavi[]=array(
			'text'=> '内容管理',
			'url' => __APP__.'/Article'
			);

		$order = 'sort, id desc';
		$where = array();
		if(!empty($_REQUEST['category_id'])) {
			//判断是否有子类
			$tmp_rs = M('Category')->where("pid=".$_REQUEST['category_id'])->getField('id,name');
			if (!empty($tmp_rs) && count($tmp_rs)>0) {
				$tmp_rs[$_REQUEST['category_id']] = '';
				$where['category_id'] = array('in', implode(',', array_keys($tmp_rs)));
			}
			else {
				$where['category_id'] = $_REQUEST['category_id'];
			}
			$topnavi[]=array(
				'text'=> '内容列表：'.M('Category')->where("id=".$_REQUEST['category_id'])->getField('name'),
				);
		}
		else {
			$topnavi[]=array(
				'text'=> '全部内容',
				);
		}
		$where['status'] = array('gt', -1);
		if(!empty($_REQUEST['status'])) {
			$where['status'] = $_REQUEST['status'];
		}
		$count = $this->dao->where($where)->count();
		import("@.Paginator");
		$limit = 20;
		$p = new Paginator($count,$limit);
		$rs = $this->dao->relation(true)->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();
		$this->assign('list', $rs);
		$this->assign('page', $p->showMultiNavi());

		$this->assign("topnavi",$topnavi);
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}

	public function form() {
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);

		if ($id > 0) {
			$topnavi[]=array(
				'text'=> '修改内容',
				);
			$info = $this->dao->find($id);
			$pid = M('Category')->where("id=".$info['category_id'])->getField('pid');
			if (!empty($pid) && $pid>0) {
				$this->category_array['Article'] = M('Category')->where("pid=".$pid." and status>0")->getField('id,name');
			}
		}
		else {
			$topnavi[]=array(
				'text'=> '添加内容',
				);
			$info = array(
				'id' => 0,
				'category_id' => 0
				);
			!empty($_REQUEST['category_id']) && ($info['category_id'] = $_REQUEST['category_id']);
			$info['sort'] = 100;
		}
		$info['category_opts'] = self::genOptions($this->category_array['Article'], $info['category_id']);
		$this->assign("info", $info);
		$this->assign("topnavi", $topnavi);

		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}
	public function sub_category() {
		$id = intval($_REQUEST['id']);
		$rs = M('Category')->where("pid=".$id." and status>0")->order('sort')->getField('id,name');
		empty($rs) && ($rs = array());
		die(json_encode($rs));
	}

	public function submit(){
		if(empty($_POST['submit'])) {
			return;
		}
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);

		$category_id = intval($_REQUEST['category_id']);
		$category_id<=0 && self::_error('分类必须选择！');
		$title = trim($_REQUEST['title']);
		''==$title && self::_error('标题必须填写！');
		$author = trim($_REQUEST['author']);
		$summary = trim($_REQUEST['summary']);
		$content = trim($_REQUEST['content']);
		$sort = intval($_REQUEST['sort']);
		if($id>0) {
			$rs = $this->dao->where(array('title'=>$title,'id'=>array('neq',$id)))->find();
			if($rs && sizeof($rs)>0){
				self::_error('此标题已被添加过！');
			}
			$this->dao->category_id = $category_id;
			$this->dao->title = $title;
			$this->dao->author = $author;
			$this->dao->summary = $summary;
			$this->dao->content = $content;
			$this->dao->sort = $sort;
			$this->dao->modify_time = date("Y-m-d H:i:s");
			if(false !== $this->dao->where("id=".$id)->save()) {
				if($_FILES['file']['size'] > 0) {
					$path = 'html/Attach/Article/'.$id.'.jpg';
					if (!move_uploaded_file($_FILES['file']['tmp_name'], $path)) {
						self::_error('上传缩略图出错！');
					}
				}
				self::_success('修改成功！', __URL__.'/index/category_id/'.$category_id);
			}
			else{
				self::_error('修改失败！'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		else {
			$rs = $this->dao->where(array('title'=>$title))->find();
			if(!empty($rs) && sizeof($rs)>0) {
				self::_error('此标题已被添加过！');
			}
			$this->dao->category_id = $category_id;
			$this->dao->title = $title;
			$this->dao->author = $author;
			$this->dao->summary = $summary;
			$this->dao->content = $content;
			$this->dao->sort = $sort;
			$this->dao->create_time = date("Y-m-d H:i:s");
			$this->dao->modify_time = date("Y-m-d H:i:s");
			$this->dao->status = 1;
			if($id = $this->dao->add()) {
				if($_FILES['file']['size'] > 0) {
					$path = 'html/Attach/Article/'.$id.'.jpg';
					if (!move_uploaded_file($_FILES['file']['tmp_name'], $path)) {
						self::_error('上传缩略图出错！');
					}
				}
				self::_success('添加成功！', __URL__.'/index/category_id/'.$category_id);
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