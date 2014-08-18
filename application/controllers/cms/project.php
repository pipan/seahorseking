<?php
class Project extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		
		$this->load->helper('text');
		$this->load->library('form_validation');
		
		$this->load->model('language_model');
		$this->load->model('translation_model');
		$this->load->model('translation_group_model');
		$this->load->model('user_model');
		$this->load->model('blog_model');
		$this->load->model('project_model');
		$this->load->model('user_in_project_model');
		$this->load->model('tag_model');
		$this->load->model('project_in_tag_model');
		$this->load->model('blog_in_tag_model');
		
		$this->data['header_menu_clicked'] = "project";
	}
	
	public function index(){
		if (is_admin_login($this)){
			$this->data['project'] = $this->project_model->get();
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
			$language = $this->language_model->get(array(), $language);
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
					$this->project_model->save($table_data, $id);
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
					$this->project_model->save($table_data, $id);
				}
				redirect("cms/project");
			}
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
			foreach($this->data['language'] as $l){
				$this->form_valiadtion->set_rules('position_'.$l['lang_shortcut'], $l['lang_name'].' position', 'required');
			}
			
			if ($this->form_validation->run() == true){
				if ($id == 0){
					$table_data = array(
							'private_id' => 1,
					);
					$group_id = $this->translation_group->save($table_data);
				}
				redirect("cms/project/position");
			}
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
	
	public function add_member($id){
		if (is_admin_login($this)){
			if ($id > 0 && $this->project_model->exists($id)){
				$this->form_validation->set_rules('user', 'user', 'required');
				
				if ($this->form_validation->run() == true){
					$table_data = array(
							'user_id' => $this->input->post('user'),
							'project_id' => $id,
					);
					$this->user_in_project_model->save($table_data);
					redirect("cms/project/member/".$id);
				}
				$this->data['project'] = $this->project_model->get(array(), $id);
				$this->data['user'] = $this->user_in_project_model->get_not_in_project($id);
				$this->data['block_header_title'] = get_lang_value($this->data['project']['project_name'])." add members";
				$layout_data['title'] = "SHK | project";
				$layout_data['header'] = $this->load->view("cms/templates/header", $this->data, true);
				$layout_data['body'] = $this->load->view("cms/project/body_add_member", $this->data, true);
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
}