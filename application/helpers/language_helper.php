<?php
if (!function_exists("valid_language")){
	function valid_language($language){
		$l_model = new Language_model();
		if ($l_model->exists_shortcut($language)){
			return $language;
		}
		return $l_model->get_default()['lang_shortcut'];
	}
}
if (!function_exists("valid_language_id")){
	function valid_language_id($language){
		$l_model = new Language_model();
		if ($l_model->exists($language)){
			return $language;
		}
		return $l_model->get_default()['id'];
	}
}
if (!function_exists("get_lang_label")){
	function get_lang_label($link, $replace, $selected){
		return array(
				'en' => array(
						'class' => lang_label_class('en', $selected),
						'link' => lang_link_replace($link, $replace, 'en'),
						'text' => "English",
				),
				'sk' => array(
						'class' => lang_label_class('sk', $selected),
						'link' => lang_link_replace($link, $replace, 'sk'),
						'text' => "Slovencina",
				),
		);
	}
}
if (!function_exists("lang_link_replace")){
	function lang_link_replace($link, $replace, $lang){
		$link = str_replace('%l', $lang, $link);
		if (isset($replace[$lang])){
			foreach($replace[$lang] as $search => $replace){
				$link = str_replace($search, $replace, $link);
			}
		}
		return $link;
	}
}
if (!function_exists("lang_label_class")){
	function lang_label_class($lang, $selected){
		if ($lang == $selected){
			return "light_blue_bg";
		}
		else{
			return "";
		}
	}
}
if (!function_exists("get_lang_value")){
	function get_lang_value($group_id, $lang_id = false){
		$t_model = new Translation_model();
		return $t_model->get_translation($group_id, $lang_id)['lang_value'];
	}
}