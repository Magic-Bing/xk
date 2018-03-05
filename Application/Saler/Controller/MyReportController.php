<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/16 0016
 * Time: 17:08
 */

namespace Saler\Controller;
/**
 * 首页
 *
 * @create 2017-10-16
 * @author qzb
 */

class MyReportController extends BaseController
{
    public function _initialize()
    {
        parent::_initialize();
        $this->set_seo_title("我的信息");
    }
    
    /**
     * 我的报表页面微信开盘
     *
     * @create 2017-10-16
     * @author qzb
     */
    public function index()
    {
        $search_info = I('info', '', 'trim');
        $hid = get_search_id_by($search_info, 'p');
        $uid = $this->get_user_id();
        if (!$hid) {
            redirect(U('saler/index/index'));
        } else {
            $user = M()->table("xk_user")->where("id=$uid")->find();
            $user_where['userid']=$uid;
            $user_project_list = D("Station")->getpProjectListByUserId($user_where['userid']);
            $project_ids = array();
            foreach ($user_project_list as $user_project_list_value) {
                $project_ids[] = $user_project_list_value['proj_id'];
            }
            $arr_string=implode(",",$project_ids);
            //获取有权限查看的活动
            $pd=M()->table("xk_station2user su")->field("su.id,p.id pid,sp.proj_id,sp.pc_id,e.id eid")->
            join("xk_station2pc sp ON su.station_id=sp.station_id")->
            join("LEFT JOIN xk_event_order_house e ON e.project_id=sp.proj_id AND e.batch_id=sp.pc_id")->
            join("LEFT JOIN xk_pzcsvalue p ON p.project_id=sp.proj_id AND p.batch_id=sp.pc_id AND p.pzcs_id=1 AND cs_value=-1")->
            where("su.userid=$uid")->count();
            $this->assign('count', $pd);
            $this->assign('user', $user);
            $this->assign('search_hd_id', $hid);
            $this->display();
        }
    }

    /**
     * 我的报表页面电子开盘
     *
     * @create 2018-3-2
     * @author qzb
     */
    public function dz_index()
    {
        $pid = I('p', 0, 'intval');
        $bid = I('b', 0, 'trim');
        $uid=$this->get_user_id();
        $this->assign('pid', $pid);
        $this->assign('bid', $bid);
        $projinfo=M()->table("xk_kppc k")->field("k.*,p.name pname")->join("xk_project p ON p.id=k.proj_id")->where("k.proj_id=".$pid." AND k.id=".$bid)->find();
//        echo $pid."-".$bid;exit;
        if(empty($projinfo))
        {
            session("USER_ID",null);
            $this->error('数据异常，请重新登录！', U('logging/index'));
        }
            $user = M()->table("xk_user")->where("id=$uid")->find();
            $user_where['userid']=$uid;
        $pd=M()->table("xk_station2user su")->field("su.id,p.id pid,sp.proj_id,sp.pc_id,e.id eid")->
        join("xk_station2pc sp ON su.station_id=sp.station_id")->
        join("LEFT JOIN xk_event_order_house e ON e.project_id=sp.proj_id AND e.batch_id=sp.pc_id")->
        join("LEFT JOIN xk_pzcsvalue p ON p.project_id=sp.proj_id AND p.batch_id=sp.pc_id AND p.pzcs_id=1 AND cs_value=-1")->
        where("su.userid=$uid")->count();
        $this->assign('count', $pd);
        $this->assign('user', $user);
        $this->display();
    }
    /**
     * 修改密码
     *
     * @create 2017-10-17
     * @author qzb
     */
    public function update_user()
    {

        $oldpwd = I('old_pwd', '', 'trim');
        $newpwd = I('new_pwd', '', 'trim');

        $uid = $this->get_user_id();
        $model = D("user");
        $userinfo = $model->where("id=$uid")->find();
        if ($userinfo['password'] <> md5(md5($oldpwd))) {
            echo "false1";
            exit;
        }
        if ($userinfo['password'] == md5(md5($newpwd))) {
            echo "false2";
            exit;
        }
        $data['password'] = md5(md5($newpwd));
        $bz = $model->where('id=' . $uid)->save($data);
        if ($bz) {
            session('USER_ID', null);
            echo "true";
            exit;
        }
    }
}

