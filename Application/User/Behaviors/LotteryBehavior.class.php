<?php

namespace User\Behaviors;

use \Think\Behavior as Behavior;


/**
 * 中奖行为扩展
 *
 * @create 2016-9-21
 * @author zlw
 */
class LotteryBehavior extends Behavior
{
	
	/**
	 * 行为执行入口
	 *
	 * @create 2016-9-21
	 * @author zlw
	 */
    public function run(&$param)
	{
		if (IS_AJAX) {
			return false;
		}
		
		$name = strtolower(CONTROLLER_NAME.".".ACTION_NAME);
		
		$allow_actions = C('LOTTERY.ACTIONS');
		$show_actions = C('LOTTERY.SHOW_ACTIONS');
		
		if (in_array($name, $allow_actions)) {
			$data = array();
			\R('Prizes\show_lottery', $data, 'Service');
		} elseif (in_array($name, $show_actions) 
			&& !in_array($name, $allow_actions)
		) {
			$data = array();
			\R('Prizes\show_user_prizes', $data, 'Service');
		}
    }
	
}








