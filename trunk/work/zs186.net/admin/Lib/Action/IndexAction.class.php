<?php
/**
*
* 管理首页
*
* @author zerofault <zerofault@gmail.com>
* @since 2009/8/5
*/
class IndexAction extends BaseAction{

	public function _initialize() {
		parent::_initialize();
	}

	public function index(){
		$topnavi[]=array(
			"text"=>"欢迎"
			);
		$this->assign("topnavi",$topnavi);

		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}
	public function setting() {
		if (!empty($_POST['submit'])) {
			$data = array(
				'qq_service1' => trim($_REQUEST['qq_service1']),
				'qq_service2' => trim($_REQUEST['qq_service2']),
				'phone_service' => trim($_REQUEST['phone_service']),
				'qq_designer' => trim($_REQUEST['qq_designer']),
				'qq_company' => trim($_REQUEST['qq_company']),
				'qq_cooperation' => trim($_REQUEST['qq_cooperation']),
				'point' => intval($_REQUEST['point']),
				'keywords' => str_replace(array("\r\n", "\n"), ' ', trim($_REQUEST['keywords'])),
				'description' => str_replace(array("\r\n", "\n"), ' ', trim($_REQUEST['description']))
				);

			if(F(MODULE_NAME.'-'.ACTION_NAME, $data, APP_PATH.'/../Runtime/Data/')) {
				self::_success('提交成功！', __URL__.'/'.ACTION_NAME);
			}
			else {
				self::_error('保存数据出错！');
			}
		}
		$topnavi[]=array(
			'text'=> '网站参数设置',
			);
		$this->assign("topnavi", $topnavi);

		$data = F(MODULE_NAME.'-'.ACTION_NAME, '', APP_PATH.'/../Runtime/Data/');
		if (empty($data)) {
			$data = array(
				'qq_service1' => '1518985666',
				'qq_service2' => '1006770691',
				'phone_service' => '18727279944',
				'qq_designer' => '1518985666',
				'qq_company' => '1518985666',
				'qq_cooperation' => '272468213',
				'point' => '20',
				'keywords' => '宜昌装修公司排名 装修报价 宜昌乐装网 装修网 装饰网 建材网 家装公司 家装网 宜昌装潢 宜昌房子装修 宜昌二手房装修',
				'description' => '乐装网的网站描述，通过搜索引擎抓取后方便用户了解'
				);
		}
		$this->assign('data', $data);
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}

	public function marquee() {
		if (!empty($_POST['submit'])) {
			$data = array();
			foreach ($_REQUEST['title'] as $i=>$title) {
				$data[] = array(
					'title' => $title,
					'url' => $_REQUEST['url'][$i]
					);
			}
			if(F(MODULE_NAME.'-'.ACTION_NAME, $data, APP_PATH.'/../Runtime/Data/')) {
				self::_success('提交成功！', __URL__.'/'.ACTION_NAME);
			}
			else {
				self::_error('保存数据出错！');
			}
		}
		$topnavi[]=array(
			'text'=> '网站滚动状态管理',
			);
		$this->assign("topnavi",$topnavi);

		$data = F(MODULE_NAME.'-'.ACTION_NAME, '', APP_PATH.'/../Runtime/Data/');
		if (empty($data)) {
			$data = array(
				array(
					'title' => '上乐装网机会多多 优惠多多 即可获得精美礼品一份',
					'url' => 'http://www.lzwyc.com/'
					)
				);
		}
		$this->assign('list', $data);
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}
	public function focus() {
		if (!empty($_POST['submit'])) {
			$data = array();
			foreach ($_REQUEST['img0'] as $i=>$img0) {
				if($_FILES['img']['size'][$i] > 0) {
					$path = 'html/Attach/index/'.date("YmdHis").substr(microtime(),1,7).'.'.strtolower(pathinfo($_FILES['img']['name'][$i], PATHINFO_EXTENSION));
					if (!move_uploaded_file($_FILES['img']['tmp_name'][$i], $path)) {
						self::_error('上传图片出错！');
					}
				}
				else {
					$path = $img0;
				}
				$data[] = array(
					'img' => $path,
					'url' => $_REQUEST['url'][$i]
					);
			}
			if(F(MODULE_NAME.'-'.ACTION_NAME, $data, APP_PATH.'/../Runtime/Data/')) {
				self::_success('提交成功！', __URL__.'/'.ACTION_NAME);
			}
			else {
				self::_error('保存数据出错！');
			}
			exit;
		}
		$topnavi[]=array(
			'text'=> '焦点图',
			);
		$this->assign("topnavi",$topnavi);

		$data = F(MODULE_NAME.'-'.ACTION_NAME, '', APP_PATH.'/../Runtime/Data/');
		if (empty($data)) {
			$data = array(
				array(
					'img' => 'Tpl/default/Public/Images/3.jpg',
					'url' => '#'
					),
				array(
					'img' => 'Tpl/default/Public/Images/4.jpg',
					'url' => '#'
					),
				array(
					'img' => 'Tpl/default/Public/Images/5.jpg',
					'url' => '#'
					),
				array(
					'img' => 'Tpl/default/Public/Images/6.jpg',
					'url' => '#'
					)
				);
		}
		$this->assign('list', $data);
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}

