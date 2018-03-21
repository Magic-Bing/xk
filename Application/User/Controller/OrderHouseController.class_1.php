//源程序后30页
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
namespace User\Controller;
/**
 * 搜索
 *
 * @create 2016-9-2
 * @author zlw
 */
class SearchController extends BaseController 
{

	/**
	 * 首页
	 *
	 * @create 2016-9-2
	 * @author zlw
	 */
    public function index() 
	{	
		//项目
		$Project = D('Common/Project');

		//分析
		$search_info = I('info', '', 'trim');
		$search_project_id = get_search_id_by($search_info, 'p');
		
		$this->assign('project_id', $search_project_id);	
		
		$where['proj_id'] = $search_project_id;
                
                //获取项目
		$project_info = $Project->getProjectById($search_project_id);
		$this->assign('project', $project_info);
		
		//楼栋
		$Build = D('Common/Build');
		$Buildview = D('Common/Buildview');
		$build_list = $Buildview->getBuildList($where, 'buildname ASC');
		$this->assign('build_list', $build_list);		
		
		//户型
		$Room = D('Common/Room');
		$Roomview = D('Common/Roomview');
		$hx_list = $Roomview->getRoomListGroupBy('hx, proj_id', 'hx', 'hx ASC', $where);
		$this->assign('hx_list', $hx_list);	
	
		$this->set_seo_title($project_info['name']);
        $this->display();		
	}
	
	
	/**
	 * 搜索房间并返回信息
	 *
	 * @create 2016-9-2
	 * @author zlw
	 */
	public function room()
	{
		if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('room/index'));
		}
		
		//条件
		$search_info = I('info', '', 'trim');
		$type = I('type', '', 'trim');
		if (empty($search_info) && $type=="ptss") {
			$this->error('搜索条件不能为空，请确认后重试！', U('room/index'));
		}
		$this->assign('search_info', $search_info);
	
		if (!empty($search_info) && $search_info<>"") 
		{
			//当前房间
			$map['room'] 	= array('like', '%' . $search_info . '%');
			$map['hx']  	= array('like', '%' . $search_info . '%');
			$map['floor']  	= array('like', '%' . $search_info . '%');
			$map['_logic']  = 'or';
			$where['_complex'] = $map;
		}
		
		//项目
		$project_id = I('project_id', '', 'intval');
		if (empty($project_id) || $project_id == 0) {
			$this->error("项目不存在，请重试！", U('search/index'));
		}
		$where['proj_id'] = $project_id;
		
		//是否购买
		$is_xf = I('is_xf', '', 'trim');
		if (strtolower($is_xf) != 'all') {
			if (intval($is_xf) == 1) {
				$where['is_xf'] = 0;
			} else {
				$where['is_xf'] = 0;
			}
		}
		
		//楼栋
		$build_ids = I('build_ids', '', 'trim');
		if (!empty($build_ids)) {
			$where['bld_id'] = array('in', explode(',', $build_ids));
		}
		
		//楼层
		$floor_start = I('floor_start', '', 'trim');
		if (!empty($floor_start)) {
			$where['floor'][] = array('egt', intval($floor_start));
		}else{
			$where['floor'][] = array('egt', -2);
		}
		$floor_end = I('floor_end', '', 'trim');
		if (!empty($floor_end)) {
			$where['floor'][] = array('elt', intval($floor_end));
		}else{
			$where['floor'][] = array('elt', 999);
		}

		//面积
		$area_start = I('area_start', '', 'trim');
		if (!empty($area_start)) {
			$where['area'][] = array('egt', intval($area_start));
		}else{
			$where['area'][] = array('egt', 1);
		}  
		$area_end = I('area_end', '', 'trim');
		if (!empty($area_end)) {
			$where['area'][] = array('elt', intval($area_end));
		}else{
			$where['area'][] = array('elt', 99999);
		}
		
		//价格
		$price_start = I('price_start', '', 'trim');
		if (!empty($price_start)) {
			$where['price'][] = array('egt', intval($price_start));
		}else{
			$where['price'][] = array('egt', 1);
		}
		$price_end = I('price_end', '', 'trim');
		if (!empty($price_end)) {
			$where['price'][] = array('elt', intval($price_end));
		}else{
			$where['price'][] = array('elt', 999999999);
		}

		//户型
		$hx_ids = I('hx_ids', '', 'trim');
		if (!empty($hx_ids)) {
			$where['hx'] = array('in', explode(',', $hx_ids));
		}
                
		//$rooms = D("Room")->getRoomList($where, "bld_id ASC, unit ASC, no ASC");
		$rooms = D("Roomview")->getRoomList($where, "cast(buildcode as SIGNED) ASC, cast(unit as SIGNED) ASC, cast(floor as SIGNED) DESC, cast(room as SIGNED) ASC");
		
		//获取相关信息
		if (!empty($rooms)) {
			foreach ($rooms as $key => $room) {
				//楼栋信息
				$bld_id = $room['bld_id'];
				$build = D("Build")->getBuildById($bld_id);
				
				//判断时间
				if (date('d', $room['xftime']) == date('d')) {
					$time = date('H:i', $room['xftime']);
				} elseif (!empty($room['xftime'])) {
					$time = date('Y-m-d H:i', $room['xftime']);
				} else {
					$time = '';
				}
				$data = array(
					'room_id' 		=> $room['id'],
					'room_name' 	=> $build['buildname'].$room['unit'].'单元',
					'room_floor' 	=> $room['floor'].'F',
					'room_number' 	=> $room['room'],
					'room_hx' 		=> $room['hx'],
					'room_area' 	=> $room['area'],
					'room_total' 	=> $room['total'],
					'room_is_xf' 	=> 0,
					'xftime' 		=> $time
				);
				
				$rooms[$key] = array_merge($room, $data);
			}
		}
		$this->assign('rooms', $rooms);
		
		//获取内容
		$room_list = $this->fetch();
		
		$this->success($room_list, U('search/index'));
	}

}
namespace User\Controller;
/**
 * 首页
 *
 * @create 2016-8-22
 * @author zlw
 */
class IndexController extends BaseController 
{
	/**
	 * 构造方法
	 *
	 * @create 2016-11-16
	 * @author zlw
	 */
	public function _initialize()
	{
		//设置项目相关
		$this->set_project();
		//$this->wx_login();
		parent::_initialize();
	}
        
	
	/**
	 * 设置项目相关
	 *
	 * @create 2016-11-16
	 * @author zlw
	 */
	protected function set_project()
	{
		$search_info = I('info', '', 'trim');
		
		$project_id = get_search_id_by($search_info, 'p', '');
		if (!empty($project_id)) {
			D('Weixin', 'Logic')->setProjectId($project_id);
		}
	}
	
