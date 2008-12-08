<?php

/**
 * Template.cls.php
 * @author  Liut@bokee.com
 * @version  1.0
 * @abstract  模板类
 * @copyright bokee dot com
 */

require_once('sql/DAO.cls.php');
require_once('mod/Block.cls.php');
require_once('com/UploadImg.cls.php');
require_once('com/Log.cls.php');

class Template
{
	/**
	* @access private
	* @abstract 
	*/
	var $_template_is_default;
	
	/**
	* @access private
	* @abstract template channel info
	*/
	var $_template_channel;

	/**
	* @access private
	* @abstract default template subject id is -1
	*/
	var $_template_subject_id = -1;
	
	/**
	* @access private
	* @abstract default template special id is -1
	*/	
	var $_template_special_id = -1;

	/**
	* @access private
	* @abstract default template special subject id is -1
	*/	
	var $_template_special_subject_id = -1;

	/**
	* @access private
	* @abstract default template id is 0
	*/
	var $_template_id = 0;

	/**
	* @access private
	* @abstract template original file directory
	*/
	var $_template_file_dir = "WEB-INF/html/templates/init/";

	/**
	* @access private
	* @abstract template directory
	*/
	var $_template_dir = "WEB-INF/html/templates/index/";

	/**
	* @access private
	* @abstract template name
	*/
	var $_template_name;

	/**
	* @access private
	*/
	var $_db;
	
	/**
	* @access public
	*/
	var $_template_file;

	/**
	* @access public
	*/
	var $_tpl_file;

	/**
	* @access public
	*/
	var $_template;	//for store the template info

	/**
	*/
	var $_template_image_dir = "web/images/index/";

	/**
	* @Constructor
	*/
	function template($db = "cms_life",$template_id = -1,$showAd = "false")	
	{
		$this->_db = $db;
		$this->showAd = $showAd;
		$this->_template_id = $template_id;
	}

	function QueryRow($sql = "",$db = "")
	{
		$dao = DAO::CreateInstance();
		$dao->assoc = true;
		$dao->SetCurrentSchema($this->_db);
		$result = $dao->GetRow($sql);
		$dao->Disconnect();
		return $result;
	}

	function QueryPlan($sql = "",$db = "")
	{
		$dao = DAO::CreateInstance();
		$dao->assoc = true;
		$dao->SetCurrentSchema($this->_db);
		$result = $dao->GetPlan($sql);
		$dao->Disconnect();
		return $result;
	}


	/**
	* @access public
	* @abstract get template file from form by channel name
	*/
	function getTemplateFileByPath($channel_name,$id)
	{
		$this->_template_id = $id;
		$this->_template_file = $this->_template_file_dir . "cms_" . $channel_name . "/".$id.".html";
	}

	/**
	* @access public
	* @abstract get template file from form by filename
	*/
	function getTemplateFileByName()
	{
		if(!empty($_REQUEST['name']))
		{
			$this->_template_file = urldecode($_REQUEST['name']);
			$this->_template_file = $this->locateTemplateFile();
		}
		else
		{
			die("没有选择任何模板文件");
		}
	}

	/**
	* @access public
	* @param $id
	*/
	function setTemplateId($id)
	{
		$this->_template_id = $id;
	}

	/**
	* @access public
	* @abstract get template data from db by id
	* @param $template_id
	*/
	function getTemplateById($template_id)
	{
		$this->_template_id = $template_id;
		$sql = "SELECT * FROM template WHERE id = ".$this->_template_id." LIMIT 1";
		if($row = $this->QueryRow($sql))
		{
			$this->_template_is_default = $row['is_default'];
			$this->_template_id = $row['id'];
			$this->_template_subject_id = $row['subject_id'];
			$this->_template_special_id = $row['special_id'];
			$this->_template_special_subject_id = $row['special_subject_id'];
			$this->_template_name = $row['name'];
			$this->_template_file = $row['path'];
			$this->file = $this->_template_file;
			$this->_tpl_path = $row['file_name'];
			$this->_tpl_file = $this->locateTplFile();
			return true;
		}
		return false;
	}

	/**
	* @access public
	* @abstract list templates
	*/
	function getTemplateList()
	{
		$dao = DAO::CreateInstance();
		$dao->assoc = true;
		$dao->SetCurrentSchema($this->_db);
		$sql = "SELECT distinct(name) as name,id FROM template ORDER BY id DESC";
		$row = $dao->GetPlan($sql);
		return $row;
	}

