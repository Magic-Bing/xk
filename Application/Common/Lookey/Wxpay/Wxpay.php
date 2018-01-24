<?php

namespace Lookey\Wxpay;


/**
 * 微信支付
 * 
 * 发送红包
 * $sendredpackUrl = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
 * 
 * 查询红包
 * $getHbinfoUrl = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/gethbinfo';
 * 
 * @create 2016-11-14
 * @author zlw
 */
class Wxpay
{
	
	/**
	 * 公钥
	 */
	private $publicKey = "";
	
	/**
	 * 私钥
	 */
	private $privateKey = '';
	
	/**
	 * ca证书
	 */	
	private $rootca = '';
 
	/**
	 * 构造函数
	 * 
	 * @create 2016-11-14
	 * @author zlw
	 */	
	public function __construct(
		$publicKey = '', 
		$privateKey = '', 
		$rootca = ''
	) {
		if (!empty($publicKey)) {
			$this->setPublicKey($publicKey);
		}

		if (!empty($privateKey)) {
			$this->setPrivateKey($privateKey);
		}

		if (!empty($rootca)) {
			$this->setRootca($rootca);
		}
	}
	
	/**
	 * 设置公钥
	 * 
	 * @create 2016-11-14
	 * @author zlw
	 */
	public function setPublicKey($publicKey)
	{
		$this->publicKey = $publicKey;
		
		return $this;
	}
	
	/**
	 * 设置私钥
	 * 
	 * @create 2016-11-14
	 * @author zlw
	 */
	public function setPrivateKey($privateKey)
	{
		$this->privateKey = $privateKey;
		
		return $this;
	}
	
	/**
	 * 设置ca证书
	 * 
	 * @create 2016-11-14
	 * @author zlw
	 */
	public function setRootca($rootca)
	{
		$this->rootca = $rootca;
		
		return $this;
	}
  
	/**
	 * 提交
	 * 
	 * @create 2016-11-14
	 * @author zlw
	 */
	public function send($url, $sendArray, $key)
	{
		//随机字符串
		$sendArray['nonce_str'] = $this->createNonceStr(32);

		//清除签名干扰
		unset($sendArray['sign']);
		
		//签名
		$sign = $this->createSign($sendArray, $key);
		$sendArray['sign'] = $sign;
		
		//获取数据
		$sendXml = $this->arrayToXml($sendArray);
		$result = $this->curlPostSsl($url, $sendXml);
		
		if ($result['errorCode'] != 0) {
			return $result['data'];
		} else {		
			$dataXml = $result['data'];
			$data = $this->xmlToArray($dataXml);
			
			//file_put_contents('adki', var_export($data, true), FILE_APPEND);
			
			return $data;
		}
	}
	
	/**
	 * 创建mch_billno
	 * 
	 * @create 2016-11-14
	 * @author zlw
	 */
	public function createMchBillno($mchId, $randInt = 6)
	{
		return $mchId . date('Ymd') . $this->createNonceInt($randInt);
	}
 