	public function case_list() {
		if (!empty($_POST['submit'])) {
			$data = array();
			foreach ($_REQUEST['company'] as $i=>$company) {
				if($_FILES['img']['size'][$i] > 0) {
					$path = 'html/Attach/index/'.date("YmdHis").substr(microtime(),1,7).'.'.strtolower(pathinfo($_FILES['img']['name'][$i], PATHINFO_EXTENSION));
					if (!move_uploaded_file($_FILES['img']['tmp_name'][$i], $path)) {
						self::_error('上传图片出错！');
					}
				}
				else {
					$path = $_REQUEST['img0'][$i];
				}
				$data[] = array(
					'img' => $path,
					'time' => trim($_REQUEST['time'][$i]),
					'company' => trim($_REQUEST['company'][$i]),
					'project' => trim($_REQUEST['project'][$i]),
					'price' => trim($_REQUEST['price'][$i]),
					'url' => trim($_REQUEST['url'][$i])
					);
			}
			if(F(MODULE_NAME.'-'.ACTION_NAME, $data, APP_PATH.'/../Runtime/Data/')) {
				self::_success('提交成功！', __URL__.'/'.ACTION_NAME);
			}
			else {
				self::_error('保存数据出错！');
			}
		}
		$topnavi[]=array(
			'text'=> '装修案例',
			);
		$this->assign("topnavi",$topnavi);

		$data = F(MODULE_NAME.'-'.ACTION_NAME, '', APP_PATH.'/../Runtime/Data/');
		if (empty($data)) {
			$data = array(
				array(
					'img' => 'Tpl/default/Public/Images/test_pic1.jpg',
					'time' => '17:47',
					'company' => '宜昌水木庭装饰有限公司',
					'project' => '宜昌藏龙星天地3室2厅2卫130M2',
					'price' => '￥80,000'
					),
				array(
					'img' => 'Tpl/default/Public/Images/test_pic1.jpg',
					'time' => '16:53',
					'company' => '鑫大众装饰设计工程有限公司',
					'project' => '宜昌新荣苑3室2厅2卫114M2',
					'price' => '￥30,000'
					),
				array(
					'img' => 'Tpl/default/Public/Images/test_pic1.jpg',
					'time' => '17:47',
					'company' => '宜昌水木庭装饰有限公司',
					'project' => '宜昌藏龙星天地3室2厅2卫130M2',
					'price' => '￥80,000'
					),
				array(
					'img' => 'Tpl/default/Public/Images/test_pic1.jpg',
					'time' => '16:53',
					'company' => '鑫大众装饰设计工程有限公司',
					'project' => '宜昌新荣苑3室2厅2卫114M2',
					'price' => '￥30,000'
					)
				);
		}
		$this->assign('list', $data);
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}

