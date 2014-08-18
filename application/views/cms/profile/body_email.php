<div class="block">
	<div class="block-header">
		<div class="block-header-title">
			Email
		</div>
	</div>
	<div class="block-body">
		<?php 
		echo validation_errors();
		echo form_open("cms/profile/email");
		?>
			<div>
				<label for="email">email</label>
				<input id="email" type="text" name="email"  />
			</div>
			<div>
				<input type="submit" name="changeEmail" value="change"  />
			</div>
		</form>
	</div>
</div>