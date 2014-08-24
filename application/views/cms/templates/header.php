<div id="logout" class="white">
	<a href="<?php echo base_url()."index.php/cms/logout";?>">logout</a>
</div>
<div id="logo">
	<a href="<?php echo base_url()."index.php/cms";?>">
		<div id="header-logo">
			<img id="header-logo-image" src="<?php echo assets_url()."image/shk_logo.png";?>" alt="SeaHorseKing Logo">
		</div>
		<div id="header-logo-text">
			Seahorse King
		</div>
	</a>
</div>
<div id="header-menu">
	<?php 
	if (!isset($header_menu_clicked)){
		$header_menu_clicked = "";
	}
	?>
	<a href="<?php echo base_url()."index.php/cms/profile";?>" class="<?php echo header_menu_class($header_menu_clicked, 'profile');?>">Profile</a>
	<a href="<?php echo base_url()."index.php/cms/member";?>" class="<?php echo header_menu_class($header_menu_clicked, 'member');?>">Members</a>
	<a href="<?php echo base_url()."index.php/cms/article";?>" class="<?php echo header_menu_class($header_menu_clicked, 'article');?>">Articles</a>
	<a href="<?php echo base_url()."index.php/cms/project";?>" class="<?php echo header_menu_class($header_menu_clicked, 'project');?>">Projects</a>
	<a href="<?php echo base_url()."index.php/cms/link";?>" class="<?php echo header_menu_class($header_menu_clicked, 'link');?>">Links</a>
	<a href="<?php echo base_url()."index.php/cms/static_page";?>" class="<?php echo header_menu_class($header_menu_clicked, 'static page');?>">Static pages</a>
</div>