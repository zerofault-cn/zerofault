<?php
class HotelAction extends BaseAction{
	protected $dao, $topnavi;

	protected function _initialize() {
		parent::_initialize();
		$this->dao = D('Hotel');
		$this->topnavi[] = array(
			'text' => '酒店管理'
			);
	}

	public function index(){
		$topnavi[]=array(
			'text'=> empty($_REQUEST['category_id'])?'酒店列表':M('Category')->where("id=".intval($_REQUEST['category_id']))->getField('name'),
			);
		$this->assign("topnavi", $topnavi);

		$where = array();
		$order = 'sort';
		$where['status'] = array('gt', -1);
		if(!empty($_REQUEST['status'])) {
			$where['status'] = $_REQUEST['status'];
			$order = 'id desc';
		}
		if (!empty($_REQUEST['category_id'])) {
			$where['category_id'] = intval($_REQUEST['category_id']);
			$this->assign('category_id', $_REQUEST['category_id']);
		}
		$count = $this->dao->where($where)->count();
		import("@.Paginator");
		$limit = 20;
		$p = new Paginator($count,$limit);
		$rs = $this->dao->relation(true)->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();
		$this->assign('list', $rs);
		$this->assign('page', $p->showMultiNavi());

		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}
	public function form() {
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);

		if ($id > 0) {
			$topnavi[]=array(
				'text'=> '修改酒店信息',
				);
			$info = $this->dao->find($id);
		}
		else {
			$topnavi[]=array(
				'text'=> '添加酒店',
				);
			$info = array(
				'id' => 0,
				'category_id' => intval($_REQUEST['category_id']),
				'region_id' => 0,
				'district_id' => 0,
				'level_id' => 0
				);
			!empty($_REQUEST['category_id']) && ($info['category_id'] = $_REQUEST['category_id']);
			$max_sort = $this->dao->getField("max(sort)");//获取最大sort值，用于分配给新增记录的默认sort值
			$info['sort'] = $max_sort+2;
		}
		$info['category_opts'] = self::genOptions(M('Category')->where("type='Hotel' and status=1")->order('sort')->getField('id,name'), $info['category_id']);
		$info['region_opts'] = self::genOptions(M('Region')->where("pid=2")->order('sort')->getField('id,name'), $info['region_id']);
		$info['district_opts'] = self::genOptions(M('District')->order('sort')->getField('id,name'), $info['district_id']);
		$info['level_opts'] = self::genOptions(M('Level')->order('sort')->getField('id,name'), $info['level_id']);
		$this->assign("info", $info);
		$this->assign("topnavi", $topnavi);

		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}
	public function client_edit() {
		if (empty($_SESSION['hotel_id'])) {
			return;
		}
		$id = $_SESSION['hotel_id'];
		$info = $this->dao->find($id);

		$info['category_opts'] = self::genOptions(M('Category')->where("type='Hotel' and status=1")->order('sort')->getField('id,name'), $info['category_id']);
		$info['region_opts'] = self::genOptions(M('Region')->where("pid=2")->order('sort')->getField('id,name'), $info['region_id']);
		$info['district_opts'] = self::genOptions(M('District')->order('sort')->getField('id,name'), $info['district_id']);
		$info['level_opts'] = self::genOptions(M('Level')->order('sort')->getField('id,name'), $info['level_id']);
		$this->assign("info", $info);

		$this->assign('content', 'form');
		$this->display('Layout:main');
	}
	public function client_submit() {
		$this->submit();
	}
	public function submit(){
		if(empty($_POST['submit'])) {
			return;
		}
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);

		$name = trim($_REQUEST['name']);
		''==$name && self::_error('酒店名称必须填写！');
		
		$password = trim($_REQUEST['password']);

		$address = trim($_REQUEST['address']);
		$category_id = intval($_REQUEST['category_id']);
		empty($category_id) && self::_error('酒店分类必须选择！');
		$region_id = intval($_REQUEST['region_id']);
		empty($region_id) && self::_error('行政区域必须选择！');
		$district_id = intval($_REQUEST['district_id']);
		empty($district_id) && self::_error('商业区域必须选择！');
		$level_id = intval($_REQUEST['level_id']);
		empty($level_id) && self::_error('酒店星级必须选择！');
		$capacity = intval($_REQUEST['capacity']);
		empty($capacity) && self::_error('酒店承接能力必须填写！');
		
		$introduction = trim($_REQUEST['introduction']);
		$sort = intval($_REQUEST['sort']);
		if($id>0) {
			$rs = $this->dao->where(array('name'=>$name,'id'=>array('neq',$id), 'category_id'=>$category_id))->find();
			if($rs && sizeof($rs)>0) {
				self::_error('此酒店已被添加过！');
			}
			if (!empty($password)) {
				strlen($password)<6 && self::_error('新密码至少需要6个字符！');
				strlen($password)>20 && self::_error('新密码不能超过20个字符！');
				$password2 = trim($_REQUEST['password2']);
				$password!=$password2 && self::_error('两次输入的新密码不一致！');
				$this->dao->password = md5($password);
			}
			$this->dao->name = $name;
			$this->dao->address = $address;
			$this->dao->category_id = $category_id;
			$this->dao->region_id = $region_id;
			$this->dao->district_id = $district_id;
			$this->dao->level_id = $level_id;
			$this->dao->capacity = $capacity;
			$this->dao->introduction = $introduction;
			if(false !== $this->dao->where("id=".$id)->save()) {
				if($_FILES['file']['size'] > 0) {
					$path = 'html/Attach/Hotel/'.$id.'.jpg';
					if (!move_uploaded_file($_FILES['file']['tmp_name'], $path)) {
						self::_error('上传缩略图出错！');
					}
				}
				if (-1 == $_SESSION[C('USER_AUTH_KEY')]) {
					self::_success('修改成功！');
				}
				else {
					self::_success('修改成功！', __URL__.'/index/category_id/'.$category_id);
				}
			}
			else{
				self::_error('修改失败！'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
		else {
			$rs = $this->dao->where(array('name'=>$name, 'category_id'=>$category_id))->find();
			if(!empty($rs) && sizeof($rs)>0) {
				self::_error('此酒店已被添加过！');
			}
			''==$password && self::_error('密码不能为空！');

			$this->dao->name = $name;
			$this->dao->password = md5($password);
			$this->dao->category_id = $category_id;
			$this->dao->region_id = $region_id;
			$this->dao->district_id = $district_id;
			$this->dao->level_id = $level_id;
			$this->dao->capacity = $capacity;
			$this->dao->introduction = $introduction;
			$this->dao->sort = $sort;
			$this->dao->addtime = date("Y-m-d H:i:s");
			$this->dao->status = 1;
			if($id=$this->dao->add()) {
				if($_FILES['file']['size'] > 0) {
					$path = 'html/Attach/Hotel/'.$id.'.jpg';
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
	public function update(){
		'password'==$_REQUEST['f'] && ($_REQUEST['v']=md5($_REQUEST['v']));
		parent::_update();
	}
	public function delete(){
		parent::_delete();
	}
}
?>