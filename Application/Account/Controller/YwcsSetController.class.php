<?php

namespace Account\Controller;

class YwcsSetController extends BaseController {

    /**
     * 系统构造函数
     *
     * @create 2018-01-26
     * @author jxw
     */
    public function _initialize() {
        parent::_initialize();

        //分类名称
        $this->assign('classify_name', '基础数据设置');

        //设置当前方法
        $this->set_current_action('jcsj_ywcsset', 'jcsj');
    }

    /**
     * 业务参数设置
     *
     * @create 2017-05-04
     * @author jxw
     */
    public function index() {
        //项目ID
        if(isset($_POST['project_id'])){
            $search_project_id = I('project_id', 0, 'intval');
            session("selected_project",$search_project_id);
        }else{
            $search_project_id = session("selected_project");
        }
        //批次ID
        $search_batch_id = I('batch_id',0, 'intval');
        
        //用户的项目  
        $user_project_ids = $this->get_user_project_ids();
        if (empty($user_project_ids)) {
            $user_project_ids = array('-99999');
        }
        if ($search_project_id != 0) {
            if (!in_array($search_project_id, $user_project_ids)) {
                $this->error("你没有权限访问该项目的信息！");
            }
        }
        //用户的批次
        $user_batch_ids = $this->get_user_batch_ids();
        if (empty($user_batch_ids)) {
            $user_batch_where['id'] = '-99999';
        } 
        if ($search_batch_id != 0) {
            if (!in_array($search_batch_id, $user_batch_ids)) {
                $this->error("你没有权限访问该项目批次的信息！");
            }
        } 
        //获取项目信息
        $Project = D('Common/Project');
        $project_where['status'] = 1;
        $project_where['id'] = array('in', $user_project_ids);
        $project_list = $Project->getProjectList($project_where,'cp_id DESC, id DESC' );
        
        if (empty($search_project_id)) { 
            $search_project_id=$project_list[0]["id"] ;      
        }
        //获取批次信息
        $batch_where['proj_id'] = $search_project_id;
        $batch_where['xk_kppc.is_yx'] = 1;
        $batch_where['xk_kppc.id'] = array('in', $user_batch_ids);
        $batch_list = D('Batch')->join("left join xk_project b on b.id=xk_kppc.proj_id")->getList($batch_where, 'xk_kppc.*,b.name as pname');
        if (empty($search_batch_id)) { $search_batch_id=$batch_list[0]["id"]; }
        
        $this->assign('search_project_id', $search_project_id);
        $this->assign('search_batch_id', $search_batch_id);
        
        $this->assign('project_list', $project_list);
        $this->assign('batch_list', $batch_list);
        
        //开盘模式
         $kpmsinfo=D("pzcs a")->field("a.*,b.id as bid,b.name as bname,b.proj_id as pid,cs.cs_value,cs.id as cs_id")
                ->join("inner join xk_kppc b on 1=1")
                ->join("left join (select * from xk_pzcsvalue cs where cs.batch_id=$search_batch_id and cs.project_id=$search_project_id ) cs on cs.pzcs_id=a.id")
                ->where("a.yw_type='批次' and   b.id=$search_batch_id and b.proj_id=$search_project_id and a.group_id=0 ")
                ->order("a.group_id,a.px")->select();
        //电子开盘参数
        $dzkp_cslist=D("pzcs a")->field("a.*,b.id as bid,b.name as bname,b.proj_id as pid,cs.cs_value,cs.id as cs_id")
                ->join("inner join xk_kppc b on 1=1")
                ->join("left join (select * from xk_pzcsvalue cs where cs.batch_id=$search_batch_id and cs.project_id=$search_project_id ) cs on cs.pzcs_id=a.id")
                ->where("a.yw_type='批次' and   b.id=$search_batch_id and b.proj_id=$search_project_id and a.group_id=1 and 888=888")
                ->order("a.group_id,a.px")->select();
        //微信开盘参数
        $wxkp_cslist=D("pzcs a")->field("a.*,b.id as bid,b.name as bname,b.proj_id as pid,cs.cs_value,cs.id as cs_id")
                ->join("inner join xk_kppc b on 1=1")
                ->join("left join (select * from xk_pzcsvalue cs where cs.batch_id=$search_batch_id and cs.project_id=$search_project_id ) cs on cs.pzcs_id=a.id")
                ->where("a.yw_type='批次' and   b.id=$search_batch_id and b.proj_id=$search_project_id and a.group_id=2")
                ->order("a.group_id,a.px")->select();
        
         if ($kpmsinfo[0]['cs_value']==-1){
              $kpmsinfo[0]['showdzkp']="none";
              $kpmsinfo[0]['showwxkp']="block";
         }
         else{
             $kpmsinfo[0]['showdzkp']="block";
             $kpmsinfo[0]['showwxkp']="none";
         }
        
        $this->assign('kpmsinfo', $kpmsinfo[0]); 
        $this->assign('dzkplist', $dzkp_cslist);
        $this->assign('wxkplist', $wxkp_cslist);
        //$this->assign('cstype', array(1=>'电子开盘',2=>'微信开盘')); 
        $this->set_seo_title("参数设置");
        $this->display();
    }
    //添加修改权限到表
    public function updateCsset(){
        $cslist=I("cslist/a");
        $pid=$cslist[0];
        $bid=$cslist[1];
        if(empty($pid)||empty($bid))
        {
            echo "系统错误";exit;
        }
        $allcs=$cslist[2];
        foreach($allcs as $k=>$cs)
        {
            //if($cs["id"]==0){
                $addcs[$k]["project_id"]=$pid;
                $addcs[$k]["batch_id"]=$bid;
                $addcs[$k]["pzcs_id"]=$cs["pzcs_id"];
                $addcs[$k]["cs_value"]=$cs["cs_value"];
                $ii++;
            //}
        }
        if($addcs)
        {
            M()->table("xk_pzcsvalue")->where("project_id=$pid and batch_id=$bid")->delete();
            M()->table("xk_pzcsvalue")->addAll($addcs);
        } 
        echo "保存成功";exit;
    }
}