	/**
	* @access public
	* @abstract list template files
	*/
	function getFileList()
	{
		if($handle = opendir($this->_template_file_dir))
		{
			while(false !== ($file_name = readdir($handle)))
			{
				if (is_dir($this->_template_file_dir.$file_name) && $file_name != '.' && $file_name != '..' && $file_name != 'CVS')
				{
					$file[]['name'] = $file_name;
				}
			}
		}
		else
		{
			return false;
		}
		closedir($handle);
		return $file;
	}

	/**
	* @access public
	* @abstract list all blocks in this channel
	*/
	function getBlockList()
	{
		$block = new Block($this->_db);
		$block_array = $block->getBlockList();

		/*
		foreach($block_array as $block)
		{
			$this->block_list .= "<option value=".$block['id'].">".$block['name']."\n";
		}
		*/
		return $block_array;
	}

	/**
	* @access private
	* @param $file
	*/
	function loadFile($file)
	{
		if(!( $data = trim(stripslashes(file_get_contents($file))) ))
		{
			return false;
		}

		return $data;
	}

	/**
	* @access private
	* @param $original_content
	* @param $content
	* @param $tag
	* @param $tag_end
	* @param $pos
	*/
	function findEnd($original_content,$content,$tag,$tag_end,$pos = 0)
	{
		
		$pos = $pos + strpos($content,$tag_end);
		$pos = $pos + strlen($tag_end);
		$sub_left = substr($original_content,0,$pos);
		$sub_right = substr($original_content,$pos);
		$pattern = "#<".$tag."#isU";

		if(preg_match_all($pattern,$sub_left,$begin))
		{
			$tag_begin_count = count($begin[0]);
		}
		else
		{
			$tag_begin_count = -1;
		}

		$pattern = "#".$tag_end."#isU";
		if(preg_match_all($pattern,$sub_left,$end))
		{
			$tag_end_count = count($end[0]);
		}
		else
		{
			$tag_begin_count = -2;
		}

		if($tag_begin_count != $tag_end_count)
		{
			$pos = $this->findEnd($original_content,$sub_right,$tag,$tag_end,$pos);
		}

		return $pos;
	}

	/**
	* @access public
	* @abstract parse block
	*/
	function parse($name = "",$parse_it_all = true)
	{
		$count = 0;
		$image_count = 0;
		$name = empty($name)?"['|\"](?P<name>.*)['|\"]":"['|\"](?P<name>".$name.")['|\"]";

		if(!($yet_another_dom = $this->_file_data))
			die("Template File Load Failed!");

		$pattern = '#(?P<blocks><[\w]+\s*[^>]*name\s*\=\s*'.$name.'[^>]*>)#isU';

		if(preg_match_all($pattern,$yet_another_dom,$matches))
		{
			for($i=0;$i<count($matches['blocks']);$i++)
			{
				if(preg_match("/<div/",$matches['blocks'][$i]) || preg_match("/<table/",$matches['blocks'][$i]) || preg_match("/<ul/",$matches['blocks'][$i]) || preg_match("/<img/",$matches['blocks'][$i]))
				{
					$nodeName[] = $matches['name'][$i];
					$clip = $matches['blocks'][$i];
					$clip_length = strlen($clip);

					if(preg_match("/<([\S]+)/",$matches['blocks'][$i],$mean))
					{
						$tag = $mean[1];
					}

					if($tag == "img")
					{
						$start_position = strpos($yet_another_dom,$clip);
						$after_content = substr($yet_another_dom,$start_position);
						$end_position = strpos($after_content,">")+1;
						$str = substr($after_content,0,$end_position);
						$nodeType[] = "image";
						$nodeContent[] = $str;
						$nodeLength[] = strlen($str);
						$nodePosition[] = $start_position;

						continue;
					}

					$tag_end = "</".$tag.">";
					$start_position = strpos($yet_another_dom,$clip);
					$after_content = substr($yet_another_dom,$start_position);
					$pattern = "#".$tag_end."#isU";

					$end_position = $this->findEnd($after_content,$after_content,$tag,$tag_end);


					$str = substr($after_content,0,$end_position);
					$length = strlen($str);
					$nodeType[] = "normal";
					$nodeContent[] = $str;
					$nodeLength[] = $length;
					$nodePosition[] = $start_position;
				}
			}

			for($i=0;$i<count($nodeName);$i++)
			{
				$template_images = array();
				if(preg_match_all("#\{(?P<blocks>[^\}]*)\}#isU",$nodeContent[$i],$blocks))
				{
					for($j=0;$j<count($this->_block_list);$j++)
					{
						for($k=0;$k<count($blocks['blocks']);$k++)
						{
							if($this->_block_list[$j]['name'] == $blocks['blocks'][$k])
							{
								$used_blocks[] = $this->_block_list[$j];
							}
						}
					}	
				}

				if($nodeType[$i] == "image")
				{
					if(preg_match_all("#(?P<images>\<img[^\>]*\>)#isU",$nodeContent[$i],$images))
					{
						for($j=0;$j<count($images['images']);$j++)
						{
							$template_images[$j]['count'] = $image_count;
							$template_images[$j]['block_name'] = $nodeName[$i];
							$template_images[$j]['startpos'] = strpos($yet_another_dom,$images['images'][$j]);
							$template_images[$j]['length'] = strlen($images['images'][$j]);
							$image_count++;
						}
					}
				}
				
				if($parse_it_all)
				{
					$nodeArray[$i]['type'] = $nodeType[$i];
					$nodeArray[$i]['count'] = $count;
					$nodeArray[$i]['name'] = $nodeName[$i];
					$nodeArray[$i]['content'] = $nodeContent[$i];
					$nodeArray[$i]['length'] = strlen($nodeContent[$i]);
					$nodeArray[$i]['startpos'] = strpos($yet_another_dom,$nodeContent[$i]);
					$nodeArray[$i]['block_list'] = $this->_block_list;
					$nodeArray[$i]['used_blocks'] = $used_blocks;
					$nodeArray[$i]['template_images'] = $template_images;
					
					$count++;
				}
				else
				{
					$nodeArray['type'] = $nodeType[$i];
					$nodeArray['name'] = $nodeName[$i];
					$nodeArray['content'] = $nodeContent[$i];
					$nodeArray['used_blocks'] = $used_blocks;
					$nodeArray['template_images'] = $template_images;
				}
			}
			return $nodeArray;
		}

		return false;
	}

