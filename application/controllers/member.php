<?php
class Member extends CI_Controller{
	
	public $limit = 8;
	
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
		$this->load->model('user_in_link_model');
		
		$this->data['ongoing_project'] = $this->project_model->get();
		$this->data['language'] = $this->language_model->get();
		$this->data['link'] = $this->shk_link_model->get_active(array('link'));
		$this->data['header_menu_clicked'] = "member";
		$this->data['style'] = array('style_member');
	}
	
	public function index($language = "", $page = 1){
		$language = valid_language($language);
		$language_ext = "_".$language['lang_shortcut'];
		$this->data['lang_use'] = $language;
		$this->lang->load('general', $language['lang_shortcut']);
		$this->lang->load('member', $language['lang_shortcut']);
		$this->data['lang'] = $this->lang;
		$this->data['lang_label'] = get_lang_label(base_url().'index.php/%l/member/'.$page, array(), $this->data['language'], $language);
		
		$this->data['member'] = $this->user_model->get_list(array(), ($page -1) * $this->limit, $this->limit);
		$i = 0;
		foreach ($this->data['member'] as $m){
			$this->data['member'][$i]['body'] = read_file("./content/member/".$m['id']."/description".$language_ext.".txt");
			$this->data['member'][$i]['link'] = $this->user_in_link_model->get_for_user($m['id'], array('link'));
			$i++;
		}
		
		if ($page < 1){
			$page = 1;
		}
		$this->data['page'] = $page;
		$this->data['page_offset'] = 3;
		$this->data['last_page'] = ceil($this->user_model->count_all() / $this->limit);
		
		$layout_data['title'] = $this->lang->line('member_title');
		$layout_data['links'] = $this->load->view("shk/templates/links", $this->data, true);
		$layout_data['header'] = $this->load->view("shk/templates/header", $this->data, true);
		$layout_data['body'] = $this->load->view("shk/member/body_index", $this->data, true);
		$layout_data['menu'] = $this->load->view("shk/templates/menu", $this->data, true);
		$layout_data['footer'] = $this->load->view("shk/templates/footer", $this->data, true);
		$this->load->view("layout/default", $layout_data);
	}
}