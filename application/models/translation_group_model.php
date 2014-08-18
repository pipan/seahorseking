<?php
class Translation_group_model extends MY_Model{
	
	public function __construct(){
		parent::__construct('translation_group');
		$this->select = array();
		$this->select_id = array('translation_group.id');
	}
	
	public static function get_select(){
		return array();
	}
	public static function get_select_id(){
		return array('translation_group.id');
	}
	
	public function save($data, $id = false){
		$this->db->query('INSERT INTO '.$this->table.'() VALUES()');
		$ret = $this->db->insert_id();
		return $ret;
	}
}