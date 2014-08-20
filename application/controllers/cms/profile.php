<?php
class Profile extends CI_Controller{
	
	public $data;
	
	public function __construct(){
		parent::__construct();
		
		$this->load->helper('db');
		$this->load->library('form_validation');
		$this->load->library('bcrypt');
		
		$this->load->model('language_model');
		$this->load->model('user_model');
		$this->load->model('link_model');
		$this->load->model('user_in_link_model');
	}
	
	public function password_validation(){
		$user = $this->user_model->get_login_by_id($this->session->userdata('admin_id'));
		if ($this->bcrypt->check_password($this->input->post('old_password').$user['salt'], $user['password'])){
			return true;
		}
		$this->form_validation->set_message('password_validation', 'Wrong old password');
		return false;
	}
	
	public function index(){
		if (is_admin_login($this)){
			$this->data['language'] = $this->language_model->get();
			$this->form_validation->set_rules('nickname', 'nickname', 'required|max_length[50]');
			$this->form_validation->set_rules('name', 'name', 'required|max_length[50]');
			$this->form_validation->set_rules('surname', 'surname', 'required|max_length[50]');
			
			if ($this->form_validation->run() == true){
				$gender = null;
				$birthday = null;
				if ($this->input->post('gender') != false){
					$gender = $this->input->post('gender');
				}
				if ($this->input->post('day') != false && $this->input->post('month') != false && $this->input->post('year') != false){
					if (checkdate($this->input->post('month'), $this->input->post('day'), $this->input->post('year'))){
						$birthday = $this->input->post('year')."-".$this->input->post('month')."-".$this->input->post('day');
					}
				}
				$table_data = array(
						'user_nickname' => $this->input->post('nickname'),
						'user_name' => $this->input->post('name'),
						'user_surname' => $this->input->post('surname'),
						'user_gender' => $gender,
						'user_birthday' => $birthday,
				);
				$this->user_model->save($table_data, $this->session->userdata('admin_id'));
				foreach ($this->data['language'] as $l){
					if ($this->input->post('description_'.$l['lang_shortcut']) != false){
						write_file("./content/member/".$this->session->userdata('admin_id')."/description_".$l['lang_shortcut'].".txt", $this->input->post('description_'.$l['lang_shortcut']));
					}
				}
				//delete profiles
				$this->user_in_link_model->detach($this->session->userdata('admin_id'));
				//add profiles
				$profiles = $this->link_model->get();
				foreach ($profiles as $p){
					if ($this->input->post('profile_link_'.$p['link_name']) != false){
						$table_data = array(
								'link_id' => $p['id'],
								'user_id' => $this->session->userdata('admin_id'),
								'link' => $this->input->post('profile_link_'.$p['link_name']),
						);
						$this->user_in_link_model->save($table_data);
					}
				}
				redirect("cms/manager");
			}
			$this->data['header_menu_clicked'] = "profile";
			$this->data['profile'] = $this->user_model->get(array(), $this->session->userdata('admin_id'));
			$this->data['profile_link'] = $this->user_in_link_model->get_for_user($this->session->userdata('admin_id'), array('link'));
			$this->data['link'] = $this->link_model->get();
			$layout_data['title'] = "SHK | profile";
			$layout_data['header'] = $this->load->view("cms/templates/header", $this->data, true);
			$layout_data['body'] = $this->load->view("cms/profile/body_index", $this->data, true);
			$layout_data['menu'] = $this->load->view("cms/profile/menu", $this->data, true);
			$layout_data['footer'] = $this->load->view("cms/templates/footer", $this->data, true);
			$this->load->view("layout/cms_default", $layout_data);
		}
		else{
			redirect("cms/login");
		}
	}
	
	public function password(){
		if (is_admin_login($this)){
			$this->form_validation->set_rules('old_password', 'old password', 'required|callback_password_validation');
			$this->form_validation->set_rules('new_password', 'new password', 'required');
			$this->form_validation->set_rules('repeat_password', 'repeat password', 'required|matches[new_password]');
			
			if ($this->form_validation->run() == true){
				$user = $this->user_model->get_login_by_id($this->session->userdata('admin_id'));
				$table_data = array(
						'password' => $this->bcrypt->hash_password($this->input->post('new_password').$user['salt']),
				);
				$this->user_model->save($table_data, $this->session->userdata('admin_id'));
				redirect("cms/profile");
			}
			$this->data['header_menu_clicked'] = "profile";
			$this->data['profile'] = $this->user_model->get(array(), $this->session->userdata('admin_id'));
			$layout_data['title'] = "SHK | password";
			$layout_data['header'] = $this->load->view("cms/templates/header", $this->data, true);
			$layout_data['body'] = $this->load->view("cms/profile/body_password", $this->data, true);
			$layout_data['menu'] = $this->load->view("cms/profile/menu", $this->data, true);
			$layout_data['footer'] = $this->load->view("cms/templates/footer", $this->data, true);
			$this->load->view("layout/cms_default", $layout_data);
		}
		else{
			redirect("cms/login");
		}
	}
	
	public function email(){
		if (is_admin_login($this)){
			$this->form_validation->set_rules('email', 'email', 'required|valid_email');
				
			if ($this->form_validation->run() == true){
				$table_data = array(
						'email' => $this->input->post('email'),
				);
				$this->user_model->save($table_data, $this->session->userdata('admin_id'));
				redirect("cms/profile");
			}
			$this->data['header_menu_clicked'] = "profile";
			$this->data['profile'] = $this->user_model->get(array(), $this->session->userdata('admin_id'));
			$layout_data['title'] = "SHK | email";
			$layout_data['header'] = $this->load->view("cms/templates/header", $this->data, true);
			$layout_data['body'] = $this->load->view("cms/profile/body_email", $this->data, true);
			$layout_data['menu'] = $this->load->view("cms/profile/menu", $this->data, true);
			$layout_data['footer'] = $this->load->view("cms/templates/footer", $this->data, true);
			$this->load->view("layout/cms_default", $layout_data);
		}
		else{
			redirect("cms/login");
		}
	}
	
	public function avatar(){
		if (is_admin_login($this)){
			$config['upload_path'] = './content/member/'.$this->session->userdata('admin_id').'/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size']	= '1024';
			$this->load->library('upload', $config);
	
			if ($this->upload->do_upload('avatar')){
				$upload = $this->upload->data();
				if (strlen($upload['file_name']) <= 70){
					$user = $this->user_model->get(array(), $this->session->userdata('admin_id'));
					//delete previous avatar
					if ($user['avatar'] != null){
						unlink("./content/member/".$this->session->userdata('admin_id')."/".$user['avatar']);
					}
					$table_data = array(
							'avatar' => $upload['file_name'],
					);
					$this->user_model->save($table_data, $this->session->userdata('admin_id'));
					redirect("cms/profile");
				}
			}
			$this->data['header_menu_clicked'] = "profile";
			$this->data['profile'] = $this->user_model->get(array(), $this->session->userdata('admin_id'));
			$layout_data['title'] = "SHK | email";
			$layout_data['header'] = $this->load->view("cms/templates/header", $this->data, true);
			$layout_data['body'] = $this->load->view("cms/profile/body_avatar", $this->data, true);
			$layout_data['menu'] = $this->load->view("cms/profile/menu", $this->data, true);
			$layout_data['footer'] = $this->load->view("cms/templates/footer", $this->data, true);
			$this->load->view("layout/cms_default", $layout_data);
		}
		else{
			redirect("cms/login");
		}
	}
}