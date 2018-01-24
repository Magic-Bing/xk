<?php
namespace Home\Controller;

class LedController extends BaseController 
{
	
    public function index() 
    {
        $this->led();
    }
	
	
    public function led() 
    {
        $pid=I("p","0",'intval');
        $where="";
        if ($pid<>0)
        {
            $where=" and proj_id=".$pid;
        }
       
        $userid = $this->get_user_id_acc();
		$pcurllist=M()->query("select * from xk_station2user a left join xk_station2sjqx b on a.station_id=b.station_id where userid=".$userid." and b.is_dq=1 ". $where ." order by proj_id desc,pc_id desc" );
		if (!empty($pcurllist) && count($pcurllist)>0)
		{
			$ledurl = $pcurllist[0]['ledurl'];
			$proj_id = $pcurllist[0]['proj_id'];
                        $pc_id = $pcurllist[0]['pc_id'];
		} else {
			$this->error('项目不存在，请重试！', U('index/index'));
		}
		
        $this->getledrooms($proj_id,$pc_id);
		
        $this->display($ledurl);
    }
	
    
    /**
    * led获取数据
    *
    * @create 2016-8-29
    * @author jxw
    */
    public function getledrooms($projid = 0,$pc_id=0) 
    {
        //获取房间列表
        $userid = $this->get_user_id_acc();
        $get_projid = I('pid');
		
		if (!empty($get_projid)) {
			$projid = $get_projid;
		}
		
        $Model = new \Think\Model();
        if (empty($projid) || $projid == 0) {
            $this->error('项目不存在，请查看其他项目！', U('login/index'));
		}
        else
        {
            $projlist1=$Model->query("select * from xk_station2user a left join xk_station2proj b on a.station_id=b.station_id where a.userid=".$userid ." and b.proj_id=". $projid );
            if (empty($projlist1) || count($projlist1)<1){
                 $this->error('您无权查看此项目，请联系管理员！', U('login/index'));
            }
        }
        $where="";
        if ($pc_id<>0)
        {
            $where=" and pc_id=".$pc_id;
        }
        $group_room_build = $Model->query("SELECT bld_id,buildname,buildcode FROM xk_roomlist WHERE proj_id = " . $projid . $where . "  GROUP BY bld_id ORDER BY id DESC");
        $group_room_unit = $Model->query("SELECT `bld_id`,`unit` FROM `xk_roomlist` WHERE proj_id = ".$projid . $where . "  GROUP BY bld_id, unit ORDER BY id asc");
        $group_room_floor = $Model->query("SELECT `bld_id`,`unit`,`floor` FROM `xk_roomlist` WHERE `proj_id` = ".$projid.$where . "  GROUP BY bld_id, floor ORDER BY id DESC");
        $group_room_nolist = $Model->query("SELECT `bld_id`,`unit`,`no` FROM `xk_roomlist` WHERE `proj_id` = ". $projid . $where . "  GROUP BY bld_id, unit, no ORDER BY cast(unit as SIGNED),cast(no as SIGNED),id asc");
        $group_room_no = $Model->query("SELECT * FROM `xk_roomlist` WHERE `proj_id` = " . $projid . $where . "  ORDER BY bld_id,cast(unit as SIGNED),cast(floor as SIGNED) desc,cast(no as SIGNED),id ASC");
        
	//公告数据
        $dqtime=date('Y-m-d');
        $gfrooms = $Model->query("SELECT a.* FROM xk_roomlist a WHERE a.proj_id=" .$projid." and a.is_xf=1 AND FROM_UNIXTIME(a.xftime,'%Y-%m-%d')='".$dqtime ."' and 55=55  ORDER BY a.xftime desc,a.bld_id,unit,floor desc,no,a.id ASC limit 10;" );

        //数据格式化
         foreach ($group_room_nolist as $group_room_nolist_key => $group_room_nolist_value) {
            $group_room_nolist[$group_room_nolist_value['bld_id']][$group_room_nolist_value['unit']][] = $group_room_nolist_value;
        }
        foreach ($group_room_unit as $group_room_unit_key => $group_room_unit_value) {
                $group_room_unit[$group_room_unit_value['bld_id']][] = $group_room_unit_value;
        }
        foreach ($group_room_floor as $group_room_floor_key => $group_room_floor_value) {
            $group_room_floor[$group_room_floor_value['bld_id']][] = $group_room_floor_value;
        }
        foreach ($group_room_no as $group_room_no_key => $group_room_no_value) {
            $group_room_no[$group_room_no_value['bld_id']][$group_room_no_value['unit']][$group_room_no_value['floor']][$group_room_no_value['no']][] = $group_room_no_value;
        }
        $this->assign('gfrooms', $gfrooms);
        $this->assign('rooms', $group_room_no);
        $this->assign('nolist', $group_room_nolist);
        $this->assign('floors', $group_room_floor);
        $this->assign('units', $group_room_unit);
        $this->assign('ii', 0);
        $this->assign('projid',$projid);
        
        unset($where);
        //获取相关楼栋
        $build_ids = array();
        foreach ($group_room_build as $group_room_build_k => $group_room_build_v) {
                $build_ids[] = $group_room_build_v['bld_id'];
        }
        if (!empty($build_ids)) {
			$Build = D('Common/Build');
			$where['id'] = array('in', $build_ids);
			$build_list = $Build->getBuildList($where, 'cast(buildname as SIGNED), id DESC');
        } else {
			$build_list = array();
        }
        $build_new_list = array();
        foreach ($build_list as $key => $build) {
                $build_new_list[$build['id']] = $build;
        }
        $this->assign('builds', $build_new_list);
        //seo设置
        $this->set_seo_title('LED销控表');
        $this->set_seo_keywords('LED销控表');
        $this->set_seo_description('LED销控表');	
        
        //collection 收藏，comparison 对比，follow 关注
        $now_type = I('type');
        if (!in_array($now_type, array('collection', 'comparison', 'follow'))) {
                $now_type = 'collection';
        }
        $this->assign('now_type', $now_type);
        
        //排名数据获取
        $typelist=array( 0 => "dj",1 => "db",2 => "sc");
        foreach ($typelist as $typelist_key => $typelist_value)  
        {
            if ($typelist_value=="dj")
            {
                $djpmlist=$Model->query("select a.room_id,a.djcount as gs,b.projname,b.buildname,b.unit,b.floor,b.no,b.room from xk_roomattribute a left join  xk_roomlist b  on a.room_id=b.id where  b.proj_id=".$projid." and b.is_xf=0  and djcount>0 group by a.room_id order by a.djcount desc limit 10");
                $max_count = $djpmlist[0]['gs'];
                foreach ($djpmlist as $djpmlist_key => $djpmlist_value)
                {
                    $djpmlist[$djpmlist_key]['precision'] = round(($djpmlist_value['gs']/$max_count)*100, 2).'%';
                    $djpmlist[$djpmlist_key]['nowcount'] = $djpmlist_value['gs'];
                }
            }
            if ($typelist_value=="db")
            {
                $dbpmlist=$Model->query("select a.room_id,a.sscount as gs,b.projname,b.buildname,b.unit,b.floor,b.no,b.room from xk_roomattribute a left join  xk_roomlist b  on a.room_id=b.id where  b.proj_id=".$projid." and b.is_xf=0 and sscount>0 group by a.room_id order by a.sscount desc limit 10");
                $max_count = $dbpmlist[0]['gs'];
                foreach ($dbpmlist as $dbpmlist_key => $dbpmlist_value)
                {
                    $dbpmlist[$dbpmlist_key]['precision'] = round(($dbpmlist_value['gs']/$max_count)*100, 2).'%';
                    $dbpmlist[$dbpmlist_key]['nowcount'] = $dbpmlist_value['gs'];
                }
            }
            if ($typelist_value=="sc")
            {
                $scpmlist=$Model->query("select a.room_id,a.sccount as gs,b.projname,b.buildname,b.unit,b.floor,b.no,b.room from xk_roomattribute a left join  xk_roomlist b  on a.room_id=b.id where  b.proj_id=".$projid." and b.is_xf=0 and sccount>0 group by a.room_id order by a.sccount desc limit 10");
                $max_count = $scpmlist[0]['gs'];
                foreach ($scpmlist as $scpmlist_key => $scpmlist_value)
                {
                    $scpmlist[$scpmlist_key]['precision'] = round(($scpmlist_value['gs']/$max_count)*100, 2).'%';
                    $scpmlist[$scpmlist_key]['nowcount'] = $scpmlist_value['gs'];
                }
            }
            $this->assign('djpmlist', $djpmlist);
            $this->assign('dbpmlist', $dbpmlist);
            $this->assign('scpmlist', $scpmlist);
        }
    }
	
	
    /**
     * 获取最新购房信息
     *
     * @create 2016-8-29
     * @author jxw
     */
    public function get_gfrooms()
    {
            if (!IS_AJAX) {
                    $this->error('请求错误，请确认后重试！', U('led/index'));
            }
            $type = I('info', '', 'trim');
            $projid = I('projid', 0, 'trim');
            $Model = new \Think\Model(); 
            if ($type=='showgg')
            {
                $dqtime=date('Y-m-d');
                $rooms=$Model->query("SELECT a.* FROM xk_roomlist a WHERE a.proj_id=" .$projid." and a.is_xf=1 AND FROM_UNIXTIME(a.xftime,'%Y-%m-%d')='".$dqtime ."' and 666=666 ORDER BY a.xftime desc,a.bld_id,a.unit,a.floor desc,a.no,a.id ASC limit 10;" );
            }
            if($type=='showzxrooms')
            {
                //获取最近6秒内产生的1条选房数据; 测试用>300  正式时需要改成<6;      10分钟之内的取消选房数据
                $rooms=$Model->query("SELECT a.* FROM xk_roomlist a WHERE 333=333 and  a.proj_id=" .$projid." and (is_qxxf=1 or is_xf=1)  ORDER BY a.xftime desc,a.qxxftime desc,a.bld_id,a.unit,a.floor desc,a.no,a.id ASC ;" );
            }
            /*else
            {
                $rooms=$Model->query("SELECT a.* FROM xk_roomlist a WHERE a.proj_id=" .$projid." and is_xf=1 AND unix_timestamp(now())- a.xftime > 600 ORDER BY a.xftime desc,a.bld_id,a.unit,a.floor desc,a.no,a.id ASC limit 10;" );
            }*/
            $this->success($rooms);
    } 
    public function get_pmsj()
    {
        if (!IS_AJAX) {
                $this->error('请求错误，请确认后重试！', U('led/index'));
        }
        $projid = I('projid', 0, 'trim');
        $Model = new \Think\Model(); 
        //排名数据获取
        $typelist=array( 0 => "dj",1 => "db",2 => "sc");
        foreach ($typelist as $typelist_key => $typelist_value)  
        {
            if ($typelist_value=="dj")
            {
                $djpmlist=$Model->query("select a.room_id,a.djcount as gs,b.projname,b.buildname,b.unit,b.floor,b.no,b.room from xk_roomattribute a left join  xk_roomlist b  on a.room_id=b.id where  b.proj_id=".$projid." and b.is_xf=0 and djcount>0 and 888=888 group by a.room_id order by a.djcount desc limit 10");
                $max_count = $djpmlist[0]['gs'];
                foreach ($djpmlist as $djpmlist_key => $djpmlist_value)
                {
                    $djpmlist[$djpmlist_key]['precision'] = round(($djpmlist_value['gs']/$max_count)*100, 2).'%';
                    $djpmlist[$djpmlist_key]['nowcount'] = $djpmlist_value['gs'];
                }
            }
            if ($typelist_value=="db")
            {
                $dbpmlist=$Model->query("select a.room_id,a.sscount as gs,b.projname,b.buildname,b.unit,b.floor,b.no,b.room from xk_roomattribute a left join  xk_roomlist b  on a.room_id=b.id where  b.proj_id=".$projid." and b.is_xf=0 and sscount>0 group by a.room_id order by a.sscount desc limit 10");
                $max_count = $dbpmlist[0]['gs'];
                foreach ($dbpmlist as $dbpmlist_key => $dbpmlist_value)
                {
                    $dbpmlist[$dbpmlist_key]['precision'] = round(($dbpmlist_value['gs']/$max_count)*100, 2).'%';
                    $dbpmlist[$dbpmlist_key]['nowcount'] = $dbpmlist_value['gs'];
                }
            }
            if ($typelist_value=="sc")
            {
                $scpmlist=$Model->query("select a.room_id,a.sccount as gs,b.projname,b.buildname,b.unit,b.floor,b.no,b.room from xk_roomattribute a left join  xk_roomlist b  on a.room_id=b.id where  b.proj_id=".$projid." and b.is_xf=0  and sccount>0 group by a.room_id order by a.sccount desc limit 10");
                $max_count = $scpmlist[0]['gs'];
                foreach ($scpmlist as $scpmlist_key => $scpmlist_value)
                {
                    $scpmlist[$scpmlist_key]['precision'] = round(($scpmlist_value['gs']/$max_count)*100, 2).'%';
                    $scpmlist[$scpmlist_key]['nowcount'] = $scpmlist_value['gs'];
                }
            }
        }
        $allpm=array();
        $allpm[0]=$djpmlist;
        $allpm[1]=$dbpmlist;
        $allpm[2]=$scpmlist; 
        $this->success($allpm, U('led/index'));
    }
    
