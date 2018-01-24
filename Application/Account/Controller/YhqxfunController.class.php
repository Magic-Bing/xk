<?php
/**
 * Created by PhpStorm.
 * User: qzb
 * Date: 2017/12/19 0019
 * Time: 15:44
 * Content: 岗位功能权限
 */

namespace Account\Controller;


class YhqxfunController extends BaseController
{
    public function _initialize() {
        parent::_initialize();

        //分类名称
        $this->assign('classify_name', '用户权限设置');

        //设置当前方法
        $this->set_current_action('yhqx_fun', 'yhqx');
    }

    //功能权限页面
    public function index(){
        $Model=M();
        $uid=$this->get_user_id();
        $is_all=$Model->table("xk_user")->field("is_all")->where("id=$uid")->find();
        $compid = I('compid');
        $companys = $this->get_user_company();
        if (empty($compid) || $compid==0)
        {
            $compid=$companys[0]['id'];
        }
        if (!empty($compid) && $compid<>0)
        {
            //岗位列表
            $stationlist=$Model->query("select name  as projname,status,NULL as id, cp_id, id as proj_id,NULL as name,NULL as code  from xk_project where cp_id=" . $compid . "  union all select b.name  as projname,b.status,a.* from xk_station a left join xk_project b on a.proj_id=b.id where a.cp_id=" . $compid . " order by cp_id,proj_id,id" );
            $this->assign('stationlist', $stationlist);
            $mk_checked=$Model->table("xk_fun_station")->field("fun_id")->where("station_id={$stationlist[0]['id']}")->select();
            $this->assign('mk_checked', $mk_checked);
            if((int)$is_all['is_all']===1){
                $one_mk=$Model->table("xk_fun")->where("parent_id=0")->order("px ASC")->select();
                $this->assign('one_mk', $one_mk);
                $two_mk=$Model->table("xk_fun")->where("parent_id<>0 AND is_Enable=1")->order("px ASC")->select();
                $this->assign('two_mk', $two_mk);
            }else{
               $sid=$Model->table("xk_station2user")->field("station_id")->where("userid=$uid")->select();
               if(!$sid){
                   $this->error_page();
               }
               $arr=[];
               for($i=0;$i<count($sid);$i++){
                    $arr[]=$sid[$i]['station_id'];
               }
                $arr_string=implode(",",$arr);
                $fid=$Model->table("xk_fun_station")->field("fun_id")->where("station_id in ({$arr_string})")->select();
                $arr1=[];
                for($i=0;$i<count($fid);$i++){
                    $arr1[]=$fid[$i]['fun_id'];
                }
                $arr_string1=implode(",",$arr1);
                $one_mk=$Model->table("xk_fun")->where("parent_id=0 AND id in ({$arr_string1})")->order("px ASC")->select();
                $this->assign('one_mk', $one_mk);
                $two_mk=$Model->table("xk_fun")->where("parent_id<>0 AND is_Enable=1 AND id in ({$arr_string1})")->order("px ASC")->select();
                $this->assign('two_mk', $two_mk);
            }

        }
        $this->set_seo_title("岗位功能权限");
        $this->assign('companys', $companys);
        $this->assign('compid', $compid);
//        $this->assign('is_all', (int)$is_all['is_all']);
        $this->display();
    }

    //获取角色已选择的模块
    public function getFun(){
        $sid=I("sid/d");
        $mk_checked=M()->table("xk_fun_station")->field("fun_id")->where("station_id=$sid")->select();
        echo json_encode($mk_checked);exit;
    }
    //添加修改权限到表
    public function updateFun(){
        $funs=I("funs/a");
        M()->table("xk_fun_station")->where("station_id={$funs[0]['station_id']}")->delete();
        M()->table("xk_fun_station")->addAll($funs);
        echo "修改成功";exit;
    }
}