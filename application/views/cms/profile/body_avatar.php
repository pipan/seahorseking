<div class="block">
	<div class="block-header">
		<div class="block-header-title">
			Avatar
		</div>
	</div>
	<div class="block-body">
		<?php
		echo validation_errors();
		echo form_open_multipart("cms/profile/avatar");
		?>
			<div>
				<label for="avatar">avatar</label>
				<input id="avatar" type="file" name="avatar" />
			</div>
			<div>
				<input type="submit" name="changeAvatar" value="change" />
			</div>
		</form>
	</div>
</div>