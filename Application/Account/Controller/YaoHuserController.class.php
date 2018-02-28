<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/27 0027
 * Time: 14:37
 */

namespace Account\Controller;
/*
 * 手动设置用户的摇号
 * qzb
 * 2018-2-27
 * */

class YaoHuserController extends BaseController
{
    /**
     * 系统构造函数
     *
     *  2018-02-27
     *  qzb
     */
    public function _initialize() {
        parent::_initialize();

        //分类名称
        $this->assign('classify_name', '选房摇号');

        //设置当前方法
        $this->set_current_action('yaoh_set', 'yaoh');
    }
    /*
 * 摇号设置页面
 * qzb
 * 2018-2-27
 * */
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



        //条件
        $choose_where = array();
        if (!empty($search_project_id)) {
            $choose_where['choose.project_id'][] = $search_project_id;
        } else {
            //项目条件
            if (!empty($user_project_ids)) {
                $choose_where['choose.project_id'][] = array('in', $user_project_ids);
            } else {
                $choose_where['choose.project_id'][] = '-99999';
            }
        }
        $choose_where['choose.status'][] = 1;

        if (!empty($search_batch_id)) {
            $choose_where['choose.batch_id'][] = $search_batch_id;
        } else {
            //批次条件
            if (!empty($user_batch_ids)) {
                $choose_where['choose.batch_id'] = array('in', $user_batch_ids);
            } else {
                $choose_where['choose.batch_id'] = '-99999';
            }
        }

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
        $choose_count = M()->table("xk_choose choose")->where($choose_where)->count();
        $listRows = C("SIGN_PAGE_NUM");
        //分页
        $Page = $this->bootstrapPage($choose_count, $listRows);
        $page_show = $Page->show();
        $total_pages = $Page->totalPages;

        //取范围
        $limit = $Page->firstRow . ',' . $Page->listRows;
        $choose_list = M()->table("xk_choose choose")->field("choose.id,choose.customer_name,choose.customer_phone,choose.cardno,choose.cyjno,p.name project_name,p.id pid,k.name batch_name,k.id bid,yu.yh_group,yu.yh_group_px,yu.id yid,r.id rid")->
        join("LEFT JOIN xk_yaohuser yu ON yu.cst_id=choose.id")->
        join("LEFT JOIN xk_yaohresult r ON r.cstid=choose.id")->
        join("xk_project p ON p.id=choose.project_id")->
        join("xk_kppc k ON k.id=choose.batch_id")->where($choose_where)->limit($limit)->select();
        $p = I('p', '1', 'intval');
        $this->assign('p', $p);
        $this->assign('total_pages', $total_pages);
        $this->assign('choose_count', $choose_count);
        $this->assign('page_show', $page_show);
        $this->assign('listRows', $listRows);

        $this->assign('choose_list', $choose_list);

        $this->set_seo_title("摇号客户");

        $this->display();
    }

    /*
     * 新增记录或者修改记录
     * qzb
     * 2018-2-27*/
    public function add(){
        $yid=I("yid",0,"intval");
        $px=I("px",0,"intval");
        $cid=I("cid",0,"intval");
        $data['proj_id']=I("pid",0,"intval");
        $data['pc_id']=I("bid",0,"intval");
        $yh_pd=M()->table("xk_yaohresult")->where("cstid=$cid")->find();
        if($yh_pd){
            $this->error("该用户已经摇过号了，不能更改！");
        }
        $zd_pd=M()->table("xk_yaohset")->where($data)->find();
        if($zd_pd['mzgs'] < $px){
            $this->error("分组序号不能超过".$zd_pd['mzgs'].",请重新输入！");
        }
        $data['yh_group']=I("gp",0,"intval");
        $data['yh_group_px']=$px;
        $res=M()->table("xk_yaohuser")->where($data)->find();
        if($res){
            $this->error("该分组排序已存在，请重新输入！");
        }
        $data['cst_id']=$cid;

        if($yid===0){
            $res=M()->table('xk_yaohuser')->add($data);
            if($res){
                $this->success("设置成功！");
            }else{
                $this->error("设置失败，请重试！");
            }
        }else{
            $res=M()->table('xk_yaohuser')->where("id=$yid")->save($data);
            if($res){
                $this->success("更改成功！");
            }else{
                $this->error("更改失败，请重试！");
            }
        }

    }
}