	/**
	* @access public
	* @abstract Interface::
	*/
	function previewTemplate()
	{}


	/**
	* @access private
	* @abstract 
	*/
	function channelJs()
	{
		if($this->_template_subject_id >= 0)
		{
			$id = "0";
		}
		else
		{
			$id = "1";
		}

		return "document.editform.showchannel[".$id."].checked = true";
	}

	/**
	* @access public
	* @abstract Interface :: action handle for tpl_edit
	*/
	function editTemplate()
	{
		$this->template_stage = "编辑模板";
		$this->_block_list = $this->getBlockList();

		if(!empty($this->_template_id))
		{
			$result['id'] = $this->_template_id;
			$result['chanel_checked_js'] = $this->channelJs();
			$result['name'] = $this->_template_name;
			$result['block'] = $this->mergeTemplate();
			$result['subject'] = $this->getSubjectList();
			$result['special'] = $this->getSpecialList();
		}
		return $result;
	}


	function mergeTemplate()
	{
		if(!$this->_file_data = $this->loadFile($this->_template_file))
		{
			die("Tpl File Load Failed");
		}
		$nodeArray = $this->parse();

		$backup_dir = dirname($this->_tpl_file);
		$backup_file = $backup_dir."/".$this->_template_id."/".date("Y-m-d",time())."/".date("His").".bak";

		if(!file_exists(dirname($backup_file)))
		{
			$this->makePath(dirname($backup_file));
		}

		copy($this->_tpl_file,$backup_file);


		if(!$this->_file_data = $this->loadFile($this->_tpl_file))
		{
			die("Template File Load Failed");
		}

		for($i=0;$i<count($nodeArray);$i++)
		{
			$patchArray = $this->parse($nodeArray[$i]['name'],false);
			if(!empty($patchArray['content']))
			{
				$nodeArray[$i]['content'] = $patchArray['content'];
				$nodeArray[$i]['used_blocks'] = $patchArray['used_blocks'];
			}
		}
		return $nodeArray;
	}

	/**
	* @access public
	* @abstract Interface :: action handle for tpl_add
	*/
	function addTemplate()
	{
		$this->template_stage = "添加模板";
		$this->_block_list = $this->getBlockList();
		if(!empty($this->_template_file) && $this->_file_data = $this->loadFile($this->_template_file))
		{
			$result['id'] = $this->_template_id;
			$result['chanel_checked_js'] = "document.editform.showchannel[0].checked = true";
			$result['subject'] = $this->getSubjectList();
			$result['special'] = $this->getSpecialList();
			$result['block'] = $this->parse();
			$result['name'] = $_REQUEST['name'];
			return $result;
		}
		else
		{
			die("没有选择任何模板");
		}
	}


