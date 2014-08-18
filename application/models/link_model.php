<?php
class Link_model extends MY_Model{
	
	public function __construct(){
		parent::__construct('link');
		$this->select = array('link.image', 'link.image_active', 'link.link_name');
		$this->select_id = array('link.id', 'link.image', 'link.image_active', 'link.link_name');
	}
	
	public static function get_select(){
		return array('link.image', 'link.image_active', 'link.link_name');
	}
	public static function get_select_id(){
		return array('link.id', 'link.image', 'link.image_active', 'link.link_name');
	}
}