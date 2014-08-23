<?php 
if (isset($project)){
	foreach ($project as $p){
		?>
		<div class="block">
			<div class="block-header">
				<div class="block-header-title">
					<a href="<?php echo base_url().$lang_use['lang_shortcut']."/project/view/".get_lang_slug($p['project_name'], $lang_use['id'])."-".$p['project_name'];?>"><?php echo get_lang_value($p['project_name'], $lang_use['id']);?></a>
				</div>
				<div class="block-header-abstract">
					<?php echo get_lang_value($p['project_status'], $lang_use['id']);?>
				</div>
				<div class="block-header-info">
					<a href="<?php echo base_url().$lang_use['lang_shortcut']."/project/gallery/".get_lang_slug($p['project_name'], $lang_use['id'])."-".$p['project_name'];?>"><?php echo $lang->line('project_gallery');?></a>
				</div>
				<div class="block-header-link">
					<?php 
					if (isset($p['link'])){
						foreach ($p['link'] as $l){
							?>
							<div class="link-item">
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
					<a href="<?php echo base_url().$lang_use['lang_shortcut']."/article/view/".get_lang_slug($p['blog_name'], $lang_use['id'])."-".$p['blog_name'];?>"><?php echo $lang->line('word_more');?></a>
					<?php 
				}
				?>
			</div>
		</div>
		<?php
	}
	page_div($page, $page_offset, $last_page, base_url().$lang_use['lang_shortcut']."/project/%p");
}
?>