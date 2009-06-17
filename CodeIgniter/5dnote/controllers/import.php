<?php

class Import extends Controller {

	function Import()
	{
		parent::Controller();
	}
	
	function index()
	{
		$baseurl = 'http://zerofault.appspot.com/';
		
		$this->db->select_max('addtime');
		$query = $this->db->get('entries');
		if($query->num_rows()>0)
		{
			$row = $query->row();
			$time = strtotime($row->addtime);
			$t = date('Y-m-d-H-i-s',$time+1);
		}
		else
		{
			$t = '1970-01-01-00-00-00';
		}
		$csv = file_get_contents($baseurl.'dump/export?t='.$t);
		$lines = explode('$',$this->convert_encoding($csv));
		foreach($lines as $line)
		{
			if(!strlen($line)>10){
				continue;
			}
			$fields = explode('|',$line);
			if(sizeof($fields)!=8)
			{
				continue;
			}
			//checkvar($fields);
			$data = array(
				'title' => $fields[1],
				'url' => $fields[2],
				'content' => $fields[3],
				'image' => 'pic'==$fields[7]?file_get_contents($baseurl.'img?key='.$fields[0]):'',
				'addtime' => $fields[4],
				'private' => 0==strcasecmp('false',$fields[5])?False:True,
				'type' => $fields[7],
				'tag_ids' => implode(',',$this->parseTags($fields[6],$fields[7]))
				);
			//checkvar($data);
			$ret = $this->db->insert('entries',$data);
			echo $this->db->insert_id().':'.$fields[1]."<br />\r\n";
		}
	}
	function convert_encoding($str)
	{
		return iconv("UTF-8", "gb2312//IGNORE" , $str);
	}
	function parseTags($tags,$type)
	{
		$ret = array();
		$tags_arr = explode(' ',trim($tags));
		foreach($tags_arr as $tag)
		{
			$tag = trim($tag);
			$query = $this->db->query("select * from tags where name='".$tag."'");
			if($query->num_rows()>0)
			{
				$row = $query->row();
				$this->db->query("update tags set count_".$type."=count_".$type."+1, usetime=now() where id=".$row->id);
				$tag_id = $row->id;
			}
			else
			{
				$data = array(
					'name' => $tag,
					'count_link' => 0,
					'count_note' => 0,
					'count_pic' => 0,
					'usetime' => date("Y-m-d H:i:s")
					);
				if($type)
				{
					$data['count_'.$type] = 1;
				}
				$this->db->insert('tags', $data);
				$tag_id = $this->db->insert_id();
			}
			if($this->checkTagId($tag_id))
			{
				$ret[] = $tag_id;
			}
			
		}
		return $ret;
	}
	function checkTagId($tag_id=0)
	{
		if(!$tag_id>0)
		{
			return false;
		}
		$query = $this->db->query("SHOW COLUMNS FROM entries LIKE 'tag_ids'");
		$row = $query->row();
		$Type = $row->Type;//set('1','2','3','4','5','6','7','8','9','10')
		eval('$set_arr = array'.substr($Type,3).';');
		if(in_array($tag_id,$set_arr))
		{
			return true;
		}
		else
		{
			$sql = "ALTER TABLE entries CHANGE tag_ids tag_ids ".substr(trim($row->Type),0,-1).",'".$tag_id."') NOT NULL";
			if($this->db->query($sql))
			{
				return true;
			}
			else
			{
				return false;
			}
		}

	}



}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */