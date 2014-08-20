<div class="block">
	<div class="block-header">
		<div class="block-header-title">
			<?php echo $block_header_title;?>
		</div>
	</div>
	<div class="block-body">
		<?php 
		echo validation_errors();
		echo form_open("cms/project/position_change/".$position['id']);
			if (isset($language)){
				foreach ($language as $l){
					?>
					<div>
						<label for="position_<?php echo $l['lang_shortcut'];?>"><?php echo $l['lang_name'];?></label>
						<input id="position_<?php echo $l['lang_shortcut'];?>" type="text" name="position_<?php echo $l['lang_shortcut'];?>" value="<?php echo set_value('position_'.$l['lang_shortcut'], $position[$l['lang_shortcut']]);?>" />
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