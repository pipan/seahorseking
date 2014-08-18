<?php
class Link extends CI_Controller{
	
	public $data;
	
	public function __construct(){
		parent::__construct();
		
		$this->load->library('form_validation');
		
		$this->load->model('link_model');
		$this->load->model('shk_link_model');
	}
	
	public function index(){
		if (is_admin_login($this)){

			$this->data['header_menu_clicked'] = "link";
			$this->data['link'] = $this->link_model->get();
			$layout_data['title'] = "SHK | link";
			$layout_data['header'] = $this->load->view("cms/templates/header", $this->data, true);
			$layout_data['body'] = $this->load->view("cms/link/body_index", $this->data, true);
			$layout_data['menu'] = $this->load->view("cms/link/menu", $this->data, true);
			$layout_data['footer'] = $this->load->view("cms/templates/footer", $this->data, true);
			$this->load->view("layout/cms_default", $layout_data);
		}
		else{
			redirect("cms/login");
		}
	}
	
	public function change($id = 0){
		if (is_admin_login($this)){
			if ($id > 0 && $this->link_model->exists($id)){
				$this->data['link'] = $this->link_model->get(array(), $id);
				$this->data['block_header_title'] = "Change link";
			}
			else{
				$this->data['link'] = array(
						'id' => 0,
						'link_name' => "",
						'image' => "",
						'image_active' => "",
				);
				$this->data['block_header_title'] = "Add link";
				$id = 0;
			}
			
			$config['upload_path'] = './assets/image/link/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size']	= '1024';
			$this->load->library('upload', $config);
			$this->form_validation->set_rules('name', 'name', 'required|max_length[30]');
			
			if ($this->form_validation->run() == true){
				//image
				$link = $this->link_model->get(array(), $id);
				if ($this->upload->do_upload('image') && strlen($this->upload->data()['file_name']) <= 50){
					//delete previous avatar
					if ($id > 0 && $link['image'] != null){
						delete_files("./assets/image/link/".$link['image']);
					}
					$table_data['image'] = $this->upload->data()['file_name'];
				}
				//image active
				if ($this->upload->do_upload('image_active') && strlen($this->upload->data()['file_name']) <= 50){
					//delete previous avatar
					if ($id > 0 && $link['image_active'] != null){
						delete_files("./assets/image/link/".$link['image_active']);
					}
					$table_data['image_active'] = $this->upload->data()['file_name'];
				}
				$table_data['link_name'] = $this->input->post('name');
				$this->link_model->save($table_data, $id);
				redirect("cms/link");
			}
			$this->data['header_menu_clicked'] = "link";
			$layout_data['title'] = "SHK | link";
			$layout_data['header'] = $this->load->view("cms/templates/header", $this->data, true);
			$layout_data['body'] = $this->load->view("cms/link/body_change", $this->data, true);
			$layout_data['menu'] = $this->load->view("cms/link/menu", $this->data, true);
			$layout_data['footer'] = $this->load->view("cms/templates/footer", $this->data, true);
			$this->load->view("layout/cms_default", $layout_data);
		}
		else{
			redirect("cms/login");
		}
	}
	
	public function shk(){
		if (is_admin_login($this)){
			$this->form_validation->set_rules('save', 'save', 'required');
				
			if ($this->form_validation->run() == true){
				//delete profiles
				$this->shk_link_model->detach();
				//add profiles
				$profiles = $this->link_model->get();
				foreach ($profiles as $p){
					if ($this->input->post('profile_link_'.$p['link_name']) != false){
						$table_data = array(
								'link_id' => $p['id'],
								'link' => $this->input->post('profile_link_'.$p['link_name']),
						);
						$this->shk_link_model->save($table_data);
					}
				}
				redirect("cms/link");
			}
			$this->data['header_menu_clicked'] = "link";
			$layout_data['title'] = "SHK | shk link";
			$this->data['profile_link'] = $this->shk_link_model->get(array('link'));
			$layout_data['header'] = $this->load->view("cms/templates/header", $this->data, true);
			$layout_data['body'] = $this->load->view("cms/link/body_shk", $this->data, true);
			$layout_data['menu'] = $this->load->view("cms/link/menu", $this->data, true);
			$layout_data['footer'] = $this->load->view("cms/templates/footer", $this->data, true);
			$this->load->view("layout/cms_default", $layout_data);
		}
		else{
			redirect("cms/login");
		}
	}
}