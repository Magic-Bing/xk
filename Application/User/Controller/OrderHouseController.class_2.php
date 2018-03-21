//源程序前30页
<?php
namespace Account\Controller;
use Common\Controller\BaseController as CommonBaseController;                                                                                                
/**
 * 基础控制器
 *
 * @create 2016-12-22
 * @author zlw
 */
class BaseController extends CommonBaseController 
{
    /**
     * 系统构造函数
     *
     * @create 2016-12-22
     * @author zlw
     */
    public function _initialize() 
	{
        parent::_initialize();
		
		//网站名称
		$this->set_website();
		
		//验证登录
		$this->check_login();
		
		//用户信息
		$this->set_user_info();
		//获取指定的模块
        $this->get_choose_fun();
		
		//未读竞价记录
		//$this->log_noread_count();
    }


    public function error_page()
    {
        $this->error('没有权限进入该页面！','/index/index');
    }
    /**
     * 空方法
     *
     * @create 2016-12-23
     * @author zlw
     */
    public function _empty() 
	{
        $this->error('方法不存在！');
    }
	
	/**
	 * 判断是否已经登录
	 *
     * @create 2016-12-23
	 * @author zlw
	 */
    protected function check_login() 
	{
		if (!session('?ACCOUNT_ID')) {
                    //$this->error('你还没有登录，正在跳转到登录页面', U('login/index'));
            redirect(U('../login/index'),0);
		}else{
		  $id=session('ACCOUNT_ID');
		  $pd=M()->table("xk_user")->where("id=$id")->find();
		  if(!$pd){
              session('ACCOUNT_ID', null);
              redirect(U('../login/index'),0);
          }
        }
    }	
	
	/**
	 * 设置网站名称
	 *
     * @create 2016-12-23
	 * @author zlw
	 */
    protected function set_website($website = '') 
	{
		if (empty($website)) {
			$website = '云销控管理系统';
		}
		$this->assign('website', $website);
    }	
	
    /**
     * 设置用户信息
     *
     * @create 2016-12-23
     * @author zlw
    */
    protected function set_user_info($user_info = '') 
    {
            if (empty($user_info)) {
                    $user_id = $this->get_user_id();

                    $where['id'] = $user_id;
                    $where[]="9933=9933";
                    $user = D("User")->getOne($where);
                    if (empty($user)) {
                            $this->set_logout();

                            $this->error('用户不存在，请稍后重试！', U('login/index'));
                    }
                    $user_info = $user;
            }
            $this->assign('user_info', $user_info);
    }	

    /**
     * 是否登录
     *
     * @create 2016-12-23
     * @author zlw
     */
    protected function is_login() 
	{
        if (session('?ACCOUNT_ID')) {
            return $this->get_user_id();
        } else {
            return false;
        }
    }

    /**
     * 获取登录ID
     *
     * @create 2016-12-23
     * @author zlw
     */
    protected function get_user_id() 
    {
        return session('ACCOUNT_ID');
    }
    
     /**
     * 获取登录用户类型
     *
     * @create 2016-12-23
     * @author zlw
     */
    protected function get_user_type() 
    {
        return session('ACCOUNT_TYPE');
    }
    

	/**
	 * 设置退出
	 *
     * @create 2016-12-23
	 * @author zlw
	 */
    protected function set_logout() 
	{
		session('ACCOUNT_ID', null);
                session('ACCOUNT_TYPE', null);
	}

	/**
	 * 未读取的竞价记录
	 *
     * @create 2016-12-30
	 * @author zlw
	 */
    protected function log_noread_count() 
	{
		//用户的项目和项目批次
		$user_project_ids = $this->get_user_project_ids();
		$user_batch_ids = $this->get_user_batch_ids();
		
		if (!empty($user_project_ids) && !empty($user_project_ids)) {
			$log_noread_count = D('ChooselogView')->getNoreadLogCount($user_project_ids, $user_batch_ids);
		} else {
			$log_noread_count = 0;
		}
		
		$this->assign('log_noread_count', $log_noread_count);
	}
	/*=====================获取用户有权限查看的模块======================*/
    protected  function get_choose_fun(){
        //当前用户ID
        $model=M();
        $user_id = $this->get_user_id();
        $pd=$model->table("xk_user")->field("is_all")->where("id=$user_id")->find();
        if((int)$pd['is_all'] ===1) {
            $fun = $model->table("xk_fun")->where("is_fun=1")->order("px ASC")->select();
            $this->assign("fun", $fun);
        }else{
            $fun=$model->table("xk_station2user su")->field("f.*")->join("xk_fun_station fs on fs.station_id=su.station_id")->join("xk_fun f on f.id=fs.fun_id")->where("su.userid=$user_id and f.is_fun=1")->order("f.px ASC")->select();

            $this->assign("fun", $fun);
        }
    }
	/*#----------- 设置左侧导航信息 ---------------#*/

	/**
	 * 设置组名称
	 *
     * @create 2016-12-27
	 * @author zlw
	 */
    protected function set_group_name($name = '') 
	{
		$this->assign('group_name', $name);
	}

	/**
	 * 设置组方法
	 *
     * @create 2016-12-27
	 * @author zlw
	 */
    protected function set_group_action($action = '', $group = '') 
	{
		$group_action_list = array();
		if (!is_array($action)) {
			$group_action_list[] = $action;
		} else {
			$group_action_list = $action;
		}
		
		if (!empty($group)) {
			$group_action[$group] = $group_action_list;
		} else {
			$group_action = $group_action_list;
		}
		
		$this->assign('group_action', $group_action);
	}
        
        
	/**
	 * 设置当前方法
	 *
     * @create 2016-12-27
	 * @author zlw
	 */
    protected function set_now_action($now_action = '') 
	{
		$this->assign('now_action', $now_action);
	}

	/**
	 * 设置方法
	 *
     * @create 2016-12-27
	 * @author zlw
	 */
    protected function set_current_action($action = '', $group = '') 
	{
		$this->set_group_action($action, $group);
		$this->set_now_action($action);
	}
	
	/*#----------- 用户项目信息 ---------------#*/
	
	/**
	 * 获取用户的项目
	 *
     * @create 2016-12-26
	 * @author zlw
	 */
//    protected function get_user_project()
//	{
//		//当前用户ID
//		$user_id = $this->get_user_id();
//		$is_all=M("user")->field("is_all")->where("id=$user_id")->find();
////		echo json_encode($is_all);exit;
//		//当前用户的项目
//		$StationrelevanceView = D("StationrelevanceView");
//		if($is_all['is_all']!=1){
//            $user_project_where['station2user_user_id'] = $user_id;
//        }
//		$user_project_where['Project.status'] = 1;
//		$user_project_list = $StationrelevanceView->getList($user_project_where);
//		//用户的相关项目和批次
////        echo json_encode($user_project_list);exit;
//		$user_project_ids = array();
//		$user_batch_ids = array();
//		if (!empty($user_project_list)) {
//			foreach ($user_project_list as $user_project) {
//				$user_project_ids[$user_project['project_id']] = $user_project['project_id'];
//				$user_batch_ids[$user_project['batch_id']] = $user_project['batch_id'];
//			}
//		} else {
//			$user_project_ids = array('-99999');
//			$user_batch_ids = array('-99999');
//		}
//		$user_projects = array(
//			'user_project_ids' => $user_project_ids,
//			'user_batch_ids' => $user_batch_ids,
//			'user_project_list' => $user_project_list,
//		);
////		echo json_encode($user_projects);exit;
//		return $user_projects;
//	}
    protected function get_user_project()
    {
        //当前用户ID
        $user_id = $this->get_user_id();
        $model=M();
        $is_all=$model->table("xk_user")->field("is_all")->where("id=$user_id")->find();
        $user_project_ids = [];
        $user_batch_ids = [];
        if((int)$is_all['is_all']===1) {
            $pids = $model->table("xk_project")->field("id")->select();
            for ($i = 0; $i < count($pids); $i++) {
                $user_project_ids[$pids[$i]['id']] = $pids[$i]['id'];
            }
            $kids = $model->table("xk_kppc")->field("id")->select();
            for ($i = 0; $i < count($kids); $i++) {
                $user_batch_ids[$kids[$i]['id']] = $kids[$i]['id'];
            }
        }else{
            $res=$model->table("xk_station2user su")->field("sp.proj_id pid,k.id kid")->
                join("xk_station2proj sp ON sp.station_id=su.station_id")->
                join("xk_kppc k ON k.proj_id=sp.proj_id")->where("su.userid=$user_id")->select();
            foreach ($res as $user_project) {
				$user_project_ids[$user_project['pid']] = $user_project['pid'];
				$user_batch_ids[$user_project['kid']] = $user_project['kid'];
			}

        }
        if(!$user_project_ids){
            $user_project_ids = array('-99999');
            $user_batch_ids = array('-99999');
        }
        $user_projects = array(
            'user_project_ids' => $user_project_ids,
            'user_batch_ids' => $user_batch_ids,
        );
//		echo json_encode($user_projects);exit;
        return $user_projects;
    }
	
