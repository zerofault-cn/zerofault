<?php

class SystemAction extends BaseAction{

	public function _initialize() {
		parent::_initialize();
	}

	public function setting() {
		if (!empty($_POST['submit'])) {
			$data = array(
				'title' => trim($_REQUEST['title']),
				'keywords' => str_replace(array("\r\n", "\n"), ' ', trim($_REQUEST['keywords'])),
				'description' => str_replace(array("\r\n", "\n"), ' ', trim($_REQUEST['description'])),
				'qq' => trim($_REQUEST['qq']),
				);

			if(F(MODULE_NAME.'-'.ACTION_NAME, $data, 'Runtime/Data/')) {
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

		$data = F(MODULE_NAME.'-'.ACTION_NAME, '', 'Runtime/Data/');
		if (empty($data)) {
			$data = array(
				'title' => '',
				'keywords' => '',
				'description' => ''
				);
		}
		$this->assign('data', $data);
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:default');
	}
	public function image() {
		if (!empty($_POST['submit'])) {
			$data = array();
			foreach ($_REQUEST as $key=>$val) {
				if (!is_array($val)) {
					continue;
				}
				$data[$key] = array(
					'name' => $val['name'],
					);
				if (is_array($val['img0'])) {
					$data[$key]['list'] = array();
					foreach ($val['img0'] as $i=>$img0) {
						if($_FILES[$key]['size']['img'][$i] > 0) {
							$path = 'html/Attach/Image/'.date("YmdHis").substr(microtime(),1,7).'.'.strtolower(pathinfo($_FILES[$key]['name']['img'][$i], PATHINFO_EXTENSION));
							if (!move_uploaded_file($_FILES[$key]['tmp_name']['img'][$i], $path)) {
								self::_error('上传图片出错1！');
							}
						}
						else {
							$path = $img0;
						}
						$data[$key]['list'][$i] = array(
							'img' => $path
							);
					}
				}
				else {
					if($_FILES[$key]['size']['img'] > 0) {
						$path = 'html/Attach/Image/'.date("YmdHis").substr(microtime(),1,7).'.'.strtolower(pathinfo($_FILES[$key]['name']['img'], PATHINFO_EXTENSION));
						if (!move_uploaded_file($_FILES[$key]['tmp_name']['img'], $path)) {
							self::_error('上传图片出错2！');
						}
					}
					else {
						$path = $val['img0'];
					}
					$data[$key]['img'] = $path;
					$data[$key]['url'] = empty($val['url'])?'':trim($val['url']);
				}
			}
			if(F(MODULE_NAME.'-'.ACTION_NAME, $data, 'Runtime/Data/')) {
				//生成banner.xml
				$uri = './Runtime/Data/banner.xml';
				touch($uri);
				$uri = realpath($uri);
				$xml = new XMLWriter();
				$xml->openUri($uri);
				$xml->setIndentString('  ');
				$xml->setIndent(true);
				$xml->startDocument('1.0', 'utf-8');
				$xml->startElement('banner');
				$xml->writeAttribute('width', '1578');
				$xml->writeAttribute('height', '530');
				$xml->writeAttribute('backgroundColor', '0xffffff');
				$xml->writeAttribute('backgroundTransparency', '100');
				$xml->writeAttribute('startWith', '1');
				$xml->writeAttribute('barHeight', '28');
				$xml->writeAttribute('fadeTransition', 'false');
				$xml->writeAttribute('verticalTransition', 'false');
				$xml->writeAttribute('controllerTop', 'false');
				$xml->writeAttribute('transitionSpeed', '1');
				$xml->writeAttribute('titleX', '0');
				$xml->writeAttribute('titleY', '0');

				$xml->startElement('items');
				foreach ($data['index_top']['list'] as $item) {
					$xml->startElement('item');

						$xml->startElement('title');
						$xml->text($item['title']);
						$xml->endElement();
					
						$xml->startElement('path');
						$xml->text($item['img']);
						$xml->endElement();

						$xml->startElement('target');
						$xml->text('_blank');
						$xml->endElement();

						$xml->startElement('bar_color');
						$xml->text('0x888888');
						$xml->endElement();

						$xml->startElement('bar_transparency');
						$xml->text('50');
						$xml->endElement();

						$xml->startElement('slideShowTime');
						$xml->text('3');
						$xml->endElement();

					$xml->endElement();
				}
				$xml->endElement();
				$xml->endElement();
				$xml->endDocument();
			//	$xml->flush();

				self::_success('提交成功！', __URL__.'/'.ACTION_NAME);
			}
			else {
				self::_error('保存数据出错！');
			}
			exit;
		}
		$topnavi[]=array(
			'text'=> '栏目头图设置',
			);
		$this->assign("topnavi", $topnavi);

		$data = F(MODULE_NAME.'-'.ACTION_NAME, '', 'Runtime/Data/');
		if (empty($data)) {
			$data = array(
				'index_top' => array(
					'name' => '首页头部图',
					'list' => array(
						array(
							'img' => 'Tpl/default/Public/Images/banner_01.jpg'
							),
						array(
							'img' => 'Tpl/default/Public/Images/banner_02.jpg'
							)
						)
					),
				'index_wedding' => array(
					'name' => '首页【[时尚婚纱】配图',
					'img' => 'Tpl/default/Public/Images/index_56.jpg',
					'url' => __APP__.'/Album/works/5'
					),
				'top_about' => array(
					'name' => '【关于皇宫】页头部图',
					'img' => 'Tpl/default/Public/Images/new_17.jpg'
					),
				'top_news' => array(
					'name' => '【最新活动】页头部图',
					'img' => 'Tpl/default/Public/Images/new_17.jpg'
					),
				'top_works' => array(
					'name' => '【最新作品】页头部图',
					'img' => 'Tpl/default/Public/Images/new_17.jpg'
					),
				'top_reserve' => array(
					'name' => '【在线预定】页头部图',
					'img' => 'Tpl/default/Public/Images/new_17.jpg'
					),
				'top_reminder' => array(
					'name' => '【温馨提示】页头部图',
					'img' => 'Tpl/default/Public/Images/new_17.jpg'
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
			if(F(MODULE_NAME.'-'.ACTION_NAME, $data, 'Runtime/Data/')) {
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

		$data = F(MODULE_NAME.'-'.ACTION_NAME, '', 'Runtime/Data/');
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