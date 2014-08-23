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
				<label>profiles</label>
				<div style="display: inline-block;"> 
				<?php
				if (isset($link)){
					foreach ($link as $l){              
						?>
						<div id="profile_<?php echo $l["link_name"];?>" style="float:left;overflow:hidden;border-left:solid transparent 1px;">
							<div class="clickable" style="float:left;" onClick="changeVisibilityById('<?php echo $l["link_name"]."_form";?>');changeClearById('profile_<?php echo $l["link_name"];?>','both','');changeFloatById('profile_<?php echo $l["link_name"];?>','left','');changeBorderColorById('profile_<?php echo $l["link_name"];?>','L','#0defdc');">
								<?php 
								if (is_in_model_array($l['id'], $project_link, 'link_id')){
									$project_link_item = get_where($project_link, 'link_id', $l['id']);
									$link_value = $project_link_item['link'];
									?>
									<img class="logo" src="<?php echo assets_url()."image/link/".$l['image_active'];?>" />
									<?php 
								}
								else{
									$link_value = "";
									?>
									<img class="logo" src="<?php echo assets_url()."image/link/".$l['image'];?>" />
									<?php 
								}
								?>
							</div>
							<div id="<?php echo $l["link_name"]."_form";?>" class="invisible">
								<input type="text" name="project_link_<?php echo $l["link_name"];?>" value="<?php echo set_value('project_link_'.$l['link_name'], $link_value);?>" />
							</div>
						</div>
						<?php
					}
				}
				?>
				</div>
			</div>
			<div>
				<label for="blog">blog</label>
				<select id="blog" name="blog">
					<option value="0">None</option>
					<?php
					if (isset($blog)){ 
						foreach ($blog as $b){
							?>
							<option value="<?php echo $b['id'];?>" <?php echo set_select('blog', $b['id'], $b['id'] == $project['blog_id']);?>><?php echo get_lang_value($b['blog_name'], $project_language['id']);?></option>
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