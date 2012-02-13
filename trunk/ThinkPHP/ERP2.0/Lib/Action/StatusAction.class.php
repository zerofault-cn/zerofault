<?php
class StatusAction extends BaseAction{

	protected $dao, $config, $status_arr, $RevArray;

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
			'2' => 'Failed',
			'8' => 'Ignore',
			'9' => 'Pass*'
		);
		$this->assign('status_arr', $this->status_arr);
		$this->RevArray = array(
			'Software' => 'Software Rev',
			'Logic' => 'Logic Rev',
			'FCT' => 'FCT Rev',
			'Host' => 'Host Rev'
		);
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
		if (isset($_REQUEST['creator_id'])) {
			$creator_id = intval($_REQUEST['creator_id']);
		}
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
		if (!empty($_REQUEST['board_info'])) {
			$board_info = trim($_REQUEST['board_info']);
			if (strlen($board_info)>0) {
				$board_where['info'] = array('like', '%'.$board_info.'%');
			}
		}
		if (isset($_REQUEST['owner_id'])) {
			$owner_id = intval($_REQUEST['owner_id']);
		}
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
			$old_item_ids = $this->dao->item_ids;
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
				$item_ids_diff = array_diff(explode(',', $old_item_ids), $_REQUEST['item_id']);
				if (!empty($item_ids_diff)) {
					$item_deleted = M('StatusItem')->where(array('id'=>array('in', $item_ids_diff)))->getField('id,name');
					self::write_log('Manually', 'Remove Test Items ['.implode('/', $item_deleted).'] from the Test Flow('.$id.': '.$this->dao->name.').');
				}
				//update all status
				M('StatusStatus')->where("flow_id=".$id." and item_id not in (".implode(',', $_REQUEST['item_id']).")")->delete();
				//load board list in the flow
				$board_rs = M('StatusBoard')->where("flow_id=".$id)->select();
				$last_owner_id = $_REQUEST['owner_id'][0];
				foreach ($_REQUEST['item_id'] as $i=>$item_id) {
					if (empty($_REQUEST['owner_id'][$i])) {
						$owner_id = $last_owner_id;
					}
					else {
						$owner_id = intval($_REQUEST['owner_id'][$i]);
						$last_owner_id = $owner_id;
					}
					$tmp_rs = D('StatusStatus')->relation(true)->where("flow_id=".$id." and item_id=".$item_id)->find();
					if (empty($tmp_rs)) {
						self::write_log('Manually', 'Add Test Item['.M('StatusItem')->where("id=".$item_id)->getField('name').'] to the Test Flow('.$id.': '.$this->dao->name.').');
						//add new item for all board
						foreach ($board_rs as $board) {
							$status_data = array(
								'flow_id' => $id,
								'board_id' => $board['id'],
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

							if (-1 != $board['status']) {
								M('StatusBoard')->where("id=".$board['id'])->setField(array('status', 'update_time'), array(-1, date('Y-m-d H:i:s')));
								self::write_log('Automatically', 'Change Board('.$board['id'].': '.$board['name'].') finnal status from ['.$this->status_arr[$board['status']].'] to ['.$this->status_arr[-1].']');
							}
						}
					}
					else {
						//update the exists item
						if ($tmp_rs['owner_id'] != $owner_id) {
							M('StatusStatus')->where("flow_id=".$id." and item_id=".$item_id)->setField(array('owner_id', 'substitute_id', 'sort'), array($owner_id, 0, $i));
							self::write_log('Manually', 'Change the default owner of Item('.$item_id.': '.$tmp_rs['item']['name'].') from ['.$tmp_rs['owner']['realname'].'] to ['.M('Staff')->where("id=".$owner_id)->getField('realname').']');
						}
					}
				}
				//check each board status
				foreach ($board_rs as $board) {
					$status_count = M('StatusStatus')->where("board_id=".$board['id'])->group('status')->getField('status,count(*)');
					if ($status_count[2] > 0) {
						//有Fail
						$value = 2;
					}
					else {
						//没有Fail
						if ($status_count[0] > 0) {
							//有Pending
							$value = 0;
						}
						else {
							//没有Pending
							if ($status_count[-1] > 0) {
								//有None
								$value = -1;
							}
							else {
								//没有None，只剩Pass和Ignore
								if ($status_count[1] == count($_REQUEST['item_id'])) {
									//全部Pass
									$value = 1;
								}
								else {
									$value = 9;
								}
							}
						}
					}
					if ($board['status'] != $value) {
						M('StatusBoard')->where("id=".$board['id'])->setField(array('status', 'update_time'), array($value, date('Y-m-d H:i:s')));
						self::write_log('Automatically', 'Change Board('.$board['id'].': '.$board['name'].') finnal status from ['.$this->status_arr[$board['status']].'] to ['.$this->status_arr[$value].']');
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
				self::send_mail('board', $board_id);
				self::_success('Create flow success!',__URL__);
			}
			else {
				self::_error('Create flow fail!'.$this->dao->getLastSql());
			}
		}
	}

	public function flow() {
		Session::set('sub', MODULE_NAME);

		$this->assign('request', $_REQUEST);

		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);

		$board_where = array(
			'flow_id' => $id
			);
		if (!empty($_REQUEST['board_name'])) {
			$board_name = trim($_REQUEST['board_name']);
			if (strlen($board_name)>0) {
				$board_where['name'] = array('like', '%'.$board_name.'%');
			}
		}
		if (!empty($_REQUEST['board_info'])) {
			$board_info = trim($_REQUEST['board_info']);
			if (strlen($board_info)>0) {
				$board_where['info'] = array('like', '%'.$board_info.'%');
			}
		}
		if (isset($_REQUEST['board_status'])) {
			$board_status = intval($_REQUEST['board_status']);
			if ($board_status>-2) {
				$board_where['status'] = $board_status;
			}
		}
		if (isset($_REQUEST['owner_id'])) {
			$owner_id = intval($_REQUEST['owner_id']);
		}
		$owner_arr = M('StatusBoard')->join("Inner Join erp_staff on erp_staff.id=erp_status_board.owner_id")->distinct(true)->field("erp_staff.id as id, erp_staff.realname as realname")->order("realname")->select();
		$this->assign('owner_opts', self::genOptions($owner_arr, $owner_id, 'realname'));
		if (!empty($owner_id)) {
			$board_where['owner_id'] = $owner_id;
		}

		$flow_info = $this->dao->find($id);

		$board_list = D('StatusBoard')->relation(true)->where($board_where)->order('id')->select();
		$board_ids = array();
		foreach ($board_list as $i=>$board) {
			$board_list[$i]['comment'] = D('Comment')->relation(true)->where(array('model_name'=>'StatusBoard', 'model_id'=>$board['id']))->order('id')->select();
			$board_list[$i]['last_comment'] = M('Comment')->where(array('model_name'=>'StatusBoard', 'model_id'=>$board['id']))->order('id desc')->find();
			$board_ids[] = $board['id'];
		}

		$owner_arr = explode(',', $flow_info['owner_ids']);
		$item_board_status = array();
		$board_ext = "";
		if (count($board_where)>1) {
			//using board filter
			if (count($board_ids)==1) {
				$board_ext = " and board_id=".$board_ids[0];
			}
			else {
				$board_ext = " and board_id in (".implode(',', $board_ids).")";
			}
		}
		foreach (explode(',', $flow_info['item_ids']) as $i=>$item_id) {
			$board_status = D('StatusStatus')->relation(true)->where("flow_id=".$id." and item_id=".$item_id." and sort=".$i.$board_ext)->order("board_id")->select();
			foreach ($board_status as $j=>$status) {
				$board_status[$j]['comment'] = D('Comment')->relation(true)->where(array('model_name'=>'StatusStatus', 'model_id'=>$status['id']))->order('id')->select();
				$board_status[$j]['last_comment'] = M('Comment')->where(array('model_name'=>'StatusStatus', 'model_id'=>$status['id']))->order('id desc')->find();
				//load revision as title
				$tmp_rs = M('StatusRevision')->where("status_id=".$status['id'])->order('sort')->select();
				empty($tmp_rs) && ($tmp_rs = array());
				$tmp_result = array(
					'System' => array_fill_keys(array_keys($this->RevArray), ''),
					'User' => array()
					);
				foreach ($tmp_rs as $row) {
					if (array_key_exists($row['field'], $tmp_result['System'])) {
						$tmp_result['System'][$this->RevArray[$row['field']]] = $row['value'];
					}
					else {
						$tmp_result['User'][$row['field']] = $row['value'];
					}
				}
				$title = '';
				foreach ($tmp_result as $tmp_arr1) {
					foreach ($tmp_arr1 as $tmp_key=>$tmp_val) {
						if(''==trim($tmp_val)) {
							continue;
						}
						$title .= '<b>'.$tmp_key.': </b>'.$tmp_val.'<br />';
					}
				}
				$board_status[$j]['title'] = $title;
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
						$objCommentRichText = $objPHPExcel->getActiveSheet()->getComment($COLS[3+$k].(4+$j))->getText()->createTextRun('['.$comment['staff']['realname'].']@'.$comment['create_time'].':');
						$objCommentRichText->getFont()->setBold(true);
						$objPHPExcel->getActiveSheet()->getComment($COLS[3+$k].(4+$j))->getText()->createTextRun("\r\n");
						$objPHPExcel->getActiveSheet()->getComment($COLS[3+$k].(4+$j))->getText()->createTextRun($comment['content']."\r\n");
						$objPHPExcel->getActiveSheet()->getComment($COLS[3+$k].(4+$j))->setWidth('180pt');
						$objPHPExcel->getActiveSheet()->getComment($COLS[3+$k].(4+$j))->setHeight('180pt');
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
				empty($board['comment']) && $board['comment']=array();
				foreach ($board['comment'] as $comment) {
					$objPHPExcel->getActiveSheet()->getComment($COLS[3+$i].(5+$j))->setAuthor($comment['staff']['realname']);
					$objCommentRichText = $objPHPExcel->getActiveSheet()->getComment($COLS[3+$i].(5+$j))->getText()->createTextRun('['.$comment['staff']['realname'].']@'.$comment['create_time'].':');
					$objCommentRichText->getFont()->setBold(true);
					$objPHPExcel->getActiveSheet()->getComment($COLS[3+$i].(5+$j))->getText()->createTextRun("\r\n");
					$objPHPExcel->getActiveSheet()->getComment($COLS[3+$i].(5+$j))->getText()->createTextRun($comment['content']."\r\n");
					$objPHPExcel->getActiveSheet()->getComment($COLS[3+$i].(5+$j))->setWidth('180pt');
					$objPHPExcel->getActiveSheet()->getComment($COLS[3+$i].(5+$j))->setHeight('180pt');
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
	public function flow2() {
		Session::set('sub', MODULE_NAME);

		$this->assign('request', $_REQUEST);

		$id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);

		$board_where = array(
			'flow_id' => $id
			);
		if (!empty($_REQUEST['board_name'])) {
			$board_name = trim($_REQUEST['board_name']);
			if (strlen($board_name)>0) {
				$board_where['name'] = array('like', '%'.$board_name.'%');
			}
		}
		if (!empty($_REQUEST['board_info'])) {
			$board_info = trim($_REQUEST['board_info']);
			if (strlen($board_info)>0) {
				$board_where['info'] = array('like', '%'.$board_info.'%');
			}
		}
		if (isset($_REQUEST['board_status'])) {
			$board_status = intval($_REQUEST['board_status']);
			if ($board_status>-2) {
				$board_where['status'] = $board_status;
			}
		}
		if (isset($_REQUEST['owner_id'])) {
			$board_owner_id = intval($_REQUEST['owner_id']);
		}
		$owner_arr = M('StatusBoard')->join("Inner Join erp_staff on erp_staff.id=erp_status_board.owner_id")->distinct(true)->field("erp_staff.id as id, erp_staff.realname as realname")->order("realname")->select();
		$this->assign('owner_opts', self::genOptions($owner_arr, $board_owner_id, 'realname'));
		if (!empty($board_owner_id)) {
			$board_where['owner_id'] = $board_owner_id;
		}
		$selected_item_id = 0;
		$selected_item_index = -1;
		if (!empty($_REQUEST['item_id'])) {
			$selected_item_id = intval($_REQUEST['item_id']);
		}

		$flow_info = $this->dao->find($id);

		$flow_item_arr = array();
		$item_ids = explode(',', $flow_info['item_ids']);
		foreach ($item_ids as $i=>$item_id) {
			if ($selected_item_id == $item_id) {
				$selected_item_index = $i;
			}
			$item_list[$i] = M('StatusItem')->find($item_id);
			$flow_item_arr[$i] = $item_list[$i];
			$flow_item_arr[$i]['name'] = ($i+1).'.&nbsp;'.$flow_item_arr[$i]['name'];
		}
		$owner_ids = explode(',', $flow_info['owner_ids']);
		foreach ($owner_ids as $i=>$owner_id) {
			$owner_list[$i] = M('Staff')->where("id=".$owner_id)->getField('realname');
		}
		if ($selected_item_id > 0) {
			$item_ids = array($item_ids[$selected_item_index]);
			$tmp_arr = $item_list;
			unset($item_list);
			$item_list = array($selected_item_index => $tmp_arr[$selected_item_index]);
			$owner_list = array($owner_list[$selected_item_index]);
		}
		$this->assign('flow_item_opts', self::genOptions($flow_item_arr, $selected_item_id));

		$board_list = D('StatusBoard')->relation(true)->where($board_where)->order('id')->select();
		foreach ($board_list as $i=>$board) {
			$board_item = array();
			foreach ($item_ids as $j=>$item_id) {
				$status = M('StatusStatus')->where("board_id=".$board['id']." and flow_id=".$id." and item_id=".$item_id)->find();
				$board_item[$j] = array(
					'status_id' => $status['id'],
					'status' => $status['status'],
					'last_comment' => M('Comment')->where(array('model_name'=>'StatusStatus', 'model_id'=>$status['id']))->order('id desc')->find()
					);

				//load revision as title
				$tmp_rs = M('StatusRevision')->where("status_id=".$status['id'])->order('sort')->select();
				empty($tmp_rs) && ($tmp_rs = array());
				$tmp_result = array(
					'System' => array_fill_keys(array_keys($this->RevArray), ''),
					'User' => array()
					);
				foreach ($tmp_rs as $row) {
					if (array_key_exists($row['field'], $tmp_result['System'])) {
						$tmp_result['System'][$this->RevArray[$row['field']]] = $row['value'];
					}
					else {
						$tmp_result['User'][$row['field']] = $row['value'];
					}
				}
				$title = '';
				foreach ($tmp_result as $tmp_arr1) {
					foreach ($tmp_arr1 as $tmp_key=>$tmp_val) {
						if(''==trim($tmp_val)) {
							continue;
						}
						$title .= '<b>'.$tmp_key.': </b>'.$tmp_val.'<br />';
					}
				}
				$board_item[$j]['title'] = $title;
			}
		//	dump($board_item);
			$board_list[$i]['board_item'] = $board_item;
			$board_list[$i]['last_comment'] = M('Comment')->where(array('model_name'=>'StatusBoard', 'model_id'=>$board['id']))->order('id desc')->find();
		}


		$op = empty($_REQUEST['op']) ? '' : trim($_REQUEST['op']);
		if ('export' == $op) {
		}

		$this->assign('flow_info', $flow_info);
		$this->assign('item_list', $item_list);
		$this->assign('owner_list', $owner_list);

		$this->assign('board_list', $board_list);

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
				//self::send_mail('board', $board_id);
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
			$info['owner_opts'] = self::genOptions(M('Staff')->where(array('status'=>1))->order('realname')->select(), $info['owner_id'], 'realname');

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
	public function revision() {
		$RevArray = array(
			'Software' => 'Software Rev',
			'Logic' => 'Logic Rev',
			'FCT' => 'FCT Rev',
			'Host' => 'Host Rev'
		);
		$RevSort = array(
			'Software' => 1,
			'Logic' => 2,
			'FCT' => 3,
			'Host' => 4
		);
		$this->assign('RevArray', $RevArray);
		$status_id = empty($_REQUEST['status_id']) ? 0 : intval($_REQUEST['status_id']);
		$this->assign('status_id', $status_id);
		$board_id = empty($_REQUEST['board_id']) ? 0 : intval($_REQUEST['board_id']);
		$this->assign('board_id', $board_id);

		if (!empty($_POST['submit'])) {
			if (!empty($_REQUEST['field'])) {
				foreach ($_REQUEST['field'] as $i=>$field) {
					if (''==trim($field) || ''==trim($_REQUEST['value'][$i])) {
						continue;
					}
					if (array_key_exists(trim($field), $RevArray)) {
						self::_error('The field name: "'.$field.'" is not allowed');
					}
					$data = array(
						'board_id' => $board_id,
						'status_id' => $status_id,
						'field' => $field,
						'value' => trim($_REQUEST['value'][$i]),
						'sort' => 10,
						'staff_id' => $_SESSION[C('USER_AUTH_KEY')],
						'update_time' => date('Y-m-d H:i:s')
					);
					if (!M('StatusRevision')->add($data)) {
						self::_error('Add ext revision entry fail!<br />'.$this->dao->getLastSql());
					}
				}
			}
			if (!empty($_REQUEST['_field'])) {
				foreach ($_REQUEST['_field'] as $i=>$field) {
					if (''==trim($_REQUEST['_value'][$i])) {
						continue;
					}
					$data = array(
						'board_id' => $board_id,
						'status_id' => $status_id,
						'field' => $field,
						'value' => trim($_REQUEST['_value'][$i]),
						'sort' => $RevSort[$field],
						'staff_id' => $_SESSION[C('USER_AUTH_KEY')],
						'update_time' => date('Y-m-d H:i:s')
					);
					if (!M('StatusRevision')->add($data)) {
						self::_error('Add revision entry fail!<br />'.$this->dao->getLastSql());
					}
				}
			}
			if (!empty($_REQUEST['_id'])) {
				foreach ($_REQUEST['_id'] as $id=>$value) {
					if (empty($id)) {
						continue;
					}
					$dao = M('StatusRevision');
					$dao->find($id);
					if (''==trim($value)) {
						//delete the entry
						$dao->delete();
					}
					else {
						if ($dao->value == trim($value)) {
							continue;
						}
						$dao->value = trim($value);
						$dao->update_time = date('Y-m-d H:i:s');
						if (false === $dao->save()) {
							self::_error('Update revision entry fail!<br />'.$this->dao->getLastSql());
						}
					}
				}
			}
			$value = intval($_REQUEST['status']);
			if ($board_id > 0) {
				//改变Board状态
				$dao = M('StatusBoard');
				$info = $dao->find($board_id);
				if ($info['status'] != $value) {
					$dao->where('id='.$board_id)->setField(array('status', 'update_time'), array($value, date('Y-m-d H:i:s')));
					self::write_log('Manually', 'Change finnal status of Board('.$info['id'].': '.$info['name'].') from ['.$this->status_arr[$info['status']].'] to ['.$this->status_arr[$value].']');
				}
			}
			elseif ($status_id > 0) {
				//改变Status状态
				$dao = M('StatusStatus');
				$info = $dao->find($status_id);
				$item = M('StatusItem')->find($info['item_id']);
				$board = M('StatusBoard')->find($info['board_id']);
				if ($info['status'] != $value) {
					$dao->where("id=".$status_id)->setField(array('status', 'update_time'), array($value, date('Y-m-d H:i:s')));
					self::write_log('Manually', 'Change status of Item('.$item['id'].': '.$item['name'].') of Board('.$board['id'].': '.$board['name'].') from ['.$this->status_arr[$info['status']].'] to ['.$this->status_arr[$value].']');
				}

				if (1==$value || $value!=$board['status']) {
					if (-1==$value) {
						//没有Fail和Pending，None=>None
						if ($dao->where("board_id=".$info['board_id']." and (status=0 or status=2)")->count()==0) {
							M('StatusBoard')->where("id=".$info['board_id'])->setField(array('status', 'update_time'), array($value, date('Y-m-d H:i:s')));
							self::write_log('Automatically', 'Change final status of Board('.$board['id'].': '.$board['name'].') from ['.$this->status_arr[$board['status']].'] to ['.$this->status_arr[$value].']');
						}
					}
					elseif (0==$value) {
						//没有Fail， Pending=>Pending
						if ($dao->where("board_id=".$info['board_id']." and status=2")->count()==0) {
							M('StatusBoard')->where("id=".$info['board_id'])->setField(array('status', 'update_time'), array($value, date('Y-m-d H:i:s')));
							self::write_log('Automatically', 'Change final status of Board('.$board['id'].': '.$board['name'].') from ['.$this->status_arr[$board['status']].'] to ['.$this->status_arr[$value].']');
						}
					}
					elseif (1==$value) {
						//如果所有Status都为Pass，则设置Board为Pass
						if ($dao->where("board_id=".$info['board_id'])->count() == $dao->where("board_id=".$info['board_id']." and status=1")->count()) {
							M('StatusBoard')->where('id='.$info['board_id'])->setField(array('status', 'update_time'), array($value, date('Y-m-d H:i:s')));
							self::write_log('Automatically', 'Change final status of Board('.$board['id'].': '.$board['name'].') from ['.$this->status_arr[$board['status']].'] to ['.$this->status_arr[$value].']');
						}
						elseif ($dao->where("board_id=".$info['board_id']." and (status=-1 or status=0 or status=2)")->count()==0) {
							M('StatusBoard')->where('id='.$info['board_id'])->setField(array('status', 'update_time'), array(9, date('Y-m-d H:i:s')));
							self::write_log('Automatically', 'Change final status of Board('.$board['id'].': '.$board['name'].') from ['.$this->status_arr[$board['status']].'] to ['.$this->status_arr[9].']');
						}
						elseif ($dao->where("board_id=".$info['board_id']." and status=0")->count()>0 && $dao->where("board_id=".$info['board_id']." and status=2")->count()==0) {
							M('StatusBoard')->where('id='.$info['board_id'])->setField(array('status', 'update_time'), array(0, date('Y-m-d H:i:s')));
							self::write_log('Automatically', 'Change final status of Board('.$board['id'].': '.$board['name'].') from ['.$this->status_arr[$board['status']].'] to ['.$this->status_arr[0].']');
						}
					}
					elseif (2==$value) {
						//设置Board状态为Failed
						M('StatusBoard')->where('id='.$info['board_id'])->setField(array('status', 'update_time'), array($value, date('Y-m-d H:i:s')));
						self::write_log('Automatically', 'Change final status of Board('.$board['id'].': '.$board['name'].') from ['.$this->status_arr[$board['status']].'] to ['.$this->status_arr[$value].']');
					}
					elseif (8==$value) {
						//如果没有None、Pending、Fail了
						if ($dao->where("board_id=".$info['board_id']." and (status=-1 or status=0 or status=2)")->count()==0) {
							if ($dao->where("board_id=".$info['board_id']." and status=1")->count()>0) {
								//至少有一个Pass，则设置Board为Pass*
								M('StatusBoard')->where('id='.$info['board_id'])->setField(array('status', 'update_time'), array(9, date('Y-m-d H:i:s')));
								self::write_log('Automatically', 'Change final status of Board('.$board['id'].': '.$board['name'].') from ['.$this->status_arr[$board['status']].'] to ['.$this->status_arr[9].']');
							}
							else {
								//没有Pass，那么全部为Ignore
								M('StatusBoard')->where('id='.$info['board_id'])->setField(array('status', 'update_time'), array(8, date('Y-m-d H:i:s')));
								self::write_log('Automatically', 'Change final status of Board('.$board['id'].': '.$board['name'].') from ['.$this->status_arr[$board['status']].'] to ['.$this->status_arr[8].']');
							}
						}
					}
				}
			}

			self::_success('Revision and Status updated!');
		}

		$result = array();
		if (!empty($status_id)) {
			$where = "status_id=".$status_id;
			$result['Status'] = D('StatusStatus')->relation(true)->find($status_id);
		}
		if (!empty($board_id)) {
			$where = "board_id=".$board_id;
			$result['Status'] = D('StatusBoard')->relation(true)->find($board_id);
		}

		$rs = M('StatusRevision')->where($where)->order('sort')->select();
		empty($rs) && ($rs = array());
		$result['System'] = array_fill_keys(array_keys($RevArray), '');
		$result['User'] = array();
		foreach ($rs as $i=>$row) {
			if (array_key_exists($row['field'], $RevArray)) {
				$result['System'][$row['field']] = $row;
			}
			else {
				$result['User'][$row['field']] = $row;
			}
		}
		$this->assign('result', $result);

		$this->assign('content', ACTION_NAME);
		$this->display('Layout:content');
	}
	public function update() {
		$board_id = empty($_REQUEST['board_id']) ? 0 : intval($_REQUEST['board_id']);
		$status_id = empty($_REQUEST['id']) ? 0 : intval($_REQUEST['id']);
		$field = $_REQUEST['f'];
		$value = $_REQUEST['v'];
		$rs = true;
		if ($board_id > 0) {
			//改变Board表栏位
			$dao = M('StatusBoard');
			$info = $dao->find($board_id);
			if ($info[$field] != $value) {
				$rs = $dao->where('id='.$board_id)->setField(array($field, 'update_time'), array($value, date('Y-m-d H:i:s')));
			}
		}
		elseif ($status_id > 0) {
			//改变Status表栏位
			$dao = M('StatusStatus');
			$info = $dao->find($status_id);
			$old_value = $info[$field];
			if ($info[$field] != $value) {
				$rs = $dao->where("id=".$status_id)->setField(array($field, 'update_time'), array($value, date('Y-m-d H:i:s')));
				if ('owner_id'==$field || 'substitute_id'==$field) {
					$old_owner = M('Staff')->where("id=".$old_value)->getField('realname');
					$new_owner = M('Staff')->where("id=".$value)->getField('realname');
					$item = M('StatusItem')->find($info['item_id']);
					$board = M('StatusBoard')->find($info['board_id']);
					self::write_log('Manually', 'Change the '.str_replace('_id', '', $field).' of Item('.$item['id'].': '.$item['name'].') of Board('.$board['id'].': '.$board['name'].') from ['.$old_owner.'] to ['.$new_owner.']');
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
	public function _mail($type='board', $id='') {
		if (!defined('APP_ROOT')) {
			define('APP_ROOT', 'http://'.$_SERVER['SERVER_ADDR'].__APP__);
		}
		$smtp_config = C('_smtp_');
		include_once (LIB_PATH.'class.phpmailer.php');
		$mail = new PHPMailer();
		$mail->IsSMTP();
	//	$mail->SMTPDebug  = 1;  // 2 = messages only
		$mail->Host       = $smtp_config['host'];
		$mail->Port       = $smtp_config['port'];
		$mail->SetFrom($smtp_config['from_mail'], 'ERP System');

		switch ($type) {
			case 'flow':
				$board_arr = D('StatusBoard')->where("flow_id=".$id." and status<=0")->select();
				foreach ($board_arr as $board) {
					self::_mail('board', $board['id']);
				}
			case 'board':
				$board = D('StatusBoard')->relation(true)->find($id);
				//to board owner
				$rs = M('Staff')->find($board['owner_id']);
				//$mail->AddAddress($rs['email'], $rs['realname']);

				//to all item owner
				$status = D('StatusStatus')->relation(true)->where("board_id=".$id)->select();

				$style = '<style>'."\n";
				$style .= 'strong.None{color: #808080;}'."\n";
				$style .= 'strong.Pass{color: #339900;}'."\n";
				$style .= 'strong.Pending{color: #0000FF;}'."\n";
				$style .= 'strong.Failed{color: #FF0000;}'."\n";
				$style .= '</style>'."\n";
				$body = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><body>'."\n";
				$body .= '<table cellpadding="5" border="1" style="border-collapse:collapse;border:1px solid #666666;">'."\n";
				$body .= '<tr bgcolor="#CCCCCC">'."\n";
				$body .= '<td colspan="2">Board Status Detail</td>'."\n";
				$body .= '</tr>'."\n";
				$body .= '<tr><td width="120">Flow Name:</td><td><a href="'.APP_ROOT.'/Status/flow/id/'.$board['flow_id'].'" target="_blank">'.$board['flow']['name'].'</a></td></tr>'."\n";
				$body .= '<tr><td>Board Name:</td><td><a href="'.APP_ROOT.'/Status/board/id/'.$board['id'].'" target="_blank">'.$board['name'].'</a></td></tr>'."\n";
				$body .= '<tr><td>Board Information:</td><td>'.nl2br($board['info']).'</td></tr>'."\n";
				$body .= '<tr><td>Owner:</td><td>'.$board['owner']['realname'].'</td></tr>'."\n";
				$body .= '<tr><td>Create Time:</td><td>'.$board['create_time'].'</td></tr>'."\n";
				$body .= '<tr><td>Item Status:</td><td>'."\n";
				$body .= '<table cellpadding="3" border="1" style="border-collapse:collapse;border:1px solid #999999;">'."\n";
				$body .= '<tr bgcolor="#DDDDDD"><th>No.</th><th>Test Item</th><th>Owner</th><th>Status</th></tr>'."\n";
				foreach ($status as $i=>$row) {
					$body .= '<tr';
					if ($row['status'] < 1) {
						$body .= ' class="staff_'.(empty($row['substitute_id'])?$row['owner_id']:$row['substitute_id']).'"';
					}
					$body .= '>'."\n";
					$body .= '<td align="center">'.($i+1).'</td>'."\n";
					$body .= '<td nowrap="nowrap">'.$row['item']['name'].'</td>'."\n";
					$body .= '<td nowrap="nowrap">'.$row['owner']['realname'];
					if (!empty($row['substitute_id'])) {
						$body .= '<img src="'.APP_ROOT.'/../..'.APP_PUBLIC_PATH.'/Images/105.png" alt=" -> " align="absmiddle"/>'.$row['substitute']['realname'];
					}
					$body .= '</td>';
					$body .= '<td><strong class="'.$this->status_arr[$row['status']].'">'.$this->status_arr[$row['status']].'</strong></td></tr>'."\n";
				}
				$body .= '</table>'."\n";
				$body .= '</td></tr></table>'."\n";
				$body .= '<br /><br />For more information, please visit <a target="_blank" href="'.APP_ROOT.'/Status">ERP System -> Board Status</a>';
				$body .= '<br /><br />Best Regards,<br />'.C('ERP_TITLE');
				$body .= '</body></html>';
				foreach ($status as $i=>$row) {
					if ($row['status'] > 0) {
						continue;
					}
					$subject = '[Board Status]: ['.$board['flow']['name'].'] need ['.(empty($row['substitute_id'])?$row['owner']['realname']:$row['substitute']['realname']).'] to update the test status';
					$style2 = '<style>.staff_'.(empty($row['substitute_id'])?$row['owner_id']:$row['substitute_id']).'{background-color:#ffff66;}</style>';
					$header = 'Hi '.(empty($row['substitute_id'])?$row['owner']['realname']:$row['substitute']['realname']).',<br />'."\n";
					$header .= '&nbsp;&nbsp;The below rows in yellow need you to update.<br />'."\n";

					$mail->ClearAddresses();
					if (empty($row['substitute_id'])) {
						$mail->AddAddress($row['owner']['email'], $row['owner']['realname']);
					}
					else {
						$mail->AddAddress($row['substitute']['email'], $row['substitute']['realname']);
					}
					$mail->Subject = $subject;
					$mail->MsgHTML($style.$style2.$header.$body);
					$debug = 'type='.$type.', board_id='.$id.', item_id='.$row['item_id'].', owner_id='.$row['owner_id'].', substitute_id='.$row['substitute_id'];
					if(!$mail->Send()) {
						Log::Write('Mail status Error: '.$debug."\n".$mail->ErrorInfo, LOG::ERR);
					}
					echo $debug."\n";
					Log::Write('Mail status Success: '.$debug, LOG::INFO);
				}
				break;

			default :
				//
		}
	}
	public function send_mail() {
		$type=$_REQUEST['type'];
		$id = $_REQUEST['id'];
		self::_mail($type, $id);
	}
	public function write_log($type, $content) {
		$data = array(
			'type' => $type,
			'action_time' => date('Y-m-d H:i:s'),
			'staff_id' =>  $_SESSION[C('USER_AUTH_KEY')],
			'content' => $content
			);
		if (!M('StatusLog')->add($data)) {
			self::_error('Add log fail!<br />'.$this->dao->getLastSql());
		}
	}
	public function read_log() {
		Session::set('sub', MODULE_NAME.'/'.ACTION_NAME);
		$dao = D('StatusLog');

		$this->assign('request', $_REQUEST);

		import("@.Paginator");
		$limit = 50;
		if (!empty($_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_limit'])) {
			$limit = $_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_limit'];
		}
		if (!empty($_REQUEST['limit'])) {
			$limit = $_REQUEST['limit'];
		}
		$_SESSION[MODULE_NAME.'_'.ACTION_NAME.'_limit'] = $limit;

		$where = array();
		if (isset($_REQUEST['staff_id'])) {
			$staff_id = intval($_REQUEST['staff_id']);
		}
		$staff_arr = $dao->join("Inner Join erp_staff on erp_staff.id=erp_status_log.staff_id")->distinct(true)->field("erp_staff.id as id, erp_staff.realname as realname")->order("realname")->select();
		$this->assign('staff_opts', self::genOptions($staff_arr, $staff_id, 'realname'));
		if (!empty($staff_id)) {
			$where['staff_id'] = $staff_id;
		}

		!empty($_REQUEST['from']) && ($where['action_time'] = array('egt', $_REQUEST['from']));
		!empty($_REQUEST['to']) && ($where['action_time'] = array('lt', $_REQUEST['to']));
		
		$count = $dao->where($where)->getField('count(*)');
		$p = new Paginator($count,$limit);

		$rs = $dao->relation(true)->where($where)->order('id desc')->limit($p->offset.','.$p->limit)->select();
		
		$this->assign('result', $rs);
		$this->assign('page', $p->showMultiNavi());
		$this->assign('content', ACTION_NAME);

		$this->assign('ACTION_TITLE', 'Operation Log');
		$this->display('Layout:ERP_layout');

	}
}
?>