<?php

namespace User\Controller;

use Lookey\Wxpay\Packet as WxPacket;
use Org\Util\String as Stringer;


/**
 * 奖励
 *
 * @create 2016-11-11
 * @author zlw
 */
class RewardController extends BaseController
{
	
	/**
	 * 构造方法
	 *
	 * @create 2016-11-11
	 * @author zlw
	 */
	public function _initialize()
	{
		parent::_initialize();
	}
	
	/**
	 * 首页
	 *
	 * @create 2016-11-11
	 * @author zlw
	 */
    public function index()
	{		
		if (IS_AJAX) {
			$code = I("code", '', 'trim');
			if (empty($code)) {
				$this->error("发生错误，请重试！");
			}
			
			$RewardMoney = D("RewardMoney");
			$RewardLog = D("RewardLog");

			//当前用户
			$customer_id = $this->get_customer_id();

			//条件
			$where['customer_id'] = $customer_id ;		
			$where['code'] = $code ;		
			$customer_reward = $RewardMoney->getOne($where);
			
			if (empty($customer_reward)) {
				$this->error("你还没有奖励金额！");
			}
			
			//金额
			$money = $customer_reward['reward'] - $customer_reward['use_reward'];
			
			if ($money <= 0) {
				$this->error("你没有金额可提取！");
			}
			
			//发送红包消息
			//$packet = $this->send_packet($customer_reward['project_id'], $customer_reward['wxopenid'], $money);
			
			//测试
			$packet = $this->send_packet($customer_reward['project_id'], 'oMXErxN3q2oarQWIftHFpd9no4pk', $money);
			
			if (empty($packet) || !is_array($packet) || $packet['return_code'] != 'SUCCESS') {				
				$this->error("提取奖励失败，请稍后重试！");
			} else {
				//更改提取金额为全部提取
				$use_reward_where['customer_id'] = $customer_id;
				$use_reward_where['code'] = $code;		
				$use_reward_data['use_reward'] = $customer_reward['reward'];		
				$RewardMoney->editOne($use_reward_where, $use_reward_data);
				
				//提现记录
				$rewardLogData['customer_id'] = $customer_id;
				$rewardLogData['reward_customer_id'] = 0;
				$rewardLogData['project_id'] = $customer_reward['project_id'];
				$rewardLogData['reward'] = $money;
				$rewardLogData['action'] = 2;
				$rewardLogData['add_time'] = time();
				$rewardLogData['add_ip'] = get_client_ip(0, true);
				$rewardLogCheckHasAdd = $RewardLog->addOne($rewardLogData);
				
				$this->success("提取奖励成功！");
			}
		} else {
			$project_id = I("project_id", 0, 'intval');
			if ($project_id == 0) {
				$this->error('项目错误，请重试！');
			}
			
			$RewardMoney = D("RewardMoney");
			$Project = D("Project");
			
			//项目
			$project = $Project->getOneById($project_id);
			if (empty($project)) {
				$this->error("项目不存在，请确认后重试！");
			}
			$this->assign('project', $project);
			
			//当前用户
			$customer_id = $this->get_customer_id();

			//用户奖励
			$customerReward = $RewardMoney->getOneByCustomerIdAndProjectId($customer_id, $project_id);
			$this->assign('customerReward', $customerReward);
			
			//提取所需验证码
			if (time() > $customerReward['code_time'] + 10*60) {
				$data['code'] = Stringer::randString(6);
				$data['code_time'] = time();
				$where['project_id']  = $project_id;
				$where['customer_id'] = $customer_id;
				$RewardMoney->editOne($where, $data);
				
				$code = $data['code'];
			} else {
				$code = $customerReward['code'];
			}
			
			$this->assign('code', $code);
			
			$this->set_seo_title('提现详情');
			$this->display();
		}
    }
	
