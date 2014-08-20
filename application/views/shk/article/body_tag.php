<?php 
if (isset($blog)){
	foreach ($blog as $b){
		?>
		<div class="block">
			<div class="block-header">
				<div class="block-header-title">
					<?php echo $b['title'];?>
				</div>
				<div class="block-header-info">
					<?php echo date_to_word($lang_use['lang_shortcut'], $b['post_date']);?>
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
	page_div($page, $page_offset, $last_page, base_url()."index.php/".$lang_use['lang_shortcut']."/article/tag/%p/".$tag);
}
?>