<?php
class ShareAction extends BaseAction{

	protected $dao, $config, $status_arr;

	public function _initialize() {
		if ('Node'!= MODULE_NAME) {
			Session::set('top', 'Experience');
		}
		$this->dao = D('Share');
		parent::_initialize();
		$this->assign('MODULE_TITLE', 'Experience Share');
	}

	Public function all() {
		$this->assign('MODULE_TITLE', 'All Experience');
		$this->index('all');
	}

	public function index($type='') {
		$this->assign('ACTION_TITLE', 'Experience List');
		Session::set('sub', MODULE_NAME.(''==$type?'':'/'.$type));
		$where = array();
		if (!empty($_REQUEST['keyword']) && ''!=trim($_REQUEST['keyword'])) {
			$keyword = trim($_REQUEST['keyword']);
			$keyword_arr = explode(' ', $keyword);
			foreach ($keyword_arr as $key) {
				$title_arr[] = "title like '%".$key."%'";
				$keywords_arr[] = "keywords like '%".$key."%'";
				$content_arr[] = "content like '%".$key."%'";
			}
			$where['_string'] = implode(' and ', $title_arr).' or '.implode(' and ', $keywords_arr).' or '.implode(' and ', $content_arr);
		}
		if (''==$type) {
			//my share
			$where['_string'] = "staff_id=".$_SESSION[C('USER_AUTH_KEY')];
		}
		else {
			if (!empty($_SESSION[C('ADMIN_AUTH_NAME')])) {
			//	$where['status'] = 1;
			}
			if (!empty($_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_category_id'])) {
				$category_id = $_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_category_id'];
			}
			if (isset($_REQUEST['category_id'])) {
				$category_id = intval($_REQUEST['category_id']);
			}
			$_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_category_id'] = $category_id;
			$this->assign('category_opts', self::genOptions(M('Category')->where(array('type'=>'ShareCategory'))->select(), $category_id));
			if (!empty($category_id)) {
				$where['category_id'] = $category_id;
			}

			if (!empty($_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_project_id'])) {
				$project_id = $_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_project_id'];
			}
			if (isset($_REQUEST['project_id'])) {
				$project_id = intval($_REQUEST['project_id']);
			}
			$_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_project_id'] = $project_id;
			$this->assign('project_opts', self::genOptions(M('Category')->where(array('type'=>'ShareProject'))->select(), $project_id));
			if (!empty($project_id)) {
				$where['project_id'] = $project_id;
			}

			if (!empty($_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_staff_id'])) {
				$staff_id = $_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_staff_id'];
			}
			if (isset($_REQUEST['staff_id'])) {
				$staff_id = intval($_REQUEST['staff_id']);
			}
			$_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_staff_id'] = $staff_id;
			$staff_arr = $this->dao->join("Inner Join erp_staff on erp_staff.id=erp_share.staff_id")->distinct(true)->field("erp_staff.id as id, erp_staff.realname as realname")->order("realname")->select();
			$this->assign('staff_opts', self::genOptions($staff_arr, $staff_id, 'realname'));
			if (!empty($staff_id)) {
				$where['staff_id'] = $staff_id;
			}

			if (!empty($_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_dept_id'])) {
				$dept_id = $_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_dept_id'];
			}
			if (isset($_REQUEST['dept_id'])) {
				$dept_id = intval($_REQUEST['dept_id']);
			}
			$_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_dept_id'] = $dept_id;
			$dept_arr = $this->dao->join("Inner Join erp_department on erp_department.id=erp_share.dept_id")->distinct(true)->field("erp_department.id as id, erp_department.name as name")->order("name")->select();
			$this->assign('dept_opts', self::genOptions($dept_arr, $dept_id));
			if (!empty($dept_id)) {
				$where['dept_id'] = $dept_id;
			}
		}

		import("@.Paginator");
		$limit = 20;
		if (!empty($_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_limit'])) {
			$limit = $_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_limit'];
		}
		if (!empty($_REQUEST['limit'])) {
			$limit = $_REQUEST['limit'];
		}
		$_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_limit'] = $limit;

		$total = $this->dao->where($where)->count();
		$p = new Paginator($total,$limit);

		$rs = $this->dao->relation(true)->where($where)->order('status desc, id desc')->limit($p->offset.','.$p->limit)->select();
		empty($rs) && ($rs = array());
		$result = array();
		$project_arr = array();
		foreach ($rs as $i=>$item) {
			if (empty($result[$item['project_id']])) {
				$result[$item['project_id']] = array();
				$project_arr[$item['project_id']] = $item['project']['name'];
			}
			$item['create_date'] = $this->kindlyTime($item['create_time']);
			$item['comment_count'] = M('Comment')->where(array('model_name'=>MODULE_NAME, 'model_id'=>$item['id'], 'status'=>1))->count();
			if ($item['comment_count']>0) {
				$tmp = M('Comment')->where(array('model_name'=>MODULE_NAME, 'model_id'=>$item['id'], 'status'=>1))->order('id desc')->find();
				$item['comment_staff'] = M('Staff')->where("id=".$tmp['staff_id'])->getField('realname');
				$item['comment_date'] = $this->kindlyTime($tmp['create_time']);
			}
			if (!empty($keyword_arr)) {
				foreach ($keyword_arr as $key) {
					$item['title'] = eregi_replace('('.$key.')', '<em>\\1</em>', $item['title']);
				}
			}
			$result[$item['project_id']][] = $item;
		}
		array_multisort($project_arr, SORT_ASC, SORT_REGULAR, $result);
		$this->assign('result', $result);
		$this->assign('project_arr', $project_arr);

		$this->assign('page', $p->showMultiNavi());

		$this->assign('request', $_REQUEST);
		$this->assign('type', $type);
		$this->assign('content', 'index');
		$this->display('Layout:ERP_layout');
	}
	private function kindlyTime($time) {
		$date = substr($time, 0, 10);
		switch ($date) {
			case date('Y-m-d') :
				return '今天 '.substr($time, 11, 5);
				break;
			
			case date('Y-m-d', time()-86400) :
				return '昨天 '.substr($time, 11, 5);
				break;

			default :
				return $date;
		}
	}
	
	public function view() {
		$id = intval($_REQUEST['id']);
		$info = $this->dao->relation(true)->find($id);
		$this->dao->setInc('hit', "id=".$id);
		$this->assign('ACTION_TITLE', $info['title']);

		$info['comment'] = D('Comment')->relation(true)->where(array('model_name'=>MODULE_NAME, 'model_id'=>$id, 'status'=>1))->order('id')->select();
		$info['attachment'] = M('Attachment')->where(array('model_name'=>MODULE_NAME, 'model_id'=>$id, 'status'=>1))->select();

		$this->assign('info', $info);
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:ERP_layout');
	}
	public function form() {
		$default_content = '<h2 class="sub">背景介绍&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·</h2><p>在此输入内容...<br /><br /></p>';
		$default_content .= '<h2 class="sub">现象描述&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·</h2><p>在此输入内容...<br /><br /></p>';
		$default_content .= '<h2 class="sub">原因分析&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·</h2><p>在此输入内容...<br /><br /></p>';
		$default_content .= '<h2 class="sub">解决方法&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·</h2><p>在此输入内容...<br /><br /></p>';
		$default_content .= '<h2 class="sub">总结心得&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·&nbsp;·</h2><p>在此输入内容...<br /><br /></p>';
		$this->assign('ACTION_TITLE', 'Share my Experience');
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		if ($id>0) {
			$info = $this->dao->find($id);
			$this->assign('ACTION_TITLE', 'Edit my Experience');
			$info['project_opts'] = self::genOptions(M('Category')->where(array('type'=>'ShareProject'))->select(), $info['project_id'], 'name');
			$info['category_opts'] = self::genOptions(M('Category')->where(array('type'=>'ShareCategory'))->select(), $info['category_id'], 'name');
			if (''==trim($info['content'])) {
				$info['content'] = $default_content;
			}
			$info['attachment'] = M('Attachment')->where(array('model_name'=>MODULE_NAME, 'model_id'=>$id, 'status'=>1))->select();
		}
		else {
			$info = array(
				'id' => 0,
				'title' => '',
				'keywords' => '',
				'content' => $default_content,
				'project_opts' => self::genOptions(M('Category')->where(array('type'=>'ShareProject'))->select()),
				'category_opts' => self::genOptions(M('Category')->where(array('type'=>'ShareCategory'))->select()),
				'notification' => '000',
				'entry' => $this->config['entry_field']
				);
			
		}
		$this->assign('info', $info);
		$this->assign('MAX_FILE_SIZE', self::MAX_FILE_SIZE());
		$this->assign('upload_max_filesize', min(ini_get('memory_limit'), ini_get('post_max_size'), ini_get('upload_max_filesize')));

		$this->assign('content', ACTION_NAME);
		$this->display('Layout:ERP_layout');
	}

	public function submit(){
		if (empty($_POST['submit'])) {
			return;
		}
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		empty($_REQUEST['project_id']) && self::_error('Project must be specified!');
		empty($_REQUEST['category_id']) && self::_error('Category must be specified!');
		$title = trim($_REQUEST['title']);
		empty($title) && self::_error('Please type your title first!');
		if ($id>0) {
			$this->dao->find($id);
			if (intval($this->dao->notification) == 0 && ($_REQUEST['chk0'] || $_REQUEST['chk1'] || $_REQUEST['chk2'])) {
				$this->dao->mail_status = 0;
			}
		}
		else {
			$this->dao->staff_id = $_SESSION[C('USER_AUTH_KEY')];
			$this->dao->dept_id = $_SESSION[C('STAFF_AUTH_NAME')]['dept_id'];
			$this->dao->create_time = date("Y-m-d H:i:s");
			$this->dao->status = 1;
		}
		$this->dao->project_id = intval($_REQUEST['project_id']);
		$this->dao->category_id = intval($_REQUEST['category_id']);
		$this->dao->notification = strval((empty($_REQUEST['chk0'])?'0':'1').(empty($_REQUEST['chk1'])?'0':'1').(empty($_REQUEST['chk2'])?'0':'1'));
		$this->dao->title = $title;
		$this->dao->keywords = trim($_REQUEST['keywords']);
		$this->dao->content = trim($_REQUEST['content']);
		$this->dao->modify_time = date("Y-m-d H:i:s");
		if ($id>0) {
			if(false !== $this->dao->save()){
				//process multi-file
				foreach ($_FILES['file']['size'] as $i=>$size) {
					if($size > 0) {
						$data = array(
							'name' => $_FILES['file']['name'][$i],
							'type' => $_FILES['file']['type'][$i],
							'size' => $size,
							'path' => 'Attach/'.MODULE_NAME.'/'.date("YmdHis").substr(microtime(),1,7).'.'.strtolower(pathinfo($_FILES['file']['name'][$i], PATHINFO_EXTENSION)),
							'model_name' => MODULE_NAME,
							'model_id' => $id,
							'staff_id' => $_SESSION[C('USER_AUTH_KEY')],
							'upload_time' => date('Y-m-d H:i:s'),
							'status' => 1
							);
						if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $data['path'])) {
							if (!M('Attachment')->add($data)) {
								self::_error('Insert fail!'.$this->dao->getLastSql());
							}
						}
						else {
							self::_error('Move '.$_FILES['file']['tmp_name'][$i].' to '.$data['path'].' fail!');
						}
					}
				}
				$this->mail_share($id);
				self::_success('Experience updated!',__URL__);
			}
			else{
				self::_error('Update fail!'.$this->dao->getLastSql());
			}
		}
		else{
			if($id = $this->dao->add()) {
				//process multi-file
				foreach ($_FILES['file']['size'] as $i=>$size) {
					if($size > 0) {
						$data = array(
							'name' => $_FILES['file']['name'][$i],
							'type' => $_FILES['file']['type'][$i],
							'size' => $size,
							'path' => 'Attach/'.MODULE_NAME.'/'.date("YmdHis").substr(microtime(),1,7).'.'.strtolower(pathinfo($_FILES['file']['name'][$i], PATHINFO_EXTENSION)),
							'model_name' => MODULE_NAME,
							'model_id' => $id,
							'staff_id' => $_SESSION[C('USER_AUTH_KEY')],
							'upload_time' => date('Y-m-d H:i:s'),
							'status' => 1
							);
						if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $data['path'])) {
							if (!M('Attachment')->add($data)) {
								self::_error('Insert fail!'.$this->dao->getLastSql());
							}
						}
						else {
							self::_error('Move '.$_FILES['file']['tmp_name'][$i].' to '.$data['path'].' fail!');
						}
					}
				}
				$this->mail_share($id);
				self::_success('Experience share success!',__URL__);
			}
			else {
				self::_error('Experience share fail!'.(C('APP_DEBUG')?$this->dao->getLastSql():''));
			}
		}
	}
	public function comment() {
		if (!empty($_GET['id'])) {
			die(M('Comment')->where('id='.$_GET['id'])->getField('content'));
		}
		if (empty($_POST['submit'])) {
			return;
		}
		$dao = D('Comment');
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		empty($_REQUEST['share_id']) && self::_error('No experience id specified!');
		$share_id = intval($_REQUEST['share_id']);
		$content = trim($_REQUEST['content']);
		!$content && self::_error('Comment can\'t be empty!');
		if ($id>0) {
			$dao->find($id);
			$attachment_html = "";
			$att_arr = M('Attachment')->where("model_name='Comment' and model_id=".$id." and status=1")->select();
			empty($att_arr) && ($att_arr = array());
			foreach ($att_arr as $att) {
				$attachment_html .= '<div id="attachment_'.$att['id'].'" class="new_attachment"><a title="View attachment in new window" target="_blank" href="'.__APP__.'/../'.$att['path'].'">'.$att['name'].'</a><img border="0" align="top" title="Click to delete this attachment" onclick="myConfirm(\'Are you sure to delete this attachment?\', \''.__URL__.'/delete_attachment/id/'.$att['id'].'\');" style="cursor:pointer;" alt="Delete" src="'.APP_PUBLIC_PATH.'/Images/cross.gif"></div>';
			}
		}
		else {
			$dao->model_name = MODULE_NAME;
			$dao->model_id = $share_id;
			$dao->staff_id = $_SESSION[C('USER_AUTH_KEY')];
			$dao->create_time = date('Y-m-d H:i:s');
			$dao->status = 1;
		}
		$dao->content = $content;
		if ($id>0) {
			if(false !== $dao->save()) {
				//process multi-file
				foreach ($_FILES['file']['size'] as $i=>$size) {
					if($size > 0) {
						$data = array(
							'name' => $_FILES['file']['name'][$i],
							'type' => $_FILES['file']['type'][$i],
							'size' => $size,
							'path' => 'Attach/Comment/'.date("YmdHis").substr(microtime(),1,7).'.'.strtolower(pathinfo($_FILES['file']['name'][$i], PATHINFO_EXTENSION)),
							'model_name' => 'Comment',
							'model_id' => $id,
							'staff_id' => $_SESSION[C('USER_AUTH_KEY')],
							'upload_time' => date('Y-m-d H:i:s'),
							'status' => 1
							);
						if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $data['path'])) {
							if (!$att_id = M('Attachment')->add($data)) {
								self::_error('Insert fail!'.$this->dao->getLastSql());
							}
						}
						else {
							self::_error('Move '.$_FILES['file']['tmp_name'][$i].' to '.$data['path'].' fail!');
						}
						$attachment_html .= '<div id="attachment_'.$att_id.'" class="new_attachment"><a title="View attachment in new window" target="_blank" href="'.__APP__.'/../'.$data['path'].'">'.$data['name'].'</a><img border="0" align="top" title="Click to delete this attachment" onclick="myConfirm(\'Are you sure to delete this attachment?\', \''.__URL__.'/delete_attachment/id/'.$att_id.'\');" style="cursor:pointer;" alt="Delete" src="'.APP_PUBLIC_PATH.'/Images/cross.gif"></div>';
					}
				}
				$html  = '<script language="JavaScript" type="text/javascript">';
				$html .= 'parent.myAlert("Update comment success!");';
				$html .= 'parent.myOK(500);';
				$html .= 'parent.show_comment('.$id.', "'.str_replace(array("\r\n", "\n"), '<br />', $content).'", "'.addslashes($attachment_html).'");';
				$html .= '</script>';
				die($html);
			}
			else{
				self::_error('Update comment fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
			}
		}
		else {
			if($id=$dao->add()) {
				$attachment_html = "";
				//process multi-file
				foreach ($_FILES['file']['size'] as $i=>$size) {
					if($size > 0) {
						$data = array(
							'name' => $_FILES['file']['name'][$i],
							'type' => $_FILES['file']['type'][$i],
							'size' => $size,
							'path' => 'Attach/Comment/'.date("YmdHis").substr(microtime(),1,7).'.'.strtolower(pathinfo($_FILES['file']['name'][$i], PATHINFO_EXTENSION)),
							'model_name' => 'Comment',
							'model_id' => $id,
							'staff_id' => $_SESSION[C('USER_AUTH_KEY')],
							'upload_time' => date('Y-m-d H:i:s'),
							'status' => 1
							);
						if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $data['path'])) {
							if (!$att_id = M('Attachment')->add($data)) {
								self::_error('Insert fail!'.$this->dao->getLastSql());
							}
						}
						else {
							self::_error('Move '.$_FILES['file']['tmp_name'][$i].' to '.$data['path'].' fail!');
						}
						$attachment_html .= '<div id="attachment_'.$att_id.'" class="new_attachment"><a title="View attachment in new window" target="_blank" href="'.__APP__.'/../'.$data['path'].'">'.$data['name'].'</a><img border="0" align="top" title="Click to delete this attachment" onclick="myConfirm(\'Are you sure to delete this attachment?\', \''.__URL__.'/delete_attachment/id/'.$att_id.'\');" style="cursor:pointer;" alt="Delete" src="'.APP_PUBLIC_PATH.'/Images/cross.gif"></div>';
					}
				}
				$html  = '<script language="JavaScript" type="text/javascript">';
				$html .= 'parent.myAlert("Post comment success!");';
				$html .= 'parent.myOK(500);';
				$html .= 'parent.show_comment('.$id.', "'.str_replace(array("\r\n", "\n"), '<br />', $content).'", "'.addslashes($attachment_html).'");';
				$html .= '</script>';
				die($html);
			}
			else{
				self::_error('Post comment fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
			}
		}
	}
	public function project() {
		$this->assign('MODULE_TITLE', 'Experience Project');
		$this->category('ShareProject');
	}
	public function category($type = 'ShareCategory'){
		Session::set('sub', MODULE_NAME.'/'.ACTION_NAME);
		$dao = M('Category');
		if (!empty($_POST['submit'])) {
			$name = trim($_REQUEST['name']);
			!$name && self::_error(ucfirst(ACTION_NAME).' Name required');
			$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
			if ($id>0) {
				$rs = $dao->where(array('type'=>$type,'name'=>$name,'id'=>array('neq',$id)))->find();
				if($rs && sizeof($rs)>0){
					self::_error(ucfirst(ACTION_NAME).' Name: \''.$name.'\' already exists!');
				}
				$dao->find($id);
			}
			else {
				$rs = $dao->where(array('type'=>$type,'name'=>$name))->find();
				if($rs && sizeof($rs)>0){
					self::_error(ucfirst(ACTION_NAME).' Name: \''.$name.'\' already exists!');
				}
			}
			$dao->type = $type;
			$dao->code = '';
			$dao->name = $name;
			if ($id>0) {
				if(false !== $dao->save()){
					self::_success(ucfirst(ACTION_NAME).' information updated!');
				}
				else{
					self::_error('Update fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
				}
			}
			else {
				if($dao->add()) {
					self::_success('Add '.ACTION_NAME.' success!');
				}
				else{
					self::_error('Add '.ACTION_NAME.' fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
				}
			}
		}
		elseif (!empty($_REQUEST['id'])) {
			$id = $_REQUEST['id'];
			$rs = $this->dao->where(array(ACTION_NAME.'_id'=>$id))->select();
			if(!empty($rs) && sizeof($rs)>0) {
				self::_error('It\'s in use, can\'t be deleted!');
			}
			else{
				$this->dao = M('Category');
				self::_delete();
			}
		}
		if ('category' == ACTION_NAME) {
			$this->assign('ACTION_TITLE', 'Experience Category');
		}
		elseif ('project' == ACTION_NAME) {
			$this->assign('ACTION_TITLE', 'Experience Project');
		}
		$result = $dao->where(array('type'=>$type))->order('name')->select();

		$this->assign('result', $result);
		$this->assign('content', 'category');
		$this->display('Layout:ERP_layout');
	}

	public function delete() {
		$id = $_REQUEST['id'];

		//delete comment
		M('Comment')->where(array('model_name'=>MODULE_NAME, 'model_id'=>$id))->delete();

		//delete attachment
		$rs = (array)M('Attachment')->where(array('model_name'=>MODULE_NAME, 'model_id'=>$id))->select();
		foreach ($rs as $row) {
			@unlink($row['path']);
			M('Attachment')->where('id='.$row['id'])->delete();
		}
		self::_delete();
	}
	public function delete_comment() {
		$id = intval($_REQUEST['id']);
		$dao = D('Comment');
		$info = $dao->relation(true)->find($id);
		if($id>0 && $dao->where("id=".$id)->delete()) {
			foreach ($info['attachment'] as $att) {
				$path = M('Attachment')->where('id='.$att['id'])->getField('path');
				@unlink($path);
				M('Attachment')->where("id=".$att['id'])->delete();
			}
			$html  = '<script language="JavaScript" type="text/javascript">';
			$html .= 'parent.myAlert("Delete comment success!");';
			$html .= 'parent.myOK(500);';
			$html .= 'parent.remove_comment('.$id.');';
			$html .= '</script>';
			die($html);
		}
		else {
			self::_error('Delete comment fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
		}
	}
	public function delete_attachment() {
		$id = $_REQUEST['id'];
		$dao = M('Attachment');
		$path = $dao->where('id='.$id)->getField('path');
		@unlink($path);
		if ($dao->where("id=".$id)->delete()) {
			$html  = '<script language="JavaScript" type="text/javascript">';
			$html .= 'parent.myAlert("Delete success!");';
			$html .= 'parent.myOK(500);';
			$html .= 'parent.remove_attachment('.$id.');';
			$html .= '</script>';
			die($html);
		}
		else {
			self::_error('Delete attachment fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
		}
	}
	public function mail_share($id=0) {
		if (!defined('APP_ROOT')) {
			define('APP_ROOT', 'http://'.$_SERVER['SERVER_ADDR'].__APP__);
		}
		empty($id) && ($id = intval($_REQUEST['id']));
		if (empty($id)) {
			echo "No ID specified\n";
			return;
		}
		$info = $this->dao->relation(true)->find($id);

		if ($info['notification'][0]=='1' || $info['notification'][1]=='1' || $info['notification'][2]=='1') {
			$smtp_config = C('_smtp_');
			include_once (LIB_PATH.'class.phpmailer.php');
			$mail = new PHPMailer();
			$mail->IsSMTP();
		//	$mail->SMTPDebug  = 1;  // 2 = messages only
			$mail->Host       = $smtp_config['host'];
			$mail->Port       = $smtp_config['port'];
			$mail->SetFrom($smtp_config['from_mail'], 'ERP Experience');

			$mail->AddAddress($info['staff']['email'], $info['staff']['realname']);
			$subject = '[Notification] ['.$info['staff']['realname'].'] share ['.$info['title'].'] to you';
			
			$body = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body>'."\n";
			$body .= 'Hi all, <br />'."\n";
			$body .= '&nbsp;&nbsp;&nbsp;&nbsp;Please click on the <span style="color:#548dd4;">Enter</span> link to view it, it will guide you to the ERP system in your default browser. Use your ERP/AgigAFlow username and password if it\'s needed. <br />'."\n";
			$body .= '<a href="'.APP_ROOT.'/Share/view/id/'.$id.'" target="_blank"><u style="font-weight:bold; color: #548dd4; font-size: 18pt">Enter</u></a>'."\n";
			$body .= '<br /><br />Best Regards,<br />'.C('ERP_TITLE')."\n";
			$body .= '</body></html>'."\n";

			
			if ($info['notification'][2] == '1') {
				$tmp_rs = M('Staff')->where("status=1")->select();
				empty($tmp_rs) && ($tmp_rs = array());
				foreach ($tmp_rs as $row) {
					$mail->AddCC($row['email'], $row['realname']);
				}
			}
			else {
				if ($info['notification'][1] == '1') {
					$tmp_rs = M('Staff')->where("status=1 and is_leader=1")->select();
					empty($tmp_rs) && ($tmp_rs = array());
					foreach ($tmp_rs as $row) {
						$mail->AddCC($row['email'], $row['realname']);
					}
				}
				if ($info['notification'][0] == '1') {
					$tmp_rs = M('Staff')->where("status=1 and dept_id=".$info['staff']['dept_id'])->select();
					empty($tmp_rs) && ($tmp_rs = array());
					foreach ($tmp_rs as $row) {
						$mail->AddCC($row['email'], $row['realname']);
					}
				}
			}
			
			$mail->Subject = $subject;
			$mail->MsgHTML($body);
			if(!$mail->Send()) {
				Log::Write('Mail Experience(ID: '.$id.') Error: '.$mail->ErrorInfo, LOG::ERR);
				return false;
			}
			echo "Mail Experience(ID: ".$id.") Success!\n";
			Log::Write('Mail Experience(ID: '.$id.') Success!', LOG::INFO);
		}
		//update mail_status
		$this->dao->setField('mail_status', 1);
		echo "Update mail_status done!\n";
		return true;
	}
}
?>