<div class="block">
	<div class="block-header">
		<div class="block-header-title">
			SHK links
		</div>
	</div>
	<div class="block-body">
		<?php
		echo form_open("cms/link/shk");
			if (isset($profile_link)){
				foreach ($profile_link as $l){              
					?>
					<div id="profile_<?php echo $l["link_name"];?>">
						<div style="float: left;">
							<?php 
							if ($l['link'] != null){
								?>
								<img class="logo" src="<?php echo assets_url()."image/link/".$l['image_active'];?>" />
								<?php 
							}
							else{
								?>
								<img class="logo" src="<?php echo assets_url()."image/link/".$l['image'];?>" />
								<?php 
							}
							?>
						</div>
						<div id="<?php echo $l["link_name"]."_form";?>">
							<input type="text" name="profile_link_<?php echo $l["link_name"];?>" value="<?php echo set_value('profile_link_'.$l['link_name'], $l['link']);?>" />
						</div>
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