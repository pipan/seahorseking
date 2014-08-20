<?php
class Member extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
	
		$this->load->library('form_validation');
		$this->load->library('bcrypt');
	
		$this->load->model('language_model');
		$this->load->model('translation_group_model');
		$this->load->model('translation_model');
		$this->load->model('permission_model');
		$this->load->model('user_model');
	
		$this->data['header_menu_clicked'] = "member";
	}
	
	public function index(){
		if (is_admin_login($this)){
			$this->data['member'] = $this->user_model->get();
			$layout_data['title'] = "SHK | member";
			$layout_data['header'] = $this->load->view("cms/templates/header", $this->data, true);
			$layout_data['body'] = $this->load->view("cms/member/body_index", $this->data, true);
			$layout_data['menu'] = $this->load->view("cms/member/menu", $this->data, true);
			$layout_data['footer'] = $this->load->view("cms/templates/footer", $this->data, true);
			$this->load->view("layout/cms_default", $layout_data);
		}
		else{
			redirect("cms/login");
		}
	}
	
	public function change($id){
		if (is_admin_login($this)){
			if ($id > 0 && $this->user_model->exists($id)){
				$this->form_validation->set_rules('permission', 'permission', 'required|is_natural');
				
				if ($this->form_validation->run() == true){
					$table_data = array(
							'permission_id' => $this->input->post('permission'),
					);
					$this->user_model->save($table_data, $id);
					redirect("cms/member");
				}
				$this->data['member'] = $this->user_model->get(array(), $id);
				$this->data['permission'] = $this->permission_model->get();
				$this->data['block_header_title'] = "Change member ".$this->data['member']['user_nickname'];
				$layout_data['title'] = "SHK | member";
				$layout_data['header'] = $this->load->view("cms/templates/header", $this->data, true);
				$layout_data['body'] = $this->load->view("cms/member/body_change", $this->data, true);
				$layout_data['menu'] = $this->load->view("cms/member/menu", $this->data, true);
				$layout_data['footer'] = $this->load->view("cms/templates/footer", $this->data, true);
				$this->load->view("layout/cms_default", $layout_data);
			}
			else{
				$layout_data['title'] = "SHK | member";
				$layout_data['header'] = $this->load->view("cms/templates/header", $this->data, true);
				$layout_data['body'] = $this->load->view("cms/templates/body_wrong_id", $this->data, true);
				$layout_data['menu'] = $this->load->view("cms/member/menu", $this->data, true);
				$layout_data['footer'] = $this->load->view("cms/templates/footer", $this->data, true);
				$this->load->view("layout/cms_default", $layout_data);
			}
		}
		else{
			redirect("cms/login");
		}
	}
	
	public function add(){
		if (is_admin_login($this)){
			$this->form_validation->set_rules('nickname', 'nickname', 'required|max_length[50]');
			$this->form_validation->set_rules('name', 'name', 'required|max_length[50]');
			$this->form_validation->set_rules('surname', 'surname', 'required|max_length[50]');
			$this->form_validation->set_rules('email', 'email', 'required|valid_email|max_length[100]');
			$this->form_validation->set_rules('permission', 'permission', 'required|is_natural');
			
			if ($this->form_validation->run() == true){
				$salt = random_string('alnum', 16);
				$table_data = array(
						'user_nickname' => $this->input->post('nickname'),
						'user_name' => $this->input->post('name'),
						'user_surname' => $this->input->post('surname'),
						'email' => $this->input->post('email'),
						'salt' => $salt,
						'password' => $this->bcrypt->hash_password("password".$salt),
						'permission_id' => $this->input->post('permission'),
				);
				$this->user_model->save($table_data);
				redirect("cms/member");
			}
			$this->data['permission'] = $this->permission_model->get();
			$this->data['block_header_title'] = "Add member ";
			$layout_data['title'] = "SHK | member";
			$layout_data['header'] = $this->load->view("cms/templates/header", $this->data, true);
			$layout_data['body'] = $this->load->view("cms/member/body_add", $this->data, true);
			$layout_data['menu'] = $this->load->view("cms/member/menu", $this->data, true);
			$layout_data['footer'] = $this->load->view("cms/templates/footer", $this->data, true);
			$this->load->view("layout/cms_default", $layout_data);
		}
		else{
			redirect("cms/login");
		}
	}
}