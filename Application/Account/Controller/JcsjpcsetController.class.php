<?php

namespace Account\Controller;

/**
 * 基础数据管理-楼栋批次设置
 *
 * @create 2017-05-03
 * @author jxw
 */
class JcsjpcsetController extends BaseController {

    /**
     * 系统构造函数
     *
     * @create 2017-05-03
     * @author jxw
     */
    public function _initialize() {
        parent::_initialize();

        //分类名称
        $this->assign('classify_name', '基础数据设置');

        //设置当前方法
        $this->set_current_action('jcsj_pcset', 'jcsj');
    }

    /**
     * 楼送批次设置
     *
     * @create 2017-05-04
     * @author jxw
     */
    public function index() {
        $Model = new \Think\Model();
        if(isset($_POST['projid'])){
            $search_project_id = I('projid', 0, 'intval');
            session("selected_project",$search_project_id);
        }else{
            $search_project_id = session("selected_project");
        }
        $projid = $search_project_id;
        //可选项目取值
        $user_project_ids = $this->get_user_project_ids();
        $pids=array_merge($user_project_ids);
        $str_p=implode(",",$pids);
       if (!empty($projid)) {
            if(!in_array($projid,$user_project_ids)){
                $this->error("非法操作！",'/Account/Jcsjroom/room');
            }
            $where ="  a.proj_id = $projid" ;
        }else{
           $where ="  a.proj_id in ($str_p)" ;
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
                $project_list[] = $project_list_value;
            }
        } else {
            $project_list = array();
        }
        $this->assign('projectlist', $project_list);

            $kppc=$Model->query("SELECT a.*,case when is_yx=1 then '开启' else '关闭' end as zt,a.plan  FROM xk_kppc a where " . $where . "  order by is_yx desc,a.id asc" );
            
            $bldlist=$Model->query("SELECT a.*  FROM xk_build a where " . $where . "  order by a.proj_id asc,a.pc_id asc,a.id asc" );
            
            $kppclist=array();
            foreach ($kppc as $kppc_k => $kppc_v) {  
                foreach ($bldlist as $bldlist_k => $bldlist_v)
                {
                    if ($kppc_v['id']==$bldlist_v['pc_id'] && $kppc_v['proj_id']==$bldlist_v['proj_id'])
                        $kppc_v[$kppc_k][]=$bldlist_v;
                }
                $kppclist[]=$kppc_v;
            }
            $this->assign('projid', $projid);
            $this->assign('kppclist', $kppclist);
        $this->set_seo_title("批次设置");
        $this->display();
    }
    
    public function getbldlist()
    {
            if (!IS_AJAX) {
                    $this->error('请求错误，请确认后重试！', U('account/index'));
            }
            $pcid = I('pcid', '', 'trim');
            $projid = I('projid', '', 'trim');
            if (empty($pcid)||$pcid==0)
            {
                $this->error("数据错误，请重试");
            }
            if ($pcid==999)
                $pcid=0;
            $Model = new \Think\Model(); 

            $bldlist=$Model->query("SELECT a.* FROM xk_build a WHERE a.pc_id=" .$pcid . " and a.proj_id= ".$projid ."  ORDER BY  a.buildcode,a.id" );

            $this->success($bldlist);
    }
    
    public function pcdelbld(){
        if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('admin/index'));
		} 
        $id = I('id');
        $pcid = I('pcid');
        if (empty($id)||$id==0)
        {
            $this->error("数据错误，请重试");
        }
        else
        {
            $data['pc_id']=0;
            $model = M("build");  
            $model->where('id='.$id .' and pc_id='. $pcid)->save($data);
        }
        $this->success('操作成功！', '',true);
    } 
    
    public function pcaddbld(){
        if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('accoount/index'));
		} 
        $projid = I('projid');
        $pcid = I('pcid');
        $bldlist=I('bldlist');
        
        if (empty($pcid)||$pcid==0)
        {
            $this->error("数据错误，请重试");
        }
        else
        {
            $data['pc_id']=$pcid;
            $model = M("build");  
            $model->where('id in('. str_replace("|",",",$bldlist) .') and proj_id='. $projid )->save($data);
        }
        $this->success('操作成功！', '',true);
    }
     public function editkppc(){
        if (!IS_AJAX) {
                       $this->error('请求错误，请确认后重试！', U('account/index'));
                }
         $id = I('pcid', '', 'trim');
        if (empty($id)|| $id==0)
        {
            $this->error("数据错 误，请重试");
        }
        $Model = new \Think\Model(); 
        $pcinfo=$Model->query("SELECT a.id,a.proj_id,a.name,a.is_dq,a.is_yx,a.roomscount,a.ledurl,FROM_UNIXTIME( kptime,'%Y-%m-%d') as kptime,b.name as projname FROM xk_kppc a left join xk_project b on a.proj_id=b.id where a.id = ". $id ." and 889=889 " );
        $this->success($pcinfo); 
    }
    public function savekppc(){
        if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('admin/index'));
		}
//		echo json_encode(I('post.'));exit;
        if(!empty($_FILES['plan']['size'])){
            $config = array(
                "rootPath" => 'Uploads',
                "savePath" => "/img/jcsjpcset/",
                'maxSize' => 3145728,
                'saveName' => 'time',
                'exts' => array('jpeg', 'png','jpg'),
                'autoSub' => true
            );
            $upload = new \Think\Upload($config);// 实例化上传类
            $info = $upload->uploadOne($_FILES['plan']);
            if (!$info) {// 上传错误提示错误信息
                $this->error($upload->getError());
            }
            $data['plan']="/Uploads".$info['savepath'].$info['savename'];
        }

        $id = I('id', '', 'trim');
        $proj_id = I('proj_id', '', 'trim');
        $name = I('name', '', 'trim');
        $is_yx = I('is_yx', '', 'trim');
        $is_dq = I('is_dq', '', 'trim');
        $kptime = I('kptime', '', 'trim'); 
        if($is_dq==1)
        {
            $data1['is_dq']=0;
            $model = M("kppc");  
            $model->where('proj_id='.$proj_id)->save($data1);
        }
        $data['proj_id']=$proj_id;
        $data['name']=$name;
        $data['kptime']=strtotime($kptime);
        $data['is_yx']=$is_yx;
        $data['is_dq']=$is_dq;
        $model = M("kppc");  
        $model->where('id='.$id)->save($data);
        $this->success('保存成功！', '',true);
    } 
    
    public function editbld(){
        if (!IS_AJAX) {
                       $this->error('请求错误，请确认后重试！', U('account/index'));
                }
         $id = I('bldid', '', 'trim');
        if (empty($id)|| $id==0)
        {
            $this->error("数据错 误，请重试");
        }
        $Model = new \Think\Model(); 
        $pcinfo=$Model->query("SELECT * FROM xk_build  where id = ". $id ." and 999=999 " );
        $this->success($pcinfo); 
    }
    
    public function savebld(){
        if (!IS_AJAX) {
                    $this->error('请求错误，请确认后重试！', U('admin/index'));
            }
        
        $id = I('id', '', 'trim');
        $proj_id = I('proj_id', '', 'trim');
        $buildname = I('buildname', '', 'trim');
        $buildcode = I('buildcode', '', 'trim');
        $bldtype = I('bldtype', '', 'trim');

        //$data['proj_id']=$proj_id;
        $data['buildname']=$buildname;
        $data['buildcode']=$buildcode;
        $data['bldtype']=$bldtype;
        $model = M("build");  
        $model->where('id='.$id)->save($data);
        $this->success('保存成功！', '',true);
    }


}

