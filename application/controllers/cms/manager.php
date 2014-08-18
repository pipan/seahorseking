<?php
class Manager extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		
		$this->load->model('user_model');
		
		$this->lang->load("general", "en");
		$this->data['lang'] = $this->lang;
	}
	
	public function index(){
		if (is_admin_login($this)){
			$layout_data['title'] = "SHK | manager";
			$layout_data['header'] = $this->load->view("cms/templates/header", $this->data, true);
			$layout_data['body'] = $this->load->view("cms/manager/body", $this->data, true);
			$layout_data['menu'] = $this->load->view("cms/templates/menu", $this->data, true);
			$layout_data['footer'] = $this->load->view("cms/templates/footer", $this->data, true);
			$this->load->view("layout/cms_default", $layout_data);
		}
		else{
			redirect("cms/login");
		}
	}
}