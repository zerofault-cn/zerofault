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
		//$csv = file_get_contents($baseurl.'dump/export?t='.$t);
		$c = curl_init();
		curl_setopt($c, CURLOPT_URL, $baseurl.'dump/export?t='.$t);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($c);
		$lines = explode('$',$this->convert_encoding($data));
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
				);
			//checkvar($data);
			$this->db->insert('entries',$data);
			$entry_id = $this->db->insert_id();
			$this->insertTags($entry_id, $fields[6], $fields[7]);
			
			echo $entry_id.':'.$fields[1]."<br />\r\n";
		}
	}
	function convert_encoding($str)
	{
		return iconv("UTF-8", "gb2312//IGNORE" , $str);
	}
	function insertTags($entry_id,$tags,$type)
	{
		$tags_arr = explode(' ',trim($tags));
		foreach($tags_arr as $tag)
		{
			$tag = trim($tag);
			$query = $this->db->query("select * from tags where name='".$tag."'");
			if($query->num_rows()>0)
			{
				$row = $query->row();
				$tag_id = $row->id;
			}
			else
			{
				$data = array(
					'name' => $tag,
					'usetime' => date("Y-m-d H:i:s")
					);
				$this->db->insert('tags', $data);
				$tag_id = $this->db->insert_id();
			}
			$data = array(
				'entry_id' => $entry_id,
				'tag_id'  => $tag_id
				);
			$this->db->insert('entry_tags', $data);
		}
		return true;
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */