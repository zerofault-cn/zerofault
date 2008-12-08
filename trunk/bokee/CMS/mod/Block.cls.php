<?php

/**
 * Block.cls.php
 * @author  Liut@bokee.com
 * @version  1.0
 * @abstract  区块类
 * @copyright bokee dot com
 */

require_once('sql/DAO.cls.php');

class block
{
	/**
	* @member varibles with default value 
	*/

	/**
	* @access private
	*/
	var $_mark = 0;
	/**
	* @access private
	*/
	var $_block_id = 0;
	/**
	* @access private
	*/
	var $_block_content;
	/**
	* @access private
	*/
	var $_subject_id = 0;
	/**
	* @access private
	*/
	var $_special_id = -1;
	/**
	* @access private
	*/
	var $_special_subject_id = -1;	
	/**
	* @access private
	* @Block data string
	*/
	var $_blockstr;
	/**
	* @access private
	* @Block Data Map
	*/
	var $_block_map;
	/**
	* @access private
	* @Block Data Format
	*/
	var $_block_format;
	/**
	* @access private
	* @Block Name
	*/
	var $_block_name;
	/**
	* @access private
	* @Block's action
	*/
	var $_action;

	/**
	* @Block's sample fields
	*/
	var $_sample_fields = array("title","sub_title","create_time","media_name","author","description","view_num","comment_num","remote_url");

	/**
	* @access public
	* @abstract Constructor
	* @param string $channel_db($channel_db)
	* @param string $block_type
	* @param int $block_id
	*/
	function block()
	{
		if(func_num_args() == 0)
		{			
			$this->_db = "cms_life";
		}
		else
		{
			$this->_db = func_get_arg(0);
		}
		$this->_block_type = 'general';
	}


	/**
	* @access public
	* @abstract get a block id from request
	*/
	function getId()
	{
		if(!empty($_REQUEST['id']))
		{
			$this->setId(trim($_REQUEST['id']));
		}
	}

	/**
	* @access public
	* @abstract get a block name from request
	*/
	function getName()
	{
		if(!empty($_POST['blockname']))
		{
			$this->setName(trim($_POST['blockname']));
		}
	}

	/**
	* @access public
	* @abstract get a block data string from request
	*/
	function getData()
	{
		if(!empty($_POST['hiddenValue']))
		{
			$this->setData(trim($_POST['hiddenValue']));
		}
	}

	/**
	* @access public
	* @abstract get a block format from request
	*/
	function getFormat()
	{
		if(!empty($_POST['format']))
		{
			$this->setFormat(trim($_POST['format']));
		}
	}
	/**
	* @access public
	* @abstract 根据 ID 删除模板
	*/
	function DeleteByID($id)
	{
		$id = empty($id)?0:$id;
		$sql = "delete from template_block where id=" . $id;
		if(!$this->Query($sql))
		{
			Log::Append("文件:" . __FILE__ . " 第 " . __LINE__ . " 行附近出错。" . $sql);
			return false;
		}
		return true;
	}

	/**
	* @access public
	* @set the sample field of the block
	*/
	function setSampleField()
	{
		switch($this->_block_type)
		{
			case 'general':
				$this->_sample_fields = array("title","sub_title","create_time","media_name","author","remote_url","view_num","comment_num");
				break;
			case 'hasImage':
				$this->_sample_fields = array("image" => array());
				break;
		}
	}

	/**
	* @access public
	* @abstract set channel id of the block
	*/
	function setSubject($subject_id)
	{
		$this->_subject = $subject_id;
	}

	/**
	* @access public
	* @abstract set block id of the block
	*/
	function setId($id)
	{
		$this->_block_id = $id;
	}

	/**
	@access public
	@abstract set block name
	*/
	function setName($str)
	{
		$this->_block_name = $str;
	}

	/**
	@access public
	@abstract setting a block string
	*/
	function setData($str)
	{
		$this->_blockstr = $str;
	}

	/**
	@access public
	@abstract setting a block data format
	*/
	function setFormat($str)
	{
		$this->_block_format = $str;
	}

	/**
	@access public
	@abstract setting a block data format
	*/
	function setContent($str)
	{
		$this->_block_content = $str;
	}

	/**
	* @access public
	* @abstract set the action type of the block(add or save)
	*/
	function setAction($action)
	{
		$this->_action = $action;
	}

	/**
	* @access public
	* @abstract get a block data from DB by id
	*/
	function getBlock()
	{
		return $result = $this->fetchSample($this->_block_id);
	}
	/**
	* @access private
	* @abstract parse a data map from block string
	*/
	function parseMap()
	{
		//print $this->_block_content;
		//exit;
		if(preg_match('#^SELECT(?P<FIELDS>[^A-Z]*).*WHERE(?P<CONDITION>.*)ORDER BY(?P<ORDERBY>[^A-Z]*)\s+(?P<SEQUENCE>[^\s]*)\s+LIMIT(?P<LIMIT>.*)#',$this->_block_content,$tmp))
		{
//			print_r($tmp);
			$this->_sample_fields = trim($tmp['FIELDS']);
			$this->_block_map['FIELDS'] = explode(",",trim($tmp['FIELDS']));
			for($i=0;$i<count($this->_block_map['FIELDS']);$i++)
			{
				$this->_block_map['FIELDS'][$i] = substr(trim($this->_block_map['FIELDS'][$i]),2);
			}
			
			$this->_block_map['CONDITION'] = preg_split("#AND#",trim($tmp['CONDITION']));
			$this->_block_map['ORDERBY'] = substr(strstr(trim($tmp['ORDERBY']),"."),1);
			$this->_block_map['SEQUENCE'] = trim($tmp['SEQUENCE']);
			$this->_block_map['LIMIT'] = trim($tmp['LIMIT']);

			if(!is_array($this->_block_map['CONDITION']))
			{
				$temp = preg_split("#=#",$this->_block_map['CONDITION']);
				$key = "_".trim($temp[0]);
				$value = trim($temp[1]);
				$this->$key = $value;
			}
			else
			{
				preg_match("#\((\d),.*\)#isU",$this->_block_map['CONDITION'][0],$first);
				$this->_subject_id = $first[1];
				preg_match_all("#r.source\s\=\s\"(\w*)\"#isU",$this->_block_map['CONDITION'][1],$second);
				$this->_source = $second[1];
				$this->_mark = trim(substr(strstr($this->_block_map['CONDITION'][2],"="),1));
			}
		}
	}

	/**
	* @access private
	* @abstract parse a block string into block data map
	*/
	function parse()
	{
//		echo $this->_blockstr."<br>";
		if(!preg_match_all("#\{\w+(?:\s*\=\s*[\w|\d]+)?\}#i",$this->_blockstr,$array))
		{
			return $blockMap;
		}
		foreach($array[0] as $v)
		{
			if(preg_match("|\b(?P<key>\w+)\s*=\s*(?P<value>.*)\b|",$v,$matches))
			{
				$k = $matches['key'];
				if($k != "LIMIT" && $k != "ORDERBY" && $k != "SEQUENCE")
				{
					if($k == "FROM")
					{
						$source = preg_split("#\|#isU",$matches['value'],-1,PREG_SPLIT_NO_EMPTY);
						$matches['value'] = "";
						for($i=0;$i<count($source);$i++)
						{
							$matches['value'] .= "r.source = \"" . $source[$i] . "\" OR ";
						}

						$matches['value'] = substr($matches['value'],0,-4);
					}
					if($k == "mark")
					{
						$k = "a.mark";
					}
					$blockMap['CONDITION'][$k] = $matches['value'];
				}
				else
				{
					$blockMap[$k] = $matches['value'];
				}
			}
			else
			{
				$blockMap['FIELDS'][] = preg_replace("#\{(\w+)\}#","\\1",$v);
			}
		}

		return $blockMap;
	}