	/**
	 * 首页
	 *
	 * @create 2016-8-22
	 * @author zlw
	 */
    public function index() 
	{		
		//分析
		$search_info = I('info', '', 'trim');
		$this->assign("info",$search_info);

		$search_project_id = get_search_id_by($search_info, 'p');
        $count=$this->get_bx_count($search_project_id);
        $this->assign("cou",$count);
        $this->assign("eventId",$search_project_id);
		if( !empty($search_project_id)&& $search_project_id>0)
		{
			 $model = new \Think\Model();
			 $pclst=$model->query("select * from xk_kppc a where a.proj_id='". $search_project_id ."' and is_dq=1 order by id desc limit 1 ");
			 cookie('pc_id',$pclst[0]['id']);
			 cookie('proj_id',$pclst[0]['proj_id']);
		}

		//归类
		$Room = D('Common/Room');
		$Roomview = D('Common/Roomview');
		$where['proj_id'] = $search_project_id;
		$where['is_dq'] = 1;
		$group_room_build = $Roomview->getRoomListGroupBy('bld_id', 'bld_id', 'bld_id, id', $where);
		$group_room_unit = $Roomview->getRoomListGroupBy('bld_id, unit', 'bld_id, unit', 'bld_id, unit, id', $where);

		//数据格式化
		$new_group_room_unit = array();
		foreach ($group_room_unit as $group_room_unit_key => $group_room_unit_value) {
			$new_group_room_unit[$group_room_unit_value['bld_id']][] = $group_room_unit_value;
		}
		$this->assign('new_units', $new_group_room_unit);
		$this->assign('units', array_merge($new_group_room_unit));

		//分析
		$search_build_id = get_search_id_by($search_info, 'b', $group_room_build[0]['bld_id']);
		$search_unit_id = get_search_id_by($search_info, 'u', $new_group_room_unit[$search_build_id][0]['unit']);

		//获取楼层
		unset($where);
		$where['proj_id'] = $search_project_id;
		$where['bld_id'] = $search_build_id;
		$where['unit'] = $search_unit_id;
		$group_room_floor = $Room->getRoomListGroupBy('floor', 'floor DESC', 'id DESC', $where);
		$this->assign('floors', $group_room_floor);

		//设置当前搜索
		$search = array(
			'search_project_id' => $search_project_id,
			'search_build_id' 	=> $search_build_id,
			'search_unit_id' 	=> $search_unit_id,
		);
		$this->assign($search);

		//户型
		//$Room = D('Common/Room');
		$Roomview = D('Common/Roomview');
		$hx_list = $Roomview->getRoomListGroupBy('hx, proj_id', 'hx', 'hx ASC', array('proj_id' => $search_project_id));
		$this->assign('hx_list', $hx_list);

		//项目
		$Project = D('Common/Project');
		
		//获取项目
		$project_info = $Project->getProjectById($search_project_id);
		$this->assign('project', $project_info);

		//获取相关楼栋
		$build_ids = array();
		foreach ($group_room_build as $group_room_build_k => $group_room_build_v) {
			$build_ids[] = $group_room_build_v['bld_id'];
		}

		if (!empty($build_ids)) {
			$Build = D('Common/Build');
			$where['id'] = array('in', $build_ids);
			$build_list = $Build->getBuildList($where, 'cast(buildname as SIGNED), id DESC');
		} else {
			$build_list = array();
		}

		$build_new_list = array();
		foreach ($build_list as $key => $build) {
			$build_new_list[$build['id']] = $build;
		}
		$this->assign('builds', $build_new_list);
		$this->assign('buildings', array_merge($build_new_list));
//        echo json_encode($build_new_list);exit;
		//房间
		unset($where);
		$where['proj_id'] = $search_project_id;
		$where['bld_id'] = $search_build_id;
		$where['unit'] = $search_unit_id;
		$room_list = D("Common/Room")->getRoomListJoinAttribute($where, 'floor DESC, no ASC');

		$new_room_list = array();
		$room_ids = array();
		foreach ($room_list as $room_list_key => $room_list_value) {
			$new_room_list[$room_list_value['floor']][] = $room_list_value;
			$room_ids[] = $room_list_value['id'];
		}
		$this->assign('rooms', $new_room_list);
//        echo json_encode($group_room_floor);
//        echo json_encode($new_room_list);exit;
		//收藏
		unset($where);
		$collection_room_ids = array();
		if (count($room_list)>1)
		{
			$where['cst_id'] 	= $this->get_customer_id();
			$where['room_id'] 	= array('in', $room_ids);
			$room_collection = D('Common/Collection')->getList($where);
			foreach ($room_collection as $room_collection_key => $room_collection_value) {
				$collection_room_ids[] = $room_collection_value['room_id'];
			}
		}		
		$this->assign('collection_room_ids', $collection_room_ids);
//        echo json_encode($build_new_list);
//        echo json_encode($new_group_room_unit);
//        exit;
		$this->set_seo_title($project_info['name']);
        $this->display();
    }

