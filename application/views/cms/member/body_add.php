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
				<label for="nickname">nickname</label>
				<input id="nickname" type="text" name="nickname" />
			</div>
			<div>
				<label for="name">name</label>
				<input id="name" type="text" name="name" />
			</div>
			<div>
				<label for="surname">surname</label>
				<input id="surname" type="text" name="surname" />
			</div>
			<div>
				<label for="email">email</label>
				<input id="email" type="text" name="email" />
			</div>
			<div>
				<label for="permission">permission</label>
				<select id="permission" name="permission">
					<?php 
					if (isset($permission)){
						foreach ($permission as $p){
							?>
							<option value="<?php echo $p['id'];?>" <?php echo set_select('permission', $p['id']);?>><?php echo $p['id'];?></option>
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