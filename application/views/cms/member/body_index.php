<div class="block">
	<div class="block-header">
		<div class="block-header-title">
			Members
		</div>
	</div>
	<div class="block-body">
		<table>
			<tr>
				<td>nickname</td>
				<td>name</td>
				<td>surname</td>
				<td>email</td>
				<td></td>
			</tr>
			<?php 
			if (isset($member)){
				foreach ($member as $m){
					?>
					<tr>
						<td><?php echo $m['user_nickname'];?></td>
						<td><?php echo $m['user_name'];?></td>
						<td><?php echo $m['user_surname'];?></td>
						<td><?php echo $m['email'];?></td>
						<td><a href="<?php echo base_url()."index.php/cms/member/change/".$m['id'];?>">change</a></td>
					</tr>
					<?php
				}
			}
			?>
		</table>
	</div>
</div>