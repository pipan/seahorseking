<div class="block">
	<div class="block-header">
		<div class="block-header-title">
			<?php echo $block_header_title;?>
		</div>
	</div>
	<div class="block-body">
		<?php
		echo validation_errors();
		echo form_open_multipart("cms/project/add_gallery/".$project['id']);
		?>		
			<div>
				<label for="image">image</label>
				<input id="image" type="file" name="image" />
			</div>
			<div>
				<input type="submit" name="save" value="save" />
			</div>
		</form>
	</div>
</div>