    /**
     * 房间列表
     *
     * @create 2016-9-6
     * @author zlw
     */
    public function room()
    {
        $search_where = array();

        //楼栋
        $build_ids = I('build_ids', '', 'trim');
        if (!empty($build_ids)) {
            $search_where['bld_id'] = array('in', explode(',', $build_ids));
        }

        //楼层
        $floor_start = I('floor_start', '', 'trim');
        if (!empty($floor_start)) {
            $search_where['floor'][] = array('egt', intval($floor_start));
        } else {
            $search_where['floor'][] = array('egt', -2);
        }
        $floor_end = I('floor_end', '', 'trim');
        if (!empty($floor_end)) {
            $search_where['floor'][] = array('elt', intval($floor_end));
        } else {
            $search_where['floor'][] = array('elt', 999);
        }

        //面积
        $area_start = I('area_start', '', 'trim');
        if (!empty($area_start)) {
            $search_where['area'][] = array('egt', intval($area_start));
        } else {
            $search_where['area'][] = array('egt', 1);
        }
        $area_end = I('area_end', '', 'trim');
        if (!empty($area_end)) {
            $search_where['area'][] = array('elt', intval($area_end));
        }else{
            $search_where['area'][] = array('elt', 99999);
        }


        //价格
        $price_start = I('price_start', '', 'trim');
        if (!empty($price_start)) {
            $search_where['price'][] = array('egt', intval($price_start));
        }else{
            $search_where['price'][] = array('egt', 1);
        }

        $price_end = I('price_end', '', 'trim');
        if (!empty($price_end)) {
            $search_where['price'][] = array('elt', intval($price_end));
        }else{
            $search_where['price'][] = array('elt', 999999999);
        }


        //户型
        $hx_ids = I('hx_ids', '', 'trim');
        if (!empty($hx_ids)) {
            $search_where['hx'] = array('in', explode(',', $hx_ids));
        }

        //项目
        $Project = D('Common/Project');
        $project_list = $Project->getProjectList(array(
            'status' => 1
        ), 'name ASC, id ASC');
        $this->assign('projects', $project_list);

        //格式化楼栋
        $new_project_list = array();
        foreach ($project_list as $project_list_key => $project_list_value) {
            $new_project_list[$project_list_value['id']][] = $project_list_value;
        }
        $this->assign('new_projects', $new_project_list);

        //分析
        $search_info = I('info', '', 'trim');
        $search_project_id = get_search_id_by($search_info, 'p', $project_list[0]['id']);

        //户型
        $Room = D('Common/Room');
        unset($where);
        $where['proj_id'] = $search_project_id;
        $hx_list = $Room->getRoomListGroupBy('hx, proj_id', 'hx', 'hx ASC', $where);
        $this->assign('hx_list', $hx_list);

        //归类
        $Room = D('Common/Room');
        $where['proj_id'] = $search_project_id;
        $where = array_merge($where, $search_where);
        $group_room_build = $Room->getRoomListGroupBy('bld_id', 'bld_id', 'bld_id, id', $where);
        $group_room_unit = $Room->getRoomListGroupBy('bld_id, unit', 'bld_id, unit', 'bld_id, unit, id', $where);

        //数据格式化
        $new_group_room_unit = array();
        foreach ($group_room_unit as $group_room_unit_key => $group_room_unit_value) {
            $new_group_room_unit[$group_room_unit_value['bld_id']][] = $group_room_unit_value;
        }
        $this->assign('new_units', $new_group_room_unit);

        //分析
        $search_build_id = get_search_id_by($search_info, 'b', $group_room_build[0]['bld_id']);
        $search_unit_id = get_search_id_by($search_info, 'u', $new_group_room_unit[$search_build_id][0]['unit']);

        //获取楼层
        unset($where);
        $where['proj_id'] 	= $search_project_id;
        $where['bld_id'] 	= $search_build_id;
        $where['unit'] 		= $search_unit_id;
        $where = array_merge($where, $search_where);
        $group_room_floor = $Room->getRoomListGroupBy('floor', 'floor DESC', 'id DESC', $where);
        $this->assign('floors', $group_room_floor);

        //设置当前搜索
        $search = array(
            'search_project_id' => $search_project_id,
            'search_build_id' 	=> $search_build_id,
            'search_unit_id' 	=> $search_unit_id,
        );
        $this->assign($search);

        //获取项目
        $project_info = $Project->getProjectById($search_project_id);
        $this->assign('project', $project_info);

        //获取相关楼栋
        $build_ids = array();
        foreach ($group_room_build as $group_room_build_k => $group_room_build_v) {
            $build_ids[] = $group_room_build_v['bld_id'];
        }

        if (!empty($build_ids)) {
            $Build = D('Common/Build');
            $where['id'] = array('in', $build_ids);
            $build_list = $Build->getBuildList($where, 'buildname, id DESC');
        } else {
            $build_list = array();
        }

        $build_new_list = array();
        foreach ($build_list as $key => $build) {
            $build_new_list[$build['id']] = $build;
        }
        $this->assign('builds', $build_new_list);

        //房间
        unset($where);

        $where['proj_id'] 	= $search_project_id;
        $where['bld_id'] 	= $search_build_id;
        $where['unit'] 		= $search_unit_id;
        $where = array_merge($where, $search_where);
        //$room_list = D("Common/Room")->getRoomList($where, 'floor DESC, no ASC');
        $room_list = D("Common/Room")->getRoomListJoinAttribute($where, 'floor DESC, no ASC');

        $new_room_list = array();
        foreach ($room_list as $room_list_key => $room_list_value) {
            $new_room_list[$room_list_value['floor']][] = $room_list_value;
        }

        $new_room_list = array();
        $room_ids = array();
        foreach ($room_list as $room_list_key => $room_list_value) {
            $new_room_list[$room_list_value['floor']][] = $room_list_value;
            $room_ids[] = $room_list_value['id'];
        }
        $this->assign('rooms', $new_room_list);

        //收藏
        unset($where);
        $collection_room_ids = array();
        if (count($room_list)>1)
        {
            $where['cst_id'] 	= $this->get_customer_id();
            $where['room_id'] 	= array('in', $room_ids);
            $room_collection = D('Common/Collection')->getList($where);
            foreach ($room_collection as $room_collection_key => $room_collection_value) {
                $collection_room_ids[] = $room_collection_value['room_id'];
            }
        }
        $this->assign('collection_room_ids', $collection_room_ids);

        unset($where);
        $where['cst_id'] = $this->get_customer_id();
        $where['hd_id'] = 1;
        $Wxrg = D('Common/WxrgLog')->getOne($where);
        $this->assign('wxrg', $Wxrg);
        //获取内容
        $room_list = $this->fetch();

        $this->success($room_list, U('index/index'));
    }
    /**
     * 微信认购
     *
     * @create 2017-04-26
     * @author jxw
     */
    public function wxrg_add()
    {
        if (!IS_AJAX) {
            $this->error('请求错误，请确认后重试！');
        }

        //获取ID
        $id = I('room_id', 0, 'intval');
        if (empty($id) || $id == 0) {
            $this->error('房间ID不能为空，请确认后重试！');
        }

        //验证当前房间信息
        $room = D("Room")->getRoomById($id);
        if (empty($room)) {
            $this->error('房间信息不存在，请确认后重试！');
        }
        $cstid=$this->get_customer_id();
        //判断当前房间是否选择
        $is_success=0;
        if ($room['is_xf'] <> 1) {
            //判断当前客户本次微信认购是否已购买房间
            unset($where);
            $where['cst_id'] = $cstid;
            $where['hd_id'] = 1;
            $cst2wxrg = D('Common/WxrgLog')->getList($where);
            if (!empty($cst2wxrg))
            {
                $this->error('已购买其他房间，不能再次购买！');
            }
            $cst = D("Customer")->getOneById($cstid);
            $data = array(
                'is_xf' => 1,
                'xftime' => time(),
                'cstname' => $cst['name'],
            );

            $check_has_edit = D("Room")->editRoomById($data, $id);
            if ($check_has_edit === false) {
                $this->error('认购失败，请确认后重试！', U('room/index'));
            }
            //日志
            $this->wxrg_add_log($room['id'],$cstid,$cst['name']);
            $is_success=1;
        }

        $Model = new \Think\Model();
        $projid=$room['proj_id'];
        //获取备选的房间
        unset($where);
        $where['cst_id'] = $cstid;
        $where['proj_id'] = $projid;
        $where['is_dq'] = 1;
        $bxrooms = D('Common/Collectionview')->getListJoinWxrg($where);
        $sxrooms=array();
        $sxrooms[0]=$is_success;
        $sxrooms[1]=$bxrooms;
        $this->success($sxrooms);
    }


    /**
     * 微信认购 - 后置操作方法
     *
     * @create 2017-04-26
     * @author jxw
     */
    public function wxrg_add_log($room_id,$cst_id, $cst_name)
    {
        D("WxrgLog")->wxrglog($room_id, $cst_id, $cst_name,1);
    }

    //备选房源(收藏列表)
    public function collectedroom()
    {
        $id = I('id', 0, 'trim');
        $cid = session("user_id");
        $model=M();
        $res=$model->table("xk_room r")->field("b.buildname bname,r.unit,r.floor,r.room,r.area,r.total,r.hx,h.hxmx,c.id,c.px,r.id rid")->
            join("xk_cst2rooms c ON r.id=c.room_id")->
            join("LEFT JOIN xk_hxset h ON h.hx=r.hx")->
            join("xk_build b ON b.id=r.bld_id")->
            where("c.proj_id=$id AND c.cst_id=$cid")->order("c.px asc")->select();
        $this->assign("res",$res);
        $this->assign("id",$id);
        $this->set_seo_title("备选房源");
        $this->display(":index/collectedroom");
    }