	public function company() {
		if (!empty($_POST['submit'])) {
			$data = array();
			foreach ($_REQUEST['img0'] as $i=>$img0) {
				if($_FILES['img']['size'][$i] > 0) {
					$path = 'html/Attach/index/'.date("YmdHis").substr(microtime(),1,7).'.'.strtolower(pathinfo($_FILES['img']['name'][$i], PATHINFO_EXTENSION));
					if (!move_uploaded_file($_FILES['img']['tmp_name'][$i], $path)) {
						self::_error('上传图片出错！');
					}
				}
				else {
					$path = $img0;
				}
				$data[] = array(
					'img' => $path,
					'name' => trim($_REQUEST['name'][$i]),
					'url' => trim($_REQUEST['url'][$i])
					);
			}
			if(F(MODULE_NAME.'-'.ACTION_NAME, $data, APP_PATH.'/../Runtime/Data/')) {
				self::_success('提交成功！', __URL__.'/'.ACTION_NAME);
			}
			else {
				self::_error('保存数据出错！');
			}
		}
		$topnavi[]=array(
			'text'=> '装饰公司',
			);
		$this->assign("topnavi", $topnavi);

		$data = F(MODULE_NAME.'-'.ACTION_NAME, '', APP_PATH.'/../Runtime/Data/');
		if (empty($data)) {
			$data = array_fill(0, 12,
				array(
					'img' => 'Tpl/default/Public/Images/test_pic2.png',
					'name' => '迪威装饰',
					'url' => '#',
					)
				);
		}
		$this->assign('list', $data);
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}

	public function statistic() {
		if (!empty($_POST['submit'])) {
			$data = array(
				'total' => intval($_REQUEST['total']),
				'user_count' => intval($_REQUEST['user_count']),
				'company_count' => intval($_REQUEST['company_count']),
				'invite_count' => intval($_REQUEST['invite_count'])
				);

			if(F(MODULE_NAME.'-'.ACTION_NAME, $data, APP_PATH.'/../Runtime/Data/')) {
				self::_success('提交成功！', __URL__.'/'.ACTION_NAME);
			}
			else {
				self::_error('保存数据出错！');
			}
		}
		$topnavi[]=array(
			'text'=> '最新招标数据',
			);
		$this->assign("topnavi", $topnavi);

		$data = F(MODULE_NAME.'-'.ACTION_NAME, '', APP_PATH.'/../Runtime/Data/');
		if (empty($data)) {
			$data = array(
				'total' => 275052,
				'user_count' => 76231,
				'company_count' => 18373,
				'invite_count' => 41943
				);
		}
		$this->assign('data', $data);
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}

