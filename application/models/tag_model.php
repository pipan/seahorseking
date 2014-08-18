<?php
class Tag_model extends CI_Model{
	
	public function __construct(){
		parent::__construct();
		$this->select = array('tag.tag_name', 'tag.tag_slug', 'tag.lang_id');
		$this->select_id = array('tag.id', 'tag.tag_name', 'tag.tag_slug', 'tag.lang_id');
		$this->relation = array(
				'language' => array(
						'join' => 'language',
						'on' => 'tag.lang_id=language.id',
						'type' => 'inner',
						'select' => Language_model::get_select(),
				),
		);
	}
	
	public static function get_select(){
		return array('tag.tag_name', 'tag.tag_slug', 'tag.lang_id');
	}
	public static function get_select_id(){
		return array('tag.id', 'tag.tag_name', 'tag.tag_slug', 'tag.lang_id');
	}
}