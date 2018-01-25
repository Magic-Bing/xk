<?php

namespace Lookey\Qrcode;


/**
 * 二维码
 *
 * @create 2016-11-4
 * @author zlw
 */
class Qrcode 
{
	
	/**
	 * 根据内容生成二维码
	 *
	 * @create 2016-11-4
	 * @author zlw
	 */
	public function getQrcodePng($qr, $value) 
	{
		include 'phpqrcode/phpqrcode.php'; 
		
		$errorCorrectionLevel = 'L';//容错级别 
		$matrixPointSize = 6;		//生成图片大小 
		
		//生成二维码图片 
		\QRcode::png($value, $qr, $errorCorrectionLevel, $matrixPointSize, 2); 
		
		return $qr;
	}
	
	/**
	 * 在二维码内加log
	 *
	 * @create 2016-11-4
	 * @author zlw
	 */
	public function getQrcodePngAndLogo($qr, $logo) 
	{
		if ($logo !== FALSE) { 
			$QR = imagecreatefromstring(file_get_contents($qr)); 
			$logo = imagecreatefromstring(file_get_contents($logo)); 
			
			$QR_width = imagesx($QR);//二维码图片宽度 
			$QR_height = imagesy($QR);//二维码图片高度 
			$logo_width = imagesx($logo);//logo图片宽度 
			$logo_height = imagesy($logo);//logo图片高度 
			
			$logo_qr_width = $QR_width / 5; 
			$scale = $logo_width/$logo_qr_width; 
			$logo_qr_height = $logo_height/$scale; 
			$from_width = ($QR_width - $logo_qr_width) / 2;
			
			//重新组合图片并调整大小 
			imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, 
			$logo_qr_height, $logo_width, $logo_height); 
		} 
		
		//输出图片 
		Header("Content-type: image/png");
		ImagePng($QR);	
	}

}
