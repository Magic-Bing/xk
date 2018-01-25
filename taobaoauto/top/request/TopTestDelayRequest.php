<?php
/**
 * TOP API: taobao.top.test.delay request
 * 
 * @author auto create
 * @since 1.0, 2014.11.04
 */
class TopTestDelayRequest
{
	/** 
	 * 系统自动生成
	 **/
	private $sleepTime;
	
	private $apiParas = array();
	
	public function setSleepTime($sleepTime)
	{
		$this->sleepTime = $sleepTime;
		$this->apiParas["sleep_time"] = $sleepTime;
	}

	public function getSleepTime()
	{
		return $this->sleepTime;
	}

	public function getApiMethodName()
	{
		return "taobao.top.test.delay";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
