<?php
class Article extends CI_Controller{
	
	public $limit = 8;
	
	public function __construct(){
		parent::__construct();
		
		$this->load->helper('text');
		$this->load->helper('builder');
		$this->load->helper('MY_date');
		$this->load->library('blog_parser');
		
		$this->load->model('language_model');
		$this->load->model('user_model');
		$this->load->model('translation_group_model');
		$this->load->model('translation_model');
		$this->load->model('blog_model');
		$this->load->model('project_model');
		$this->load->model('tag_model');
		$this->load->model('blog_in_tag_model');
		
		$this->data['ongoing_project'] = $this->project_model->get();
		$this->data['language'] = $this->language_model->get();
		$this->data['link'] = $this->shk_link_model->get_active(array('link'));
		$this->data['header_menu_clicked'] = "article";
	}
	
	public function index($language = "", $page = 1){
		$language = valid_language($language);
		$language_ext = "_".$language['lang_shortcut'];
		$this->data['lang_use'] = $language;
		$this->lang->load('general', $language['lang_shortcut']);
		$this->lang->load('article', $language['lang_shortcut']);
		$this->data['lang'] = $this->lang;
		$this->data['lang_label'] = get_lang_label(base_url().'index.php/%l/article/'.$page, array(), $this->data['language'], $language);
		
		$this->data['style'] = array('style_blog');
		$this->data['blog'] = $this->blog_model->get_list(array('project'), ($page -1) * $this->limit, $this->limit);
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
		$this->data['last_page'] = ceil($this->blog_model->count_all() / $this->limit);
		
		$layout_data['title'] = $this->lang->line('article_title');
		$layout_data['links'] = $this->load->view("shk/templates/links", $this->data, true);
		$layout_data['header'] = $this->load->view("shk/templates/header", $this->data, true);
		$layout_data['body'] = $this->load->view("shk/article/body_index", $this->data, true);
		$layout_data['menu'] = $this->load->view("shk/templates/menu", $this->data, true);
		$layout_data['footer'] = $this->load->view("shk/templates/footer", $this->data, true);
		$this->load->view("layout/default", $layout_data);
	}
	
	public function view($slug, $language = ""){
		//working with language
		$language = valid_language($language);
		$language_ext = "_".$language['lang_shortcut'];
		$this->data['lang_use'] = $language;
		$this->lang->load('general', $language['lang_shortcut']);
		$this->lang->load('article', $language['lang_shortcut']);
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
		$this->data['lang_label'] = get_lang_label(base_url().'index.php/%l/article/view/%s', $replace, $this->data['language'], $language);
		//set all data
		$this->data['style'] = array('style_blog');
		$this->data['blog'] = $this->blog_model->get_by_blog_name($slug_id, array('project', 'user'));
		$this->data['blog']['title'] = rawUrlDecode(read_file("./content/article/".$this->data['blog']['id']."/title".$language_ext.".txt"));
		$this->data['blog']['body'] = rawUrlDecode(read_file("./content/article/".$this->data['blog']['id']."/body".$language_ext.".txt"));;
		$tag_data = array(
				'blog_id' => $this->data['blog']['id'],
				'lang_id' => $language['id'],
		);
		$this->data['tag'] = $this->blog_in_tag_model->get_by_data($tag_data);
		//fill data to layout
		$layout_data['title'] = "SHK | ".get_lang_value($this->data['blog']['blog_name']);
		$layout_data['links'] = $this->load->view("shk/templates/links", $this->data, true);
		$layout_data['header'] = $this->load->view("shk/templates/header", $this->data, true);
		$layout_data['body'] = $this->load->view("shk/article/body_view", $this->data, true);
		$layout_data['menu'] = $this->load->view("shk/templates/menu", $this->data, true);
		$layout_data['footer'] = $this->load->view("shk/templates/footer", $this->data, true);
		$this->load->view("layout/default", $layout_data);
	}
	
	public function tag($tag, $page = 1, $language = "sk"){
		//working with language
		$language = valid_language($language);
		$language_ext = "_".$language['lang_shortcut'];
		$this->data['lang_use'] = $language;
		$this->lang->load('general', $language['lang_shortcut']);
		$this->lang->load('article', $language['lang_shortcut']);
		$this->data['lang'] = $this->lang;
		$this->data['lang_label'] = get_lang_label(base_url().'index.php/%l/article', array(), $this->data['language'], $language);
		
		if ($page < 1){
			$page = 1;
		}
		$this->data['style'] = array('style_blog');
		$tag_data = array(
				'tag_slug' => $tag,
				'lang_id' => $language['id'],
		);
		$this->data['blog'] = $this->blog_in_tag_model->get_list_by_data(array('tag', 'blog'), $tag_data, ($page - 1) * $this->limit, $this->limit);
		$i = 0;
		foreach ($this->data['blog'] as $b){
			$this->data['blog'][$i]['title'] = Blog_parser::pure_text(get_lang_value($b['blog_name'], $language['id']), $b['blog_id'], $language_ext);
			$this->data['blog'][$i]['body'] = word_limiter(Blog_parser::pure_text(read_file("./content/article/".$b['blog_id']."/bodyTextarea".$language_ext.".txt"), $b['blog_id'], $language_ext), 50);
			$i++;
		}
		$this->data['page'] = $page;
		$this->data['page_offset'] = 3;
		$this->data['last_page'] = ceil($this->blog_in_tag_model->count_all_by_tag_slug($tag) / $this->limit);
		$this->data['tag'] = $tag;
		$this->data['title'] = "SHK | ".$tag;
		
		$layout_data['title'] = $this->lang->line('article_title');
		$layout_data['links'] = $this->load->view("shk/templates/links", $this->data, true);
		$layout_data['header'] = $this->load->view("shk/templates/header", $this->data, true);
		$layout_data['body'] = $this->load->view("shk/article/body_tag", $this->data, true);
		$layout_data['menu'] = $this->load->view("shk/templates/menu", $this->data, true);
		$layout_data['footer'] = $this->load->view("shk/templates/footer", $this->data, true);
		$this->load->view("layout/default", $layout_data);
	}
}