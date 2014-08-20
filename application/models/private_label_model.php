<?php
class Private_label_model extends MY_Model{
	
	public function __construct(){
		parent::__construct('private_label');
		$this->select = array('private_label.label');
		$this->select_id = array('private_label.id', 'private_label.label');
	}
	
	public static function get_select(){
		return array('private_label.label');
	}
	public static function get_select_id(){
		return array('private_label.id', 'private_label.label');
	}
	
	public function get_by_label($label){
		$this->db->where('label = \''.$label.'\'');
		$query = $this->db->get($this->table);
		return $query->row_array();
	}
}