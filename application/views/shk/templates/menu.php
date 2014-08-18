<div class="list">
	<div class="listName"> 
	<?php echo $lang->line('menu_ongoing_project');?>
	</div>
	<ul>
	<?php
	if (isset($project)){
		foreach ($project as $p){
			?>
			<li><a href="<?php echo $p['link'];?>"><?php echo $p['text'];?></a></li>
			<?php
		}
	}
	?>
	</ul>
</div>