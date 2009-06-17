<?php

class Home extends Controller {

	function Home()
	{
		parent::Controller();
	//	$this->load->scaffolding('entries');
	//	$this->load->helper('url');
		
	}
	
	function index()
	{
		$type = $_REQUEST['type'];
		empty($type) && $type='link';
		$data['type'] = $type;
		$this->db->where('type',$type);
		$this->db->where('private',0);
		$query = $this->db->get('entries');
		$data['total'] = $query->num_rows();


		$this->load->library('pagination');
		$uri = $_SERVER['REQUEST_URI'];
		if(strstr($uri,'index.php')===false)
		{
			$uri .= 'index.php';
		}
		if(strpos($uri,'?')===false)
		{
			$uri .='?type=link';
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