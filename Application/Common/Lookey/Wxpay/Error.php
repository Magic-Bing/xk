<?php

namespace Lookey\Wxpay;


/**
 * 错误码
 *
 * @create 2016-11-14
 * @author zlw
 */
class Error
{
	
	//错误代码信息
	public static $errorCode = array(
		'NO_AUTH' 		=> '发放失败，此请求可能存在风险，已被微信拦截',
		'SENDNUM_LIMIT' => '该用户今日领取红包个数超过限制',
		'CA_ERROR'		=> '请求未携带证书，或请求携带的证书出错',
		'ILLEGAL_APPID'	=> '错误传入了app的appid',
		'SIGN_ERROR' 	=> '商户签名错误',
		'FREQ_LIMIT' 	=> '受频率限制',
		'XML_ERROR'		=> '请求的xml格式错误，或者post的数据为空',
		'PARAM_ERROR' 	=> '参数错误',
		'OPENID_ERROR' 	=> 'Openid错误',
		'NOTENOUGH' 	=> '余额不足',
		'FATAL_ERROR' 	=> '重复请求时，参数与原单不一致',
		'SECOND_OVER_LIMITED' 	=> '企业红包的按分钟发放受限',
		'DAY_OVER_LIMITED' 		=> '企业红包的按天日发放受限',
		'MONEY_LIMIT' 	=> '红包金额发放限制',
		'SEND_FAILED' 	=> '红包发放失败,请更换单号再重试',
		'SYSTEMERROR' 	=> '系统繁忙，请再试。',
		'PROCESSING' 	=> '请求已受理，请稍后使用原单号查询发放结果',
	);

	/**
	 * 获取错误详情
	 *
	 * @create 2016-11-4
	 * @author zlw
	 */
	public static function getErrorInfo($errcode) 
	{
		if (isset(static::$errorCode[$errcode])) {
			return static::$errorCode[$errcode];
		} else {
			return '未知错误：' . $errcode;
		}
	}
	
	//------------------------
	
	//错误代码信息
	public static $hbinfoErrorCode = array(
		'CA_ERROR'		=> '请求未携带证书，或请求携带的证书出错',
		'SIGN_ERROR' 	=> '商户签名错误',
		'NO_AUTH' 		=> '没有权限',
		'NOT_FOUND' 	=> '指定单号数据不存在',
		'FREQ_LIMIT' 	=> '受频率限制',
		'XML_ERROR'		=> '请求的xml格式错误，或者post的数据为空',
		'PARAM_ERROR' 	=> '参数错误',
		'SYSTEMERROR' 	=> '系统繁忙，请重试。',
	);

	/**
	 * 获取错误详情
	 *
	 * @create 2016-11-4
	 * @author zlw
	 */
	public static function getHbinfoErrorInfo($errcode) 
	{
		if (isset(static::$hbinfoErrorCode[$errcode])) {
			return static::$hbinfoErrorCode[$errcode];
		} else {
			return '未知错误：' . $errcode;
		}
	}
	
}
