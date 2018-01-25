<?php

namespace User\Controller;

use Lookey\Wxsdk\Auth as Weixin;
use Lookey\Wxsdk\Jssdk as Jssdk;
use Lookey\Lottery\Rander as Lottery;

use Common\Controller\BaseController as CommonBaseController;


/**
 * 基础控制器
 *
 * @create 2016-8-18
 * @author zlw
 */
class BaseController extends CommonBaseController 
{
	/**
	 * 构造方法
	 *
	 * @create 2016-9-6
	 * @author zlw
	 */
	public function _initialize()
	{
		parent::_initialize();
		
		//微信登录检测
		$this->wx_login();
	}
  
	/**
	 * 空方法
	 *
	 * @create 2016-9-6
	 * @author zlw
	 */
	public function _empty()
	{
		$this->error('方法不存在！', U('index/index'));
    }

    /**
     * 获取备选房源数量
     *
     * @create 2016-9-6
     * @author zlw
     */
    public function get_bx_count($pid){
        $uid=session(user_id);
        if(!$uid){
            $uid=cookie('user_id');
        }
        return M()->table("xk_cst2rooms")->where("proj_id=$pid AND cst_id=$uid")->count();
    }

	
	/**
	 * 判断是否登录
	 *
	 * @create 2016-9-6
	 * @author zlw
	 */
	protected function is_login() 
	{
		$user_id = $this->get_customer_id();
		
		if (empty($user_id)) {
			return false;
		} else {
			return true;
		}
	}
	
	/**
	 * 获取客户ID
	 *
	 * @create 2016-9-6
	 * @author zlw
	 */
	protected function get_customer_id() 
	{
		$user_id = session('user_id');
		if (empty($user_id)) {
			$user_id = cookie('user_id');
			if (!empty($user_id)) {
				session('user_id', $user_id);
			} else {
				return null;
			}
		}
		
		return $user_id;
	}
	
	/**
	 * 加密和解密
	 *
	 * @create 2016-9-13
	 * @author zlw
	 */
	protected function crypt($string, $type = 'encode')
	{
		//加密密钥
		$key = C("WX.KEY").MD5('5e7ws');
		
		if (strtolower($type) == 'decode') {
			//解密
			$code_string = think_decrypt($string, $key);
		} else {
			//加密
			$code_string = think_encrypt($string, $key);
		}	
		
		return $code_string;
	}
	
	/**
	 * 微信登录 - 提示 
	 *
	 * @create 2016-10-8
	 * @author zlw
	 */
	protected function wx_login_tip(
		$content = "请在微信客户端打开链接",
		$title = "微信登录提示",
		$keyword = "微信登录提示",
		$description = "微信登录提示"
	) {
		$this->assign('content', $content);
		
		$this->set_seo_title($title);
		$this->set_seo_keywords($keyword);
		$this->set_seo_description($description);
		
		echo $this->fetch('common/open_weixin_tip');
		
		exit();
	}
	
	/**
	 * 判断浏览器信息
	 *
	 * @create 2016-10-26
	 * @author zlw
	 */
	protected function check_user_agent()
	{
		//判断是否为微信浏览器
		if ( !strpos($_SERVER["HTTP_USER_AGENT"], 'MicroMessenger') ) { 
			$this->wx_login_tip("请在微信客户端打开链接");
		}
	}	
	
	/**
	 * 获取微信配置信息 - APP_ID和APP_SECRET
	 *
	 * @create 2016-11-8
	 * @author zlw
	 */
	protected function get_weixin_config()
	{
		
		$appID = C('WX.APP_ID');
		$appSecret = C('WX.APP_SECRET');
		
		/*
		$weixin = D('Weixin', 'Logic')->getAppidAndAppsecret();
		if (empty($weixin)) {
			$this->wx_login_tip('访问错误，请扫描或者公众号登录！');
		}

		$appID = $weixin['app_id'];
		$appSecret = $weixin['app_secret'];
                */
		return array(
			'appID' => $appID,
			'appSecret' => $appSecret,
		);
	}	
	
