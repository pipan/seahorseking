<div class="block">
	<div class="block-header">
		<div class="block-header-title">
			<?php echo $blog['title'];?>
		</div>
		<div class="block-header-info">
					<?php echo date_to_word($lang_use['lang_shortcut'], $blog['post_date']);?>
				</div>
	</div>
	<div class="block-body">
		<div class="block-body-info">
			<div>
				<div class="block-body-info-label"><?php echo $lang->line('article_author');?></div>
				<div class="block-body-info-value"><?php echo $blog['user_nickname'];?></div>
			</div>
			<?php 
			if ($blog['project_id'] != null){
				?>
				<div>
					<div class="block-body-info-label"><?php echo $lang->line('article_project');?></div>
					<div class="block-body-info-value"><?php echo get_lang_value($blog['project_name'], $lang_use['id']);?></div>
				</div>
				<?php 
			}
			?>
		</div>
		<?php 
		echo $blog['body'];?>
	</div>
	<?php
	if (isset($tag) && sizeof($tag) > 0){
		?>
		<div class="block-footer">
		<?php
		foreach ($tag as $t){
			?>
			<div class="tag">
				<a href="<?php echo base_url()."index.php/".$lang_use['lang_shortcut']."/article/tag/".$t['tag_slug'];?>"><?php echo $t['tag_name'];?></a>
			</div>
			<?php
		}
		?>
		</div>
		<?php
	}
	?>
</div>