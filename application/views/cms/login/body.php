<div>
	<div class="block">
		<div class="block-header">
			<div class="block-header-title">
				Login
			</div>
		</div>
		<div class="block-body">
			<div class="center" style="width: 165px;">
				<?php 
				echo validation_errors();
				echo form_open("cms/login");
				?>
					<div>
						<input type = "text" name = "name" />
					</div>
					<div>
						<input type = "password" name = "password" />
					</div>
					<div>
						<input type = "submit" name = "login" value = "login" />
					</div>
				</form>
			</div>
		</div>
	</div>
</div>