    //取消收藏
    public function delete_collected(){
        $id=I("post.id");
        $px=M()->table("xk_cst2rooms")->where("id=$id")->select();
        $pd=M()->table("xk_cst2rooms")->where("id=$id")->delete();
        if($pd){
            M()->execute("update xk_cst2rooms set px=(px-1) WHERE cst_id={$px[0]['cst_id']} AND proj_id={$px[0]['proj_id']} AND px>{$px[0]['px']}");
        }
        echo $pd?"true":"false";exit;
    }
}

/**
 * 首页
 *
 * @create 2016-8-22
 * @author zlw
 */
class OrderHouseController extends BaseController {

    private $_eventId = 0;

    /**
     * 构造方法
     *
     * @create 2016-11-16
     * @author zlw
     */
    public function _initialize() {
        parent::_initialize();
        
        $privilege = session("privilege");

        if(empty($privilege))//未登录
        {
            $info = I('info', 0, 'trim');
            if(in_array(ACTION_NAME, array('privilege', 'send_sms_code', 'check')))//当前页面为登录页面
            {
                if(!empty($info) && !in_array(ACTION_NAME, array('send_sms_code', 'check')))
                {
                    $einfo = geturl($info, getUrlkey());
                    $eventId = $einfo['eventId'];
                    if (!empty($eventId) && $eventId > 0) {
                        cookie('eventId', encrypt_url("eventId/" . $eventId, getUrlkey()),60 * 60*6);
                    }

                }
            }
            else
            {
                if(!empty($info))
                {
                    $einfo = geturl($info, getUrlkey());
                    $eventId = $einfo['eventId'];
                    if (!empty($eventId) && $eventId > 0) {
                        cookie('eventId', encrypt_url("eventId/" . $eventId, getUrlkey()),60 * 60*6);
                    }
                }
                $this->logout();
            }
        }
        else//已登录
        {
            $info = I('info', 0, 'trim');
            //校验活动状态和用户状态是否正常
            $redisDriver = new Redis();
            if(empty(cookie('eventId')))
            {
                $einfo = geturl($info, getUrlkey());
                $eventId = $einfo['eventId'];
                if($eventId && in_array(ACTION_NAME, array('privilege', 'send_sms_code', 'check')))//当前页面为登录页面
                {
                     cookie('eventId', encrypt_url("eventId/" . $eventId, getUrlkey()),60 * 60*6);
                }
            }
            $eid = geturl(cookie('eventId'), getUrlkey())["eventId"];
            
            $cphone = rsa_decode(cookie('phone'),getChoosekey());//解密
            if ($eid && $cphone) {
                $event = $redisDriver->hGetAll("event_order_house_{$eid}");
                if ($event) {
                    if ($event['states'] == 0) {
                        $this->logout();
                    }
                    $chooselog = $redisDriver->hGetAll("dlsx_order_house_{$eid}_{$cphone}");
                    if (!$chooselog || !$chooselog['sid']) {//登录已失效
                        $this->logout();
                    } else {
                        if (session_id() <> $chooselog['sid']) {//同一手机号只能一台手机登录
                            $this->logout();
                        }
                    }
                    if(!$chooselog||$chooselog['status']==0){//用户已禁用
                        $this->logout();
                    }
                }else
                {
                    $dqev =D("EventOrderHouse")->where("id={$eid}")->find();
                    if($dqev['states']==0)
                    {
                        $this->logout();
                    }
                }
            }
            
            if(!empty($info) && !empty(cookie('eventId')))//判断用户打开的活动页面是否有效
            {
                $einfo = geturl($info, getUrlkey());
                $einfo1 = geturl(cookie('eventId'), getUrlkey());
                if($einfo['eventId']<>$einfo1['eventId'])
                {
                    cookie('eventId', encrypt_url("eventId/" . $einfo['eventId'], getUrlkey()),60 * 60*6);
                    $this->logout();
                }
            }
            
            if(in_array(ACTION_NAME, array('privilege', 'send_sms_code', 'check')))//当前页面为登录页面
            {
                $this->redirect('index', [info => cookie('eventId')]);
            }
         }

        $einfo = geturl(cookie('eventId'), getUrlkey());
        $this->_eventId =$einfo["eventId"];
    }

    public function getEventId() {
        return $this->_eventId;
    }

    /**
     * 微信认购
     *
     * @create 2017-04-25
     * @author jxw
     */
    public function index() {
        
        $id=$this->getEventId();
        if(empty($id))
        {
            $this->logout();
        }
        $eventOrderHouseModel = D('Common/EventOrderHouse');
        $event = $eventOrderHouseModel->getEventByEventId($id);

        //所有栋
        $buildings = array();
        //冗余 搜索使用
        $rdd_building = array();
        foreach ($event['building_hash'] as $building) {
            $building[] = explode('_', $building[0])[5];
            $buildings[] = $building;
            $rdd_building[$building[0]] = $building[1];
        }
        //所有单元
        $units = array();
        foreach ($buildings as $building) {
            $tempUnits = $eventOrderHouseModel->getUnitsBelongToBuildingByRedisId($building[0]);

            $units[] = $tempUnits;
        }

        //所有房间
        $rooms = $eventOrderHouseModel->getRoomsBelongToUnitByRedisId($units[0][0][0]);
        
        //所有户型
        $hxs = $event['allhx'];
        /* $hxs = [$rooms[0]['hx']];
          for ($i=0;$i<count($rooms);$i++){
          if ( !in_array($rooms[$i]['hx'],$hxs) ){
          $hxs[] = $rooms[$i]['hx'];
          }
          } */

        //项目
        $project = D("Common/Project")->getProjectById($rooms[0]["project_id"]);

        //用户收藏
        $this->get_customer_id();
        $where = array('cst_id' => session("chooseuid"), 'proj_id' => $event['project_id'], 'eventId' => $id, '88=88');
        $roomCollectionModel = D('Common/Collection');
        $roomCollected = $roomCollectionModel->getList($where);

        //整理用户收藏
        foreach ($roomCollected as $key => $item) {
            $room = $eventOrderHouseModel->getRoomByRedisKey("event_order_house_{$id}_room_{$item['room_id']}");
            if (empty($room)) {
                unset($roomCollected[$key]);
            } else {
                $roomCollected[$key] = $room;
                $roomCollected[$key]['building_name'] = $rdd_building["event_order_house_{$id}_build_{$room['build_id']}"];
            }
        }

        //用户已预定的房间
        $orderHouseOrderModel = D('OrderHouseOrder');

        $orderedRoom = $orderHouseOrderModel->find(array(
            'where' => array('event_id' => $id, 'belong_phone' => rsa_decode(session('phone'),  getChoosekey()))
        ));
        //收藏排名
        $collectionSort = $eventOrderHouseModel->getRoomCollectionSort($id);

        //所有被预购的房间
        $orderedRooms = $eventOrderHouseModel->getAllOrderedRoomInRedis($id);

        $dqhm = $this->getMillisecond();
        $time = 0;
        if ($dqhm < $event['start_time'] * 1000) {//活动未开始时，返回活动开始倒计时time和整个活动时长time1
            $time = $event['start_time'] * 1000 - $dqhm;
            $time1 = $event['end_time'] * 1000 - $event['start_time'] * 1000;
            $this->assign('iswks', 1);
            $this->assign('time1', $time1);
        } else {//活动已开始，返回的time和time1一样
            $time = $event['end_time'] * 1000 - $dqhm;
            if ($dqhm > $event['end_time'] * 1000) {
                $this->assign('iswks', -1); //活动已结束
                $time = 0;
            } else {
                $this->assign('iswks', 0);
            }
            $this->assign('time1', $time);
        }
        //活动倒计时
        $this->assign('time', $time);

        //活动ID
        $this->assign('eventId', cookie("eventId"));
        //$this->assign('jmevent', cookie("eventid"));

        //所有栋
        $this->assign('buildings', $buildings);
        //所有单元
        $this->assign('units', $units);

        //默认为 budings[0] unit[0] 下属单元 默认加载
        $this->assign('rooms', json_encode($rooms ? $rooms : array()));

        //用户收藏的房间
        $this->assign('roomCollected', json_encode($roomCollected));

        //用户已经预定的房间
        $this->assign('orderedRoom', json_encode($orderedRoom ? $orderedRoom : array()));
        //$this->assign('orderedRoom',$orderedRoom);
        //所有已被预定的房间
        $this->assign('orderedRooms', json_encode($orderedRooms ? $orderedRooms : array()));

        //用户收藏房间排序
        $this->assign('collectionSort', json_encode($collectionSort ? $collectionSort : array()));

        //所有户型
        $this->assign('hxs', $hxs);
        $this->set_seo_title($project["name"]);
        $this->display();
    }