	/**
	* @access private
	* @abstract add a map(relies on the DAO API)
	*/
	function addMap()	
	{
		$subject_array = array();
		if($this->_block_map['FIELDS'] < 1)
		{
			$content = "";
		}
		else
		{
			for($i=0;$i<count($this->_block_map['FIELDS']);$i++)
			{
				//Sigh...
				if($this->_block_map['FIELDS'][$i] == "create_time")
				{
					$this->_block_map['FIELDS'][$i] = "r.datetime";
				}
				else
				{
					$fields .= "a.".$this->_block_map['FIELDS'][$i].", ";
				}
			}
			$fields .= "r.datetime ";

//			print_r($this->_block_map);

			$source = "(";

			foreach($this->_block_map['CONDITION'] as $k => $v)
			{
				if($k == "a.mark")
				{
					$mark = $k . " <= " . $v;
				}

				if ($k == "special_subject_id")
				{
					$v = fmod($v,100);
				}

				if($k == "FROM")
				{
					$source .= $v." OR ";
					continue;
				}

				if($k == "subject_id")
				{
					$sql = "SELECT id,parent_id FROM subject ORDER BY id DESC";
					$row_subject_array = $this->Query($sql);
					$subject_array = $this->findSubject($v,$row_subject_array);
					array_unshift($subject_array,array("id" => $v));

					for($i=0;$i<count($subject_array);$i++)
					{
						$subject_id .= $subject_array[$i]['id'].", ";
					}

					$type = "subject";
					continue;
				}
				$condition .= $k." = ".$v." AND ";
			}

			$subject_id = substr($subject_id,0,-2);
			$condition = substr($condition,0,-5);
			$source = substr($source,0,-4);
			$source .= ")";
			$limit = "LIMIT ".$this->_block_map['LIMIT'];
			$sequence = " ".$this->_block_map['SEQUENCE']." ";

			if($type != "subject")
			{
				//$orderby = " ORDER BY ".$this->_block_map['ORDERBY'];
				$content = "SELECT " . $fields ." FROM article a WHERE " . $condition . $orderby . $sequence . $limit;
			}
			else
			{
				$orderby = " ORDER BY r.datetime DESC ";
				//$orderby = " ORDER BY r.datetime DESC ";
				//$content = "SELECT " . $fields . " FROM article a, rel_article_subject r WHERE r.subject_id IN (".$subject_id.") AND " . $source . " AND " . $condition . " AND r.article_id = a.id ". $orderby . $sequence . $limit;
				$content = "SELECT " . $fields . " FROM article a, rel_article_subject r WHERE r.subject_id IN (".$subject_id.") AND " . $source . " AND " . $mark . " AND r.article_id = a.id ". $orderby . $limit;
			}
		}

		$this->blockSQL['name'] = $this->_block_name;		
		$this->blockSQL['format'] = $this->_block_format;
		$this->blockSQL['content'] = $content;

		if($this->_block_id != "")
		{
			$this->block_stage = "编辑区块成功";
			$query_type = "Update";
			$addtype = "UPDATE template_block SET ";
			$addcondition = " WHERE id = " . $this->_block_id . " ";
		}
		else
		{
			$this->block_stage = "添加区块成功";
			$query_type = "Insert";
			$addtype = "INSERT INTO template_block SET ";
			$addcondition = "";
		}

		foreach($this->blockSQL as $field => $value)
		{
			$query_sql .= $field . " = '" . $value . "', ";
		}

		$query_sql = $addtype . substr($query_sql,0,-2) . $addcondition . " ";
		$dao = DAO::CreateInstance();
		$dao->assoc = true;
		$dao->SetCurrentSchema($this->_db);
//		die($query_sql);
		$dao->$query_type($query_sql);

		$this->lastId = $dao->LastID();
		return true;
	}

