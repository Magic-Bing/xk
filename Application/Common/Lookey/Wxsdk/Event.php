<?php

namespace Lookey\Wxsdk;


/**
 * 接收微信推送事件
 *
 * @create 2016-11-10
 * @author zlw
 */
class Event 
{
	
	/**
	 * 事件获取数据对象
	 *
	 * @create 2016-11-11
	 * @author zlw
	 */
	public $postObj = null;
	
	/**
	 * 事件获取数据数组
	 *
	 * @create 2016-11-11
	 * @author zlw
	 */
	public $postArr = null;
	
	/**
	 * 返回数据
	 *
	 * @create 2016-11-11
	 * @author zlw
	 */
	public $result = null;
	
	/**
	 * 执行
	 *
	 * @create 2016-11-11
	 * @author zlw
	 */
    public function isEchostr()
    {
		if (isset($_GET["echostr"])) {
			return true;	
		} else {	
			return false;	
		}
    }
	
	/**
	 * 返回验证
	 *
	 * @create 2016-11-21
	 * @author zlw
	 */
    public function returnEchostr()
    {
		ob_clean();
		echo $_GET["echostr"];
		exit;
    }
	
	/**
	 * 验证
	 *
	 * @create 2016-11-11
	 * @author zlw
	 */
    public function valid($accessToken)
    {
        $echoStr = $_GET["echostr"];
        if ($this->checkSignature($accessToken)) {
			ob_clean();
            echo $echoStr;
            exit;
        }
    }