    //我的订单列表
    public function myorder() {
        //echo $this->getMillisecond();
        $id=$this->getEventId();
        if(empty($id))
        {
            $this->logout();
        }

        //$id = I('id', 0, 'trim');
        $eventOrderHouseModel = D('Common/EventOrderHouse');
        $event = $eventOrderHouseModel->getEventByEventId($id);

        //用户信息
        $chooseModel = M('choose');

        $cuserinfo = $chooseModel->find(array(
            'where' => array('id' => session("chooseuid"), 'customer_phone' => session('phone'))
        ));
        $cuserinfo['customer_phone']=rsa_decode(session('phone'),getChoosekey());
        $cuserinfo['cardno']=rsa_decode($cuserinfo['cardno'],getChoosekey());
        $this->assign('userinfo', $cuserinfo);

        //用户收藏
        $this->get_customer_id();
        $where = array('cst_id' => session("chooseuid"), 'proj_id' => $event['project_id'], 'eventId' => $id, '88=88');
        $roomCollectionModel = D('Common/Collection');
        $roomCollected = $roomCollectionModel->getList($where);

        //整理用户收藏
        foreach ($roomCollected as $key => $item) {
            $room = $eventOrderHouseModel->getRoomByRedisKey("event_order_house_{$id}_room_{$item['room_id']}");
            if (empty($room)) {
                unset($roomCollected[$key]);
            } else {
                $roomCollected[$key] = $room;
                $roomCollected[$key]['building_name'] = $rdd_building["event_order_house_{$id}_build_{$room['build_id']}"];
            }
        }
        //活动ID
        $this->assign('eventId', cookie("eventId"));
        //$this->assign('eventId', $id);
        
        //用户收藏的房间
        $this->assign('roomCollected', json_encode($roomCollected));

        //用户已预定的房间
        $orderHouseOrderModel = D('OrderHouseOrder');
        $orderedRooms = $orderHouseOrderModel->select(array(
            'where' => array('event_id' => $id, 'belong_phone' => rsa_decode(session('phone'),getChoosekey()))
        ));
        if (!$orderedRooms) {
            $orderedRooms = array();
        }
        $redis = new \Redis();
        $redis->connect(C('REDIS_HOST'));
        if (count($orderedRooms) > 0) {
            foreach ($orderedRooms as $key => $orderedRoom) {
                
                $room = $redis->hGetAll("event_order_house_{$id}_room_{$orderedRoom['room_id']}");
                if ($room) {
                    $orderedRooms[$key]['total'] = $room['total'];
                }
            }
        }
        $this->assign('orderedRooms', $orderedRooms);

        $this->set_seo_title("我的订单");
        $this->display();
    }

    public function ordershow() {
        //$code=encrypt_url("eventId/2/oid/16",getUrlkey());
        //print_r($code);

        $info = I('info', 0, 'trim');
        $einfo = geturl($info, getUrlkey());
        $id = $einfo['eventId'];
        $oid = $einfo['oid'];


        $eventOrderHouseModel = D('Common/EventOrderHouse');
        $event = $eventOrderHouseModel->getEventByEventId($id);
        if (!$event['project_id']) {
            $event = $eventOrderHouseModel->getOneById($id);
        }

        //用户信息
        $chooseModel = M('choose');

        $cuserinfo = $chooseModel->find(array(
            'where' => array('id' => session("chooseuid"), 'customer_phone' => session('phone'))
        ));
        $cuserinfo['customer_phone']=rsa_decode(session('phone'),getChoosekey());
        $cuserinfo['cardno']=rsa_decode($cuserinfo['cardno'],getChoosekey());
        $this->assign('userinfo', $cuserinfo);

        //用户收藏
        $this->get_customer_id();
        $where = array('cst_id' => session("chooseuid"), 'proj_id' => $event['project_id'], 'eventId' => $id, '88=88');
        $roomCollectionModel = D('Common/Collection');
        $roomCollected = $roomCollectionModel->getList($where);

        //整理用户收藏
        foreach ($roomCollected as $key => $item) {
            $room = $eventOrderHouseModel->getRoomByRedisKey("event_order_house_{$id}_room_{$item['room_id']}");
            if (empty($room)) {
                unset($roomCollected[$key]);
            } else {
                $roomCollected[$key] = $room;
                $roomCollected[$key]['building_name'] = $rdd_building["event_order_house_{$id}_build_{$room['build_id']}"];
            }
        }

        //用户已预定的房间
        $orderHouseOrderModel = D('OrderHouseOrder');

        $orderedRoom = $orderHouseOrderModel->find(array(
            'where' => array('event_id' => $id, 'id' => $oid)
        ));
        if (!$orderedRoom) {
            $orderedRoom = array();
        }
        //活动ID
        $this->assign('eventId', cookie("eventId"));
        $this->assign('event', $event);

        //用户收藏的房间
        $this->assign('roomCollected', json_encode($roomCollected));

        //用户已经预定的房间
        $this->assign('orderedRoom', $orderedRoom);

        $redis = new \Redis();
        $redis->connect(C('REDIS_HOST'));
        //房间详情
        $room = $redis->hGetAll("event_order_house_{$id}_room_{$orderedRoom['room_id']}");
        if (!($room) && $orderedRoom['room_id'] > 0) {
            $room = M(roomlist)->where("id=" . $orderedRoom['room_id'])->find();
            $room['project_name'] = $room['projname'];
            $room['project_id'] = $room['proj_id'];
            $room['batch_id'] = $room['pc_id'];
        }
        $this->assign('room', $room);

        //项目信息
        if ($room) {
            $projinfo = M(project)->where("id=" . $room['project_id'])->find();
            $this->assign('projinfo', $projinfo);
        }
        //户型信息
        $hxwhere = [
            'fields' => '*'
            , 'where' => [
                'project_id' => $room['project_id']
                , 'batch_id' => $room['batch_id']
                , 'hx' => $room['hx']
                , '2=2'
            ]
        ];

        $hxinfo = D('hxset')->find($hxwhere);
        $this->assign('hxinfo', $hxinfo);

        $this->set_seo_title("订单详情");
        $this->display();
    }
    /**
     * 房间列表
     *
     * @create 2016-9-6
     * @author zlw
     */
    public function room() {
        if (!IS_AJAX)
            $this->error('请求错误，请确认后重试！');

        $condition = I('post.condition');

        //获取该单元所有房间
        $eventOrderHouseModel = D('Common/EventOrderHouse');
        $einfo = geturl($condition['event_id'], getUrlkey());
        $eventId=$einfo["eventId"];
        
        $unitKey = "event_order_house_{$eventId}_build_{$condition['build_id']}_unit_{$condition['unit_id']}";
        $rooms = $eventOrderHouseModel->getRoomsBelongToUnitByRedisId($unitKey);
        $roomsCount = count($rooms);
        for ($i = 0; $i < $roomsCount; $i++) {

            if ($condition['level'][0] > $rooms[$i]['floor']) {
                unset($rooms[$i]);
            }

            if (!empty($condition['level'][1]) && $condition['level'][1] < $rooms[$i]['floor']) {
                unset($rooms[$i]);
            }

            if ($condition['area'][0] > $rooms[$i]['area']) {
                unset($rooms[$i]);
            }

            if (!empty($condition['area'][1]) && $condition['area'][1] < $rooms[$i]['area']) {
                unset($rooms[$i]);
            }

            if ($condition['total'][0] * 10000 > $rooms[$i]['total']) {
                unset($rooms[$i]);
            }

            if (!empty($condition['total'][1]) && $condition['total'][1] * 10000 < $rooms[$i]['total']) {
                unset($rooms[$i]);
            }

            if ($condition['room'][0] > $rooms[$i]['room']) {
                unset($rooms[$i]);
            }

            if (!empty($condition['room'][1]) && $condition['room'][1] < $rooms[$i]['room']) {
                unset($rooms[$i]);
            }

            if (!empty($condition['hx'])) {
                if (!in_array($rooms[$i]['hx'], $condition['hx']))
                    unset($rooms[$i]);
            }

            if ($rooms[$i]['status'] == 1 && $condition['ds'] == 1)
                unset($rooms[$i]);
        }

        //$this->show(json_encode( array_values($rooms) ));
        $this->success(['成功', array_values($rooms)]);
    }

