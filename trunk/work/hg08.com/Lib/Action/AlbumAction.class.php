<?php
class AlbumAction extends BaseAction {
	protected $dao;

	public function _initialize() {
		$this->dao = D('Album');
		parent::_initialize();
	}
	public function works() {
		$this->assign('MODULE_TITLE', '最新作品');
		$id = intval($_REQUEST['id']);
		$alias = ACTION_NAME;
		$this->assign('alias', $alias);
		
		if (empty($id)) {
			//找第一个子分类
			$category = M('Category')->where("alias='".$alias."'")->find();
			$sub_category = M('Category')->where("pid=".$category['id']." and status>0")->order('sort')->find();
			$id = $_GET['id'] = $sub_category['id'];

			$left_list = M('Category')->where("pid=".$category['id']." and status>0")->order('sort')->select();
		}
		else {
			$category = M('Category')->where("id=".$id)->find();
			$left_list = M('Category')->where("pid=".$category['pid']." and status>0")->order('sort')->select();
		}
		$this->assign('ACTION_TITLE', $category['name']);
		$this->assign('left_list', $left_list);
		$this->index($id);
	}

	public function customer() {
		$alias = ACTION_NAME;
		$this->assign('alias', $alias);

		$category = M('Category')->where("alias='".$alias."'")->find();
		$this->assign('MODULE_TITLE', $category['name']);
		$this->index($category['id']);
	}

	public function index($id=0) {
		//子分类文章列表
		$where = array(
			'category_id' => $id,
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

		$this->assign('content', ACTION_NAME);
		$this->display('Layout:reminder');
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
/*
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
*/
		$this->assign('content', 'album');
		$this->display('Layout:main');
	}
	public function photo() {
		$this->assign('MODULE_TITLE', '顾客特照');
		
		$id = intval($_REQUEST['id']);
		$info = $this->dao->find($id);
		$this->assign('ACTION_TITLE', $info['name']);
		$this->assign('album', $info);
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
			'album_id' => intval($_REQUEST['id']),
			'status' => array('gt', 0)
			);
		$rs = M('Photo')->where($where)->order('sort')->select();
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