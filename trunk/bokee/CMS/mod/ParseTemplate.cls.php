<?php

/**
 * ParseTemplate.cls.php
 * @author  Liut@bokee.com
 * @version  1.0
 * @abstract  区块类
 * @copyright bokee dot com
 */

require_once('sql/DAO.cls.php');
require_once('mod/Block.cls.php');
require_once('mod/Subject.cls.php');
require_once('com/FTP.cls.php');

class ParseTemplate
{
	var $_id = -1;
	var $_template_type;

	var $_template_id = -1;

	var $_params;

	var $_block_count = 0;

	function ParseTemplate($db = "cms_life",$arg = array())
	{
		$this->_db = $db;
		$this->_params = $arg;
	}
	function QueryRow($sql = "")
	{
		$dao = DAO::CreateInstance();
		$dao->assoc = true;
		$dao->SetCurrentSchema($this->_db);

		$result = $dao->GetRow($sql);

		$dao->Disconnect();

		return $result;
	}

	function QueryPlan($sql = "")
	{
		$dao = DAO::CreateInstance();
		$dao->assoc = true;
		$dao->SetCurrentSchema($this->_db);

		$result = $dao->GetPlan($sql);

		$dao->Disconnect();

		return $result;
	}

	function setParam($array)
	{
		$this->_params = $array;
	}

	function getTemplates()
	{

		foreach($this->_params as $param)
		{
			$htmls[] = $this->getTemplate($param);
		}

		return $htmls;
	}

	function getTemplate($param)
	{
		if(array_key_exists("id",$param))
		{
			$this->_template_type = "id";
			$this->_template_id = $param['id'];
			$sql = "SELECT * FROM template WHERE id = ".$this->_template_id." LIMIT 1";
		}

		$tmp = array_keys($param);
		$this->_template_type = $tmp[0];
		$tmp = array_values($param);
		$this->_id = $tmp[0];

		$sql = "SELECT * FROM template WHERE ".$this->_template_type." = ".$this->_id." AND is_default = 'Y' LIMIT 1";

		$template_row = $this->QueryRow($sql);


		if(!empty($template_row))
		{
			$this->_subject_id = $template_row['subject_id'];
			$this->_special_id = $template_row['special_id'];
			$this->_special_subject_id = $template_row['special_subject_id'];
			$file = $template_row['file_name']."/".$template_row['id'].".tpl";
			$path = $template_row['file_name'];
			$content = file_get_contents($file);
		}
		elseif(array_key_exists("content",$param))
		{
			$path = "";
			$content = $param['content'];
		}
		elseif(array_key_exists("file",$param))
		{
			$path = dirname($param['file']);
			$content = file_get_contents($param['file']);
		}
		else
		{
			return false;
		}

		$this->_content = $content;
		if(preg_match("#<body[^>]*>(.*)</body>#isU",$this->_content,$body))
		{
			$body_content = $body[1];
		}


		if(preg_match_all("#\{(?P<blocks>[^\;]*)\}#isU",$body_content,$matches))
		{
			$blocks = $matches['blocks'];
		}
		else
		{
			return $this->_content;
		}


		$blocks_data = $this->getBlocks($blocks);

		for($i=0;$i<count($blocks_data);$i++)
		{
			$sub[] = substr($this->_content,$blocks_data[$i]['position'],$blocks_data[$i]['length']);
			$replace[] = $blocks_data[$i]['content'];
		}
		$html = str_replace($sub,$replace,$this->_content);



		if(!empty($path))
		{
			$file = $path."/index.shtml";
			if($handle = fopen($file,"w"))
			{
				fwrite($handle,$html);
			}

			fclose($handle);

			//From mod/Article.cls.php
			if($this->_subject_id >= 0)
			{
				$subject = new Subject($this->_db);
				$subject->GetByID($this->_subject_id);
				$level = $subject->GetSort();
				for($i=0;$i<$level;$i++)
				{
					$subjects[$i] = $subject->GetDirName();
					$subject->GetByID($subject->GetParentId());
				}
				
				$this->_subject_dir = "";
				for($i=$level-1;$i>=0;$i--)
				{
					//Log::Append($this->_subject_dir);
					$this->_subject_dir .= "/" . $subjects[$i];
					if(!is_dir($dir.$this->_subject_dir))
					{
						mkdir($dir.$this->_subject_dir, 0700);
					}
					if(!is_dir($image_dir.$this->_subject_dir))
					{
						mkdir($image_dir.$this->_subject_dir, 0700);
					}
				}
			}
			else
			{
				$this->_subject_dir = "/html/".$this->_db."/special/foo.html";
			}

			$ftp = new FTP(substr($this->_db, 4));

			$remote_file = "/html/".$this->_db."/".$this->_subject_dir."/index.shtml";

			$ftp->FtpMkdir(dirname($remote_file));
			if($result = $ftp->Put($file,$remote_file))
			{
				return true;
			}
			else
			{

			}
		}
		else
		{
			return $html;
		}
	}

