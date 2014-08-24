<?php
class Static_page extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		
		$this->load->helper('text');
		$this->load->library('form_validation');
		
		$this->load->model("language_model");
		$this->load->model('private_label_model');
		$this->load->model('translation_group_model');
		$this->load->model('translation_model');
		$this->load->model('static_page_model');
		
		$this->data['header_menu_clicked'] = "static page";
	}
	
	public function is_unique_folder(){
		$used_folders = array('static_page', 'project', 'article', 'member', 'templates');
		if ($this->static_page_model->exists_by_folder($this->input->post('folder')) || in_array($this->input->post('folder'), $used_folders)){
			$this->form_validation->set_message('is_unique_folder', 'Folder has to hav unique name');
			return false;
		}
		return true;
	}
	
	public function index(){
		if (is_admin_login($this)){
			$this->data['page'] = $this->static_page_model->get();
			$this->data['language'] = $this->language_model->get();
			$layout_data['title'] = "SHK | page";
			$layout_data['header'] = $this->load->view("cms/templates/header", $this->data, true);
			$layout_data['body'] = $this->load->view("cms/static_page/body_index", $this->data, true);
			$layout_data['menu'] = $this->load->view("cms/static_page/menu", $this->data, true);
			$layout_data['footer'] = $this->load->view("cms/templates/footer", $this->data, true);
			$this->load->view("layout/cms_default", $layout_data);
		}
		else{
			redirect("cms/login");
		}
	}
	
	public function add(){
		if (is_admin_login($this)){
			$this->form_validation->set_rules('folder', 'folder', 'required|max_length[30]|callback_is_unique_folder');
			
			if ($this->form_validation->run() == true){
				$static_label = $this->private_label_model->get_by_label('static_page');
				$table_data = array(
						'private_id' => $static_label['id'],
				);
				$group_id = $this->translation_group_model->save($table_data);
				$table_data = array(
						'folder' => $this->input->post('folder'),
						'page_title' => $group_id,
						'post_date' => date("Y-n-d H:i:s"),
				);
				$this->static_page_model->save($table_data);
				mkdir("./application/views/shk/".$this->input->post('folder'), 0777);
				$this->session->set_userdata('change', 1);
				redirect("cms/static_page");
			}
			$this->data['language'] = $this->language_model->get();
			$layout_data['title'] = "SHK | page";
			$layout_data['header'] = $this->load->view("cms/templates/header", $this->data, true);
			$layout_data['body'] = $this->load->view("cms/static_page/body_add", $this->data, true);
			$layout_data['menu'] = $this->load->view("cms/static_page/menu", $this->data, true);
			$layout_data['footer'] = $this->load->view("cms/templates/footer", $this->data, true);
			$this->load->view("layout/cms_default", $layout_data);
		}
		else{
			redirect("cms/login");
		}
	}
	
	public function order(){
		if (is_admin_login($this)){
			$this->data['page'] = $this->static_page_model->get();
			foreach ($this->data['page'] as $p){
				$this->form_validation->set_rules($p['folder'], $p['folder'], 'required|in_natural');
			}
				
			if ($this->form_validation->run() == true){
				foreach ($this->data['page'] as $p){
					$table_data = array(
							'position' => $this->input->post($p['folder']),
					);
					$this->static_page_model->save($table_data, $p['id']);
				}
				redirect("cms/static_page");
			}
			$this->data['language'] = $this->language_model->get();
			$layout_data['title'] = "SHK | page";
			$layout_data['header'] = $this->load->view("cms/templates/header", $this->data, true);
			$layout_data['body'] = $this->load->view("cms/static_page/body_order", $this->data, true);
			$layout_data['menu'] = $this->load->view("cms/static_page/menu", $this->data, true);
			$layout_data['footer'] = $this->load->view("cms/templates/footer", $this->data, true);
			$this->load->view("layout/cms_default", $layout_data);
		}
		else{
			redirect("cms/login");
		}
	}
	
	public function change($id, $language = ""){
		if (is_admin_login($this)){
			$language = valid_language_id($language);
			$this->data['project_language'] = $language;
				
			$this->data['jscript'] = array('jscript_blog_oop', 'jscript_editor');
			$this->data['style'] = array('style_blog', 'style_blog_edit');
			$this->data['url'] = "cms/static_page";
			$this->data['url_save'] = "/save";
				
			if ($this->static_page_model->exists($id)){
				$lang_ext = "_".$language['lang_shortcut'];
				$this->data['page'] = $this->static_page_model->get(array(), $id);
				$this->data['series_id'] = 0;
				$this->data['thumbnail'] = 0;
				$this->data['blog_id'] = $id;
				$this->data['blog_lang'] = $language['id'];
				
				$this->data['blog_title'] = "";
				if (file_exists("./application/views/shk/".$this->data['page']['folder']."/titleTextarea".$lang_ext.".txt")){
					$this->data['blog_title'] = read_file("./application/views/shk/".$this->data['page']['folder']."/titleTextarea".$lang_ext.".txt");
				}
				$this->data['blog_body'] = "";
				if (file_exists("./application/views/shk/".$this->data['page']['folder']."/bodyTextarea".$lang_ext.".txt")){
					$this->data['blog_body'] = read_file("./application/views/shk/".$this->data['page']['folder']."/bodyTextarea".$lang_ext.".txt");
				}
				$this->data['blog_link'] = array();
				if (file_exists("./application/views/shk/".$this->data['page']['folder']."/link".$lang_ext.".txt")){
					$this->data['blog_link'] = Blog_parser::parse_link(read_file("./application/views/shk/".$this->data['page']['folder']."/link".$lang_ext.".txt"));
				}
				$this->data['blog_image'] = array();
				if (file_exists("./application/views/shk/".$this->data['page']['folder']."/image".$lang_ext.".txt")){
					$this->data['blog_image'] = Blog_parser::parse_image(read_file("./application/views/shk/".$this->data['page']['folder']."/image".$lang_ext.".txt"));
				}
				$this->data['blog_video'] = array();
				if (file_exists("./application/views/shk/".$this->data['page']['folder']."/video".$lang_ext.".txt")){
					$this->data['blog_video'] = Blog_parser::parse_video(read_file("./application/views/shk/".$this->data['page']['folder']."/video".$lang_ext.".txt"));
				}
					
				$this->data['project'] = "";
				$layout_data['title'] = "SHK | page";
				$layout_data['header'] = $this->load->view("cms/templates/header", $this->data, true);
				$layout_data['body'] = $this->load->view("cms/article/body_load", $this->data, true);
				$layout_data['body'] .= $this->load->view("cms/article/body_change", $this->data, true);
				$layout_data['menu'] = $this->load->view("cms/article/menu_edit", $this->data, true);
				$layout_data['footer'] = $this->load->view("cms/templates/footer", $this->data, true);
				$this->load->view("layout/cms_default", $layout_data);
			}
			else{
				$layout_data['title'] = "SHK | page";
				$layout_data['header'] = $this->load->view("cms/templates/header", $this->data, true);
				$layout_data['body'] = $this->load->view("cms/templates/body_wrong_id", $this->data, true);
				$layout_data['menu'] = $this->load->view("cms/static_page/menu", $this->data, true);
				$layout_data['footer'] = $this->load->view("cms/templates/footer", $this->data, true);
				$this->load->view("layout/cms_default", $layout_data);
			}
		}
		else{
			redirect("admin/manager/login");
		}
	}
	
	public function save($edit_id, $language = ""){
		if (is_admin_login($this)){
			$language = valid_language_id($language);
			$this->data['language'] = $language;
				
			if ($this->static_page_model->exists($edit_id)){
				$this->form_validation->set_rules('title', 'title', 'required|max_length[70]');
				$this->form_validation->set_rules('titleTextarea', 'textarea title', 'required');
				$this->form_validation->set_rules('body', 'body', 'required');
				$this->form_validation->set_rules('bodyTextarea', 'textarea body', 'required');
	
				if ($this->form_validation->run() === FALSE){
					$log = "ID: ".$edit_id.PHP_EOL;
					$log .= "TITLE: ".$this->input->post('title').PHP_EOL;
					$log .= "TITLE_TEXTAREA: ".$this->input->post('titleTextarea').PHP_EOL;
					$log .= "BODY: ".$this->input->post('body').PHP_EOL;
					$log .= "BODY_TEXTAREA: ".$this->input->post('bodyTextarea').PHP_EOL;
					$log .= "LANG: ".$this->data['language']['lang_shortcut'].PHP_EOL;
					write_file("./content/article/log/".date("Y-n-d-H-i-s").".txt", $log);
					echo validation_errors();
				}
				else{
					$lang_ext = "_".$language['lang_shortcut'];
					$title = $this->input->post('titleTextarea');
					if ($this->input->post('link') != false){
						$i = 1;
						foreach ($this->input->post('link') as $link){
							$title = str_replace("[LINK-".$i."]", $link['text'], $title);
							$i++;
						}
					}
						
					$page = $this->static_page_model->get(array(), $edit_id);
					$page_title = $page['page_title'];
					$table_data = array(
							'lang_value' => $title,
							'slug' => url_title(convert_accented_characters($title), '-', TRUE),
					);
					$this->translation_model->update($table_data, $page_title, $language['id']);
					
					write_file("./application/views/shk/".$page['folder']."/title".$lang_ext.".txt", $this->input->post('title'));
					write_file("./application/views/shk/".$page['folder']."/titleTextarea".$lang_ext.".txt", $this->input->post('titleTextarea'));
					write_file("./application/views/shk/".$page['folder']."/body".$lang_ext.".txt", $this->input->post('body'));
					write_file("./application/views/shk/".$page['folder']."/bodyTextarea".$lang_ext.".txt", $this->input->post('bodyTextarea'));
					if ($this->input->post('link') != false){
						$linkFileData = "";
						foreach ($this->input->post('link') as $link){
							$linkFileData .= "TEXT: ".$link['text'].PHP_EOL;
							$linkFileData .= "LINK: ".$link['link'].PHP_EOL;
						}
						write_file("./application/views/shk/".$page['folder']."/link".$lang_ext.".txt", $linkFileData, 'w+');
					}
					else{
						delete_files("./application/views/shk/".$page['folder']."/link".$lang_ext.".txt");
					}
					if ($this->input->post('image') != false){
						$imageFileData = "";
						foreach ($this->input->post('image') as $image){
							$imageFileData .= "TEXT: ".$image['text'].PHP_EOL;
							$imageFileData .= "LINK: ".$image['link'].PHP_EOL;
							$imageFileData .= "WIDTH: ".$image['width'].PHP_EOL;
							$imageFileData .= "ALIGNMENT: ".$image['alignment'].PHP_EOL;
						}
						write_file("./application/views/shk/".$page['folder']."/image".$lang_ext.".txt", $imageFileData);
					}
					else{
						delete_files("./application/views/shk/".$page['folder']."/image".$lang_ext.".txt");
					}
					if ($this->input->post('video') != false){
						$videoFileData = "";
						foreach ($this->input->post('video') as $video){
							$videoFileData .= "TEXT: ".$video['text'].PHP_EOL;
							$videoFileData .= "LINK: ".$video['link'].PHP_EOL;
							$videoFileData .= "CODE: ".$video['code'].PHP_EOL;
							$videoFileData .= "WIDTH: ".$video['width'].PHP_EOL;
							$videoFileData .= "ALIGNMENT: ".$video['alignment'].PHP_EOL;
						}
						write_file("./application/views/shk/".$page['folder']."/video".$lang_ext.".txt", $videoFileData);
					}
					else{
						delete_files("./application/views/shk/".$page['folder']."/video".$lang_ext.".txt");
					}
					echo "success";
				}
			}
			else{
				echo "fail";
			}
		}
		else{
			redirect("admin/manager/login");
		}
	}
	
	public function error_save(){
		if (is_admin_login($this)){
			$language = "en";
			$this->lang->load("general", $language);
			$data['lang'] = $this->lang;
			$data['language'] = $language;
				
			$data['title'] = "totosomja - blog error";
			$data['functions'] = array(
					array(
							'link' => base_url().'index.php/admin/blog/new_blog',
							'text' => 'new blog',
					),
					array(
							'link' => base_url().'index.php/admin/blog/help',
							'text' => 'help',
					),
			);
	
			$this->load->view("templates/header_manager", $data);
			$this->load->view("manager/blog/error_save", $data);
			$this->load->view("templates/right_body_blog", $data);
			$this->load->view("templates/footer", $data);
		}
		else{
			redirect("admin/manager/login");
		}
	}
}