	/**
	* @access private
	* @abstract fetch sample article from db for specify block
	*/
	function fetchSample($block_id = -1)
	{
		if($block_id > 0)
		{
			$this->_block_id = $block_id;
			$dao = DAO::CreateInstance();
			$dao->assoc = true;
			$dao->SetCurrentSchema($this->_db);

			$sql = "SELECT * FROM template_block WHERE id = '".$this->_block_id."' LIMIT 1";	

			$row_block = $dao->GetRow($sql);
			$this->setFormat($row_block['format']);
			$this->setName($row_block['name']);
			$this->setContent($row_block['content']);

			$this->parseMap();
		}



		$dictionary = array("subject" => "频道",
							"title" => "标题",
							"create_time" => "发表日期",
							"author" => "作者",
							"media_name" => "来源媒体",
							"comment_num" => "评论数");

		$dao = DAO::CreateInstance();
		$dao->assoc = true;
		$dao->SetCurrentSchema($this->_db);

		$subject_array = $this->getSubject($this->getSubjectList());
		$special_array = $this->getSpecialList();

		if($this->_subject_id > 0)
		{
			for($i=0;$i<count($subject_array);$i++)
			{
				if($subject_array[$i]['id'] == $this->_subject_id)
				{
					$subject_array[$i]['selectflag'] = "SELECTED";
				}
				continue;
			}
			$where_clause = " WHERE subject_id = " .$this->_subject_id ." ";
		}
		elseif($this->_special_id > 0)
		{
			for($i=0;$i<count($special_array);$i++)
			{
				if(!isset($special_array[$i]['spcial_id']))
				{
					if($special_array[$i]['id'] == $this->_special_id)
					{
						$special_array[$i]['selectflag'] = "SELECTED";
					}
				}
				continue;
			}
			$where_clause = " WHERE special_id = " .$this->_special_id ." ";
		}
		elseif($this->_special_subject_id > 0)
		{
			for($i=0;$i<count($special_array);$i++)
			{
				if(isset($special_array[$i]['special_id']))
				{
					if(fmod($special_array[$i]['id'],100) == $this->_special_subject_id)
					{
						
						$special_array[$i]['selectflag'] = "SELECTED";
						continue;
					}
				}
			}
			$where_clause = " WHERE special_subject_id = " .$this->_special_subject_id ." ";
		}
		else
		{
			$subject_array[$this->_subject_id]['selectflag'] = "SELECTED";
			$where_clause = "";
		}

		$sql = "SELECT title,remote_url,author,create_time,comment_num,media_name,mark FROM article ".$where_clause." ORDER BY create_time DESC LIMIT 1";
		


		$row = $dao->GetRow($sql);

		if(!$row)
		{
			$sql = "SELECT title, sub_title, remote_url, author, create_time, comment_num, media_name,mark FROM article ORDER BY create_time DESC LIMIT 1";
					
			$row = $dao->GetRow($sql);
		}

		$dao->Disconnect();
		
		foreach($row as $k => $v)
		{
			
			if($k != "mark" && $k != "remote_url")
			{
				$result['field'] .= $k . " : {data : " . "\"" . $v . "\",flag : false},\n";
				$result['html']['field'][] = array("key" => $k,
												   "tip" => $dictionary[$k],
												   "selectflag" =>$this->isThisSelected($k,$this->_block_map['FIELDS'])?"CHECKED":"");
				/*
				$result['html']['orderBy'][] = array("key" => $k,
													 "tip" => $dictionary[$k],
													 "selectflag" =>$this->isThisSelected($k,$this->_block_map['ORDERBY'])?"SELECTED":"");
													 */
			}
		}
		$result['field'] = substr($result['field'],0,-2);
		$source_array = array("cms","blog","column","rss","blogmark");
		for($i=0;$i<count($source_array);$i++)
		{
			$checkthis = false;
			for($j=0;$j<count($this->_source);$j++)
			{
				if($source_array[$i] == $this->_source[$j])
				{
					$checkthis = true;
					break;
				}
			}
			if($checkthis)
			{
				$result['source'] .= $source_array[$i]." : true, ";
			}
			else
			{
				$result['source'] .= $source_array[$i]." : false, ";
			}
		}
		$result['source'] = substr($result['source'],0,-2);
		$result['html']['mark'] = array(array('key' => "1",'selectflag' => ""),
										array('key' => "2",'selectflag' => ""),
										array('key' => "3",'selectflag' => ""),
										array('key' => "4",'selectflag' => ""),
										array('key' => "5",'selectflag' => "")
										);
		if($this->_mark - 1 >= 0)
		{
			$result['html']['mark'][($this->_mark) - 1]['selectflag'] = "SELECTED";
		}
		else
		{
			$result['html']['mark'][0]['selectflag'] = "SELECTED";
		}

		$result['html']['orderBy'] = $this->selectDefault($result['html']['orderBy']);

		$result['html']['value']['block_id'] = $this->_block_id;
		$result['html']['value']['block_name'] = $this->_block_name;
		$result['html']['value']['block_format'] = $this->_block_format;
		$result['html']['value']['content_limit'] = $this->_block_map['LIMIT'] == ""?"5":$this->_block_map['LIMIT'];
		$result['html']['value']['content_desc'] = $this->_block_map['SEQUENCE'] == 'DESC'?'SELECTED':''; 
		$result['html']['value']['content_asc'] = $this->_block_map['SEQUENCE'] == 'ASC'?'SELECTED':''; 


		if($this->_block_stage == 'add')
		{
			$result['stage'] = '添加';
		}
		elseif($this->_block_stage == 'edit')
		{
			$result['stage'] = '编辑';
		}

		$result['html']['subject'] = $subject_array;

		$result['html']['special'] = $special_array;
		
		return $result;
	}

