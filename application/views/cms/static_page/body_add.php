<div class="block">
	<div class="block-header">
		<div class="block-header-title">
			Add page
		</div>
	</div>
	<div class="block-body">
		<?php 
		echo validation_errors();
		echo form_open("cms/static_page/add");
		?>
			<div>
				<label for="folder">folder</label>
				<input id="folder" type="text" name="folder" />
			</div>
			<div>
				<input type="submit" name="save" value="save" />
			</div>
		</form>
	</div>
</div>