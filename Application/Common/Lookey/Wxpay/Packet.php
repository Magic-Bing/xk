<?php

namespace Lookey\Wxpay;


/**
 * 发送红包接口
 * 
 * @create 2016-11-14
 * @author zlw
 */
class Packet
{
	//发送红包
	private $sendredpackUrl = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
	
	//发放裂变红包
	private $sendgroupredpackUrl = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendgroupredpack';
	
	//查询红包
	private $getHbinfoUrl = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/gethbinfo';	
	
	/**
	 * 配置
	 */	
	private $config = array(
		'mch_id' => '', //商户号
		'weixin_appid' => '', //公众账号appid
		'send_name' => '', //商户名称
		'total_num' => 1, //发送红包总人数
		'wishing' => '', //红包祝福语
		'act_name' => '', //活动名称
		'remark' => '', //备注信息
		
		//key设置路径：微信商户平台(pay.weixin.qq.com)-->账户设置-->API安全-->密钥设置		
		'api_password' => '', //密钥
		
		'amt_type' => 'ALL_RAND', //红包金额设置方式[裂变红包]
		
		'public_key' => '', //公钥
		'private_key' => '', //私钥
		'rootca' => '', //ca证书
	);
	
	/**
	 * 支付句柄
	 */	
	private $wxpay = null;
 
	/**
	 * 构造函数
	 */	
	public function __construct($config = array())
	{
		if (!empty($config)) {
			$this->set_config($config);
		}
		
		if (!$this->wxpay) {
			$this->wxpay = new Wxpay();
		}
	}
	
	/**
	 * 设置配置信息
	 * 
	 * @create 2016-11-11
	 * @author zlw
	 */
	public function set_config($config = array())
	{
		//初始化红包设置信息
		$this->config = array_merge($this->config, $config);
		
		//调用接口的机器Ip地址
		$this->config['client_ip'] = $_SERVER['SERVER_ADDR'];
		
		return $this;
	}
	
	/**
	 * 设置证书
	 * 
	 * @create 2016-11-14
	 * @author zlw
	 */
	private function set_key()
	{
		//公钥
		$this->wxpay->setPublicKey($this->config['public_key']);
		
		//私钥
		$this->wxpay->setPrivateKey($this->config['private_key']);
		
		//ca证书
		$this->wxpay->setRootca($this->config['rootca']);
	}
  
	/**
	 * 发送红包
	 * 
	 * @create 2016-11-11
	 * @author zlw
	 */
	public function send_redpacket($re_openid, $total_amount)
	{
		$mch_billno = $this->wxpay->createMchBillno($this->config['mch_id']);
		
		$send_array = array(
			'mch_billno' 	=> $mch_billno,
			'mch_id' 		=> $this->config['mch_id'],
			'wxappid' 		=> $this->config['weixin_appid'],
			'send_name' 	=> $this->config['send_name'],
			're_openid' 	=> $re_openid,
			'total_amount' 	=> $total_amount,
			'total_num' 	=> $this->config['total_num'],
			'wishing' 		=> $this->config['wishing'],
			'client_ip' 	=> $this->config['client_ip'],
			'act_name' 		=> $this->config['act_name'],
			'remark' 		=> $this->config['remark'],
		);
		
		//设置证书
		$this->set_key();
		
		//提交
		$data = $this->wxpay->send($this->sendredpackUrl, $send_array, $this->config['api_password']);
		
		/**
		成功结果：
		$data = [
			'return_code' => 'SUCCESS', 
			'return_msg' => '发放成功.', 
			'result_code' => 'SUCCESS', 
			'err_code' => '0', 
			'err_code_des' => '发放成功.',
			'mch_billno' => '0010010404201411170000046545', 
			'mch_id' => '10010404', 
			'wxappid' => 'wx6fa7e3bab7e15415', 
			're_openid' => 'onqOjjmM1tad-3ROpncN-yUfa6uI', 
			'total_amount' => '1'
		]
		*/
		
		return $data;
	}
  
	/**
	 * 发放裂变红包
	 * 
	 * @create 2016-11-18
	 * @author zlw
	 */
	public function send_groupredpack($re_openid, $total_amount)
	{
		$mch_billno = $this->wxpay->createMchBillno($this->config['mch_id']);
		
		$send_array = array(
			'mch_billno' 	=> $mch_billno,
			'mch_id' 		=> $this->config['mch_id'],
			'wxappid' 		=> $this->config['weixin_appid'],
			'send_name' 	=> $this->config['send_name'],
			're_openid' 	=> $re_openid,
			'total_amount' 	=> $total_amount,
			'total_num' 	=> $this->config['total_num'],
			'amt_type' 		=> $this->config['amt_type'],
			'wishing' 		=> $this->config['wishing'],
			'act_name' 		=> $this->config['act_name'],
			'remark' 		=> $this->config['remark'],
		);
		
		//设置证书
		$this->set_key();
		
		//提交
		$data = $this->wxpay->send($this->sendredpackUrl, $send_array, $this->config['api_password']);
		
		/**
		成功结果：
		$data = [
			'return_code' => 'SUCCESS', 
			'return_msg' => '发放成功.', 
			'result_code' => 'SUCCESS', 
			'err_code' => '0', 
			'err_code_des' => '发放成功.',
			'mch_billno' => '0010010404201411170000046545', 
			'mch_id' => '10010404', 
			'wxappid' => 'wx6fa7e3bab7e15415', 
			're_openid' => 'onqOjjmM1tad-3ROpncN-yUfa6uI', 
			'total_amount' => '1'
		]
		*/
		
		return $data;
	}
	
	/**
	 * 查询红包
	 * 
	 * @create 2016-11-14
	 * @author zlw
	 */
	public function get_hbinfo($mch_billno)
	{		
		$send_array = array(
			'mch_billno' => $mch_billno,
			'mch_id' => $this->config['mch_id'],
			'appid' => $this->config['weixin_appid'],
			'bill_type' => $this->config['bill_type'],
		);
		
		//设置证书
		$this->set_key();
		
		//提交
		$data = $this->wxpay->send($this->getHbinfoUrl, $send_array, $this->config['api_password']);
		
		/**
		返回成功数据：
		$data = [
			'return_code' => 'SUCCESS', 
			'return_msg' => 'OK', 
			'result_code' => 'SUCCESS', 
			'err_code' => 'SUCCESS', 
			'err_code_des' => 'OK', 
			'mch_billno' => '9010080799701411170000046603', 
			'mch_id' => '11475856', 
			'detail_id' => '10000417012016080830956240040', 
			'status' => 'RECEIVED', 
			'send_type' => 'ACTIVITY', 
			'hb_type' => 'NORMAL', 
			'total_num' => '1', 
			'total_amount' => '100', 
			'send_time' => '2016-08-08 21:49:22', 
			'hblist' => [
				'hbinfo' => [
					'openid' => 'oHkLxtzmyHXX6FW_cAWo_orTSRXs',
					'amount' => '100',
					'rcv_time' => '2016-08-08 21:49:46',
				]
			]
		
		];
		
		返回失败数据：
		$data = [
			'return_code' => 'FAIL', 
			'return_msg' => '指定单号数据不存在', 
			'result_code' => 'FAIL', 
			'err_code' => 'SYSTEMERROR', 
			'err_code_des' => '指定单号数据不存在', 
			'mch_id' => '11475856'
			'mch_billno' => '9010080799701411170000046603', 
		]				
		
		*/
		
		return $data;
	}
	
}