	/**
	 * 验证签名包
	 *
	 * @create 2016-11-11
	 * @author zlw
	 */
    private function checkSignature($accessToken)
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = $accessToken;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if ( $tmpStr == $signature ) {
            return true;
        } else {
            return false;
        }
    }

	/**
	 * 获取事件信息
	 *
	 * @create 2016-11-10
	 * @author zlw
	 */
	public function getEvent()
	{
        $postStr = isset($GLOBALS["HTTP_RAW_POST_DATA"]) ? $GLOBALS["HTTP_RAW_POST_DATA"] : "";
        if (empty($postStr)) {
			return false;
		}
		
		$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        
		// 普通消息和事件消息等共用的有以下字段
		//toUserName、FromUserName、CreateTime、MsgType
		
		//对象
		$this->postObj = $postObj;
		
		//数组
		$this->postArr = json_decode(json_encode($postObj), true); 
		
		return $this;
    }

	/**
	 * 返回信息
	 *
	 * @create 2016-11-8
	 * @author zlw
	 */
    public function responseMsg($msg = '')
    {
		if (empty($msg)) {
			$msg = $this->result;
		}
		
		ob_clean();
		echo $msg;
		exit;
	}
	
	/**
	 * 获取事件信息返回数据
	 *
	 * @create 2016-11-10
	 * @author zlw
	 */
	public function getPostObj()
	{
		return $this->postObj;
	}
	
	/**
	 * 获取事件信息返回数据数组
	 *
	 * @create 2016-11-11
	 * @author zlw
	 */
	public function getPostArr()
	{
		return $this->postArr;
	}
	
	/**
	 * ToUserName
	 *
	 * @create 2016-11-10
	 * @author zlw
	 */
	public function getToUserName()
	{
		return $this->postObj->ToUserName;
	}
	
	/**
	 * FromUserName
	 *
	 * @create 2016-11-10
	 * @author zlw
	 */
	public function getFromUserName()
	{
		return $this->postObj->FromUserName;
	}
	
	/**
	 * 创建时间
	 *
	 * @create 2016-11-10
	 * @author zlw
	 */
	public function getCreateTime()
	{
		return $this->postObj->CreateTime;
	}
	
	/**
	 * MsgType
	 *
	 * @create 2016-11-10
	 * @author zlw
	 */
	public function getMsgType()
	{
		return $this->postObj->MsgType;
	}

    /*
     * 回复文本消息
	 *
	 * @create 2016-11-11
	 * @author zlw
     */
    public function transmitText($object, $content)
    {
        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>";
        $result = sprintf(
			$textTpl, 
			$object->FromUserName, 
			$object->ToUserName, 
			time(), 
			$content
		);
		
		$this->result = $result;
		
        return $result;
    }
	
	/**
     * 返回图片回复模板
	 *
	 * @create 2016-11-11
	 * @author zlw
     */
    public function transmitPicture($object, $picurl, $mediaId = '', $msgId = '')
	{   	
    	$textTpl= "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[image]]></MsgType>
<PicUrl><![CDATA[%s]]></PicUrl>
<MediaId><![CDATA[%s]]></MediaId>
<MsgId>%s</MsgId>
</xml>";
        $result = sprintf(
			$textTpl, 
			$object->FromUserName, 
			$object->ToUserName, 
			time(), 
			$picurl, 
			$mediaId, 
			$msgId
		);
		
		$this->result = $result;
		
    	return $result;    	
    }
	
    /**
     * 返回图文回复模板
 	 *
	 * @create 2016-11-11
	 * @author zlw
    */
    public function transmitTextAndPicture($object, $picurl, $article = array())
	{
    	$textTpl="<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<ArticleCount>1</ArticleCount>
<Articles>
<item>
<Title><![CDATA[%s]]></Title>
<Description><![CDATA[%s]]></Description>
<PicUrl><![CDATA[%s]]></PicUrl>
<Url><![CDATA[%s]]></Url>
</item>
</Articles>
</xml>";
		
        $result = sprintf(
			$textTpl, 
			
			$object->FromUserName, 
			$object->ToUserName, 
			time(), 
			$article['Title'], 
			$article['Description'], 
			$article['PicUrl'], 
			$article['Url']
		);
		
		$this->result = $result;
		
    	return $result;  	
    }
    
    /**
     * 回复图文
 	 *
	 * @create 2016-11-11
	 * @author zlw
    */
    public function transmitNews($object, $arrItem)
    {
        if (!is_array($arrItem)) {
            return;
		}
		
        $itemTpl = "<item>
<Title><![CDATA[%s]]></Title>
<Description><![CDATA[%s]]></Description>
<PicUrl><![CDATA[%s]]></PicUrl>
<Url><![CDATA[%s]]></Url>
</item>";
        $itemStr = "";
		
        foreach ($arrItem as $item) {
            $itemStr .= sprintf(
				$itemTpl, 
				$item['Title'], 
				$item['Description'], 
				$item['PicUrl'], 
				$item['Url']
			);
		}
       
	   $newsTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<Content><![CDATA[]]></Content>
<ArticleCount>%s</ArticleCount>
<Articles>%s</Articles>
</xml>";

        $resultStr = sprintf(
			$newsTpl, 
			$object->FromUserName, 
			$object->ToUserName, 
			time(), 
			count($arrItem),
			$itemStr
		);
        
		return $resultStr;
    }
    
    /**
     * 音乐消息
 	 *
	 * @create 2016-11-11
	 * @author zlw
    */
    public function transmitMusic($object, $musicArray, $flag = 0)
    {
        $itemTpl = "<Music>
<Title><![CDATA[%s]]></Title>
<Description><![CDATA[%s]]></Description>
<MusicUrl><![CDATA[%s]]></MusicUrl>
<HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
</Music>";
        $itemStr = sprintf(
			$itemTpl, 
			$musicArray['Title'], 
			$musicArray['Description'], 
			$musicArray['MusicUrl'], 
			$musicArray['HQMusicUrl']
		);
        
		$textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[music]]></MsgType>
%s
<FuncFlag>%d</FuncFlag>
</xml>";
		$resultStr = sprintf(
			$textTpl, 
			$object->FromUserName, 
			$object->ToUserName, 
			time(), 
			$itemStr, 
			$flag
		);
		
        return $resultStr;
    }

}

/**
事件类型：
@create 2016-11-10
@author zlw

根据事件消息的事件名将事件分类，单个去处理。

每个事件消息的共用部分是Event，代表了事件类型。

事件名称（Event的值）

关注（subscribe）

取消关注（unsubscribe）

上报地理位置（LOCATION）

自定义菜单拉取消息（CLICK）

点击菜单跳转（VIEW）

扫描带参数二维码（SCAN）

扫码推事件（scancode_push）

扫描显示消息接受中（scancode_waitmsg）

弹出系统拍照发图（pic_sysphoto）

弹出拍照或者相册发图（pic_photo_or_album）

弹出微信相册发图器（pic_weixin）

弹出地理位置选择器（location_select）

模板消息送达情况提醒（TEMPLATESENDJOBFINISH）

群发消息后的通知（MASSSENDJOBFINISH）

微信小店订单支付后的通知（merchant_order）

资质认证成功（qualification_verify_success）

资质认证失败（qualification_verify_fail）

名称认证成功（naming_verify_success）

名称认证失败（naming_verify_fail）

年审通知（annual_renew）

认证过期失效通知（verify_expired）

**/
