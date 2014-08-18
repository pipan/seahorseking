<?php
class User_in_link_model extends MY_Model{
	
	public function __construct(){
		parent::__construct('user_in_link');
		$this->select = array('user_in_link.link_id', 'user_in_link.user_id', 'user_in_link.link');
		$this->select_id = array('user_in_link.id', 'user_in_link.link_id', 'user_in_link.user_id', 'user_in_link.link');
		$this->relation = array(
				'user' => array(
						'join' => 'user',
						'on' => 'user_in_link.user_id=user.id',
						'type' => 'inner',
						'select' => User_model::get_select(),
				),
				'link' => array(
						'join' => 'link',
						'on' => 'user_in_link.link_id=link.id',
						'type' => 'right',
						'select' => Link_model::get_select(),
				),
		);
	}
	
	public static function get_select(){
		return array('user_in_link.link_id', 'user_in_link.user_id', 'user_in_link.link');
	}
	public static function get_select_id(){
		return array('user_in_link.id', 'user_in_link.link_id', 'user_in_link.user_id', 'user_in_link.link');
	}
	
	public function get_by_user($user_id, $join = array()){
		$this->db->select($this->join($join, $this->select_id));
		$this->db->where('user_id =', $user_id);
		$this->db->or_where('user_id IS NULL');
		$query = $this->db->get($this->table);
		return $query->result_array();
	}
	
	public function detach($user_id){
		$sql = "DELETE FROM user_in_link WHERE user_id=".$user_id;
		$this->db->query($sql);
	}
}