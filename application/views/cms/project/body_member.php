<div class="block">
	<div class="block-header">
		<div class="block-header-title">
			<?php echo $block_header_title;?>
		</div>
		<div class="block-header-info">
			<a href="<?php echo base_url()."index.php/cms/project/add_member/".$project['id'];?>">add member</a>
		</div>
	</div>
	<div class="block-body">
		<table>
			<tr>
				<td>nick</td>
				<td></td>
			</tr>
			<?php
			if (isset($member)){
				foreach ($member as $m){
					?>
					<td><?php echo $m['user_nickname'];?></td>
					<td><a href="<?php echo base_url()."index.php/cms/project/remove_member/".$m['id'];?>">remove</a></td>
					<?php
				}
			}
			?>
		</table>
	</div>
</div>