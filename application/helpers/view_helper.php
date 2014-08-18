<?php
if (!function_exists("header_menu_class")){
	function header_menu_class($selected, $class){
		if ($selected == $class){
			return "header-menu-clicked";
		}
		return "";
	}
}