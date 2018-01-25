<?php

namespace Lookey\Wxsdk;


/**
 * 多媒体
 *
 * @create 2016-11-10
 * @author zlw
 */
class Media 
{
	
	//微信Token
	public $accessToken = null;

	//多媒体上传链接
	private $mediaUploadUrl = "http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=[ACCESS_TOKEN]";
	
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
	 * 上传多媒体文件
	 *
	 * @create 2016-11-16
	 * @author zlw
	 */
	public function uploadMedia($type, $file)
	{
		
		if (empty($this->accessToken)) {
			return false;
		}
		
		$accessToken = $this->accessToken;
		
		$mediaUploadUrl = str_replace(
			array('[ACCESS_TOKEN]'),
			array($accessToken),
			$this->mediaUploadUrl
		);
		
		$data = array(
			"media"  => "@".$file
		);
		$info = json_decode(Http::curlPost($mediaUploadUrl, $data), true);
		
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
	 * 下载多媒体文件
	 *
	 * @create 2016-11-10
	 * @author zlw
	 */
    function saveMedia($url)
	{
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);    
        curl_setopt($ch, CURLOPT_NOBODY, 0); //对body进行输出。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $package = curl_exec($ch);
        $httpinfo = curl_getinfo($ch);
       
        curl_close($ch);
        $media = array_merge(array('mediaBody' => $package), $httpinfo);
        
        //求出文件格式
        preg_match('/\w\/(\w+)/i', $media["content_type"], $extmatches);
        $media['file_ext'] = $extmatches[1];
		
		return $media;
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
