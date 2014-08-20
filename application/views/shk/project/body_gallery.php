<div class="block">
	<div class="block-header">
		<div class="block-header-title">
			<?php echo $block_header_title;?>
		</div>
	</div>
	<div class="block-body">
		<div>
			<?php 
			if (isset($gallery)){
				$i = 0;
				foreach ($gallery as $g){
					$size = fit_image("./content/project/".$project['id']."/gallery/".$g['image'], 100, 100);
					?>
					<div class="gallery-item gallery-view clickable" onClick="viewer.start(<?php echo $i;?>)">
						<img class="gallery-item-image" style="<?php echo "width: ".$size['width']."px; height: ".$size['height']."px;";?>" src="<?php echo content_url()."project/".$project['id']."/gallery/".$g['image'];?>" />
					</div>
					<?php
					$i++;
				}
			}
			?>
		</div>
	</div>
</div>