    public function pmtled1() 
    {
        $user_where['userid'] = session("ACCOUNT_ID");
        $user_project_list = D("Station")->getpProjectListByUserId($user_where['userid']);
        $project_ids = array();
        foreach ($user_project_list as $user_project_list_value) {
                $project_ids[] = $user_project_list_value['proj_id'];
        }

        //项目列表
        if (!empty($project_ids)) {
                $Project = D('Common/Project');
                $where11['status'] = 1;
                $where11['id'] = array('in', $project_ids);
                $project_list = $Project->getProjectList($where11, 'id DESC');
        } else {
                $project_list = array();
        }
        $this->assign('project', $project_list);

        $Model = new \Think\Model(); 
        $sqltemp="select a.*,FROM_UNIXTIME(xftime,'%Y-%m-%d  %H:%i') as xftime1,c.leftpx,c.toppx from xk_roomlist a inner join
                    ( 
                            select a.id as bld_id,a.buildname,a.buildcode  from xk_build a left join xk_station2pc b on a.pc_id=b.pc_id left join xk_station2user c on b.station_id=c.station_id
                            left join xk_kppc d on a.pc_id=d.id 
                            where 1111=1111 and a.id= 31 and c.userid= " .$user_where['userid'] . " and a.proj_id= " . $project_list[0]['id'] . " and d.is_yx=1
                    ) b on a.bld_id=b.bld_id left join xk_room_pmtzb c on a.id=c.room_id order by floor,no";  
        $rooms=$Model ->query($sqltemp); 
        $this->assign('rooms', $rooms);
        $this->display();
    }
    
