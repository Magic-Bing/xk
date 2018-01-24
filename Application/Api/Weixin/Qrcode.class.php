<?php

namespace Api\Weixin;

use Think\Log as Loger;
use Lookey\Wxsdk\Qrcode as WxQrcode;
use Lookey\Wxsdk\Message as WxMessage;
use Lookey\Wxsdk\Jssdk as WxJssdk;
use Lookey\Wxsdk\Error as WxError;


/**
 * 二维码
 *
 * @create 2016-11-16
 * @author zlw
 */
class Qrcode
{
	
	/**
	 * 获取微信配置信息 - APP_ID和APP_SECRET
	 *
	 * @create 2016-11-8
	 * @author zlw
	 */
	protected function get_weixin_config($project_id)
	{
		$weixin = D('Weixin', 'Logic')->getAppidAndAppsecret($project_id);
		if (empty($weixin)) {
			return array(
				'appID' => '',
				'appSecret' => '',
			);
		}

		$appID = $weixin['app_id'];
		$appSecret = $weixin['app_secret'];

		return array(
			'appID' => $appID,
			'appSecret' => $appSecret,
		);
	}	
	
	/**
	 * 二维码关注反馈
	 *
	 * @create 2016-11-7
	 * @author zlw
	 */
    public function wxcallback_after(&$param)
	{
		$RewardUsers = D("RewardUsers");
		$RewardLog = D("RewardLog");
		$RewardOption = D("RewardOption");
		$Customer = D("Customer");
		$RewardMoney = D("RewardMoney");
		
        //1、获取反馈信息【获取当前用户openid和自定义识别码】
		
		$WxQrcode = new WxQrcode();
		$qrcodeInfo = $WxQrcode->getEvent();
		
		/*
		$qrcodeInfo = array(
			'fromUsername' => 'omBI_xBvCUj3FNzcGk54Xs9CHPws',
			'value' => '2147483647',
			'isFollow' => false,
		);
		*/
		
		//微信端数据
		$openid = $qrcodeInfo['fromUsername'];
		$code = $qrcodeInfo['value'];
		$isFollow = $qrcodeInfo['isFollow'];
		
		$rewardUser = $RewardUsers->getOne(array('code' => $code));
		
		//上级用户为空，直接返回
		if (empty($rewardUser)) {
			return ;
		}
		
		$parent_customer_id = $rewardUser['customer_id'];
		$project_id = $rewardUser['project_id'];
		
		/**============== 发送信息设置 - 开始 ===================**/
		
		//发送信息
		$WxMessage = new WxMessage();
		
		//微信配置信息
		$appCconfig = $this->get_weixin_config($project_id);
		
		//配置信息
		$appID = $appCconfig['appID'];
		$appSecret = $appCconfig['appSecret'];

		//获取access_token
		$WxJssdk = new WxJssdk($appID, $appSecret);
		$WxJssdk->setPath(RUNTIME_PATH . 'Weixin/');
		$accessToken = $WxJssdk->getAccessToken();
		
		$WxMessage->setAccessToken($accessToken);
		
		/**============== 发送信息设置 - 结束 ===================**/
		
		//没有关注，添加信息
		if ($isFollow === false) {
			
			//获取设置信息
			$optionWhere['project_id'] = $project_id;
			$optionWhere['status'] = 1;
			$rewardOption = $RewardOption->getOne($optionWhere);
		
			$option_end_time = $rewardOption['end_time'];
			if ($option_end_time < time()) {
				return false;
			}
			
			//当前用户登录信息
			$customer = $Customer->getOneByOpenId($openid);
                        //为空时，应该直接先保存到数据库中
			
			//当前用户ID
			$customer_id = $customer['id'];
			
			$rewardUsersWhere['customer_id'] = $customer_id;
			$rewardUsersWhere['project_id'] = $project_id;
			$rewardUserInfo = $RewardUsers->getOne($rewardUsersWhere);
			
			if (empty($rewardUserInfo)) {
				//记录关注信息
				$data['pid'] = $parent_customer_id;
				$data['customer_id'] = $customer_id;
				$data['project_id'] = $project_id;
				$data['add_time'] = time();
				$data['add_ip'] = get_client_ip(0, true);
				
				$checkHasAdd = $RewardUsers->addOne($data);
			} else {
				//更改关注信息
				$data['pid'] = $parent_customer_id;
				
				$where['customer_id'] = $customer_id;

				$checkHasEdit = $RewardUsers->editOne($where, $data);
			}
			
			/**===================== 记录奖励信息 =========================**/
		
			$rewardLogWhere['customer_id'] = $customer_id;
			$rewardLogWhere['reward_customer_id'] = 0;
			$rewardLogWhere['project_id'] = $project_id;
			$nowCustomerLog = $RewardLog->getOne($rewardLogWhere);
	
			//关注自己的二维码不添加奖励
			if (empty($nowCustomerLog)) {
				//记录一级奖励信息
				$rewardLogData['customer_id'] = $customer_id;
				$rewardLogData['reward_customer_id'] = 0;
				$rewardLogData['project_id'] = $project_id;
				$rewardLogData['reward'] = $rewardOption['one_reward'];
				$rewardLogData['add_time'] = time();
				$rewardLogData['add_ip'] = get_client_ip(0, true);
				
				$rewardLogCheckHasAdd = $RewardLog->addOne($rewardLogData);
			
				//添加关注奖励
				$RewardMoney->addCustomerReward($customer_id, $project_id, $rewardOption['one_reward'], $openid);
		
				////记录二级奖励信息
				if (isset($parent_customer_id) 
					&& $parent_customer_id != 0
					&& $parent_customer_id != $customer_id
				) {
					$rewardLog2Data['customer_id'] = $parent_customer_id;
					$rewardLog2Data['reward_customer_id'] = $customer_id;
					$rewardLog2Data['project_id'] = $project_id;
					$rewardLog2Data['reward'] = $rewardOption['two_reward'];
					$rewardLog2Data['add_time'] = time();
					$rewardLog2Data['add_ip'] = get_client_ip(0, true);
					
					$rewardLog2CheckHasAdd = $RewardLog->addOne($rewardLog2Data);
				
					//添加关注奖励
					$RewardMoney->addCustomerReward($parent_customer_id, $project_id, $rewardOption['two_reward']);
				
					//判断奖励是否符合发红信息
					$customerReward2 = $RewardMoney->getOneByCustomerIdAndProjectId($parent_customer_id, $project_id);
					$customerReward2Money = ($customerReward2['reward'] - $customerReward2['use_reward']) + $rewardOption['two_reward'];
					if ($customerReward2Money >= $rewardOption['lowest_cash'] 
						&& $customerReward2['is_notice'] != 1
					) {					
						//发送通知
						$this->send_notice($WxMessage, $customerReward2['wxopenid'], $parent_customer_id, $project_id, $customerReward2Money);
					}
				
					//记录三级奖励信息
					$rewardUser2 = $RewardUsers->getOne(array('customer_id' => $parent_customer_id));
					if (isset($rewardUser2['pid']) 
						&& $rewardUser2['pid'] != 0
						&& $rewardUser2['pid'] != $parent_customer_id
					) {
						$rewardLog3Data['customer_id'] = $rewardUser2['pid'];
						$rewardLog3Data['reward_customer_id'] = $parent_customer_id;
						$rewardLog3Data['project_id'] = $project_id;
						$rewardLog3Data['reward'] = $rewardOption['three_reward'];
						$rewardLog3Data['add_time'] = time();
						$rewardLog3Data['add_ip'] = get_client_ip(0, true);
						
						$rewardLog3CheckHasAdd = $RewardLog->addOne($rewardLog3Data);
				
						//添加关注奖励
						$RewardMoney->addCustomerReward($rewardUser2['pid'], $project_id, $rewardOption['three_reward']);
				
						//判断奖励是否符合发红信息
						$customerReward3 = $RewardMoney->getOneByCustomerIdAndProjectId($rewardUser2['pid'], $project_id);
						$customerReward3Money = ($customerReward3['reward'] - $customerReward3['use_reward']) + $rewardOption['three_reward'];
						if ($customerReward3Money >= $rewardOption['lowest_cash'] 
							&& $customerReward3['is_notice'] != 1
						) {
							//发送通知
							$this->send_notice($WxMessage, $customerReward3['wxopenid'], $customerReward3['customer_id'], $project_id, $customerReward3Money);
						}
					}
				}
			
			}
		
		}
		
		//2、发送图文信息
		$Project = D("Project");
		$project = $Project->getProjectById($project_id);
		
		$description = '欢迎选购['.$project['name'].']楼盘！很高兴为你服务！\n';
		$description .= '项目：'.$project['name'].'\n';
		$description .= '地址：'.$project['address'].'\n';
		$description .= '电话：'.$project['mobile'].'\n';
		$description .= '点击查看详情！';
		
		//提交的数据
		$projectData = array(
			array(
				'title' => $project['name'],
				'description' => $description,
				'picurl' => '',
				'url' => U('user/index/index', array(
					'info' => 'p'.$project_id
				), '', true, true),
			),
		);
		
		$sendNewsStatus = $WxMessage->sendNews($openid, $projectData);
		if ($sendNewsStatus === false) {
			$errId = $WxMessage->getErrId();
			$errMsg = WxError::getErrorInfo($errId);
			
			//记录错误日志
			add_weixin_log('[SEND_NEWS]'.$errMsg, 'Weixin');
			//错误：[45015]回复时间超过限制【解决方案：微信回复公众号】
		}
    }	
	
