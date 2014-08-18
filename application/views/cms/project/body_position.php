<div class="block">
	<div class="block-header">
		<div class="block-header-title">
			Positions
		</div>
	</div>
	<div class="block-body">
		<table>
			<tr>
				<?php
				if (isset($language)){
					foreach ($language as $l){
						?>
						<td><?php echo $l['lang_shortcut'];?></td>
						<?php
					}
				}
				?>
				<td></td>
			</tr>
			<?php
			if (isset($position)){
				foreach ($position as $p){
					?>
					<tr>
						<?php 
						if (isset($language)){
							foreach ($language as $l){
								?>
								<td><?php echo get_lang_value($p['id'], $l['id']);?></td>
								<?php
							}
						}
						?>
						<td><a href="<?php echo base_url()."index.php/cms/project/position_change/".$p['id'];?>">change</a></td>
					</tr>
					<?php
				}
			}
			?>
		</table>
	</div>
</div>