        /**
	 * 获取用户的公司权限列表
	 *
        * @create 2016-12-26
	 * @author zlw
	 */
        protected function get_user_company() 
	{	
                $user_id = $this->get_user_id();
                $where['id'] = $user_id;
                $where[]="9933=9933";
                $user = D("User")->getOne($where);
                $Model = new \Think\Model();
                unset($where);
                //超级管理员获取全部的公司
                if ($user['is_all']==1)
                {
                    $companys=$Model->query("SELECT b.name as compname,b.id FROM xk_company b  order by b.id" );
                }
                else
                {
                    $companys=$Model->query("SELECT b.name as compname,b.id FROM xk_user a left join xk_company b on a.cp_id=b.id  where a.id=" . $user_id . " and 888=888 order by b.id" );
                }
                return $companys;
	}	
      
        
	/**
	 * 获取用户的项目ID列表
	 *
     * @create 2016-12-26
	 * @author zlw
	 */
    protected function get_user_project_ids() 
	{	
		$user_project_list = $this->get_user_project();
		return $user_project_list['user_project_ids'];
	}	
	
	/**
	 * 获取用户的项目批次ID列表
	 *
     * @create 2016-12-26
	 * @author zlw
	 */
    protected function get_user_batch_ids() 
	{	
		$user_project_list = $this->get_user_project();
		return $user_project_list['user_batch_ids'];
	}	
	
	/**
	 * 获取用户的项目列表
	 *
     * @create 2016-12-26
	 * @author zlw
	 */
    protected function get_user_project_list() 
	{	
		$user_project_list = $this->get_user_project();
		return $user_project_list['user_project_list'];
	}	
	
	//获取ip
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

namespace Account\Controller;

use Think\Exception;
use Think\Upload as Upload;
use Lookey\Web\Excel as Excel;
use Think\Cache\Driver\Redis;

/**
 * 竞价选房
 *
 * @create 2016-12-26
 * @author zlw
 */
class ChooseUserController extends BaseController {

    /**
     * 系统构造函数
     *
     * @create 2016-12-26
     * @author zlw
     */
    public function _initialize() {
        parent::_initialize();

        //分类名称
        $this->assign('classify_name', '客户信息');

        //设置当前方法
        $this->set_current_action('choose_user', '111');
    }

    /**
     * 客户信息
     *
     * @create 2016-12-26
     * @author zlw
     */
    public function index() {
//        if(!IS_POST){
//            $this->error("错误的操作方法！");
//        }
//        echo json_encode($_POST);exit;
        //项目ID
        if(isset($_POST['project_id'])){
            $search_project_id = I('project_id', 0, 'intval');
            session("selected_project",$search_project_id);
        }else{
            $search_project_id = session("selected_project");
        }

        $zt = I('zt', 0, 'intval');
        $status = I('status', '', 'trim');
        $search_batch_id = I('batch_id', 0, 'intval');
        $search_word = I('word', '', 'trim');
        $search_uid = I('uid', 0, 'intval');
        $this->assign('bid', $search_batch_id);

        //当前用户的项目
        $user_project_ids = $this->get_user_project_ids();
        if (empty($user_project_ids)) {
            $user_project_ids = array('-99999');
        } else {
            if (empty($search_project_id)) {
                //$search_project_id=$user_project_ids[0];
            }
        }
        //设置当前搜索
        $search = array(
            'search_project_id' => $search_project_id,
            'search_word' => $search_word,
        );
        $this->assign($search);
        //项目
        $Project = D('Common/Project');
        //获取当前项目
        $project_info = $Project->getProjectById($search_project_id);
        //当前用户ID
        $user_id = $this->get_user_id();
        if ($search_project_id != 0) {
            if (!in_array($search_project_id, $user_project_ids)) {
                $this->error("你没有权限访问该项目的信息！");
            }
        }

        //获取项目列表
        $project_where = array();
        $project_where['status'] = 1;
        $project_where['id'] = array('in', $user_project_ids);
        $project_old_list = D('Common/ProjectView')->getList($project_where, 'company_id DESC, id DESC', '50');
        if (!empty($project_old_list)) {
            foreach ($project_old_list as $project_list_key => $project_list_value) {
                $project_list[$project_list_value['id']] = $project_list_value;
            }
        } else {
            $project_list = array();
        }
        $this->assign('project_list', $project_list);

        //用户的项目批次
        $user_batch_ids = $this->get_user_batch_ids();

        //批次
        if (!empty($user_batch_ids)) {
            $user_batch_where['id'] = array('in', $user_batch_ids);
        } else {
            $user_batch_where['id'] = '-99999';
        }
        $user_batch_where['proj_id'] = $search_project_id;
        $batch_list = D('Batch')->getList($user_batch_where, '*');
        $this->assign('batch_list', $batch_list);

        //用户信息视图
        $ChooseView = D('Common/ChooseView');

        //条件
        $choose_where = array();
        if (!empty($search_project_id)) {
            $choose_where['project_id'][] = $search_project_id;
        } else {
            //项目条件
            if (!empty($user_project_ids)) {
                $choose_where['project_id'][] = array('in', $user_project_ids);
            } else {
                $choose_where['project_id'][] = '-99999';
            }
        }


        if (!empty($search_batch_id)) {
            $choose_where['batch_id'][] = $search_batch_id;
        } else {
            //批次条件
            if (!empty($user_batch_ids)) {
                $choose_where['batch_id'] = array('in', $user_batch_ids);
            } else {
                $choose_where['batch_id'] = '-99999';
            }
        }

        //选房状态
        if (!empty($zt)) {
            if ($zt == 1) {
//                $choose_where=array("room_id"=>array("IS NOT"=>NULL));
                $choose_where["rm1.id"] = array('exp', 'is not null');
            } else {
//                $choose_where= array("room_id"=>array("IS"=>NULL));
                $choose_where["rm1.id"] = array('exp', 'is null');
            }
        }

        if ($status !== "") {
//            echo $status;exit;
            $choose_where['status'] = (int) $status;
        }
        if (!empty($search_uid)) {
            if ($search_uid === 1) {
                $choose_where["us.id"] = array('exp', 'is null');
            }
        }
        $this->assign('zt', $zt);
        $this->assign('status', $status);
        $this->assign('search_uid', $search_uid);

        //搜索查询
        if (!empty($search_word)) {
            $choose_like_where['choose.customer_name'] = array('like', '%' . $search_word . '%');
            $choose_like_where['choose.like_p'] = array('like', '%' . strencode($search_word) . '%');
            $choose_like_where['choose.cyjno'] = array('like', '%' . $search_word . '%');
            $choose_like_where['choose.like_c'] = array('like', '%' . strencode($search_word) . '%');
            $choose_like_where['_logic'] = 'or';
            $choose_where['_complex'] = $choose_like_where;
        }

        //总数
        $choose_count = $ChooseView->where($choose_where)->count();
        $listRows = I('r', 10, 'intval');
        //分页
        $Page = $this->bootstrapPage($choose_count, $listRows);
        $page_show = $Page->show();
        $total_pages = $Page->totalPages;

        //取范围
        $limit = $Page->firstRow . ',' . $Page->listRows;
        $choose_list = $ChooseView->getList(
                $choose_where, '*', 'project_id desc,batch_id desc,status desc ,id ASC', $limit
        );
        $p = I('p', '1', 'intval');
        $this->assign('p', $p);
        $this->assign('total_pages', $total_pages);
        $this->assign('choose_count', $choose_count);
        $this->assign('page_show', $page_show);
        $this->assign('listRows', $listRows);

        $this->assign('choose_list', $choose_list);

        $this->set_seo_title("客户信息");
        
        $this->display();
    }

    //修改单个状态
    public function updateStatus() {
        $status = I("status", 0, "intval");
        $id = I("id", 0, "intval");
        
        if(empty($id))
        {
            echo '客户信息错误！';
            exit;
        }
        
        $choose=D("Choose");
        $cstinfo=$choose->find($id);
        if(empty($cstinfo))
        {
            echo '客户信息错误！';
            exit;
        }
        $event = M()->table("xk_event_order_house")
                    ->where("states=1 and project_id={$cstinfo['project_id']} and batch_id={$cstinfo['batch_id']} and unix_timestamp(now())<= end_time and unix_timestamp(now())>=start_time")
                    ->find();
        $phone= rsa_decode($cstinfo['customer_phone'],getChoosekey());     
        if($event)
        {
            try{
                $redis = new Redis();
                $redis->hSet("dlsx_order_house_{$event['id']}_{$phone}", 'status', $status); 
                $choose->startTrans();
                $res = $choose->where("id=$id")->save(["status" => $status]);
                $choose->commit();
            }
            catch (\Exception $e) {
                $redis->hSet("dlsx_order_house_{$event['id']}_{$phone}", 'status', $cstinfo['status']); 
                $choose->rollback();
                echo false;
                exit;
            }
            echo true;
            exit;
        }
        else
        {
            $res = $choose->where("id=$id")->save(["status" => $status]);
            echo $res ? "true" : "false";
            exit;
        }
        
    }

