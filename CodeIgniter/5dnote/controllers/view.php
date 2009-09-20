<?php

class View extends Controller {

	function View()
	{
		parent::Controller();
	//	$this->load->scaffolding('entries');
		$this->load->helper('url');
		$this->output->enable_profiler(TRUE);

	}
	
	function index()
	{
		$type = $_REQUEST['type'];
		empty($type) && $type='link';
		$data['type'] = $type;
		

		// get tags list
		$this->db->select('tags.name, count(entries.id) as count');
		$this->db->join('entry_tags', 'entry_tags.tag_id = tags.id', 'inner');
		$this->db->join('entries', 'entries.id = entry_tags.entry_id and entries.type=\''.$type.'\'', 'inner');
		$this->db->group_by('tags.id');
		$this->db->order_by('count desc');
		$query = $this->db->get('tags');
		//checkvar($query->result_array());
		$data['tag_list'] = $query->result_array();



		$offset = $_REQUEST['offset'];
		empty($offset) && $offset = 0;

		$tag = $_REQUEST['tag'];
		
		/**/
		$this->db->select('entries.*, group_concat(tags.name) as tag_names'); 
		$this->db->where('type',$type);
		$this->db->where('private',0);
		if($tag)
		{
			$this->db->join('entry_tags', 'entry_tags.entry_id = entries.id','inner');
			$this->db->join('tags', 'tags.id = entry_tags.tag_id and tags.name=\''.$tag.'\'', 'inner');
		}
		else
		{
			$this->db->join('entry_tags', 'entry_tags.entry_id = entries.id');
			$this->db->join('tags', 'tags.id = entry_tags.tag_id');
		}
		$this->db->group_by('entries.id');
		$query = $this->db->get('entries');
		/**/
		//$query = $this->db->query("select entries.*,group_concat(tags.name) from entries,tags,entry_tags where entries.id=entry_tags.entry_id and entry_tags.tag_id=tags.id group by entries.id");
		$data['total'] = $query->num_rows();


		$this->load->library('pagination');
		//$config['page_query_string'] = true;
		$config['first_link'] = '|&lt;';
		$config['last_link'] = '&gt;|';


		$config['base_url'] = $_SERVER["SCRIPT_NAME"].'?c=view&m=index&type='.$type.'&tag='.$tag;
		$config['total_rows'] = $data['total'];
		$config['per_page'] = '20'; 
		$config['query_string_segment'] = 'offset';
		$this->pagination->initialize($config); 
		//checkvar($this->pagination);
		$data['pagination'] = $this->pagination->create_links();
		//$query = $this->db->query("select entries.*,group_concat(tags.name) as tag_names from entries,tags,entry_tags where entries.id=entry_tags.entry_id and entry_tags.tag_id=tags.id group by entries.id order by entries.id desc limit ".$offset.",".$config['per_page']);
		$this->db->select('entries.*, group_concat(tags.name) as tag_names'); 
		$this->db->where('type',$type);
		$this->db->where('private',0);
		if($tag)
		{
			$this->db->join('entry_tags', 'entry_tags.entry_id = entries.id','inner');
			$this->db->join('tags', 'tags.id = entry_tags.tag_id and tags.name=\''.$tag.'\'', 'inner');
		}
		else
		{
			$this->db->join('entry_tags', 'entry_tags.entry_id = entries.id');
			$this->db->join('tags', 'tags.id = entry_tags.tag_id');
		}
		$this->db->group_by('entries.id');
		$this->db->order_by('entries.id desc');
		$query = $this->db->get('entries', $config['per_page'], $offset);
		$data['result'] = $query->result_array();
		$this->load->view('view',$data);
	}
	
	function img()
	{
		$id = $_REQUEST['id'];
		header("Content-Type: image/jpeg");
		$this->db->where('id',$id);
		$query = $this->db->get('entries');
		$row = $query->row();
		echo $row->image;
	}


}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */