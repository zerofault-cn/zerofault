<?php
class ArticleAction extends BaseAction{
	protected $dao, $topnavi;

	public function _initialize() {
		parent::_initialize();
		$this->dao = D('Article');
		$this->topnavi[] = array(
			'text' => '内容管理'
			);
		$this->category_arr = M('Category')->where("type='Article' and status>0")->order('sort')->getField('id,name');
	}

	public function index(){
		$topnavi[]=array(
			'text'=> '文章管理',
			'url' => __APP__.'/Article'
			);

		$order = 'sort';
		$where = array();
		if(!empty($_REQUEST['category_id'])) {
			$where['category_id'] = $_REQUEST['category_id'];
			$topnavi[]=array(
				'text'=> '文章列表：'.$this->category_array['Article'][$_REQUEST['category_id']],
				);
		}
		else {
			$topnavi[]=array(
				'text'=> '全部文章',
				);
		}
		$rs = $this->dao->where($where)->order($order)->select();

		$this->assign('list', $rs);

		$this->assign("topnavi",$topnavi);
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}
	public function form() {
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);

		if ($id > 0) {
			$topnavi[]=array(
				'text'=> '修改文章内容',
				);
			$info = $this->dao->find($id);
		}
		else {
			$topnavi[]=array(
				'text'=> '添加文章',
				);
			$info = array(
				'id' => 0,
				'category_id' => 0
				);
			!empty($_REQUEST['category_id']) && ($info['category_id'] = $_REQUEST['category_id']);
			$max_sort = $this->dao->getField("max(sort)");
			$info['sort'] = $max_sort+2;
		}
		$info['category_opts'] = self::genOptions($this->category_array['Article'], $info['category_id']);
		$this->assign("info", $info);
		$this->assign("topnavi", $topnavi);

		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}

	public function submit(){
		if(empty($_POST['submit'])) {
			return;
		}
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);

		$category_id = intval($_REQUEST['category_id']);
		$category_id<=0 && self::_error('类别必须选择！');
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
			$this->dao->summary = $summary;
			$this->dao->content = $content;
			$this->dao->sort = $sort;
			$this->dao->modify_time = date("Y-m-d H:i:s");
			if(false !== $this->dao->where("id=".$id)->save()) {
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
			$this->dao->content = $content;
			$this->dao->sort = $sort;
			$this->dao->create_time = date("Y-m-d H:i:s");
			$this->dao->modify_time = date("Y-m-d H:i:s");
			$this->dao->status = 1;
			if($this->dao->add()) {
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