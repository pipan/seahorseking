<?php 
if (isset($blog)){
	foreach ($blog as $b){
		?>
		<div class="block">
			<div class="block-header">
				<div class="block-header-title">
					<a href="<?php echo base_url()."index.php/".$lang_use['lang_shortcut']."/article/view/".get_lang_slug($b['blog_name'], $lang_use['id'])."-".$b['blog_name'];?>"><?php echo get_lang_value($b['blog_name'], $lang_use['id']);?></a>
				</div>
			</div>
			<div class="block-body">
				<?php 
				if ($b['thumbnail'] != null){
					?>
					<div class="blog_preview_thumbnail">
						<img class="blog_preview_thumbnail_image" src="<?php echo $b['thumbnail'];?>" />
					</div>
					<?php
				}
				echo $b['body'];?>
				<a href="<?php echo base_url()."index.php/".$lang_use['lang_shortcut']."/article/view/".get_lang_slug($b['blog_name'], $lang_use['id'])."-".$b['blog_name'];?>"><?php echo $lang->line('word_more');?></a>
			</div>
		</div>
		<?php
	}
	page_div($page, $page_offset, $last_page, base_url()."index.php/".$lang_use['lang_shortcut']."/project/%p/".get_lang_slug($project['project_name'], $lang_use['id'])."-".$project['project_name']);
}
?>