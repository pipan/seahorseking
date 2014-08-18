<div class="block">
	<div class="block-header">
		<div class="block-header-title">
			Password
		</div>
	</div>
	<div class="block-body">
		<?php 
		echo validation_errors();
		echo form_open("cms/profile/password");
		?>
			<div>
				<label for="old_password">old password</label>
				<input id="old_password" type="password" name="old_password"  />
			</div>
			<div>
				<label for="new_password">new password</label>
				<input id="new_password" type="password" name="new_password"  />
			</div>
			<div>
				<label for="repeat_password">repeat new password</label>
				<input id="repeat_password" type="password" name="repeat_password"  />
			</div>
			<div>
				<input type="submit" name="changePassword" value="change"  />
			</div>
		</form>
	</div>
</div>