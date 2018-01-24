<?php

namespace Lookey\Wxsdk;


/**
 * 工具
 * 
 * @create 2016-11-9
 * @author zlw
 */
class Tool
{
	
	/**
	 * 数组转xml
	 * 
	 * @create 2016-11-9
	 * @author zlw
	 */
	public function arrayToXml($data, $root = 'xml')
	{
		$xml = "<".$root.">"; 
		foreach ($arr as $key => $val) { 
			if (is_array($val)) { 
				$xml .= "<".$key.">".$this->toXml($val)."</".$key.">"; 
			} else { 
				if (is_numeric($val)) {
					$xml .= "<".$key.">".$val."</".$key.">";
				} else {
					$xml .= "<".$key."><![CDATA[".$val."]]></".$key.">"; 
				}
			} 
		} 
		$xml .= "</".$root.">";
		
		return $xml;
	}
	
	/**
	 * 数组转xml
	 * 
	 * @create 2016-11-9
	 * @author zlw
	 */
	public function arrayDomToXml($arr, $dom = 0, $item = 0, $root = 'xml')
	{ 
		if (!$dom) { 
			$dom = new DOMDocument("1.0"); 
		} 
		if (!$item) { 
			$item = $dom->createElement($root); 
			$dom->appendChild($item); 
		} 
		foreach ($arr as $key => $val) { 
			$itemx = $dom->createElement(is_string($key) ? $key : "item"); 
			$item->appendChild($itemx); 
			if (!is_array($val)) { 
				$text = $dom->createTextNode($val); 
				$itemx->appendChild($text); 			 
			} else { 
				$this->arrayToXml($val, $dom, $itemx); 
			} 
		} 
		return $dom->saveXML(); 
	}
	
	/**
	 * xml转数组
	 * 
	 * @create 2016-11-9
	 * @author zlw
	 */
	function xmlToArray($xml)
	{ 
		//禁止引用外部xml实体 
		libxml_disable_entity_loader(true); 
		$xmlString = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA); 
		$val = json_decode(json_encode($xmlString), true); 
		return $val; 
	} 
 
}
