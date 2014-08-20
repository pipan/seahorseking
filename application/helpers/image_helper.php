<?php
if (!function_exists("fit_image")){
	function fit_image($image, $width, $height){
		list($sizeW, $sizeH) = getimagesize($image);
		$ratio = $sizeW / $sizeH;
		$fit_ratio = $width / $height;
		if ($ratio > $fit_ratio){
			$imageHeight = $height;
			$imageWidth = $height * $ratio;
		}
		else{
			$imageWidth = $width;
			$imageHeight = $width / $ratio;
		}
		return array(
				'width' => $imageWidth,
				'height' => $imageHeight,
		);
	}
}