<?php

namespace Account\Controller;

/**
 * 岗位权限管理
 *
 * @create 2017-05-03
 * @author jxw
 */
class YhqxprojController extends BaseController {

    /**
     * 系统构造函数
     *
     * @create 2017-05-03
     * @author jxw
     */
    public function _initialize() {
        parent::_initialize();

        //分类名称
        $this->assign('classify_name', '用户权限设置');

        //设置当前方法
        $this->set_current_action('yhqx_proj', 'yhqx');
    }

    /**
     * 岗位权限设置
     *
     * @create 2017-05-04
     * @author jxw
     */
    public function index() {
        $Model = new \Think\Model();

        $compid = I('compid');
        $companys = $this->get_user_company();
        if (empty($compid) || $compid==0)
        {
            $compid=$companys[0]['id'];
        }

        if (!empty($compid) && $compid<>0)
        {
            //选择公司取值
            $selectedcomp=$Model->query("SELECT a.* FROM xk_company a where  a.id= " . $compid . " and 2=2 " );
            $this->assign('selectedcomp', $selectedcomp[0] );
            $companylist=$Model->query("SELECT a.* FROM xk_company a where  2=2 order by a.id asc" );
            $this->assign('companylist', $companys);

            //岗位列表
            $stationlist=$Model->query("select name  as projname,status,NULL as id, cp_id, id as proj_id,NULL as name,NULL as code  from xk_project where cp_id=" . $compid . "  union all select b.name  as projname,b.status,a.* from xk_station a left join xk_project b on a.proj_id=b.id where a.cp_id=" . $compid . " order by cp_id,proj_id,id" );
            if (!empty($stationlist))
            {
                //第一个岗位下用户列表
                $pclist=$Model->query("SELECT a.*  FROM xk_station2sjqx a where a.station_id=" . $stationlist[0]['id'] . " and 2=2 order by a.id asc" );
                $this->assign('pclist', $pclist);
            }

            $this->assign('stationlist', $stationlist);
            $pro=$Model->table("xk_project")->field("id,name")->where("cp_id =$compid")->select();
            $this->assign('pro', $pro);
        }
        $this->set_seo_title("岗位数据权限");
        $this->display();
    }
    
    public function editstation(){
        if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('index'));
		}
        $id = I('id', '', 'trim');
        if (empty($id)|| $id==0)
        {
            $this->error("数据错误，请确认后重试！", U('index'));
        }
        $Model = new \Think\Model(); 
        $stationinfo=$Model->query("SELECT a.*,b.name as compname FROM xk_station a left join xk_company b on a.cp_id=b.id where a.id=" . $id . " and 11=11" );
        $this->success($stationinfo[0]);
        $this->display();
    }

    public function savestation(){
        if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('index'));
		}
        
        $id = I('id', 0, 'trim');
        $cp_id = I('compid', 0, 'trim');
        $name = I('name', '', 'trim');
        $proj_id = I('proj_id',0, 'intval');
        if (empty($id)||$id==0)
        {
            $data['cp_id']=$cp_id;
            $data['name']=$name;
            $data['proj_id']=$proj_id;
            $model = M("station");  
            $model->add($data);
        }
        else
        {
            //$data['cp_id']=$cp_id;
            $data['name']=$name;
            $data['proj_id']=$proj_id;
            $model = M("station");  
            $model->where('id='.$id)->save($data);
        }
        $this->success('保存成功！', '',true);
    }
    public function getprojpclist()
    {
		if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('admin/index'));
		}
                $station_id = I('station_id', '', 'trim');
                $cp_id = I('cp_id', '', 'trim');
                $type = I('type', '', 'trim');
                $pid = I('pid', 0, 'intval');
                if (empty($station_id)||$station_id==0)
                {
                    $this->error("数据错误，请重试");
                }