    /**
     * 添加
     *
     * @create 2016-12-26
     * @author zlw
     */
    public function add() {
        if (IS_AJAX) {
            $name = I('name', 0, 'trim');
            $project_id = I('project_id', 0, 'intval');
            $batch_id = I('batch_id', 0, 'intval');
            $customer_name = I('customer_name', '', 'trim');
            $customer_phone = I('customer_phone', '', 'trim');
            $cardno = I('cardno', '', 'trim');
            $cyjno = I('cyjno', '', 'trim');
            $row_number = I('row_number', 0, 'intval');
            $money = I('money', 0, 'trim');
            $ys_time = I('ys_time', 0, 'intval');
            /* $area = I('area', 0, 'trim');
              $price = I('price', 0, 'trim');
              $house_type = I('house_type', '', 'trim');
              $floor = I('floor', '', 'trim'); */
            $room = I('room', '', 'trim');
            $ywy = I('ywy', '', 'trim');
            $ywyphone = I('ywyphone', '', 'trim');
            //$password = I('password', '', 'trim');
            $remark = I('remark', '', 'trim');
            $status = I('status', '', 'trim');

            if ($project_id == 0 || empty($customer_name) || empty($customer_phone) || empty($cyjno)
            ) {
                $this->error("信息不能为空，请确认后重试！");
            }

            //if (!is_phone_number($customer_phone)) {
            if (empty($customer_phone)) {
                $this->error("客户手机号码错误，请确认后重试！");
            }

            $user_project_ids = $this->get_user_project_ids();
            if (!in_array($project_id, $user_project_ids)) {
                $this->error("项目错误，请选择正确的项目！");
            }

            $Choose = D('Choose');
            $pd = $Choose->where("project_id=$project_id AND batch_id=$batch_id AND (customer_phone=$customer_phone OR cardno='$cardno' OR cyjno='$cyjno')")->find();
            if ($pd) {
                $this->error("电话或者身份证或者诚意金编号已存在，请修改后再提交！");
            }
            $data['name'] = $name;
            $data['project_id'] = $project_id;
            $data['batch_id'] = $batch_id;
            $data['customer_name'] = $customer_name;
            $data['customer_phone'] = rsa_encode($customer_phone, getChoosekey());
            $data['cardno'] = rsa_encode($cardno, getChoosekey());
            $data['like_p'] = strencode($customer_phone);
            $data['like_c'] = strencode($cardno);
            $data['cyjno'] = $cyjno;
            $data['row_number'] = $row_number;
            $data['money'] = $money;
            $data['ys_time'] = $ys_time;
            /* $data['area'] = $area;		
              $data['price'] = $price;
              $data['house_type'] = $house_type;
              $data['floor'] = $floor; */
            $data['room'] = $room;
            $data['ywy'] = $ywy;
            $data['ywyphone'] = $ywyphone;
            //$data['password'] = $password;
            $data['remark'] = $remark;
            $data['status'] = 1;
            $data['add_time'] = time();
            $data['add_ip'] = get_client_ip(0, true);
            $chech_has_add = $Choose->addOne($data);
            if (false === $chech_has_add) {
                $this->error("添加失败，请稍后重试！");
            } else {
                $this->success("恭喜你，添加成功！", '');
            }
        } else {
            //项目ID
            $project_id = session("selected_project");
            $this->assign('project_id', $project_id);

            //用户的项目和项目批次
            $user_project_ids = $this->get_user_project_ids();
            $user_batch_ids = $this->get_user_batch_ids();

            //获取项目列表
            $project_where = array();
            if (!empty($user_project_ids)) {
                $project_where['id'] = array('in', $user_project_ids);
            } else {
                $project_where['id'] = '-99999';
            }
            $project_old_list = D('Common/ProjectView')->getList($project_where, 'company_id ASC, id ASC', '50');
            if (!empty($project_old_list)) {
                foreach ($project_old_list as $project_list_key => $project_list_value) {
                    $project_list[$project_list_value['id']] = $project_list_value;
                }
            } else {
                $project_list = array();
            }
            $this->assign('project_list', $project_list);

            //批次
            if (!empty($user_batch_ids)) {
                $user_batch_where['id'] = array('in', $user_batch_ids);
            } else {
                $user_batch_where['id'] = '-99999';
            }
            $batch_list = D('Batch')->getList($user_batch_where, '*');
            $this->assign('batch_list', $batch_list);

            if (!empty($batch_list)) {
                foreach ($batch_list as $batch_list_key => $batch_list_value) {
                    $project_batch_list[$batch_list_value['proj_id']][] = array(
                        'n' => urlencode($batch_list_value['name']),
                        'v' => $batch_list_value['id'],
                    );
                }
            } else {
                $project_batch_list = array();
            }

            $project_new_list = array();
            if (!empty($project_old_list)) {
                foreach ($project_old_list as $project_old_list_key => $project_old_list_value) {
                    $project_new_list[] = array(
                        'n' => urlencode($project_old_list_value['company_name'] . '--' . $project_old_list_value['name']),
                        'v' => $project_old_list_value['id'],
                        's' => isset($project_batch_list[$project_old_list_value['id']]) ? $project_batch_list[$project_old_list_value['id']] : ''
                    );
                }
            }

            $project_json = urldecode(json_encode($project_new_list));
            $this->assign('project_json', $project_json);

            $this->set_seo_title('添加客户信息');
            $this->display();
        }
    }

    /**
     * 编辑
     *
     * @create 2016-12-26
     * @author zlw
     */
    public function edit() {
        if (IS_AJAX) {
            $id = I('id', 0, 'intval');
            $name = I('name', '', 'trim');
            $project_id = I('project_id', 0, 'intval');
            $batch_id = I('batch_id', 0, 'intval');
            $customer_name = I('customer_name', '', 'trim');
            $customer_phone = I('customer_phone', '', 'trim');
            $cardno = I('cardno', '', 'trim');
            $cyjno = I('cyjno', '', 'trim');
            $row_number = I('row_number', 0, 'intval');
            $money = I('money', 0, 'trim');
            $ys_time = I('ys_time', 0, 'intval');
            /* $area = I('area', 0, 'trim');
              $price = I('price', 0, 'trim');
              $house_type = I('house_type', '', 'trim');
              $floor = I('floor', '', 'trim'); 
            $room = I('room', '', 'trim');*/
            $ywy = I('ywy', '', 'trim');
            $ywyphone = I('ywyphone', '', 'trim');
            //$password = I('password', '', 'trim');
            $remark = I('remark', '', 'trim');
            $status = I('status', '', 'trim');

            if ($id == 0 || $project_id == 0 || empty($customer_name) || empty($customer_phone) || empty($cyjno)
            ) {
                $this->error("信息不能为空，请确认后重试！");
            }

            //if (!is_phone_number($customer_phone)) {
            if (empty($customer_phone)) {
                $this->error("客户手机号码错误，请确认后重试！");
            }

            $user_project_ids = $this->get_user_project_ids();
            if (!in_array($project_id, $user_project_ids)) {
                $this->error("项目错误，请选择正确的项目！");
            }

            $Choose = D('Choose');
            $pd = $Choose->where("project_id=$project_id AND batch_id=$batch_id AND id<>$id AND (customer_phone=$customer_phone OR cardno='$cardno' OR cyjno='$cyjno')")->find();
            if ($pd) {
                $this->error("电话或者身份证或者诚意金编号已存在，请修改后再提交！");
            }
            
            $where['id'] = $id;
            $data['name'] = $name;
            $data['project_id'] = $project_id;
            $data['batch_id'] = $batch_id;
            $data['customer_name'] = $customer_name;
            $data['customer_phone'] = rsa_encode($customer_phone, getChoosekey());
            $data['cardno'] = rsa_encode($cardno, getChoosekey());
            $data['like_p'] = strencode($customer_phone);
            $data['like_c'] = strencode($cardno);
            $data['cyjno'] = $cyjno;
            $data['row_number'] = $row_number;
            $data['money'] = $money;
            $data['ys_time'] = $ys_time;
            /* $data['area'] = $area;		
              $data['price'] = $price;
              $data['house_type'] = $house_type;
              $data['floor'] = $floor; 
            $data['room'] = $room;*/
            $data['ywy'] = $ywy;
            $data['ywyphone'] = $ywyphone;
            //$data['password'] = $password;		
            $data['remark'] = $remark;
            //$data['status'] = $status;
            $pds = $Choose->where("id=$id AND customer_phone='$customer_phone' AND cardno='$cardno' AND cyjno='$cyjno'")->find();
            $zy = $Choose->field("project_id,batch_id,customer_phone choose_phone,cardno choose_card,cyjno choose_cyjno")->where("id=$id")->find();
            $event = M()->table("xk_event_order_house")
                    ->where("states=1 and project_id={$zy['project_id']} and batch_id={$zy['batch_id']} and unix_timestamp(now())<= end_time and unix_timestamp(now())>=start_time")
                    ->find();
            
            if (!$pds) {
                $zy1['choose_phone'] = rsa_decode($zy['choose_phone'],  getChoosekey());
                $zy1['choose_card'] = rsa_decode($zy['choose_card'],  getChoosekey());
                $zy1['new_phone'] = $customer_phone;
                $zy1['new_card'] = $cardno;
                $zy1['new_cyjno'] = $cyjno;
                $zy1['choose_id'] = $id;
                $zy1['update_time'] = time();
                $zy1['update_ip'] = $this->getIP();
                $zy1['update_user'] = $this->get_user_id();
                M()->table("xk_update_choose_log")->add($zy1);
            }
            $chech_has_edit = $Choose->editOne($where, $data);
            if (false === $chech_has_edit) {
                $this->error("更改失败，请稍后重试！");
            } else {
                if ($data['status'] == 1 && $event) {
                    try {
                        $redisDriver = new Redis();
                        $redisDriver->del("order_house_{$data['customer_phone']}_loginerror");
                    } catch (Exception $e) {
                        
                    }
                }
                $oldphone=rsa_decode($zy['choose_phone'],  getChoosekey());
                if($customer_phone<>$oldphone && $event)
                {
                    try{
                        $redisDriver = new Redis();
                        $redisDriver->del("dlsx_order_house_{$event['id']}_{$oldphone}"); 
                    }catch (Exception $e) {
                        
                    }
                }
                $this->success("恭喜你，更改成功！", '');
            }
        } else {
            $id = I('id', 0, 'intval');
            if ($id == 0) {
                $this->error("信息不存在，请确认后重试！");
            }
            $this->assign('id', $id);

            //奖励信息
//            $Choose = D('Choose');

            $choose = M()->table("xk_choose c")->field("c.*,r.id rid")->join("LEFT JOIN xk_room r ON r.cstid=c.id")->where("c.id=$id")->find();
//            echo json_encode($choose);exit;
            if (empty($choose)) {
                $this->error("信息不存在，请确认后重试！");
            }

            $this->assign('choose', $choose);

            //用户的项目和项目批次
            $user_project_ids = $this->get_user_project_ids();
            $user_batch_ids = $this->get_user_batch_ids();

            //获取项目列表
            $project_where = array();
            if (!empty($user_project_ids)) {
                $project_where['id'] = array('in', $user_project_ids);
            } else {
                $project_where['id'] = '-99999';
            }
            $project_old_list = D('Common/ProjectView')->getList($project_where, 'company_id ASC, id ASC', '500');
            if (!empty($project_old_list)) {
                foreach ($project_old_list as $project_list_key => $project_list_value) {
                    $project_list[$project_list_value['id']] = $project_list_value;
                }
            } else {
                $project_list = array();
            }
            $this->assign('project_list', $project_list);

            //批次
            if (!empty($user_batch_ids)) {
                $user_batch_where['id'] = array('in', $user_batch_ids);
            } else {
                $user_batch_where['id'] = '-99999';
            }
            $batch_list = D('Batch')->getList($user_batch_where, '*');
            $this->assign('batch_list', $batch_list);

            if (!empty($batch_list)) {
                foreach ($batch_list as $batch_list_key => $batch_list_value) {
                    $project_batch_list[$batch_list_value['proj_id']][] = array(
                        'n' => urlencode($batch_list_value['name']),
                        'v' => $batch_list_value['id'],
                    );
                }
            } else {
                $project_batch_list = array();
            }

            $project_new_list = array();
            if (!empty($project_old_list)) {
                foreach ($project_old_list as $project_old_list_key => $project_old_list_value) {
                    $project_new_list[] = array(
                        'n' => urlencode($project_old_list_value['company_name'] . '--' . $project_old_list_value['name']),
                        'v' => $project_old_list_value['id'],
                        's' => isset($project_batch_list[$project_old_list_value['id']]) ? $project_batch_list[$project_old_list_value['id']] : ''
                    );
                }
            }
            $project_json = urldecode(json_encode($project_new_list));
            $this->assign('project_json', $project_json);

            //当前批次
            $batch_id = $choose['batch_id'];
            $batch_where['id'] = $batch_id;
            $batch = D('Batch')->getOne($batch_where, '*');
            $this->assign('batch', $batch);

            $this->set_seo_title('编辑客户信息');
            $this->display();
        }
    }