	/*
	* @access private
	* @
	*/
	function selectDefault($property)
	{
		for($i=0;$i<count($property);$i++)
		{
			$isSelected .= $property[$i]['selectflag'];
		}


		if ($isSelected == "")
		{
			$property[0]['selectflag'] = "SELECTED";
		}

		return $property;
	}
	/**
	* @access private
	* @abstract 
	*/
	function isThisSelected($item,$array)
	{
		if(is_array($array))
		{
			foreach($array as $v)
			{
				if ($item == $v)
				{
					return true;
				}
			}
			
			return false;
		}
		else
		{
			return $item == $array?true:false;
		}
	}

	/**
	* @access private
	* @abstract get subject-list for specify channel 
	*/
	function getSubjectList($parent_id = 0,$prefix = "")
	{
		$sql = "SELECT id,name FROM subject WHERE parent_id = ".$parent_id." ORDER BY id,parent_id DESC";
		$temp = $this->Query($sql);

		for($i=0;$i<count($temp);$i++)
		{
			if($parent_id == 0)
			{
				$temp[$i]['prefix'] = $prefix;
			}
			else
			{
				$temp[$i]['prefix'] = $prefix . "-";
			}
			$subject .= "id:".$temp[$i]['id']."#name:".$temp[$i]['name']."#prefix:".$temp[$i]['prefix']."Tarkus";
			$subject .= $this->getSubjectList($temp[$i]['id'],$temp[$i]['prefix']);

		}

		return $subject;
	}