	function getSubjectList()
	{
		$block = new Block($this->_db);
		$array = $block->getSubject($block->getSubjectList());
		array_unshift($array,array("type" => "subject_id","name" => "频道首页","id" => 0,"prefix" => ""));	
		for($i=0;$i<count($array);$i++)
		{
			if($this->_template_subject_id == $array[$i]['id'])
			{
				$array[$i]['selectflag'] = "SELECTED";
				continue;
			}
		}
		return $array;
	}

	function getSpecialList()
	{
		$block = new Block($this->_db);
		$array = $block->getSpecialList();
		for($i=0;$i<count($array);$i++)
		{
			$varible = "_template_" . $array[$i]['type'];
			if(array_key_exists("special_id",$array[$i]))
			{
				if($this->$varible == $array[$i]['id'] - $array[$i]['special_id']*100)
				{
					$array[$i]['selectflag'] = "SELECTED";
					continue;
				}
			}
			elseif($this->$varible == $array[$i]['id'])
			{
				$array[$i]['selectflag'] = "SELECTED";
				continue;
			}
		}
		return $array;
	}


	/**
	* @access private
	*/
	function doSomethingAboutSave()
	{
		$this->template_stage = "保存模板";
		$query_header = "UPDATE template ";
		$query_type = "Update";
		$where_clause = " WHERE id = " . $this->_template_id;
		
		$source = file_get_contents($this->locateTemplateFile());

		for($i=0;$i<count($this->_template_images);$i++)
		{
			if(array_key_exists("name",$this->_template_images[$i]))
			{
				$string = substr($source,$this->_template_images[$i]['startpos'],$this->_template_images[$i]['length']);
				$sub[] = $string;
				$replace[] = preg_replace('#src\=\"[^\"]+\"#isU',"src=\"http://images." . DOMAIN . "/".$this->_template_images[$i]['name']."\"",$string);	
			}
		}
		$file = str_replace($sub,$replace,$source);

		unset($sub);
		unset($replace);

		for($i=0;$i<count($this->_data['content']);$i++)
		{
			$sub[] = substr($source,$this->_data['startpos'][$i],$this->_data['length'][$i]);
			$replace[] = stripslashes($this->_data['content'][$i]);
		}

		$file = str_replace($sub,$replace,$file);

		if(!$this->writeTplFile($file))
		{
			die("TPL file write error");
		}

		$sql = "UPDATE template SET ".$this->_template_channel.", name = '".$this->_template_name."', file_name = '" .$this->_tpl_path."', path = '".$this->_template_file."', is_default = '".$this->_template_is_default."' " . $where_clause;

		$dao = DAO::CreateInstance();
		$dao->assoc = true;
		$dao->SetCurrentSchema($this->_db);
		$dao->Update($sql);
		return true;
	}
	/**
	* @access public
	* @abstract Interface :: action handle for tpl_save
	*/
	function saveTemplate()
	{
		$this->getId();
		$this->getName();
		$this->getData();
		$this->getFile();
		$this->getIsDefault();
		$subdir = $this->getChannel();
		$this->getSavePath($subdir);
		$this->updateLimit();
		$this->getImages();
		$this->doSomethingAboutSave();

		return $this->_template_id;
	}


	function writeTplFile($data)
	{
		if(!empty($data))
		{
			$path = $this->_tpl_path;

			$this->makePath($path);

			$filename = $path."/".$this->_template_id.".tpl";
			
			if(!$fp = fopen($filename,"w+"))
			{
				die("can't open file");
			}

			if(!fwrite($fp,$data))
			{
				die("can't write file");
			}
			fclose($fp);
		}

		return true;
	}

	function makePath($path)
	{
       if (!file_exists($path))
       {
           $this->makePath(dirname($path));

           mkdir($path, 0777);
       }
	}

	function getSavePath($subdir = "")
	{
		if($subdir == "")
		{
			if($this->_template_subject_id > 0)
			{
				$subdir = "subject/" . $this->_template_subject_id;
			}
			elseif($this->_template_special_id > 0)
			{
				$subdir = "special/" . $this->_template_special_id;
			}
		}

		$this->_tpl_path = $this->_template_dir .$this->_db . "/" . $subdir;
	}

	/**
	* @function handler for add template
	*/
	function listTemplateFile()
	{
		$this->template_stage = "选择模板文件";
		$result = $this->getFileList();

		return $result;
	}

