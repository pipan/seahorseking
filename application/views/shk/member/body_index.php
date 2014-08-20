<?php 
if (isset($member)){
	foreach ($member as $m){
		?>
		<div class="block">
			<div class="block-header">
				<div class="block-header-title">
					<?php echo $m['user_nickname'];?>
				</div>
				<div class="block-header-link">
					<?php 
					if (isset($m['link'])){
						foreach ($m['link'] as $l){
							?>
							<div class="link-item">
								<a href="<?php echo $l['link'];?>" target="_blank" title="<?php echo $l['link_name'];?>">
						    		<img class="logo" src="<?php echo assets_url()."image/link/".$l['image'];?>" alt="<?php echo $l['link_name'];?>" />
						    	</a>
						    </div>
							<?php
						}
					}
					?>
				</div>
			</div>
			<div class="block-body">
				<div class="profile">
					<?php 
					if ($m['avatar'] != null){
						?>
						<div class="profile-avatar">
							<img class="profile-avatar-image" src="<?php echo content_url()."member/".$m['id']."/".$m['avatar'];?>" />
						</div>
						<?php
					}
					?>
					<div class="profile-info">
						<div>
							<div class="profile-info-label"><?php echo $lang->line('member_name_label');?></div>
							<div class="profile-info-value"><?php echo $m['user_name']." ".$m['user_surname'];?></div>
						</div>
						<div>
							<div class="profile-info-label"><?php echo $lang->line('member_gender_label');?></div>
							<div class="profile-info-value"><?php echo $lang->line('member_gender_'.$m['user_gender']);?></div>
						</div>
						<div>
							<div class="profile-info-label"><?php echo $lang->line('member_age_label');?></div>
							<div class="profile-info-value"><?php echo get_age($m['user_birthday']);?></div>
						</div>
						<div>
							<div class="profile-info-label"><?php echo $lang->line('member_email_label');?></div>
							<div class="profile-info-value"><?php echo $m['email'];?></div>
						</div>
					</div>
				</div>
				<?php
				echo $m['body'];?>
			</div>
		</div>
		<?php
	}
	page_div($page, $page_offset, $last_page, base_url()."index.php/".$lang_use['lang_shortcut']."/member/%p");
}
?>