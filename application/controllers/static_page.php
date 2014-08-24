<?php
class Static_page extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		
		$this->load->helper('text');
		$this->load->helper('builder');
		$this->load->helper('my_date');
		$this->load->library('blog_parser');
		
		$this->load->model('language_model');
		$this->load->model('user_model');
		$this->load->model('translation_group_model');
		$this->load->model('translation_model');
		$this->load->model('blog_model');
		$this->load->model('project_model');
		$this->load->model('static_page_model');
		
		$this->data['ongoing_project'] = $this->project_model->get();
		$this->data['language'] = $this->language_model->get();
		$this->data['link'] = $this->shk_link_model->get_active(array('link'));
		$this->data['static_page'] = $this->static_page_model->get();
	}
	
	public function index($slug, $language = ""){
		$language = valid_language($language);
		$language_ext = "_".$language['lang_shortcut'];
		$this->data['lang_use'] = $language;
		$this->lang->load('general', $language['lang_shortcut']);
		$this->lang->load('static_page', $language['lang_shortcut']);
		$this->data['lang'] = $this->lang;
		//explode slug and get id from it
		$expl = explode("-", $slug);
		$slug_id = $expl[sizeof($expl) - 1];
		unset($expl[sizeof($expl) - 1]);
		$slug = implode('-', $expl);
		if ($this->static_page_model->exists_by_name($slug_id)){
			$replace = array();
			foreach ($this->data['language'] as $l){
				$replace[$l['lang_shortcut']] = array(
						'%s' => get_lang_slug($slug_id, $l['id'])."-".$slug_id,
				);
			}
			$this->data['lang_label'] = get_lang_label(base_url().'%l/%s', $replace, $this->data['language'], $language);
			$page = $this->static_page_model->get_by_name($slug_id);
			$this->data['header_menu_clicked'] = $page['folder'];
			$this->data['block_header_title'] = rawUrlDecode(read_file("./application/views/shk/".$page['folder']."/title".$language_ext.".txt"));
			$this->data['block_body'] = rawUrlDecode(read_file("./application/views/shk/".$page['folder']."/body".$language_ext.".txt"));
			
			$layout_data['title'] = "SHK | ".get_lang_value($page['page_title'], $language['id']);
			$layout_data['links'] = $this->load->view("shk/templates/links", $this->data, true);
			$layout_data['header'] = $this->load->view("shk/templates/header", $this->data, true);
			$layout_data['body'] = $this->load->view("shk/static_page/layout_body", $this->data, true);
			$layout_data['menu'] = $this->load->view("shk/templates/menu", $this->data, true);
			$layout_data['footer'] = $this->load->view("shk/templates/footer", $this->data, true);
			$this->load->view("layout/default", $layout_data);
		}
		else{
			$this->data['lang_label'] = get_lang_label(base_url().'%l', array(), $this->data['language'], $language);
			$this->data['block_header_title'] = $this->lang->line('wrong_id_header');
			$this->data['block_body'] = $this->lang->line('wrong_id_body');
			$layout_data['title'] = $this->lang->line('static_page_title_wrong_id');
			$layout_data['links'] = $this->load->view("shk/templates/links", $this->data, true);
			$layout_data['header'] = $this->load->view("shk/templates/header", $this->data, true);
			$layout_data['body'] = $this->load->view("shk/templates/body_wrong_id", $this->data, true);
			$layout_data['menu'] = $this->load->view("shk/templates/menu", $this->data, true);
			$layout_data['footer'] = $this->load->view("shk/templates/footer", $this->data, true);
			$this->load->view("layout/default", $layout_data);
		}
	}
}