	/**
	* @function handler for add template
	*/
	function listTemplate()
	{
		$this->template_stage = "选择模板";
		$result = $this->getTemplateList();
		return $result;
	}

	function locateTplFile()
	{
		return $this->_tpl_path."/".$this->_template_id.".tpl";
	}

	function locateTemplateFile()
	{
		return $this->_template_file;
	}

	function getId()
	{
		if(!empty($_REQUEST['id']))
		{
			$this->setId($_REQUEST['id']);
		}
	}

	function setId($id)
	{
		$this->_template_id = urldecode($id);
	}

	function getName()
	{
		if(!empty($_REQUEST['name']))
		{
			$this->setName(urldecode($_REQUEST['name']));
		}
	}

	function setName($name)
	{
		$this->_template_name = $name;
	}

	function getData()
	{
		$this->setData($_REQUEST['block']);
	}

	function setData($block)
	{
		$this->_data = $block;
	}

	function getFile()
	{

		$this->setFile(urldecode($_REQUEST['file']));
	}

	function setFile($file)
	{
		$this->_template_file = $file;
	}

	function getIsDefault()
	{
		$this->setIsDefault(urldecode($_REQUEST['is_default']));
	}

	function setIsDefault($is_default)
	{
		$this->_template_is_default = $is_default;
	}

	function getChannel()
	{
		return $this->setChannel($_REQUEST['channel']);
	}

	function getImages()
	{
		$template_images = !empty($_REQUEST['template_images'])?$_REQUEST['template_images']:false;
		if($template_images)
		{
			for($i=0;$i<count($_FILES['template_images']['name']);$i++)
			{
				if(!empty($_FILES['template_images']['name'][$i]))
				{	
					$upload = new UploadImg();
					$path = $this->_template_image_dir.substr($this->_db,4)."/".date("Y-m-d");
					$upload_path = "/index/" . substr($this->_db,4)."/".date("Y-m-d");
					$upload->setPath( $upload_path );

					if(!is_dir($path))
					{
						$this->makePath($path);
					}
					//@move_uploaded_file($_FILES['template_images']['tmp_name'][$i],$path."/".$_FILES['template_images']['name'][$i]);
					
					$file['name'] = $_FILES['template_images']['name'][$i];
					$file['size'] = $_FILES['template_images']['size'][$i];
					$file['type'] = $_FILES['template_images']['type'][$i];
					$file['tmp_name'] = $_FILES['template_images']['tmp_name'][$i];
									
					if(!$name = $upload->upload($file))
					{
						die("图片上传时有错误发生");
					}
					
					$template_images[$i]['name'] = $path."/".$name;
				}
			}

			$this->_template_images = $template_images;

		}
		else
		{
			return false;
		}
	}

	function updateLimit()
	{
		if(!empty($_REQUEST['block_limit']))
		{
			$block_limit = $_REQUEST['block_limit'];
			foreach($block_limit as $id => $limit)
			{
				$sql = "SELECT content FROM template_block WHERE id = " .$id;

				$result = $this->QueryRow($sql);
				$content = preg_replace("#LIMIT\s?(\d*)#","LIMIT ".$limit."",$result['content']);
				$sql = "UPDATE template_block SET content = '" .$content. "' WHERE id = ".$id;

				$dao = DAO::CreateInstance();
				$dao->assoc = true;
				$dao->SetCurrentSchema($this->_db);
				$dao->Update($sql);
			}
		}
	}

	function setChannel($channel)
	{
		$this->_template_channel = urldecode($channel);

		$tmp = explode("=",$this->_template_channel);
		
		$key = "_template_".$tmp[0];
		$value = $tmp[1];

		if($tmp[0] == "subject_id")
		{
			$this->_template_channel = "special_id = -1, special_subject_id = -1, " . $this->_template_channel;
			$subdir = "subject/" . $value;
		}
		elseif($tmp[0] == "special_id")
		{
			$this->_template_channel = "subject_id = -1, special_subject_id = -1, " . $this->_template_channel;
			$subdir = "special/" . $value;
		}
		elseif($tmp[0] == "special_subject_id")
		{
			$special_id = floor($value/100);
			$value = $value - $special_id*100;
			$subdir = "special/".$special_id."/".$value;
			$this->_template_channel = " subject_id = -1, special_id = ".$special_id.", special_subject_id = ".$value;
		}
		$this->$key = $value;

		return $subdir;
	}
}
?>
