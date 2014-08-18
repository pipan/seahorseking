<div class="block">
	<div class="block-header">
		<div class="block-header-title">
			Projects
		</div>
	</div>
	<div class="block-body">
		<table>
			<tr>
				<td>name</td>
				<td>status</td>
				<td>percentage</td>
				<td>article</td>
				<?php
				if (isset($language)){ 
					foreach ($language as $l){
						?>
						<td></td>
						<?php
					}
				}
				?>
				<td></td>
				<td></td>
			</tr>
			<?php 
			if (isset($project)){
				foreach ($project as $p){
					?>
					<tr>
						<td><?php echo get_lang_value($p['project_name']);?></td>
						<td><?php echo get_lang_value($p['project_status']);?></td>
						<td><?php echo $p['project_percentage'];?></td>
						<?php 
						if ($p['blog_id'] == null){
							?>
							<td>None</td>
							<?php
						}
						else{
							?>
							<td><?php echo get_lang_value($p['blog_name']);?></td>
							<?php 
						}
						if (isset($language)){ 
							foreach ($language as $l){
								?>
								<td><a href="<?php echo base_url()."index.php/cms/project/change/".$p['id']."/".$l['id'];?>"><?php echo $l['lang_shortcut'];?></a></td>
								<?php
							}
						}
						?>
						<td><a href="<?php echo base_url()."index.php/cms/project/member/".$p['id'];?>">members</a></td>
						<td><a href="<?php echo base_url()."index.php/cms/project/gallery/".$p['id'];?>">gallery</a></td>
					</tr>
					<?php
				}
			}
			?>
		</table>
	</div>
</div>