	/**
	* @access private
	* @abstract get special-list for specify channel 
	*/
	function getSpecialList($parent_id = 0,$prefix = "")
	{
		$sql = "SELECT id,name FROM special ORDER BY id DESC";
		$array = $this->Query($sql);

		$tmp = count($array);

		for($i=0;$i<$tmp;$i++)
		{
			$array[$i]['type'] = "special_id";
			$array[$i]['prefix'] = "";
			$result[] = $array[$i];
			$sql = "SELECT * FROM special_subject WHERE special_id = ".$array[$i]['id']." ORDER BY id DESC";

			$sub_array = $this->Query($sql);
				
			if(count($sub_array) > 0)
			{
				for($j=0;$j<count($sub_array);$j++)
				{
					$sub_array[$j]['type'] = "special_subject_id";
					$sub_array[$j]['name'] = $array[$i]['name']."::".$sub_array[$j]['name'];
					$sub_array[$j]['prefix'] = "-";
					$sub_array[$j]['id'] = $sub_array[$j]['id'] + 100 * $array[$i]['id'];

					$result[] = $sub_array[$j];
				}
			}
		}

		return $result;
	}

	/**
	* @access private
	* @abstract get subjects data
	*/
	function getSubject($subject)
	{
		$array = explode("Tarkus",trim($subject));
		for($i=0;$i<count($array) - 1;$i++)
		{
			$temp = explode("#",$array[$i]);
			foreach($temp as $v)
			{
				$tmp = explode(":",$v);
				$key = $tmp[0];
				$value = $tmp[1];
				$result[$i][$key] = $value;
				$result[$i]['type'] = "subject_id";
			}
		}
		return $result;
	}

	/**
	* @access public
	* @abstract Interface :: action handle for addBlock
	*/
	function addBlock()
	{		
		$this->block_stage = "添加区块";
		$this->_subject_id = isset($_REQUEST['subject_id'])?$_REQUEST['subject_id']:$this->_subject_id;
		$this->_special_id = isset($_REQUEST['special_id'])?$_REQUEST['special_id']:$this->_special_id;
		$this->_special_subject_id = isset($_REQUEST['special_subject_id'])?$_REQUEST['special_subject_id']:"";
		return $this->fetchSample();
	}

	/**
	* @access public
	* @abstract Interface :: action handle for editBlock
	*/
	function editBlock()
	{
		$this->block_stage = "编辑区块";
		$this->getId();		
		return $this->getBlock();
	}

	/**
	* @access public
	* @abstract Interface :: action handle for saveBlock
	*/
	function saveBlock()
	{
		$this->getName();
		$this->getData();
		$this->getFormat();
		$this->_block_map = $this->parse();
		$this->addMap();
	}

	/**
	* @access public 
	* @abstract list all blocks of the specify channel
	*/
	function getBlockList()
	{
		$sql = "SELECT id,name,content FROM template_block ORDER BY id DESC";
		$row = $this->Query($sql);
		for($i=0;$i<count($row);$i++)
		{
			if(!empty($row[$i]['content']))
			{
				if(preg_match("#LIMIT\s?(\d*)#",$row[$i]['content'],$matches))
				{
					$row[$i]['limit'] = $matches[1];
				}
			}
		}
		return $row;
	}

	/**
	* @access private
	* @abstract Helper Method :: Query : base on the DAO Object
	*/
	function Query($sql = "")
	{
		$dao = DAO::CreateInstance();
		$dao->assoc = true;
		$dao->SetCurrentSchema($this->_db);
		$result = $dao->GetPlan($sql);
		$dao->Disconnect();
		return $result;
	}

	/**
	* @access private
	* @abstract Helper Method :: findSubject
	*/
	function findSubject($id,$subject_array,$result_array = array())
	{
		static $result_index = 0;
		$temp_array = array();
		$index_array = array();
		foreach($subject_array as $index => $array)
		{
			if($id == $array['parent_id'])
			{
				$index_array[] = $index;
				$temp_array[] = $subject_array[$index];
				$result_array[$result_index] = $subject_array[$index];
				$result_index++;
			}
		}

		for($i=0;$i<count($index_array);$i++)
		{
			$index_value = $index_array[$i];
			unset($subject_array[$index_value]);
		}

		for($i=0;$i<count($temp_array);$i++)
		{
			$result_array = $this->findSubject($array[$i]['id'],$subject_array,$result_array);
		}
		return $result_array;
	}
}
?>