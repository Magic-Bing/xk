<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/9 0009
 * Time: 10:33
 */

namespace Account\Controller;
/**
 * 基础数据管理-户型设置
 *
 * @create 2017-10-09
 * @author qzb
 */

class HxsetController extends BaseController

{
    /**
     * 系统构造函数
     *
     * @create 2017-10-09
     * @author qzb
     */
    public function _initialize()
    {
        parent::_initialize();

        //分类名称
        $this->assign('classify_name', '基础数据设置');

        //设置当前方法
        $this->set_current_action('jcsj_hxset', 'jcsj');
    }

    /**
     * 户型设置
     *
     * @create 2017-10-09
     * @author qzb
     */
    public function index()
    {
        //项目ID
        $search_project_id = I('project_id', 0, 'intval');
        
        $search_batch_id = I('batch_id',0, 'intval');
        $search_word = I('word', '', 'trim');
        $this->assign('bid', $search_batch_id);
        //当前用户的项目
        $user_project_ids = $this->get_user_project_ids();
        $pids=array_merge($user_project_ids);
        $str_p=implode(",",$pids);
        if (empty($user_project_ids)) {
            $user_project_ids = array('-99999');
        } else {
            /*if (empty($search_project_id)) {
                $search_project_id=$user_project_ids[0];
            }*/
        }

        //项目
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
         //设置当前搜索
        $search = array(
            'search_project_id' => $search_project_id,
            'search_word' => $search_word,
        );
        $this->assign($search);
        //用户的项目批次
        $user_batch_ids = $this->get_user_batch_ids();
        $bids=array_merge($user_batch_ids);
        $str_b=implode(",",$bids);
        //批次
        if (!empty($user_batch_ids)) {
            $user_batch_where['id'] = array('in', $user_batch_ids);
        } else {
            $user_batch_where['id'] = '-99999';
        }
        $user_batch_where['proj_id'] = $search_project_id;
        $batch_list = D('Batch')->getList($user_batch_where, '*');
        $this->assign('batch_list', $batch_list);


        //项目条件
        if (!empty($search_project_id)) {
            $p = "AND h.project_id=$search_project_id";
        } else {
            $p = "AND h.project_id in ($str_p)";
        }

        //批次条件
        if (!empty($search_batch_id)) {
            $b = "AND h.batch_id=$search_batch_id";
        } else {
            $b = "AND h.batch_id in ($str_b)";
        }

        //搜索查询
        if (!empty($search_word)) {
            $h = "AND h.hx like '%$search_word%'";
        } else {
            $h = "";
        }
        //总数
        $hx_count = M()->table("xk_hxset h")->where("1=1 $p $b $h")->count();
        $listRows = I('r', '10', 'intval');
        //分页
        $Page = $this->bootstrapPage($hx_count, $listRows);
        $page_show = $Page->show();
        $total_pages = $Page->totalPages;

        //取范围
        $limit = $Page->firstRow . ',' . $Page->listRows;
        $hx_list = M()->table("xk_hxset h")->field("h.*,p.name pname,k.name bname")->
        join("xk_project p ON p.id=h.project_id")->
        join("xk_kppc k ON k.id=h.batch_id")->
        where("1=1 $p $b $h")->limit($limit)->select();
        $p = I('p', '1', 'intval');
        $this->assign('p', $p);
        $this->assign('total_pages', $total_pages);
        $this->assign('hx_count', $hx_count);
        $this->assign('page_show', $page_show);
        $this->assign('listRows', $listRows);
        $this->assign('hx_list', $hx_list);
        $this->set_seo_title("户型设置");
        $this->display();
    }

    /**
     * 2017-10-9
     * 增加户型
     * qzb
     */
    public function add_hx()
    {

        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->saveName = array('uniqid','');
        $upload->savePath  =      '../Uploads/img/hximg/'; // 设置附件上传目录    // 上传单个文件
        $upload->autoSub  = true;
        $upload->subName  = array('date','Ymd');
        $info   =   $upload->uploadOne($_FILES['imgurl']);
        if(!$info) {// 上传错误提示错误信息
        echo "false";exit;
        }else{// 上传成功 获取上传文件信息
//            echo $info['savepath'].$info['savename'];
            $path= "/Uploads/img/hximg/".date("Ymd",time())."/".$info['savename'];
            $data=$_POST;
            $data['imgurl']=$path;
            $pd=M()->table("xk_hxset")->add($data);
            echo $pd?"true":"false";exit;
        }
    }

    /*
     * 2017-10-10
     * 删除户型
     * qzb*/

    public function delete_hx(){
        $id=I("id",0,"intval");
        $res=M()->table("xk_hxset")->field("imgurl")->where("id=$id")->select();
        $pd=M()->table("xk_hxset")->where("id=$id")->delete();
          if($pd){
              unlink($_SERVER['DOCUMENT_ROOT']."/Uploads/".$res[0]['imgurl']);//删除服务器上的图片
          }
        echo $pd?"true":"false";
    }

    /*
     * 2017-10-10
     * 修改编辑户型的数据
     * qzb*/
    public function update_hx(){
        $file=$_FILES['imgurl'];
        $data=$_POST;
       if($file['name']){
           $upload = new \Think\Upload();// 实例化上传类
           $upload->maxSize   =     3145728 ;// 设置附件上传大小
           $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
           $upload->saveName = array('uniqid','');
           $upload->savePath  =      '../Uploads/img/hximg/'; // 设置附件上传目录    // 上传单个文件
           $upload->autoSub  = true;
           $upload->subName  = array('date','Ymd');
           $info   =   $upload->uploadOne($file);
           if(!$info) {// 上传错误提示错误信息
               echo "false";exit;
           }else{// 上传成功 获取上传文件信息
//            echo $info['savepath'].$info['savename'];
               $data['imgurl']= "/Uploads/img/hximg/".date("Ymd",time())."/".$info['savename'];
           }
       }
        $id=$data['id'];
        unset($data['id']);
//        echo json_encode($data);exit;
        $res="";
        if($file['name']){
            $res=M()->table("xk_hxset")->field("imgurl")->where("id=$id")->select();
        }

        $pd=M()->table("xk_hxset")->field("hx,hxmx,area,tnarea,imgurl")->where("id=$id")->save($data);
        if($file['name']) {
            if ($pd) {
                unlink($_SERVER['DOCUMENT_ROOT'] . "/Uploads/" . $res[0]['imgurl']);//删除服务器上的图片
            }
        }
        echo $pd?"true":"false";exit;
    }
}