	/**
	 * 发送红包
	 *
	 * @create 2016-11-11
	 * @author zlw
	 */
	protected function send_packet($project_id, $customer_wxopenid, $money)
	{
		$ProjectView = D('ProjectView');
		
		//项目信息
		$project = $ProjectView->getOneById($project_id);
		if (empty($project)) {
			return false;
		}

		$key_path = C("WX.CREDENTIALS_PATH");
		
		$public_key = getcwd().str_replace('/', DIRECTORY_SEPARATOR, $key_path.$project['public_key']);
		$private_key = getcwd().str_replace('/', DIRECTORY_SEPARATOR, $key_path.$project['private_key']);
		$rootca = getcwd().str_replace('/', DIRECTORY_SEPARATOR, $key_path.$project['rootca']);
		
		//配置
		$config = array(
			//'weixin_appid' => $project['app_id'], //公众账号appid
			//测试
			'weixin_appid' => 'wxbc7a646af858aa25',//及食公众号,用于测试
			
			'mch_id' => $project['mch_id'], //商户号
			'send_name' => $project['name'], //商户名称
			'wishing' => $project['wishing'], //红包祝福语
			'act_name' => $project['act_name'], //活动名称
			'remark' => $project['remark'], //备注
			'api_password' => $project['api_password'], //密钥
			
			//密钥设置路径：微信商户平台(pay.weixin.qq.com)-->账户设置-->API安全-->密钥设置
			
			'public_key' => $public_key, //证书pem格式
			'private_key' => $private_key, //证书密钥pem格式
			'rootca' => $rootca, //CA证书
		);
		
		//设置配置
		$WxPacket = new WxPacket();
		$WxPacket->set_config($config);
		
		$re_openid = $customer_wxopenid;
		$total_amount = $money*100;
		
		//发送红包
		$data = $WxPacket->send_redpacket($re_openid, $total_amount);
		if (!is_array($data)) {
			add_weixin_log('[SEND_PACKET:CURL]'.$data, 'Weixin');
		} elseif ($data['return_code'] != 'SUCCESS') {
			//记录错误日志
			add_weixin_log('[SEND_PACKET:RETURN_MSG]'.$packet['return_msg'], 'Weixin');
		} elseif ($data['result_code'] != 'SUCCESS') {
			//记录错误日志
			add_weixin_log('[SEND_PACKET:ERR_CODE_DES]'.$packet['err_code_des'], 'Weixin');
		} elseif (empty($data)) {
			add_weixin_log('[SEND_PACKET:EMPTY]weixin return empty!', 'Weixin');
		}

		
		return $data;
	}
	
	/**
	 * 奖励详情
	 *
	 * @create 2016-11-11
	 * @author zlw
	 */
    public function info()
	{
		$project_id = I("project_id", 0, 'intval');
		if (empty($project_id) || $project_id == 0) {
			$this->error("项目不存在，请确认后重试！");
		}
		
		//类型
		$type = I('type', '', 'trim');
		if (!empty($type)) {
			if (strtolower($type) == 'use') {
				$where['action'] = 2;
				$type = 'use';
			} elseif (strtolower($type) == 'get') {
				$where['action'] = 1;
				$type = 'get';
			} else {
				$type = '';
			}
		}
		$this->assign('type', $type);
		
		$RewardMoney = D("RewardMoney");
		$RewardLog = D("RewardLog");
		$Project = D("Project");
		$Customer = D("Customer");
	
		//项目
		$project = $Project->getOneById($project_id);
		if (empty($project)) {
			$this->error("项目不存在，请确认后重试！");
		}
		$this->assign('project', $project);

		//当前用户
		$customer_id = $this->get_customer_id();

		//条件
		$where['customer_id'] = $customer_id;		
		$where['project_id'] = $project_id;		
		$where['status'] = 1;		
		
		//活动总数
		$count = $RewardLog->where($where)->count();
	
		//分页
		$Page 		= $this->mpage($count, 5);
		$page_show  = $Page->show();	
		$this->assign('page_show', $page_show); 

		//取范围
		$limit = $Page->firstRow.','.$Page->listRows;
		
		//奖励日志
		$customer_reward_log = $RewardLog->getList($where, '*', 'add_time DESC', $limit);
		$this->assign('customer_reward_log', $customer_reward_log);
		
		//用户ID列表
		$customer_ids = array();
		if (!empty($customer_reward_log)) {
			foreach ($customer_reward_log as $customer_reward_log_key => $customer_reward_log_value) {
				$customer_ids[$customer_reward_log_value['reward_customer_id']] = $customer_reward_log_value['reward_customer_id'];
			}
		}
		
		//用户列表
		$customers = array();
		if (!empty($customer_ids)) {
			unset($where);
			$where['id'] = array('in', $customer_ids);
			$customers = $Customer->getList($where);
			
			foreach ($customers as $customers_value) {
				$customers[$customers_value['id']] = $customers_value;
			}
		}
		$this->assign('customers', $customers);

		//用户奖励
		$customerReward = $RewardMoney->getOneByCustomerIdAndProjectId($customer_id, $project_id);
		$this->assign('customerReward', $customerReward);
		
		$this->set_seo_title('提取奖励');
		$this->display();
    }
	
	
}

