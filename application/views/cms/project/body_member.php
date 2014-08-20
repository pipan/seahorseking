<div class="block">
	<div class="block-header">
		<div class="block-header-title">
			<?php echo $block_header_title;?>
		</div>
		<div class="block-header-info">
			<a href="<?php echo base_url()."index.php/cms/project/change_member/".$project['id'];?>">add member</a>
		</div>
	</div>
	<div class="block-body">
		<table>
			<tr>
				<td>nick</td>
				<td>position</td>
				<td></td>
				<td></td>
			</tr>
			<?php
			if (isset($member)){
				foreach ($member as $m){
					?>
					<tr>
						<td><?php echo $m['user_nickname'];?></td>
						<td><?php echo get_lang_value($m['position_id']);?></td>
						<td><a href="<?php echo base_url()."index.php/cms/project/change_member/".$project['id']."/".$m['id'];?>">change</a></td>
						<td><a href="<?php echo base_url()."index.php/cms/project/remove_member/".$m['id'];?>">remove</a></td>
					</tr>
					<?php
				}
			}
			?>
		</table>
	</div>
</div>