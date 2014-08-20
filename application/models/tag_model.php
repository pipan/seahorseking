<?php
class Tag_model extends MY_Model{
	
	public function __construct(){
		parent::__construct('tag');
		$this->select = array('tag.tag_name', 'tag.tag_slug', 'tag.lang_id');
		$this->select_id = array('tag.id', 'tag.tag_name', 'tag.tag_slug', 'tag.lang_id');
		$this->relation = array(
				'language' => array(
						'join' => 'language',
						'on' => 'tag.lang_id=language.id',
						'type' => 'inner',
						'select' => Language_model::get_select(),
				),
		);
	}
	
	public static function get_select(){
		return array('tag.tag_name', 'tag.tag_slug', 'tag.lang_id');
	}
	public static function get_select_id(){
		return array('tag.id', 'tag.tag_name', 'tag.tag_slug', 'tag.lang_id');
	}
	
	public function get_by_data($data){
		$query = $this->db->get_where('tag', array('tag_slug =' => $data['tag_slug'], 'lang_id =' => $data['lang_id']));
		return $query->row_array();
	}
	
	public function save($data, $id = false){
		if ($id == false){
			if (($ret = $this->get_by_data($data)) == false){
				$this->db->insert($this->table, $data);
				$ret = $this->db->insert_id();
			}
			else{
				$ret = $ret['id'];
			}
		}
		else{
			$this->db->where(array('id =' => $id));
			$this->db->update($this->table, $data);
			$ret = $id;
		}
		return $ret;
	}
}