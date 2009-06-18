<?php

class View extends Controller {

	function View()
	{
		parent::Controller();
	//	$this->load->scaffolding('entries');
	//	$this->load->helper('url');
		
	}
	
	function index()
	{
		$type = $this->uri->segment(1);
		empty($type) && $type='link';
		$data['type'] = $type;

		if($this->uri->segment(2))
		{
			$tmp = $this->uri->segment(2);
			if(strlen($tmp) == strlen(intval($tmp)))
			{
				$offset = $tmp;
			}
			else
			{
				$tag = $tmp;
			}
		}
		if($this->uri->segment(3))
		{
			$tag = $this->uri->segment(2);
			$offset = $this->uri->segment(3);
		}
		$this->db->where('type',$type);
		$this->db->where('private',0);
		if($tag)
		{
			$this->db->join('entry_tags', 'entry_tags.entry_id = entries.id','inner');
			$this->db->join('tags', 'tags.id = entry_tags.tag_id and tags.name='.$tag,'inner');
		}
		$query = $this->db->get('entries');
		$data['total'] = $query->num_rows();


		$this->load->library('pagination');
		$uri = $_SERVER['REQUEST_URI'];
		if(strstr($uri,'index.php')===false)
		{
			$uri .= 'index.php/link';
		}
		else
		{
			$uri = substr($uri,0,strpos($uri,'?')).'?type='.$_REQUEST['type'];
		}
		$config['page_query_string'] = true;
		$config['base_url'] = $uri;
		$config['total_rows'] = $data['total'];
		$config['per_page'] = '6'; 
		$config['query_string_segment'] = 'offset';
		$this->pagination->initialize($config); 
		//checkvar($this->pagination);
		$data['pagination'] = $this->pagination->create_links();
		$this->db->limit($config['per_page'],$_REQUEST['offset']);
		$query = $this->db->get('entries');
		foreach($result=$query->result_array() as $k=>$row)
		{
			$this->db->where_in('id',$row['tag_ids']);
			$query2 = $this->db->get('tags');
			$tag_names = array();
			foreach($query2->result_array() as $row)
			{
				$tag_names[]=$row['name'];
			}
			$result[$k]['tag_names'] = $tag_names;
		}
		$data['result'] = $result;
		$this->load->view('view',$data);
	}
	



}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */