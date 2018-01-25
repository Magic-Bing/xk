<?php

namespace Lookey\Lottery;


/**
 * 彩票抽奖
 *
 * @create 2016-9-19
 * @author zlw
 */
class Lottery 
{

	protected static $awardsArr;
	
    protected static $proField = 'probability';
	
    protected static $proSum = 0;
	
    protected static $checkAward = false;
	
    const SUCCESS_CODE = 0;
	
    const FAIL_CODE = -1;
	
	/**
	 * 改变概率字段名
	 *
	 * @create 2016-9-19
	 * @author zlw
	 */
    public static function setProField($field = null) 
	{
        if (!empty($field)) {
            self::$proField = $field;
        }
    }
	
	/**
	 * 设置奖品
	 *
	 * @create 2016-9-19
	 * @author zlw
	 */
    public static function setAwards($awards)
	{
        self::$awardsArr = $awards;
        self::checkAwards();
    }
	
	/**
	 * 抽奖
	 *
	 * @create 2016-9-19
	 * @author zlw
	 */
    public static function roll() 
	{
        if (false == self::$checkAward) {
            return self::failRoll('奖品不是一个正确的格式!');
        }
		
        $result = mt_rand(0, self::$proSum);
        $proValue = 0;
        foreach (self::$awardsArr as $_key => $value) {
            $proValue += $value[self::$proField]; 
            if ($result <= $proValue) {
                return self::successRoll($_key);
            }
        }
		
        return self::failRoll('错误！');
    } 
	
	/**
	 * 检查抽奖数据
	 *
	 * @create 2016-9-19
	 * @author zlw
	 */
    protected static function checkAwards()
	{
        if (!is_array(self::$awardsArr) || empty(self::$awardsArr)) {
            return self::$checkAward = false;
        }
		
        self::$proSum = 0;
        foreach (self::$awardsArr as $_key => $award) {
            self::$proSum += $award[self::$proField];
        }
		
        if (empty(self::$proSum)) {
            return self::$checkAward = false;
        }
		
        return self::$checkAward = true;
    }
	
	/**
	 * 抽奖成功
	 *
	 * @create 2016-9-19
	 * @author zlw
	 */
    protected static function successRoll($rollKey)
	{
        return array(
			'code' => self::SUCCESS_CODE, 
			'roll_key' => $rollKey, 
			'msg' => '抽奖成功！'
		);
    }
	
	/**
	 * 抽奖失败
	 *
	 * @create 2016-9-19
	 * @author zlw
	 */
    protected static function failRoll($msg = '抽奖失败！')
	{
        return array(
			'code' => self::FAIL_CODE, 
			'msg' => $msg 
		);
    }
	
}