    /**
     * 删除
     *
     * @create 2016-12-26
     * @author zlw
     */
    public function delete() {
        if (!IS_POST) {
            $this->error("访问错误，请确认后重试！");
        }

        $id = I('post.id', 0, 'intval');
        if ($id == 0) {
            $this->error("ID错误，请确认后重试！");
        }

        $Choose = D('Choose');

        $cstinfo = $Choose->getOneById($id);
        if (empty($cstinfo)) {
            $this->success("删除成功！");
        }

        $project_id = $cstinfo['project_id'];
        $batch_id = $cstinfo['batch_id'];

        $user_project_ids = $this->get_user_project_ids();
        $user_batch_ids = $this->get_user_batch_ids();

        if (!in_array($project_id, $user_project_ids) || !in_array($batch_id, $user_batch_ids)) {
            $this->error("删除失败，你不能删除该信息！");
        }
        
        $event = M()->table("xk_event_order_house")
                    ->where("states=1 and project_id={$cstinfo['project_id']} and batch_id={$cstinfo['batch_id']} and unix_timestamp(now())<= end_time and unix_timestamp(now())>=start_time")
                    ->find();
        $phone= rsa_decode($cstinfo['customer_phone'],getChoosekey());     
        if($event)
        {
            try{
                $redis = new Redis();
                //$redis->hset("dlsx_order_house_{$event['id']}_{$phone}", 'status', 0);
                $redis->del("dlsx_order_house_{$event['id']}_{$phone}"); 
                $Choose->startTrans();
                $check_has_delete = $Choose->deleteOneById($id);
                $Choose->commit();
            }
            catch (\Exception $e) {
                $redis->hSet("dlsx_order_house_{$event['id']}_{$phone}", 'status', $cstinfo['status']); 
                $Choose->rollback();
                $this->error("删除失败，请确认后重试！");
            }
        }
        else
        {
            $check_has_delete = $Choose->deleteOneById($id);
        }
        if (false === $check_has_delete) {
            $this->error("删除失败，请确认后重试！");
        }

        $this->success("删除成功！");
    }

    /**
     * 批量删除
     *
     * @create 2016-12-26
     * @author zlw
     */
    public function delete_all() {
        if (!IS_POST) {
            $this->error("访问错误，请确认后重试！");
        }

        $ids = I('post.ids', '', 'trim');

        if (empty($ids)) {
            $this->error("删除失败，请选择要删除的信息！");
        }

        $user_project_ids = $this->get_user_project_ids();
        $user_batch_ids = $this->get_user_batch_ids();

        $Choose = D('Choose');

        foreach ($ids as $id) {
            $id = intval($id);

            if ($id == 0) {
                continue;
            }

            $choose = $Choose->getOneById($id);
            if (empty($choose)) {
                continue;
            }

            $project_id = $choose['project_id'];
            $batch_id = $choose['batch_id'];

            if (!in_array($project_id, $user_project_ids) || !in_array($batch_id, $user_batch_ids)
            ) {
                continue;
            }

            $check_has_delete = $Choose->deleteOneById($id);
            if (false === $check_has_delete) {
                continue;
            }
        }

        $this->success("批量删除成功！");
    }

    //批量启用和批量关闭
    public function plOff() {
        if (!IS_POST) {
            $this->error("访问错误，请确认后重试！");
        }

        $ids = I('ids/a', '', 'trim');

        if (empty($ids)) {
            $this->error("关闭失败，请选择要关闭的用户信息！");
        }
        $Choose = D('Choose');
        foreach ($ids as $id) {            
            $Choose->where("id=$id")->save(["status" => 0]);
        }

        $this->success("批量关闭成功！");
    }

    public function plOpen() {
        if (!IS_POST) {
            $this->error("访问错误，请确认后重试！");
        }

        $ids = I('ids/a', '', 'trim');

        if (empty($ids)) {
            $this->error("启用败，请选择要启用的用户信息！");
        }
        $Choose = D('Choose');
        foreach ($ids as $id) {
            $Choose->where("id=$id")->save(["status" => 1]);
        }

        $this->success("批量启用成功！");
    }

    /*     * =============== 导入与导出 ==================* */

    //身份证验证函数
    function is_id_card($id) {
        $id = strtoupper($id);
        $regx = "/(^\d{15}$)|(^\d{17}([0-9]|X)$)/";
        $arr_split = array();
        if (!preg_match($regx, $id)) {
            return false;
        }
        if (15 == strlen($id)) { //检查15位
            $regx = "/^(\d{6})+(\d{2})+(\d{2})+(\d{2})+(\d{3})$/";

            @preg_match($regx, $id, $arr_split);
            //检查生日日期是否正确
            $dtm_birth = "19" . $arr_split[2] . '/' . $arr_split[3] . '/' . $arr_split[4];
            if (!strtotime($dtm_birth)) {
                return false;
            } else {
                return true;
            }
        } else {      //检查18位
            $regx = "/^(\d{6})+(\d{4})+(\d{2})+(\d{2})+(\d{3})([0-9]|X)$/";
            @preg_match($regx, $id, $arr_split);
            $dtm_birth = $arr_split[2] . '/' . $arr_split[3] . '/' . $arr_split[4];
            if (!strtotime($dtm_birth)) { //检查生日日期是否正确
                return false;
            } else {
                //检验18位身份证的校验码是否正确。
                //校验位按照ISO 7064:1983.MOD 11-2的规定生成，X可以认为是数字10。
                $arr_int = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
                $arr_ch = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
                $sign = 0;
                for ($i = 0; $i < 17; $i++) {
                    $b = (int) $id{$i};
                    $w = $arr_int[$i];
                    $sign += $b * $w;
                }
                $n = $sign % 11;
                $val_num = $arr_ch[$n];
                if ($val_num != substr($id, 17, 1)) {
                    return false;
                } //phpfensi.com
                else {
                    return true;
                }
            }
        }
    }

