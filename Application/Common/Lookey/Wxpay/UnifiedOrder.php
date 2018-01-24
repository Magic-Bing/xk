<?php

namespace Lookey\Wxpay;


/**
 * 微信扫码支付
 * 
 * @create 2016-11-14
 * @author zlw
 */
class UnifiedOrder
{
	
	//商户ID
	protected $mchid;

	//微信appid
	protected $appid;

	//支付key值
	protected $key;

	//错误信息
	protected $errMsg = '';
  
	/**
	 * 构造函数
	 * 
	 * @create 2016-11-15
	 * @author zlw
	 */	
	public function __construct($mchid, $appid, $key)
	{
		$this->mchid = $mchid; // 微信支付商户号 PartnerID 通过微信支付商户资料审核后邮件发送
		$this->appid = $appid; //公众号APPID 通过微信支付商户资料审核后邮件发送
		$this->key = $key;   //https://pay.weixin.qq.com 帐户设置-安全设置-API安全-API密钥-设置API密钥
	}
	
	/**
	 * @param string $openid 调用【网页授权获取用户信息】接口获取到用户在该公众号下的Openid
	 * @param float $totalFee 收款总费用 单位元
	 * @param string $outTradeNo 唯一的订单号
	 * @param string $orderName 订单名称
	 * @param string $notifyUrl 支付结果通知url 不要有问号
	 *   https://mp.weixin.qq.com/ 微信支付-开发配置-测试目录
	 *   测试目录 http://mp.weixin.com/paytest/  最后需要斜线，(需要精确到二级或三级目录)
	 * @return string
	 */
	public function createJsBizPackage(
		$openid, 
		$totalFee, 
		$outTradeNo, 
		$orderName, 
		$notifyUrl, 
		$timestamp
	) {
		$config = array(
			'mch_id' => $this->mchid,
			'appid' => $this->appid,
			'key' => $this->key,
		);
		
		$unified = array(
			'appid' => $config['appid'],
			'attach' => '支付',             //商家数据包，原样返回
			'body' => $orderName,
			'mch_id' => $config['mch_id'],
			'nonce_str' => self::createNonceStr(),
			'notify_url' => $notifyUrl,
			'openid' => $openid,            
			'out_trade_no' => $outTradeNo,
			'spbill_create_ip' => '127.0.0.1',
			'total_fee' => intval($totalFee * 100),       //单位 转为分
			'trade_type' => 'JSAPI', //rade_type=JSAPI，此参数必传
		);
		
		$unified['sign'] = self::getSign($unified, $config['key']);
		
		$responseXml = self::curlPost('https://api.mch.weixin.qq.com/pay/unifiedorder', self::arrayToXml($unified));
		
		/*
		<xml>
		<return_code><![CDATA[SUCCESS]]></return_code>
		<return_msg><![CDATA[OK]]></return_msg>
		<appid><![CDATA[wx00e5904efec77699]]></appid>
		<mch_id><![CDATA[1220647301]]></mch_id>
		<nonce_str><![CDATA[1LHBROsdmqfXoWQR]]></nonce_str>
		<sign><![CDATA[ACA7BC8A9164D1FBED06C7DFC13EC839]]></sign>
		<result_code><![CDATA[SUCCESS]]></result_code>
		<prepay_id><![CDATA[wx2015032016590503f1bcd9c30421762652]]></prepay_id>
		<trade_type><![CDATA[JSAPI]]></trade_type>
		</xml>
		*/
		
		$unifiedOrder = simplexml_load_string($responseXml, 'SimpleXMLElement', LIBXML_NOCDATA);
		
		if ($unifiedOrder === false) {
			$this->errMsg = 'parse xml error';
			return false;
		}
		
		if ($unifiedOrder->return_code != 'SUCCESS') {
			$this->errMsg = $unifiedOrder->return_msg;
			return false;
		}
		if ($unifiedOrder->result_code != 'SUCCESS') {
			$this->errMsg = $unifiedOrder->err_code;
			return false;
			/*
			NOAUTH 商户无此接口权限
			NOTENOUGH 余额不足
			ORDERPAID 商户订单已支付
			ORDERCLOSED 订单已关闭
			SYSTEMERROR 系统错误
			APPID_NOT_EXIST   APPID不存在
			MCHID_NOT_EXIST MCHID不存在
			APPID_MCHID_NOT_MATCH appid和mch_id不匹配
			LACK_PARAMS 缺少参数
			OUT_TRADE_NO_USED 商户订单号重复
			SIGNERROR 签名错误
			XML_FORMAT_ERROR XML格式错误
			REQUIRE_POST_METHOD 请使用post方法
			POST_DATA_EMPTY post数据为空
			NOT_UTF8 编码格式错误
			*/
		}
		
		//$unifiedOrder->trade_type 交易类型 调用接口提交的交易类型，取值如下：JSAPI，NATIVE，APP
		//$unifiedOrder->prepay_id 预支付交易会话标识 微信生成的预支付回话标识，用于后续接口调用中使用，该值有效期为2小时
		//$unifiedOrder->code_url 二维码链接 trade_type为NATIVE是有返回，可将该参数值生成二维码展示出来进行扫码支付
		$code_list = (array)$unifiedOrder->code_url;
		$arr = array(
			"appId" => $config['appid'],
			"timeStamp" => $timestamp,
			"nonceStr" => self::createNonceStr(),
			"package" => "prepay_id=" . $unifiedOrder->prepay_id,
			"signType" => 'MD5',
			"code_url" => $code_list[0]
		);
		
		$arr['paySign'] = self::getSign($arr, $config['key']);
		
		return $arr;
	}
	
