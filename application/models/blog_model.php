<?php
class Blog_model extends MY_Model{
	
	public function __construct(){
		parent::__construct('blog');
		$this->select = array('blog.user_id', 'blog.blog_name', 'blog.post_date', 'blog.thumbnail', 'blog.project_id');
		$this->select_id = array('blog.id', 'blog.user_id', 'blog.blog_name', 'blog.post_date', 'blog.thumbnail', 'blog.project_id');
		$this->relation = array(
				'user' => array(
						'join' => 'user',
						'on' => 'blog.user_id=user.id',
						'type' => 'inner',
						'select' => User_model::get_select(),
				),
				'project' => array(
						'join' => 'project',
						'on' => 'blog.project_id=project.id',
						'type' => 'left',
				),
		);
	}
	
	public static function get_select(){
		return array('blog.user_id', 'blog.blog_name', 'blog.post_date', 'blog.thumbnail', 'blog.project_id');
	}
	public static function get_select_id(){
		return array('blog.id', 'blog.user_id', 'blog.blog_name', 'blog.post_date', 'blog.thumbnail', 'blog.project_id');
	}
	
	public function exists_by_name($id){
		$this->db->select('id');
		$this->db->from($this->table);
		$this->db->where('blog_name', $id);
		return ($this->db->count_all_results() > 0);
	}
	
	public function get_by_blog_name($blog_name, $join = array()){
		$this->db->select($this->join($join, $this->select_id));
		$query = $this->db->get_where($this->table, array('blog_name =' => $blog_name));
		return $query->row_array();
	}
	
	public function get_by_project($project_id){
		$this->db->select($this->select_id);
		$query = $this->db->get_where($this->table, array('project_id =' => $project_id));
		return $query->result_array();
	}
	
	public function get_list_by_project($project_id, $join = array(), $limit_from, $limit){
		$this->db->select($this->join($join, $this->select_id));
		$this->db->where('project_id', $project_id);
		$query = $this->db->get($this->table, $limit, $limit_from);
		return $query->result_array();
	}
	
	public function count_all_by_project($project_id){
		$this->db->where('project_id', $project_id);
		return $this->db->count_all($this->table);
	}
}