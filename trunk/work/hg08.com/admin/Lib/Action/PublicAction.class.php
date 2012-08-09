<?php
/**
*
* 公共操作类
* 无需RBAC认证
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class PublicAction extends BaseAction{
	/**
	*
	* 验证是否已登录，如果未登录，显示登录框
	*/
	public function login() {
		if(empty($_SESSION[C('USER_AUTH_KEY')])) {
			$this->assign('content', ACTION_NAME);
			$this->display();
		}
		else{
			redirect(__APP__);
		}
	}
	/**
	*
	* 验证并保存登录信息
	*/
	public function checkLogin(){
		$User	=	D('Admin');
		if(''==trim($_REQUEST['username'])) {
			die(self::_error('用户名必须!'));
		}
		elseif (''==trim($_REQUEST['password'])){
			die(self::_error('密码必须！'));
		}
		$where = array(
			'username' => trim($_POST['username']),
			'password' => md5(trim($_POST['password']))
			);
		// 进行委托认证
		$info = $User->where($where)->find();
		if(empty($info)) {
			self::_error('登录失败，请检查用户名和密码是否有误！');
		}
		else{
			if ($info['status'] < 1) {
				self::_error('此用户账号已被停用！');
			}
			$_SESSION[C('USER_AUTH_KEY')] = $info['id'];
			$_SESSION[C('IS_ADMINISTRATOR')] = (1==$info['id']?true:false);
			$_SESSION['admin_name'] = empty($info['realname'])?$info['username']:$info['realname'];
			
			//保存访问权限
			RBAC::saveAccessList($info['id']);
			$User->where("id=".$info['id'])->setField('login_time', date('Y-m-d H:i:s'));
			self::_success('登陆成功！', __APP__, 500);
		}
	}
	/**
	*
	* 注销处理
	*/
	public function logout(){
		Session::clear();
		self::_success('注销成功！', __APP__, 500);
	}
	
	Public function upload() {
		import("ORG.Net.UploadFile");
		$upload = new UploadFile(); // 实例化上传类
		$upload->maxSize  = 1024*1024*min(ini_get('memory_limit'), ini_get('post_max_size'), ini_get('upload_max_filesize')); // 设置附件上传大小

		$ext_arr = array(
			'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
			'flash' => array('swf', 'flv'),
			'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
			'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
		);
		$upload_type = trim($_REQUEST['dir']);
		$upload->allowExts  = $ext_arr[$upload_type]; // 设置附件上传类型
		$upload->savePath =  'html/Attach/'.$upload_type.'/'; // 设置附件上传目录
		if (!is_dir($upload->savePath)) {
			@mkdir($upload->savePath);
		}
		$arr = array();
		if(!$upload->upload()) { // 上传错误提示错误信息
			$arr['error' ] = 1;
			$arr['message'] = $upload->getErrorMsg();
		}
		else{ // 上传成功 获取上传文件信息
			$info =  $upload->getUploadFileInfo();
			$arr['error'] = 0;
			$arr['url'] = __APP__.'/../'.$info[0]['savepath'].$info[0]['savename'];
		}
		die(json_encode($arr));
	}

	public function file_manager() {
		//目录名
		$dir_name = empty($_GET['dir']) ? '' : trim($_GET['dir']);
		if (!in_array($dir_name, array('', 'image', 'flash', 'media', 'file'))) {
			echo "Invalid Directory name.";
			exit;
		}
		//图片扩展名
		$ext_arr = array('gif', 'jpg', 'jpeg', 'png', 'bmp');

		//根目录路径，可以指定绝对路径，比如 /var/www/attached/
		$root_path = __APP__ . '/../html/Attach/';
		//根目录URL，可以指定绝对路径，比如 http://www.yoursite.com/attached/
		$root_url = $root_path;

		
		if ($dir_name !== '') {
			$root_path .= $dir_name . "/";
			$root_url .= $dir_name . "/";
			if (!file_exists($root_path)) {
				@mkdir($root_path);
			}
		}

		//根据path参数，设置各路径和URL
		if (empty($_GET['path'])) {
			$current_path = realpath($root_path) . '/';
			$current_url = $root_url;
			$current_dir_path = '';
			$moveup_dir_path = '';
		} else {
			$current_path = realpath($root_path) . '/' . $_GET['path'];
			$current_url = $root_url . $_GET['path'];
			$current_dir_path = $_GET['path'];
			$moveup_dir_path = preg_replace('/(.*?)[^\/]+\/$/', '$1', $current_dir_path);
		}
		
		//排序形式，name or size or type
		$order = empty($_GET['order']) ? 'name' : strtolower($_GET['order']);

		//不允许使用..移动到上一级目录
		if (preg_match('/\.\./', $current_path) || '/'==$current_path) {
			echo 'Access is not allowed.';
			exit;
		}
		//最后一个字符不是/
		if (!preg_match('/\/$/', $current_path)) {
			echo 'Parameter is not valid.';
			exit;
		}
		//目录不存在或不是目录
		if (!file_exists($current_path) || !is_dir($current_path)) {
			echo 'Directory does not exist.';
			exit;
		}

		//遍历目录取得文件信息
		$file_list = array();
		
		if ($handle = opendir($current_path)) {
			$i = 0;
			while (false !== ($filename = readdir($handle))) {
				if ($filename{0} == '.') continue;
				$file = $current_path . $filename;
				if (is_dir($file)) {
					$file_list[$i]['is_dir'] = true; //是否文件夹
					$file_list[$i]['has_file'] = (count(scandir($file)) > 2); //文件夹是否包含文件
					$file_list[$i]['filesize'] = 0; //文件大小
					$file_list[$i]['is_photo'] = false; //是否图片
					$file_list[$i]['filetype'] = ''; //文件类别，用扩展名判断
				} else {
					$file_list[$i]['is_dir'] = false;
					$file_list[$i]['has_file'] = false;
					$file_list[$i]['filesize'] = filesize($file);
					$file_list[$i]['dir_path'] = '';
					$file_ext = strtolower(array_pop(explode('.', trim($file))));
					$file_list[$i]['is_photo'] = in_array($file_ext, $ext_arr);
					$file_list[$i]['filetype'] = $file_ext;
				}
				$file_list[$i]['filename'] = $filename; //文件名，包含扩展名
				$file_list[$i]['datetime'] = date('Y-m-d H:i:s', filemtime($file)); //文件最后修改时间
				$i++;
			}
			closedir($handle);
		}
		usort($file_list, 'cmp_func');

		$result = array();
		//相对于根目录的上一级目录
		$result['moveup_dir_path'] = $moveup_dir_path;
		//相对于根目录的当前目录
		$result['current_dir_path'] = $current_dir_path;
		//当前目录的URL
		$result['current_url'] = $current_url;
		//文件数
		$result['total_count'] = count($file_list);
		//文件列表数组
		$result['file_list'] = $file_list;

		//输出JSON字符串
		header('Content-type: application/json; charset=UTF-8');
		die(json_encode($result));
	}
}
?>