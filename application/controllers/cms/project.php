<?php
class Project extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		
		$this->load->helper('text');
		$this->load->helper('image');
		$this->load->helper('db');
		$this->load->library('form_validation');
		
		$this->load->model('language_model');
		$this->load->model('private_label_model');
		$this->load->model('translation_group_model');
		$this->load->model('translation_model');
		$this->load->model('user_model');
		$this->load->model('blog_model');
		$this->load->model('project_model');
		$this->load->model('user_in_project_model');
		$this->load->model('tag_model');
		$this->load->model('project_in_tag_model');
		$this->load->model('blog_in_tag_model');
		$this->load->model('gallery_model');
		$this->load->model('project_in_link_model');
		
		$this->data['header_menu_clicked'] = "project";
	}
	
	public function index(){
		if (is_admin_login($this)){
			$this->data['project'] = $this->project_model->get(array('blog'));
			$this->data['language'] = $this->language_model->get();
			$layout_data['title'] = "SHK | project";
			$layout_data['header'] = $this->load->view("cms/templates/header", $this->data, true);
			$layout_data['body'] = $this->load->view("cms/project/body_index", $this->data, true);
			$layout_data['menu'] = $this->load->view("cms/project/menu", $this->data, true);
			$layout_data['footer'] = $this->load->view("cms/templates/footer", $this->data, true);
			$this->load->view("layout/cms_default", $layout_data);
		}
		else{
			redirect("cms/login");
		}
	}
	
	public function change($id = 0, $language = 0){
		if (is_admin_login($this)){
			$language = valid_language_id($language);
			$this->data['project_language'] = $language;
			if ($id > 0 && $this->project_model->exists($id)){
				$this->data['project'] = $this->project_model->get(array(), $id);
				$this->data['block_header_title'] = "Change project ".$language['lang_name'];
			}
			else{
				$this->data['project'] = array(
						'id' => 0,
						'project_name' => 0,
						'project_status' => 0,
						'project_percentage' => 0,
						'blog_id' => 0,
				);
				$this->data['block_header_title'] = "Add project ".$language['lang_name'];
				$id = 0;
			}
			$this->form_validation->set_rules('name', 'name', 'required');
			$this->form_validation->set_rules('status', 'status', 'required');
			$this->form_validation->set_rules('percentage', 'percentage', 'required|is_natural|less_then[999]');
			$this->form_validation->set_rules('blog', 'blog', '');
			
			if ($this->form_validation->run() == true){
				if ($id == 0){
					$table_data = array();
					$name_id = $this->translation_group_model->save($table_data);
					$status_id = $this->translation_group_model->save($table_data);
					$table_data = array(
							'lang_id' => $language['id'],
							'group_id' => $name_id,
							'lang_value' => $this->input->post('name'),
							'slug' => url_title(convert_accented_characters($this->input->post('name')), '-', TRUE),
					);
					$this->translation_model->save($table_data);
					$table_data = array(
							'lang_id' => $language['id'],
							'group_id' => $status_id,
							'lang_value' => $this->input->post('status'),
							'slug' => null,
					);
					$this->translation_model->save($table_data);
					$blog_id = null;
					if ($this->input->post('blog') != false){
						$blog_id = $this->input->post('blog');
					}
					$table_data = array(
							'project_creator' => $this->session->userdata('admin_id'),
							'project_name' => $name_id,
							'project_date' => date("Y-n-j H:i:s"),
							'project_status' => $status_id,
							'project_percentage' => $this->input->post('percentage'),
							'blog_id' => $blog_id,
					);
					$project_id = $this->project_model->save($table_data, $id);
					mkdir("./content/project/".$project_id, 0777);
					mkdir("./content/project/".$project_id."/gallery", 0777);
				}
				else{
					$name_id = $this->data['project']['project_name'];
					$status_id = $this->data['project']['project_status'];
					$table_data = array(
							'lang_value' => $this->input->post('name'),
							'slug' => url_title(convert_accented_characters($this->input->post('name')), '-', TRUE),
					);
					$this->translation_model->update($table_data, $name_id, $language['id']);
					$table_data = array(
							'lang_value' => $this->input->post('status'),
							'slug' => null,
					);
					$this->translation_model->update($table_data, $status_id, $language['id']);
					$blog_id = null;
					if ($this->input->post('blog') != false){
						$blog_id = $this->input->post('blog');
					}
					$table_data = array(
							'project_name' => $name_id,
							'project_status' => $status_id,
							'project_percentage' => $this->input->post('percentage'),
							'blog_id' => $blog_id,
					);
					$project_id = $this->project_model->save($table_data, $id);
				}
				//delete profiles
				$this->project_in_link_model->detach($project_id);
				//add profiles
				$profiles = $this->link_model->get();
				foreach ($profiles as $p){
					if ($this->input->post('project_link_'.$p['link_name']) != false){
						$table_data = array(
								'link_id' => $p['id'],
								'project_id' => $project_id,
								'link' => $this->input->post('project_link_'.$p['link_name']),
						);
						$this->project_in_link_model->save($table_data);
					}
				}
				$this->session->set_userdata('change', 1);
				redirect("cms/project");
			}
			$this->data['blog'] = $this->blog_model->get_by_project($id);
			$this->data['project_link'] = $this->project_in_link_model->get_for_project($id, array('link'));
			$this->data['link'] = $this->link_model->get();
			$layout_data['title'] = "SHK | project";
			$layout_data['header'] = $this->load->view("cms/templates/header", $this->data, true);
			$layout_data['body'] = $this->load->view("cms/project/body_change", $this->data, true);
			$layout_data['menu'] = $this->load->view("cms/project/menu", $this->data, true);
			$layout_data['footer'] = $this->load->view("cms/templates/footer", $this->data, true);
			$this->load->view("layout/cms_default", $layout_data);
		}
		else{
			redirect("cms/login");
		}
	}
	
	public function position(){
		if (is_admin_login($this)){
			$this->data['language'] = $this->language_model->get();
			$this->data['position'] = $this->translation_group_model->get_private('position');
			$layout_data['title'] = "SHK | project";
			$layout_data['header'] = $this->load->view("cms/templates/header", $this->data, true);
			$layout_data['body'] = $this->load->view("cms/project/body_position", $this->data, true);
			$layout_data['menu'] = $this->load->view("cms/project/menu", $this->data, true);
			$layout_data['footer'] = $this->load->view("cms/templates/footer", $this->data, true);
			$this->load->view("layout/cms_default", $layout_data);
		}
		else{
			redirect("cms/login");
		}
	}
	
	public function position_change($id = 0){
		if (is_admin_login($this)){
			$this->data['language'] = $language = $this->language_model->get();
			$this->data['position'] = array();
			if ($id == 0 || !$this->translation_group_model->exists_private($id, 'position')){
				$id = 0;
				$this->data['block_header_title'] = "Add position";
				foreach($this->data['language'] as $l){
					$this->data['position'][$l['lang_shortcut']] = "";
				}
			}
			else{
				$this->data['block_header_title'] = "Change position";
				foreach($this->data['language'] as $l){
					$this->data['position'][$l['lang_shortcut']] = get_lang_value($id, $l['id']);
				}
			}
			$this->data['position']['id'] = $id;
			foreach($this->data['language'] as $l){
				$this->form_validation->set_rules('position_'.$l['lang_shortcut'], $l['lang_name'].' position', 'required');
			}
			
			if ($this->form_validation->run() == true){
				$position = $this->private_label_model->get_by_label('position');
				if ($id == 0){
					$table_data = array(
							'private_id' => $position['id'],
					);
					$group_id = $this->translation_group_model->save($table_data);
				}
				else{
					$group_id = $id;
				}
				foreach($this->data['language'] as $l){
					if ($id == 0){
						$table_data = array(
								'lang_id' => $l['id'],
								'group_id' => $group_id,
								'lang_value' => $this->input->post('position_'.$l['lang_shortcut']),
								'slug' => null,
						);
						$this->translation_model->save($table_data);
					}
					else{
						$table_data = array(
								'lang_value' => $this->input->post('position_'.$l['lang_shortcut']),
								'slug' => null,
						);
						$this->translation_model->update($table_data, $group_id, $l['id']);
					}
				}
				redirect("cms/project/position");
			}
			$layout_data['title'] = "SHK | project";
			$layout_data['header'] = $this->load->view("cms/templates/header", $this->data, true);
			$layout_data['body'] = $this->load->view("cms/project/body_position_change", $this->data, true);
			$layout_data['menu'] = $this->load->view("cms/project/menu", $this->data, true);
			$layout_data['footer'] = $this->load->view("cms/templates/footer", $this->data, true);
			$this->load->view("layout/cms_default", $layout_data);
		}
		else{
			redirect("cms/login");
		}
	}
	
	public function member($id){
		if (is_admin_login($this)){
			if ($id > 0 && $this->project_model->exists($id)){
				$this->data['project'] = $this->project_model->get(array(), $id);
				$this->data['member'] = $this->user_in_project_model->get_in_project($id);
				$this->data['block_header_title'] = get_lang_value($this->data['project']['project_name'])." members";
				$layout_data['title'] = "SHK | project";
				$layout_data['header'] = $this->load->view("cms/templates/header", $this->data, true);
				$layout_data['body'] = $this->load->view("cms/project/body_member", $this->data, true);
				$layout_data['menu'] = $this->load->view("cms/project/menu", $this->data, true);
				$layout_data['footer'] = $this->load->view("cms/templates/footer", $this->data, true);
				$this->load->view("layout/cms_default", $layout_data);
			}
			else{
				$layout_data['title'] = "SHK | project";
				$layout_data['header'] = $this->load->view("cms/templates/header", $this->data, true);
				$layout_data['body'] = $this->load->view("cms/templates/body_wrong_id", $this->data, true);
				$layout_data['menu'] = $this->load->view("cms/project/menu", $this->data, true);
				$layout_data['footer'] = $this->load->view("cms/templates/footer", $this->data, true);
				$this->load->view("layout/cms_default", $layout_data);
			}
		}
		else{
			redirect("cms/login");
		}
	}
	
	public function change_member($id, $uip_id = 0){
		if (is_admin_login($this)){
			if ($id > 0 && $this->project_model->exists($id)){
				$this->data['project'] = $this->project_model->get(array(), $id);
				if ($uip_id > 0 && $this->user_in_project_model->exists($uip_id)){
					$this->data['member'] = $this->user_in_project_model->get(array(), $uip_id);
					$this->data['block_header_title'] = get_lang_value($this->data['project']['project_name'])." change members";
				}
				else{
					$uip_id = 0;
					$this->data['block_header_title'] = get_lang_value($this->data['project']['project_name'])." add members";
					$this->data['member'] = array(
							'id' => 0, 
					);
				}
				$this->form_validation->set_rules('user', 'user', 'required');
				$this->form_validation->set_rules('position', 'position', '');
	
				if ($this->form_validation->run() == true){
					$table_data = array(
							'user_id' => $this->input->post('user'),
							'position_id' => $this->input->post('position'),
							'project_id' => $id,
					);
					$this->user_in_project_model->save($table_data, $uip_id);
					redirect("cms/project/member/".$id);
				}
				if ($uip_id == 0){
					$this->data['users'] = $this->user_in_project_model->get_not_in_project($id);
				}
				else{
					$uip = $this->user_in_project_model->get(array(), $uip_id);
					$this->data['user'] = $this->user_model->get(array(), $uip['user_id']);
				}
				$this->data['position'] = $this->translation_group_model->get_private('position');
				$layout_data['title'] = "SHK | project";
				$layout_data['header'] = $this->load->view("cms/templates/header", $this->data, true);
				$layout_data['body'] = $this->load->view("cms/project/body_member_change", $this->data, true);
				$layout_data['menu'] = $this->load->view("cms/project/menu", $this->data, true);
				$layout_data['footer'] = $this->load->view("cms/templates/footer", $this->data, true);
				$this->load->view("layout/cms_default", $layout_data);
			}
			else{
				$layout_data['title'] = "SHK | project";
				$layout_data['header'] = $this->load->view("cms/templates/header", $this->data, true);
				$layout_data['body'] = $this->load->view("cms/templates/body_wrong_id", $this->data, true);
				$layout_data['menu'] = $this->load->view("cms/project/menu", $this->data, true);
				$layout_data['footer'] = $this->load->view("cms/templates/footer", $this->data, true);
				$this->load->view("layout/cms_default", $layout_data);
			}
		}
		else{
			redirect("cms/login");
		}
	}
	
	public function remove_member($id){
		if (is_admin_login($this)){
			if ($id > 0 && $this->user_in_project_model->exists($id)){
				$uip = $this->user_in_project_model->get(array(), $id);
				$project_id = $uip['project_id'];
				$this->user_in_project_model->remove($id);
			}
			else{
				$project_id = 0;
			}
			redirect("cms/project/member/".$project_id);
		}
		else{
			redirect("cms/login");
		}
	}
	
	public function gallery($id){
		if (is_admin_login($this)){
			if ($id > 0 && $this->project_model->exists($id)){
				$this->form_validation->set_rules('remove', 'remove', 'required');
				
				if ($this->form_validation->run() == true){
					$gallery = $this->gallery_model->get_by_project($id);
					foreach ($gallery as $g){
						if ($this->input->post('select_'.$g['id']) != false){
							unlink("./content/project/".$id."/gallery/".$g['image']);
							$this->gallery_model->remove($g['id']);
						}
					}
					//redirect("cms/project/gallery/".$id);
				}
				$this->data['style'] = array('style_gallery');
				$this->data['project'] = $this->project_model->get(array(), $id);
				$this->data['gallery'] = $this->gallery_model->get_by_project($id);
				$this->data['block_header_title'] = get_lang_value($this->data['project']['project_name'])." gallery";
				$layout_data['title'] = "SHK | project";
				$layout_data['header'] = $this->load->view("cms/templates/header", $this->data, true);
				$layout_data['body'] = $this->load->view("cms/project/body_gallery", $this->data, true);
				$layout_data['menu'] = $this->load->view("cms/project/menu", $this->data, true);
				$layout_data['footer'] = $this->load->view("cms/templates/footer", $this->data, true);
				$this->load->view("layout/cms_default", $layout_data);
			}
			else{
				$layout_data['title'] = "SHK | project";
				$layout_data['header'] = $this->load->view("cms/templates/header", $this->data, true);
				$layout_data['body'] = $this->load->view("cms/templates/body_wrong_id", $this->data, true);
				$layout_data['menu'] = $this->load->view("cms/project/menu", $this->data, true);
				$layout_data['footer'] = $this->load->view("cms/templates/footer", $this->data, true);
				$this->load->view("layout/cms_default", $layout_data);
			}
		}
		else{
			redirect("cms/login");
		}
	}
	
	public function add_gallery($id){
		if (is_admin_login($this)){
			if ($id > 0 && $this->project_model->exists($id)){
				$this->form_validation->set_rules('save', 'save', 'required');
				
				if ($this->form_validation->run() == true){
					$config['upload_path'] = './content/project/'.$id.'/gallery/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['max_size']	= '1024';
					$this->load->library('upload', $config);
			
					if ($this->upload->do_upload('image')){
						$upload = $this->upload->data();
						$table_data = array(
								'user_id' => $this->session->userdata('admin_id'),
								'project_id' => $id,
								'image' => $upload['file_name'],
								'post_date' => date("Y-n-d H:i:s"),
						);
						$this->gallery_model->save($table_data);
						redirect("cms/project/gallery/".$id);
					}
				}
				$this->data['project'] = $this->project_model->get(array(), $id);
				$this->data['block_header_title'] = get_lang_value($this->data['project']['project_name'])." add to gallery";
				$layout_data['title'] = "SHK | project";
				$layout_data['header'] = $this->load->view("cms/templates/header", $this->data, true);
				$layout_data['body'] = $this->load->view("cms/project/body_add_gallery", $this->data, true);
				$layout_data['menu'] = $this->load->view("cms/project/menu", $this->data, true);
				$layout_data['footer'] = $this->load->view("cms/templates/footer", $this->data, true);
				$this->load->view("layout/cms_default", $layout_data);
			}
			else{
				$layout_data['title'] = "SHK | project";
				$layout_data['header'] = $this->load->view("cms/templates/header", $this->data, true);
				$layout_data['body'] = $this->load->view("cms/templates/body_wrong_id", $this->data, true);
				$layout_data['menu'] = $this->load->view("cms/project/menu", $this->data, true);
				$layout_data['footer'] = $this->load->view("cms/templates/footer", $this->data, true);
				$this->load->view("layout/cms_default", $layout_data);
			}
		}
		else{
			redirect("cms/login");
		}
	}
}