<?php
class AlbumAction extends BaseAction{
	protected $dao;

	public function _initialize() {
		parent::_initialize();
		$this->dao = D('Album');
	}

	public function index(){
		$topnavi[]=array(
			'text'=> '作品管理',
			'url' => __APP__.'/Album'
			);

		$order = 'sort';
		$where = array();
		if(!empty($_REQUEST['category_id'])) {
			//判断是否有子类
			$tmp_rs = M('Category')->where("pid=".$_REQUEST['category_id'])->getField('id,name');
			if (!empty($tmp_rs) && count($tmp_rs)>0) {
				$where['category_id'] = array('in', implode(',', array_keys($tmp_rs)));
			}
			else {
				$where['category_id'] = $_REQUEST['category_id'];
			}
			$topnavi[]=array(
				'text'=> '作品列表：'.M('Category')->where("id=".$_REQUEST['category_id'])->getField('name')
				);
		}
		else {
			$topnavi[]=array(
				'text'=> '全部作品',
				);
		}
		$where['status'] = array('gt', -1);
		if(!empty($_REQUEST['status'])) {
			$where['status'] = $_REQUEST['status'];
			$order = 'id desc';
		}
		$rs = $this->dao->relation(true)->where($where)->order($order)->select();

		$this->assign('list', $rs);

		$this->assign("topnavi",$topnavi);
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}
	public function form() {
		$topnavi[]=array(
			'text'=> '作品管理',
			'url' => __APP__.'/Album'
			);

		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		if ($id > 0) {
			$topnavi[]=array(
				'text'=> '修改内容',
				);
			$info = $this->dao->relation(true)->find($id);
			$pid = M('Category')->where("id=".$info['category_id'])->getField('pid');
			if (!empty($pid) && $pid>0) {
				$this->category_array['Album'] = M('Category')->where("pid=".$pid." and status>0")->getField('id,name');
			}
		}
		else {
			$topnavi[]=array(
				'text'=> '添加内容',
				);
			$info = array(
				'id' => 0,
				'category_id' => 0,
				'Photo' => array()
				);
			!empty($_REQUEST['category_id']) && ($info['category_id'] = $_REQUEST['category_id']);
			$max_sort = $this->dao->getField("max(sort)");
			$info['sort'] = $max_sort+2;
		}
		$info['category_opts'] = self::genOptions($this->category_array['Album'], $info['category_id']);
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
		$name = trim($_REQUEST['name']);
		''==$name && self::_error('标题必须填写！');
		$sort = intval($_REQUEST['sort']);
		if($id>0) {
			$rs = $this->dao->where(array('title'=>$title,'id'=>array('neq',$id)))->find();
			if($rs && sizeof($rs)>0){
				self::_error('此标题已被添加过！');
			}
			$this->dao->category_id = $category_id;
			$this->dao->name = $name;
			$this->dao->sort = $sort;
			$this->dao->modify_time = date("Y-m-d H:i:s");
			if(false !== $this->dao->where("id=".$id)->save()) {
				import('@.Image');
				$image = new Image();
				if ($_FILES['file']['size'] > 0) {
					$path = 'html/Attach/Album/'.$id.'.jpg';
					if (!$image->thumb($_FILES['file']['tmp_name'], $path, '', 160, 160)) {
						self::_error('上传缩略图出错！');
					}
					@unlink($_FILES['file']['tmp_name']);
				}
				//编辑原有图片
				foreach ($_FILES['_photo_file']['size'] as $i=>$size) {
					$photo_dao = M('Photo');
					if ($size>0) {
						$filename = date("YmdHis").substr(microtime(),1,7).'.'.strtolower(pathinfo($_FILES['_photo_file']['name'][$i], PATHINFO_EXTENSION));
						$src = 'html/Attach/Photo_src/'.$filename;
						$thumb = 'html/Attach/Photo_thumb/'.$filename;
						if (!move_uploaded_file($_FILES['_photo_file']['tmp_name'][$i], $src)) {
							self::_error('上传图片出错！');
						}
						if (!$image->thumb($src, $thumb, '', 170, 170)) {
							self::_error('生成缩略图出错！');
						}
						$data['name'] = $_REQUEST['_photo_name'][$i];
						$data['thumb'] = $thumb;
						$data['src'] = $src;
						$data['sort'] = $_REQUEST['_photo_sort'][$i];
						if (false === $photo_dao->where('id='.$i)->save($data)) {
							self::_error('添加图片记录出错！');
						}
					}
				}
				//新增的图片
				foreach ($_FILES['photo_file']['size'] as $i=>$size) {
					$photo_dao = M('Photo');
					$data = array(
						'album_id' => $id
						);
					if ($size>0) {
						$filename = date("YmdHis").substr(microtime(),1,7).'.'.strtolower(pathinfo($_FILES['photo_file']['name'][$i], PATHINFO_EXTENSION));
						$src = 'html/Attach/Photo_src/'.$filename;
						$thumb = 'html/Attach/Photo_thumb/'.$filename;
						if (!move_uploaded_file($_FILES['photo_file']['tmp_name'][$i], $src)) {
							self::_error('上传图片出错！');
						}
						if (!$image->thumb($src, $thumb, '', 170, 170)) {
							self::_error('生成缩略图出错！');
						}
						$data['name'] = $_REQUEST['photo_name'][$i];
						$data['thumb'] = $thumb;
						$data['src'] = $src;
						$data['sort'] = $_REQUEST['photo_sort'][$i];
						if (!$photo_dao->add($data)) {
							self::_error('添加图片记录出错！');
						}
					}
				}
				self::_success('修改成功！', __URL__.'/index/category_id/'.$category_id);
			}
			else{
				self::_error('修改失败！'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		else {
			$rs = $this->dao->where(array('name'=>$name, 'category_id'=>$category_id))->find();
			if(!empty($rs) && sizeof($rs)>0) {
				self::_error('当前分类下存在同名标题！');
			}
			$this->dao->category_id = $category_id;
			$this->dao->name = $name;
			$this->dao->sort = $sort;
			$this->dao->create_time = date("Y-m-d H:i:s");
			$this->dao->modify_time = date("Y-m-d H:i:s");
			$this->dao->status = 1;
			if($id = $this->dao->add()) {
				import('@.Image');
				$image = new Image();
				if ($_FILES['file']['size'] > 0) {
					$path = 'html/Attach/Album/'.$id.'.jpg';
					if (!$image->thumb($_FILES['file']['tmp_name'], $path, '', 160, 160)) {
						self::_error('上传缩略图出错！');
					}
					@unlink($_FILES['file']['tmp_name']);
				}
				foreach ($_FILES['photo_file']['size'] as $i=>$size) {
					$photo_dao = M('Photo');
					$data = array(
						'album_id' => $id
						);
					if ($size>0) {
						$filename = date("YmdHis").substr(microtime(),1,7).'.'.strtolower(pathinfo($_FILES['photo_file']['name'][$i], PATHINFO_EXTENSION));
						$src = 'html/Attach/Photo_src/'.$filename;
						$thumb = 'html/Attach/Photo_thumb/'.$filename;
						if (!move_uploaded_file($_FILES['photo_file']['tmp_name'][$i], $src)) {
							self::_error('上传图片出错！');
						}
						if (!$image->thumb($src, $thumb, '', 170, 170)) {
							self::_error('生成缩略图出错！');
						}
						$data['name'] = $_REQUEST['photo_name'][$i];
						$data['thumb'] = $thumb;
						$data['src'] = $src;
						$data['sort'] = $_REQUEST['photo_sort'][$i];
						if (!$photo_dao->add($data)) {
							self::_error('添加图片记录出错！');
						}
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