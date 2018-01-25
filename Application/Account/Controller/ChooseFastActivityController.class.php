<?php

namespace Account\Controller;

/**
 * 快速开启活动
 *
 * @create 2016-12-29
 * @author zlw
 */
class ChooseFastActivityController extends BaseController {

    /**
     * 系统构造函数
     *
     * @create 2016-12-28
     * @author zlw
     */
    public function _initialize() {
        parent::_initialize();

        //分类名称
        $this->assign('classify_name', '竞价选房');

        //设置当前方法
        $this->set_current_action('choose_fast_activity', 'choose');
    }

    /**
     * 竞价选房
     *
     * @create 2016-12-19
     * @author zlw
     */
    public function index() {
        //项目ID
        $search_project_id = I('get.project_id', '0', 'intval');
        $search_batch_id = I('get.batch_id', '0', 'intval');
        $search_word = I('get.word', '', 'trim');

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

        $ChooseactivityView = D('Common/ChooseactivityView');

        //条件
        $choose_activity_where = array();
        if (!empty($search_project_id)) {
            $choose_activity_where['Kppc.proj_id'][] = $search_project_id;
        }
        if (!empty($search_batch_id)) {
            $choose_activity_where['Kppc.id'][] = $search_batch_id;
        }

        //项目条件
        if (!empty($user_project_ids)) {
            $choose_activity_where['Kppc.proj_id'][] = array('in', $user_project_ids);
        } else {
            $choose_activity_where['Kppc.proj_id'][] = '-99999';
        }

        //批次条件
        if (!empty($user_batch_ids)) {
            $choose_activity_where['Kppc.id'][] = array('in', $user_batch_ids);
        } else {
            $choose_activity_where['Kppc.id'][] = '-99999';
        }

        //搜索查询
        if (!empty($search_word)) {
            $choose_activity_like_where['ChooseActivity.name'] = array('like', '%' . $search_word . '%');
            $choose_activity_like_where['Project.name'] = array('like', '%' . $search_word . '%');
            $choose_activity_like_where['_logic'] = 'or';
            $choose_activity_where['_complex'] = $choose_activity_like_where;
        }

        //总数
        $choose_activity_count = $ChooseactivityView->where($choose_activity_where)->count();

        //分页
        $Page = $this->bootstrapPage($choose_activity_count, 10);
        $page_show = $Page->show();
        $total_pages = $Page->totalPages;

        //取范围
        $limit = $Page->firstRow . ',' . $Page->listRows;

        $choose_activity_list = $ChooseactivityView->getList(
                $choose_activity_where, '*', 'sort DESC, start_time DESC, id DESC', $limit
        );

        if (!empty($choose_activity_list)) {
            foreach ($choose_activity_list as $choose_activity_key => $choose_activity_value) {
                $choose_activity_list[$choose_activity_key]['user_count'] = D('ChooseLog')->where(array('activity_id' => $choose_activity_value['id']))->count();
            }
        }

        $p = I('get.p', '1', 'intval');
        $this->assign('p', $p);
        $this->assign('total_pages', $total_pages);
        $this->assign('count', $choose_activity_count);
        $this->assign('page_show', $page_show);

        $this->assign('choose_activity_list', $choose_activity_list);

        $this->set_seo_title("快速开启活动");
        $this->display();
    }

    /**
     * 添加
     *
     * @create 2016-12-19
     * @author zlw
     */
    public function add() {
        if (!IS_AJAX) {
            $this->error("提交错误，请确认后重试！");
        }

        $project_id = I('project_id', 0, 'intval');
        $batch_id = I('batch_id', 0, 'intval');

        $person_count = I('person_count', 0, 'intval');
        $long_time = I('long_time', 0, 'intval');

        $type = I('type', '', 'trim');

        $start_time = strtotime(I('start_time', '', 'trim'));
        $start_time = !empty($start_time) ? $start_time : time();
        $end_time = I('end_time', '', 'trim');
        $end_time = !empty($end_time) ? $end_time : ($start_time + $long_time);

        $name = I('name', '快速开启活动', 'trim');
        $description = I('description', '快速开启的活动', 'trim');

        $sort = I('sort', '0', 'intval');

        $remark = I('remark', '快速开启的活动', 'trim');
        $status = I('status', '1', 'trim');

        if ($project_id == 0 || $batch_id == 0 || $start_time == 0
        ) {
            $this->error("信息不能为空，请确认后重试！");
        }

        $user_project_ids = $this->get_user_project_ids();
        if (!in_array($project_id, $user_project_ids)) {
            $this->error("项目错误，请选择正确的项目！");
        }

        $ChooseActivity = D('ChooseActivity');

        $data['name'] = $name;
        $data['description'] = $description;
        $data['project_id'] = $project_id;
        $data['batch_id'] = $batch_id;

        if ($sort == 0 || empty($sort)) {
            $activity_count_where['project_id'] = $project_id;
            $activity_count_where['batch_id'] = $batch_id;
            $activity_count = $ChooseActivity->where($activity_count_where)->count();

            $sort = $activity_count + 1;

            $activity = $ChooseActivity->getOne($activity_count_where, '*', 'sort DESC');
            if ($activity['sort'] >= $sort) {
                $sort = $activity['sort'] + 1;
            }

            $data['sort'] = $sort;
        }

        $data['person_count'] = $person_count;
        $data['start_time'] = $start_time;
        $data['end_time'] = $end_time;
        $data['long_time'] = $long_time;
        $data['type'] = $type;

        $data['remark'] = $remark;
        $data['status'] = $status;
        $data['add_user_id'] = $this->get_user_id();
        $data['add_time'] = time();
        $data['add_ip'] = get_client_ip(0, true);

        $chech_has_add = $ChooseActivity->addOne($data);
        if (false === $chech_has_add) {
            $this->error("添加失败，请稍后重试！");
        } else {
            $this->success("添加成功！", '');
        }
    }

}
