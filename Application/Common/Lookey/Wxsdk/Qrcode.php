<?php

namespace Lookey\Wxsdk;


/**
 * 微信生成二维码
 *
 * @create 2016-11-4
 * @author zlw
 */
class Qrcode 
{
	
	//微信Token
	public $accessToken = null;

	//获取ticket
	private $ticketUrl = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=[ACCESS_TOKEN]";

	//获取ticket
	private $showQrcodeUrl = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=[TICKET]";
	
	/**
	 * 设置accessToken
	 *
	 * @create 2016-11-4
	 * @author zlw
	 */
	public function setAccessToken($accessToken = '')
	{
		$this->accessToken = $accessToken;
		return $this;
	}	
	
	/**
	 * 创建临时二维码
	 *
	 * @create 2016-11-4
	 * @author zlw
	 */
	public function getQrcode($data = array())
	{
		$accessToken = $this->accessToken;
		
		$ticketUrl = str_replace(
			array('[ACCESS_TOKEN]'),
			array($accessToken),
			$this->ticketUrl
		);
		
		//参数配置
		//action_name: 二维码类型，
		//	QR_SCENE为临时,
		//	QR_LIMIT_SCENE为永久,
		//	QR_LIMIT_STR_SCENE为永久的字符串参数值
		switch (strtoupper($data['action_name'])) {
			case "QR_SCENE":
				if (!isset($data['expire_seconds'])) {
					$data['expire_seconds'] = 604800;
				}
				$qrcodeDate = '{"expire_seconds": '.$data['expire_seconds'].', "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": '.$data['scene_id'].'}}}';
				break;

			case "QR_LIMIT_SCENE":
				$qrcodeDate = '{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": '.$data['scene_id'].'}}}';
				break;
				
			case "QR_LIMIT_STR_SCENE":
				$qrcodeDate = '{"action_name": "QR_LIMIT_STR_SCENE", "action_info": {"scene": {"scene_str": '.$data['scene_str'].'}}}';
				break;
				
			default:
				$qrcodeDate = '{"expire_seconds": '.$data['expire_seconds'].', "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": '.$data['scene_id'].'}}}';
				break;
		}
		
		$result = Http::curlPost($ticketUrl, $qrcodeDate);
		$result = json_decode($result, true);
		
		$data = array(
			'ticket' => $result['ticket'],
			'expire_seconds' => $result['expire_seconds'],
			'url' => urldecode($result['url']),
		);
		
		return $data;
	}	
	
	/**
	 * 获取显示二维码的链接
	 *
	 * @create 2016-11-8
	 * @author zlw
	 */
	public function getShowQrcodeUrl($ticket)
	{
		$showQrcodeUrl = str_replace(
			array('[TICKET]'),
			array($ticket),
			$this->showQrcodeUrl
		);
		
		return $showQrcodeUrl;
	}
	
	/**
	 * 显示二维码
	 *
	 * @create 2016-11-4
	 * @author zlw
	 */
	public function showQrcode($ticket)
	{
		$showQrcodeUrl = str_replace(
			array('[TICKET]'),
			array($ticket),
			$this->showQrcodeUrl
		);
		
		$data = Http::curlGet($showQrcodeUrl);
		
		return $data;
	}
	
	/**
	 * 获得二维码图片
	 *
	 * @create 2016-11-8
	 * @author zlw
	 */
	public function getQrcodeImage($url) 
	{
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER,0);
		curl_setopt($ch, CURLOPT_NOBODY,0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$package = curl_exec($ch);
		$httpinfo = curl_getinfo($ch);
		curl_close($ch);
		
		return array_merge(
			array('body' => $package),
			array('header' => $httpinfo)
		);
	}	

	/**
	 * 微信返回请求
	 *
	 * @create 2016-10-4
	 * @author zlw
	 */
	public function getEvent()
	{
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        
		$toUserName = (string) $postObj->ToUserName;
		$fromUsername = (string) $postObj->FromUserName;
		$createTime = (string) $postObj->CreateTime;
		$msgType = (string) $postObj->MsgType;
        $ticket = (string) $postObj->TICKET;
        $event = (string) $postObj->Event;
        $EventKey = trim((string) $postObj->EventKey);
		
        $keyArray = explode("_", $EventKey);
		
		//已关注着扫描
		if (count($keyArray) == 1) {
			$value = $EventKey;
			$isFollow = true;
		} else {
			//未关注者扫描
			$value = $keyArray[1];
			$isFollow = false;
		}
		
		$data = array(
			'isFollow' => $isFollow,
			'toUserName' => $toUserName,
			'fromUsername' => $fromUsername,
			'createTime' => $createTime,
			'msgType' => $msgType,
			'event' => $event,
			'EventKey' => $EventKey,
			'value' => $value,
			'ticket' => $ticket,
		);
		
		return $data;
    }

}
