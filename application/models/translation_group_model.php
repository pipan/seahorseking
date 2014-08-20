<?php
class Translation_group_model extends MY_Model{
	
	public function __construct(){
		parent::__construct('translation_group');
		$this->select = array('translation_group.private_id');
		$this->select_id = array('translation_group.id', 'translation_group.private_id');
	}
	
	public static function get_select(){
		return array('translation_group.private_id');
	}
	public static function get_select_id(){
		return array('translation_group.id', 'translation_group.private_id');
	}
	
	public function exists_private($id, $label){
		$this->db->select('id');
		$this->db->from($this->table);
		$this->db->where('id = '.$id);
		$this->db->where('private_id IN (SELECT id FROM private_label WHERE label = \''.$label.'\')');
		return ($this->db->count_all_results() > 0);
	}
	
	public function get_private($label){
		$this->db->select($this->select_id);
		$this->db->where('private_id IN (SELECT id FROM private_label WHERE label=\''.$label.'\')');
		$query = $this->db->get($this->table);
		return $query->result_array();
	}
	
	public function save($data, $id = false){
		if (sizeof($data) == 0){
			$this->db->query('INSERT INTO '.$this->table.'() VALUES()');
			$ret = $this->db->insert_id();
			return $ret;
		}
		else{
			return parent::save($data, $id);
		}
	}
}