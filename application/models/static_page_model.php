<?php
class Static_page_model extends MY_Model{
	
	public function __construct(){
		parent::__construct('static_page');
		$this->select = array('static_page.folder', 'static_page.position', 'static_page.post_date', 'static_page.page_title');
		$this->select_id = array('static_page.id', 'static_page.folder', 'static_page.position', 'static_page.post_date', 'static_page.page_title');
	}
	
	public static function get_select(){
		return array('static_page.folder', 'static_page.position', 'static_page.post_date', 'static_page.page_title');
	}
	public static function get_select_id(){
		return array('static_page.id', 'static_page.folder', 'static_page.position', 'static_page.post_date', 'static_page.page_title');
	}
	
	public function exists_by_name($id){
		$this->db->select('id');
		$this->db->from($this->table);
		$this->db->where('page_title', $id);
		return ($this->db->count_all_results() > 0);
	}
	
	public function exists_by_folder($folder){
		$this->db->select('id');
		$this->db->from($this->table);
		$this->db->where('folder', $folder);
		return ($this->db->count_all_results() > 0);
	}
	
	public function get($join = array(), $id = false){
		$this->db->select($this->join($join, $this->select_id));
		$this->db->order_by('position ASC');
		if ($id == false){
			$query = $this->db->get($this->table);
			return $query->result_array();
		}
		else{
			$query = $this->db->get_where($this->table, array($this->table.'.id =' => $id));
			return $query->row_array();
		}
	}
	
	public function get_by_name($name, $join = array()){
		$this->db->select($this->join($join, $this->select_id));
		$query = $this->db->get_where($this->table, array('page_title =' => $name));
		return $query->row_array();
	}
}