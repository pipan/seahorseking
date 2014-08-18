<?php
class Translation_model extends MY_Model{
	
	public function __construct(){
		parent::__construct('translation');
		$this->select = array('translation.lang_id', 'translation.group_id', 'translation.lang_value', 'translation.slug');
		$this->select_id = array('translation.id', 'translation.lang_id', 'translation.group_id', 'translation.lang_value', 'translation.slug');
		$this->relation = array(
				'language' => array(
						'join' => 'language',
						'on' => 'translation.lang_id=language.id',
						'type' => 'inner',
						'select' => Language_model::get_select(),
				),
		);
	}
	
	public static function get_select(){
		return array('translation.lang_id', 'translation.group_id', 'translation.lang_value', 'translation.slug');
	}
	public static function get_select_as($as = array()){
		$ret = array();
		$i = 0;
		$select = Translation_model::get_select();
		foreach ($select as $s){
			if (sizeof($as) > $i && $as[$i] != ""){
				$ret[$i] = $s.' AS '.$as[$i];
			}
			else{
				$ret[$i] = $s;
			}
			$i++;
		}
		return $ret;
	}
	public static function get_select_id(){
		return array('translation.id', 'translation.lang_id', 'translation.group_id', 'translation.lang_value', 'translation.slug');
	}
	
	public function get_translation($group_id, $lang_id = false){
		$this->db->select($this->join(array(), $this->select_id));
		$this->db->where('group_id', $group_id);
		if ($lang_id == false){
			$this->db->where('lang_id = (SELECT id FROM language WHERE lang_default = \'1\')');
		}
		else{
			$this->db->where('lang_id = '.$lang_id);
		}
		$query = $this->db->get($this->table);
		if (sizeof($query->row_array()) > 0){
			return $query->row_array();
		}
		else{
			return array(
				'lang_value' => "",
			);
		}
	}
	
	public function exists_combination($group_id, $lang_id){
		$this->db->select('id');
		$this->db->from($this->table);
		$this->db->where('group_id', $group_id);
		$this->db->where('lang_id', $lang_id);
		return ($this->db->count_all_results() > 0);
	}
	
	function get_by_combination($group_id, $lang_id, $join = array()){
		$this->db->select($this->join($join, $this->select_id));
		$this->db->where('group_id', $group_id);
		$this->db->where('lang_id', $lang_id);
		$query = $this->db->get($this->table);
		return $query->row_array();
	}
	
	public function update($data, $group_id, $lang_id){
		if ($this->exists_combination($group_id, $lang_id)){
			$trans = $this->get_by_combination($group_id, $lang_id);
			return $this->save($data, $trans['id']);
		}
		else{
			$data['lang_id'] = $lang_id;
			$data['group_id'] = $group_id;
			return $this->save($data);
		}
	}
}