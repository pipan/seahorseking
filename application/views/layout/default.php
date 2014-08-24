<!doctype html>
<html>
	<head>
		<link type = "text/css" rel = "stylesheet" href = "<?php echo assets_url()."style/style.css";?>" />
		<?php 
		if (isset($style)){
			foreach ($style as $s){
				?>
				<link rel="stylesheet" type="text/css" href="<?php echo assets_url()."style/".$s.".css";?>" />
				<?php
			}	
		}
		?>
		<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
		<script type="text/javascript" src="<?php echo assets_url()."jscript/jscript_general.js";?>"></script>
		<script type="text/javascript" src="<?php echo assets_url()."jscript/jquery_general.js";?>"></script>
		<script type="text/javascript" src="<?php echo assets_url()."jscript/jscript_events.js";?>"></script>
		<?php 
		if (isset($jscript)){
			foreach ($jscript as $j){
				?>
				<script type="text/javascript" src="<?php echo assets_url()."jscript/".$j.".js";?>"></script>
				<?php
			}
		}
		if (isset($language) && isset($lang_use) && isset($lang_label)){
			foreach ($language as $l){
				if ($l['id'] != $lang_use['id']){
					?>
					<link rel="alternate" hreflang="<?php echo $l['lang_shortcut'];?>" href="<?php echo $lang_label[$l['lang_shortcut']]['link'];?>">
					<?php
				}
			}
		}
		?>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<meta name="google-site-verification" content="Omr5FFkGKHXf2kN96vPeSInT6gt0n97R43f89S754-M" />
		<link rel="shortcut icon" href="<?php echo assets_url()."image/icon.ico";?>" type="image/x-icon" />
		<title><?php echo $title;?></title>
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			
			ga('create', 'UA-54121996-1', 'auto');
			ga('send', 'pageview');
		</script>
	</head>
	<body>
		<div id="links">
			<?php echo $links;?>	
		</div>
		<div id="main">
			<div id="header" class="scroll-effect">
				<?php echo $header;?>	
			</div>
			<div id="body" class="scroll-effect">
				<div id="content">
					<?php echo $body;?>	
				</div>
				<div id="menu">
					<?php echo $menu;?>
				</div>
			</div>
			<div id="footer">
				<?php echo $footer;?>	
			</div>
		</div>
	</body>
</html>