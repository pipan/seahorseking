<?php
class Language_model extends MY_Model{
	
	public function __construct(){
		parent::__construct('language');
		$this->select = array('language.lang_name', 'language.lang_shortcut', 'language.lang_default');
		$this->select_id = array('language.id', 'language.lang_name', 'language.lang_shortcut', 'language.lang_default');
	}
	
	public static function get_select(){
		return array('language.lang_name', 'language.lang_shortcut', 'language.lang_default');
	}
	public static function get_select_id(){
		return array('language.id', 'language.lang_name', 'language.lang_shortcut', 'language.lang_default');
	}
	
	public function get_default(){
		$this->db->select(Language_model::get_select_id());
		$this->db->where('lang_default = 1');
		$query = $this->db->get($this->table);
		return $query->row_array();
	}
	
	public function get_by_shortcut($shortcut){
		$this->db->select($this->select_id);
		$this->db->from($this->table);
		$this->db->where('lang_shortcut', $shortcut);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	public function exists_shortcut($shortcut){
		$this->db->select('id');
		$this->db->from($this->table);
		$this->db->where('lang_shortcut', $shortcut);
		return ($this->db->count_all_results() > 0);
	}
}