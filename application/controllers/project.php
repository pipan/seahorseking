<?php
class Project extends CI_Controller{
	
	public $limit = 8;
	
	public function __construct(){
		parent::__construct();
		
		$this->load->helper('text');
		$this->load->helper('builder');
		$this->load->helper('image');
		$this->load->library('blog_parser');
		
		$this->load->model('language_model');
		$this->load->model('user_model');
		$this->load->model('translation_group_model');
		$this->load->model('translation_model');
		$this->load->model('blog_model');
		$this->load->model('project_model');
		$this->load->model('gallery_model');
		$this->load->model('project_in_link_model');
		
		$this->data['ongoing_project'] = $this->project_model->get();
		$this->data['language'] = $this->language_model->get();
		$this->data['link'] = $this->shk_link_model->get_active(array('link'));
		$this->data['header_menu_clicked'] = "project";
	}
	
	public function index($language = "", $page = 1){
		$language = valid_language($language);
		$language_ext = "_".$language['lang_shortcut'];
		$this->data['lang_use'] = $language;
		$this->lang->load('general', $language['lang_shortcut']);
		$this->lang->load('project', $language['lang_shortcut']);
		$this->data['lang'] = $this->lang;
		$this->data['lang_label'] = get_lang_label(base_url().'%l/project/'.$page, array(), $this->data['language'], $language);
		
		$this->data['style'] = array('style_blog');
		$this->data['project'] = $this->project_model->get_list(array('blog'), ($page -1) * $this->limit, $this->limit);
		$i = 0;
		foreach ($this->data['project'] as $p){
			$this->data['project'][$i]['body'] = word_limiter(Blog_parser::pure_text(read_file("./content/article/".$p['blog_id']."/bodyTextarea".$language_ext.".txt"), $p['blog_id'], $language_ext), 50);
			$this->data['project'][$i]['link'] = $this->project_in_link_model->get_for_project($p['id'], array('link'));
			$i++;
		}
		if ($page < 1){
			$page = 1;
		}
		$this->data['page'] = $page;
		$this->data['page_offset'] = 3;
		$this->data['last_page'] = ceil($this->project_model->count_all() / $this->limit);
		
		$layout_data['title'] = $this->lang->line('project_title');
		$layout_data['links'] = $this->load->view("shk/templates/links", $this->data, true);
		$layout_data['header'] = $this->load->view("shk/templates/header", $this->data, true);
		$layout_data['body'] = $this->load->view("shk/project/body_index", $this->data, true);
		$layout_data['menu'] = $this->load->view("shk/templates/menu", $this->data, true);
		$layout_data['footer'] = $this->load->view("shk/templates/footer", $this->data, true);
		$this->load->view("layout/default", $layout_data);
	}
	
	public function view($slug, $page = 1, $language = ""){
		//working with language
		$language = valid_language($language);
		$language_ext = "_".$language['lang_shortcut'];
		$this->data['lang_use'] = $language;
		$this->lang->load('general', $language['lang_shortcut']);
		$this->lang->load('project', $language['lang_shortcut']);
		$this->data['lang'] = $this->lang;
		
		//explode slug and get id from it
		$expl = explode("-", $slug);
		$slug_id = $expl[sizeof($expl) - 1];
		unset($expl[sizeof($expl) - 1]);
		$slug = implode('-', $expl);
		//lang label link
		$replace = array();
		foreach ($this->data['language'] as $l){
			$replace[$l['lang_shortcut']] = array(
					'%s' => get_lang_slug($slug_id, $l['id'])."-".$slug_id,
			);
		}
		$this->data['lang_label'] = get_lang_label(base_url().'%l/project/view/'.$page.'/%s', $replace, $this->data['language'], $language);
		
		$this->data['style'] = array('style_blog');
		$this->data['project'] = $this->project_model->get_by_name($slug_id, array());
		$this->data['blog'] = $this->blog_model->get_list_by_project($this->data['project']['id'], array(), ($page -1) * $this->limit, $this->limit);
		$i = 0;
		foreach ($this->data['blog'] as $b){
			$this->data['blog'][$i]['title'] = Blog_parser::pure_text(get_lang_value($b['blog_name'], $language['id']), $b['id'], $language_ext);
			$this->data['blog'][$i]['body'] = word_limiter(Blog_parser::pure_text(read_file("./content/article/".$b['id']."/bodyTextarea".$language_ext.".txt"), $b['id'], $language_ext), 50);
			$i++;
		}
		if ($page < 1){
			$page = 1;
		}
		$this->data['page'] = $page;
		$this->data['page_offset'] = 3;
		$this->data['last_page'] = ceil($this->blog_model->count_all_by_project($this->data['project']['id']) / $this->limit);
	
		$layout_data['title'] = "SHK | ".get_lang_value($this->data['project']['project_name'], $language['id']);
		$layout_data['links'] = $this->load->view("shk/templates/links", $this->data, true);
		$layout_data['header'] = $this->load->view("shk/templates/header", $this->data, true);
		$layout_data['body'] = $this->load->view("shk/project/body_view", $this->data, true);
		$layout_data['menu'] = $this->load->view("shk/templates/menu", $this->data, true);
		$layout_data['footer'] = $this->load->view("shk/templates/footer", $this->data, true);
		$this->load->view("layout/default", $layout_data);
	}
	
	public function gallery($slug, $language = ""){
		//working with language
		$language = valid_language($language);
		$language_ext = "_".$language['lang_shortcut'];
		$this->data['lang_use'] = $language;
		$this->lang->load('general', $language['lang_shortcut']);
		$this->lang->load('project', $language['lang_shortcut']);
		$this->data['lang'] = $this->lang;
	
		//explode slug and get id from it
		$expl = explode("-", $slug);
		$slug_id = $expl[sizeof($expl) - 1];
		unset($expl[sizeof($expl) - 1]);
		$slug = implode('-', $expl);
		//lang label link
		$replace = array();
		foreach ($this->data['language'] as $l){
			$replace[$l['lang_shortcut']] = array(
					'%s' => get_lang_slug($slug_id, $l['id'])."-".$slug_id,
			);
		}
		$this->data['lang_label'] = get_lang_label(base_url().'%l/project/gallery/%s', $replace, $this->data['language'], $language);
	
		$this->data['style'] = array('style_blog', 'style_gallery');
		$this->data['jscript'] = array('jscript_gallery');
		$this->data['project'] = $this->project_model->get_by_name($slug_id, array());
		$this->data['gallery'] = $this->gallery_model->get_by_project($this->data['project']['id']);
		$this->data['block_header_title'] = get_lang_value($this->data['project']['project_name'], $language['id'])." ".$this->lang->line('project_gallery');
		
		$layout_data['title'] = "SHK | ".get_lang_value($this->data['project']['project_name'], $language['id']);
		$layout_data['links'] = $this->load->view("shk/templates/links", $this->data, true);
		$layout_data['header'] = $this->load->view("shk/templates/header", $this->data, true);
		$layout_data['body'] = $this->load->view("shk/project/body_gallery", $this->data, true);
		$layout_data['menu'] = $this->load->view("shk/templates/menu", $this->data, true);
		$layout_data['footer'] = $this->load->view("shk/templates/footer", $this->data, true);
		$this->load->view("layout/default", $layout_data);
	}
}