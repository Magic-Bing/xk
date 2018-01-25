<?php

namespace User\Controller;


/**
 * 奖品
 *
 * @create 2016-9-20
 * @author zlw
 */
class PrizesController extends BaseController
{
	
	/**
	 * 默认页
	 *
	 * @create 2016-9-20
	 * @author zlw
	 */
    public function index()
	{
		$this->error('方法不存在！', U('user/index'));
    }
	
	/**
	 * 获取奖品
	 *
	 * @create 2016-9-20
	 * @author zlw
	 */
    public function lottery()
	{
		/*
		if (!IS_AJAX) {
			$this->error('访问错误！', U('user/index'));
		}
		
		ob_start();  
		$prize = $this->get_prizes_lottery();
		$content = ob_get_contents();  
		ob_end_clean(); 
		
		if (!empty($content)) {
			$this->success($content, U('user/index'));
		}
		*/
    }
	
}
