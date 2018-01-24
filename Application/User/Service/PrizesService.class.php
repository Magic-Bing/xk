<?php

namespace User\Service;

use User\Controller\BaseController as UserBaseController;


/**
 * 奖品
 *
 * @create 2016-9-23
 * @author zlw
 */
class PrizesService extends UserBaseController
{
	
	/**
	 * 获取奖品
	 *
	 * @create 2016-9-23
	 * @author zlw
	 */
    public function show_lottery($prizes = array())
	{
		$this->get_prizes_lottery($prizes);
    }
	
	
	/**
	 * 显示用户所得的奖品
	 *
	 * @create 2016-9-26
	 * @author zlw
	 */
    public function show_user_prizes($prizes = array())
	{
		$this->get_user_prizes($prizes);
    }
	
}
