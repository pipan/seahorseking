<div id="language">
	<?php 
	if (isset($lang_label)){
		foreach ($lang_label as $l){
			?>
			<div class="language-label">
				<a class="<?php echo $l['class'];?>" href="<?php echo $l['link'];?>"><?php echo $l['text'];?></a>
			</div>
			<?php 
		}
	}
	?>
</div>
<div id="logo">
	<a href="<?php echo base_url();?>">
		<img src="<?php echo assets_url()."image/logo2.png";?>" alt="SeaHorseKing Logo">
	</a>
</div>
<div id="header-menu">
	<?php 
	if (!isset($header_menu_clicked)){
		$header_menu_clicked = "";
	}
	?>
	<a href="<?php echo base_url().$lang_use['lang_shortcut']."/article";?>" class="<?php echo header_menu_class($header_menu_clicked, 'article');?>"><?php echo $lang->line('header_menu_article');?></a>
	<a href="<?php echo base_url().$lang_use['lang_shortcut']."/project";?>" class="<?php echo header_menu_class($header_menu_clicked, 'project');?>"><?php echo $lang->line('header_menu_project');?></a>
	<a href="<?php echo base_url().$lang_use['lang_shortcut']."/about";?>" class="<?php echo header_menu_class($header_menu_clicked, 'about');?>"><?php echo $lang->line('header_menu_about');?></a>
	<a href="<?php echo base_url().$lang_use['lang_shortcut']."/member";?>" class="<?php echo header_menu_class($header_menu_clicked, 'member');?>"><?php echo $lang->line('header_menu_member');?></a>
	<a href="<?php echo base_url().$lang_use['lang_shortcut']."/contact";?>" class="<?php echo header_menu_class($header_menu_clicked, 'contact');?>"><?php echo $lang->line('header_menu_contact');?></a>
</div>
