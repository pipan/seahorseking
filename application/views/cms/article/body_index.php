<div class="block">
	<div class="block-header">
		<div class="block-header-title">
			Article
		</div>
	</div>
	<div class="block-body">
		<table>
			<tr>
				<td>title</td>
				<td>project</td>
				<td>post date</td>
				<td></td>
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
			if (isset($blog)){
				foreach($blog as $b){
					?>
					<tr>
						<td><?php echo get_lang_value($b['blog_name']);?></td>
						<td><?php echo get_lang_value($b['project_name']);?></td>
						<td><?php echo $b['post_date']?></td>
						<td><a href = "<?php echo base_url()."index.php/admin/blog/edit/".$b["id"];?>">change</a></td>
						<?php 
						if (isset($language)){
							foreach ($language as $l){
								?>
								<td><a href="<?php echo base_url()."index.php/cms/article/change/".$b['id']."/".$l['id'];?>"><?php echo $l['lang_shortcut'];?></a></td>
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