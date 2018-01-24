<?php

namespace Lookey\WxpayApi;

use Lookey\WxpayApi\Api\WxPayApi as WxPayApi;
use Lookey\WxpayApi\Data\WxPayDataBase as WxPayDataBase;
use Lookey\WxpayApi\Data\WxPayResults as WxPayResults;
use Lookey\WxpayApi\Data\WxPayNotifyReply as WxPayNotifyReply;
use Lookey\WxpayApi\Data\WxPayUnifiedOrder as WxPayUnifiedOrder;
use Lookey\WxpayApi\Data\WxPayOrderQuery as WxPayOrderQuery;
use Lookey\WxpayApi\Data\WxPayCloseOrder as WxPayCloseOrder;
use Lookey\WxpayApi\Data\WxPayRefund as WxPayRefund;
use Lookey\WxpayApi\Data\WxPayRefundQuery as WxPayRefundQuery;
use Lookey\WxpayApi\Data\WxPayDownloadBill as WxPayDownloadBill;
use Lookey\WxpayApi\Data\WxPayReport as WxPayReport;
use Lookey\WxpayApi\Data\WxPayShortUrl as WxPayShortUrl;
use Lookey\WxpayApi\Data\WxPayMicroPay as WxPayMicroPay;
use Lookey\WxpayApi\Data\WxPayReverse as WxPayReverse;
use Lookey\WxpayApi\Data\WxPayJsApiPay as WxPayJsApiPay;
use Lookey\WxpayApi\Data\WxPayBizPayUrl as WxPayBizPayUrl;


/**
 * 
 * 刷卡支付实现类
 * @author widyhu
 *
 */
class NativePay
{
	/**
	 * 
	 * 生成扫描支付URL,模式一
	 * @param BizPayUrlInput $bizUrlInfo
	 */
	public function GetPrePayUrl($productId) {
		$biz = new WxPayBizPayUrl();
		$biz->SetProduct_id($productId);
		$values = WxpayApi::bizpayurl($biz);
		$url = "weixin://wxpay/bizpayurl?" . $this->ToUrlParams($values);
		return $url;
	}
	
	/**
	 * 
	 * 参数数组转换为url参数
	 * @param array $urlObj
	 */
	private function ToUrlParams($urlObj) {
		$buff = "";
		foreach ($urlObj as $k => $v) {
			$buff .= $k . "=" . $v . "&";
		}
		
		$buff = trim($buff, "&");
		return $buff;
	}
	
	/**
	 * 
	 * 生成直接支付url，支付url有效期为2小时,模式二
	 * @param UnifiedOrderInput $input
	 */
	public function GetPayUrl($input)
	{
		if ($input->GetTrade_type() == "NATIVE") {
			$result = WxPayApi::unifiedOrder($input);
			return $result;
		}
	}
}
