<div>
	<?php 
	if (isset($link)){
		foreach ($link as $l){
			?>
			<div class="link-item">
				<a href="<?php echo $l['link'];?>" target="_blank" title="<?php echo $l['link_name'];?>">
		    		<img class="logo" src="<?php echo assets_url()."image/link/".$l['image'];?>" alt="<?php echo $l['link_name'];?>" />
		    	</a>
		    </div>
			<?php
		}
	}
	?>
</div>