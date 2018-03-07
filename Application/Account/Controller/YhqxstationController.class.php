<?php

namespace Account\Controller;

/**
 * 岗位用户管理
 *
 * @create 2017-05-03
 * @author jxw
 */
class YhqxstationController extends BaseController {

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
        $this->set_current_action('yhqx_station', 'yhqx');
    }

    /**
     * 岗位用户设置
     *
     * @create 2017-05-04
     * @author jxw
     */
    public function index() {
        $Model = new \Think\Model();
        if(isset($_POST['compid'])){
            $compid = I('compid', 0, 'intval');
            session("selected_company",$compid);
        }else{
            $compid = session("selected_company");
        }
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
                $userlist=$Model->query("SELECT a.*,b.name as username,b.code ,b.mobile   FROM xk_station2user a left join xk_user b on a.userid=b.id where a.station_id=" . $stationlist[0]['id'] . " and 2=2 order by a.id asc" );
                $this->assign('userlist', $userlist); 
            }

            $this->assign('stationlist', $stationlist);
            $pro=$Model->table("xk_project")->field("id,name")->where("cp_id =$compid")->select();
            $this->assign('pro', $pro);
        }


        $this->set_seo_title("岗位用户管理");
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
    public function getuserist()
    {
		if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('index'));
		}
                $station_id = I('station_id', '', 'trim');
                $cp_id = I('cp_id', '', 'trim');
                $type = I('type', '', 'trim');
                if (empty($station_id)||$station_id==0)
                {
                    $this->error("数据错误，请重试");
                }
                $Model = new \Think\Model(); 
                
                if ($type=="zj")
                {
                    $userlist=$Model->query("SELECT a.*,b.name as username,b.code ,b.mobile FROM xk_station2user a left join xk_user b on a.userid=b.id  WHERE a.station_id=" .$station_id . " and b.cp_id= ".$cp_id ." and 99=99 ORDER BY  a.id asc" );
                }
                else
                {
                    $userlist=$Model->query("SELECT a.* FROM xk_user a  left join  (select * from xk_station2user where station_id=" .$station_id .")  b on a.id=b.userid WHERE a.cp_id= ".$cp_id ." and  b.userid is null  and  a.is_all<>1 ORDER BY  a.id asc" );
                }
		$this->success($userlist);
    }
    
    public function stationdeluser(){
        if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('index'));
		} 
        $id = I('id');
        $station_id = I('stationid');
        if (empty($id)||$id==0)
        {
            $this->error("数据错误，请重试");
        }
        else
        {
            $model = M("station2user");  
            $model->where('id='.$id .' and station_id='. $station_id)->delete();
        }
        $this->success('操作成功！', '',true);
    } 
    
    public function stationadduser(){
        if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('index'));
		} 
        $station_id = I('station_id');
        $userlist=I('userlist');
        
        if (empty($station_id)||$station_id==0)
        {
            $this->error("数据错误，请重试");
        }
        else
        {
            $users=explode("|",$userlist);
            foreach ($users as $user_k => $user_v)
            {
                $data['station_id']=$station_id;
                $data['userid']=$user_v;
                $model = M("station2user");  
                $model->add($data);
            }
        }
        $this->success('操作成功！', '',true);
    }

    //删除岗位
    public function delete_station(){
        $id=I("id",0,"intval");
        M()->table("xk_station2pc")->where("station_id=$id")->delete();
        M()->table("xk_station2proj")->where("station_id=$id")->delete();
        M()->table("xk_station2user")->where("station_id=$id")->delete();
        M()->table("xk_station")->where("id=$id")->delete();
        $this->success("删除成功!");
    }
}