	/**
	 * 查询订单
	 *
	 * @create 2016-11-22
	 * @author zlw
     */
    public function orderQuery($outTradeNo)
    {
        $config = array(
			'mch_id' => $this->mchid,
			'appid' => $this->appid,
			'key' => $this->key,
        );
		
        $unified = array(
            'appid' => $config['appid'],
            'mch_id' => $config['mch_id'],
            'out_trade_no' => $outTradeNo,
			'nonce_str' => $this->createNonceStr()
        );
		
        $unified['sign'] = $this->getSign($unified, $config['key']);
        $responseXml = $this->curlPost('https://api.mch.weixin.qq.com/pay/orderquery', $this->arrayToXml($unified));
        /*
        <xml><return_code><![CDATA[SUCCESS]]></return_code>
                <return_msg><![CDATA[OK]]></return_msg>
                <appid><![CDATA[wx406c5455be1a2590]]></appid>
                <mch_id><![CDATA[1398638602]]></mch_id>
                <nonce_str><![CDATA[ousUeAEvH6KlDiGe]]></nonce_str>
                <sign><![CDATA[D8BFB54A52C324238D5A4BA8C8BC6D01]]></sign>
                <result_code><![CDATA[SUCCESS]]></result_code>
                <out_trade_no><![CDATA[1476157452]]></out_trade_no>
                <trade_state><![CDATA[NOTPAY]]></trade_state>
                <trade_state_desc><![CDATA[订单未支付]]></trade_state_desc>
                </xml>
        */
		
        $unifiedOrder = simplexml_load_string($responseXml, 'SimpleXMLElement', LIBXML_NOCDATA);
		if ($unifiedOrder === false) {
			$this->errMsg = 'parse xml error';
			return false;
		}
		if ($unifiedOrder->return_code != 'SUCCESS') {
			$this->errMsg = $unifiedOrder->return_msg;
			return false;
		}
		if ($unifiedOrder->result_code != 'SUCCESS') {
			$this->errMsg = $unifiedOrder->err_code;
			return false;
            /*
            NOAUTH 商户无此接口权限
            NOTENOUGH 余额不足
            ORDERPAID 商户订单已支付
            ORDERCLOSED 订单已关闭
            SYSTEMERROR 系统错误
            APPID_NOT_EXIST   APPID不存在
            MCHID_NOT_EXIST MCHID不存在
            APPID_MCHID_NOT_MATCH appid和mch_id不匹配
            LACK_PARAMS 缺少参数
            OUT_TRADE_NO_USED 商户订单号重复
            SIGNERROR 签名错误
            XML_FORMAT_ERROR XML格式错误
            REQUIRE_POST_METHOD 请使用post方法
            POST_DATA_EMPTY post数据为空
            NOT_UTF8 编码格式错误
            */
        }
        //$unifiedOrder->trade_type 交易类型 调用接口提交的交易类型，取值如下：JSAPI，NATIVE，APP
        //$unifiedOrder->prepay_id 预支付交易会话标识 微信生成的预支付回话标识，用于后续接口调用中使用，该值有效期为2小时
        //$unifiedOrder->code_url 二维码链接 trade_type为NATIVE是有返回，可将该参数值生成二维码展示出来进行扫码支付
		/*
		public 'return_code' => string 'SUCCESS' (length=7)
		public 'return_msg' => string 'OK' (length=2)
		public 'appid' => string 'wx406c5455be1a2590' (length=18)
		public 'mch_id' => string '1398638602' (length=10)
		public 'nonce_str' => string 'lyt2ZGFeE9G0DI4W' (length=16)
		public 'sign' => string 'F942BB644E72FE29936C80E6780D8D8A' (length=32)
		public 'result_code' => string 'SUCCESS' (length=7)
		public 'out_trade_no' => string '1476157452' (length=10)
		public 'trade_state' => string 'NOTPAY' (length=6)
		public 'trade_state_desc' => string '订单未支付' (length=15)
		*/
		//已结支付
		/*
		object(SimpleXMLElement)[26]
			public 'return_code' => string 'SUCCESS' (length=7)
			public 'return_msg' => string 'OK' (length=2)
			public 'appid' => string 'wx406c5455be1a2590' (length=18)
			public 'mch_id' => string '1398638602' (length=10)
			public 'nonce_str' => string '6cFpzNc5BTyZ02x0' (length=16)
			public 'sign' => string 'F01C79BD0FC4BC4FE38231BA92A91201' (length=32)
			public 'result_code' => string 'SUCCESS' (length=7)
			public 'openid' => string 'ojIdvuCVrweMrgaU-dFobIItTtpk' (length=28)
			public 'is_subscribe' => string 'N' (length=1)
			public 'trade_type' => string 'NATIVE' (length=6)
			public 'bank_type' => string 'CFT' (length=3)
			public 'total_fee' => string '1' (length=1)
			public 'fee_type' => string 'CNY' (length=3)
			public 'transaction_id' => string '4001652001201610116386495939' (length=28)
			public 'out_trade_no' => string '1476161468' (length=10)
			public 'attach' => string '支付' (length=6)
			public 'time_end' => string '20161011125205' (length=14)
			public 'trade_state' => string 'SUCCESS' (length=7)
			public 'cash_fee' => string '1' (length=1)
		 */
		if (isset($unifiedOrder->trade_state_desc)){
			$msg = "订单未支付";
		}
		if (isset($unifiedOrder->transaction_id)){
			$msg = "已支付";
		}
		
		return $msg;
    }
  
