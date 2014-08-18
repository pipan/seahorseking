<div class="block">
	<div class="block-header">
		<div class="block-header-title">
			<?php echo $block_header_title;?>
		</div>
	</div>
	<div class="block-body">
		<?php 
		echo validation_errors();
		echo form_open("cms/member/add");
		?>
			<div>
				<label for="permission">permission</label>
				<select id="permission" name="permission">
					<?php 
					if (isset($permission)){
						foreach ($permission as $p){
							?>
							<option value="<?php echo $p['id'];?>" <?php echo set_select('permission', $p['id'], $p['id'] == $member['permission_id']);?>><?php echo $p['id'];?></option>
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