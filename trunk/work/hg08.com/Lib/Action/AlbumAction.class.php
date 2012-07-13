<?php
class AlbumAction extends BaseAction {
	protected $dao;

	public function _initialize() {
		$this->dao = D('Album');
		parent::_initialize();
	}
	public function _empty() {
		$this->assign('MODULE_TITLE', '最新作品');
		$id = intval($_REQUEST['id']);
		$alias = ACTION_NAME;
		$this->assign('alias', $alias);
		if (empty($id)) {
			$category = M('Category')->where("alias='".$alias."'")->find();
			$sub_category = M('Category')->where("pid=".$category['id']." and status>0")->order('sort')->find();
			if (!empty($sub_category)) {
				$_GET['id'] = $sub_category['id'];
				$this->index($category['id']);
				exit;
			}

			$where = array(
				'category_id' => $category['id'],
				'status' => array('gt', 0)
				);
			$order = 'sort, id desc';
			$row = $this->dao->where($where)->order($order)->find();
			echo $this->dao->getLastSql();
			$id = $row['id'];
			$_GET['id'] = $id;
		}
		else {
			$category = M('Category')->where("alias='".$alias."'")->find();
			$sub_category_count = M('Category')->where("pid=".$category['id']." and status>0")->count();
			if (!empty($sub_category_count) && $sub_category_count>0) {
				$this->index();
				exit;
			}
			$category_id = $this->dao->where("id=".$id)->getField('category_id');
			$category = M('Category')->find($category_id);
		}
		$this->assign('category', $category);

		$left_list = $this->dao->where("category_id=".$category['id']." and status>0")->order('sort, id desc')->select();
		$this->assign('left_list', $left_list);
		$this->detail($id);
	}
	public function index($pid=0) {
		if (!empty($_REQUEST['id'])) {
			$category_id = intval($_REQUEST['id']);
			$category = M('Category')->find($category_id);
			$pid = $category['pid'];
		}
		$sub_category = M('Category')->where("pid=".$pid." and status>0")->order('sort')->select();
		$this->assign('left_list', $sub_category);
		if (empty($_REQUEST['id'])) {
			//取第一个子分类
			$category = array_shift($sub_category);
		}
		$this->assign('category', $category);
		$this->assign('ACTION_TITLE', $category['name']);
		//子分类文章列表
		$where = array(
			'category_id' => $category['id'],
			'status' => array('gt', 0)
			);
		$order = 'sort, id desc';
		$count = $this->dao->where($where)->count();
		import("@.Paginator");
		$limit = 12;
		$p = new Paginator($count, $limit);
		$rs = $this->dao->where($where)->order($order)->limit($p->offset.','.$p->limit)->select();
		$this->assign('list', $rs);
		$this->assign('page', $p->showMultiNavi());

		$this->assign('content', 'index');
		$this->display('Layout:main');
	}

	public function album($id=0) {
		$album_id = $id;
		!empty($_REQUEST['id']) && ($id = intval($_REQUEST['id']));
		$this->dao->setInc('view', 'id='.$id);

		$info = $this->dao->find($id);
		$this->assign('ACTION_TITLE', $info['name']);
		
		$list = M('Photo')->where('album_id='.$id.' and status>0')->order('sort, id desc')->select();
		$this->assign('list', $list);

		$category = M('Category')->find($info['category_id']);
		$this->assign('category', $category);
		$sub_category = M('Category')->where("pid=".$category['pid']." and status>0")->order('sort')->select();
		$this->assign('left_list', $sub_category);
		$this->assign('alias', M('Category')->where("id=".$category['pid'])->getField('alias'));
		$_GET['id'] = $category['id'];

		//获取上一篇，下一篇
		$rel_link = array();
		$rs = $this->dao->where("category_id=".$info['category_id']." and (sort=".$info['sort']." and id<".$id." or sort<".$info['sort'].")")->order('sort desc, id desc')->find();
		if (!empty($rs) && count($rs)>0) {
			$rel_link['prev'] = $rs;
		}
		$rs = $this->dao->where("category_id=".$info['category_id']." and (sort=".$info['sort']." and id>".$id." or sort>".$info['sort'].")")->order('sort, id')->find();
		if (!empty($rs) && count($rs)>0) {
			$rel_link['next'] = $rs;
		}
		$this->assign('rel_link', $rel_link);

		$this->assign('content', 'album');
		$this->display('Layout:main');
	}

	public function photo() {
		$this->assign('MODULE_TITLE', '顾客特照');
		$this->display('Layout:gallery');
	}
	public function gallery_xml() {
		header("Content-Type:text/xml; charset=utf-8");
		$xml = new XMLWriter();
		$xml->openUri("php://output");
		$xml->setIndentString('  ');
		$xml->setIndent(true);
		$xml->startDocument('1.0', 'utf-8');
		$xml->startElement('gallery');
		$xml->writeAttribute('frameColor', '0xCCCCCC');
		$xml->writeAttribute('frameWidth', '5');
		$xml->writeAttribute('imagePadding', '0');
		$xml->writeAttribute('displayTime', '6');
		$xml->writeAttribute('imagePadding', '0');

		$where = array(
			'category_id' => 3,
			'status' => array('gt', 0)
			);
		$order = 'sort, id desc';
		$rs = M('Photo')->where($where)->order($order)->select();
		empty($rs) && ($rs = array());
		foreach ($rs as $row) {
			$xml->startElement('image');

				$xml->startElement('url');
				$xml->text(__APP__.'/../'.$row['src']);
				$xml->endElement();

				$xml->startElement('caption');
				$xml->text($row['name']);
				$xml->endElement();

				if ($row['height']>700) {
					$height = 700;
					$width = $row['width']*$height/$row['height'];
				}
				else {
					$height = $row['height'];
					$width = $row['width'];
				}
				$xml->startElement('width');
				$xml->text($width);
				$xml->endElement();

				$xml->startElement('height');
				$xml->text($height);
				$xml->endElement();

			$xml->endElement();
		}
		$xml->endElement();
		$xml->endDocument();
		$xml->flush();
	}

}
?>