//                echo json_encode($type);exit;
                $Model = new \Think\Model();
                if ($type=="zj")
                {
                        $pclist=$Model->query("SELECT a.* FROM xk_station2sjqx a  WHERE a.station_id=".$station_id."  and a.cp_id= ".$cp_id." and a.is_yx=1 and 99=99 ORDER BY  a.id asc" );

                }
                else
                {
                    if($pid!==0){
                        $pclist=$Model->query("SELECT a.* FROM (select pc.*,pj.name as projname,pj.cp_id from xk_kppc pc left join xk_project pj on .pc.proj_id=pj.id where pj.status=1) a  left join  (select * from xk_station2sjqx where station_id=" .$station_id.") b on a.id=b.pc_id  WHERE  a.cp_id= ".$cp_id ." and a.proj_id = $pid and  b.id is null and a.is_yx=1 and 88=88 ORDER BY  a.proj_id,a.id asc" );
                    }else{
                        $pclist=$Model->query("SELECT a.* FROM (select pc.*,pj.name as projname,pj.cp_id from xk_kppc pc left join xk_project pj on .pc.proj_id=pj.id where pj.status=1) a  left join  (select * from xk_station2sjqx where station_id=" .$station_id.") b on a.id=b.pc_id  WHERE  a.cp_id= ".$cp_id ." and  b.id is null and a.is_yx=1 and 88=88 ORDER BY  a.proj_id,a.id asc" );
                    }

                }
		$this->success($pclist);
    }
    
    public function stationdelpc(){
        if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('admin/index'));
		} 
        $id = I('id');
        $station_id = I('stationid');
        if (empty($id)||$id==0)
        {
            $this->error("数据错误，请重试");
        }
        else
        {
            $Model1 = new \Think\Model();
            $pclist=$Model1->query("SELECT a.* FROM  xk_station2pc a where a.id=" . $id );
            if (!empty($pclist) && count($pclist)>0)
            {
                $proj_id=$pclist[0]['proj_id'];
                $model = M("station2pc");  
                $model->where('id='.$id .' and station_id='. $station_id)->delete();
                
                $Model1 = new \Think\Model(); 
                //删除后判断本岗位本项目下岗位批次权限是否为空，如果为空，需要删除岗位项目数据
                $projlist=$Model1->query("SELECT a.* FROM xk_station2proj a left join (select * from xk_station2pc where station_id=". $station_id.") b on a.proj_id=b.proj_id where b.proj_id is null  and a.proj_id=". $proj_id . " and  a.station_id=" . $station_id );
                if (!empty($projlist) && count($projlist)>0)
                {
                    $model = M("station2proj");  
                    $model->where('id='.$projlist[0]['id'] .' and station_id='. $station_id)->delete();
                }
            }
        }
        $this->success('操作成功！', '',true);
    } 
    
     public function stationaddpc(){
        if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('admin/index'));
		} 
        $station_id = I('station_id');
        $pclist=I('pclist');
        if (empty($station_id)||$station_id==0)
        {
            $this->error("数据错误，请重试");
        }
        else
        {
            $Model1 = new \Think\Model(); 
            $pctemp=explode("|",$pclist); 
            $model = M("station2pc");
            $modelp = M("station2proj"); 
            foreach ($pctemp as $pctemp_k => $pctemp_v)
            {
                $data['station_id']=$station_id;
                $pcs=explode("]",$pctemp_v);
                $data['pc_id']=$pctemp_v;
                $data['pc_id']=$pcs[0];   
                $data['proj_id']=$pcs[1]; 
                $model->add($data);
                $station2proj=$Model1->query("SELECT a.* FROM  xk_station2proj a where  a.station_id=" .$station_id. " and  a.proj_id=" . $pcs[1] );
                if(empty($station2proj)|| count($station2proj)==0)
                {
                     $data1['station_id']=$station_id;
                     $data1['proj_id']=$pcs[1]; 
                    $modelp->add($data1);
                }
            }
        }
        $this->success('操作成功！', '',true);
    }
}

