<div class="block">
	<div class="block-header">
		<div class="block-header-title">
			Profile
		</div>
	</div>
	<div class="block-body">
		<?php 
		echo validation_errors();
		echo form_open("cms/profile");
		?>
			<div>
				<?php
				if ($profile['avatar'] != null){
					?>
					<img class="avatar" src="<?php echo content_url()."member/".$profile['id']."/".$profile['avatar'];?>" />
					<?php
				}
			?>
			</div>
			<div>
				<label for="nickname">nickname</label>
				<input id="nickname" type="text" name="nickname" value="<?php echo set_value('nickname', $profile['user_nickname']);?>" />
			</div>
			<div>
				<label for="name">name</label>
				<input id="name" type="text" name="name" value="<?php echo set_value('name', $profile['user_name']);?>" />
			</div>
			<div>
				<label for="surname">surname</label>
				<input id="surname" type="text" name="surname" value="<?php echo set_value('surname', $profile['user_surname']);?>" />
			</div>
			<div>
	        	<label for="day">birthday</label>
	        	<select id="day" name="day">
	        		<?php
					for ($i = 0; $i <= 31; $i++){
						?>
						<option <?php echo set_select('day', $profile['birthday_day'], $i == $profile['birthday_day']);?>><?php echo $i;?></option>
						<?php
					}
					?>
				</select>  
				<select name="month">
					<?php
					for ($i = 0; $i < 13; $i++){
						?>
						<option <?php echo set_select('month', $profile['birthday_month'], $i == $profile['birthday_month']);?>><?php echo $i;?></option>
						<?php
					}
					?>
				</select>
				<select name="year">
					<option>0000</option>
					<?php
					for ($i = date("Y"); $i >= 1900; $i--){
						?>
						<option <?php echo set_select('year', $profile['birthday_year'], $i == $profile['birthday_year']);?>><?php echo $i;?></option>
						<?php
					}
					?>
				</select>
			</div>  
			<div>
		      	<label>gender</label>
				<span>
					<input type="radio" name="gender" id="male" value="1" <?php echo set_radio('gender', 1, $profile['user_gender'] == 1);?> />
					<label for="male" class="exception">male</label>
				</span>
				<span style="padding-left:20px;">
					<input type="radio" name="gender" id="female" value="2" <?php echo set_radio('gender', 2, $profile['user_gender'] == 2);?> />
					<label for="female" class="exception">female</label>
				</span>
			</div>
			<div>
				<label>profiles</label>
				<div style="display: inline-block;"> 
				<?php
				if (isset($profile_link)){
					foreach ($profile_link as $l){              
						?>
						<div id="profile_<?php echo $l["link_name"];?>" style="float:left;overflow:hidden;border-left:solid transparent 1px;">
							<div class="clickable" style="float:left;" onClick="changeVisibilityById('<?php echo $l["link_name"]."_form";?>');changeClearById('profile_<?php echo $l["link_name"];?>','both','');changeFloatById('profile_<?php echo $l["link_name"];?>','left','');changeBorderColorById('profile_<?php echo $l["link_name"];?>','L','#0defdc');">
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
							<div id="<?php echo $l["link_name"]."_form";?>" class="invisible">
								<input type="text" name="profile_link_<?php echo $l["link_name"];?>" value="<?php echo set_value('profile_link_'.$l['link_name'], $l['link']);?>" />
							</div>
						</div>
						<?php
					}
				}
				?>
				</div>
			</div>
        	<div>
				<label for="description">description</label>
				<textarea id="description" name="description" style="width: 300px; height: 80px;"><?php echo read_file("./content/member/".$profile["id"]."/description.txt");?></textarea>
			</div>
			<div>
				<input type="submit" name="editProfile" value="edit" />
			</div>
		</form>
	</div>
</div>