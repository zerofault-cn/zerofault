<?php
class PhotoAction extends BaseAction{
	protected $dao;

	public function _initialize() {
		parent::_initialize();
		$this->dao = D('Photo');
	}

	public function index(){
		//直接管理Photo
		if (empty($_REQUEST['album_id'])) {
			$where = array(
				'category_id' => 3
				);
		}
		else {
			$where = array(
				'album_id' => intval($_REQUEST['album_id'])
				);
		}
		$topnavi[]=array(
			'text'=> '图片列表',
			);
		$order = 'sort, id desc';
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

		$this->assign("topnavi", $topnavi);
		$this->assign('content', 'Photo:index');
		$this->display('Layout:default');
	}
	public function genXML() {
		$where = array(
			'category_id' => 3,
			'status' => array('gt', 0)
			);
		$order = 'sort';
		$rs = $this->dao->where($where)->order($order)->select();
		empty($rs) && ($rs = array());
		foreach ($rs as $row) {
		}
	}
	public function form() {
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		if ($id > 0) {
			$topnavi[]=array(
				'text'=> '修改图片',
				);
			$info = $this->dao->relation(true)->find($id);
		}
		else {
			$topnavi[]=array(
				'text'=> '添加图片',
				);
			$info = array(
				'id' => 0,
				'category_id' => 0,
				'album_id' => 0,
				'sort' => 100,
				);
			if (!empty($_REQUEST['category_id'])) {
				$info['category_id'] = intval($_REQUEST['category_id']);
				$info['Category'] = M('Category')->find($info['category_id']);
			}
		}
		$this->assign("info", $info);
		$this->assign("topnavi", $topnavi);

		$this->assign('content', 'Photo:form');
		$this->display('Layout:default');
	}
	
	public function submit(){
		if(empty($_POST['submit'])) {
			return;
		}
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);

		$category_id = intval($_REQUEST['category_id']);
		$album_id = intval($_REQUEST['album_id']);
		$name = trim($_REQUEST['name']);
		$sort = intval($_REQUEST['sort']);
		if($id>0) {
			$this->dao->name = $name;
			$this->dao->sort = $sort;
			if(false !== $this->dao->where("id=".$id)->save()) {
				import('@.Image');
				$image = new Image();
				if ($_FILES['file']['size'] > 0) {
					$filename = date("YmdHis").substr(microtime(),1,7).'.'.strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
					$src = 'html/Attach/Photo_src/'.$filename;
					$thumb = 'html/Attach/Photo_thumb/'.$filename;
					if (!move_uploaded_file($_FILES['file']['tmp_name'], $src)) {
						self::_error('上传图片出错！');
					}
					if (3 == $category_id) {
						$maxWidth = 680;
						$maxHeight = 345;
					}
					else {
						$maxWidth = 170;
						$maxHeight = 170;
					}
					if (!$image->thumb($src, $thumb, '', $maxWidth, $maxHeight)) {
						self::_error('生成缩略图出错！');
					}
					$image_info = $image->getImageInfo($src);
					$this->dao->thumb = $thumb;
					$this->dao->src = $src;
					$this->dao->width = $image_info['width'];
					$this->dao->height = $image_info['height'];
					$this->dao->type = $image_info['type'];
					$this->dao->size = $image_info['size'];
					if (false === $this->dao->where('id='.$id)->save()) {
						self::_error('更新图片记录出错！');
					}
				}
				self::_success('修改成功！', __APP__.'/Photo/index/category_id/'.$category_id.'/album_id/'.$album_id);
			}
			else{
				self::_error('修改失败！'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		else {
			$this->dao->category_id = $category_id;
			$this->dao->album_id = $album_id;
			$this->dao->name = $name;
			$this->dao->sort = $sort;
			$this->dao->addtime = date("Y-m-d H:i:s");
			$this->dao->status = 1;
			if($id = $this->dao->add()) {
				import('@.Image');
				$image = new Image();
				if ($_FILES['file']['size'] > 0) {
					$filename = date("YmdHis").substr(microtime(),1,7).'.'.strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
					$src = 'html/Attach/Photo_src/'.$filename;
					$thumb = 'html/Attach/Photo_thumb/'.$filename;
					if (!move_uploaded_file($_FILES['file']['tmp_name'], $src)) {
						self::_error('上传图片出错！');
					}
					if (3 == $category_id) {
						$maxWidth = 680;
						$maxHeight = 345;
					}
					else {
						$maxWidth = 170;
						$maxHeight = 170;
					}
					if (!$image->thumb($src, $thumb, '', $maxWidth, $maxHeight)) {
						self::_error('生成缩略图出错！');
					}
					$image_info = $image->getImageInfo($src);
					$this->dao->thumb = $thumb;
					$this->dao->src = $src;
					$this->dao->width = $image_info['width'];
					$this->dao->height = $image_info['height'];
					$this->dao->type = $image_info['type'];
					$this->dao->size = $image_info['size'];
					if (false === $this->dao->where('id='.$id)->save()) {
						self::_error('更新图片记录出错！');
					}
				}
				
				self::_success('添加成功！', __APP__.'/Photo/index/category_id/'.$category_id.'/album_id/'.$album_id);
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
		$info = $this->dao->find(intval($_REQUEST['id']));
		@unlink($info['thumb']);
		@unlink($info['src']);
		parent::_delete();
	}
}
?>