	/**
	 * 请确保您的libcurl版本是否支持双向认证，版本高于7.20.1
	 * 
	 * @create 2016-11-14
	 * @author zlw
	 */
	private function curlPostSsl(
		$url, 
		$vars, 
		$second = 30, 
		$aHeader = array()
	) {
		$ch = curl_init();
		//超时时间
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//这里设置代理，如果有的话
		//curl_setopt($ch,CURLOPT_PROXY, '10.206.30.98');
		//curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		//以下两种方式需选择一种
		//第一种方法，cert 与 key 分别属于两个.pem文件
		//默认格式为PEM，可以注释
		curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLCERT, $this->publicKey);
		//默认格式为PEM，可以注释
		curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLKEY, $this->privateKey);
		//ca证书
		curl_setopt($ch, CURLOPT_CAINFO, $this->rootca);
		//第二种方式，两个文件合成一个.pem文件
		//curl_setopt($ch, CURLOPT_SSLCERT, getcwd().'/all.pem');
		if( count($aHeader) >= 1 ){
			curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
		}
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
		$data = curl_exec($ch);
		if ($data) {
			curl_close($ch);
			return array(
				'errorCode' => 0,
				'errorMsg' 	=> 'OK',
				'data' 		=> $data,
			);
		} else {
			$errorCode = curl_errno($ch);
			$errorMsg = "call faild, errorCode:$errorCode\n";
			curl_close($ch);
			return array(
				'errorCode' => $errorCode,
				'errorMsg' 	=> $errorMsg,
				'data' 		=> $errorMsg,
			);
		}
	}
 
	/**
	 * 生成自定义签名
	 * 
	 * @create 2016-11-14
	 * @author zlw
	 */
	private function createSign($signArray, $signKey)
	{
		$signString = $this->formatQueryParaMap($signArray);
		
		//转成UTF-8
		$signString = $this->gbkToUtf8($signString);
		$stringSign = "{$signString}&key={$signKey}";
		
		$sign = MD5($stringSign);
		$sign = strtoupper($sign);
		
		return $sign;
	}
	
	/**
	 * 格式化数组
	 * 
	 * @create 2016-11-14
	 * @author zlw
	 */
	private function formatQueryParaMap($signArray, $urlencode = false)
	{
		//根据字典序排序
		ksort($signArray);
		
		$signList = array();
		foreach ($signArray as $key => $value) {
			if (!empty($value)) {
				if ($urlencode) {
					$value = urlencode($value);
				}
				$signList[] = "{$key}={$value}";
			}
		}
		$signString = implode('&', $signList);		
		//$signString = http_build_query($signArray);
		
		return $signString;
	}
	
	/**
	 * 生成随机字符串
	 * 
	 * @create 2016-11-14
	 * @author zlw
	 */
	private function createNonceStr($length)
	{
		$str = null;
		$strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
		$max = strlen($strPol) - 1;
		for ($i = 0; $i < $length; $i++) {
			//rand($min,$max)生成介于min和max两个数之间的一个随机整数
			$str .= $strPol[rand(0, $max)];
		}

		return $str;
	}

	/**
	 * 生成随机数字
	 * 
	 * @create 2016-11-14
	 * @author zlw
	 */
	private function createNonceInt($length)
	{
		$str = null;
		$strPol = "0123456789";
		$max = strlen($strPol) - 1;
		for($i = 0; $i < $length; $i++) {
			$str .= $strPol[rand(0, $max)];
		}

		return $str;
	}
 
	/**
	 * 自动判断把gbk或gb2312编码的字符串转为utf8
	 * 能自动判断输入字符串的编码类，如果本身是utf-8就不用转换，否则就转换为utf-8的字符串
	 * 支持的字符编码类型是：utf-8,gbk,gb2312
	 * @$str:string 字符串
	 * 
	 * @create 2016-11-14
	 * @author zlw
	 */
	private function gbkToUtf8($str)
	{
		$charset = mb_detect_encoding($str, array('ASCII', 'UTF-8', 'GBK', 'GB2312'));
		$charset = strtolower($charset);
		
		if ("utf-8" != $charset) {
			$str = iconv('UTF-8', $charset, $str);
		}
		
		return $str;
	}
	
	/**
	 * 数组装xml
	 * 
	 * @create 2016-11-14
	 * @author zlw
	 */
	private function arrayToXml($arr)
	{
		$xml = "<xml>"; 
		foreach ($arr as $key => $val) { 
			if (is_array($val)) { 
				$xml .= "<".$key.">".$this->arrayToXml($val)."</".$key.">"; 
			} else { 
				if (is_numeric($val)) {
					$xml .= "<".$key.">".$val."</".$key.">";
				} else {
					$xml .= "<".$key."><![CDATA[".$val."]]></".$key.">"; 
				}
			} 
		} 
		$xml .= "</xml>";
		
		return $xml;
	}

	/**
	 * XML转数组
	 * 
	 * @create 2016-11-14
	 * @author zlw
	 */
	private function xmlToArray($postStr) 
	{
		$msg = array();
		
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
		$msg = (array) simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
		
		return $msg;
	}
}
