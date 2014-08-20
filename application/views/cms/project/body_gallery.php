<div class="block">
	<div class="block-header">
		<div class="block-header-title">
			<?php echo $block_header_title;?>
		</div>
		<div class="block-header-info">
			<a href="<?php echo base_url()."index.php/cms/project/add_gallery/".$project['id'];?>">add to gallery</a>
		</div>
	</div>
	<div class="block-body">
		<?php
		echo form_open("cms/project/gallery/".$project['id']);
		?>	
			<div>
				<?php 
				if (isset($gallery)){
					foreach ($gallery as $g){
						$size = fit_image("./content/project/".$project['id']."/gallery/".$g['image'], 100, 100);
						?>
						<div class="gallery-item">
							<label for="select_<?php echo $g['id'];?>"><img class="gallery-item-image" style="<?php echo "width: ".$size['width']."px; height: ".$size['height']."px;";?>" src="<?php echo content_url()."project/".$project['id']."/gallery/".$g['image'];?>" /></label>
							<input id="select_<?php echo $g['id'];?>" class="gallery-item-image-select" type="checkbox" name="select_<?php echo $g['id'];?>" />
						</div>
						<?php
					}
				}
				?>
			</div>
			<div>
				<input type="submit" name="remove" value="remove" />
			</div>
		</form>
	</div>
</div>