	public function knowledge() {
		if (!empty($_POST['submit'])) {
			$data = array();
			foreach ($_REQUEST['img0'] as $i=>$img0) {
				if($_FILES['img']['size'][$i] > 0) {
					$path = 'html/Attach/index/'.date("YmdHis").substr(microtime(),1,7).'.'.strtolower(pathinfo($_FILES['img']['name'][$i], PATHINFO_EXTENSION));
					if (!move_uploaded_file($_FILES['img']['tmp_name'][$i], $path)) {
						self::_error('上传图片出错！');
					}
				}
				else {
					$path = $img0;
				}
				$data[] = array(
					'img' => $path,
					'url' => trim($_REQUEST['url'][$i])
					);
			}
			if(F(MODULE_NAME.'-'.ACTION_NAME, $data, APP_PATH.'/../Runtime/Data/')) {
				self::_success('提交成功！', __URL__.'/'.ACTION_NAME);
			}
			else {
				self::_error('保存数据出错！');
			}
		}
		$topnavi[]=array(
			'text'=> '装修常识配图',
			);
		$this->assign("topnavi", $topnavi);

		$data = F(MODULE_NAME.'-'.ACTION_NAME, '', APP_PATH.'/../Runtime/Data/');
		if (empty($data)) {
			$data = array(
				array(
					'img' => 'Tpl/default/Public/Images/test_pic4.gif',
					'url' => '#',
					),
				array(
					'img' => 'Tpl/default/Public/Images/test_pic4.gif',
					'url' => '#',
					)
				);
		}
		$this->assign('list', $data);
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}
	public function tips() {
		if (!empty($_POST['submit'])) {
			$data = array();
			foreach ($_REQUEST['title'] as $n=>$arr) {
				$data[$n] = array();
				foreach ($arr as $i=>$title) {
					$data[$n][] = array(
						'title' => trim($title),
						'url' => trim($_REQUEST['url'][$n][$i])
						);
				}
			}
			if(F(MODULE_NAME.'-'.ACTION_NAME, $data, APP_PATH.'/../Runtime/Data/')) {
				self::_success('提交成功！', __URL__.'/'.ACTION_NAME);
			}
			else {
				self::_error('保存数据出错！');
			}
		}
		$topnavi[]=array(
			'text'=> '装修名词',
			);
		$this->assign("topnavi", $topnavi);

		$data = F(MODULE_NAME.'-'.ACTION_NAME, '', APP_PATH.'/../Runtime/Data/');
		if (empty($data)) {
			$data = array(
				'tip1' => array(
					array(
						'title' => '基础装修',
						'url' => '#'
						),
					array(
						'title' => '硬装',
						'url' => '#'
						),
					array(
						'title' => '隐蔽',
						'url' => '#'
						),
					array(
						'title' => '清包',
						'url' => '#'
						),
					array(
						'title' => '半包',
						'url' => '#'
						)
					),
				'tip2' => array(
					array(
						'title' => '装修合同',
						'url' => '#'
						),
					array(
						'title' => '清包合同',
						'url' => '#'
						),
					array(
						'title' => '施工合同',
						'url' => '#'
						),
					array(
						'title' => '相关法规',
						'url' => '#'
						)
					),
				'tip3' => array(
					array(
						'title' => '地面工程',
						'url' => '#'
						),
					array(
						'title' => '电气',
						'url' => '#'
						),
					array(
						'title' => '管道',
						'url' => '#'
						),
					array(
						'title' => '吊顶',
						'url' => '#'
						)
					)
				);
		}
		$this->assign('data', $data);
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}
	public function brand() {
		if (!empty($_POST['submit'])) {
			$data = array();
			foreach ($_REQUEST['img0'] as $i=>$img0) {
				if($_FILES['img']['size'][$i] > 0) {
					$path = 'html/Attach/index/'.date("YmdHis").substr(microtime(),1,7).'.'.strtolower(pathinfo($_FILES['img']['name'][$i], PATHINFO_EXTENSION));
					if (!move_uploaded_file($_FILES['img']['tmp_name'][$i], $path)) {
						self::_error('上传图片出错！');
					}
				}
				else {
					$path = $img0;
				}
				$data[] = array(
					'img' => $path,
					'url' => $_REQUEST['url'][$i]
					);
			}
			if(F(MODULE_NAME.'-'.ACTION_NAME, $data, APP_PATH.'/../Runtime/Data/')) {
				self::_success('提交成功！', __URL__.'/'.ACTION_NAME);
			}
			else {
				self::_error('保存数据出错！');
			}
		}
		$topnavi[]=array(
			'text'=> '品牌直达管理',
			);
		$this->assign("topnavi",$topnavi);

		$data = F(MODULE_NAME.'-'.ACTION_NAME, '', APP_PATH.'/../Runtime/Data/');
		if (empty($data)) {
			$data = array(
				array(
					'img' => 'Tpl/default/Public/Images/brand1.png',
					'url' => '#'
					),
				array(
					'img' => 'Tpl/default/Public/Images/brand2.png',
					'url' => '#'
					),
				array(
					'img' => 'Tpl/default/Public/Images/brand3.png',
					'url' => '#'
					),
				array(
					'img' => 'Tpl/default/Public/Images/brand4.png',
					'url' => '#'
					),
				array(
					'img' => 'Tpl/default/Public/Images/brand5.png',
					'url' => '#'
					),
				array(
					'img' => 'Tpl/default/Public/Images/brand6.png',
					'url' => '#'
					)
				);
		}
		$this->assign('list', $data);
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}
	public function flink() {
		if (!empty($_POST['submit'])) {
			$data = array();
			foreach ($_REQUEST['name'] as $i=>$title) {
				$data[] = array(
					'name' => $title,
					'url' => $_REQUEST['url'][$i]
					);
			}
			if(F(MODULE_NAME.'-'.ACTION_NAME, $data, APP_PATH.'/../Runtime/Data/')) {
				self::_success('提交成功！', __URL__.'/'.ACTION_NAME);
			}
			else {
				self::_error('保存数据出错！');
			}
		}
		$topnavi[]=array(
			'text'=> '友情链接管理',
			);
		$this->assign("topnavi",$topnavi);

		$data = F(MODULE_NAME.'-'.ACTION_NAME, '', APP_PATH.'/../Runtime/Data/');
		if (empty($data)) {
			$data = array(
				array(
					'name' => '睿腾网络',
					'url' => 'http://www.ycruit.com/'
					)
				);
		}
		$this->assign('list', $data);
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}
}
?>