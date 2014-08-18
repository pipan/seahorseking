<div class="block">
	<div class="block-header">
		<div class="block-header-title">
			<?php echo $block_header_title;?>
		</div>
	</div>
	<div class="block-body">
		<?php
		echo validation_errors();
		echo form_open("cms/project/add_member/".$project['id']);
		?>		
			<div>
				<label for="user">user</label>
				<select id="user" name="user">
					<?php 
					if (isset($user)){
						foreach ($user as $u){
							?>
							<option value="<?php echo $u['id'];?>" <?php echo set_select('user', $u['id']);?>><?php echo $u['user_nickname'];?></option>
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