    /**
     * 微信认购
     *
     * @create 2017-04-26
     * @author jxw
     */
    public function order() {
        if (!IS_AJAX) {
            $this->error('请求错误，请确认后重试!');
        }
        //$eventId = I('eventId', 0, 'intval');
        $eventId=$this->getEventId();
        if (empty($eventId)) {
            $this->error('活动信息错误，请确认后重试!');
        }

        $redis = new OriginRedis();
        $redis->connect(C('REDIS_HOST'));

        $event = $redis->hGetAll("event_order_house_{$eventId}");

        if (empty($event))
            $this->error('无活动');

        if (time() < $event['start_time'])
            $this->error('活动未开始');

        if (time() > $event['end_time'])
            $this->error('活动已结束');

        $phone = rsa_decode(session('phone'),getChoosekey());

        if (empty($phone))
            $this->error('手机号码不正确');

        $eventOrderHouseModel = D('Common/EventOrderHouse');

        //查看活动是否存在
        $event = $eventOrderHouseModel->getEventByEventId($eventId);

        $expire_time = $event['end_time'] - time();

        if (empty($event)) {
            $this->error('活动没有开始');
        }

        //获取房间ID
        $ids = I('room_id', 0, 'intval');

        $orderHouseOrderModel = D('OrderHouseOrder');
        //用户预购房间
        //$userygroom;
        $evrnt_isyks = $redis->get($event['isyks']);
        //优先处理预购房间
        if ($evrnt_isyks == 0) {
            $ygrooms = $redis->hGetAll("event_order_house_{$eventId}_room_order_member");

            if (count($ygrooms) > 0) {
                foreach ($ygrooms as $ygroom) {
                    //$oldroom=$redis->hGetAll("event_order_house_{$eventId}_room_{$ygroom}");

                    $redis->hSet("event_order_house_{$eventId}_room_{$ygroom}", 'status', 1);
                    $redis->set("event_order_house_{$eventId}_room_{$ygroom}_locked", 1, $expire_time);
                    $redis->sAdd("event_order_house_{$eventId}_room_ordered", $ygroom);
                    //$redis->sAdd("event_order_house_{$eventId}_room_order_phone",$oldroom['schedule_phone']);
                }
            }
            $redis->hSet("event_order_house_{$eventId}", 'isyks', 1);
        }
        if ($event['isdx'] == 0) {//同一账号不允许购买多套 
            $id = $ids;
            if (empty($id) || $id == 0) {
                $this->error('房间ID不能为空，请确认后重试!');
            }
            //获取房间信息
            $room = $eventOrderHouseModel->getRoomByRedisKey("event_order_house_{$eventId}_room_{$id}");
            if (empty($room)) {
                $this->error('该房间没有参加活动!');
            }
            //房间是否已出售
            $isRoomOrdered = $redis->sIsMember("event_order_house_{$eventId}_room_ordered", $id);
            if ($isRoomOrdered) {
                if (empty($room['schedule_phone'])) {
                    $this->error('房间已被认购!');
                } else {
                    if ($room['schedule_phone'] != $phone)
                        $this->error('房间已被认购!');
                }
            }
            //用户只能购买一套  
            $isMemberOrdered = $redis->sIsMember("event_order_house_{$eventId}_room_order_phone", $phone);
            if ($isMemberOrdered) {
                $this->error('每人最多购买一套!');
            }
            $ygrooms = $redis->hGetAll("event_order_house_{$eventId}_room_order_member");
            if (count($ygrooms) > 0) {
                foreach ($ygrooms as $ygroom) {
                    $oldroom = $redis->hGetAll("event_order_house_{$eventId}_room_{$ygroom}");
                    if ($oldroom['schedule_phone'] == $phone) {
                        if ($room['id'] != $oldroom['id']) {
                            $roomname = $oldroom['buildname'] . "-" . $oldroom['unit'] . "单元-" . $oldroom['floor'] . "层-" . $oldroom['room'];
                            //$this->error('请选择预定房源：'.$roomname);
                            $this->error('抢购失败，请选择其他房源！');
                        }
                    }
                }
            }
            //如果status 1 返回错误 设置set锁
            if ($room['status'] === 1) {
                if (empty($room['schedule_phone'])) {
                    $redis->set("event_order_house_{$eventId}_room_{$id}_locked", 1, $expire_time);
                    $this->error('房间已被认购!');
                } else {
                    if ($room['schedule_phone'] != $phone) {
                        $redis->set("event_order_house_{$eventId}_room_{$id}_locked", 1, $expire_time);
                        $this->error('房间已被认购!');
                    }
                }
            }

            $getLock = 0;
            //如果status 0 就行修改
            if (empty($room['status'])) {
                $getLock = $redis->setnx("event_order_house_{$eventId}_room_{$id}_locked", 1);
            } else {
                if (!empty($room['schedule_phone']) && $room['schedule_phone'] == $phone)
                {
                     $redis->setnx("event_order_house_{$eventId}_room_{$id}_locked", 1);
                     $getLock=1;
                }
            }

            //setnx 进行锁定 10s 没有 获得锁 返回错误
            if ($getLock) {
                $redis->expire("event_order_house_{$eventId}_room_{$id}_locked", 10);
            } else {
                $this->error('请稍后重试！');
            }
            
            while(true){
                $isLock = $redis->set("event_order_house_{$eventId}_maxcode_locked", 1, 1);
                if ($isLock) {
                      $maxcode = $redis->get("event_order_house_{$eventId}_maxcode") + 1;
                      $redis->set("event_order_house_{$eventId}_maxcode", $maxcode);
                      $redis->del("event_order_house_{$eventId}_maxcode_locked");
                      break;
                }else {
                    usleep(5000); //睡眠，降低抢锁频率，缓解redis压力
                }
            }
            
            /*$maxcode = $redis->get("event_order_house_{$eventId}_maxcode") + 1;
            $redis->set("event_order_house_{$eventId}_maxcode", $maxcode);*/
            if ($maxcode < 1000)
                $newmaxcode = '0' . $maxcode;
            if ($maxcode < 100)
                $newmaxcode = '00' . $maxcode;
            if ($maxcode < 10)
                $newmaxcode = '000' . $maxcode;

            $order_id = time() + rand(1000, 9999);
            if ($eventId < 10)
                $hdcode = substr('0' . $eventId, -2);
            else
                $hdcode = substr($eventId, -2);

            $obj = null;
            //写入mysql try catch
            if ($getLock) {
                $obj = array(
                    'event_id' => $eventId
                    , 'event_name' => $event['name']
                    , 'company_id' => $room['company_id']
                    , 'project_id' => $room['project_id']
                    , 'project_name' => $room['project_name']
                    , 'batch_id' => $room['batch_id']
                    , 'batch_name' => $room['batch_name']
                    , 'build_id' => $room['build_id']
                    , 'build_name' => $room['buildname']
                    , 'unit_no' => $room['unit']
                    , 'floor_no' => $room['floor']
                    , 'room_id' => $id
                    , 'room_no' => $room['no']
                    , 'room_room' => $room['room']
                    , 'belong_openid' => $this->get_wx_open_id()
                    , 'belong_real_name' => session("realName")
                    //,'belong_gender'=> $user_info['sex']
                    , 'belong_phone' => $phone
                    , 'belong_uid' => session("chooseuid")
                    //,'code'=> sprintf('%02s',$room['build_id']).sprintf('%02s',$room['unit']).sprintf('%02s',$room['floor']).$room['no'].sprintf('%06s',rand(0,999999))
                    //,'code'=> date("mdh",time()).$eventId.$id
                    , 'code' => $newmaxcode
                    //, 'log_time' => $this->getMillisecond()
                    , 'log_time' => time()
                    , 'is_checked' => 0
                    , 'order_id' => date('Ymd') . $hdcode . $order_id
                );
                $orderHouseOrderModel = D('OrderHouseOrder');
                try {
                    $redis->set("event_order_house_{$eventId}_room_{$id}_locked", 1, $expire_time);
                    $redis->hSet("event_order_house_{$eventId}_room_{$id}", 'status', 1);
                    //添加已认购的房间
                    $redis->sAdd("event_order_house_{$eventId}_room_ordered", $id);
                    //添加已经购买的人员
                    $redis->sAdd("event_order_house_{$eventId}_room_order_phone", $phone);
                    
                    //$redis->hSet("dlsx_order_house_{$eventId}_{$cphone}", 'yrgcount', $yrgcount + 1);
                    $orderHouseOrderModel->startTrans();
                    $oid = $orderHouseOrderModel->add($obj);
                    $roomd = D('Room');
                    $datar["is_xf"] = 1;
                    $datar["cstid"] = session("chooseuid");
                    $datar["xftime"] = time();
                    $datar["cstname"] = $obj['belong_real_name'];
                    $roomd->where('id=' . $id)->save($datar);
                    $orderHouseOrderModel->commit();
                } catch (\Exception $e) {
                    $redis->del("event_order_house_{$eventId}_room_{$id}_locked");
                    $redis->hSet("event_order_house_{$eventId}_room_{$id}", 'status', 0);
                    $redis->sRem("event_order_house_{$eventId}_room_ordered", $id);
                    $redis->sRem("event_order_house_{$eventId}_room_order_phone", $phone);
                    //$redis->hSet("dlsx_order_house_{$eventId}_{$cphone}", 'yrgcount', $yrgcount);
                    $orderHouseOrderModel->rollback();
                    $this->error('请稍后重试！');
                }
            }

            $orderedRooms = $eventOrderHouseModel->getAllOrderedRoomInRedis($eventId);
            $orderedRooms = empty($orderedRooms) ? [] : $orderedRooms;
            $this->success(['预购成功', $obj['code'], $orderedRooms,   encrypt_url("eventId/{$eventId}/oid/{$oid}", getUrlkey())]); 
        } else {//允许购买多套
        }
    }
    
