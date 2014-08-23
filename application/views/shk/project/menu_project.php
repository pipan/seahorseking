<div class="list">
	<div class="listName"> 
		<?php echo get_lang_value($project['project_name'], $lang_use['id']);?>
		<div class="menu-project-link">
			<?php 
			if (isset($project['link'])){
				foreach ($project['link'] as $l){
					?>
					<div class="menu-project-link-item">
						<a href="<?php echo $l['link'];?>" target="_blank" title="<?php echo $l['link_name'];?>">
				    		<img class="logo" src="<?php echo assets_url()."image/link/".$l['image'];?>" alt="<?php echo $l['link_name'];?>" onMouseOver="setImageByElem(this, '<?php echo "link/".$l['image_active'];?>');" onMouseOut="setImageByElem(this, '<?php echo "link/".$l['image'];?>');" />
				    	</a>
				    </div>
					<?php
				}
			}
			?>
		</div>
	</div>
	<ul>
		<li><?php echo $lang->line('project_menu_status').": ".get_lang_value($project['project_status'], $lang_use['id']);?></li>
		<li><a href="<?php echo base_url().$lang_use['lang_shortcut']."/project/gallery/".get_lang_slug($project['project_name'], $lang_use['id'])."-".$project['project_name'];?>"><?php echo $lang->line('project_gallery');?></a></li>
	</ul>
</div>
<div class="list">
	<div class="listName"> 
		<?php echo $lang->line('project_menu_members');?>
	</div>
	<ul>
		<?php
		if (isset($project['member'])){
			foreach ($project['member'] as $m){
				?>
				<li><?php echo $m['user_nickname'].": ".get_lang_value($m['position_id'], $lang_use['id']);?></li>
				<?php
			}
		}
		?>
	</ul>
</div>
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