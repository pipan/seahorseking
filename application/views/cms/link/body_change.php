<div class="block">
	<div class="block-header">
		<div class="block-header-title">
			<?php echo $block_header_title;?>
		</div>
	</div>
	<div class="block-body">
		<?php 
		echo validation_errors();
		echo form_open_multipart("cms/link/change/".$link['id']);
		?>
		<div>
			<label for="name">name</label>
			<input id="name" type="text" name="name" value="<?php echo set_value('name', $link['link_name']);?>" />
		</div>
		<div>
			<label for="image">image</label>
			<input id="image" type="file" name="image" />
		</div>
		<div>
			<label for="image_active">image active</label>
			<input id="image_active" type="file" name="image_active" />
		</div>
		<div>
			<input type="submit" name="save" value="save" />
		</div>
	</div>
</div>