	/**
	 * 发送通知
	 *
	 * @create 2016-11-15
	 * @author zlw
	 */
	protected function send_notice($WxMessage, $to_openid, $customer_id, $project_id, $money) 
	{
		$RewardMoney = D("RewardMoney");

		//奖励详情链接
		$reward_url = U('user/reward/index', array('project_id' => $project_id), '', 'html', true);
		
		//发送可提现提示
		$msgStr = "你有奖励可提现，请注意查收。当前奖励金额：\n";
		$msgStr .= $money . '元\n';
		$msgStr .= '<a href=\''.trim($reward_url).'\'>马上提取奖励</a>';
		
		$sendMessageStatus = $WxMessage->sendMsg($to_openid, $msgStr);
		if ($sendMessageStatus === false) {
			$errId = $WxMessage->getErrId();
			$errMsg = WxError::getErrorInfo($errId);
			
			//记录错误日志
			add_weixin_log('[SEND_MSG]'.$errMsg, 'Weixin');
		} else {
			//发送成功，更改为已通知
			$RewardMoney->editCustomerRewardNotice($customer_id, $project_id, 1);
		}
	}
	
	/**
	 * 发送微信信息
	 *
	 * @create 2016-11-21
	 * @author zlw
	 */
	protected function send_msg($WxMessage, $to_openid, $msgStr) 
	{		
		$WxMessage->sendMsg($to_openid, $msgStr);
	}
    
    
}


