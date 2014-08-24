<div class="block">
	<div class="block-header">
		<div class="block-header-title">
			Pages
		</div>
	</div>
	<div class="block-body">
		<table>
			<tr>
				<td>folder</td>
				<td>post date</td>
				<?php 
				if (isset($language)){
					foreach ($language as $l){
						?>
						<td></td>
						<?php
					}
				}
				?>
			</tr>
			<?php
			if (isset($page)){
				foreach($page as $p){
					?>
					<tr>
						<td><?php echo $p['folder'];?></td>
						<td><?php echo $p['post_date']?></td>
						<?php 
						if (isset($language)){
							foreach ($language as $l){
								?>
								<td><a href="<?php echo base_url()."index.php/cms/static_page/change/".$p['id']."/".$l['id'];?>"><?php echo $l['lang_shortcut'];?></a></td>
								<?php
							}
						}
						?>
					</tr>
					<?php
				}
			}
			?>
		</table>
	</div>
</div>