<div class="block">
	<div class="block-header">
		<div class="block-header-title">
			Order pages
		</div>
	</div>
	<div class="block-body">
		<?php 
		echo validation_errors();
		echo form_open();
			if (isset($page)){
				foreach($page as $p){
					?>
					<div>
						<label for="<?php echo $p['folder'];?>"><?php echo $p['folder'];?></label>
						<input id="<?php echo $p['folder'];?>" type="text" name="<?php echo $p['folder'];?>" value="<?php echo set_value($p['folder'], $p['position']);?>" />
					</div>
					<?php 
				}
			}
			?>
			<div>
				<input type="submit" name="save" value="save" />
			</div>
		</form>
	</div>
</div>