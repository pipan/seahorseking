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
<!-- 
<div style="position: absolute; top: 0px; right: 80px;">
	<input type="text" name="font" onInput="change_font(this);" />
</div>
 -->
<div id="logo">
	<a href="<?php echo base_url().$lang_use['lang_shortcut'];?>">
		<div id="header-logo">
			<img id="header-logo-image" src="<?php echo assets_url()."image/shk_logo.png";?>" alt="SeaHorseKing Logo">
		</div>
		<div id="header-logo-text">
			Seahorse King
		</div>
	</a>
</div>
<div id="logo_small">
	<a href="<?php echo base_url().$lang_use['lang_shortcut'];?>">
		<img id="header-logo-small" src="<?php echo assets_url()."image/shk_logo.png";?>" alt="SeaHorseKing Logo">
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
	<a href="<?php echo base_url().$lang_use['lang_shortcut']."/member";?>" class="<?php echo header_menu_class($header_menu_clicked, 'member');?>"><?php echo $lang->line('header_menu_member');?></a>
	<?php 
	if (isset($static_page)){
		foreach ($static_page as $page){
			$db_lang = get_lang_db($page['page_title'], $lang_use['id']);
			?>
			<a href="<?php echo base_url().$lang_use['lang_shortcut']."/".$db_lang['slug']."-".$page['page_title'];?>" class="<?php echo header_menu_class($header_menu_clicked, $page['folder']);?>"><?php echo $db_lang['lang_value'];?></a>
			<?php
		}
	}
	?>
</div>
