<?php
class Static_page extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		
		$this->load->helper('text');
		$this->load->helper('builder');
		$this->load->helper('my_date');
		
		$this->load->model('language_model');
		$this->load->model('user_model');
		$this->load->model('translation_group_model');
		$this->load->model('translation_model');
		$this->load->model('blog_model');
		$this->load->model('project_model');
		
		$this->data['ongoing_project'] = $this->project_model->get();
		$this->data['language'] = $this->language_model->get();
		$this->data['link'] = $this->shk_link_model->get_active(array('link'));
	}
	
	public function index($static, $language = ""){
		$this->data['header_menu_clicked'] = $static;
		
		$language = valid_language($language);
		$language_ext = "_".$language['lang_shortcut'];
		$this->data['lang_use'] = $language;
		$this->lang->load('general', $language['lang_shortcut']);
		$this->lang->load($static, $language['lang_shortcut']);
		$this->data['lang'] = $this->lang;
		$this->data['lang_label'] = get_lang_label(base_url().'index.php/%l/'.$static, array(), $this->data['language'], $language);
		
		$layout_data['title'] = $this->lang->line($static.'_title');
		$layout_data['links'] = $this->load->view("shk/templates/links", $this->data, true);
		$layout_data['header'] = $this->load->view("shk/templates/header", $this->data, true);
		$layout_data['body'] = $this->load->view("shk/".$static."/body_index".$language_ext, $this->data, true);
		$layout_data['menu'] = $this->load->view("shk/templates/menu", $this->data, true);
		$layout_data['footer'] = $this->load->view("shk/templates/footer", $this->data, true);
		$this->load->view("layout/default", $layout_data);
	}
}