	/**
	 * 响应
	 * 
	 * @create 2016-11-15
	 * @author zlw
	 */
	public function notify()
	{
		$config = array(
			'mch_id' => $this->mchid,
			'appid' => $this->appid,
			'key' => $this->key,
		);
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		
		//error_log($postStr, 3, './str.txt');
		/*
		$postStr = '<xml>
		<appid><![CDATA[wx00e5904efec77699]]></appid>
		<attach><![CDATA[支付测试]]></attach>
		<bank_type><![CDATA[CMB_CREDIT]]></bank_type>
		<cash_fee><![CDATA[1]]></cash_fee>
		<fee_type><![CDATA[CNY]]></fee_type>
		<is_subscribe><![CDATA[Y]]></is_subscribe>
		<mch_id><![CDATA[1220647301]]></mch_id>
		<nonce_str><![CDATA[a0tZ41phiHm8zfmO]]></nonce_str>
		<openid><![CDATA[oU3OCt5O46PumN7IE87WcoYZY9r0]]></openid>
		<out_trade_no><![CDATA[550bf2990c51f]]></out_trade_no>
		<result_code><![CDATA[SUCCESS]]></result_code>
		<return_code><![CDATA[SUCCESS]]></return_code>
		<sign><![CDATA[F6F519B4DD8DB978040F8C866C1E6250]]></sign>
		<time_end><![CDATA[20150320181606]]></time_end>
		<total_fee>1</total_fee>
		<trade_type><![CDATA[JSAPI]]></trade_type>
		<transaction_id><![CDATA[1008840847201503200034663980]]></transaction_id>
		</xml>';
		*/
		
		$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
		if ($postObj === false) {
			$this->errMsg = 'parse xml error';
			return false;
		}
		if ($postObj->return_code != 'SUCCESS') {
			$this->errMsg = $postObj->return_msg;
			return false;
		}
		if ($postObj->result_code != 'SUCCESS') {
			$this->errMsg = $postObj->err_code;
			return false;
		}
		$arr = (array)$postObj;
		unset($arr['sign']);
		
		if (self::getSign($arr, $config['key']) == $postObj->sign) {
			// $mch_id = $postObj->mch_id; //微信支付分配的商户号
			// $appid = $postObj->appid; //微信分配的公众账号ID
			// $openid = $postObj->openid; //用户在商户appid下的唯一标识
			// $transaction_id = $postObj->transaction_id;//微信支付订单号
			// $out_trade_no = $postObj->out_trade_no;//商户订单号
			// $total_fee = $postObj->total_fee; //订单总金额，单位为分
			// $is_subscribe = $postObj->is_subscribe; //用户是否关注公众账号，Y-关注，N-未关注，仅在公众账号类型支付有效
			// $attach = $postObj->attach;//商家数据包，原样返回
			// $time_end = $postObj->time_end;//支付完成时间
			
			return $postObj;
		} else {
			$this->errMsg = '支付失败';
			return false;
		}
	}
	
