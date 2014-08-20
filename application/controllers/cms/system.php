<?php
class System extends CI_Controller{
	
	public function __construct(){
		parent::__construct();
		$this->load->library('bcrypt');
		$this->load->helper('string');
	}
	
	public function create_table(){
		//Table permission
		$this->db->query("CREATE TABLE IF NOT EXISTS permission(
				id int(9) NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (id))
				COLLATE utf8_general_ci,
				ENGINE innoDB");
		
		//Table user
		$this->db->query("CREATE TABLE IF NOT EXISTS user(
				id int(9) NOT NULL AUTO_INCREMENT,
				email varchar(100) NOT NULL,
				salt varchar(16) NOT NULL,
				password varchar(64) NOT NULL,
				user_nickname varchar(50) NOT NULL,
				user_name varchar(50) NOT NULL,
				user_surname varchar(50) NOT NULL,
				user_gender tinyint(1),
				user_birthday date,
				permission_id int(9) NOT NULL,
				avatar varchar(70),
				PRIMARY KEY (id),
				INDEX user_nickname_id USING BTREE (user_nickname),
				FOREIGN KEY (permission_id) REFERENCES permission(id))
				COLLATE utf8_general_ci,
				ENGINE innoDB");
		
		//Table private_label
		$this->db->query("CREATE TABLE IF NOT EXISTS private_label(
				id int(9) NOT NULL AUTO_INCREMENT,
				label varchar(20) NOT NULL,
				PRIMARY KEY (id))
				COLLATE utf8_general_ci,
				ENGINE innoDB");
		
		//Table language
		$this->db->query("CREATE TABLE IF NOT EXISTS language(
		        id int(9) NOT NULL AUTO_INCREMENT,
		        lang_name varchar(20) NOT NULL,
		        lang_shortcut varchar(2) NOT NULL,
		        lang_default tinyint(1) NOT NULL,
				PRIMARY KEY (id))
				COLLATE utf8_general_ci,
				ENGINE innoDB");
		
		//Table translation_group
		$this->db->query("CREATE TABLE IF NOT EXISTS translation_group(
		        id int(9) NOT NULL AUTO_INCREMENT,
				private_id int(9),
		    	PRIMARY KEY (id),
				FOREIGN KEY (private_id) REFERENCES private_label(id))
				COLLATE utf8_general_ci,
				ENGINE innoDB");
		
		//Table translation
		$this->db->query("CREATE TABLE IF NOT EXISTS translation(
		        id int(9) NOT NULL AUTO_INCREMENT,
		        lang_id int(9) NOT NULL,
		        group_id int(9) NOT NULL,
		        lang_value text NOT NULL,
				slug text,
		    	PRIMARY KEY (id),
		        FOREIGN KEY (lang_id) REFERENCES language(id),
		        FOREIGN KEY (group_id) REFERENCES translation_group(id))
				COLLATE utf8_general_ci,
				ENGINE innoDB");
		
		//Table project
		$this->db->query("CREATE TABLE IF NOT EXISTS project(
		    	id int(9) NOT NULL AUTO_INCREMENT,
		        project_creator int(9) NOT NULL,
				project_name int(9) NOT NULL,
				project_date datetime NOT NULL,
		        project_status int(9),
		        project_percentage int(3) NOT NULL,
				blog_id int(9),
				PRIMARY KEY (id),
				FOREIGN KEY (project_creator) REFERENCES user(id),
		        FOREIGN KEY (project_name) REFERENCES translation_group(id),
		        FOREIGN KEY (project_status) REFERENCES translation_group(id))
				COLLATE utf8_general_ci,
				ENGINE innoDB");
		
		//Table user_in_project
		$this->db->query("CREATE TABLE IF NOT EXISTS user_in_project(
		        id int(9) NOT NULL AUTO_INCREMENT,
		        user_id int(9) NOT NULL,
				project_id int(9) NOT NULL,
				position_id int(9),
				PRIMARY KEY (id),
				FOREIGN KEY (user_id) REFERENCES user(id),
		        FOREIGN KEY (project_id) REFERENCES project(id),
				FOREIGN KEY (position_id) REFERENCES translation_group(id))
				COLLATE utf8_general_ci,
				ENGINE innoDB");
		
		//Table blog
		$this->db->query("CREATE TABLE IF NOT EXISTS blog(
				id int(9) NOT NULL AUTO_INCREMENT,
				user_id int(9) NOT NULL,
				blog_name int(9) NOT NULL,
				post_date datetime,
				thumbnail varchar(100),
				project_id int(9),
				PRIMARY KEY (id),
				FOREIGN KEY (user_id) REFERENCES user(id),
				FOREIGN KEY (blog_name) REFERENCES translation_group(id),
				FOREIGN KEY (project_id) REFERENCES project(id))
				COLLATE utf8_general_ci,
				ENGINE innoDB");
		
		//Table tag
		$this->db->query("CREATE TABLE IF NOT EXISTS tag(
				id int(9) NOT NULL AUTO_INCREMENT,
				tag_name varchar(30) NOT NULL,
				tag_slug varchar(30) NOT NULL,
				lang_id int(9) NOT NULL,
				PRIMARY KEY (id),
				INDEX tag_slug_id USING BTREE (tag_slug, lang_id),
				FOREIGN KEY (lang_id) REFERENCES language(id))
				COLLATE utf8_general_ci,
				ENGINE innoDB");
		
		//Table blog_in_tag
		$this->db->query("CREATE TABLE IF NOT EXISTS blog_in_tag(
				id int(9) NOT NULL AUTO_INCREMENT,
				blog_id int(9) NOT NULL,
				tag_id int(9) NOT NULL,
				PRIMARY KEY (id),
				FOREIGN KEY (blog_id) REFERENCES blog(id),
				FOREIGN KEY (tag_id) REFERENCES tag(id))
				COLLATE utf8_general_ci,
				ENGINE innoDB");
		
		//Table project_in_tag
		$this->db->query("CREATE TABLE IF NOT EXISTS project_in_tag(
				id int(9) NOT NULL AUTO_INCREMENT,
				project_id int(9) NOT NULL,
				tag_id int(9) NOT NULL,
				PRIMARY KEY (id),
				FOREIGN KEY (project_id) REFERENCES project(id),
				FOREIGN KEY (tag_id) REFERENCES tag(id))
				COLLATE utf8_general_ci,
				ENGINE innoDB");
		
		//Table link
		$this->db->query("CREATE TABLE IF NOT EXISTS link(
				id int(9) NOT NULL AUTO_INCREMENT,
				image varchar(50) NOT NULL,
				image_active varchar(50) NOT NULL,
				link_name varchar(30) NOT NULL,
				PRIMARY KEY (id))
				COLLATE utf8_general_ci,
				ENGINE innoDB");
		
		//Table shk_link
		$this->db->query("CREATE TABLE IF NOT EXISTS shk_link(
				id int(9) NOT NULL AUTO_INCREMENT,
				link_id int(9) NOT NULL,
				link varchar(50) NOT NULL,
				PRIMARY KEY (id),
				FOREIGN KEY (link_id) REFERENCES link(id) ON DELETE CASCADE)
				COLLATE utf8_general_ci,
				ENGINE innoDB");
		
		//Table user_in_link
		$this->db->query("CREATE TABLE IF NOT EXISTS user_in_link(
				id int(9) NOT NULL AUTO_INCREMENT,
				link_id int(9) NOT NULL,
				user_id int(9) NOT NULL,
				link varchar(50) NOT NULL,
				PRIMARY KEY (id),
				FOREIGN KEY (link_id) REFERENCES link(id) ON DELETE CASCADE,
				FOREIGN KEY (user_id) REFERENCES user(id))
				COLLATE utf8_general_ci,
				ENGINE innoDB");
		
		//Table gallery
		$this->db->query("CREATE TABLE IF NOT EXISTS gallery(
				id int(9) NOT NULL AUTO_INCREMENT,
				user_id int(9) NOT NULL,
				project_id int(9) NOT NULL,
				image varchar(70) NOT NULL,
				post_date datetime NOT NULL,
				PRIMARY KEY (id),
				FOREIGN KEY (user_id) REFERENCES user(id),
				FOREIGN KEY (project_id) REFERENCES project(id))
				COLLATE utf8_general_ci,
				ENGINE innoDB");
		
		//ADD foreign key to project
		$this->db->query("ALTER TABLE project
				ADD FOREIGN KEY (blog_id) REFERENCES blog(id)");
	}
	
	public function insert_into(){
		//empty tables
		$this->db->empty_table('user');
		$this->db->empty_table('permission');
		$this->db->empty_table('language');
		$this->db->empty_table('private_label');
		
		//permission
		$data = array(
				'id' => 1,
		);
		$this->db->insert('permission', $data);
		
		//user
		$salt = random_string('alnum', 16);
		$data = array(
				'id' => '1',
				'email' => 'peto.gas@centrum.sk',
				'user_nickname' => 'pipan',
				'user_name' => 'Peter',
				'user_surname' => 'Gasparik',
				'salt' => $salt,
				'password' => $this->bcrypt->hash_password("pipan93".$salt),
				'permission_id' => 1,
		);
		$this->db->insert('user', $data);
		mkdir("./content/member/1", 0755);
		
		//language
		$data = array(
				'id' => '1',
				'lang_name' => 'slovencina',
				'lang_shortcut' => 'sk',
				'lang_default' => '1',
		);
		$this->db->insert('language', $data);
		$data = array(
				'id' => '2',
				'lang_name' => 'enlish',
				'lang_shortcut' => 'en',
				'lang_default' => '0',
		);
		$this->db->insert('language', $data);
		
		//private_label
		$data = array(
				'label' => 'position',
		);
		$this->db->insert('private_label', $data);
	}
}