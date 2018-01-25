<?php

namespace Lookey\Web;


/**
 * json 生成,分析 支持中文
 *
 * @create 2016-12-05
 * @author zlw
 */
class Json 
{
	
	/**
	 * 生成json
	 *
	 * @create 2016-12-05
	 * @author zlw
	 */
	public static function encode($str)
	{
		$json = json_encode($str);
		
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'
			|| DIRECTORY_SEPARATOR == '\\'
			|| PATH_SEPARATOR == ';'
		) {
			//windows
			return preg_replace("#\u([0-9a-f]{4})#ie", "iconv('UCS-2LE', 'UTF-8', pack('H4', '\1'))", $json);
		} else {
			//linux
			return preg_replace("#\u([0-9a-f]{4})#ie", "iconv('UCS-2BE', 'UTF-8', pack('H4', '\1'))", $json);
		}
	}
	
	/**
	 * 分析json
	 *
	 * @create 2016-12-05
	 * @author zlw
	 */
	public static function decode($str, $isArray = false) 
	{
		return json_decode($str, $isArray);
	}
	
}

