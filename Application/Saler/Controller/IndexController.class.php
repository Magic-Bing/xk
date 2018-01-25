<?php

namespace Saler\Controller;

/**
 * 首页
 *
 * @create 2016-8-25
 * @author zlw
 */
class IndexController extends BaseController {

	/**
	 * 首页
	 *
	 * @create 2016-8-25
	 * @author zlw
	 */




    public function index() 
	{
		$user_where['userid'] = $this->get_user_id();
        $Model = new \Think\Model();
        $userinfo=$Model->query("SELECT * FROM xk_user WHERE id=". $user_where['userid'] ." limit 1" );
        if (empty($userinfo) || count($userinfo)<1)
        $this->error('用户登录信息异常,请重新登录！', U('logging/index'));
        //获取有权限查看的项目
        $user_project_list = D("Station")->getpProjectListByUserId($user_where['userid']);
		$project_ids = array();
		foreach ($user_project_list as $user_project_list_value) {
			$project_ids[] = $user_project_list_value['proj_id'];
		}
        $arr_string=implode(",",$project_ids);
		//获取有权限查看的活动
		$activity=$Model->table("xk_station2pc sp")->field("e.id,e.name")->join("xk_event_order_house e ON e.project_id=sp.proj_id AND e.batch_id=sp.pc_id")->where("sp.proj_id in({$arr_string})")->group("e.id")->select();
//		echo json_encode($activity);exit;
        if(count($activity)==1)
        {
            //只有一个活动时，直接前往首页
            redirect( U('saler/DataStatistics/index',array('info' => set_search_ids(array('p' => $activity[0]['id'])))));
        }
        else
        {
            //多个活动时，前往活动列表让用户选择
            $this -> assign('userinfo', $userinfo[0]);
            $this -> assign('projects', $activity);
            $this -> display(":index/indexone");
        }
//		echo json_encode($activity);exit;
		/*//项目列表
		if (!empty($project_ids)) {
			$Project = D('Common/Project');
			$where['status'] = 1;
			$where['id'] = array('in', $project_ids);
			$project_list = $Project -> getProjectList($where, 'id ASC');
		} else {
			$project_list = array();
		}
		$type=session('type');
		if(count($project_list)==1)
		{
		    if($type>=3){
                redirect( U('saler/statistics/index',array('info' => set_search_ids(array('p' => $project_list[0]['id'])))));
            }else{
                redirect( U('saler/project/index',array('info' => set_search_ids(array('p' => $project_list[0]['id'])))));
            }
		}
		else
		 {
             $this -> assign('userinfo', $userinfo[0]);
             $this -> assign('projects', $project_list);
             $this -> set_seo_title("项目列表");
             if($type>=3){
                 $this -> display(":index/indexone");
             }else{
                 $this -> display();
             }

		 }*/
	}

	/**
	 * 修改密码
	 * @author wxh
	 */
	public function user() {
		$user = M("user");
		if ($_POST) {
			$data = $user -> where("id ='" . $_SESSION['USER_ID'] . "' and password ='" . md5(md5($_POST['oldpwd'])) . "'") -> select();
			if (empty($data)) {
				$this -> error("原密码错误，请重新输入！");
			} else {
				$data['password'] = md5(md5($_POST['newpwd']));
				$dat = $user -> field("password") -> where("id =". $_SESSION['USER_ID']) -> save($data);
				session('USER_ID', null);
				$this->success('修改成功！', U('logging/index'));
			}

		} else {
			$data = $user -> where("id = " . $_SESSION['USER_ID']) -> select();
			$this -> assign("data", $data[0]);
			$this -> display();
		}
	}

}