    /**
     * 获取Excel数据
     *
     * @edit 2016-12-19
     * @author zlw
     */
    public function importGet($filename, $exts = 'xls') {
        //导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
        import("Org.Util.PHPExcel");
        //创建PHPExcel对象，注意，不能少了\
        $PHPExcel = new \PHPExcel();
        //如果excel文件后缀名为.xls，导入这个类
        if ($exts == 'xls') {
            import("Org.Util.PHPExcel.Reader.Excel5");
            $PHPReader = new \PHPExcel_Reader_Excel5();
        } elseif ($exts == 'xlsx') {
            import("Org.Util.PHPExcel.Reader.Excel2007");
            $PHPReader = new \PHPExcel_Reader_Excel2007();
        }

        //载入文件
        $PHPExcel = $PHPReader->load($filename);
        //获取表中的第一个工作表，如果要获取第二个，把0改为1，依次类推
        $currentSheet = $PHPExcel->getSheet(0);
        //获取总列数
        $allColumn = $currentSheet->getHighestColumn();
        //获取总行数
        $allRow = $currentSheet->getHighestRow();

        if (empty($allRow)) {
            $this->error = '文件内容为空';
            return false;
        }

        // 循环获取表中的数据，
        // $currentRow表示当前行，从哪行开始读取数据，索引值从0开始
        $data = array();
        for ($currentRow = 1; $currentRow <= $allRow; $currentRow++) {
            //从哪列开始，A表示第一列
            for ($currentColumn = 'A'; $currentColumn <= $allColumn; $currentColumn++) {
                //数据坐标
                $address = $currentColumn . $currentRow;

                //读取到的数据，保存到数组$arr中
                if ($currentColumn === 'A') {
                    $data[$currentRow][$currentColumn] = (string) $currentSheet->getCell($address)->getValue();
                } else {
                    $data[$currentRow][$currentColumn] = $currentSheet->getCell($address)->getValue();
                }
            }
        }

        return $data;
    }

    //删除二位数组中相同的的数组只针对2个相同的，多个不行,并且只针对当前页面的导入
    public function deleteArr($arr) {
        for ($k = 0; $k < count($arr); $k++) {
            for ($i = 0; $i < $k; $i++) {
                if ($arr[$k]['A'] === $arr[$i]['A'] && $arr[$k]['B'] === $arr[$i]['B'] && $arr[$k]['C'] === $arr[$i]['C']) {
                    unset($arr[$i]);
                }
            }
            $arr = array_merge($arr);
        }
        return $arr;
    }

