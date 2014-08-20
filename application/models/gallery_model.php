<?php
class Gallery_model extends MY_Model{
	
	public function __construct(){
		parent::__construct('gallery');
		$this->select = array('gallery.user_id', 'gallery.project_id', 'gallery.image', 'gallery.post_date');
		$this->select_id = array('gallery.id', 'gallery.user_id', 'gallery.project_id', 'gallery.image', 'gallery.post_date');
		$this->relation = array(
				'user' => array(
						'join' => 'user',
						'on' => 'gallery.user_id=user.id',
						'type' => 'inner',
						'select' => User_model::get_select(),
				),
				'project' => array(
						'join' => 'project',
						'on' => 'gallery.project_id=project.id',
						'type' => 'inner',
						'select' => Project_model::get_select(),
				),
		);
	}
	
	public static function get_select(){
		return array('gallery.user_id', 'gallery.project_id', 'gallery.image', 'gallery.post_date');;
	}
	public static function get_select_id(){
		return array('gallery.id', 'gallery.user_id', 'gallery.project_id', 'gallery.image', 'gallery.post_date');;
	}
	
	public function get_by_project($project_id, $join = array()){
		$this->db->select($this->join($join, $this->select_id));
		$query = $this->db->get_where($this->table, array($this->table.'.project_id =' => $project_id));
		return $query->result_array();
	}
	
	public function remove($id){
		$this->db->delete($this->table, array('id' => $id));
	}
}