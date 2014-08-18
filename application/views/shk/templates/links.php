<div>
	<?php 
	if (isset($link)){
		foreach ($link as $l){
			?>
			<div class="link-item">
				<a href="<?php echo $l['link'];?>" target="_blank">
		    		<img class="logo" src="<?php echo assets_url()."image/link/".$l['image'];?>" />
		    	</a>
		    </div>
			<?php
		}
	}
	?>
</div>