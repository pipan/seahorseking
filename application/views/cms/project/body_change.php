<div class="block">
	<div class="block-header">
		<div class="block-header-title">
			<?php echo $block_header_title;?>
		</div>
	</div>
	<div class="block-body">
		<?php 
		echo validation_errors();
		echo form_open("cms/project/change/".$project['id']."/".$project_language['id']);
		?>
			<div>
				<label for="name">name</label>
				<input id="name" type="text" name="name" value="<?php echo set_value('name', get_lang_value($project['project_name'], $project_language['id']));?>" />
			</div>
			<div>
				<label for="status">status</label>
				<input id="status" type="text" name="status" value="<?php echo set_value('name', get_lang_value($project['project_status'], $project_language['id']));?>" />
			</div>
			<div>
				<label for="percentage">percentage</label>
				<input id="percentage" type="text" name="percentage" value="<?php echo set_value('name', $project['project_percentage']);?>" />
			</div>
			<div>
				<label for="blog">blog</label>
				<select id="blog" name="blog">
					<option value="0">None</option>
					<?php
					if (isset($blog)){ 
						foreach ($blog as $b){
							?>
							<option value="<?php echo $b['id'];?>" <?php echo set_select('blog', $b['id'], $b['id'] == $project['blog_id']);?>><?php echo get_lang_value($b['id'], $project_language);?></option>
							<?php
						}
					}
					?>
				</select>
			</div>
			<div>
				<input type="submit" name="save" value="save" />
			</div>
		</form>
	</div>
</div>