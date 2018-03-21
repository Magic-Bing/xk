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
	 * 微信选房首页
	 *
	 * @create 2016-8-25
	 * @author zlw
	 */
  /*  public function index()
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
	}*/

	/*
	 * 电子开盘批次个数判断
	 * qzb
	 * 2018-2-28*/
//        public function dz_page(){
//            $uid=$this->get_user_id();
//            $Model = new \Think\Model();
//            $userinfo=$Model->query("SELECT * FROM xk_user WHERE id=". $uid ." limit 1" );
//            if (empty($userinfo) || count($userinfo)<1)
//                $this->error('用户登录信息异常,请重新登录！', U('logging/index'));
//            //获取有权限查看的项目
//            $pd=$Model->table("xk_station2user su")->field("su.id,sp.proj_id,sp.pc_id,k.name,p.id pid")->
//            join("xk_station2pc sp ON su.station_id=sp.station_id")->
//            join("xk_kppc k ON k.id=sp.pc_id")->
//            join("LEFT JOIN xk_pzcsvalue p ON p.project_id=sp.proj_id AND p.batch_id=sp.pc_id AND p.pzcs_id=1 AND cs_value=-1")->
//            where("su.userid=".$uid)->select();
//            $count=0;
//            $pid=$pd[0]['proj_id'];
//            $pc=[];
//            for($i=0;$len=count($pd),$i<$len;$i++){
//                if(!$pd[$i]['pid']){
//                    $pc[$i]['id']=$pd[$i]['pc_id'];
//                    $pc[$i]['name']=$pd[$i]['name'];
//                    $count++;
//                }
//            }
//            if($count===1)
//            {
//                //只有一个活动时，直接前往首页
//                redirect( U('saler/DataStatistics/dz_index',array('p' =>$pid,'b' =>$pd[0]['pc_id'] )));
//            }
//            else
//            {
//                //多个活动时，前往活动列表让用户选择
//                $this -> assign('userinfo', $userinfo[0]);
//                $this -> assign('pid', $pid);
//                $this -> assign('pc', $pc);
//                $this -> display();
//            }
//        }

    /*
	 * 电子开盘和微信开盘合并，让用户自行选择
	 * qzb
	 * 2018-3-5*/
    public function index(){
        $uid=$this->get_user_id();
        $Model = new \Think\Model();
        $userinfo=$Model->query("SELECT * FROM xk_user WHERE id=". $uid ." limit 1" );
        if (empty($userinfo) || count($userinfo)<1)
            $this->error('用户登录信息异常,请重新登录！', U('logging/index'));
        //获取有权限查看的项目
        $pd=$Model->table("xk_station2user su")->field("su.id,sp.proj_id,sp.pc_id,k.name,p.id pid,e.id eid,e.name ename")->
        join("xk_station2pc sp ON su.station_id=sp.station_id")->
        join("xk_kppc k ON k.id=sp.pc_id")->
        join("LEFT JOIN xk_event_order_house e ON e.project_id=sp.proj_id AND e.batch_id=sp.pc_id")->
        join("LEFT JOIN xk_pzcsvalue p ON p.project_id=sp.proj_id AND p.batch_id=sp.pc_id AND p.pzcs_id=1 AND cs_value=-1")->
        where("su.userid=".$uid)->select();
//        echo json_encode($pd);exit;
        $pc=[];
        $hd=[];
        for($i=0;$len=count($pd),$i<$len;$i++){
            if($pd[$i]['pid']){
                $hd[$i]['id']=$pd[$i]['eid'];
                $hd[$i]['name']=$pd[$i]['ename'];
            }else{
                $pc[$i]['id']=$pd[$i]['pc_id'];
                $pc[$i]['pid']=$pd[$i]['proj_id'];
                $pc[$i]['name']=$pd[$i]['name'];
            }
        }
        $pc=$this->unique($pc);
        $hd=$this->unique($hd);
        //多个活动时，前往活动列表让用户选择
        $this -> assign('userinfo', $userinfo[0]);
        $this -> assign('pc', $pc);
        $this -> assign('hd', $hd);
        $this -> display("index/dz_index");
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
