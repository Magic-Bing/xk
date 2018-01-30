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
        $search_project_id = I('project_id', 0, 'intval');
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
        
        

        /*$p_ywcslist=D("pzcs a")->field("a.id,a.cs_name,a.cs_type,b.id as pid,b.name as pname")->join("inner join xk_project b on 1=1")->where(" a.yw_type='项目' and  b.id=$search_project_id")->select();*/
        $b_ywcslist=D("pzcs a")->field("a.id,a.cs_name,a.cs_type,b.id as bid,b.name as bname,b.proj_id as pid")->join("inner join xk_kppc b on 1=1")->where("a.yw_type='批次' and   b.id=$search_batch_id and b.proj_id=$search_project_id")->order("a.id desc")->select();
        
        /*$p_values=D("pzcsvalue a")->where("a.batch_id=0 and a.project_id=$search_project_id")->select();*/
        $b_values=D("pzcsvalue a")->where("a.batch_id=$search_batch_id and a.project_id=$search_project_id")->select();
        
       /* foreach($p_ywcslist as $k=>$pl)
        {
            foreach($p_values as $pv)
            {
                if($pl['id']==$pv['pzcs_id'] && $pl['pid']==$pv['project_id'])
                {
                    $p_ywcslist[$k]['cs_value']=$pv['cs_value'];
                    break;
                }
            }
        }*/
        $list=array();
        foreach($b_ywcslist as $k=>$bl)
        {
            foreach($b_values as $bv)
            {
                if($bl['id']==$bv['pzcs_id']  && $bl['pid']==$bv['project_id'] and $bl['bid']==$bv['batch_id'])
                {
                    
                    //$b_ywcslist[$k]['cs_value']=$bv['cs_value'];
                    switch ($bl["cs_name"])
                    {
                    case '开盘类型':
                      $list['kplx']['cs_value']=$bv['cs_value'];
                      $list['kplx']['cs_id']=$bv['id'];
                      break;  
                    case '自动签到':
                      $list['zdqd']['cs_value']=$bv['cs_value'];
                      $list['zdqd']['cs_id']=$bv['id'];
                      break; 
                    case '自动入场审核':
                      $list['zdrcsh']['cs_value']=$bv['cs_value'];
                      $list['zdrcsh']['cs_id']=$bv['id'];
                      break;  
                    case '是否摇号':
                      $list['isyh']['cs_value']=$bv['cs_value'];
                      $list['isyh']['cs_id']=$bv['id'];
                      break; 
                    case '快速选房显示信息':
                      $karr=explode(";",$bv['cs_value']);
                      $list['showinfo']['cs_value']=$karr;
                      $list['showinfo']['cs_id']=$bv['id'];
                      break; 
                    }
                    break;
                }
            }
        }
        $this->assign('list', $list);
        //快速选房显示内容选项
        $xfinfolist=['标准总价','优惠后总价','建筑面积','建筑单价','套内面积','套内单价','户型'];
        $this->assign('xfinfolist', $xfinfolist);
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