	function getBlocks($blocks)
	{
		for($i=0;$i<count($blocks);$i++)
		{
			$replace = "";
			$tr_postion = 0;
			$li_postion = 0;
			$div_postion = 0;
			$block_name = $blocks[$i];
			$block_entry = "{".$block_name."}";
			$block_postion = strpos($this->_content,$block_entry);
			$sub = substr($this->_content,0,$block_postion);

			$tr_position = $this->lastIndexOf($sub,"<tr");
			$li_position = $this->lastIndexOf($sub,"<li");
			$div_position = $this->lastIndexOf($sub,"<div");
			$positions = array("tr" => $tr_position,"li" => $li_position,"div" => $div_position);
			$max = 0;
			foreach($positions as $type => $position)
			{
				if(intval($position) > $max)
				{
					$max = $position;
					$block_type = $type;
				}
			}

			$pattern = "#(?P<content>\s*?<".$block_type."[^\{]+(?:\{".$block_name."\})[^\{]*<\/".$block_type.">){1}#isU";

			if($block_type == "div")
			{
				$block_content = $block_entry;
				$block_length = strlen($block_content);
			}
			elseif($block_type == "li")
			{
				if(preg_match($pattern,substr($this->_content,$li_position),$li))
				{
					$block_content = $li['content'];
					$block_length = strlen($block_content);
					$block_postion = $li_position;
				}
			}
			elseif($block_type == "tr")
			{
				if(preg_match($pattern,substr($this->_content,$tr_position),$tr))
				{
					$block_content = $tr['content'];
					$block_length = strlen($block_content);
					$block_postion = $tr_position;
				}
			}
			else
			{
				die("in hell");
			}

			if($format = $this->getBlock($block_name))
			{
				foreach($format as $value)
				{
					$replace .= str_replace($block_entry,$value,$block_content);
				}
			}
			$blocks_data[$this->_block_count]['name'] = $block_name;
			$blocks_data[$this->_block_count]['length'] = $block_length;
			$blocks_data[$this->_block_count]['position'] = $block_postion;
			$blocks_data[$this->_block_count]['content'] = $replace;

			$this->_block_count++;
		}
		return $blocks_data;
	}

	function lastIndexOf($string,$needle)
	{
		$index = strpos(strrev($string),strrev($needle));
		if(is_bool($index) && !$index)
		{
			return -1;
		}
		$index = strlen($string) - strlen($needle) - $index;

		return $index - 1;
	}

