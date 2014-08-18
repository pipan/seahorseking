<div id="logo">
	<a href="<?php echo base_url()."index.php";?>">
		<img src="<?php echo assets_url()."image/logo.png";?>" alt="SeaHorseKing Logo">
	</a>
</div>
<div id="header-menu">
	<?php 
	if (!isset($header_menu_clicked)){
		$header_menu_clicked = "";
	}
	?>
	<a href="" class="<?php echo header_menu_class($header_menu_clicked, 'article');?>"><?php echo $lang->line('header_menu_article');?></a>
	<a href="" class="<?php echo header_menu_class($header_menu_clicked, 'project');?>"><?php echo $lang->line('header_menu_project');?></a>
	<a href="" class="<?php echo header_menu_class($header_menu_clicked, 'about');?>"><?php echo $lang->line('header_menu_about');?></a>
	<a href="" class="<?php echo header_menu_class($header_menu_clicked, 'member');?>"><?php echo $lang->line('header_menu_member');?></a>
	<a href="" class="<?php echo header_menu_class($header_menu_clicked, 'contact');?>"><?php echo $lang->line('header_menu_contact');?></a>
</div>