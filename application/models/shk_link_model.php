<?php
class Shk_link_model extends MY_Model{
	
	public function __construct(){
		parent::__construct('shk_link');
		$this->select = array('shk_link.link_id', 'shk_link.link');
		$this->select_id = array('shk_link.id', 'shk_link.link_id', 'shk_link.link');
		$this->relation = array(
				'link' => array(
						'join' => 'link',
						'on' => 'shk_link.link_id=link.id',
						'type' => 'right',
						'select' => Link_model::get_select(),
				),
		);
	}
	
	public static function get_select(){
		return array('shk_link.link_id', 'shk_link.link');
	}
	public static function get_select_id(){
		return array('shk_link.id', 'shk_link.link_id', 'shk_link.link');
	}
	
public function get_active($join = array(), $id = false){
		$this->db->select($this->join($join, $this->select_id));
		$this->db->where('shk_link.link_id IS NOT NULL');
		if ($id == false){
			$query = $this->db->get($this->table);
			return $query->result_array();
		}
		else{
			$this->db->where('id = '.$id);
			$query = $this->db->get($this->table);
			return $query->row_array();
		}
	}
	
	public function detach(){
		$this->db->empty_table($this->table);
	}
}