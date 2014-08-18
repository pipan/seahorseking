<?php
class User_in_project_model extends MY_Model{
	
	public function __construct(){
		parent::__construct('user_in_project');
		$this->select = array('user_in_project.user_id', 'user_in_project.project_id');
		$this->select_id = array('user_in_project.id', 'user_in_project.user_id', 'user_in_project.project_id');
		$this->relation = array(
				'project' => array(
						'join' => 'project',
						'on' => 'user_in_project.project_id=project.id',
						'type' => 'inner',
						'select' => Project_model::get_select(),
				),
				'user' => array(
						'join' => 'user',
						'on' => 'user_in_project.user_id=user.id',
						'type' => 'inner',
						'select' => User_model::get_select(),
				),
		);
	}
	
	public static function get_select(){
		return array('user_in_project.user_id', 'user_in_project.project_id');
	}
	public static function get_select_id(){
		return array('user_in_project.id', 'user_in_project.user_id', 'user_in_project.project_id');
	}
	
	public function get_not_in_project($id){
		$query = $this->db->query("SELECT id, user_nickname FROM user 
				WHERE id NOT IN (SELECT user_id FROM user_in_project WHERE project_id = '".$id."')");
		return $query->result_array();
	}
	public function get_in_project($id){
		$this->db->select($this->join(array('user'), $this->select_id));
		$this->db->where('project_id', $id);
		$query = $this->db->get($this->table);
		return $query->result_array();
	}
}