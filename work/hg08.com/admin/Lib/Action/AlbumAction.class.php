<?php
class AlbumAction extends BaseAction{
	protected $dao;

	public function _initialize() {
		parent::_initialize();
		$this->dao = D('Album');
	}

	public function category() {
		$this->dao = D('Category');
		if (!empty($_POST)) {
			$name = trim($_REQUEST['name']);
			empty($name) && self::_error('分类名称必须填写！');
			$sort = intval($_REQUEST['sort']);
			$this->dao->pid = 4;
			$this->dao->type = 'Album';
			$this->dao->name = $name;
			$this->dao->sort = $sort;
			if ($this->dao->add()) {
				self::_success('添加成功！');
			}
			else {
				self::_error('添加失败！'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}

		$topnavi[]=array(
			'text'=> '作品分类',
			);
		$rs = $this->dao->relation(true)->where('pid=4')->order('sort')->select();
		$this->assign('list', $rs);

		$this->assign("topnavi",$topnavi);
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}
	public function index(){
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
			$this->assign('category_id', $_REQUEST['category_id']);
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
		$count = $this->dao->where($where)->count();
		import("@.Paginator");
		$limit = 20;
		$p = new Paginator($count, $limit);
		$rs = $this->dao->relation(true)->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();
		$this->assign('list', $rs);

		$this->assign("topnavi",$topnavi);
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}
	public function photo() {
		R('Photo', 'index');
	}
	public function form() {
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		if ($id > 0) {
			$topnavi[]=array(
				'text'=> '修改相册',
				);
			$info = $this->dao->relation(true)->find($id);
			$pid = M('Category')->where("id=".$info['category_id'])->getField('pid');
			if (!empty($pid) && $pid>0) {
				$this->category_array['Album'] = M('Category')->where("pid=".$pid." and status>0")->getField('id,name');
			}
		}
		else {
			$topnavi[]=array(
				'text'=> '添加相册',
				);
			$info = array(
				'id' => 0,
				'category_id' => 0,
				'sort' => 100,
				'Photo' => array()
				);
			!empty($_REQUEST['category_id']) && ($info['category_id'] = $_REQUEST['category_id']);
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
					if (!$image->thumb($_FILES['file']['tmp_name'], $path, '', 210, 310)) {
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
						if (3 == $category_id) {
							$maxWidth = 680;
							$maxHeight = 345;
						}
						else {
							$maxWidth = 200;
							$maxHeight = 200;
						}
						if (!$image->thumb($src, $thumb, '', $maxWidth, $maxHeight)) {
							self::_error('生成缩略图出错！');
						}
						$data['name'] = $_REQUEST['_photo_name'][$i];
						$data['thumb'] = $thumb;
						$data['src'] = $src;
						$data['sort'] = $_REQUEST['_photo_sort'][$i];

						$image_info = $image->getImageInfo($src);
						$data['width'] = $image_info['width'];
						$data['height'] = $image_info['height'];
						$data['type'] = $image_info['type'];
						$data['size'] = $image_info['size'];
						if (false === $photo_dao->where('id='.$i)->save($data)) {
							self::_error('添加图片记录出错！');
						}
					}
				}
				//新增的图片
				foreach ($_FILES['photo_file']['size'] as $i=>$size) {
					$photo_dao = M('Photo');
					$data = array(
						'category_id' => $category_id,
						'album_id' => $id
						);
					if ($size>0) {
						$filename = date("YmdHis").substr(microtime(),1,7).'.'.strtolower(pathinfo($_FILES['photo_file']['name'][$i], PATHINFO_EXTENSION));
						$src = 'html/Attach/Photo_src/'.$filename;
						$thumb = 'html/Attach/Photo_thumb/'.$filename;
						if (!move_uploaded_file($_FILES['photo_file']['tmp_name'][$i], $src)) {
							self::_error('上传图片出错！');
						}
						if (3 == $category_id) {
							$maxWidth = 680;
							$maxHeight = 345;
						}
						else {
							$maxWidth = 200;
							$maxHeight = 200;
						}
						if (!$image->thumb($src, $thumb, '', $maxWidth, $maxHeight)) {
							self::_error('生成缩略图出错！');
						}
						$data['name'] = $_REQUEST['photo_name'][$i];
						$data['thumb'] = $thumb;
						$data['src'] = $src;
						$data['sort'] = $_REQUEST['photo_sort'][$i];
						$data['status'] = 1;

						$image_info = $image->getImageInfo($src);
						$data['width'] = $image_info['width'];
						$data['height'] = $image_info['height'];
						$data['type'] = $image_info['type'];
						$data['size'] = $image_info['size'];
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
					if (!$image->thumb($_FILES['file']['tmp_name'], $path, '', 210, 310)) {
						self::_error('上传缩略图出错！');
					}
					@unlink($_FILES['file']['tmp_name']);
				}
				foreach ($_FILES['photo_file']['size'] as $i=>$size) {
					$photo_dao = M('Photo');
					$data = array(
						'category_id' => $category_id,
						'album_id' => $id
						);
					if ($size>0) {
						$filename = date("YmdHis").substr(microtime(),1,7).'.'.strtolower(pathinfo($_FILES['photo_file']['name'][$i], PATHINFO_EXTENSION));
						$src = 'html/Attach/Photo_src/'.$filename;
						$thumb = 'html/Attach/Photo_thumb/'.$filename;
						if (!move_uploaded_file($_FILES['photo_file']['tmp_name'][$i], $src)) {
							self::_error('上传图片出错！');
						}
						if (3 == $category_id) {
							$maxWidth = 680;
							$maxHeight = 345;
						}
						else {
							$maxWidth = 200;
							$maxHeight = 200;
						}
						if (!$image->thumb($src, $thumb, '', $maxWidth, $maxHeight)) {
							self::_error('生成缩略图出错！');
						}
						$data['name'] = $_REQUEST['photo_name'][$i];
						$data['thumb'] = $thumb;
						$data['src'] = $src;
						$data['sort'] = $_REQUEST['photo_sort'][$i];
						$data['status'] = 1;
						
						$image_info = $image->getImageInfo($src);
						$data['width'] = $image_info['width'];
						$data['height'] = $image_info['height'];
						$data['type'] = $image_info['type'];
						$data['size'] = $image_info['size'];
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
	public function update() {
		parent::_update();
	}

	public function delete() {
		$id = intval($_REQUEST['id']);
		if (M('Photo')->where('album_id='.$id)->count() > 0) {
			self::_error('该作品相册下还有图片文件，不能删除！');
		}
		parent::_delete();
	}
	public function delete_category() {
		$this->dao = M('Category');
		$id = intval($_REQUEST['id']);
		if (M('Album')->where('category_id='.$id)->count() > 0) {
			self::_error('该分类下还有作品，不能删除！');
		}
		parent::_delete();
	}
}
?>