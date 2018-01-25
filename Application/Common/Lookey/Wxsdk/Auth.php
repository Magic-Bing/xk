<?php

namespace Lookey\Wxsdk;


/**
 * 微信认证
 *
 * @create 2016-9-12
 * @author zlw
 */
class Auth
{
	
	//微信id
	public $appId = null;
	
	//微信key
	public $appSecret = null;
	
	//微信Token
	public $accessToken = null;
	
	//获取微信code
	public $snsapiUrl = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=[APP_ID]&redirect_uri=[REDIRECT_URI]&response_type=code&scope=[SCOPE]&state=[STATE]#wechat_redirect";
	
	//获取微信授权凭证（access_token）
	public $accessTokenUrl = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=[APP_ID]&secret=[APP_SECRET]&code=[CODE]&grant_type=authorization_code";
  
	//刷新access_token
	public $refreshTokenUrl = "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=[APP_ID]&grant_type=refresh_token&refresh_token=[REFRESH_TOKEN]";

	//拉取用户信息
	public $userInfoUrl = "https://api.weixin.qq.com/sns/userinfo?access_token=[ACCESS_TOKEN]&openid=[OPENID]&lang=zh_CN";

	//检验授权凭证（access_token）是否有效
	public $snsAuthUrl = "https://api.weixin.qq.com/sns/auth?access_token=[ACCESS_TOKEN]&openid=[OPENID]";
	
	//错误代码
	public $errcode = null;
	
	//错误信息
	public $errmsg = null;
	
	/**
	 * 构造函数
	 *
	 * @create 2016-9-9
	 * @author zlw
	 */
	public function __construct($appId = '', $appSecret = '')
	{
		$this->appId = $appId;
		$this->appSecret = $appSecret;
	}
	
	/**
	 * 设置app_id
	 *
	 * @create 2016-9-9
	 * @author zlw
	 */
	public function setAppId($appId)
	{
		$this->appId = $appId;
		return $this;
	}
	
	/**
	 * 设置app_secret
	 *
	 * @create 2016-9-9
	 * @author zlw
	 */
	public function setAppSecret($appSecret)
	{
		$this->appSecret = $appSecret;
		return $this;
	}
	
	/**
	 * 获取微信代码
	 * 
	 * 'snsapi_base' - 静默授权
	 * 'snsapi_userinfo' - 用户授权
	 *
	 * @create 2016-9-12
	 * @author zlw
	 */
	public function getCode(
		$redirect_uri = '', 
		$scope = 'snsapi_userinfo', 
		$state = '123'
	) {
		$appid = $this->appId;	
		$redirect_uri = urlencode($redirect_uri);
		
		$url = str_replace(
			array('[APP_ID]', '[REDIRECT_URI]', '[SCOPE]', '[STATE]'),
			array($appid, $redirect_uri, $scope, $state),
			$this->snsapiUrl
		);
	
		header("location:".$url);
		exit;
	}

	/**
	 * 获取微信access_token
	 *
	 * @create 2016-9-9
	 * @author zlw
	 */
	public function getAccessToken($code = '') 
	{
		$appid = $this->appId;
		$appsecret = $this->appSecret;
		
		$accessTokenUrl = str_replace(
			array('[APP_ID]', '[APP_SECRET]', '[CODE]'),
			array($appid, $appsecret, $code),
			$this->accessTokenUrl
		);

		$data = json_decode(Http::curlGet($accessTokenUrl), true);		
		if (isset($data['errcode'])) {
			$this->errcode = $data['errcode'];
			$this->errmsg = $data['errmsg'];
			
			return false;
		}
		
		return $data;
	}	
	
	/**
	 * 刷新微信凭证
	 *
	 * @create 2016-9-12
	 * @author zlw
	 */
	public function refreshToken($refresh_token = '')
	{
		$appid = $this->appId;	
		
		$url = str_replace(
			array('[APP_ID]', '[REFRESH_TOKEN]'),
			array($appid, $refresh_token),
			$this->refreshTokenUrl
		);
	
		$data = json_decode(Http::curlGet($url), true);		
		if (isset($data['errcode'])) {
			$this->errcode = $data['errcode'];
			$this->errmsg = $data['errmsg'];
			
			return false;
		}
		
		return $data;
	}

	/**
	 * 获取微信用户信息
	 *
	 * 如果网页授权作用域为snsapi_userinfo，
	 * 则此时开发者可以通过access_token和openid拉取用户信息了。
	 *
	 * @create 2016-9-9
	 * @author zlw
	 */
	public function getUserInfo($openid, $access_token) 
	{
		$url = str_replace(
			array('[ACCESS_TOKEN]', '[OPENID]'),
			array($access_token, $openid),
			$this->userInfoUrl
		);

		$data = json_decode(Http::curlGet($url), true);
		if (isset($data['errcode'])) {
			$this->errcode = $data['errcode'];
			$this->errmsg = $data['errmsg'];
			
			return false;
		}
		
		return $data;
	}

	/**
	 * 检验授权凭证（access_token）是否有效
	 *
	 * @create 2016-9-12
	 * @author zlw
	 */
	public function checkSnsAuth($openid = '', $access_token) 
	{
		$snsAuthUrl = str_replace(
			array('[ACCESS_TOKEN]', '[OPENID]'),
			array($access_token, $openid),
			$this->snsAuthUrl
		);

		$data = json_decode(Http::curlGet($snsAuthUrl), true);
		if ($data['errcode'] != 0) {
			$this->errcode = $data['errcode'];
			$this->errmsg = $data['errmsg'];
			
			return false;
		} else {
			return true;
		}	
	}	

	/**
	 * 获取错误代码
	 *
	 * @create 2016-9-12
	 * @author zlw
	 */
	public function getErrcode() 
	{
		return $this->errcode;
	}	

	/**
	 * 获取错误信息
	 *
	 * @create 2016-9-12
	 * @author zlw
	 */
	public function getErrmsg() 
	{
		return $this->errmsg;
	}

	/**
	 * 获取错误详情
	 *
	 * @create 2016-9-12
	 * @author zlw
	 */
	public function getErrorInfo() 
	{
		return Error::getErrorInfo($this->errcode);
	}

	
}