	/**
	 * 微信登录 - 静默登录
	 *
	 * @create 2016-9-12
	 * @author zlw
	 */
	protected function wx_login() 
	{
		//$this->check_user_agent();
		
		//微信配置
		$app_config = $this->get_weixin_config();
		
		$appID = $app_config['appID'];
		$appSecret = $app_config['appSecret'];
	
		$Weixin = new Weixin($appID, $appSecret);
		$Jssdk = new Jssdk($appID, $appSecret);
		$Jssdk->setPath(RUNTIME_PATH . 'Weixin/');

		$access_token = array();

		//测试用户
		cookie('user_id', 6, 86400);
		
		$user_id  = cookie('user_id');  
		if (empty($user_id)) {
			$code 	= I('code', '', 'trim'); 
			$state 	= I('state', '', 'trim');
			
			if (empty($code)) {
				$url = \get_url();
				$Weixin->getCode($url, 'snsapi_base', $state); 
			} else {
				$access_token = $Weixin->getAccessToken($code); 
			}
			
			if (!isset($access_token['access_token'])) {
				$this->wx_login_tip('获取TOKEN失败请返回微信重新验证');
			}

			//微信openid
			$wxopenid = $access_token['openid'];

			//加密微信OPENID
			$crypt_wxopenid = $this->crypt($wxopenid, 'encode');
			cookie('wxopenid', $crypt_wxopenid, 96400);	
			
			//#************** 用户信息 *******************#//
			
			//判断用户信息
			if (isset($access_token['access_token'])) {
				//微信用户信息
				$wx_user_info = $Jssdk->getUserInfo($wxopenid);
				if (!isset($wx_user_info['openid'])) {
					$this->wx_login_tip('用户验证失败请返回微信重新进入');
				}
				
				if (!isset($wx_user_info['nickname'])) {
					$wx_user_info['nickname'] = '微信用户';
					$wx_user_info['sex'] = 1;
				}

				$Customer = D('Common/Customer');	
			
				//数据库获取微信用户
				$user_info = $Customer->getOneByOpenId($wxopenid);
			
				if ($wx_user_info['nickname'] == $user_info['name']) {
					$name_key = $Customer->getCountByLikeName($wx_user_info['nickname']);
					$nickname = $wx_user_info['nickname'] . $name_key;
				} else {
					$nickname = $wx_user_info['nickname'];
				}
				
				if (empty($user_info)) { //用户没有访问过
					$user_data['name'] 		= $nickname;
					$user_data['sex'] 		= $wx_user_info['sex'];
					$user_data['openid'] 	= $wxopenid;
					
					$user_data['mobile'] 	 = '';
					$user_data['expires_in'] = time();
					
					if (!empty($access_token)) {
						$user_data['access_token'] 	= $access_token['access_token'];
						$user_data['expires_in'] 	= $access_token['expires_in'] + time();
						$user_data['refresh_token'] = $access_token['refresh_token']; 
					}
					
					$user_data['appid'] 	 = $appID; 
					$user_data['login_time'] = time(); 
					$user_data['login_ip'] 	 = get_client_ip(0, true); 
					
					$user_id = $Customer->addOne($user_data);
				} else {
					//未登录15天后更新用户姓名和性别
					if ($user_data['login_time'] + 15*24*60*60  < time()) {
						$user_data['name'] 		= $nickname;
						$user_data['sex'] 		= $wx_user_info['sex'];
					}
					
					$user_data['expires_in'] = time();
				
					//超时需要刷新令牌
					$checktime = isset($user_info['expires_in']) ? intval($user_info['expires_in']) : 0;
					if ($checktime  < time() 
						&& !empty($user_info['refresh_token'])
					) {
						$refresh_token = $Weixin->refreshToken($user_info['refresh_token']);
						
						$user_data['access_token'] 	= $refresh_token['access_token'];
						$user_data['expires_in'] 	= $refresh_token['expires_in'] + time();
						$user_data['refresh_token'] = $refresh_token['refresh_token']; 
					}
					
					$user_data['login_time'] = time(); 
					$user_data['login_ip'] 	 = get_client_ip(0, true); 
					
					$user_where['openid'] 	 = $wxopenid; 
					
					$Customer->editOne($user_data, $user_where);
					
					$user_id = $user_info['id'];
				}
				
				cookie('user_id', $user_id, 86400);
			}
		
		}
	}
	
