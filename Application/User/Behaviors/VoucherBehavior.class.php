<?php

namespace User\Behaviors;

use \Think\Behavior as Behavior;


/**
 * 代金券行为扩展
 *
 * @create 2016-12-06
 * @author zlw
 */
class VoucherBehavior extends Behavior
{
	
	/**
	 * 行为执行入口
	 *
	 * @create 2016-12-06
	 * @author zlw
	 */
    public function run(&$param)
	{
		if (IS_AJAX) {
			return false;
		}
		
		$name = strtolower(CONTROLLER_NAME.".".ACTION_NAME);
		
		$tip_actions = C('VOUCHER.TIPS');
		$gift_actions = C('VOUCHER.GIFTS');
		
		//提示
		if (in_array($name, $tip_actions)) {
			$data = array();
			\R('Voucher\tip', $data, 'Service');
		}
		
		//随机获取奖励
		if (in_array($name, $gift_actions)) {
			$data = array();
			\R('Voucher\gift', $data, 'Service');
		}
		
    }
	
}








