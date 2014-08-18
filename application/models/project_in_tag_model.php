<?php
class Project_in_tag_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();
		$this->select = array('project_id_tag.project_id', 'project_id_tag.tag_id');
		$this->select_id = array('project_in_tag.id', 'project_id_tag.project_id', 'project_id_tag.tag_id');
		$this->relation = array(
				'project' => array(
						'join' => 'project',
						'on' => 'project_in_tag.project_id=project.id',
						'type' => 'inner',
						'select' => Project_model::get_select(),
				),
				'tag' => array(
						'join' => 'tag',
						'on' => 'project_in_tag.tag_id=tag.id',
						'type' => 'inner',
						'select' => Tag_model::get_select(),
				),
		);
	}
	
	public static function get_select(){
		return array('project_id_tag.project_id', 'project_id_tag.tag_id');
	}
	public static function get_select_id(){
		return array('project_in_tag.id', 'project_id_tag.project_id', 'project_id_tag.tag_id');
	}
}