    /**
     * 微信认购登录页面
     */
    public function privilege() {
        $eventId = $this->getEventId();
  
        $eventOrderHouseModel = D('Common/EventOrderHouse');
        $event = $eventOrderHouseModel->getOneById($eventId);
        $where = [
            'fields' => '*'
            , 'where' => [
                'id' => $event['project_id']
                , '2=2'
            ]
        ];

        $project = M('project');
        $proj = $project->find($where);
        $this->assign('projname', $proj['name']);
        $this->assign('event', $event);

        unset($where);
        $where = [
            'fields' => '*'
            , 'where' => [
                'id' => $eventId
                , '3=3'
            ]
        ];
        $eventinfo = M('event_order_house')->find($where);
        $this->assign('desc', $eventinfo['desc']);
        $this->display();
    }

    /**
     * 微信认购 短信发送页面
     */
    public function send_sms_code() {
        if (!IS_AJAX) {
            $this->error('请求错误，请确认后重试');
        }

        $phone = I("post.phone", 0);
        
        $eventId = $this->getEventId();
        
        if (empty($eventId)) {
            $this->error('系统错误!');
        }
        if (empty($phone)) {
            $this->error('请填写手机号码');
        }
        if (empty($phone) || strlen($phone) != 11) {
            $this->error('请填写正确的手机号码');
        }
        $event = D('Common/EventOrderHouse')->getOneById($eventId);
        if ($event['states'] < 1) {
            $this->error('活动尚未开始，敬请期待');
        }
        $jmphone=rsa_encode($phone,getChoosekey());//加密
        $where = ['project_id' => $event['project_id'], 'batch_id' => $event['batch_id'], 'customer_phone' => $jmphone];

        $chooseinfo = D('Common/choose')->field('customer_name,id,status,ys_time')->where($where)->find();

        if (empty($chooseinfo['customer_name'])) {
            $this->error('你还未参与此活动');
        }
        if ($event['isysdl'] == 1) {//是否启用延时登录验证
            if ($chooseinfo['status'] < 1 || $event['start_time'] + (int) ($chooseinfo['ys_time']) * 60 > time()) {
                $this->error('你暂时无权参与此活动');
            }
        } else {
            if ($chooseinfo['status'] < 1) {
                $this->error('你暂时无权参与此活动');
            }
        }
        $realName = $chooseinfo['customer_name'];

        $redisDriver = new Redis();

        if ($redisDriver->get("dlsx_order_house_{$eventId}_{$phone}_code") && cookie('order_house_code')) {
            $this->error('5分钟内不用重复获取');
        }

        $code = sprintf("%6s", rand(100000, 999999));
        //阿里短信服务
        if ($event['is_short_message'] < 1) {
            $status1 = true;
        }else{
            $sms = new Alisms();
            $status1 = $sms->send_verify($phone, $code);
			  }
        if ($status1) {
            cookie("order_house_code", $code,300);
            cookie('phone', $jmphone);
            cookie("realName", $realName);
            cookie("chooseuid", $chooseinfo['id']);
            $redisDriver->set("dlsx_order_house_{$eventId}_{$phone}_code", 1, 300 * 1);

            $redisDriver->hSet("dlsx_order_house_{$eventId}_{$phone}", 'sid', session_id());
            //客户购买房源个数控制
            //$redisDriver->hSet("dlsx_order_house_{$eventId}_{$phone}",'maxcount',$chooseinfo['maxcount']);
            $redisDriver->hSet("dlsx_order_house_{$eventId}_{$phone}", 'maxcount', 3);
            $redisDriver->expire("dlsx_order_house_{$eventId}_{$phone}", 60 * 60 * 6);
	          if ($event['is_short_message'] < 1) {
                $this->success($code);
            }else{
                $this->success('验证码发送中，请稍等...');
            }				
        } else {
            $this->error($sms->error);
        }
    }

