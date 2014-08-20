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
		<?php 
		if (isset($jscript)){
			foreach ($jscript as $j){
				?>
				<script type="text/javascript" src="<?php echo assets_url()."jscript/".$j.".js";?>"></script>
				<?php
			}
		}
		?>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<link rel="shortcut icon" href="<?php echo assets_url()."image/icon.ico";?>" type="image/x-icon" />
		<title><?php echo $title;?></title>
	</head>
	<body>
		<div id="links">
			<?php echo $links;?>	
		</div>
		<div id="main">
			<div id="header">
				<?php echo $header;?>	
			</div>
			<div id="body">
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