	/**
	 * 返回成功信息
	 *
	 * 成功：SUCCESS，失败：FAIL [报文为空]
	 * 
	 * @create 2016-11-23
	 * @author zlw
	 */
	public function replyNotify($returnCode = 'SUCCESS', $returnMsg = 'OK')
	{
		//成功：SUCCESS，失败：FAIL [报文为空]
		$msgArray['return_code'] = $returnCode;
		$msgArray['return_msg'] = $returnMsg;
		
		$msg = $this->arrayToXml($msgArray);
		return $msg;
	}
	
	/**
	 * 获取错误信息
	 * 
	 * @create 2016-11-23
	 * @author zlw
	 */
	public function getErrMsg()
	{
		return !empty($this->errMsg) ? $this->errMsg : '';
	}
	
	/**
	 * curl get
	 *
	 * @param string $url
	 * @param array $options
	 * @return mixed
	 * 
	 * @create 2016-11-15
	 * @author zlw
	 */
	public static function curlGet($url = '', $options = array())
	{
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		if (!empty($options)) {
			curl_setopt_array($ch, $options);
		}
		//https请求 不验证证书和host
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
  
	/**
	 * POST请求
	 * 
	 * @create 2016-11-15
	 * @author zlw
	 */
	public static function curlPost(
		$url = '', 
		$postData = '', 
		$options = array()
	) {
		if (is_array($postData)) {
			$postData = http_build_query($postData);
		}
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30); //设置cURL允许执行的最长秒数
		if (!empty($options)) {
			curl_setopt_array($ch, $options);
		}
		
		//https请求 不验证证书和host
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
  
	/**
	 * 随机字符串
	 * 
	 * @create 2016-11-15
	 * @author zlw
	 */
	public static function createNonceStr($length = 16)
	{
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$str = '';
		for ($i = 0; $i < $length; $i++) {
			$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
		}
		return $str;
	}
  
	/**
	 * 数组转XML
	 * 
	 * @create 2016-11-15
	 * @author zlw
	 */
	public static function arrayToXml($arr)
	{
		$xml = "<xml>";
		foreach ($arr as $key => $val) {
			if (is_numeric($val)) {
				$xml .= "<" . $key . ">" . $val . "</" . $key . ">";
			} else {
				$xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
			}
			$xml .= "</xml>";
		}
		
		return $xml;
	}
	
	/**
	 * 例如：
	 * appid：  wxd930ea5d5a258f4f
	 * mch_id：  10000100
	 * device_info： 1000
	 * Body：  test
	 * nonce_str： ibuaiVcKdpRxkhJA
	 * 第一步：对参数按照 key=value 的格式，并按照参数名 ASCII 字典序排序如下：
	 * stringA="appid=wxd930ea5d5a258f4f&body=test&device_info=1000&mch_i
	 * d=10000100&nonce_str=ibuaiVcKdpRxkhJA";
	 * 第二步：拼接支付密钥：
	 * stringSignTemp="stringA&key=192006250b4c09247ec02edce69f6a2d"
	 * sign=MD5(stringSignTemp).toUpperCase()="9A0A8659F005D6984697E2CA0A9CF3B7"
	 */
	/**
	 * 获取签名
	 * 
	 * @create 2016-11-15
	 * @author zlw
	 */
	public static function getSign($params, $key)
	{
		ksort($params, SORT_STRING);
		$unSignParaString = self::formatQueryParaMap($params, false);
		$signStr = strtoupper(md5($unSignParaString . "&key=" . $key));
		return $signStr;
	}
  
	/**
	 * 组装数据
	 * 
	 * @create 2016-11-15
	 * @author zlw
	 */
	protected static function formatQueryParaMap($paraMap, $urlEncode = false)
	{
		$buff = "";
		ksort($paraMap);
		foreach ($paraMap as $k => $v) {
			if (null != $v && "null" != $v) {
				if ($urlEncode) {
				$v = urlencode($v);
				}
				$buff .= $k . "=" . $v . "&";
			}
		}
		$reqPar = '';
		if (strlen($buff) > 0) {
			$reqPar = substr($buff, 0, strlen($buff) - 1);
		}
		return $reqPar;
	}
  
}
