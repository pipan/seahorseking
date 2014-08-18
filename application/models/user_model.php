<?php
class User_model extends MY_Model{
	
	public $select_login;
	
	public function __construct(){
		parent::__construct('user');
		$this->select_login = array('user.id', 'user.user_nickname', 'user.password', 'user.salt');
		$this->select = array('user.user_nickname', 'user.user_name', 'user.user_surname', 'user.email', 'user.user_gender', 'user.user_birthday', 'user.permission_id', 'user.avatar', 'DAY(user.user_birthday) as birthday_day', 'MONTH(user.user_birthday) as birthday_month', 'YEAR(user.user_birthday) as birthday_year');
		$this->select_id = array('user.id', 'user.user_nickname', 'user.user_name', 'user.user_surname', 'user.email', 'user.user_gender', 'user.user_birthday', 'user.permission_id', 'user.avatar', 'DAY(user.user_birthday) as birthday_day', 'MONTH(user.user_birthday) as birthday_month', 'YEAR(user.user_birthday) as birthday_year');
	}
	
	public static function get_select(){
		return array('user.user_nickname', 'user.user_name', 'user.user_surname', 'user.email', 'user.user_gender', 'user.user_birthday', 'user.permission_id', 'user.avatar', 'DAY(user.user_birthday) as birthday_day', 'MONTH(user.user_birthday) as birthday_month', 'YEAR(user.user_birthday) as birthday_year');
	}
	public static function get_select_id(){
		return array('user.id', 'user.user_nickname', 'user.user_name', 'user.user_surname', 'user.email', 'user.user_gender', 'user.user_birthday', 'user.permission_id', 'user.avatar', 'DAY(user.user_birthday) as birthday_day', 'MONTH(user.user_birthday) as birthday_month', 'YEAR(user.user_birthday) as birthday_year');
	}
	
	public function get_login($nickname = ""){
		$this->db->select($this->select_login);
		$query = $this->db->get_where($this->table, array('user_nickname =' => $nickname));
		return $query->row_array();
	}
	
	public function get_login_by_id($id){
		$this->db->select($this->select_login);
		$query = $this->db->get_where($this->table, array('id =' => $id));
		return $query->row_array();
	}
}