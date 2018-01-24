<?php

namespace Lookey\Wxsdk;


/**
 * 微信短地址转换
 *
 * @create 2016-11-4
 * @author zlw
 */
class Shorturl
{	
	
	//微信Token
	public $accessToken = null;

	//获取ticket
	private $shorturlUrl = "https://api.weixin.qq.com/cgi-bin/shorturl?access_token=[ACCESS_TOKEN]";
	
	/**
	 * 设置accessToken
	 *
	 * @create 2016-10-4
	 * @author zlw
	 */
	public function setAccessToken($accessToken = '')
	{
		$this->accessToken = $accessToken;
		return $this;
	}	

	/**
	 * 获取短地址
	 *
	 * @create 2016-11-4
	 * @author zlw
	 */
	public function getShorturl($longurl) 
	{
		$shorturl = str_replace(
			array('[ACCESS_TOKEN]'),
			array($accessToken),
			$this->shorturlUrl
		);
		
		$data = '{"action":"long2short", "long_url":"'.$longurl.'"}'; 
		
		$result = Http::curlPost($shorturl, $data);
		$result = json_decode($result, true);
		
		if ($result['errcode'] === 0) {
			return $result;
		} else {
			return array(
				'errcode' => $result['errcode'],
				'errmsg' => Error::getErrorInfo($result['errcode']),
			);
		}
	}
	
}
