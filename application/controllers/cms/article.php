<?php
class Article extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('text');
		$this->load->library('form_validation');
		$this->load->library('blog_parser');
		
		$this->load->model("language_model");
		$this->load->model('translation_group_model');
		$this->load->model('translation_model');
		$this->load->model("user_model");
		$this->load->model("blog_model");
		$this->load->model('project_model');
		$this->load->model("tag_model");
		$this->load->model("blog_in_tag_model");
		
		$this->data['header_menu_clicked'] = "article";
	}
	
	public function index(){
		if (is_admin_login($this)){
			$this->data['style'] = array('style_blog');
			$this->data['blog'] = $this->blog_model->get(array('project'));
			$this->data['language'] = $this->language_model->get();
			$layout_data['title'] = "SHK | article";
			$layout_data['header'] = $this->load->view("cms/templates/header", $this->data, true);
			$layout_data['body'] = $this->load->view("cms/article/body_index", $this->data, true);
			$layout_data['menu'] = $this->load->view("cms/article/menu", $this->data, true);
			$layout_data['footer'] = $this->load->view("cms/templates/footer", $this->data, true);
			$this->load->view("layout/cms_default", $layout_data);
		}
		else{
			redirect("cms/login");
		}
	}
	
	public function change($id = 0, $language = ""){
		if (is_admin_login($this)){
			$language = valid_language_id($language);
			$this->data['project_language'] = $language;
			$default_lang = $this->language_model->get_default();
			
			$this->data['jscript'] = array('jscript_blog_oop', 'jscript_editor');
			$this->data['style'] = array('style_blog', 'style_blog_edit');
			
			if ($id == 0 || $this->blog_model->exists($id)){
				if ($id == 0){
					$this->data['blog_title'] = "Title";
					$this->data['blog_body'] = "Body";
				}
				else{
					$lang_ext = "_".$language['lang_shortcut'];
					$default_lang_ext = "_".$default_lang['lang_shortcut'];
					$this->data['blog'] = $this->blog_model->get(array(), $id);
					$this->data['series_id'] = 0;
					if ($this->data['blog']['project_id'] != null){
						$this->data['series_id'] = $this->data['blog']['project_id'];
					}
					$this->data['thumbnail'] = 0;
					if (file_exists("./content/article/".$id."/titleTextarea".$lang_ext.".txt")){
						$this->data['blog_title'] = read_file("./content/article/".$id."/titleTextarea".$lang_ext.".txt");
					}
					else{
						$this->data['blog_title'] = read_file("./content/article/".$id."/titleTextarea".$default_lang_ext.".txt");
					}
					if (file_exists("./content/article/".$id."/bodyTextarea".$lang_ext.".txt")){
						$this->data['blog_body'] = read_file("./content/article/".$id."/bodyTextarea".$lang_ext.".txt");
					}
					else{
						$this->data['blog_body'] = read_file("./content/article/".$id."/bodyTextarea".$default_lang_ext.".txt");
					}
					if (file_exists("./content/article/".$id."/link".$lang_ext.".txt")){
						$this->data['blog_link'] = Blog_parser::parse_link(read_file("./content/article/".$id."/link".$lang_ext.".txt"));
					}
					else{
						$this->data['blog_link'] = Blog_parser::parse_link(read_file("./content/article/".$id."/link".$default_lang_ext.".txt"));
					}
					if (file_exists("./content/article/".$id."/image".$lang_ext.".txt")){
						$this->data['blog_image'] = Blog_parser::parse_image(read_file("./content/article/".$id."/image".$lang_ext.".txt"));
					}
					else{
						$this->data['blog_image'] = Blog_parser::parse_image(read_file("./content/article/".$id."/image".$default_lang_ext.".txt"));
					}
					if (file_exists("./content/article/".$id."/video".$lang_ext.".txt")){
						$this->data['blog_video'] = Blog_parser::parse_video(read_file("./content/article/".$id."/video".$lang_ext.".txt"));
					}
					else{
						$this->data['blog_video'] = Blog_parser::parse_video(read_file("./content/article/".$id."/video".$default_lang_ext.".txt"));
					}
					$blog_tag_data = array(
							'blog_id' => $id,
							'lang_id' => $language['id'],
					);
					$this->data['blog_tag'] = $this->blog_in_tag_model->get_by_data($blog_tag_data);
					$this->data['blog_id'] = $id;
					$this->data['blog_lang'] = $language['id'];
				}
			
				$this->data['project'] = $this->project_model->get();
				$layout_data['title'] = "SHK | article";
				$layout_data['header'] = $this->load->view("cms/templates/header", $this->data, true);
				$layout_data['body'] = $this->load->view("cms/article/body_load", $this->data, true);
				$layout_data['body'] .= $this->load->view("cms/article/body_change", $this->data, true);
				$layout_data['menu'] = $this->load->view("cms/article/menu_edit", $this->data, true);
				$layout_data['footer'] = $this->load->view("cms/templates/footer", $this->data, true);
				$this->load->view("layout/cms_default", $layout_data);
			}
			else{
				$layout_data['title'] = "SHK | article";
				$layout_data['header'] = $this->load->view("cms/templates/header", $this->data, true);
				$layout_data['body'] = $this->load->view("cms/templates/body_wrong_id", $this->data, true);
				$layout_data['menu'] = $this->load->view("cms/article/menu", $this->data, true);
				$layout_data['footer'] = $this->load->view("cms/templates/footer", $this->data, true);
				$this->load->view("layout/cms_default", $layout_data);
			}
		}
		else{
			redirect("admin/manager/login");
		}
	}
	
	public function save_new_blog($edit_id = 0, $language = ""){
		if (is_admin_login($this)){
			$language = valid_language_id($language);
			$this->data['language'] = $language;
			
			if ($edit_id == 0 || $this->blog_model->exists($edit_id)){
				$this->form_validation->set_rules('title', 'title', 'required|max_length[70]');
				$this->form_validation->set_rules('titleTextarea', 'textarea title', 'required');
				$this->form_validation->set_rules('body', 'body', 'required');
				$this->form_validation->set_rules('bodyTextarea', 'textarea body', 'required');
				$this->form_validation->set_rules('thumbnail', 'image thumbnail', '');
				
				if ($this->form_validation->run() === FALSE){
					$log = "ID: ".$edit_id.PHP_EOL;
					$log .= "TITLE: ".$this->input->post('title').PHP_EOL;
					$log .= "TITLE_TEXTAREA: ".$this->input->post('titleTextarea').PHP_EOL;
					$log .= "BODY: ".$this->input->post('body').PHP_EOL;
					$log .= "BODY_TEXTAREA: ".$this->input->post('bodyTextarea').PHP_EOL;
					$log .= "THUMBNAIL: ".$this->input->post('thumbnail').PHP_EOL;
					$log .= "LANG: ".$this->data['language']['lang_shortcut'].PHP_EOL;
					write_file("./content/article/log/".date("Y-n-d-H-i-s").".txt", $log);
					echo validation_errors();
				}
				else{
					$lang_ext = "_".$language['lang_shortcut'];
					$title = $this->input->post('titleTextarea');
					$thumbnail = null;
					if ($this->input->post('link') != false){
						$i = 1;
						foreach ($this->input->post('link') as $link){
							$title = str_replace("[LINK-".$i."]", $link['text'], $title);
							$i++;
						}
					}
					if ($this->input->post('thumbnail') > 0 && $this->input->post('image') != false && sizeof($this->input->post('image')) >=  $this->input->post('thumbnail')){
						$image = $this->input->post('image');
						$thumbnail = $image[$this->input->post('thumbnail') - 1]['link'];
					}
					
					if ($edit_id == 0){
						$table_data = array();
						$blog_name = $this->translation_group_model->save($table_data);
						$table_data = array(
								'lang_id' => $language['id'],
								'group_id' => $blog_name,
								'lang_value' => $title,
								'slug' => url_title(convert_accented_characters($title), '-', TRUE),
						);
						$this->translation_model->save($table_data);
					}
					else{
						$blog = $this->blog_model->get(array(), $edit_id);
						$blog_name = $blog['blog_name'];
						$table_data = array(
								'lang_value' => $title,
								'slug' => url_title(convert_accented_characters($title), '-', TRUE),
						);
						$this->translation_model->update($table_data, $blog_name, $language['id']);
					}
					
					$project_id = null;
					if ($this->input->post('project') > 0){
						$project_id = $this->input->post('project');
					}
					$table_data = array(
							'thumbnail' => $thumbnail,
							'project_id' => $project_id,
					);
					
					if ($edit_id > 0){
						$id = $this->blog_model->save($table_data, $edit_id);
					}
					else{
						$table_data['user_id'] = $this->session->userdata('admin_id');
						$table_data['post_date'] = date("Y-n-d H:i:s");
						$table_data['blog_name'] = $blog_name;
						$id = $this->blog_model->save($table_data);
						mkdir("./content/article/".$id, 0777);
					}
					write_file("./content/article/".$id."/title".$lang_ext.".txt", $this->input->post('title'));
					write_file("./content/article/".$id."/titleTextarea".$lang_ext.".txt", $this->input->post('titleTextarea'));
					write_file("./content/article/".$id."/body".$lang_ext.".txt", $this->input->post('body'));
					write_file("./content/article/".$id."/bodyTextarea".$lang_ext.".txt", $this->input->post('bodyTextarea'));
					if ($this->input->post('link') != false){
						$linkFileData = "";
						foreach ($this->input->post('link') as $link){
							$linkFileData .= "TEXT: ".$link['text'].PHP_EOL;
							$linkFileData .= "LINK: ".$link['link'].PHP_EOL;
						}
						write_file("./content/article/".$id."/link".$lang_ext.".txt", $linkFileData, 'w+');
					}
					else{
						delete_files("./content/article/".$id."/link".$lang_ext.".txt");
					}
					if ($this->input->post('image') != false){
						$imageFileData = "";
						foreach ($this->input->post('image') as $image){
							$imageFileData .= "TEXT: ".$image['text'].PHP_EOL;
							$imageFileData .= "LINK: ".$image['link'].PHP_EOL;
							$imageFileData .= "WIDTH: ".$image['width'].PHP_EOL;
							$imageFileData .= "ALIGNMENT: ".$image['alignment'].PHP_EOL;
						}
						write_file("./content/article/".$id."/image".$lang_ext.".txt", $imageFileData);
					}
					else{
						delete_files("./content/article/".$id."/image".$lang_ext.".txt");
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
						write_file("./content/article/".$id."/video".$lang_ext.".txt", $videoFileData);
					}
					else{
						delete_files("./content/article/".$id."/video".$lang_ext.".txt");
					}
					if ($edit_id > 0){
						$this->blog_in_tag_model->detach_tags($edit_id, $language['id']);
					}
					else{
						mkdir("./content/article/".$id."/comments", 0755);
					}
					if ($this->input->post('tag') != false){
						foreach ($this->input->post('tag') as $tag){
							$table_data = array(
									'tag_name' => $tag['text'],
									'tag_slug' => url_title(convert_accented_characters($tag['text']), '-', TRUE),
									'lang_id' => $language['id'],
							);
							$tag_id = $this->tag_model->save($table_data);
							$table_data = array(
									'blog_id' => $id,
									'tag_id' => $tag_id,
							);
							$this->blog_in_tag_model->save($table_data);
						}
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