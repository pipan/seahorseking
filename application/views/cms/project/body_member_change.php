<div class="block">
	<div class="block-header">
		<div class="block-header-title">
			<?php echo $block_header_title;?>
		</div>
	</div>
	<div class="block-body">
		<?php
		echo validation_errors();
		echo form_open("cms/project/change_member/".$project['id']."/".$member['id']);
		?>		
			<div>
				<label for="user">user</label>
				<select id="user" name="user">
					<?php 
					if (isset($users)){
						foreach ($users as $u){
							?>
							<option value="<?php echo $u['id'];?>" <?php echo set_select('user', $u['id']);?>><?php echo $u['user_nickname'];?></option>
							<?php
						}
					}
					else{
						if (isset($user)){
							?>
							<option value="<?php echo $user['id'];?>" <?php echo set_select('user', $user['id']);?>><?php echo $user['user_nickname'];?></option>
							<?php
						}
					}
					?>
				</select>
			</div>
			<div>
				<label for="position">position</label>
				<select id="position" name="position">
					<?php 
					if (isset($position)){
						foreach ($position as $p){
							?>
							<option value="<?php echo $p['id'];?>" <?php echo set_select('user', $p['id']);?>><?php echo get_lang_value($p['id']);?></option>
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