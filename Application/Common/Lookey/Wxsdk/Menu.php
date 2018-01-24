<?php

namespace Lookey\Wxsdk;


/**
 * 菜单
 *
 * @create 2016-11-10
 * @author zlw
 */
class Menu 
{
	
	//微信Token
	public $accessToken = null;

	//获取菜单
	private $getMenuUrl = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token=[ACCESS_TOKEN]";

	//保存菜单
	private $saveMenuUrl = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=[ACCESS_TOKEN]";
	
	//删除菜单
	private $deleteMenuUrl = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=[ACCESS_TOKEN]";
	
	//错误ID
	protected $errId = null;
	
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
	 * 获取菜单
	 *
	 * @create 2016-11-10
	 * @author zlw
	 */
	public function getMenu()
	{
		if (empty($this->accessToken)) {
			return false;
		}
		
		$accessToken = $this->accessToken;
		
		$getMenuUrl = str_replace(
			array('[ACCESS_TOKEN]'),
			array($accessToken),
			$this->getMenuUrl
		);
		
		$info = json_decode(Http::curlPost($getMenuUrl), true);
		
		if (isset($info['errcode'])) {
			if ($info['errcode'] == 0) {
				return $info;
			} else {
				$this->errId = $info['errcode'];
				return false;
			}
		}

		return $info; 
	}
	
	/**
	 * 删除菜单
	 *
	 * @create 2016-11-16
	 * @author zlw
	 */
	public function deleteMenu()
	{
		if (empty($this->accessToken)) {
			return false;
		}
		
		$accessToken = $this->accessToken;
		
		$deleteMenuUrl = str_replace(
			array('[ACCESS_TOKEN]'),
			array($accessToken),
			$this->deleteMenuUrl
		);
		
		$info = json_decode(Http::curlPost($deleteMenuUrl), true);
		
		if (isset($info['errcode'])) {
			if ($info['errcode'] == 0) {
				return $info;
			} else {
				$this->errId = $info['errcode'];
				return false;
			}
		}

		return $info; 
	}
   
	/**
	 * 保存菜单
	 *
	 * @create 2016-11-10
	 * @author zlw
	 */
	public function saveMenu($info)
	{
		if (empty($this->accessToken)) {
			return false;
		}
		
		/**
		$info = json_encode($info);
		$info = preg_replace("#\\\u([0-9a-f]{4})#ie", "iconv('UCS-2', 'UTF-8', pack('H4', '\\1'))", $info);
		*/
		
		$accessToken = $this->accessToken;
		
		$saveMenuUrl = str_replace(
			array('[ACCESS_TOKEN]'),
			array($accessToken),
			$this->saveMenuUrl
		);
		
		$info = json_decode(Http::curlPost($saveMenuUrl, $info), true);
		
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
