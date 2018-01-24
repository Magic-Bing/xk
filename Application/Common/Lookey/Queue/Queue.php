<?php

namespace Lookey\Queue;


/**
 * 队列
 *
 * @edit 2016-12-28
 * @author zlw
 */ 
class Queue 
{
	/**
	 * 队列数组
	 *
	 * @edit 2016-12-28
	 * @author zlw
	 */ 
	private $queue = array(); 

	/**
	 * 构造方法
	 * @param array $result 队列数组
	 *
	 * @edit 2016-12-28
	 * @author zlw
	 */ 
	function __construct($result) 
	{ 
		if (is_array($result)) { 
			$this->queue = $result; 
		} 
	} 
	
	/**
	 * 将一个单元单元放入队列末尾
	 * @param mixed $value
	 *
	 * @edit 2016-12-28
	 * @author zlw
	 */ 
	function put($value) 
	{
		$this->queue[] = $value; 

		return $this; 
	} 
 
	/**
	 * 将队列开头的一个或多个单元移出
	 * @param int $num
	 *
	 * @edit 2016-12-28
	 * @author zlw
	 */ 
	function slice($num = 1) 
	{ 
		if (count($this->queue) < $num) { 
			$num = count($this->queue); 
		} 
		$output = array_splice($this->queue, 0, $num); 

		return $output; 
	} 

	/**
	 * 将队列开头的单元移出队列
	 *
	 * @edit 2016-12-28
	 * @author zlw
	 */ 
	function out() 
	{ 
		$entry = array_shift($this->queue); 
		return $entry; 
	} 

	/**
	 * 返回队列长度
	 *
	 * @edit 2016-12-28
	 * @author zlw
	 */ 
	function size() 
	{ 
		return count($this->queue); 
	} 

	/**
	 * 返回队列中的第一个单元
	 *
	 * @edit 2016-12-28
	 * @author zlw
	 */ 
	function peek() 
	{ 
		return $this->queue[0]; 
	} 

	/**
	 * 返回队列中的一个或多个单元
	 * @param int $num
	 *
	 * @edit 2016-12-28
	 * @author zlw
	 */ 
	function peeks($num) 
	{ 
		if (count($this->queue) < $num) { 
			$num = count($this->queue); 
		} 
		return array_slice($this->queue, 0, $num); 
	} 

	/**
	 * 消毁队列
	 *
	 * @edit 2016-12-28
	 * @author zlw
	 */ 
	function destroy() 
	{ 
		$this->queue = array(); 
	} 
}