	/**
	 * 微信登录 - 获取微信OPEN_ID
	 *
	 * @create 2016-10-10
	 * @author zlw
	 */
	protected function get_wx_open_id() 
	{
            $wxopenid  = cookie('wxopenid');  
            if (!empty($wxopenid)) {
                    //解密信息
                    $wxopenid = $this->crypt($wxopenid, 'decode');
                    return $wxopenid;
            } else {
                    $user_id = cookie('user_id');
                    $customer = D('Common/Customer')->getOneById($user_id);

                    if (isset($customer['openid'])) {
                            return $customer['openid'];
                    }
            }

            return false;
	}
	
	//计算房间热力指数得分(5为满分)
	public function roomrlzs($room_attribute,$project_id) 
	{
		$Model = new \Think\Model();
		$zgs=$Model->query("select sum(djcount)/count(1) as zdj,sum(sscount)/count(1) as zss,sum(sccount)/count(1) as zsc from xk_roomattribute a left join xk_roomlist b on a.room_id=b.id where b.proj_id='".$project_id ."' and b.is_dq=1 and 66=66");
		$djcount=$room_attribute['djcount'];
		$sscount=$room_attribute['sscount'];
		$sccount=$room_attribute['sccount'];
		
		$zdjcount=$zgs[0]['zdj'];
		$zsscount=$zgs[0]['zss'];
		$zsccount=$zgs[0]['zsc'];
		if (empty($zdjcount)||$zdjcount==0)
		{
			$djcount=1;
			$zdjcount=1;
		}
		if (empty($zsscount)||$zsscount==0)
		{
			$sscount=1;
			$zsscount=1;
		}
		if (empty($zsccount)||$zsccount==0)
		{
			$sccount=1;
			$zsccount=1;
		} 
		$num=round(($djcount/$zdjcount*0.2 + $sscount/$zsscount*0.3 + $sccount/$zsccount*0.5) * 5,0);
		if ($num>5)
			$num=5;
		return $num;
	}
	