    /**
     * 微信认购 检查权限页面
     */
    public function check() {
        if (!IS_AJAX) {
            $this->error('请求错误，请确认后重试！');
        }
        $phone = I('post.phone', 0);
        $code = I('post.code', 0);
        $eventId=$this->getEventId();
        if (empty($eventId)) {
            $this->error('系统错误');
        }
        $event = D('Common/EventOrderHouse')->getOneById($eventId);
        if ($event['states'] < 1) {
            $this->error('活动尚未开始，敬请期待');
        }
        if (empty($phone)) {
            $this->error('请填写手机号码');
        }
        if (strlen($phone) != 11) {
            $this->error('请填写正确的手机号码');
        }
        $jmphone=rsa_encode($phone,getChoosekey());//加密
        if (cookie('phone') != $jmphone || empty(cookie('order_house_code'))) {
            $this->error('请先获取验证码');
        }
        if (empty($code)) {
            $this->error('请填写验证码');
        }
        $redisDriver = new Redis();
        $loginerror = $redisDriver->get("order_house_{$phone}_loginerror");

        if (!$loginerror) {
            $loginerror = 0;
        }

        if ($loginerror >= 5) {
            //$event = D('Common/EventOrderHouse')->getOneById($eventId);
            $data1["status"] = 0;
            D("Choose")->where("customer_phone=" . $jmphone . " and project_id=" . $event['project_id'] . " and batch_id=" . $event['batch_id'])->save($data1);
            $this->error('账号锁定，6小时内不能登录');
        }
        if ($code != cookie('order_house_code') && cookie('phone') == $jmphone) {
            $loginerror = $loginerror + 1;
            $redisDriver->set("order_house_{$phone}_loginerror", $loginerror, 60 * 60 * 6);
            $this->error('请填写正确的验证码');
        }

        $orderHousePhoneModel = D('Common/OrderHousePhoneLogin');
        $data = [
            'event_id' => $eventId
            , 'phone' => $jmphone
            , 'customer_id' => cookie("chooseuid")
            , 'logintime' =>time()
            , 'logip'=>$this->getIP()
        ];
        $order_house_code=cookie('order_house_code');
        $redisDriver->del("order_house_{$phone}_loginerror");
        try{
            session('privilege', 1);
            session("phone", cookie('phone'));
            session("realName", cookie("realName"));
            session("chooseuid", cookie("chooseuid"));
            cookie('order_house_code', NULL);
            $redisDriver->hSet("dlsx_order_house_{$eventId}_{$phone}", 'status', 1);
            $orderHousePhoneModel->startTrans();
            $orderHousePhoneModel->add($data);
            $orderHousePhoneModel->commit();
        }  catch (\Exception $e) {
            session('privilege', 0);
            session("phone", NULL);
            session("realName", NULL);
            session("chooseuid", NULL);
            cookie('order_house_code', $order_house_code,300);
            $orderHousePhoneModel->rollback();
            $this->error('登录失败，请重试！');
        }
        $this->success("验证成功",__CONTROLLER__."/index/info/".cookie('eventId'));
    }

    //当前时间戳(包含毫秒)
    public function getMillisecond() {
        list($s1, $s2) = explode(' ', microtime());
        return (float) sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000);
    }

    //单独获取活动倒计时(包含毫秒)
    public function geteventdjs() {
        if (!IS_AJAX)
            $this->error('请求错误，请确认后重试！');

        $id = I('id', 0, 'intval');
        $eventOrderHouseModel = D('Common/EventOrderHouse');
        //$event = $eventOrderHouseModel->getEventByEventId(geturl($id, getUrlkey())["eventId"]);
        $event = $eventOrderHouseModel->getEventByEventId($this->getEventId());
        $dqhm = $this->getMillisecond();
        if ($dqhm < $event['start_time'] * 1000) {//活动未开始时，返回活动开始倒计时time和整个活动时长time1
            $time = $event['start_time'] * 1000 - $dqhm;
            $time1 = $event['end_time'] - $event['start_time'];
            $djsinfo['iswks'] = 1;
            $djsinfo['time1'] = $time1;
        } else {//活动已开始，返回的time和time1一样
            if ($dqhm > $event['end_time'] * 1000) {
                $time = 0;
            } else {
                $time = $event['end_time'] * 1000 - $dqhm;
            }
            $djsinfo['iswks'] = 0;
            $djsinfo['time1'] = $time;
        }
        $djsinfo['time'] = $time;
        $this->success(['成功', $djsinfo]);
    }
    public function logout() {
        $eid=cookie('eventId');
        if (empty($eid))
        {
            $eid = I('info', 0, 'trim');
        }
        $jmphone= cookie('phone');
        session_unset();
        session_destroy();
        cookie('order_house_code', NULL);
        cookie('phone', NULL);
        cookie('realName', NULL);
        cookie('chooseuid', NULL);
        cookie('eventId', NULL);
        cookie('first_vist', NULL);
        cookie('user_id', NULL);
        
        $orderHousePhoneModel = D('Common/OrderHousePhoneLogin');
        $eventId=  geturl($eid, getUrlkey())["eventId"];
        if(!$eventId) $eventId=0;
        if(!$jmphone) $jmphone=0;
        $onelog=$orderHousePhoneModel->where('event_id='.$eventId ." and phone='". $jmphone ."'")->order("id desc")->find();
        if($onelog)
        {
            $data["logouttime"]=time();
            $orderHousePhoneModel->where('id='.$onelog['id'])->save($data);
        }

        $this->redirect("privilege", ['info' => $eid]);
    }
}
