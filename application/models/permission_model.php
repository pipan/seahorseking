<?php
class Permission_model extends MY_Model{
	
	public function __construct(){
		parent::__construct('permission');
		$this->select = array();
		$this->select_id = array('permission.id');
	}
}