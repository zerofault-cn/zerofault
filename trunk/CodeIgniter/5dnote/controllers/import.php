<?php

class Import extends Controller {

	function Import()
	{
		parent::Controller();
	}
	
	function index()
	{
		$baseurl = 'http://zerofault.appspot.com/';
		
		$this->db->select('count(*) as count');
		$query = $this->db->get('entries');
		$row = $query->row();
		$count = $row->count;
		echo $url = $baseurl.'dump/export?offset='.$count;
		echo "<br />\r\n";
		$data = $this->wget($url);
		//checkvar($data);
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
				'image' => 'pic'==$fields[7]?$this->wget($baseurl.'img?key='.trim($fields[0])):'',
				'addtime' => $fields[4],
				'private' => 0==strcasecmp('false',$fields[5])?False:True,
				'type' => $fields[7],
				);
			//checkvar($data);
			if($data['type']=='pic' && $data['image']=='')
			{
				die('fetch pic error!');
			}
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
			//checkvar($data);
			$ret = $this->db->insert('entry_tags', $data);
			echo $this->db->insert_id().$tags.":".$ret."<br />\r\n";
		}
		return true;
	}
	function wget($url)
	{
		if(ini_get('allow_url_fopen'))
		{
			$data = file_get_contents($url);
		}
		else
		{
			$c = curl_init();
			curl_setopt($c, CURLOPT_URL, $url);
			curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
			$data = curl_exec($c);
		}
		return $data;
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */