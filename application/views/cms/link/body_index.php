<div class="block">
	<div class="block-header">
		<div class="block-header-title">
			Links
		</div>
	</div>
	<div class="block-body">
		<table>
			<tr>
				<td>name</td>
				<td>image</td>
				<td>image active</td>
				<td>change</td>
			</tr>
			<?php
			if (isset($link)){ 
				foreach ($link as $l){
					?>
					<tr>
						<td><?php echo $l['link_name'];?></td>
						<td><img class="cms-table-image-preview" src="<?php echo assets_url()."image/link/".$l['image'];?>" /></td>
						<td><img class="cms-table-image-preview" src="<?php echo assets_url()."image/link/".$l['image_active'];?>" /></td>
						<td><a href="<?php echo base_url()."index.php/cms/link/change/".$l['id'];?>">change</a></td>
					</tr>
					<?php
				}
			}
			?>
		</table>
	</div>
</div>