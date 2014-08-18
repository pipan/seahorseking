<?php
class Login extends CI_Controller{
	
	public $data;
	
	public function __construct(){
		parent::__construct();
		
		$this->load->library('form_validation');
		$this->load->library('bcrypt');
		
		$this->load->model('user_model');
		$this->load->model('link_model');
		$this->load->model('shk_link_model');
		
		$this->lang->load("general", "en");
		$this->data['lang'] = $this->lang;
	}
	
	public function login_validation(){
		if ($user = $this->user_model->get_login($this->input->post('name'))){
			if ($this->bcrypt->check_password($this->input->post('password').$user['salt'], $user['password'])){
				return true;
			}
		}
		$this->form_validation->set_message('login_validation', 'Wrong password or login');
		return false;
	}
	
	public function login_session($name){
		$this->session->set_userdata('admin_id', $this->user_model->get_login($name)['id']);
	}
	
	public function index(){
		if (!is_admin_login($this)){
			$this->form_validation->set_rules('name', 'name', 'required');
			$this->form_validation->set_rules('password', 'password', 'required|callback_login_validation');
			
			if ($this->form_validation->run() == false ){
				$this->data['link'] = $this->shk_link_model->get_active(array('link'));
				$layout_data['title'] = "SHK | login";
				$layout_data['links'] = $this->load->view("shk/templates/links", $this->data, true);
				$layout_data['header'] = $this->load->view("shk/templates/header", $this->data, true);
				$layout_data['body'] = $this->load->view("cms/login/body", $this->data, true);
				$layout_data['menu'] = $this->load->view("shk/templates/menu", $this->data, true);
				$layout_data['footer'] = $this->load->view("shk/templates/footer", $this->data, true);		
				$this->load->view("layout/default", $layout_data);
			}
			else{
				$this->login_session($this->input->post('name'));
				redirect("cms/manager");
			}
		}
		else{
			redirect("cms/manager");
		}
	}
	
	public function logout(){
		$this->session->unset_userdata('admin_id');
		redirect("cms/login");
	}
}