    public function pmtled2() 
    {
        $user_where['userid'] = session("ACCOUNT_ID");
        $user_project_list = D("Station")->getpProjectListByUserId($user_where['userid']);
        $project_ids = array();
        foreach ($user_project_list as $user_project_list_value) {
                $project_ids[] = $user_project_list_value['proj_id'];
        }

        //项目列表
        if (!empty($project_ids)) {
                $Project = D('Common/Project');
                $where11['status'] = 1;
                $where11['id'] = array('in', $project_ids);
                $project_list = $Project->getProjectList($where11, 'id DESC');
        } else {
                $project_list = array();
        }
        $this->assign('project', $project_list);

        $Model = new \Think\Model(); 
        $sqltemp="select a.*,FROM_UNIXTIME(xftime,'%Y-%m-%d  %H:%i') as xftime1,c.leftpx,c.toppx from xk_roomlist a inner join
                    ( 
                            select a.id as bld_id,a.buildname,a.buildcode  from xk_build a left join xk_station2pc b on a.pc_id=b.pc_id left join xk_station2user c on b.station_id=c.station_id
                            left join xk_kppc d on a.pc_id=d.id 
                            where 1111=1111 and a.id= 32 and c.userid= " .$user_where['userid'] . " and a.proj_id= " . $project_list[0]['id'] . " and d.is_yx=1
                    ) b on a.bld_id=b.bld_id left join xk_room_pmtzb c on a.id=c.room_id order by floor,no";  
        $rooms=$Model ->query($sqltemp); 
        $this->assign('rooms', $rooms);
        $this->display();
    }
}



