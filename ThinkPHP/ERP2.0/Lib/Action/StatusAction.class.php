<?php
class StatusAction extends BaseAction{

	protected $dao, $config, $status_arr;

	public function _initialize() {
		if ('Node'!= MODULE_NAME) {
			Session::set('top', 'Board Status');
		}
		$this->dao = D('StatusFlow');
		parent::_initialize();
		$this->assign('MODULE_TITLE', 'Board Status');
		$this->status_arr = array(
			'-1' => 'None',
			'0' => 'Pending',
			'1' => 'Pass',
			'2' => 'Failed'
		);
		$this->assign('status_arr', $this->status_arr);
	}

	public function index() {
		Session::set('sub', MODULE_NAME);

		$this->assign('request', $_REQUEST);
		//load template
		$this->assign('template_opts', self::genOptions(M('StatusTemplate')->order('id')->select()));
		
		$where = array();
		if (!empty($_REQUEST['flow_name'])) {
			$flow_name = trim($_REQUEST['flow_name']);
			if (strlen($flow_name)>0) {
				$where['name'] = array('like', '%'.$flow_name.'%');
			}
		}
		if (!empty($_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_creator_id'])) {
			$creator_id = $_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_creator_id'];
		}
		if (isset($_REQUEST['creator_id'])) {
			$creator_id = intval($_REQUEST['creator_id']);
		}
		$_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_creator_id'] = $creator_id;
		$creator_arr = $this->dao->join("Inner Join erp_staff on erp_staff.id=erp_status_flow.creator_id")->distinct(true)->field("erp_staff.id as id, erp_staff.realname as realname")->order("realname")->select();
		$this->assign('creator_opts', self::genOptions($creator_arr, $creator_id, 'realname'));
		if (!empty($creator_id)) {
			$where['creator_id'] = $creator_id;
		}

		$board_where = array();
		if (!empty($_REQUEST['board_name'])) {
			$board_name = trim($_REQUEST['board_name']);
			if (strlen($board_name)>0) {
				$board_where['name'] = array('like', '%'.$board_name.'%');
			}
		}
		if (!empty($_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_owner_id'])) {
			$owner_id = $_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_owner_id'];
		}
		if (isset($_REQUEST['owner_id'])) {
			$owner_id = intval($_REQUEST['owner_id']);
		}
		$_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_owner_id'] = $owner_id;
		$owner_arr = M('StatusBoard')->join("Inner Join erp_staff on erp_staff.id=erp_status_board.owner_id")->distinct(true)->field("erp_staff.id as id, erp_staff.realname as realname")->order("realname")->select();
		$this->assign('owner_opts', self::genOptions($owner_arr, $owner_id, 'realname'));
		if (!empty($owner_id)) {
			$board_where['owner_id'] = $owner_id;
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

		$rs = $this->dao->relation(true)->where($where)->order('id desc')->limit($p->offset.','.$p->limit)->select();
		empty($rs) && ($rs = array());
		$result = array();
		foreach ($rs as $i=>$row) {
			$result[$i] = $row;
			$board_where['flow_id'] = $row['id'];
			$result[$i]['board_list'] = D('StatusBoard')->relation(true)->where($board_where)->order('name')->select();
		}
		$this->assign('result', $result);

		$this->assign('page', $p->showMultiNavi());
		
		$this->assign('ACTION_TITLE', 'Flow List');
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:ERP_layout');
	}
	
	public function form() {
		Session::set('sub', MODULE_NAME);
		//load item
		$this->assign('item_list', D('StatusItem')->order('sort')->select());
		//gen staff options
		$this->assign('staff_opts', self::genOptions(M('Staff')->where(array('status'=>1))->select(), $_SESSION[C('USER_AUTH_KEY')], 'realname'));

		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		if ($id>0) {
			$info = $this->dao->find($id);
			$item_arr = explode(',', $info['item_ids']);
			$owner_arr = explode(',', $info['owner_ids']);
		}
		else {
			$info = array(
				'id' => 0,
				'name' => '',
				'item_list' => array()
			);
			$item_arr = array();
			$template_id = empty($_REQUEST['template_id']) ? 0 : intval($_REQUEST['template_id']);
			if ($template_id>0) {
				$template_info = M('StatusTemplate')->find($template_id);
				$item_arr = explode(',', $template_info['item_ids']);
				$owner_arr = explode(',', $template_info['owner_ids']);
			}
		}
		foreach ($item_arr as $i=>$item_id) {
			$item = M('StatusItem')->find($item_id);
			$info['item_list'][] = array(
				'id' => $item_id,
				'name' => $item['name'],
				'owner_opts' => self::genOptions(M('Staff')->where(array('status'=>1))->order('realname')->select(), $owner_arr[$i], 'realname')
			);
		}
		$this->assign('info', $info);

		$this->assign('ACTION_TITLE', 'Flow Form');
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:ERP_layout');
	}

	public function submit() {
		if (empty($_POST['submit'])) {
			return;
		}
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		$name = trim($_REQUEST['name']);
		empty($name) && self::_error('Flow name required!');
		empty($_REQUEST['item_id']) && self::_error('You must add at least one test item!');
		empty($_REQUEST['owner_id'][0]) && self::_error('You must specify an owner to the first test item!');
		if ($id>0) {
			$this->dao->find($id);
		}
		else {
			$this->dao->creator_id = $_SESSION[C('USER_AUTH_KEY')];
			$this->dao->create_time = date('Y-m-d H:i:s');

			$board_name = trim($_REQUEST['board_name']);
			empty($board_name) && self::_error('Board name required!');
		}
		$this->dao->name = $name;
		$this->dao->item_ids = implode(',', $_REQUEST['item_id']);
		$this->dao->owner_ids = implode(',', $_REQUEST['owner_id']);
		$this->dao->update_time = date('Y-m-d H:i:s');
		if ($id>0) {
			if(false !== $this->dao->save()) {
				//update all status
				M('StatusStatus')->where("flow_id=".$id." and item_id not in (".implode(',', $_REQUEST['item_id']).")")->delete();
				//load board list in the flow
				$board_arr = M('StatusBoard')->where("flow_id=".$id)->getField('id, name');
				$last_owner_id = $_REQUEST['owner_id'][0];
				foreach ($_REQUEST['item_id'] as $i=>$item_id) {
					if (empty($_REQUEST['owner_id'][$i])) {
						$owner_id = $last_owner_id;
					}
					else {
						$owner_id = intval($_REQUEST['owner_id'][$i]);
						$last_owner_id = $owner_id;
					}
					$tmp_rs = M('StatusStatus')->where("flow_id=".$id." and item_id=".$item_id)->select();
					if (empty($tmp_rs)) {
						//add new item for all board
						foreach ($board_arr as $board_id=>$null) {
							$status_data = array(
								'flow_id' => $id,
								'board_id' => $board_id,
								'item_id' => $item_id,
								'owner_id' => $owner_id,
								'substitute_id' => 0,
								'sort' => $i,
								'status' => -1,
								'mail_status' => -1
							);
							if (!M('StatusStatus')->add($status_data)) {
								self::_error('Add status fail!'.$this->dao->getLastSql());
							}
							M('StatusBoard')->where("id=".$board_id)->setField(array('status', 'update_time'), array(-1, date('Y-m-d H:i:s')));
						}
					}
					else {
						//update the exists item
						M('StatusStatus')->where("flow_id=".$id." and item_id=".$item_id)->setField('sort', $i);
					}
				}
				self::_success('Flow updated!',__URL__);
			}
			else {
				self::_error('Update fail!'.$this->dao->getLastSql());
			}
		}
		else {
			if($id = $this->dao->add()) {
				$board_data = array(
					'flow_id' => $id,
					'name' => $board_name.sprintf("%03d", 1),
					'info' => trim($_REQUEST['board_info']),
					'owner_id' => intval($_REQUEST['board_owner_id']),
					'create_time' => date('Y-m-d H:i:s'),
					'update_time' => date('Y-m-d H:i:s'),
					'status' => -1
				);
				if (!$board_id=M('StatusBoard')->add($board_data)) {
					self::_error('Add board fail!'.$this->dao->getLastSql());
				}
				//add item status
				$last_owner_id = $_REQUEST['owner_id'][0];
				foreach ($_REQUEST['item_id'] as $i=>$item_id) {
					if (empty($_REQUEST['owner_id'][$i])) {
						$owner_id = $last_owner_id;
					}
					else {
						$owner_id = intval($_REQUEST['owner_id'][$i]);
						$last_owner_id = $owner_id;
					}
					$status_data = array(
						'flow_id' => $id,
						'board_id' => $board_id,
						'item_id' => $item_id,
						'owner_id' => $owner_id,
						'substitute_id' => 0,
						'sort' => $i,
						'status' => -1,
						'mail_status' => -1
					);
					if (!M('StatusStatus')->add($status_data)) {
						self::_error('Add status fail!'.$this->dao->getLastSql());
					}
				}
				self::_success('Create flow success!',__URL__);
			}
			else {
				self::_error('Create flow fail!'.$this->dao->getLastSql());
			}
		}
	}

	public function flow() {
		Session::set('sub', MODULE_NAME);
		
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		
		$flow_info = $this->dao->find($id);

		$board_list = D('StatusBoard')->relation(true)->where("flow_id=".$id)->order('id')->select();
		foreach ($board_list as $i=>$board) {
			$board_list[$i]['last_comment'] = M('Comment')->where(array('model_name'=>'StatusBoard', 'model_id'=>$board['id']))->order('id desc')->find();
		}

		$owner_arr = explode(',', $flow_info['owner_ids']);
		$item_board_status = array();
		foreach (explode(',', $flow_info['item_ids']) as $i=>$item_id) {
			$board_status = D('StatusStatus')->relation(true)->where("flow_id=".$id." and item_id=".$item_id." and sort=".$i)->order("board_id")->select();
			foreach ($board_status as $j=>$status) {
				$board_status[$j]['comment'] = D('Comment')->relation(true)->where(array('model_name'=>'StatusStatus', 'model_id'=>$status['id']))->order('id')->select();
				$board_status[$j]['last_comment'] = M('Comment')->where(array('model_name'=>'StatusStatus', 'model_id'=>$status['id']))->order('id desc')->find();
			}
			$item_board_status[$i] = array(
				'item_info' => M('StatusItem')->find($item_id),
				'owner' => M('Staff')->where("id=".$owner_arr[$i])->getField('realname'),
				'board_status' => $board_status
			);
		}
		$op = empty($_REQUEST['op']) ? '' : trim($_REQUEST['op']);
		if ('export' == $op) {
			include_once (LIB_PATH.'PHPExcel.php');
			$COLS = array();
			$last_col = 'A';
			for ($i=0; $i<count($board_list)+4; $i++) {
				$COLS[] = $last_col;
				$last_col ++;
			}
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()
				->setTitle('Board Status Test Flow: '.$flow_info['name'])
				->setSubject('Board Status Test Flow: '.$flow_info['name']);
			$objPHPExcel->setActiveSheetIndex(0);
			
			$Style_BoardTH = new PHPExcel_Style();
			$Style_BoardTH->applyFromArray(
				array(
					'font' => array(
						'bold'  => true,
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					),
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
							'rgb' => 'CCCCFF'
						)
					)
				)
			);
			$Style_BoardTD = new PHPExcel_Style();
			$Style_BoardTD->applyFromArray(
				array(
					'font' => array(
						'bold'  => true,
						'color' => array('rgb' => '0000FF')
					),
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
							'rgb' => 'CCFFFF'
						)
					)
				)
			);
			$Style_BoardInfo = new PHPExcel_Style();
			$Style_BoardInfo->applyFromArray(
				array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
							'rgb' => 'CCFFFF'
						)
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_TOP,
						'wrap' => true
					)
				)
			);
			$Style_ItemTH = new PHPExcel_Style();
			$Style_ItemTH->applyFromArray(
				array(
					'font' => array(
						'bold'  => true,
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					),
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
							'rgb' => '9999CC'
						)
					)
				)
			);
			$Style_StatusTH = new PHPExcel_Style();
			$Style_StatusTH->applyFromArray(
				array(
					'font' => array(
						'bold'  => true,
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					),
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
							'rgb' => 'CC99FF'
						)
					)
				)
			);
			$Style_Status_None = new PHPExcel_Style();
			$Style_Status_None->applyFromArray(
				array(
					'font' => array(
						'bold'  => true,
						'color' => array('rgb' => '808080')
					)
				)
			);
			$Style_Status_Pass = new PHPExcel_Style();
			$Style_Status_Pass->applyFromArray(
				array(
					'font' => array(
						'bold'  => true,
						'color' => array('rgb' => '339900')
					)
				)
			);
			$Style_Status_Pending = new PHPExcel_Style();
			$Style_Status_Pending->applyFromArray(
				array(
					'font' => array(
						'bold'  => true,
						'color' => array('rgb' => '0000FF')
					)
				)
			);
			$Style_Status_Failed = new PHPExcel_Style();
			$Style_Status_Failed->applyFromArray(
				array(
					'font' => array(
						'bold'  => true,
						'color' => array('rgb' => 'FF0000')
					)
				)
			);
			
			$Style_BoardStatusTH = new PHPExcel_Style();
			$Style_BoardStatusTH->applyFromArray(
				array(
					'font' => array(
						'bold'  => true,
					),
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
						'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					),
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'startcolor' => array(
							'rgb' => '9999CC'
						)
					)
				)
			);

			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Board Name: ');
			$objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
			$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Board Information: ');
			$objPHPExcel->getActiveSheet()->mergeCells('A2:C2');
			$objPHPExcel->getActiveSheet()->setSharedStyle($Style_BoardTH, 'A1:C2');
			$objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(50);

			foreach ($board_list as $i=>$board) {
				$objPHPExcel->getActiveSheet()->getColumnDimension($COLS[3+$i])->setWidth(15);
				$objPHPExcel->getActiveSheet()->setCellValue($COLS[3+$i].'1', $board['name']);
				$objPHPExcel->getActiveSheet()->setCellValue($COLS[3+$i].'2', $board['info']);
			}
			$objPHPExcel->getActiveSheet()->setSharedStyle($Style_BoardTD, 'D1:'.$COLS[3+$i].'1');
			$objPHPExcel->getActiveSheet()->setSharedStyle($Style_BoardInfo, 'D2:'.$COLS[3+$i].'2');
			
			$objPHPExcel->getActiveSheet()->setCellValue('D3', 'Board Status');
			$objPHPExcel->getActiveSheet()->mergeCells('D3:'.$COLS[3+$i].'3');
			$objPHPExcel->getActiveSheet()->setSharedStyle($Style_StatusTH, 'D3:'.$COLS[3+$i].'3');

			$objPHPExcel->getActiveSheet()->setCellValue('A3', 'No.');
			$objPHPExcel->getActiveSheet()->setCellValue('B3', 'Test Item');
			$objPHPExcel->getActiveSheet()->setCellValue('C3', 'Default Test Owner');
			$objPHPExcel->getActiveSheet()->setSharedStyle($Style_ItemTH, 'A3:C3');

			foreach ($item_board_status as $j=>$item) {
				$objPHPExcel->getActiveSheet()->setCellValue('A'.(4+$j), $j+1);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.(4+$j), $item['item_info']['name']);
				$objPHPExcel->getActiveSheet()->setCellValue('C'.(4+$j), $item['owner']);
				foreach ($item['board_status'] as $k=>$status) {
					$objPHPExcel->getActiveSheet()->setCellValue($COLS[3+$k].(4+$j), $this->status_arr[$status['status']]);
					switch ($status['status']) {
						case '-1':
							$objPHPExcel->getActiveSheet()->setSharedStyle($Style_Status_None, $COLS[3+$k].(4+$j));
							break;
						case '0':
							$objPHPExcel->getActiveSheet()->setSharedStyle($Style_Status_Pending, $COLS[3+$k].(4+$j));
							break;
						case '1':
							$objPHPExcel->getActiveSheet()->setSharedStyle($Style_Status_Pass, $COLS[3+$k].(4+$j));
							break;
						case '2':
							$objPHPExcel->getActiveSheet()->setSharedStyle($Style_Status_Failed, $COLS[3+$k].(4+$j));
							break;
						default:
							//
					}
					empty($status['comment']) && $status['comment']=array();
					foreach ($status['comment'] as $comment) {
						$objPHPExcel->getActiveSheet()->getComment($COLS[3+$k].(4+$j))->setAuthor($comment['staff']['realname']);
						$objCommentRichText = $objPHPExcel->getActiveSheet()->getComment($COLS[3+$k].(4+$j))->getText()->createTextRun('['.$comment['staff']['realname'].' '.$comment['create_time'].']');
						$objCommentRichText->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getComment($COLS[3+$k].(4+$j))->getText()->createTextRun("\r\n");
						$objPHPExcel->getActiveSheet()->getComment($COLS[3+$k].(4+$j))->getText()->createTextRun("abc\r\n");
						$objPHPExcel->getActiveSheet()->getComment($COLS[3+$k].(4+$j))->setWidth('120pt');
						$objPHPExcel->getActiveSheet()->getComment($COLS[3+$k].(4+$j))->setHeight('160pt');
					}
				}
				$objPHPExcel->getActiveSheet()->getStyle('A'.(4+$j).':'.$COLS[3+$k].(4+$j))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
				$objPHPExcel->getActiveSheet()->getStyle('A'.(4+$j).':'.$COLS[3+$k].(4+$j))->getFill()->getStartColor()->setRGB($j%2?'CCCCCC':'EEEEEE');
			}
			$objPHPExcel->getActiveSheet()->setCellValue('A'.(5+$j), 'Board Final Status: ');
			$objPHPExcel->getActiveSheet()->mergeCells('A'.(5+$j).':C'.(5+$j));
			$objPHPExcel->getActiveSheet()->setSharedStyle($Style_BoardStatusTH, 'A'.(5+$j).':C'.(5+$j));
			foreach ($board_list as $i=>$board) {
				$objPHPExcel->getActiveSheet()->setCellValue($COLS[3+$i].(5+$j), $this->status_arr[$board['status']]);
				switch ($board['status']) {
					case '-1':
						$objPHPExcel->getActiveSheet()->setSharedStyle($Style_Status_None, $COLS[3+$i].(5+$j));
						break;
					case '0':
						$objPHPExcel->getActiveSheet()->setSharedStyle($Style_Status_Pending, $COLS[3+$i].(5+$j));
						break;
					case '1':
						$objPHPExcel->getActiveSheet()->setSharedStyle($Style_Status_Pass, $COLS[3+$i].(5+$j));
						break;
					case '2':
						$objPHPExcel->getActiveSheet()->setSharedStyle($Style_Status_Failed, $COLS[3+$i].(5+$j));
						break;
					default:
						//
				}
			}
			$objPHPExcel->getActiveSheet()->getStyle('D'.(5+$j).':'.$COLS[3+$i].(5+$j))->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
			$objPHPExcel->getActiveSheet()->getStyle('D'.(5+$j).':'.$COLS[3+$i].(5+$j))->getFill()->getStartColor()->setRGB('99CCFF');


			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="'.$flow_info['name'].'.xls"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
			exit;

		}

		$this->assign('flow_info', $flow_info);
		$this->assign('board_list', $board_list);
		$this->assign('item_board_status', $item_board_status);

		$this->assign('ACTION_TITLE', 'Flow Detail');
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:ERP_layout');
	}

	public function board() {
		Session::set('sub', MODULE_NAME);
		$dao = D('StatusBoard');

		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		if (!empty($_POST['submit'])) {
			$board_name = trim($_REQUEST['board_name']);
			!$board_name && self::_error('Board name required!');

			$flow_id = intval($_REQUEST['flow_id']);
			$rs = $dao->where("flow_id=".$flow_id)->order("name desc")->find();
			if (!empty($rs)) {
				$max_name = $rs['name'];
				$board_name = ++$max_name;
			}
			else {
				$board_name .= sprintf("%03d", 1);
			}
			$dao->id = 0;
			$dao->flow_id = $flow_id;
			$dao->name = $board_name;
			$dao->info = trim($_REQUEST['board_info']);
			$dao->owner_id = intval($_REQUEST['owner_id']);
			$dao->create_time = date('Y-m-d H:i:s');
			$dao->status = -1;
			if($board_id = $dao->add()) {
				//add item status
				$flow_info = $this->dao->find($flow_id);
				$item_ids = explode(',', $flow_info['item_ids']);
				$owner_ids = explode(',', $flow_info['owner_ids']);
				$last_owner_id = $owner_ids[0];
				foreach ($item_ids as $i=>$item_id) {
					if (empty($owner_ids[$i])) {
						$owner_id = $last_owner_id;
					}
					else {
						$owner_id = $owner_ids[$i];
						$last_owner_id = $owner_id;
					}
					$status_data = array(
						'flow_id' => $flow_id,
						'board_id' => $board_id,
						'item_id' => $item_id,
						'owner_id' => $owner_id,
						'substitute_id' => 0,
						'sort' => $i,
						'status' => -1,
						'mail_status' => -1
					);
					if (!M('StatusStatus')->add($status_data)) {
						self::_error('Add status fail!'.$this->dao->getLastSql());
					}
				}
				self::_success('Add board success!',__URL__);
			}
			else{
				self::_error('Add board fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
			}
		}
		elseif (!empty($_REQUEST['op'])) {
			$op = trim($_REQUEST['op']);

			if ('delete' == $op) {
				//delete status
				M('StatusStatus')->where(array('board_id'=>$id))->delete();
			
				$this->dao = $dao;
				self::_delete();
			}
			elseif ('add' == $op) {
				$flow_id = intval($_REQUEST['flow_id']);
				$this->assign('flow_info', $this->dao->relation(true)->find($flow_id));
				
				$rs = $dao->where("flow_id=".$flow_id)->order("name desc")->find();
				$name = '';
				$name_ext = '';
				$info = '';
				if (!empty($rs)) {
					$max_name = $rs['name'];
					$name_ext = ++$max_name;
					$name = substr($max_name, 0, -3);
					$info = $rs['info'];
				}
				$info = array(
					'name' => $name,
					'name_ext' => $name_ext,
					'info' => $info,
					'owner_opts' => self::genOptions(M('Staff')->where(array('status'=>1))->select(), $_SESSION[C('USER_AUTH_KEY')], 'realname')
				);
				$this->assign('info', $info);

				$this->assign('content', ACTION_NAME.'_add');
				$this->display('Layout:content');
			}
		}
		else {
			$info = $dao->relation(true)->find($id);
			
			$status_list = D('StatusStatus')->relation(true)->where(array('flow_id'=>$info['flow_id'], 'board_id'=>$id))->order('sort')->select();
			foreach ($status_list as $i=>$status) {
				$status_list[$i]['owner_opts'] = self::genOptions(M('Staff')->where(array('status'=>1))->order('realname')->select(), $status['owner_id'], 'realname');
				$status_list[$i]['substitute_opts'] = self::genOptions(M('Staff')->where(array('status'=>1, 'id'=>array('neq', $status['owner_id'])))->order('realname')->select(), $status['substitute_id'], 'realname');
			}
			$info['status_list'] = $status_list;
			$info['comment'] = D('Comment')->relation(true)->where(array('model_name'=>'StatusBoard', 'model_id'=>$id, 'status'=>1))->order('id')->select();
			$this->assign('info', $info);
			$this->assign('ACTION_TITLE', 'Board Detail');
			$this->assign('content', ACTION_NAME);
			$this->display('Layout:ERP_layout');
		}
	}
	public function update() {
		$board_id = empty($_REQUEST['board_id']) ? 0 : intval($_REQUEST['board_id']);
		$status_id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		$field = $_REQUEST['f'];
		$value = $_REQUEST['v'];
		$rs = true;
		if ($board_id > 0) {
			//改变Board状态
			$dao = M('StatusBoard');
			$info = $dao->where('id='.$board_id)->find();
			if ($info[$field] != $value) {
				$rs = $dao->where('id='.$board_id)->setField(array($field, 'update_time'), array($value, date('Y-m-d H:i:s')));
			}
			if ('status'==$field && 1==$value) {
			}
		}
		elseif ($status_id > 0) {
			//改变Status状态
			$dao = M('StatusStatus');
			$info = $dao->where("id=".$status_id)->find();
			if ($info[$field] != $value) {
				$rs = $dao->where("id=".$status_id)->setField(array($field, 'update_time'), array($value, date('Y-m-d H:i:s')));
			}
			if ('status'==$field) {
				if ($value <= 0) {
					//有Owner改变状态为Pending或None，则自动调整Board状态
					if ($value != M('StatusBoard')->where("id=".$info['board_id'])->getField('status')) {
						M('StatusBoard')->where("id=".$info['board_id'])->setField(array('status', 'update_time'), array($value, date('Y-m-d H:i:s')));
					}
				}
				elseif (1==$value) {
					//Turn to next
					//if ($dao->where("board_id=".$info['board_id']." and sort>".$info['sort']." and status=0")->count()==0) {
					//	$dao->where("board_id=".$info['board_id']." and sort>".$info['sort']." and status=-1")->order('sort')->limit(1)->setField('status', 0);
					//}
					//如果所有Status都为Pass，则设置Board为Pass
					if ($dao->where("board_id=".$info['board_id'])->count() == $dao->where("board_id=".$info['board_id']." and status=1")->count()) {
						M('StatusBoard')->where('id='.$info['board_id'])->setField(array('status', 'update_time'), array(1, date('Y-m-d H:i:s')));
					}
				}
				else {
					//设置Board状态为Failed
					M('StatusBoard')->where('id='.$info['board_id'])->setField(array('status', 'update_time'), array(2, date('Y-m-d H:i:s')));
				}
			}
		}
		if(false !== $rs) {
			if ('POST' == strtoupper($_SERVER["REQUEST_METHOD"])) {
				die('Update success!');
			}
			self::_success('Update success!');
		}
		else {
			if ('POST' == strtoupper($_SERVER["REQUEST_METHOD"])) {
				die('Update fail!'.(C('APP_DEBUG')? $dao->getLastSql() : ''));
			}
			self::_error('Update fail!'.(C('APP_DEBUG')? $dao->getLastSql() : ''));
		}
	}
	public function template() {
		Session::set('sub', MODULE_NAME.'/'.ACTION_NAME);
		$dao = D('StatusTemplate');

		if (!empty($_POST['submit'])) {
			$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
			$name = trim($_REQUEST['name']);
			!$name && self::_error('Template name required');
			empty($_REQUEST['item_id']) && self::_error('You must add at least one item!');
			if ($id>0) {
				$dao->find($id);
			}
			else {
				$dao->create_time = date('Y-m-d H:i:s');
			}
			$dao->name = $name;
			$dao->item_ids = implode(',', $_REQUEST['item_id']);
			$dao->owner_ids = implode(',', $_REQUEST['owner_id']);
			$dao->creator_id = $_SESSION[C('USER_AUTH_KEY')];
			$dao->update_time = date('Y-m-d H:i:s');
			if ($id>0) {
				if(false !== $dao->save()){
					self::_success('Template information updated!',__URL__.'/'.ACTION_NAME);
				}
				else{
					self::_error('Update fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
				}
			}
			else {
				if($dao->add()) {
					self::_success('Template defined success!',__URL__.'/'.ACTION_NAME);
				}
				else{
					self::_error('Template defined fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
				}
			}
		}
		elseif (!empty($_REQUEST['op'])) {
			$op = trim($_REQUEST['op']);

			if ('form' == $op) {
				$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
				if ($id>0) {
					$info = $dao->find($id);
					$item_arr = explode(',', $info['item_ids']);
					$owner_arr = explode(',', $info['owner_ids']);
					$info['item_list'] = array();
					foreach ($item_arr as $i=>$item_id) {
						$item = D('StatusItem')->find($item_id);
						$info['item_list'][] = array(
							'id' => $item_id,
							'name' => $item['name'],
							'staff_opts' => self::genOptions(M('Staff')->where(array('status'=>1))->order('realname')->select(), $owner_arr[$i], 'realname')
						);
					}
				}
				else {
					$info = array(
						'id' => 0,
						'name' => '',
						'item_list' => array()
					);
				}
				$this->assign('info', $info);
				//load item
				$this->assign('item_list', D('StatusItem')->order('sort')->select());
				$this->assign('content', ACTION_NAME.'_form');
			}
			elseif ('get_item' == $op) {
				$id = intval($_REQUEST['id']);
				$item = D('StatusItem')->find($id);
				$arr = array(
					'id' => $id,
					'name' => $item['name'],
					'staff_opts' => self::genOptions(M('Staff')->where(array('status'=>1))->order('realname')->select(), $item['owner_id'], 'realname')
				);
				die(json_encode($arr));
			}
			elseif ('delete' == $op) {
				if (!empty($_REQUEST['id'])) {
					$id = intval($_REQUEST['id']);
					$this->dao = $dao;
					self::_delete();
				}
			}
		}
		else {
			$result = $dao->relation(true)->order('id')->select();
			$this->assign('result', $result);
			$this->assign('content', ACTION_NAME);
		}
		$this->assign('ACTION_TITLE', 'Flow Template');
		$this->display('Layout:ERP_layout');
	}

	public function item() {
		Session::set('sub', MODULE_NAME.'/'.ACTION_NAME);

		$dao = D('StatusItem');
		if (!empty($_POST['submit'])) {
			$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
			$name = trim($_REQUEST['name']);
			!$name && self::_error('Item name required');
			$type = $_REQUEST['type'];
			if ($id>0) {
				$rs = $dao->where(array('type'=>$type, 'name'=>$name, 'id'=>array('neq',$id)))->find();
				if($rs && sizeof($rs)>0){
					self::_error('The item: \''.$name.'\' already exists!');
				}
				$dao->find($id);
			}
			else {
				$rs = $dao->where(array('type'=>$type, 'name'=>$name))->find();
				if($rs && sizeof($rs)>0){
					self::_error('The item: \''.$name.'\' already exists!');
				}
			}
			$dao->name = $name;
			$dao->description = trim($_REQUEST['description']);
			$dao->owner_id = intval($_REQUEST['owner_id']);
			$dao->type = 'radio';
			$dao->sort = max(1, intval($_REQUEST['sort']));
			if ($id>0) {
				if(false !== $dao->save()){
					self::_success('Test item updated!',__URL__.'/'.ACTION_NAME);
				}
				else{
					self::_error('Update fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
				}
			}
			else {
				if($dao->add()) {
					self::_success('Add item success!',__URL__.'/'.ACTION_NAME);
				}
				else{
					self::_error('Add item fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
				}
			}
		}
		elseif (!empty($_REQUEST['id'])) {
			$id = intval($_REQUEST['id']);
			$count = M('StatusTemplate')->where(array('_string'=>"item_ids like '".$id.",%' OR item_ids like '%,".$id.",%' OR item_ids like '%,".$id."'"))->count();
			if ($count > 0) {
				self::_error('It\'s used in template, can\'t be deleted!');
			}
			$count = M('StatusFlow')->where(array('item_id'=>$id))->count();
			if($count > 0) {
				self::_error('It\'s used in flow, can\'t be deleted!');
			}
			else{
				$this->dao = $dao;
				self::_delete();
			}
		}

		$this->assign('staff_opts', self::genOptions(M('Staff')->where(array('status'=>1))->order('realname')->select(), '', 'realname'));
		
		$result = $dao->relation(true)->order('sort')->select();
		$this->assign('result', $result);

		$this->assign('ACTION_TITLE', 'Test Item');
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:ERP_layout');
	}
	public function delete() {
		$id = $_REQUEST['id'];

		//delete board
		M('StatusBoard')->where(array('flow_id'=>$id))->delete();
		//delete status
		M('StatusStatus')->where(array('flow_id'=>$id))->delete();

		self::_delete();
	}

	public function list_comment() {
		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		$this->assign('id', $id);
		$model = empty($_REQUEST['model']) ? 'StatusStatus' : trim($_REQUEST['model']);
		$this->assign('model', $model);
		$this->assign('comment', D('Comment')->relation(true)->where(array('model_name'=>$model, 'model_id'=>$id, 'status'=>1))->order('id')->select());
		$this->assign('content', ACTION_NAME);
		$this->display('Layout:content');
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
		$model_name = empty($_REQUEST['model_name']) ? MODULE_NAME : trim($_REQUEST['model_name']);
		empty($_REQUEST['model_id']) && self::_error('No board id specified!');
		$model_id = intval($_REQUEST['model_id']);
		$content = trim($_REQUEST['content']);
		!$content && self::_error('Comment can\'t be empty!');
		if ($id>0) {
			$dao->find($id);
		}
		else {
			$dao->model_name = $model_name;
			$dao->model_id = $model_id;
			$dao->staff_id = $_SESSION[C('USER_AUTH_KEY')];
			$dao->create_time = date('Y-m-d H:i:s');
			$dao->status = 1;
		}
		$dao->content = $content;
		if ($id>0) {
			if(false !== $dao->save()) {
				$html  = '<script language="JavaScript" type="text/javascript">';
				$html .= 'parent.myAlert("Update comment success!");';
				$html .= 'parent.myOK(500);';
				$html .= 'parent.show_comment('.$id.', "'.str_replace(array("\r\n", "\n"), '<br />', $content).'");';
				$html .= '</script>';
				die($html);
			}
			else{
				self::_error('Update comment fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
			}
		}
		else {
			if($id=$dao->add()) {
				$html  = '<script language="JavaScript" type="text/javascript">';
				$html .= 'parent.myAlert("Post comment success!");';
				$html .= 'parent.myOK(500);';
				$html .= 'parent.show_comment('.$id.', "'.str_replace(array("\r\n", "\n"), '<br />', $content).'");';
				$html .= '</script>';
				die($html);
			}
			else{
				self::_error('Post comment fail!'.(C('APP_DEBUG')?$dao->getLastSql():''));
			}
		}
	}
	public function delete_comment() {
		$id = intval($_REQUEST['id']);
		$dao = D('Comment');
		$info = $dao->find($id);
		if($id>0 && $dao->where("id=".$id)->delete()) {
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

}
?>