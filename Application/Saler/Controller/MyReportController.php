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
     * 我的报表页面
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
            $this->assign('user_project_list', $user_project_list);
            $this->assign('user', $user);
            $this->assign('search_hd_id', $hid);
            $this->display();
        }
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

