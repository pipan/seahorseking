<div class="list">
	<div class="listName"> 
	<?php echo $lang->line('menu_ongoing_project');?>
	</div>
	<ul>
	<?php
	if (isset($ongoing_project)){
		foreach ($ongoing_project as $p){
			?>
			<li><a href="<?php echo base_url().$lang_use['lang_shortcut']."/project/view/".get_lang_slug($p['project_name'], $lang_use['id'])."-".$p['project_name'];?>"><?php echo get_lang_value($p['project_name'], $lang_use['id']);?></a></li>
			<?php
		}
	}
	?>
	</ul>
</div>