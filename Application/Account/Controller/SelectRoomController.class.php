<?php
/**
 * Created by PhpStorm.
 * User: qzb
 * Date: 2018/2/7 0007
 * Time: 14:26
 */

namespace Account\Controller;


class SelectRoomController extends BaseController
{

    public function _initialize() {
        parent::_initialize();

        //分类名称
        $this->assign('classify_name', '电子开盘');
        //设置当前方法
        $this->set_current_action('select_room', 'room');
    }
    public function index()
    {

        //项目ID
        if (isset($_POST['project_id'])) {
            $search_project_id = I('project_id', 0, 'intval');
            session("selected_project", $search_project_id);
        } else {
            $search_project_id = session("selected_project");
        }
        $this->assign('search_project_id', $search_project_id);
        $user_project_ids = $this->get_user_project_ids();

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
        //列表数据获取
        $where2=" 222=222 ";
        if (!empty($user_project_ids)) {
            $projectids = str_replace(",","','",implode(",",$user_project_ids));
            $where2.=" and  k.proj_id in('{$projectids}')";
        }
        if (!empty($user_batch_ids)) {
            $batchids = str_replace(",","','",implode(",",$user_batch_ids));
            $where2.=" and k.id in('{$batchids}')";
        }
        if (!empty($search_project_id))
        {
            $where2.=" and k.proj_id={$search_project_id}";
        }

        //总数
        $dqlist_old=M()->table("xk_kppc k")->where($where2)->count();
        //分页
        $count=count($dqlist_old);
        $Page = $this->bootstrapPage($count, 15);
        $page_show = $Page->show();
        $total_pages = $Page->totalPages;
        //取范围
        $limit = $Page->firstRow . ',' . $Page->listRows;
        $res=M()->table("xk_kppc k")->field("k.*,p.name pname")->join("xk_project p ON p.id=k.proj_id")->where($where2)->limit($limit)->select();
        $p = I('p', '1', 'intval');
        $this->assign('p', $p);
        $this->assign('res', $res);
        $this->assign('total_pages', $total_pages);
        $this->assign('count', $count);
        $this->assign('page_show', $page_show);
        $this->set_seo_title("快速选房");
        $this->display();
    }
}