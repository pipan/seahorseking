<?php 
if (isset($project)){
	foreach ($project as $p){
		?>
		<div class="block">
			<div class="block-header">
				<div class="block-header-title">
					<a href="<?php echo base_url()."index.php/".$lang_use['lang_shortcut']."/project/view/".get_lang_slug($p['project_name'], $lang_use['id'])."-".$p['project_name'];?>"><?php echo get_lang_value($p['project_name'], $lang_use['id']);?></a>
				</div>
				<div class="block-header-abstract">
					<?php echo get_lang_value($p['project_status'], $lang_use['id']);?>
				</div>
				<div class="block-header-info">
					<a href="<?php echo base_url()."index.php/".$lang_use['lang_shortcut']."/project/gallery/".get_lang_slug($p['project_name'], $lang_use['id'])."-".$p['project_name'];?>"><?php echo $lang->line('project_gallery');?></a>
				</div>
			</div>
			<div class="block-body">
				<?php 
				if ($p['body'] != false){
					if ($p['thumbnail'] != null){
						?>
						<div class="blog_preview_thumbnail">
							<img class="blog_preview_thumbnail_image" src="<?php echo $p['thumbnail'];?>" />
						</div>
						<?php
					}
					echo $p['body'];?>
					<a href="<?php echo base_url()."index.php/".$lang_use['lang_shortcut']."/article/view/".get_lang_slug($p['blog_name'], $lang_use['id'])."-".$p['blog_name'];?>"><?php echo $lang->line('word_more');?></a>
					<?php 
				}
				?>
			</div>
		</div>
		<?php
	}
	page_div($page, $page_offset, $last_page, base_url()."index.php/".$lang_use['lang_shortcut']."/project/%p");
}
?>