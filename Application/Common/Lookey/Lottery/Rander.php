<?php

namespace Lookey\Lottery;


/**
 * 彩票抽奖
 *
 * @create 2016-9-19
 * @author zlw
 */
class Rander 
{
	
	/**
	 * 抽奖 - 内置
	 *
	 * 	$prize_arr = array( 
	 * 		'0' => array('id' => 1, 'title' => 'iphone5s', 'v' => 5), 
     * 		'1' => array('id' => 2, 'title' => '联系笔记本', 'v' => 10), 
     * 		'2' => array('id' => 3, 'title' => '音箱设备', 'v' => 20), 
     * 		'3' => array('id' => 4, 'title' => '30GU盘', 'v' => 30), 
     * 		'4' => array('id' => 5, 'title' => '话费50元', 'v' => 10), 
     * 		'5' => array('id' => 6, 'title' => 'iphone6s', 'v' => 15), 
     * 		'6' => array('id' => 7, 'title' => '谢谢，继续加油哦！~', 'v' => 10), 
	 * 	); 
	 *
	 * @create 2016-9-19
	 * @author zlw
	 */
    public static function roll(
		array $prize_arr = array(),
		$probability = 'v'
	) {
		//如果中奖数据是放在数据库里，这里就需要进行判断中奖数量
		//在中1、2、3等奖的，如果达到最大数量的则unset相应的奖项，避免重复中大奖
		//code here eg:unset($prize_arr['0'])
		foreach ($prize_arr as $key => $val) { 
			$arr[$key] = $val[$probability]; 
		} 

		//根据概率获取奖项id
		$rid = self::getRand($arr); 

		//中奖项
		$res['yes'] = $prize_arr[$rid];
		
		//将中奖项从数组中剔除，剩下未中奖项，如果是数据库验证，这里可以省掉
		unset($prize_arr[$rid]);

		//打乱数组顺序
		shuffle($prize_arr); 
		
		//获取未中奖信息
		if (!empty($prize_arr)) {
			for($i = 0; $i < count($prize_arr); $i ++) { 
				$pr[] = $prize_arr[$i]; 
			} 
		} else {
			$pr = array();
		}
		$res['no'] = $pr; 
		
		return $res;
    } 

	/**
	 * 获取抽奖概率
	 *
	 * @create 2016-9-19
	 * @author zlw
	 */
	public static function getRand($proArr) 
	{ 
		$result = ''; 

		//概率数组的总概率精度
		$proSum = array_sum($proArr); 

		//概率数组循环
		foreach ($proArr as $key => $proCur) { 
			$randNum = mt_rand(1, $proSum); 
			if ($randNum <= $proCur) { 
				$result = $key; 
				break; 
			} else { 
				$proSum -= $proCur; 
			} 
		} 
		unset ($proArr); 

		return $result; 
	}
	
}
