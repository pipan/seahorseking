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
}