	function getBlock($block)
	{				
		static $inner = array();
		$format = array();
		$value = array();
		$sql = "SELECT * FROM template_block WHERE name = '".$block."' LIMIT 1";
		$block_row = $this->QueryRow($sql);

		if(count($block_row) == 0)
		{
			return false;
		}

		if(!empty($block_row['content']))
		{
			if(strpos($block_row['content'],"rel_article_subject") !== false)
			{
				$this->_normal_block = true;
			}
			else
			{
				$this->_normal_block = false;
			}

			if($this->_normal_block)
			{
				//Auto add the hyperlink of a article
				$block_row['format'] = preg_replace("#\{title\}#isU","[{source}]<a href=\"{remote_url}\">{title}</a>",$block_row['format']);

				//Auto add the source property of the article
				//$block_row['format'] = "".$block_row['format'];
				$format = $this->getFormat($block_row);
			}
		}
		else
		{
			if(preg_match_all("#\{(?P<blocks>[^\}]*)\}#isU",$block_row['format'],$matches))
			{
				$blocks = $matches['blocks'];

				foreach($blocks as $block)
				{
					$count++;
					$inner[$count][$block] = $this->getBlock($block);
				}

				foreach($inner as $inner_block)
				{
					$array = $this->replaceFormat($inner_block);
					
					$block_row['format'] = str_replace(array_keys($array),array_values($array),$block_row['format']);
				}
				
				$format[] = $block_row['format'];
			}
			else
			{
				$format[] = $block_row['format'];							
			}
		}

		return $format;
	}

	function replaceFormat($array)
	{
		if(count($array) == 1)
		{
			foreach($array as $block => $inner_formats)
			{
				foreach($inner_formats as $inner_format)
				{
					$str .= $inner_format;
				}

				$format_array["{".$block."}"] = $str;
			}
		}
		else
		{
			foreach($array as $in_array)
			{
				$inner_inner[] = $this->replaceFormat($in_array);
			}
		}

		if(!empty($inner_inner))
		{
			foreach($inner_inner as $inner_formats)
			{
				$format_array = array_merge($format_array,$inner_formats);
			}
		}

		return $format_array;
	}

	function getFormat($block_row)
	{
		static $source = array("cms" => "频道", "blog" => "公社", "rss" => "RSS", "blogmark" => "博采", "column" => "专栏");
		$format = array();
		$inner_format = array();

		if($this->_normal_block)
		{
			//Auto add the hyperlink of a article for the normal 
			if(strpos($block_row['content'],"a.remote_url") === false)
			{
				$block_row['content'] = str_replace("SELECT ","SELECT r.url as remote_url, ",$block_row['content']);
			}
			
			//Auto add the source property of the article
			$block_row['content'] = str_replace("SELECT ","SELECT r.source, ",$block_row['content']);
		}
		$block_result = $this->QueryPlan($block_row['content']);

		if(preg_match_all("#(\{(?P<fields>[^\}]*)\})#",stripslashes($block_row['format']),$matches))
		{
			$fields_name = $matches['fields'];
			$fields = $matches[1];
		}

		if(!empty($block_result))
		{
			/*
			$result_fields = array_keys($block_result[0]);
			$inner_block = array_diff($fields_name,$result_fields);

			if(!empty($inner_block))
			{
				foreach($inner_block as $block)
				{
					echo $block;
					$inner_format[] = $this->getBlock($block);
				}
			}
			*/

			for($i=0;$i<count($block_result);$i++)
			{
				$fields_value = array();
				foreach($fields_name as $field)
				{
					//Add for source property
					if($field == "source")
					{
						$source_key = $block_result[$i][$field];
						$block_result[$i][$field] = $source[$source_key];
					}

					//Add for datetime stuff
					if($field == "create_time")
					{
						if(preg_match("#(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})#isU",$block_result[$i][$field],$matches))
						{
							$block_result[$i][$field] = $matches[2]."/".$matches[3]." ".$matches[4]."/".$matches[5]; 
						}
					}

					//Add for create_time stuff
					if($field == "hotcommenttime")
					{
						$block_result[$i][$field] = preg_replace("#(\d{4})-({\d{2})-(\d{2})\s(\d{2})\:(\d{2})\:(\d{2})#","\\2/\\3 \\4/\\5",$block_result[$i][$field]);
					}
					$fields_value[] = $block_result[$i][$field];
				}
				$format[] = str_replace($fields,$fields_value,$block_row['format'])."\n";
			}
			$format = array_merge($format,$inner_format);
		}
		return $format;
	}
}
?>