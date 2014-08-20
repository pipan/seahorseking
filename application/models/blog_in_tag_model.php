<?php
class Blog_in_tag_model extends MY_Model{
	
	public function __construct(){
		parent::__construct('blog_in_tag');
		$this->select = array('blog_in_tag.blog_id' ,'blog_in_tag.tag_id');
		$this->select_id = array('blog_in_tag.id' ,'blog_in_tag.blog_id' ,'blog_in_tag.tag_id');
		$this->relation = array(
				'tag' => array(
						'join' => 'tag',
						'on' => 'blog_in_tag.tag_id=tag.id',
						'type' => 'inner',
						'select' => Tag_model::get_select(),
				),
				'blog' => array(
						'join' => 'blog',
						'on' => 'blog_in_tag.blog_id=blog.id',
						'type' => 'inner',
						'select' => Blog_model::get_select(),
				),
		);
	}
	
	public static function get_select(){
		return array('blog_in_tag.blog_id' ,'blog_in_tag.tag_id');
	}
	public static function get_select_id(){
		return array('blog_in_tag.id' ,'blog_in_tag.blog_id' ,'blog_in_tag.tag_id');
	}
	
	public function get_by_data($data){
		$select = array('tag.id');
		$join = array('tag');
		$this->db->select($this->join($join, $select));
		$query = $this->db->get_where('blog_in_tag', array('blog_in_tag.blog_id =' => $data['blog_id'], 'tag.lang_id =' => $data['lang_id']));
		return $query->result_array();
	}
	
	public function get_list_by_data($join = array(), $data, $limit_from, $limit){
		$this->db->select($this->join($join, $this->select_id));
		$this->db->where(array('tag.tag_slug =' => $data['tag_slug'], 'tag.lang_id =' => $data['lang_id']));
		$query = $this->db->get($this->table, $limit, $limit_from);
		return $query->result_array();
	}
	
	public function count_all_by_tag_slug($tag){
		$this->db->select($this->join(array('tag'), $this->select_id));
		$this->db->where(array('tag_slug =' => $tag));
		return $this->db->count_all_results($this->table);
	}
	
	public function detach_tags($blog_id, $lang_id){
		$sql = "DELETE FROM blog_in_tag WHERE blog_id=".$blog_id." AND tag_id IN (SELECT id FROM tag WHERE lang_id=".$lang_id.")";
		$this->db->query($sql);
	}
}