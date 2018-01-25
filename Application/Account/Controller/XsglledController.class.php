<?php
namespace Account\Controller;

/**
 * led显示
 *
 * @create 2017-05-15
 * @author jxw
 */
class XsglledController extends BaseController {

    /**
     * 系统构造函数
     *
     * @create 2017-04-17
     * @author jxw
     */
    public function _initialize() {
        parent::_initialize();

        //分类名称
        $this->assign('classify_name', '电子开盘');
        //设置当前方法
        $this->set_current_action('xsgl_led', 'xsgl');
    }

    public function index() {
                $user_where['userid'] = $this->get_user_id(); 
                $Model = new \Think\Model();
                $usertype=$Model ->query("select * from xk_user where id='" . $user_where['userid'] . "' ");
                if (empty($usertype) || $usertype[0]['type']<1)
                    redirect(U('login/index'), 0);
                
                
                //项目ID
		$search_project_id = I('project_id', 0, 'intval');
		$search_word = I('word', '', 'trim');
		$pd = I('pd', '', 'trim');
        $search_batch_id = I('batch_id',0, 'intval');
		//设置当前搜索
		$search = array(
			'search_project_id' => $search_project_id,
			'search_word' => $search_word,
			'pd' => $pd,
			'search_batch_id' => $search_batch_id,
		);
		$this->assign($search);

		//项目
		$Project = D('Common/Project');
		
		//获取当前项目
		$project_info = $Project->getProjectById($search_project_id);
		$this->assign('project', $project_info);
		
		//当前用户ID
		$user_id = $this->get_user_id();
		
		//当前用户的项目
		$user_project_ids = $this->get_user_project_ids();
		if (empty($user_project_ids)) {
			$user_project_ids = array('-99999');
		}
		
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
                
                
                $this->set_seo_title("LED显示");
                $this->display();
    }
}
