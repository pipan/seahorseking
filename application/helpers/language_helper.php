<?php
if (!function_exists("valid_language")){
	function valid_language($language){
		$l_model = new Language_model();
		if ($language != "" && $l_model->exists_shortcut($language)){
			return $l_model->get_by_shortcut($language);
		}
		return $l_model->get_default();
	}
}
if (!function_exists("valid_language_id")){
	function valid_language_id($language){
		$l_model = new Language_model();
		if ($language != "" && $l_model->exists($language)){
			return $l_model->get(array(), $language);
		}
		return $l_model->get_default();
	}
}
if (!function_exists("get_lang_label")){
	function get_lang_label($link, $replace, $language, $selected){
		$ret = array();
		foreach ($language as $l){
			$ret[$l['lang_shortcut']] = array(
					'class' => lang_label_class($l['lang_shortcut'], $selected['lang_shortcut']),
					'link' => lang_link_replace($link, $replace, $l['lang_shortcut']),
					'text' => strtoupper($l['lang_shortcut']),
			);
		}
		return $ret;
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
			return "language-select";
		}
		else{
			return "";
		}
	}
}
if (!function_exists("get_lang_value")){
	function get_lang_value($group_id, $lang_id = false){
		$t_model = new Translation_model();
		$tmp = $t_model->get_translation($group_id, $lang_id);
		return $tmp['lang_value'];
	}
}
if (!function_exists("get_lang_slug")){
	function get_lang_slug($group_id, $lang_id = false){
		$t_model = new Translation_model();
		$tmp = $t_model->get_translation($group_id, $lang_id);
		return $tmp['slug'];
	}
}
if (!function_exists("get_lang_db")){
	function get_lang_db($group_id, $lang_id = false){
		$t_model = new Translation_model();
		$tmp = $t_model->get_translation($group_id, $lang_id);
		return $tmp;
	}
}