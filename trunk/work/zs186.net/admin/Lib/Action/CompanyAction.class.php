<?php
class CompanyAction extends BaseAction{
	protected $dao;

	public function _initialize() {
		$this->dao = D('Company');
		parent::_initialize();
	}

	public function index(){
		$topnavi[]=array(
			'text'=> '公司管理',
			'url' => __APP__.'/Company'
			);

		$order = 'id desc';
		$topnavi[]=array(
			'text'=> '公司列表',
			);
		$this->assign("topnavi",$topnavi);

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
				'text'=> '修改公司资料',
				);
			$info = $this->dao->find($id);
		}
		else {
			$topnavi[]=array(
				'text'=> '添加公司',
				);
			$info = array('id' => 0);
			$max_sort = $this->dao->getField("max(sort)");//获取最大sort值，用于分配给新增记录的默认sort值
			$info['sort'] = $max_sort+2;
		}
		$this->assign("topnavi", $topnavi);
		$this->assign("info", $info);

		$qualification_arr = array('一级', '二级', '三级', '甲级', '乙级', '丙级');
		$this->assign('qualification_options', self::genOptions(array_combine($qualification_arr, $qualification_arr), $info['qualification']));

		$this->assign('content',ACTION_NAME);
		$this->display('Layout:default');
	}

	public function submit(){
		if(empty($_POST['submit'])) {
			return;
		}
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);

		$name = trim($_REQUEST['name']);
		''==$name && self::_error('公司名称必须填写！');
		$address = trim($_REQUEST['address']);
		$mobile = trim($_REQUEST['mobile']);
		$telephone = trim($_REQUEST['telephone']);
		$introduction = trim($_REQUEST['introduction']);
		$qualification = trim($_REQUEST['qualification']);
		$capital = trim($_REQUEST['capital']);
		$establish_date = trim($_REQUEST['establish_date']);
		strtotime($establish_date)<=0 && self::_error('成立日期的格式错误！');
		$scale = trim($_REQUEST['scale']);
		$fixed_price = trim($_REQUEST['fixed_price']);
		$business_line = trim($_REQUEST['business_line']);
		$sort = intval($_REQUEST['sort']);
		if($id>0) {
			$rs = $this->dao->where(array('name'=>$name,'id'=>array('neq',$id)))->find();
			if($rs && sizeof($rs)>0){
				self::_error('此公司名称已被添加过！');
			}
			$this->dao->name = $name;
			$this->dao->address = $address;
			$this->dao->mobile = $mobile;
			$this->dao->telephone = $telephone;
			$this->dao->introduction = $introduction;
			$this->dao->qualification = $qualification;
			$this->dao->capital = $capital;
			$this->dao->establish_date = $establish_date;
			$this->dao->scale = $scale;
			$this->dao->fixed_price = $fixed_price;
			$this->dao->business_line = $business_line;
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
				self::_error('此公司名称已被添加过！');
			}
			$this->dao->name = $name;
			$this->dao->address = $address;
			$this->dao->mobile = $mobile;
			$this->dao->telephone = $telephone;
			$this->dao->introduction = $introduction;
			$this->dao->addtime = date("Y-m-d H:i:s");
			$this->dao->sort = $sort;
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
	public function update_bit() {
		$id=$_REQUEST['id'];
		$field=$_REQUEST['f'];
		$value=intval($_REQUEST['v']);
		if ($value<0) {
			$rs = $this->dao->setDec($field, 'id='.$id, abs($value));
		}
		else {
			$rs = $this->dao->setInc($field, 'id='.$id, $value);
		}
		if(false !== $rs)
		{
		//	Log::Write($this->dao->getLastSql(), INFO);
			self::_success('操作成功！','',1200);
		}
		else
		{
			self::_error('发生错误！'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
		}
	}
	/**
	*
	* 调用基类方法
	*/
	public function delete(){
		parent::_delete();
	}

	public function case_form() {
		$topnavi[]=array(
			'text'=> '公司管理',
			'url' => __APP__.'/Company'
			);

		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		$dao = D('Case');
		if(!empty($_POST['submit'])) {
			$company_id = intval($_REQUEST['company_id']);
			$name = trim($_REQUEST['name']);
			''==$name && self::_error('案例名称必须填写！');
			$sort = intval($_REQUEST['sort']);
			if ($id>0) {
				$dao->name = $name;
				$dao->sort = $sort;
				if(false !== $dao->where("id=".$id)->save()) {
					if ($_FILES['thumb']['size']>0) {
						move_uploaded_file($_FILES['thumb']['tmp_name'], 'html/Attach/case_thumb/'.$id.'.jpg');
					}
					foreach ($_FILES['img_file']['size'] as $i=>$size) {
						if($size > 0) {
							$data = array(
								'name' => $_REQUEST['img_name'][$i],
								'type' => $_FILES['img_file']['type'][$i],
								'size' => $size,
								'path' => 'html/Attach/case_pic/'.date("YmdHis").substr(microtime(),1,7).'.'.strtolower(pathinfo($_FILES['img_file']['name'][$i], PATHINFO_EXTENSION)),
								'model_name' => 'Case',
								'model_id' => $id,
								'staff_id' => 0,
								'upload_time' => date('Y-m-d H:i:s'),
								'status' => 1
								);
							if (move_uploaded_file($_FILES['img_file']['tmp_name'][$i], $data['path'])) {
								if (!M('Attachment')->add($data)) {
									self::_error('Insert fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
								}
							}
							else {
								self::_error('Move '.$_FILES['img_file']['tmp_name'][$i].' to '.$data['path'].' fail!');
							}
						}
					}
					self::_success('修改成功！', __URL__);
				}
				else{
					self::_error('修改失败！'.(C('APP_DEBUG')?$dao->getLastSql():''));
				}
			}
			else {
				$dao->company_id = $company_id;
				$dao->name = $name;
				$dao->sort = $sort;
				$dao->status = 1;
				if($case_id = $dao->add()) {
					if ($_FILES['thumb']['size']>0) {
						move_uploaded_file($_FILES['thumb']['tmp_name'], 'html/Attach/case_thumb/'.$case_id.'.jpg');
					}
					foreach ($_FILES['img_file']['size'] as $i=>$size) {
						if($size > 0) {
							$data = array(
								'name' => $_REQUEST['img_name'][$i],
								'type' => $_FILES['img_file']['type'][$i],
								'size' => $size,
								'path' => 'html/Attach/case_pic/'.date("YmdHis").substr(microtime(),1,7).'.'.strtolower(pathinfo($_FILES['img_file']['name'][$i], PATHINFO_EXTENSION)),
								'model_name' => 'Case',
								'model_id' => $case_id,
								'staff_id' => 0,
								'upload_time' => date('Y-m-d H:i:s'),
								'status' => 1
								);
							if (move_uploaded_file($_FILES['img_file']['tmp_name'][$i], $data['path'])) {
								if (!M('Attachment')->add($data)) {
									self::_error('Insert fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
								}
							}
							else {
								self::_error('Move '.$_FILES['img_file']['tmp_name'][$i].' to '.$data['path'].' fail!');
							}
						}
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
			$info = $dao->relation(true)->find($id);
			$company = $this->dao->find($info['company_id']);
			$topnavi[]=array(
				'text'=> $company['name'],
				);
			$topnavi[]=array(
				'text'=> '修改案例信息',
				);
		}
		else {
			$company = $this->dao->find($_REQUEST['company_id']);
			$topnavi[]=array(
				'text'=> $company['name'],
				);
			$topnavi[]=array(
				'text'=> '添加案例',
				);
			$info = array('id' => 0);
			$info['company_id'] = intval($_REQUEST['company_id']);
			$max_sort = $dao->getField("max(sort)");//获取最大sort值，用于分配给新增记录的默认sort值
			$info['sort'] = $max_sort+2;
		}
		$this->assign("topnavi", $topnavi);
		$this->assign("info", $info);

		$this->assign('content',ACTION_NAME);
		$this->display('Layout:default');
	}
	public function delete_case() {
		$this->dao = M('Case');

		//delete attachment
		$id = $_REQUEST['id'];
		$rs = M('Attachment')->where(array('model_name'=>'Case', 'model_id'=>$id))->select();
		empty($rs) && ($rs = array());
		foreach ($rs as $row) {
			@unlink($row['path']);
			M('Attachment')->where('id='.$row['id'])->delete();
		}
		parent::_delete();
	}
}
?>