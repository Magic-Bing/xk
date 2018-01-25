<?php

namespace Lookey\Wxsdk;


/**
 * 发送消息
 *
 * @create 2016-11-10
 * @author zlw
 */
class Message 
{
	
	//微信Token
	public $accessToken = null;

	//单独发消息
	private $customSendUrl = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=[ACCESS_TOKEN]";

	//群发消息
	private $massSendUrl = "https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=[ACCESS_TOKEN]";
	
	//错误ID
	protected $errId = null;
	
	/**
	 * 设置accessToken
	 *
	 * @create 2016-11-10
	 * @author zlw
	 */
	public function setAccessToken($accessToken = '')
	{
		$this->accessToken = $accessToken;
		return $this;
	}	
	
	/**
	 * 给用户发送图文消息
	 *
	 * @create 2016-11-10
	 * @author zlw
	 */
    public function sendNews($openid, $arrItem)
	{
        if (!is_array($arrItem)) {
            return;
		}
		
        $itemTpl = '{"title":"%s","description":"%s","url":"%s","picurl":"%s"}';
        
		$itemStr = "";
        foreach ($arrItem as $item) {
            $itemStr .= sprintf(
				$itemTpl, 
				$item['title'], 
				$item['description'], 
				$item['url'],
				$item['picurl']
			);
		}
		
        $newsTpl = '{"touser":"%s","msgtype":"news","news":{"articles":[%s]}}';
        $dataStr = sprintf(
			$newsTpl, 
			$openid, 
			$itemStr
		);
		
		$accessToken = $this->accessToken;
		$customSendUrl = str_replace(
			array('[ACCESS_TOKEN]'),
			array($accessToken),
			$this->customSendUrl
		);
	
        $result = Http::curlPost($customSendUrl, $dataStr);
		
		//信息反馈
		$info = json_decode($result, true);
		if (isset($info['errcode'])) {
			if ($info['errcode'] == 0) {
				return true;
			} else {
				$this->errId = $info['errcode'];
				return false;
			}
		}
		
		return true;
    }
	
	/**
	 * 发送消息
	 *
	 * @create 2016-11-10
	 * @author zlw
	 */
	public function sendMsg($openid, $msg)
	{ 
		if (empty($this->accessToken)) {
			return false;
		}
		
		$accessToken = $this->accessToken;
		
		$customSendUrl = str_replace(
			array('[ACCESS_TOKEN]'),
			array($accessToken),
			$this->customSendUrl
		);
	
		//提交信息
		$postTpl = '{"touser":"%s","msgtype":"text","text":{"content":"%s"}}'; 
        $poststr = sprintf(
			$postTpl, 
			$openid, 
			$msg
		);
		
		$result = Http::curlPost($customSendUrl, $poststr);
		$info = json_decode($result, true);
		
		if (isset($info['errcode'])) {
			if ($info['errcode'] == 0) {
				return true;
			} else {
				$this->errId = $info['errcode'];
				return false;
			}
		}

		return true;
	}
	
	/**
	 * 群发消息
	 * 根据OpenID列表群发【订阅号不可用，服务号认证后可用】
	 *
	 * @create 2016-11-10
	 * @author zlw
	 */
    public function massSendmsg($openidaArr, $msg)
	{ 		
		if (empty($this->accessToken)) {
			return false;
		}
		
		$accessToken = $this->accessToken;
		
		$massSendUrl = str_replace(
			array('[ACCESS_TOKEN]'),
			array($accessToken),
			$this->massSendUrl
		);
		
		//提交的信息
		$postTpl = '{"touser":"%s","msgtype":"text","text":{"content":"%s"}}'; 
        $poststr = sprintf(
			$postTpl, 
			$openidaArr, 
			$msg
		);

 		$result = Http::curlPost($massSendUrl, $poststr);
		$info = json_decode($result, true);
  
		if (isset($info['errcode'])) {
			if ($info['errcode'] == 0) {
				return true;
			} else {
				$this->errId = $info['errcode'];
				return false;
			}
		}

		return true;
    }
	
	/**
	 * 获取错误ID
	 *
	 * @create 2016-11-16
	 * @author zlw
	 */
	public function getErrId()
	{
		return $this->errId;
	}

}
