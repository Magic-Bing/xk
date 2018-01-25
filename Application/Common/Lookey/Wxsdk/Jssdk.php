<?php

namespace Lookey\Wxsdk;


/**
 * 获取微信签名
 *
 * @create 2016-9-12
 * @author zlw
 */
class Jssdk 
{

	//微信ID
	private $appId;
	
	//微信密钥
	private $appSecret;
	
	//是否为企业号
	private $isEnterpriseId;
	
	//文件缓存目录
	public $path;
	
	//用户信息
	public $userInfoUrl = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=[ACCESS_TOKEN]&openid=[OPENID]";
	
	//关注用户信息列表
	public $followUserUrl = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=[ACCESS_TOKEN]&next_openid=[NEXT_OPENID]";
	
	//凭证
	public $ticketUrl = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=[ACCESS_TOKEN]";
	
	//企业凭证
	public $qyTicketUrl = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=[ACCESS_TOKEN]";
	
	//签名凭证
	public $tokenUrl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=[APP_ID]&secret=[APP_SECRET]";
	
	//企业签名凭证
	public $qyTokenUrl = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=[APP_ID]&corpsecret=[APP_SECRET]";

	/**
	 * 构造函数
	 *
	 * @create 2016-9-12
	 * @author zlw
	 */
	public function __construct(
		$appId, 
		$appSecret, 
		$isEnterpriseId = false
	) {
		$this->appId = $appId;
		$this->appSecret = $appSecret;
		$this->isEnterpriseId = $isEnterpriseId;
	}

	/**
	 * 设置缓存目录
	 *
	 * @create 2016-9-12
	 * @author zlw
	 */
	public function setPath($path) 
	{
		if (!file_exists($path)) {
			mkdir(iconv("UTF-8", "GBK", $path),0777,true); 
		}
		
		$this->path = $path;
		return $this;
	}

	/**
	 * 获取微信用户信息
	 *
	 * @create 2016-9-12
	 * @author zlw
	 */
	public function getUserInfo($openId) 
	{
		$accessToken = $this->getAccessToken();
		
		$url = str_replace(
			array('[ACCESS_TOKEN]', '[OPENID]'),
			array($accessToken, $openId),
			$this->userInfoUrl
		);

		$data = json_decode(Http::curlGet($url), true);
		return $data;
	}

	/**
	 * 获取微信关注用户列表
	 *
	 * @create 2016-9-12
	 * @author zlw
	 */
	public function getFollowUser($next_openid = '') 
	{
		$accessToken = $this->getAccessToken();
		
		$url = str_replace(
			array('[ACCESS_TOKEN]', '[NEXT_OPENID]'),
			array($accessToken, $next_openid),
			$this->followUserUrl
		);

		$data = json_decode(Http::curlGet($url), true);
		return $data;
	}

	/**
	 * 获取微信签名包
	 *
	 * @create 2016-6-6
	 * @author zlw
	 */
	public function getSignPackage() 
	{
		$jsapiTicket = $this->getJsApiTicket();

		// 注意 URL 一定要动态获取，不能 hardcode.
		$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
		$url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

		$timestamp = time();
		$nonceStr = $this->createNonceStr();

		// 这里参数的顺序要按照 key 值 ASCII 码升序排序
		$string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

		$signature = sha1($string);

		$signPackage = array(
			"appId"     => $this->appId,
			"nonceStr"  => $nonceStr,
			"timestamp" => $timestamp,
			"url"       => $url,
			"signature" => $signature,
			"rawString" => $string
		);
		return $signPackage; 
	}

	/**
	 * 获取签名凭证
	 *
	 * @create 2016-9-12
	 * @author zlw
	 */
	public function getAccessToken() 
	{
		// access_token 应该全局存储与更新，以下代码以写入到文件中做示例
		$file = $this->path 
			. "access_token_"
			. md5($this->appId . $this->appSecret . $this->isEnterpriseId) 
			. ".json";
		$data = json_decode(file_get_contents($file));
		
		if (!isset($data->expire_time) 
			|| $data->expire_time < time()
		) {
			if ($this->isEnterpriseId) {
				// 如果是企业号用以下URL获取access_token
				$url = str_replace(
					array('[APP_ID]', '[APP_SECRET]'),
					array($this->appId, $this->appSecret),
					$this->qyTokenUrl
				);
			} else {
				$url = str_replace(
					array('[APP_ID]', '[APP_SECRET]'),
					array($this->appId, $this->appSecret),
					$this->tokenUrl
				);
			}
			
			$res = json_decode(Http::curlGet($url));
			$access_token = $res->access_token;
			
			if ($access_token) {
				$data->expire_time = time() + 7000;
				$data->access_token = $access_token;
				$fp = fopen($file, "w");
				fwrite($fp, json_encode($data));
				fclose($fp);
			}
		} else {
			$access_token = $data->access_token;
		}
		
		return $access_token;
	}

	/**
	 * 获取微信凭据
	 *
	 * @create 2016-9-12
	 * @author zlw
	 */
	public function getJsApiTicket() 
	{
		// jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
		$file = $this->path 
			. "jsapi_ticket_" 
			. md5($this->appId . $this->appSecret . $this->isEnterpriseId) 
			. ".json";
		$data = json_decode(file_get_contents($file));
		
		if (!isset($data->expire_time) 
			|| $data->expire_time < time()
		) {
			$accessToken = $this->getAccessToken();
			if ($this->isEnterpriseId) {
				// 如果是企业号用以下 URL 获取 ticket
				$url = str_replace(
					array('[ACCESS_TOKEN]'),
					array($accessToken),
					$this->qyTicketUrl
				);
			} else {
				$url = str_replace(
					array('[ACCESS_TOKEN]'),
					array($accessToken),
					$this->ticketUrl
				);
			}
			$res = json_decode(Http::curlGet($url));
			$ticket = $res->ticket;
			if ($ticket) {
				$data->expire_time = time() + 7000;
				$data->jsapi_ticket = $ticket;
				$fp = fopen($file, "w");
				fwrite($fp, json_encode($data));
				fclose($fp);
			}
		} else {
			$ticket = $data->jsapi_ticket;
		}

		return $ticket;
	}

	/**
	 * 创建随机数
	 *
	 * @create 2016-9-12
	 * @author zlw
	 */
	private function createNonceStr($length = 16) 
	{
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = "";
		for ($i = 0; $i < $length; $i++) {
			$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
		}
		return $str;
	}

}
