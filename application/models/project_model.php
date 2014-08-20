<?php
class Project_model extends MY_Model{
	
	public function __construct(){
		parent::__construct('project');
		$this->select = array('project.project_creator', 'project.project_name', 'project.project_status', 'project.project_date', 'project.project_percentage', 'project.blog_id');
		$this->select_id = array('project.id', 'project.project_creator', 'project.project_name', 'project.project_status', 'project.project_date', 'project.project_percentage', 'project.blog_id');
		$this->relation = array(
				'user' => array(
						'join' => 'user',
						'on' => 'project.creator_id=user.id',
						'type' => 'inner',
						'select' => User_model::get_select(),
				),
				'name' => array(
						'join' => 'translation_group',
						'on' => 'project.project_name=translation_group.id',
						'type' => 'inner',
						'select' => Translation_model::get_select_as(array('project_name_lang_id', 'project_name_group_id', 'project_name_value')),
				),
				'status' => array(
						'join' => 'translation_group',
						'on' => 'project.project_status=translation_group.id',
						'type' => 'inner',
						'select' => Translation_model::get_select_as(array('project_status_lang_id', 'project_status_group_id', 'project_status_value')),
				),
				'blog' => array(
						'join' => 'blog',
						'on' => 'project.blog_id=blog.id',
						'type' => 'left',
						'select' => Blog_model::get_select(),
				),
		);
	}
	
	public static function get_select(){
		return array('project.project_creator', 'project.project_name', 'project.project_status', 'project.project_date', 'project.project_percentage', 'project.blog_id');
	}
	public static function get_select_id(){
		return array('project.id', 'project.project_creator', 'project.project_name', 'project.project_status', 'project.project_date', 'project.project_percentage', 'project.blog_id');
	}
	
	public function get_by_name($project_name, $join = array()){
		$this->db->select($this->join($join, $this->select_id));
		$query = $this->db->get_where($this->table, array('project_name =' => $project_name));
		return $query->row_array();
	}
}