<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends BaseController {
    public function index(){
         $userid = $this->get_user_id();
        $this->display();
    } 
    public function left(){
        $this->display();
    } 
    public function top(){
        $this->display();
    } 
    
    public function company(){
        $Model = new \Think\Model(); 
        //查询
        $where = " where 1=1 ";
        $name=I("get.name");
        $address=I("get.address");
        $mobile=I("get.mobile");
        if (!empty($name) && $name<>"")
           $where .=" and a.name like '%". $name ."%' " ;
        if (!empty($address) && $address<>"")
           $where .=" and a.addres like '%". $address ."%' " ;
        if (!empty($mobile) && $mobile<>"")
           $where .=" and a.mobile like '%". $mobile ."%' " ;
        
        //分页
        $pageshow = new  \Admin\Common\page(); 
        $nowpage=I("get.page");
        if (empty($nowpage)) {
            $nowpage=0;
        }
        $pageshow->setpage($nowpage, 10);
        $limit = " LIMIT ".$pageshow->startnum().", ".$pageshow->getsize();
        $complist=$Model->query("SELECT a.* FROM  xk_company a  " . $where . " ORDER BY a.id ASC ".$limit." " );
        $allcomp=$Model->query("SELECT a.* FROM xk_company a  " .  $where );
        $count=count($allcomp);
        //$pageshow->setnum($count);
        $pageshow->setnum($count);
	$pagecontent = $pageshow->getpagebar($_SERVER['REQUEST_URI']);
        $this->assign('pagecontent', $pagecontent); 
        $this->assign('complist', $complist);
        $this->display();
    }
    public function addcompany(){
        $this->display();
    }
    
    public function editcompany(){
        $id=I("get.id");
        if (empty($id)|| $id==0)
        {
            $this->error("数据错误，请重试");
        }
        $Model = new \Think\Model(); 
        $companylist=$Model->query("SELECT a.* FROM xk_company a where a.id = ". $id ." and 1=1 " );

        $this->assign('companylist', $companylist); 
        $this->display();
    }
    
    public function delcompany(){
        if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('admin/index'));
		} 
        $id = I('id');
        if (empty($id)||$id==0)
        {
            $this->error("数据错误，请重试");
        }
        else
        {
            $model = M("company");  
            $model->where('id='.$id )->delete();
        }
        $this->success('操作成功！', '',true);
    } 
    
     public function savecompany(){
        if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('admin/index'));
		}
        
        $id = I('id', '', 'trim');
        $name = I('name', '', 'trim');
        $address = I('address', '', 'trim');
        $mobile = I('mobile', '', 'trim');
        if (empty($id)||$id==0)
        {
            $data['name']=$name;
            $data['address']=$address;
            $data['mobile']=$mobile;
            $data['createdate']=strtotime(date());
            $model = M("company");  
            $model->add($data);
        }
        else
        {
            $data['name']=$name;
            $data['address']=$address;
            $data['mobile']=$mobile;
            $model = M("company");  
            $model->where('id='.$id)->save($data);
        }
        $this->success('保存成功！', '',true);
    } 
    
    
    public function project(){
        $Model = new \Think\Model(); 
        //查询
        $where = " where 1=1 ";
        $name=I("get.name");
        $address=I("get.address");
        $mobile=I("get.mobile");
        $compname=I("get.compname");
        if (!empty($name) && $name<>"")
           $where .=" and a.name like '%". $name ."%' " ;
        if (!empty($address) && $address<>"")
           $where .=" and a.address like '%". $address ."%' " ;
        if (!empty($mobile) && $mobile<>"")
           $where .=" and a.mobile like '%". $mobile ."%' " ;
        if (!empty($compname) && $compname<>"")
           $where .=" and b.name like '%". $compname ."%' " ;
        
        //分页
        $pageshow = new  \Admin\Common\page(); 
        $nowpage=I("get.page");
        if (empty($nowpage)) {
            $nowpage=0;
        }
        $pageshow->setpage($nowpage, 10);
        $limit = " LIMIT ".$pageshow->startnum().", ".$pageshow->getsize();
        $projlist=$Model->query("SELECT b.name as compname,a.*,case when a.status=1 then '开启' else '关闭' end as zt FROM xk_project a left join xk_company b on a.cp_id=b.id " . $where . " ORDER BY a.status desc,a.id ASC ".$limit." " );
        $allproj=$Model->query("SELECT a.* FROM xk_project a left join xk_company b on a.cp_id=b.id  " .  $where );
        $count=count($allproj);
        //$pageshow->setnum($count);
        $pageshow->setnum($count);
	$pagecontent = $pageshow->getpagebar($_SERVER['REQUEST_URI']); 
        $this->assign('pagecontent', $pagecontent); 
        $this->assign('projlist', $projlist);
        $this->display();
    }
    
     public function addproject(){
        $Model = new \Think\Model(); 
        $companylist=$Model->query("SELECT * FROM xk_company where 1=1" );
        
        $this->assign('companylist', $companylist); 
        $this->display();
    }
    
    public function editproject(){
        $id=I("get.id");
        if (empty($id)|| $id==0)
        {
            $this->error("数据错误，请重试");
        }
        $Model = new \Think\Model(); 
        $projinfo=$Model->query("SELECT a.*,b.name as compname FROM xk_project a left join xk_company b on a.cp_id=b.id where a.id = ". $id ." and 1=1 " );
        $this->assign('projinfo', $projinfo); 
        $companylist=$Model->query("SELECT * FROM xk_company where 1=1 and id != '".$projinfo[0]['cp_id'] ."'" );
        $this->assign('companylist', $companylist); 
        $this->display();
    }
    
    
     public function saveproject(){
        if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('admin/index'));
		}
        
        $id = I('id', '', 'trim');
        $cp_id = I('cp_id', '', 'trim');
        $name = I('name', '', 'trim');
        $address = I('address', '', 'trim');
        $mobile = I('mobile', '', 'trim');
        $projfzr = I('projfzr', '', 'trim');
		
        $app_id = I('app_id', '', 'trim');
        $app_secret = I('app_secret', '', 'trim');
		
        $mch_id = I('mch_id', '', 'trim');
        $act_name = I('act_name', '', 'trim');
        $api_password = I('api_password', '', 'trim');
        $wishing = I('wishing', '', 'trim');
        $remark = I('remark', '', 'trim');
		
        if (empty($id)||$id==0)
        {
            $data['cp_id']=$cp_id;
            $data['name']=$name;
            $data['address']=$address;
            $data['mobile']=$mobile;
            $data['projfzr']=$projfzr;
			
            $data['app_id'] = $app_id;
            $data['app_secret'] = $app_secret;
			
            $data['createdate']=strtotime(date());
            $data['status']=1;
            $model = M("project");  
            $newid=$model->add($data);
            
            //项目参数初始化
            $date1['proj_id']=$newid;
            $model = M("projoptions");
            $model->add($date1);
        }
        else
        {
            $data['cp_id']=$cp_id;
            $data['name']=$name;
            $data['address']=$address;
            $data['mobile']=$mobile;
            $data['projfzr']=$projfzr;
			
            $data['app_id'] = $app_id;
            $data['app_secret'] = $app_secret;
			
            $data['mch_id'] = $mch_id;
            $data['act_name'] = $act_name;
            $data['api_password'] = $api_password;
            $data['wishing'] = $wishing;
            $data['remark'] = $remark;
			
            $model = M("project");  
            $model->where('id='.$id)->save($data);
        }
        $this->success('保存成功！', '',true);
    } 
    
    public function zxproject(){
        if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('admin/index'));
		}
        
        $id = I('id', '', 'trim');
        $type = I('type', '', 'trim');
        if (empty($id)||$id==0)
        {
            $this->error("数据错误，请重试");
        }
        else
        {
            $data['status']=$type;
            $model = M("project");  
            $model->where('id='.$id)->save($data);
        }
        $this->success('操作成功！', '',true);
    } 
    
     public function pcbuild(){
        $Model = new \Think\Model(); 

        $projid = I('projid');
        if (!empty($projid) && $projid<>0)
        {
            $selectedproj=$Model->query("SELECT a.*,b.name as compname FROM xk_project a left join xk_company b on a.cp_id=b.id where a.status=1 and a.id= " . $projid . " and 1=1 order by b.id asc,a.id asc" );
            $this->assign('selectedproj', $selectedproj[0] ); 
            $projectlist=$Model->query("SELECT a.*,b.name as compname FROM xk_project a left join xk_company b on a.cp_id=b.id where a.status=1 and 1=1 order by b.id asc,a.id asc" );
            $this->assign('projectlist', $projectlist); 
            
            $kppc=$Model->query("SELECT a.*,case when is_yx=1 then '开启' else '关闭' end as zt  FROM xk_kppc a where a.proj_id=" . $projid . "  order by is_yx desc,a.id asc" );
            
            $bldlist=$Model->query("SELECT a.*  FROM xk_build a where a.proj_id=" . $projid . " and 3=3 order by a.proj_id asc,a.pc_id asc,a.id asc" );
            
            $kppclist=array();
            foreach ($kppc as $kppc_k => $kppc_v) {  
                foreach ($bldlist as $bldlist_k => $bldlist_v)
                {
                    if ($kppc_v['id']==$bldlist_v['pc_id'] && $kppc_v['proj_id']==$bldlist_v['proj_id'])
                        $kppc_v[$kppc_k][]=$bldlist_v;
                }
                $kppclist[]=$kppc_v;
            }
            $this->assign('kppclist', $kppclist); 
        }
        else
        {  
            $projectlist=$Model->query("SELECT a.*,b.name as compname FROM xk_project a left join xk_company b on a.cp_id=b.id where a.status=1  and 44=44 order by b.id asc,a.id asc" );
            $this->assign('projectlist', $projectlist); 
        }
        
        $this->display();
    }
    
    
    public function getbldlist()
    {
		if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('admin/index'));
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

                $bldlist=$Model->query("SELECT a.* FROM xk_build a WHERE a.pc_id=" .$pcid . " and a.proj_id= ".$projid ."  ORDER BY  a.id asc" );

		$this->success($bldlist);
    }
    
    
     public function addkppc(){ 
        $projid=I("get.projid");
        if (empty($projid)|| $projid==0)
        {
            $this->error("数据错误，请重试");
        }
        $Model = new \Think\Model(); 
        $projinfo=$Model->query("SELECT * FROM xk_project where id= ".$projid ." and 1=1" );
        
        $this->assign('projinfo', $projinfo); 
        $this->display();
    }
    
    public function editkppc(){
        $id=I("get.id");
        if (empty($id)|| $id==0)
        {
            $this->error("数据错误，请重试");
        }
        $Model = new \Think\Model(); 
        $pcinfo=$Model->query("SELECT a.id,a.proj_id,a.name,a.is_yx,a.roomscount,a.ledurl,FROM_UNIXTIME( kptime,'%Y-%m-%d') as kptime,b.name as projname FROM xk_kppc a left join xk_project b on a.proj_id=b.id where a.id = ". $id ." and 1=1 " );
        $this->assign('pcinfo', $pcinfo); 
        $this->display();
    }
    public function savekppc(){
        if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('admin/index'));
		}
        
        $id = I('id', '', 'trim');
        $proj_id = I('proj_id', '', 'trim');
        $name = I('name', '', 'trim');
        $roomscount = I('roomscount', '', 'trim');
        $is_yx = I('is_yx', '', 'trim');
        $is_dq = I('is_dq', '', 'trim');
        $kptime = I('kptime', '', 'trim');
        $ledurl = I('ledurl', '', 'trim');
        if (empty($ledurl)||$ledurl=="")
            $ledurl="index";
        if (empty($id)||$id==0)
        {
            if($is_dq==1)
            {
                $data1['is_dq']=0;
                $model = M("kppc");  
                $model->where('proj_id='.$proj_id)->save($data1);
            }
            $data['proj_id']=$proj_id;
            $data['name']=$name;
            $data['roomscount']=$roomscount;
            $data['kptime']=strtotime($kptime);
            $data['is_yx']=$is_yx;
            $data['is_dq']=$is_dq;
            $data['ledurl']=$ledurl;
            $model = M("kppc");  
            $model->add($data);
        }
        else
        {   
            if($is_dq==1)
            {
                $data1['is_dq']=0;
                $model = M("kppc");  
                $model->where('proj_id='.$proj_id)->save($data1);
            }
            $data['proj_id']=$proj_id;
            $data['name']=$name;
            $data['roomscount']=$roomscount;
            $data['kptime']=strtotime($kptime);
            $data['is_yx']=$is_yx;
            $data['is_dq']=$is_dq;
            $data['ledurl']=$ledurl;
            $model = M("kppc");  
            $model->where('id='.$id)->save($data);
        }
        $this->success('保存成功！', '',true);
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
			$this->error('请求错误，请确认后重试！', U('admin/index'));
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
    
    public function user(){
        $Model = new \Think\Model(); 
        //查询
        $where = " where 1=1 ";
        $name=I("get.name");
        $code=I("get.code");
        $mobile=I("get.mobile");
        $compname=I("get.compname");
        if (!empty($name) && $name<>"")
           $where .=" and a.name like '%". $name ."%' " ;
        if (!empty($address) && $address<>"")
           $where .=" and a.code like '%". $code ."%' " ;
        if (!empty($mobile) && $mobile<>"")
           $where .=" and a.mobile like '%". $mobile ."%' " ;
        if (!empty($compname) && $compname<>"")
           $where .=" and b.name like '%". $compname ."%' " ;
        
        //分页
        $pageshow = new  \Admin\Common\page(); 
        $nowpage=I("get.page");
        if (empty($nowpage)) {
            $nowpage=0;
        }
        $pageshow->setpage($nowpage, 10);
        $limit = " LIMIT ".$pageshow->startnum().", ".$pageshow->getsize();
        $userlist=$Model->query("SELECT b.name as compname,a.* FROM xk_user a left join xk_company b on a.cp_id=b.id " . $where . " ORDER BY b.id asc ,a.id ASC ".$limit." " );
        $alluser=$Model->query("SELECT b.name as compname,a.* FROM xk_user a left join xk_company b on a.cp_id=b.id  " .  $where );
        $count=count($alluser);

        $pageshow->setnum($count);
	$pagecontent = $pageshow->getpagebar($_SERVER['REQUEST_URI']); 
        $this->assign('pagecontent', $pagecontent); 
        $this->assign('userlist', $userlist);
        $this->display();
    }
    
     public function adduser(){
        $Model = new \Think\Model(); 
        $companylist=$Model->query("SELECT * FROM xk_company where 1=1" );
        
        $this->assign('companylist', $companylist); 
        $this->display();
    }
    
    public function edituser(){
        $id=I("get.id");
        if (empty($id)|| $id==0)
        {
            $this->error("数据错误，请重试");
        }
        $Model = new \Think\Model(); 
        $userinfo=$Model->query("SELECT a.*,b.name as compname FROM xk_user a left join xk_company b on a.cp_id=b.id where a.id = ". $id ." and 1=1 " );
        $this->assign('userinfo', $userinfo); 
        $companylist=$Model->query("SELECT * FROM xk_company where 1=1 and id != '".$userinfo[0]['cp_id'] ."'" );
        $this->assign('companylist', $companylist); 
        $this->display();
    }
    
     public function deluser(){
        if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('admin/index'));
		} 
        $id = I('id');
        if (empty($id)||$id==0)
        {
            $this->error("数据错误，请重试");
        }
        else
        {
            $model = M("user");  
            $model->where('id='.$id )->delete();
        }
        $this->success('操作成功！', '',true);
    } 
    
    
    public function pldeluser(){
        if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('admin/index'));
		} 
        $userlist = I('userlist');
        if (empty($userlist)||$userlist==0)
        {
            $this->error("数据错误，请重试");
        }
        else
        {
            $model = M("user");  
            $model->where('id in('. str_replace("|",",",$userlist) .')' )->delete();
        }
        $this->success('操作成功！', '',true);
    } 
    
    public function saveuser(){
        if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('admin/index'));
		}
        
        $id = I('id', '', 'trim');
        $cp_id = I('cp_id', '', 'trim');
        $name = I('name', '', 'trim');
        $code = I('code', '', 'trim');
        $mobile = I('mobile', '', 'trim');
        $pwd = I('pwd', '', 'trim');
        $type = I('usertype', '', 'trim');

        if (empty($id)||$id==0)
        {
            //校验是否有重复的手机和用户代码
            $Model = new \Think\Model(); 
            $cfuser=$Model->query("SELECT a.* FROM xk_user a  where a.code ='". $code ."' ");
            if (!empty($cfuser) && count($cfuser)>0)
            {
                $this->error('用户代码重复，请修改！');
            }
            $cfuser=$Model->query("SELECT a.* FROM xk_user a  where a.mobile='".$mobile."' ");
            if (!empty($cfuser) && count($cfuser)>0)
            {
                $this->error('手机号码重复，请修改！');
            }
            if (empty($pwd)||$pwd==0)
            {
               $pwd='888888';//默认值
            }
            $data['cp_id']=$cp_id;
            $data['name']=$name;
            $data['code']=$code;
            $data['mobile']=$mobile;
            $data['password']=md5(md5($pwd));
            $data['type']=$type;
            $model = M("user");  
            $model->add($data);
        }
        else
        {
            //校验是否有重复的手机和用户代码
            $Model = new \Think\Model(); 
            $cfuser=$Model->query("SELECT a.* FROM xk_user a  where a.code ='". $code ."' and a.id<>'".$id ."' ");
            if (!empty($cfuser) && count($cfuser)>0)
            {
                $this->error('用户代码重复，请修改！');
            }
            $cfuser=$Model->query("SELECT a.* FROM xk_user a  where a.mobile='".$mobile."' and a.id<>'".$id ."' ");
            if (!empty($cfuser) && count($cfuser)>0)
            {
                $this->error('手机号码重复，请修改！');
            }
            $data['cp_id']=$cp_id;
            $data['name']=$name;
            $data['code']=$code;
            $data['mobile']=$mobile;
            $data['type']=$type;
            if (!empty($pwd)||$pwd<>0)
            {
                $data['password']=md5(md5($pwd));
            }
            $model = M("user");  
            $model->where('id='.$id)->save($data);
        }
        $this->success('保存成功！', '',true);
    } 
     
    public function station(){
        $Model = new \Think\Model(); 

        $compid = I('compid');
        if (!empty($compid) && $compid<>0)
        {   
            //选择公司取值
            $selectedcomp=$Model->query("SELECT a.* FROM xk_company a where  a.id= " . $compid . " and 2=2 " );
            $this->assign('selectedcomp', $selectedcomp[0] ); 
            $companylist=$Model->query("SELECT a.* FROM xk_company a where  2=2 order by a.id asc" );
            $this->assign('companylist', $companylist); 
            
            //岗位列表
            $stationlist=$Model->query("SELECT a.* FROM xk_station a where a.cp_id=" . $compid . "  order by a.id asc" );
            if (!empty($stationlist))
            {
                //第一个岗位下用户列表
                $userlist=$Model->query("SELECT a.*,b.name as username,b.code ,b.mobile   FROM xk_station2user a left join xk_user b on a.userid=b.id where a.station_id=" . $stationlist[0]['id'] . " and 2=2 order by a.id asc" );
                $this->assign('userlist', $userlist); 
            }

            $this->assign('stationlist', $stationlist); 
        }
        else
        {  
            $companylist=$Model->query("SELECT a.* FROM xk_company a where 2=2 order by a.id asc" );
            $this->assign('companylist', $companylist); 
        }
        
        $this->display();
    }
    
    
     public function addstation(){
        $compid=I("get.compid");
        $ly=I("get.ly");
        if (!empty($ly))
        {
           $this->assign('ly', $ly); 
        }
        if (empty($compid)|| $compid==0)
        {
            $this->error("数据错误，请重试");
        }
        $Model = new \Think\Model(); 
        $compinfo=$Model->query("SELECT * FROM xk_company where id=" . $compid . " and 1=1" );
        
        $this->assign('compinfo', $compinfo); 
        $this->display();
    }
    
    public function editstation(){
        $id=I("get.id");
        $ly=I("get.ly");
        if (!empty($ly))
        {
           $this->assign('ly', $ly); 
        }
        if (empty($id)|| $id==0)
        {
            $this->error("数据错误，请重试");
        }
        $Model = new \Think\Model(); 
        $stationinfo=$Model->query("SELECT a.*,b.name as compname FROM xk_station a left join xk_company b on a.cp_id=b.id where a.id=" . $id . " and 1=1" );
        $this->assign('stationinfo', $stationinfo); 
        $this->display();
    }
    
    public function savestation(){
        if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('admin/index'));
		}
        
        $id = I('id', '', 'trim');
        $cp_id = I('compid', '', 'trim');
        $name = I('name', '', 'trim');
        $code = I('code', '', 'trim');
        if (empty($id)||$id==0)
        {
            $data['cp_id']=$cp_id;
            $data['name']=$name;
            $data['code']=$code;
            $model = M("station");  
            $model->add($data);
        }
        else
        {
            $data['cp_id']=$cp_id;
            $data['name']=$name;
            $data['code']=$code;
            $model = M("station");  
            $model->where('id='.$id)->save($data);
        }
        $this->success('保存成功！', '',true);
    } 
    public function getuserist()
    {
		if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('admin/index'));
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
                    $userlist=$Model->query("SELECT a.* FROM xk_user a  left join  (select * from xk_station2user where station_id=" .$station_id .")  b on a.id=b.userid WHERE a.cp_id= ".$cp_id ." and  b.userid is null  ORDER BY  a.id asc" );
                }
		$this->success($userlist);
    }
    
    public function stationdeluser(){
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
            $model = M("station2user");  
            $model->where('id='.$id .' and station_id='. $station_id)->delete();
        }
        $this->success('操作成功！', '',true);
    } 
    
    public function stationadduser(){
        if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('admin/index'));
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
    
    public function station2proj(){
        $Model = new \Think\Model(); 
        $compid = I('compid');
        if (!empty($compid) && $compid<>0)
        {   
            //选择公司取值
            $selectedcomp=$Model->query("SELECT a.* FROM xk_company a where  a.id= " . $compid . " and 2=2 " );
            $this->assign('selectedcomp', $selectedcomp[0] ); 
            $companylist=$Model->query("SELECT a.* FROM xk_company a where  2=2 order by a.id asc" );
            $this->assign('companylist', $companylist); 
            //岗位列表
            $stationlist=$Model->query("SELECT a.* FROM xk_station a where a.cp_id=" . $compid . "  order by a.id asc" );
            if (!empty($stationlist))
            {
                //第一个岗位的数据权限
                $pclist=$Model->query("SELECT a.*  FROM xk_station2sjqx a where a.station_id=" . $stationlist[0]['id'] . " and 2=2 order by a.id asc" );
                $this->assign('pclist', $pclist); 
            }
            $this->assign('stationlist', $stationlist); 
        }
        else
        {  
            $companylist=$Model->query("SELECT a.* FROM xk_company a where 2=2 order by a.id asc" );
            $this->assign('companylist', $companylist); 
        }
        $this->display();
    }
    
    public function getprojpclist()
    {
		if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('admin/index'));
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
                    $pclist=$Model->query("SELECT a.* FROM xk_station2sjqx a  WHERE a.station_id=" .$station_id . " and a.cp_id= ".$cp_id ." and a.is_yx=1 and 99=99 ORDER BY  a.id asc" );
                }
                else
                {
                    $pclist=$Model->query("SELECT a.* FROM (select pc.*,pj.name as projname,pj.cp_id from xk_kppc pc left join xk_project pj on .pc.proj_id=pj.id ) a  left join  (select * from xk_station2sjqx where station_id=" .$station_id.") b on a.id=b.pc_id  WHERE  a.cp_id= ".$cp_id ." and  b.id is null and a.is_yx=1 and 88=88 ORDER BY  a.proj_id,a.id asc" );
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

    
	/**
	 * 房间列表
	 * 
	 * @edit 2016-10-12
	 * @author zlw
	 */
    public function room(){
        $Model = new \Think\Model();
		
        //查询条件
        $where 	  	= " where 66665=66665 ";
        $buildname	= I("get.buildname");
        $unit  		= I("get.unit");
        $hx   		= I("get.hx");
        $room 		= I("get.room");
		
        if (!empty($buildname) && $buildname<>"") {
			$where .=" and b.buildname like '%". $buildname ."%' " ;
            $this->assign('buildname', $buildname); 
		}
        if (!empty($unit) && $unit<>"") {
			$where .=" and a.unit like '%". $unit ."%' " ;
            $this->assign('unit', $unit); 
		}
        if (!empty($hx) && $hx<>"") {
			$where .=" and a.hx like '%". $hx ."%' " ;
            $this->assign('hx', $hx); 
		}
        if (!empty($room) && $room<>"") {
			$where .=" and a.room like '%". $room ."%' " ;
            $this->assign('room', $room); 
		}
        
        $projid = I('projid');
        if (!empty($projid) && $projid<>0) {   
            //项目取值
            $projlist=$Model->query("SELECT a.*,b.name as compname FROM xk_project a left join xk_company b on a.cp_id=b.id where  2=2 order by b.id asc,a.id asc" );
            $this->assign('projlist', $projlist);
            $selectedproj=$Model->query("SELECT a.*,b.name as compname FROM xk_project a left join xk_company b on a.cp_id=b.id where a.id=" .$projid. " and 2=2 order by b.id asc,a.id asc" );
            $this->assign('selectedproj', $selectedproj[0]);
            
            //房间列表
            $allroom=$Model->query("SELECT a.* FROM xk_room a left join xk_build b on a.bld_id=b.id left join xk_project c on a.proj_id=c.id ".$where ." and  a.proj_id=" . $projid );
            $count = count($allroom);
		
			//分页
			$Page 		= $this->page($count, 10);
			$page_show  = $Page->show();	
			
			//房间列表
			$limit = " LIMIT ".$Page->firstRow.','.$Page->listRows;
            $roomlist=$Model->query("SELECT a.*,b.buildname,c.name as projname FROM xk_room a left join xk_build b on a.bld_id=b.id left join xk_project c on a.proj_id=c.id ".$where ."and  a.proj_id=" . $projid . "  order by a.id asc ".$limit );
			
            $this->assign('projid', $projid); 
            $this->assign('pagecontent', $page_show); 
            $this->assign('roomlist', $roomlist); 
        } else {  
            $projlist=$Model->query("SELECT a.*,b.name as compname FROM xk_project a left join xk_company b on a.cp_id=b.id where  2=2 order by b.id asc,a.id asc" );
            $this->assign('projlist', $projlist); 
        }
        
        $this->display();
    }

    public function delroom(){
        if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('admin/index'));
		} 
        $id = I('id');
        if (empty($id)||$id==0)
        {
            $this->error("数据错误，请重试");
        }
        else
        {
            $model = M("room");  
            $model->where('id='.$id )->delete();
        }
        $this->success('操作成功！', '',true);
    } 

     public function roomimport(){
        $projid = I('projid');
        if (!empty($projid) && $projid<>0)
            $this->assign('projid', $projid); 
        $this->display();
    }
   
    //上传方法
    public function upload()
    {
       header("Content-Type:text/html;charset=utf-8");
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('xls','xlsx','txt');// 设置附件上传类
        $upload->savePath  =      '/'; // 设置附件上传目录
        // 上传文件
        $info   =   $upload->uploadOne($_FILES['excelData']);
        $filename = './Uploads'.$info['savepath'].$info['savename'];      
        $exts = $info['ext'];
        //print_r($info);exit;
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功
            $this->rooms_import($filename, $exts);
        }
    }
    
    //导入数据方法
    protected function rooms_import($filename, $exts='xls')
    {
        //导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
        import("Org.Util.PHPExcel");
        //创建PHPExcel对象，注意，不能少了\
        $PHPExcel=new \PHPExcel();
        //如果excel文件后缀名为.xls，导入这个类
        if($exts == 'xls'){
            import("Org.Util.PHPExcel.Reader.Excel5");
            $PHPReader=new \PHPExcel_Reader_Excel5();
        }else if($exts == 'xlsx'){
            import("Org.Util.PHPExcel.Reader.Excel2007");
            $PHPReader=new \PHPExcel_Reader_Excel2007();
        }

        //载入文件
        $PHPExcel=$PHPReader->load($filename);
        //获取表中的第一个工作表，如果要获取第二个，把0改为1，依次类推
        $currentSheet=$PHPExcel->getSheet(0);
        //获取总列数
        $allColumn=$currentSheet->getHighestColumn();
        //获取总行数
        $allRow=$currentSheet->getHighestRow();
        
        if (empty($allRow)||$allRow<3)
        {
            $this->error('文件内容为空');
        }
        //循环获取表中的数据，$currentRow表示当前行，从哪行开始读取数据，索引值从0开始
        $buildlist="";
        for($currentRow=1;$currentRow<=$allRow;$currentRow++){
            //从哪列开始，A表示第一列
            for($currentColumn='A';$currentColumn<=$allColumn;$currentColumn++){
                //数据坐标
                $address=$currentColumn.$currentRow;
                //读取到的数据，保存到数组$arr中
                $data[$currentRow][$currentColumn]=$currentSheet->getCell($address)->getValue();
                if ($currentColumn=='B')
                {
                    if ($currentRow==1)
                    {
                        $projid= $data[$currentRow][$currentColumn];
                    }
                }
                if ($currentColumn=='A')
                {
                    if($currentRow>2)
                    {
                        if (stristr($buildlist,$data[$currentRow][$currentColumn])<=0)
                        {       
                            $buildlist.=$data[$currentRow][$currentColumn]."|";
                        }
                    }
                }
            }
        }
        $this->save_import($data,$projid,$buildlist);
        //$this->error('房间导入成功【'.$buildlist);
    }
    //保存导入数据
    public function save_import($data,$projid,$buildlist)
    {  
        if (empty($projid)||$projid==0)
        {
            $this->error('项目标识有误,请重新导出模板11');
        }
        $Modelr = new \Think\Model(); 
        $projinfo=$Modelr->query("SELECT a.* FROM xk_project a where a.id=" .$projid. " and 66=66 " );
        if (empty($projinfo)||count($projinfo)==0)
        {
            $this->error('项目标识有误,请重新导出模板22');
        }
        //生成楼栋信息
        $buildlist=rtrim($buildlist, "|");
        $bulids=explode("|",$buildlist);
        foreach ($bulids as $bulid_k => $bulid_v)
        {
            $bldinfo=$Modelr->query("SELECT a.* FROM xk_build a where a.proj_id=" .$projid. " and buildname='". $bulid_v ."' and 66=66 " );
            if (empty($bldinfo) || count($bldinfo)==0)
            {
                $data1['pc_id']=0;
                $data1['proj_id']=$projinfo[0]['id'];
                $data1['buildname']=$bulid_v;
                $data1['buildcode']=substr($bulid_v,0,strlen($bulid_v)-1); 
                $bld = M("build");  
                $bld->add($data1);
            }
        }
        //清空临时表xk_roomtemp
        $sql = 'truncate table xk_roomtemp';
        M()->execute($sql);

        $rooms = M('roomtemp');
        //$add_time = date('Y-m-d H:i:s', time());
        foreach ($data as $k=>$v){
            if($k >= 3){
                $info[$k-2]['proj_id']=$projinfo[0]['id'];
                $info[$k-2]['pc_id']=-99;
                $info[$k-2]['bld_id']=-99;
                $info[$k-2]['cp_id']=$projinfo[0]['cp_id'];
                
                $info[$k-2]['buildname'] = $v['A']."";
                $info[$k-2]['unit'] = $v['B'];
                $info[$k-2]['floor'] = $v['C'];
                $info[$k-2]['no'] = $v['D'];
                $info[$k-2]['room'] =  (string)$v['C']. (string)$v['D'];
                $info[$k-2]['hx'] = $v['E'];
                
                $info[$k-2]['area'] = $v['F'];
                $info[$k-2]['tnarea'] = $v['G'];
                $info[$k-2]['price'] = $v['H'];
                $info[$k-2]['tnprice'] = $v['I'];
                $info[$k-2]['total'] = $v['J'];
                $info[$k-2]['isadd'] = 1;
                $rooms->add($info[$k-2]);
            }
        }
        //更新楼栋id和批次id
        $SQL="update  xk_roomtemp a,xk_build b set a.bld_id=b.id,a.pc_id=b.pc_id where  a.proj_id=b.proj_id and a.buildname=b.buildname and a.bld_id=-99 ";
        M()->execute($SQL);
        //判断是否为新增房间
        $SQL="update  xk_roomtemp a,xk_room b set a.isadd=0,room_id=b.id where  a.proj_id=b.proj_id and a.bld_id=b.bld_id and a.unit=b.unit and a.floor=b.floor and a.no=b.no ";
        M()->execute($SQL);
        
        $roomadd=$Modelr->query("SELECT a.* FROM xk_roomtemp a where  isadd=1 " );
        if (!empty($roomadd) && count($roomadd)>0)
        {
            //新增房间
            $SQLadd="insert into xk_room (proj_id,pc_id,bld_id,cp_id,unit,floor,no,room,hx,area,tnarea,price,tnprice,total) ";
            $SQLadd.=" select proj_id,pc_id,bld_id,cp_id,unit,floor,no,room,hx,area,tnarea,price,tnprice,total from xk_roomtemp where isadd=1 ";
            $resultadd=M()->execute($SQLadd);
        }
        $roomup=$Modelr->query("SELECT a.* FROM xk_roomtemp a where  isadd = 0 " );
        if (!empty($roomup) && count($roomup)>0)
        {
            //更新房间信息
            $SQLup="update  xk_room a,xk_roomtemp b set a.hx=b.hx,a.area=b.area, a.tnarea=b.tnarea, a.price=b.price, a.tnprice=b.tnprice,a.total=b.total  where a.id=b.room_id and  b.room_id<>0 and b.isadd=0 ";
            $resultup=M()->execute($SQLup);
        }
        $this->success('房间导入成功', 'room?cz=user&projid='.$projid);

    }
    
    //导出数据方法
    protected function rooms_export($rooms_list=array())
    {
        //print_r($goods_list);exit;
        $goods_list = $goods_list;
        $data = array();
        foreach ($rooms_list as $k=>$rooms_info){
            $data[$k][id] = $rooms_info['id'];
            $data[$k][title] = $rooms_info['title'];
            $data[$k][PNO] = $rooms_info['PNO'];
            $data[$k][old_PNO] = $rooms_info['old_PNO'];
            $data[$k][price]  = $rooms_info['price'];
            $data[$k][brand_id]  = get_title('brand',$rooms_info['brand_id']);
            $data[$k][category_id]  = get_title('category',$rooms_info['category_id']);
            $data[$k][type_ids] = get_type_title($rooms_info['id']);
            $data[$k][add_time] = $rooms_info['add_time'];
        }

        foreach ($data as $field=>$v){
            if($field == 'id'){
                $headArr[]='产品ID';
            }

            if($field == 'title'){
                $headArr[]='产品名称';
            }

            if($field == 'PNO'){
                $headArr[]='零件号';
            }

            if($field == 'old_PNO'){
                $headArr[]='原厂参考零件号';
            }

            if($field == 'price'){
                $headArr[]='原厂参考面价';
            }

            if($field == 'type_ids'){
                $headArr[]='品牌';
            }

            if($field == 'brand_id'){
                $headArr[]='类别';
            }
            if($field == 'category_id'){
                $headArr[]='适用机型';
            }

            if($field == 'add_time'){
                $headArr[]='添加时间';
            }
        }
        $filename="goods_list";

        $this->getExcel($filename,$headArr,$data);
    }
  
    private  function getExcel($fileName,$headArr,$data){
        //导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Writer.Excel5");
        import("Org.Util.PHPExcel.IOFactory.php");

        $date = date("Y_m_d",time());
        $fileName .= "_{$date}.xls";

        //创建PHPExcel对象，注意，不能少了\
        $objPHPExcel = new \PHPExcel();
        $objProps = $objPHPExcel->getProperties();

        //设置表头
        $key = ord("A");
        //print_r($headArr);exit;
        foreach($headArr as $v){
            $colum = chr($key);
            $objPHPExcel->setActiveSheetIndex(0) ->setCellValue($colum.'1', $v);
            $objPHPExcel->setActiveSheetIndex(0) ->setCellValue($colum.'1', $v);
            $key += 1;
        }

        $column = 2;
        $objActSheet = $objPHPExcel->getActiveSheet();

        //print_r($data);exit;
        foreach($data as $key => $rows){ //行写入
            $span = ord("A");
            foreach($rows as $keyName=>$value){// 列写入
                $j = chr($span);
                $objActSheet->setCellValue($j.$column, $value);
                $span++;
            }
            $column++;
        }

        $fileName = iconv("utf-8", "gb2312", $fileName);
        //重命名表
        //$objPHPExcel->getActiveSheet()->setTitle('test');
        //设置活动单指数到第一个表,所以Excel打开这是第一个表
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=\"$fileName\"");
        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output'); //文件通过浏览器下载
        exit;
    }
    
    public function projoption(){
        $Model = new \Think\Model(); 
        //查询
        $where = " where 1=1 ";
        $name=I("get.name");
        $compname=I("get.compname");
        if (!empty($name) && $name<>"")
           $where .=" and a.name like '%". $name ."%' " ;
        if (!empty($compname) && $compname<>"")
           $where .=" and b.name like '%". $compname ."%' " ;
        
        //分页
        $pageshow = new  \Admin\Common\page(); 
        $nowpage=I("get.page");
        if (empty($nowpage)) {
            $nowpage=0;
        }
        $pageshow->setpage($nowpage, 10);
        $limit = " LIMIT ".$pageshow->startnum().", ".$pageshow->getsize();
        $projlist=$Model->query("SELECT a.*,b.name as projname,c.name as compname FROM xk_projoptions a left join xk_project b on a.proj_id=b.id  left join xk_company c  on b.cp_id=c.id " . $where . " ORDER BY c.id,b.id,a.id ".$limit." " );
        $allproj=$Model->query("SELECT a.* FROM xk_projoptions a left join xk_project b on a.proj_id=b.id  left join xk_company c  on b.cp_id=c.id" .  $where );
        $count=count($allproj);
        //$pageshow->setnum($count);
        $pageshow->setnum($count);
	$pagecontent = $pageshow->getpagebar($_SERVER['REQUEST_URI']); 
        $this->assign('pagecontent', $pagecontent); 
        $this->assign('projlist', $projlist);
        $this->display();
    }
    
    public function editprojoption(){
        $id=I("get.id");
        if (empty($id)|| $id==0)
        {
            $this->error("数据错误，请重试");
        }
        $Model = new \Think\Model(); 
        $projinfo=$Model->query("SELECT a.*,b.name as projname FROM xk_projoptions a left join xk_project b on a.proj_id=b.id where a.id = ". $id ." and 1=1 " );
        $this->assign('projinfo', $projinfo); 
        $this->display();
    }
    
    public function saveprojoption(){
        if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('admin/index'));
		}
        
        $id = I('id', '', 'trim');
        $is_xsjg_user = I('is_xsjg_user', '', 'trim');
        $is_xszt_user = I('is_xszt_user', '', 'trim');
        $is_qxxf_sh = I('is_qxxf_sh', '', 'trim');

        $data['cp_id']=$cp_id;
        $data['is_xsjg_user']=$is_xsjg_user;
        $data['is_xszt_user']=$is_xszt_user;
        $data['is_qxxf_sh']=$is_qxxf_sh;
        $model = M("projoptions");  
        $model->where('id='.$id)->save($data);

        $this->success('保存成功！', '',true);
    } 
    
    
     public function prize(){
        $Model = new \Think\Model(); 

        $projid = I('projid');
        if (!empty($projid) && $projid<>0)
        {
            $selectedproj=$Model->query("SELECT a.*,b.name as compname FROM xk_project a left join xk_company b on a.cp_id=b.id where a.status=1 and a.id= " . $projid . " and 1=1 order by b.id asc,a.id asc" );
            $this->assign('selectedproj', $selectedproj[0] ); 
            $projectlist=$Model->query("SELECT a.*,b.name as compname FROM xk_project a left join xk_company b on a.cp_id=b.id where a.status=1 and 1=1 order by b.id asc,a.id asc" );
            $this->assign('projectlist', $projectlist); 
            
            $kppc=$Model->query("SELECT a.*,case when is_yx=1 then '开启' else '关闭' end as zt  FROM xk_kppc a where a.proj_id=" . $projid . "  order by is_yx desc,a.id asc" );
            
            $prizelist=$Model->query("SELECT a.*,case when a.type=1 then '是' else '否' end as is_dj  FROM xk_prizes a where a.proj_id=" . $projid . " and 3=3 order by a.proj_id asc,a.pc_id asc,a.id asc" );
            
            $kppclist=array();
            foreach ($kppc as $kppc_k => $kppc_v) {  
                foreach ($prizelist as $prizelist_k => $prizelist_v)
                {
                    if ($kppc_v['id']==$prizelist_v['pc_id'] && $kppc_v['proj_id']==$prizelist_v['proj_id'])
                        $kppc_v[$kppc_k][]=$prizelist_v;
                }
                $kppclist[]=$kppc_v;
            }
            $this->assign('kppclist', $kppclist); 
        }
        else
        {  
            $projectlist=$Model->query("SELECT a.*,b.name as compname FROM xk_project a left join xk_company b on a.cp_id=b.id where a.status=1  and 44=44 order by b.id asc,a.id asc" );
            $this->assign('projectlist', $projectlist); 
        }
        
        $this->display();
    }
    public function getprizelist()
    {
		if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('admin/index'));
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

                $prizelist=$Model->query("SELECT a.*,case when a.type=1 then '是' else '否' end as is_dj  FROM xk_prizes a WHERE a.pc_id=" .$pcid . " and a.proj_id= ".$projid ."  ORDER BY  a.id asc" );
		$this->success($prizelist);
    }
    
     public function delprize(){
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
            $model = M("prizes");  
            $model->where('id='.$id .' and pc_id='. $pcid)->save($data);
        }
        $this->success('操作成功！', '',true);
    } 
    
      public function addprize(){
        $pcid = I('pcid', '', 'trim');
        $Model = new \Think\Model(); 
        $pclist=$Model->query("SELECT a.*,b.name as projname FROM xk_kppc a left join xk_project b on a.proj_id=b.id  where 1=1" );
        
        $this->assign('pclist', $pclist); 
        $this->display();
    }
    
    public function editprize(){
        $id = I('id', '', 'trim');
        if (empty($id)|| $id==0)
        {
            $this->error("数据错误，请重试");
        }
        $Model = new \Think\Model(); 
        $prizeinfo=$Model->query("SELECT a.*,b.name as pcname,c.name as projname FROM xk_prizes a left join xk_kppc b on a.pc_id=b.id left join xk_project c on a.proj_id=c.id where a.id = ". $id ." and 1=1 " );

        $this->assign('prizeinfo', $prizeinfo); 
        $this->display();
    }
    
    public function saveprize(){
        if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('admin/index'));
		}
        
        $id = I('id', '', 'trim');
        $proj_id = I('proj_id', '', 'trim');
        $pc_id= I('pc_id', '', 'trim');
        $rank = I('rank', '', 'trim');
        $name = I('name', '', 'trim');
        $zgs = I('zgs', '', 'trim');
        $sygs = I('sygs', '', 'trim');
        $zjv = I('zjv', '', 'trim');
        $type = I('type', '', 'trim');
        if (empty($id)||$id==0)
        {
            $data['proj_id']=$proj_id;
            $data['pc_id']=$pc_id;
            $data['rank']=$rank;
            $data['name']=$name;
            $data['zgs']=$zgs;
            $data['sygs']=$sygs;
            $data['zjv']=$zjv;
            $data['type']=$type;
            $model = M("prizes");  
            $model->add($data);
        }
        else
        {   
            $data['rank']=$rank;
            $data['name']=$name;
            $data['zgs']=$zgs;
            $data['sygs']=$sygs;
            $data['zjv']=$zjv;
            $data['type']=$type;
            $model = M("prizes");  
            $model->where('id='.$id)->save($data);
        }
        $this->success('保存成功！', '',true);
    } 
    
    
    
     public function applycst(){
        $Model = new \Think\Model(); 
        //查询
        $where = " where 1=1 ";
        $username=I("get.username");
        $company=I("get.company");
        $telphone=I("get.telphone");
        if (!empty($username) && $username<>"")
           $where .=" and a.username like '%". $username ."%' " ;
        if (!empty($company) && $company<>"")
           $where .=" and a.address like '%". $company ."%' " ;
        if (!empty($telphone) && $telphone<>"")
           $where .=" and a.telphone like '%". $telphone ."%' " ;
        
        //分页
        $pageshow = new  \Admin\Common\page(); 
        $nowpage=I("get.page");
        if (empty($nowpage)) {
            $nowpage=0;
        }
        $pageshow->setpage($nowpage, 999);
        $limit = " LIMIT ".$pageshow->startnum().", ".$pageshow->getsize();
        $complist=$Model->query("SELECT a.* FROM  xk_applytest a  " . $where . " ORDER BY a.id desc ".$limit." " );
        $allcomp=$Model->query("SELECT a.* FROM xk_applytest a  " .  $where );
        $count=count($allcomp);
        //$pageshow->setnum($count);
        $pageshow->setnum($count);
	$pagecontent = $pageshow->getpagebar($_SERVER['REQUEST_URI']);
        $this->assign('pagecontent', $pagecontent); 
        $this->assign('complist', $complist);
        $this->display();
    }
    public function addapplycst(){
        $this->display();
    }
       
    public function delapplycst(){
        if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('admin/index'));
		} 
        $id = I('id');
        if (empty($id)||$id==0)
        {
            $this->error("数据错误，请重试");
        }
        else
        {
            $model = M("applytest");  
            $model->where('id='.$id )->delete();
        }
        $this->success('操作成功！', '',true);
    } 
    
     
}