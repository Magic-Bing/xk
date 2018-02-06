<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/1 0001
 * Time: 15:07
 */

namespace Account\Controller;

class PrintingController extends  BaseController
{
    /**
     * 系统构造函数
     *
     * @create 2018-02-1
     * @author qzb
     */
    public function _initialize()
    {
        parent::_initialize();

        //分类名称
        $this->assign('classify_name', '基础数据设置');
    }
    public function index() {

        //项目ID
        if(isset($_POST['project_id'])){
            $search_project_id = I('project_id', 0, 'intval');
            session("selected_project",$search_project_id);
        }else{
            $search_project_id = session("selected_project");
        }
        $search_batch_id = I('batch_id',0, 'intval');
        //设置当前搜索
        $search = array(
            'search_project_id' => $search_project_id,
            'search_batch_id' => $search_batch_id,
        );
        $this->assign($search);

        //项目
        $Project = D('Common/Project');

        //获取当前项目
        $project_info = $Project->getProjectById($search_project_id);
        $this->assign('project', $project_info);


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
        //列表数据获取
        $where2="";
        if (!empty($user_project_ids)) {
            $projectids = str_replace(",","','",implode(",",$user_project_ids));
            $where2.=" pt.proj_id in('{$projectids}')";
        }
        if (!empty($user_batch_ids)) {
            $batchids = str_replace(",","','",implode(",",$user_batch_ids));
            $where2.=" and pt.pc_id in('{$batchids}')";
        }
        if (!empty($search_project_id))
        {
            $where2.=" and pt.proj_id={$search_project_id}";
        }
        if (!empty($search_batch_id))
        {
            $where2.=" and pt.pc_id={$search_batch_id}";
        }
        //总数
        $count=M()->table("xk_print pt")->where($where2)->count();
        //分页
        $Page = $this->bootstrapPage($count, 15);
        $page_show = $Page->show();
        $total_pages = $Page->totalPages;
        $res=M()->table("xk_print pt")->field("pt.*,p.name pname,k.name kname")->join("xk_project p ON p.id=pt.proj_id")->join("xk_kppc k ON k.id=pt.pc_id")->where($where2)->limit( $Page->firstRow,$Page->listRows)->select();
        $p = I('p', '1', 'intval');
        $this->assign('res', $res);
        $this->assign('p', $p);
        $this->assign('total_pages', $total_pages);
        $this->assign('count', $count);
        $this->assign('page_show', $page_show);
        $this->set_seo_title("套打设置");
        $this->display();
    }
    //生成模版
    public function add_mb(){
        $name=I("name",'','trim');
        $html=I("mb_html",'');
        $pid=I("pid",0,'intval');
        $bid=I("bid",0,'intval');
        $prid=I("prid",0,'intval');

        $str='<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"></head><body>';
        $str.=html_entity_decode($html);
        $str.='</body><script >window.print();</script></html>';
        $filename=time()."-mb.html";
        if($prid===0){
            if( ($new_file=fopen("Application/Account/View/Printing/".$filename,"w+")) === false){
                $this->error("创建模板失败，请重试！");
            }else{
                if(!fwrite ($new_file,$str)){ //将信息写入文件
                    unlink($new_file);
                    $this->error("内容插入失败，请重试！");
                }
                $arr['pc_id']=$bid;
                $arr['proj_id']=$pid;
                $arr['name']=$name;
                $arr['html_url']=$filename;
                M()->table("xk_print")->add($arr);
                $this->success("创建成功！");
            }
        }else{
            if( ($new_file=fopen("Application/Account/View/Printing/".$filename,"w+")) === false){
                $this->error("修改模板失败，请重试！");
            }else{
                if(!fwrite ($new_file,$str)){ //将信息写入文件
                    unlink($new_file);
                    $this->error("内容插入失败，请重试！");
                }
                $dname=M()->table('xk_print')->field("html_url")->where("id=$prid")->find();
                unlink("Application/Account/View/Printing/".$dname['html_url']);
                M()->table("xk_print")->where("id=$prid")->save(['html_url' => $filename]);
                $this->success("修改成功！");
            }
        }


    }

    //获取指定模版
    public function get_mb(){
        $id=I("id",0,'intval');
        $name=M()->table("xk_print")->field("html_url")->where("id=$id")->find();
        $arr=explode(".",$name['html_url']);
        echo $this->fetch("Printing:".$arr[0]);
    }

    //删除指定模版
    public function delete_mb(){
        $id=I("id",0,'intval');
        $name=M()->table("xk_print")->field("html_url")->where("id=$id")->find();
        unlink("Application/Account/View/Printing/".$name['html_url']);
        $pd=M()->table("xk_print")->where("id=$id")->delete();
        if($pd){
            $this->success("删除成功！");
        }else{
            $this->error("删除失败！");
        }

    }
}