    /**
     * 导入数据
     *
     * @create 2016-12-26
     * @author zlw
     */
     public function import() {
        if (!IS_POST) {
            $this->error("访问错误，请确认后重试！");
        }

        $upload = new Upload(); // 实例化上传类
        $upload->maxSize = 3145728; // 设置附件上传大小
        $upload->exts = array('xls', 'xlsx', 'txt'); // 设置附件上传类
        $upload->autoSub = false;
        $upload->rootPath = './Uploads/';
        $upload->savePath = '/choose/'; // 设置附件上传目录
        $upload->saveName = date('YmdHis');

        $info = $upload->uploadOne($_FILES['excel']);
        if (!$info) {
            $this->error($upload->getError());
        }

        $filename = './Uploads' . $info['savepath'] . $info['savename'];
        $ext = $info['ext'];

        $excels = $this->importGet($filename, $ext);

        if (empty($excels)) {
            $this->error('数据为空，请确认后重试！');
        }
        $project_id = rsa_decode($excels[1]['B'],  getChoosekey());
        $project_name = $excels[1]['D'];
        $batch_id = rsa_decode($excels[1]['F'],  getChoosekey());
        $user_project_ids = $this->get_user_project_ids();
        $user_batch_ids = $this->get_user_batch_ids();
        if (!in_array($project_id, $user_project_ids) || !in_array($batch_id, $user_batch_ids)
        ) {
            $this->error("导入失败，你不能导入数据到该项目！");
        }
        unset($excels[1]);
        unset($excels[2]);
        $b_excel = array_merge($excels);
        $back_excel = [];
        $back_excel['in_all'] = count($b_excel);

        //定义默认数据
        //获取数据库同一批次的数据
        $sql_arr = M()->table("xk_choose")->field("customer_name A,customer_phone B,cardno C,cyjno D,money E,row_number F,ywy G,ywyphone H,room I,ys_time J")->where("project_id=$project_id AND batch_id=$batch_id")->select();
        for($i=0;$i<count($sql_arr);$i++){
            $sql_arr[$i]['b']=rsa_decode($sql_arr[$i]['b'],getChoosekey());
            $sql_arr[$i]['c']=rsa_decode($sql_arr[$i]['c'],getChoosekey());
        }
        $excels = array_merge($b_excel, $sql_arr);
        foreach ($excels as $key => $value) {
            $excels[$key] = array_change_key_case($excels[$key], CASE_UPPER);
        }

//        echo json_encode($excels);exit;

        $key_arr = [];
        for ($k = 0; $k < count($excels); $k++) {
            for ($i = 0; $i < $k; $i++) {
                if ((string) $excels[$k]['B'] === (string) $excels[$i]['B'] || (string) $excels[$k]['C'] === (string) $excels[$i]['C'] || (string) $excels[$k]['D'] === (string) $excels[$i]['D']) {
                    $key_arr[] = $k;
                    $key_arr[] = $i;
                }
            }
        }
        $key_arr = array_unique($key_arr);
        $key_arr = array_merge($key_arr);
        $repeat_arr = [];
        for ($i = 0; $i < count($key_arr); $i++) {
            if (isset($b_excel[$key_arr[$i]])) {
                $repeat_arr[] = $b_excel[$key_arr[$i]];
                unset($b_excel[$key_arr[$i]]);
            }
        }
        $b_excel = array_merge($b_excel);
//        echo json_encode($repeat_arr);exit;

        if ($repeat_arr) {
            $back_excel['in_error'] = count($repeat_arr);
            import("Org.Util.PHPExcel");
            import("Org.Util.PHPExcel.Writer.Excel5");
            import("Org.Util.PHPExcel.IOFactory.php");

            //创建PHPExcel对象，注意，不能少了\
            $PHPExcel = new \PHPExcel();
            //激活表格
            $filename = "error" . date('YmdHis') . ".xls";
            $PHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $PHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $PHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $PHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $PHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $PHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $PHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $PHPExcel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle("F")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle("G")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle("H")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle("I")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle("J")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle("K")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $PHPExcel->getActiveSheet()->getStyle('A1:H1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
            $PHPExcel->getActiveSheet()->getStyle('A1:H1')->getFill()->getStartColor()->setARGB('00dc93d5');
            $PHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $PHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(22);
            $PHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(22);
            $PHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
            $PHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
            $PHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $PHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $PHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
            $PHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
            $PHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
            $PHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
            $PHPExcel->getActiveSheet()->setCellValue('A1', '项目标识');
            $PHPExcel->getActiveSheet()->setCellValue('B1', rsa_encode($project_id,  getChoosekey()));
            $PHPExcel->getActiveSheet()->setCellValue('C1', '项目名称');
            $PHPExcel->getActiveSheet()->setCellValue('D1', $project_name);
            $PHPExcel->getActiveSheet()->setCellValue('E1', '批次');
            $PHPExcel->getActiveSheet()->setCellValue('F1', rsa_encode($batch_id,  getChoosekey()));
            $PHPExcel->getActiveSheet()->setCellValue('G1', '说明');
            $PHPExcel->getActiveSheet()->setCellValue('H1', "此行不能修改！");
            $PHPExcel->getActiveSheet()->setCellValue('A2', '客户名称');
            $PHPExcel->getActiveSheet()->setCellValue('B2', '手机号码');
            $PHPExcel->getActiveSheet()->setCellValue('C2', '身份证号码');
            $PHPExcel->getActiveSheet()->setCellValue('D2', "诚意金编号");
            $PHPExcel->getActiveSheet()->setCellValue('E2', '诚意金金额');
            $PHPExcel->getActiveSheet()->setCellValue('F2', '排号顺序');
            $PHPExcel->getActiveSheet()->setCellValue('G2', '置业顾问');
            $PHPExcel->getActiveSheet()->setCellValue('H2', '置业顾问电话');
            $PHPExcel->getActiveSheet()->setCellValue('I2', '意向房间');
            $PHPExcel->getActiveSheet()->setCellValue('J2', '选房延迟时间');
            for ($i = 0; $i < count($repeat_arr); $i++) {
                $PHPExcel->getActiveSheet()->setCellValueExplicit("A" . ($i + 3), $repeat_arr[$i]['A'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $PHPExcel->getActiveSheet()->setCellValueExplicit("B" . ($i + 3), $repeat_arr[$i]['B'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $PHPExcel->getActiveSheet()->setCellValueExplicit("C" . ($i + 3), $repeat_arr[$i]['C'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $PHPExcel->getActiveSheet()->setCellValueExplicit("D" . ($i + 3), $repeat_arr[$i]['D'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $PHPExcel->getActiveSheet()->setCellValueExplicit("E" . ($i + 3), $repeat_arr[$i]['E'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $PHPExcel->getActiveSheet()->setCellValueExplicit("F" . ($i + 3), $repeat_arr[$i]['F'], \PHPExcel_Cell_DataType::TYPE_STRING);
                $PHPExcel->getActiveSheet()->setCellValue("G" . ($i + 3), $repeat_arr[$i]['G']);
                $PHPExcel->getActiveSheet()->setCellValue("H" . ($i + 3), $repeat_arr[$i]['H']);
                $PHPExcel->getActiveSheet()->setCellValue("I" . ($i + 3), $repeat_arr[$i]['I']);
                $PHPExcel->getActiveSheet()->setCellValue("J" . ($i + 3), $repeat_arr[$i]['J']);
            }

            $objWriter = \PHPExcel_IOFactory::createWriter($PHPExcel, 'Excel5');
//        $objWriter->save($filename);
// 输出Excel表格到浏览器下载
//                        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//                        header('Content-Disposition: attachment;filename='.$filename1);
//                        header('Cache-Control: max-age=0');
            $filePath = './Uploads/choose/choose_error/' . $filename;
            $objWriter->save($filePath);
            $back_excel['error_path'] = $filePath;
        }
        if (count($repeat_arr) == $back_excel['in_all']) {
            echo json_encode($back_excel);
            exit;
        }

//        echo json_encode($excels);exit;
        $data = array();
        foreach ($b_excel as $key => $excel) {
            $data[] = array(
                'project_id' => $project_id,
                'batch_id' => $batch_id,
                'customer_name' => (string) $excel['A'],
                'customer_phone' => rsa_encode((string) $excel['B'], getChoosekey()),
                'cardno' => rsa_encode((string) $excel['C'], getChoosekey()),
                'like_p' => strencode($excel['B']),
                'like_c' => strencode($excel['C']),
                'cyjno' => (string) $excel['D'],
                'money' => $excel['E'],
                'row_number' => $excel['F'],
                'ywy' => (string) $excel['G'],
                'ywyphone' => (string) $excel['H'],
                'room' => $excel['I'],
                'ys_time' => (int) $excel['J'],
                'remark' => '', //备注
                'add_time' => time(),
                'add_ip' => get_client_ip(0, true),
            );
        }
        $check_has_add = D('Choose')->addAll($data);
        if ($check_has_add) {
            echo json_encode($back_excel);
            exit;
        }
    }

    /**
     * 导出数据
     *
     * @create 2016-12-26
     * @author zlw
     */
    public function export() {
        $project_id = I("project_id", '', 'intval');
        if (empty($project_id) || $project_id == 0) {
            $this->error('项目ID不存在，请重试！');
        }

        //获取项目信息
        $project = D('Common/Project')->getOneById($project_id);
        if (empty($project)) {
            $this->error('项目不存在，请重试！');
        }

        //批次ID
        $batch_id = I("batch_id", '', 'intval');
        if (empty($batch_id) || $batch_id == 0) {
            $this->error('项目批次ID错误，请重试！');
        }

        //当前批次
        $batch_where['id'] = $batch_id;
        $batch = D('Batch')->getOne($batch_where, '*');
        if (empty($batch)) {
            $this->error('项目批次不存在，请重试！');
        }

        $user_project_ids = $this->get_user_project_ids();
        $user_batch_ids = $this->get_user_batch_ids();

        if (!in_array($project_id, $user_project_ids) || !in_array($batch_id, $user_batch_ids)
        ) {
            $this->error("你没有权限下载该项目的信息！");
        }

        $headArr = array(
            'title' => array(
                array('项目标识', '_bold' => true),
                rsa_encode($project_id,  getChoosekey()),
                array('项目名称', '_bold' => true),
                $project['name'],
                array('批次', '_bold' => true),
                rsa_encode($batch_id,  getChoosekey()),
                array('说明', '_bold' => true),
                "此行内容不可更改！",
            ),
            'head' => array(
                array('客户名称', '_bold' => true, '_wd' => 15),
                array('手机号码', '_bold' => true, '_wd' => 20),
                array('身份证号码', '_bold' => true, '_wd' => 30),
                array('诚意金编号', '_bold' => true, '_wd' => 15),
                array('诚意金金额', '_bold' => true, '_wd' => 15),
                array('排号顺序', '_bold' => true, '_wd' => 15),
                array('置业顾问', '_wd' => 15),
                array('置业顾问电话', '_wd' => 20),
                array('意向房间', '_wd' => 20),
                array('选房延迟时间', '_wd' => 20),
            ),
        );

        //$filename = $project['name'].'-'.$batch['name'];
        $filename = '客户导入模板';

        D('Excel', 'Logic')->export($filename, $headArr);
    }

    /*     * =============== 新增2017-9 qzb ==================* */
    /*
     * 导出客户数据
     * @create 2017-9-18
     * qzb
     */

    public function check_user() {
        $user_project_ids = $this->get_user_project_ids();
        $user_project_ids = array_merge($user_project_ids);
        $user_batch_ids = $this->get_user_batch_ids();
        $user_batch_ids = array_merge($user_batch_ids);
        $ps = implode(",", $user_project_ids);
        $bs = implode(",", $user_batch_ids);
        $project_id = I("project_id", '', 'intval');
        if (empty($project_id) || $project_id == 0) {
            $p = "AND c.project_id in({$ps})";
        } else {
            $p = "AND c.project_id=$project_id ";
        }

        //批次ID
        $batch_id = I("bid", '', 'intval');
        if (empty($batch_id) || $batch_id == 0) {
            $b = "AND c.batch_id in({$bs})";
        } else {
            $b = "AND c.batch_id=$batch_id";
        }
//批次ID
        $status = I("status", '', 'trim');
        if ($status !== "") {
            $s = "c.status =$status";
        } else {
            $s = "";
        }

        $word = I("word", '', 'trim');
        $zt = I("zt", '', 'intval');
        $z = "";
        $zc = "";
        if (!empty($zt)) {
            if ($zt == 1) {
                $z = "AND r.id IS NOT NULL";
                $zc = ",r.id,r.unit,r.floor,r.no,r.room,r.area,r.total,b.buildname";
            } else {
                $z = "AND r.id IS NULL";
                $zc = "";
            }
        }
        $w = "";
        if (!empty($word)) {
            $w = "AND (c.customer_name like '%{$word}%' OR c.customer_phone like '%{$word}%' OR c.cyjno like '%{$word}%' OR c.cardno like '%{$word}%')";
        }
        $data = M()->table("xk_project p")->field("p.name pname,c.ys_time ctime,c.status stu,c.customer_name,c.customer_phone,c.cardno,c.cyjno,c.money,c.ywy,c.ywyphone,k.name kname,rt.unit rt_unit,rt.floor rt_floor,rt.room rt_room,bt.buildname bt_name" . $zc)->
                        join("xk_choose c ON c.project_id=p.id")->
                        join("xk_kppc k ON c.batch_id=k.id")->
                        join("LEFT JOIN xk_room r ON r.cstid=c.id")->
                        join("LEFT JOIN xk_build b ON r.bld_id=b.id")->
                        join("LEFT JOIN xk_room rt ON rt.id=c.room")->
                        join("LEFT JOIN xk_build bt ON rt.bld_id=bt.id")->
                        where("1=1 $p $b $z $w $s")->select();
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Writer.Excel5");
        import("Org.Util.PHPExcel.IOFactory.php");

        //创建PHPExcel对象，注意，不能少了\
        $objPHPExcel = new \PHPExcel();
        if ($zc) {
            $filename = '客户数据-已选房-' . time() . ".xls";
        } else {
            $filename = '客户数据-' . time() . ".xls";
        }

        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("F")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("G")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("H")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("I")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("J")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("K")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("L")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("M")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("N")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("O")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', '项目');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', '批次');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', '客户名称');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', '手机号码');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', '身份证号码');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', '诚意金编号');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', '诚意金金额');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', '置业顾问');
        $objPHPExcel->getActiveSheet()->setCellValue('I1', '置业顾问电话');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', '预定房间');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', '延时时间');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', '启用状态');
        if ($zc) {
            $objPHPExcel->getActiveSheet()->setCellValue('M1', '已选房源');
            $objPHPExcel->getActiveSheet()->setCellValue('N1', '面积');
            $objPHPExcel->getActiveSheet()->setCellValue('O1', '价格');
        }

        for ($k = 0; $k < count($data); $k++) {
            if ($data[$k]['stu'] == 1) {
                $a = '启用';
            } else {
                $a = '关闭';
            }
//            $objActSheet->setCellValue($j.$column, $value, \PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ($k + 2), $data[$k]['pname']);
            $objPHPExcel->getActiveSheet()->setCellValue('B' . ($k + 2), $data[$k]['kname']);
            $objPHPExcel->getActiveSheet()->setCellValue('C' . ($k + 2), $data[$k]['customer_name']);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('D' . ($k + 2), rsa_decode($data[$k]['customer_phone'], getChoosekey()), \PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('E' . ($k + 2), rsa_decode($data[$k]['cardno'], getChoosekey()), \PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . ($k + 2), $data[$k]['cyjno']);
            $objPHPExcel->getActiveSheet()->setCellValue('G' . ($k + 2), $data[$k]['money']);
            $objPHPExcel->getActiveSheet()->setCellValue('H' . ($k + 2), $data[$k]['ywy']);
            $objPHPExcel->getActiveSheet()->setCellValue('I' . ($k + 2), $data[$k]['ywyphone']);
            $objPHPExcel->getActiveSheet()->setCellValue('J' . ($k + 2), $data[$k]['rt_unit'] ? $data[$k]['bt_name'] . "-" . $data[$k]['rt_unit'] . "单元-" . $data[$k]['rt_floor'] . "层-" . $data[$k]['rt_room'] : "无");
            $objPHPExcel->getActiveSheet()->setCellValue('K' . ($k + 2), $data[$k]['ctime'] ? $data[$k]['ctime'] : "0" );
            $objPHPExcel->getActiveSheet()->setCellValue('L' . ($k + 2), $a);
            if ($zc) {
                $objPHPExcel->getActiveSheet()->setCellValue('M' . ($k + 2), $data[$k]['buildname'] . "-" . $data[$k]['unit'] . "单元-" . $data[$k]['floor'] . "层-" . $data[$k]['room']);
                $objPHPExcel->getActiveSheet()->setCellValue('N' . ($k + 2), $data[$k]['area']);
                $objPHPExcel->getActiveSheet()->setCellValue('O' . ($k + 2), $data[$k]['total']);
            }
        }

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//        $objWriter->save($filename);
// 输出Excel表格到浏览器下载
        $filename = urlencode($filename);
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=$filename");
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter->save('php://output');
        exit;
    }

    /*
     * 预定房间模糊查询
     * @create 2017-9-29
     * qzb
     */

    public function add_room() {
        $room = I("room", 0, "intval");
        $pid = I("pid", 0, "intval");
        $bid = I("bid", 0, "intval");
        $rid = I("rid", 0, "intval");
        $r = "";
        if ($rid) {
            $r = " or r.id=$rid";
        } else {
            $r = "";
        }
        $p = "";
        $b = "";
        if (!empty($pid)) {
            $p = "AND r.proj_id=$pid";
        }
        if (!empty($bid)) {
            $b = "AND r.pc_id=$bid";
        }
        $res = M()->table("xk_roomlist r")->field("r.id,r.room,r.buildname,r.unit,r.floor,r.room,case when c.id IS NULL then 0 else c.id end  as isyyd,r.is_xf")->
                        join("LEFT JOIN xk_choose c ON c.room =r.id")->
                        //where("(r.room like '%$room%') And r.is_xf=0 $p $b $r")->select();
                        where("(r.room like '%$room%') $p $b $r")->select();
        echo json_encode($res);
        exit;
    }

    /*
     * 添加修改预定房间
     * @create 2017-9-30
     * qzb
     */

    public function update_yd() {
        $uid = I("uid", 0, "intval");
        $rid = I("rid", 0, "intval");
        $choose = D(choose)->find($uid);
        //清空原房间中的预定电话号码
        $roomlist = D('Roomlist');
        $roominfo = $roomlist->where("id={$rid}")->find();
        if ($roominfo) {
            if ($roominfo["is_xf"] === 1) {
                echo "房间已售，请重新选择!";
                exit;
            }
            $event = M()->table("xk_event_order_house")
                    ->where("states=1 and project_id={$roominfo['proj_id']} and batch_id={$roominfo['pc_id']} and unix_timestamp(now())<= end_time and unix_timestamp(now())>=start_time")
                    ->find();
            if ($event) {
                $eventOrderHouseModel = D('Common/EventOrderHouse');
                //查看活动是否存在
                $event_r = $eventOrderHouseModel->getEventByEventId($event['id']);
                if ($event_r && $event_r['project_id']>0) {
                    $expire_time = $event_r['end_time'] - time();
                    $eventId = $event['id'];
                    $redis = new Redis();
                    $isRoomOrdered = $redis->sIsMember("event_order_house_{$eventId}_room_ordered", $rid);
                    if ($isRoomOrdered) {
                        echo "房间已售，请重新选择!";
                        exit;
                    }
                    $isMemberOrdered = $redis->sIsMember("event_order_house_{$eventId}_room_order_phone", rsa_decode($choose['customer_phone'],  getChoosekey()));
                    if ($isMemberOrdered) {
                        echo "您已认购，不允许修改!";
                        exit;
                    }
                    $ygrooms = $redis->hGetAll("event_order_house_{$eventId}_room_order_member");
                    $k=-1;
                    foreach ($ygrooms as $key=>$ygroom) {
                        if ($ygroom == $rid) {
                            echo "房间已经预定!";
                            exit;
                        }
                        if($ygroom == $choose['room'])
                        {
                            $k=$key;
                        }
                    }
                    $getLock = 0;
                    //新选择的预定房间
                    $room_r = $eventOrderHouseModel->getRoomByRedisKey("event_order_house_{$eventId}_room_{$rid}");
                    //原来的预定房间
                    $room_old = $eventOrderHouseModel->getRoomByRedisKey("event_order_house_{$eventId}_room_{$choose['room']}");
                    
                    if ($room_r['status'] == 1) {
                        echo "房间已售，请重新选择!";
                        exit;
                    } else {
                        $getLock = $redis->setnx("event_order_house_{$eventId}_room_{$rid}_locked", 1);
                    }
                    if ($getLock) {
                        $redis->expire("event_order_house_{$eventId}_room_{$rid}_locked", 10);
                    } else {
                        echo "请稍后重试!";
                        exit;
                    }
                    if ($ygrooms) {
                        $j = count($ygrooms);
                    } else {
                        $j = 0;
                    }
                    $evrnt_status = $event_r['isyks'];
                    //原来已有预定房间则需要先清空，再插入本次数据
                    //活动未开始(第一个客户未开始点击认购)不能直接显示为已售，只需要加入预定房间中且修改房间预定手机即可
                    if($choose['room'])
                    {
                        $redis->hSet("event_order_house_{$eventId}_room_order_member", $k,$rid);
                        $redis->hSet("event_order_house_{$eventId}_room_{$rid}", 'schedule_phone', rsa_decode($choose['customer_phone'],  getChoosekey()));
                    }  else {
                        $redis->hSet("event_order_house_{$eventId}_room_order_member", $j, $rid);
                        $redis->expire("event_order_house_{$eventId}_room_order_member", $expire_time);
                        $redis->hSet("event_order_house_{$eventId}_room_{$rid}", 'schedule_phone', rsa_decode($choose['customer_phone'],  getChoosekey()));
                    }
                    if ($evrnt_status > 0) {
                        try {
                            if($choose['room'])
                            {   
                                $redis->hSet("event_order_house_{$eventId}_room_{$choose['room']}", 'schedule_phone', '');
                                $redis->hSet("event_order_house_{$eventId}_room_{$choose['room']}", 'status', 0);
                                $redis->del("event_order_house_{$eventId}_room_{$choose['room']}_locked");
                                $redis->sRem("event_order_house_{$eventId}_room_ordered", $choose['room']);
                            }
                            
                            $redis->hSet("event_order_house_{$eventId}_room_{$rid}", 'schedule_phone', rsa_decode($choose['customer_phone'],  getChoosekey()));
                            $redis->hSet("event_order_house_{$eventId}_room_{$rid}", 'status', 1);
                            $redis->set("event_order_house_{$eventId}_room_{$rid}_locked", 1, $expire_time);
                            $redis->sAdd("event_order_house_{$eventId}_room_ordered", $rid);
                        } catch (\Exception $e) {
                            if($choose['room'])
                            {
                                $redis->hSet("event_order_house_{$eventId}_room_{$choose['room']}", 'schedule_phone', $room_old['schedule_phone']);
                                $redis->hSet("event_order_house_{$eventId}_room_{$choose['room']}", 'status', 1);
                                $redis->set("event_order_house_{$eventId}_room_{$choose['room']}_locked",1, $expire_time);
                                $redis->sAdd("event_order_house_{$eventId}_room_ordered",1, $choose['room']);
                            }
                            
                            $redis->hSet("event_order_house_{$eventId}_room_{$rid}", 'schedule_phone', '');
                            $redis->hSet("event_order_house_{$eventId}_room_{$rid}", 'status', 0);
                            $redis->del("event_order_house_{$eventId}_room_{$rid}_locked");
                            $redis->sRem("event_order_house_{$eventId}_room_ordered", $rid);
                            echo "请稍后重试!";
                            exit;
                        }
                    }
                }
            }
            $room = D('Room');
            $room->startTrans();
            //清空原预定房间中的预定电话
            if ($choose['room'] > 0) {
                $room->where("id=" . $choose['room'])->save(["schedule_phone" => NULL]);
            }
            //写入本次预定数据：客户表和房间表
            M()->table("xk_choose")->where("id=$uid")->save(["room" => $rid]);
            $room->where("id=$rid")->save(["schedule_phone" =>  rsa_decode($choose['customer_phone'],  getChoosekey())]);
            $room->commit();
            echo "true";
            exit;
        } else {
            echo "当前选择的房间异常，请稍后重试!";
            exit;
        }
    }

    //取消预定房间
    public function update_qx() {
        $uid = I("uid", 0, "intval");
        $choose = M()->table("xk_choose")->find($uid);
        //清空预定房间
        $roomlist = D('Roomlist');
        $rid = $choose["room"];
        $roominfo = $roomlist->find($rid);
        if ($roominfo) {
            $rid = $roominfo['id'];
            $event = M()->table("xk_event_order_house")
                    ->where("states=1 and project_id={$roominfo['proj_id']} and batch_id={$roominfo['pc_id']} and unix_timestamp(now())<= end_time and unix_timestamp(now())>=start_time")
                    ->find();
            if ($event) {
                $eventOrderHouseModel = D('Common/EventOrderHouse');
                //查看活动是否存在
                $event_r = $eventOrderHouseModel->getEventByEventId($event['id']);
                if ($event_r && $event_r['project_id']>0) {
                    $redis = new Redis();
                    
                    $isMemberOrdered = $redis->sIsMember("event_order_house_{$event['id']}_room_order_phone", rsa_decode($choose['customer_phone'],  getChoosekey()));
                    if ($isMemberOrdered) {
                        echo "您已认购，不允许取消!";
                        exit;
                    }
                    $expire_time = $event_r['end_time'] - time();
                    $eventId = $event['id'];
                    $redis = new Redis();
                    $k=-1;
                    $ygrooms = $redis->hGetAll("event_order_house_{$eventId}_room_order_member");
                    foreach ($ygrooms as $key=>$ygroom) {
                        if ($ygroom == $rid) {
                            $k=$key;
                            break;
                        }
                    }
                    $redis->hDel("event_order_house_{$eventId}_room_order_member", $k);
                    
                    $evrnt_status =  $event_r['isyks'];
                    if ($evrnt_status > 0) {
                        try {
                            $redis->hSet("event_order_house_{$eventId}_room_{$rid}", 'schedule_phone', '');
                            $redis->hSet("event_order_house_{$eventId}_room_{$rid}", 'status', 0);
                            $redis->del("event_order_house_{$eventId}_room_{$rid}_locked", 1, $expire_time);
                            $redis->sRem("event_order_house_{$eventId}_room_ordered", $rid);
                        } catch (\Exception $e) {
                            $redis->hSet("event_order_house_{$eventId}_room_{$rid}", 'schedule_phone',  rsa_decode($choose['customer_phone'],  getChoosekey()));
                            $redis->hSet("event_order_house_{$eventId}_room_{$rid}", 'status', 1);
                            $redis->set("event_order_house_{$eventId}_room_{$rid}_locked", 1, $expire_time);
                            $redis->sAdd("event_order_house_{$eventId}_room_ordered", $rid);
                            echo "请稍后重试!";
                            exit;
                        }
                    }
                }
            }

            $room = D('Room');
            $room->startTrans();
            $room->where("id=" . $rid)->save(["schedule_phone" => NULL]);
            M()->table("xk_choose")->where("id=$uid")->save(["room" => NULL]);
            $room->commit();
            echo "true";
            exit;
        } else {
            echo "当前预选房异常，请稍后重试!";
            exit;
        }
    }
    public function index(){
        //项目ID
        if(isset($_POST['project_id'])){
            $search_project_id = I('project_id', 0, 'intval');
            session("selected_project",$search_project_id);
        }else{
            $search_project_id = session("selected_project");
        }
        $search_batch_id = I('batch_id', 0, 'intval');
        $search_word = I('word', '', 'trim');
        $this->assign('bid', $search_batch_id);

        //设置当前搜索
        $search = array(
            'search_project_id' => $search_project_id,
            'search_batch_id' => $search_batch_id,
            'search_word' => $search_word,
        );
        $this->assign($search);

        //项目
        $Project = D('Common/Project');

        //获取当前项目
        $project_info = $Project->getProjectById($search_project_id);
        $this->assign('project', $project_info);

        //用户的项目和项目批次
        $user_project_ids = $this->get_user_project_ids();
        $user_batch_ids = $this->get_user_batch_ids();

        if ($search_project_id != 0) {
            if (!in_array($search_project_id, $user_project_ids)) {
                $this->error("你没有权限访问该项目的信息！");
            }
        }

        //获取项目列表
        $project_where = array();
        //$project_where['status'] = 1;
        if (!empty($user_project_ids)) {
            $project_where['id'] = array('in', $user_project_ids);
        } else {
            $project_where['id'] = '-99999';
        }
        $project_old_list = D('Common/ProjectView')->getList($project_where, 'company_id DESC, id DESC', '50');
        if (!empty($project_old_list)) {
            foreach ($project_old_list as $project_list_key => $project_list_value) {
                $project_list[$project_list_value['id']] = $project_list_value;
            }
        } else {
            $project_list = array();
        }
        $this->assign('project_list', $project_list);

        //批次
        if (!empty($user_batch_ids)) {
            $user_batch_where['id'] = array('in', $user_batch_ids);
        } else {
            $user_batch_where['id'] = '-99999';
        }
        $user_batch_where['proj_id'] = $search_project_id;
        $batch_list = D('Batch')->getList($user_batch_where, '*');
        $this->assign('batch_list', $batch_list);

        $eventOrderHouseModel = D('Common/EventOrderHouse');

        //条件
        $where = array();
        if (!empty($search_project_id)) {
            $where['project_id'][] = $search_project_id;
        }

        //项目条件
        if (!empty($user_project_ids)) {
            $where['project_id'][] = array('in', $user_project_ids);
        } else {
            $where['project_id'][] = '-99999';
        }

       if (!empty($search_batch_id)) {
            $where['batch_id'][] = $search_batch_id;
        }else{
            //批次条件
            if (!empty($user_batch_ids)) {
                $where['batch_id'] = array('in', $user_batch_ids);
            } else {
                $where['batch_id'] = '-99999';
            }
        }

        //搜索查询
        if (!empty($search_word)) {
            $like['name'] = array('like', '%' . $search_word . '%');
            /*$like['rdd_project_name'] = array('like', '%' . $search_word . '%');*/
            $where['_complex'] = $like;
        }

        //总数
        $choose_activity_count = $eventOrderHouseModel->where($where)->count();

        //分页
        $Page = $this->bootstrapPage($choose_activity_count, 15);
        $page_show = $Page->show();
        $total_pages = $Page->totalPages;

        //取范围
        $limit = $Page->firstRow . ',' . $Page->listRows;

        $choose_activity_list = $eventOrderHouseModel->getList(
            $where, '*', 'start_time DESC, id DESC', $limit
        );

        foreach ($choose_activity_list as &$choose_activity) {

            $choose_activity['project_name'] = $project_list[$choose_activity['project_id']]['name'];

        }

        $p = I('p', '1', 'intval');
        $this->assign('p', $p);
        $this->assign('total_pages', $total_pages);
        $this->assign('count', $choose_activity_count);
        $this->assign('page_show', $page_show);

        $this->assign('choose_activity_list', $choose_activity_list);
        
        $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
        $this->assign('http_type', $http_type);
        $this->set_seo_title("微信认购设置");
        $this->display();
    }

    public function display_add(){
        //项目ID
        $project_id = session("selected_project");
        $this->assign('project_id', $project_id);

        //用户的项目和项目批次
        $user_project_ids = $this->get_user_project_ids();
        $user_batch_ids = $this->get_user_batch_ids();

        //获取项目列表
        $project_where = array();
        if (!empty($user_project_ids)) {
            $project_where['id'] = array('in', $user_project_ids);
        } else {
            $project_where['id'] = '-99999';
        }
        $project_old_list = D('Common/ProjectView')->getList($project_where, 'company_id DESC, id DESC', '50');
        if (!empty($project_old_list)) {
            foreach ($project_old_list as $project_list_key => $project_list_value) {
                $project_list[$project_list_value['id']] = $project_list_value;
            }
        } else {
            $project_list = array();
        }
        $this->assign('project_list', $project_list);

        //批次
        $user_batch_where = array();
        if (!empty($user_batch_ids)) {
            $user_batch_where['id'] = array('in', $user_batch_ids);
        } else {
            $user_batch_where['id'] = '-99999';
        }
        $batch_list = D('Batch')->getList($user_batch_where, '*');
        $this->assign('batch_list', $batch_list);

        if (!empty($batch_list)) {
            foreach ($batch_list as $batch_list_key => $batch_list_value) {
                $project_batch_list[$batch_list_value['proj_id']][] = array(
                    'n' => urlencode($batch_list_value['name']),
                    'v' => $batch_list_value['id'],
                );
            }
        } else {
            $project_batch_list = array();
        }

        $project_new_list = array();
        if (!empty($project_old_list)) {
            foreach ($project_old_list as $project_old_list_key => $project_old_list_value) {
                $project_new_list[] = array(
                    'n' => urlencode($project_old_list_value['company_name'] . '--' . $project_old_list_value['name']),
                    'v' => $project_old_list_value['id'],
                    's' => isset($project_batch_list[$project_old_list_value['id']]) ? $project_batch_list[$project_old_list_value['id']] : ''
                );
            }
        }
        $project_json = urldecode(json_encode($project_new_list));
        $this->assign('project_json', $project_json);

        $this->set_seo_title('微信认购设置');

        $this->display('add');
    }
    
    public function add()
    {
        if (!IS_AJAX){
            $this->error("提交错误，请稍后重试！");
        }
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->saveName = array('uniqid','');
        $upload->savePath  =      '../Uploads/img/wxlogin/'; // 设置附件上传目录    // 上传单个文件
        $upload->autoSub  = true;
        $upload->subName  = array('date','Ymd');
        $info   =   $upload->uploadOne($_FILES['login_img']);
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }
        $obj = array();
        $path= "/Uploads/img/wxlogin/".date("Ymd",time())."/".$info['savename'];
        $obj['loginimg']=$path;
        $notEmpty = array('name'=>'没有填写名称','project_id'=>'没有选择项目','batch_id'=>'没有选择批次','start_time'=>'没有选择开始时间','end_time'=>'没有选择结束时间');
        foreach (array_keys($notEmpty) as $item) {
            $value = I("post.{$item}");

            if (empty($value)){
                $this->error($notEmpty[$item]);
            }

            $obj[$item] = $value;
        }

        $fields = array('desc','mark','maxcount');
        foreach ($fields as $item) {
            $obj[$item] = I("post.{$item}");
        }
        $obj['is_short_message']=I("short","","trim")?1:0;
        $obj['states']=I("states","","trim")?1:0;
        $obj['isysdl']=I("isysdl","","trim")?1:0;
        $obj['is_show_discount']=I("is_show_discount","","trim")?1:0;
        $obj['is_aqyz']=I("is_aqyz","","trim")?1:0;
        $project = D("project")->field('cp_id,name')->where(array('id'=>$obj['project_id']))->find();

        if (empty($project['cp_id'])){
            $this->error('提交错误，请稍后重试！');
        }

        $obj['company_id'] = $project['cp_id'];
        $obj['rdd_company_name'] = $project['cp_id'];

        $obj['start_time'] = strtotime($obj['start_time']);
        $obj['end_time'] = strtotime($obj['end_time']);
        $obj['log_time'] = time();
        $eventOrderHouseModel = D('EventOrderHouse');
        $result = $eventOrderHouseModel->add($obj);

        if ($result){
            if(!empty($obj['states']))
                D('EventOrderHouse')->initializeByIdToRedis($result,1);
            $this->success('添加成功');}}}