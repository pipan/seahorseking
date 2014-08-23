<?php
class Project_in_link_model extends MY_Model{
	
	public function __construct(){
		parent::__construct('project_in_link');
		$this->select = array('project_in_link.link_id', 'project_in_link.project_id', 'project_in_link.link');
		$this->select_id = array('project_in_link.id', 'project_in_link.link_id', 'project_in_link.project_id', 'project_in_link.link');
		$this->relation = array(
				'user' => array(
						'join' => 'project',
						'on' => 'project_in_link.user_id=project.id',
						'type' => 'inner',
						'select' => Project_model::get_select(),
				),
				'link' => array(
						'join' => 'link',
						'on' => 'project_in_link.link_id=link.id',
						'type' => 'right',
						'select' => Link_model::get_select(),
				),
		);
	}
	
	public static function get_select(){
		return array('project_in_link.link_id', 'project_in_link.project_id', 'project_in_link.link');
	}
	public static function get_select_id(){
		return array('project_in_link.id', 'project_in_link.link_id', 'project_in_link.project_id', 'project_in_link.link');
	}
	
	public function get_for_project($project_id, $join = array()){
		$this->db->select($this->join($join, $this->select_id));
		$this->db->where('project_id =', $project_id);
		$query = $this->db->get($this->table);
		return $query->result_array();
	}
	
	public function detach($project_id){
		$sql = "DELETE FROM project_in_link WHERE project_id=".$project_id;
		$this->db->query($sql);
	}
}