	/**
	 * 获取奖品
	 *
	 * @create 2016-9-21
	 * @author zlw
	 */
    protected function get_prizes_lottery($prizes = array())
    {
        $prize_arr = $this->get_prizes_list();

        if (empty($prizes)) {
			$prizes = $prize_arr;
        }

		//获取中奖信息
        $prize = $this->lottery_roll($prizes);
		
		//条件信息
		$user_id = $this->get_customer_id();
		$pc_id = cookie('pc_id');
		$proj_id = cookie('proj_id');
		
		//当前用户已获得奖品列表
		$prizes = M()->query("
			SELECT a.*,b.name,b.rank,b.type 
			FROM xk_user2prize a 
			LEFT JOIN xk_prizes b on a.prize_id=b.id 
			WHERE a.proj_id='". $proj_id ."' 
				AND a.pc_id='" . $pc_id . "' 
				AND a.userid='" . $user_id ."' 
				AND 886=886 
		"); 
	
		$this->assign('prizecount', count($prizes));
		$this->assign('prize', $prizes);
		
		//中奖
        if ($prize['status'] == 1) {			
			$this->assign('is_show', 1);
        } else { // 未中奖			
			$this->assign('is_show', 0);
		}

		if (count($prizes) > 0) {
			//获取内容
			//$view = 'Prizes/lottery';
			$view = 'Prizes/lottery_show';
			$html = $this->fetch($view);
			echo $html;
		}
	}
	
	/**
	 * 获取用户所得的奖品
	 *
	 * @create 2016-9-26
	 * @author zlw
	 */
    protected function get_user_prizes()
    {
		//条件信息
		$user_id = $this->get_customer_id();
		$pc_id = cookie('pc_id');
		$proj_id = cookie('proj_id');
		
		//当前用户已获得奖品列表
		$prizes = M()->query("
			SELECT a.*,b.name,b.rank,b.type 
			FROM xk_user2prize a 
			LEFT JOIN xk_prizes b on a.prize_id=b.id 
			WHERE a.proj_id='". $proj_id ."' 
				AND a.pc_id='" . $pc_id . "' 
				AND a.userid='" . $user_id ."' 
				AND 886=886 
		"); 
	
		$this->assign('is_show', 0);
		$this->assign('prizecount', count($prizes));
		$this->assign('prize', $prizes);

		if (count($prizes) > 0) {
			//获取内容
			$view = 'Prizes/lottery_show';
			$html = $this->fetch($view);
			echo $html;
		}
	}

	/**
	 * 摇奖
	 *
	 * @create 2016-9-21
	 * @author zlw
	 */
    protected function lottery_roll($prize_arr)
    {		
		if (empty($prize_arr)) {
			return array(
				'status' 	=> 0,
				'info' 		=> '很遗憾,与大奖擦肩而过!',
			);
		}
		
		$prize = Lottery::roll($prize_arr);

		//当前奖项
		$now_prize = $prize['yes'];

		//没有数据
		if (empty($now_prize)) {
			return array(
				'status' 	=> 0,
				'info' 		=> '很遗憾,与大奖擦肩而过!',
			);
		}

		//未中奖
		if (isset($now_prize['type']) && $now_prize['type'] == '-1') {
			return array(
				'status' 	=> 0,
				'info' 		=> trim($now_prize['name']),
			);
		} else {
			//插入中奖纪录和更新奖品明细
			$u2p = M('user2prize');
			$info['userid'] 	= $this->get_customer_id();
			$info['prize_id'] 	= $now_prize['id'];
			$info['proj_id'] 	= cookie('proj_id');
			$info['pc_id'] 		= cookie('pc_id');
			$info['zjtime'] 	= time();
			$u2p->add($info);
			
			$sql = 'update xk_prizes set sygs=sygs-1 where id='.$now_prize['id'];
			M()->execute($sql);
		}

		return array(
			'status' 	=> 1,
			'info' 		=> $now_prize['name'],
		);
    }
	
	/**
	 * 奖品列表
	 *
	 * @create 2016-9-23
	 * @author zlw
	 */
    protected function get_prizes_list()
    {
        $user_id = $this->get_customer_id();
        $pc_id = cookie('pc_id');
        $proj_id = cookie('proj_id');

        $prize_arr = array();
        if ($pc_id >0 && $proj_id >0)
        {
			$model 	= new \Think\Model();
			//当前用户已获得奖品列表
			$prizes	= $model->query("select a.*,b.name,b.rank,b.type from xk_user2prize a left join xk_prizes b on a.prize_id=b.id where a.proj_id='". $proj_id ."' and a.pc_id='" . $pc_id . "' and a.userid='" . $user_id ."' and 886=886 "); 
			//获取抽奖次数设置(每人允许抽奖次数,预计总的抽奖人数[用于控制中奖概率])
			$kppcs	= $model->query("select cjcs,cjzrs from xk_kppc a where a.proj_id='". $proj_id ."' and id='" . $pc_id . "' and 887=887 ");
			$cfzj	= true;//大奖类型的奖品是否还可以重复抽取
			foreach ($prizes as $key1 => $value1) {
				if ($value1['type']==1)
				{
					$cfzj = false;
					break;
				}
			}
         
            if (count($prizes)<$kppcs[0]['cjcs'])//每人允许抽奖次数控制
            {   
                //本次活动剩余奖品列表
                $prizelist = $model->query("select id,rank,name,zjv,type from xk_prizes a where a.proj_id='". $proj_id ."' and pc_id='" . $pc_id . "' and sygs>0 order by id ");
                if(count($prizelist)>0)
                {
                    foreach ($prizelist as $key => $value) {
                        if (($cfzj && $value['type']==1) || $value['type']==0)//大奖只允许抽取一次
                        {
                            $prize_arr[$key]['id']=$value['id'];
                            $prize_arr[$key]['rank']=$value['rank'];
                            $prize_arr[$key]['name']=$value['name'];
                            $prize_arr[$key]['v']=$value['zjv'];
                        }
                    }
					
                    //添加未中奖几率及信息
                    $maxkey = count($prizelist);
                    $prize_arr[$maxkey]['id']	= 999;
                    $prize_arr[$maxkey]['rank']	= "";
                    $prize_arr[$maxkey]['name']	= "未中奖";
                    $prize_arr[$maxkey]['v']	= $kppcs[0]['cjzrs'];
                    $prize_arr[$maxkey]['type'] = '-1'; 
                }
            }
        }	
        return $prize_arr;
    }

    
    function getIP() {
        if (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        }
        elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_X_FORWARDED')) {
            $ip = getenv('HTTP_X_FORWARDED');
        }
        elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ip = getenv('HTTP_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_FORWARDED')) {
            $ip = getenv('HTTP_FORWARDED');
        }
        else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}
