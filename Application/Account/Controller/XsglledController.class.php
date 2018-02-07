<?php
namespace Account\Controller;

/**
 * led显示
 *
 * @create 2017-05-15
 * @author jxw
 */
class XsglledController extends BaseController {

    /**
     * 系统构造函数
     *
     * @create 2017-04-17
     * @author jxw
     */
    public function _initialize() {
        parent::_initialize();

        //分类名称
        $this->assign('classify_name', '电子开盘');
        //设置当前方法
        $this->set_current_action('xsgl_led', 'xsgl');
    }

    public function index() {
            
                //项目ID
        if(isset($_POST['project_id'])){
            $search_project_id = I('project_id', 0, 'intval');
            session("selected_project",$search_project_id);
        }else{
            $search_project_id = session("selected_project");
        }
		$search_word = I('word', '', 'trim');
        $search_batch_id = I('batch_id',0, 'intval');
		//设置当前搜索
		$search = array(
			'search_project_id' => $search_project_id,
			'search_word' => $search_word,
			'search_batch_id' => $search_batch_id,
		);
		$this->assign($search);

		//项目
		$Project = D('Common/Project');
		
		//获取当前项目
		$project_info = $Project->getProjectById($search_project_id);
		$this->assign('project', $project_info);
		
		//当前用户ID
		$user_id = $this->get_user_id();
		
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
                $where2="where 222=222 ";
                if (!empty($user_project_ids)) {
                    $projectids = str_replace(",","','",implode(",",$user_project_ids));
                    $where2.=" and  p.id in('{$projectids}')";
                }
                if (!empty($user_batch_ids)) {
                    $batchids = str_replace(",","','",implode(",",$user_batch_ids));
                    $where2.=" and b.id in('{$batchids}')";
                }
                if (!empty($search_project_id))
                {
                    $where2.=" and p.id={$search_project_id}";
                }
                if (!empty($search_batch_id))
                {
                    $where2.=" and b.id={$search_batch_id}";
                }
                
                //总数
                $dqlist_old=M()
                ->query("select a.*,p.name as pname,b.name as bname FROM xk_xsledset a "
                        ." left join xk_project p on a.project_id=p.id "
                        ." left join xk_kppc b on a.batch_id=b.id "
                        .$where2
                        ." union all "
                        ." select 0 as id,b.proj_id as project_id,b.id as batch_id,'' as bldidlist,'' as bldnamelist,p.name as pname,b.name as bname from xk_kppc b "
                        . " left join xk_project p on b.proj_id=p.id "
                        ." left join xk_xsledset a on a.batch_id=b.id "
                        .$where2 ." and a.batch_id is null "
                );
                //分页
                $count=count($dqlist_old);
                $Page = $this->bootstrapPage($count, 15);
                $page_show = $Page->show();
                $total_pages = $Page->totalPages;
                //取范围
                $limit = $Page->firstRow . ',' . $Page->listRows;
                
                $dqlist=M()
                ->query("select a.*,p.name as pname,b.name as bname FROM xk_xsledset a "
                        ." left join xk_project p on a.project_id=p.id "
                        ." left join xk_kppc b on a.batch_id=b.id "
                        .$where2
                        ." union all "
                        ." select 0 as id,b.proj_id as project_id,b.id as batch_id,'' as bldidlist,'' as bldnamelist,p.name as pname,b.name as bname from xk_kppc b "
                        . " left join xk_project p on b.proj_id=p.id "
                        ." left join xk_xsledset a on a.batch_id=b.id "
                        .$where2 ." and a.batch_id is null "
                        ." order by project_id desc,batch_id desc "
                        . "limit ".$limit
                );
                
                //更新列表中的值
                $new_ledlist=array();
                foreach($dqlist as $kk=>$list_vo)
                {
                    if($list_vo["id"]==0)
                    {
                        $bldlist=D("Build")->join("left join (select bld_id,count(1) as gs from xk_room group by bld_id) a  on xk_build.id=a.bld_id")
                                ->where("pc_id={$list_vo['batch_id']} and 555=555")->order("xk_build.id")->select();
                        $strids="";
                        $strnames="";
                        foreach($bldlist as $k=> $bldlist_vo) 
                        {
                            if($bldlist=="")
                            {
                                $strids=$bldlist_vo["id"];
                                $strnames==$bldlist_vo["buildname"];
                            }
                            else
                            {
                                if($k<count($bldlist)-1)
                                {
                                    $strids.=$bldlist_vo["id"].",";
                                    $strnames.=$bldlist_vo["buildname"].",";
                                }
                                else
                                {
                                    $strids.=$bldlist_vo["id"];
                                    $strnames.=$bldlist_vo["buildname"];
                                }
                            }
                        }
                        $dqlist[$kk]["bldidlist"]=$strids;
                        $dqlist[$kk]["bldnamelist"]=$strnames;
                    }
                    $new_ledlist[]=$dqlist[$kk];
                }
                $this->assign('ledlist', $new_ledlist);
                $p = I('p', '1', 'intval');
                $this->assign('p', $p);
                $this->assign('total_pages', $total_pages);
                $this->assign('count', $count);
                $this->assign('page_show', $page_show);
                
                
                $this->set_seo_title("LED显示");
                $this->display();
    }
    
     public function getbldlist()
    {
            if (!IS_AJAX) {
                    $this->error('请求错误，请确认后重试！', U('account/Xsglled/index'));
            }
            $bldids = I('bldids', '', 'trim');
            $bldids = str_replace(",","','",$bldids);
            $pcid = I('pcid', 0, 'intval');
            $projid = I('projid', 0, 'intval');
            if (empty($pcid)||$pcid==0)
            {
                $this->error("数据错误，请重试");
            }

            $bldlist=M()->query("SELECT a.* FROM xk_build a WHERE a.pc_id=$pcid and a.proj_id= $projid  and id in ('$bldids') ORDER BY  a.id" );

            $this->success($bldlist);
    }
    
    public function ledcfshow(){
        if (!IS_AJAX) {
			$this->error('请求错误，请确认后重试！', U('accoount/index'));
		} 
        $id=I('id', 0, 'intval');
        $project_id = I('project_id', 0, 'intval');
        $batch_id = I('batch_id', 0, 'intval');
        $bldlist=I('bldlist', '', 'trim');
        $bldnamelist=I('bldnamelist', '', 'trim');
        $nobldlist=I('nobldlist', '', 'trim');
        $nobldnamelist=I('nobldnamelist', '', 'trim');
        
        if (empty($batch_id)||empty($project_id) || $bldlist=="")
        {
            $this->error("数据错误，请重试111");
        }
        if(empty($id))
        {
             $data[0]['project_id']=$project_id;
             $data[0]['batch_id']=$batch_id;
             $data[0]['bldidlist']=$bldlist;
             $data[0]['bldnamelist']=$bldnamelist;
             
             $data[1]['project_id']=$project_id;
             $data[1]['batch_id']=$batch_id;
             $data[1]['bldidlist']=$nobldlist;
             $data[1]['bldnamelist']=$nobldnamelist;
             M()->table("xk_xsledset")->addAll($data);
        }
        else
        {
            $data['bldidlist']=$bldlist;
            $data['bldnamelist']=$bldnamelist;
            
            $data1['project_id']=$project_id;
            $data1['batch_id']=$batch_id;
            $data1['bldidlist']=$nobldlist;
            $data1['bldnamelist']=$nobldnamelist;
            
            $model = D("XsledSet");  
            try {
                $model->startTrans();
                $model->where("id={$id}")->save($data);
                M()->table("xk_xsledset")->add($data1);
                $model->commit();
            }catch (\Exception $e) {
                 $model->rollback();
                 $this->error("系统错误，请稍后重试");
            }
        }
        $this->success('操作成功！', '',true);
    }
    
     public function deletecf() {
        if (!IS_POST) {
            $this->error("访问错误，请确认后重试！");
        }

        $id = I('id', '0', 'intval');

        if (empty($id)) {
            $this->error("数据错误，请重试1！");
        }
        $dqset=D('XsledSet')->find($id);
        if(empty($dqset)){
            $this->error("数据错误，请重试2！");
        }
        D('XsledSet')->where("project_id = {$dqset['project_id']} and batch_id = {$dqset['batch_id']}")->delete();

        $this->success("删除成功！");
    }
    
    
    public function led()
    {
        $userid=$this->get_user_id();
        $bids=I('bldids', '', 'trim');
        $project_id=I('pid', 0, 'intval');
        $projinfo=M()->query("select * from xk_project where id=". $project_id );
        $where =" where 1=1 ";
        $where.= " and bld_id in($bids)";
        $group_room_build = M()->query("SELECT bld_id,buildname,buildcode FROM xk_roomlist " . $where . "  GROUP BY bld_id ORDER BY bld_id,id asc");
//        echo $str;exit;
        $group_room_unit = M()->query("SELECT `bld_id`,`unit` FROM `xk_roomlist` ". $where . "  GROUP BY bld_id, unit ORDER BY bld_id,id asc");
        $group_room_floor = M()->query("SELECT `bld_id`,`unit`,`floor` FROM `xk_roomlist` ". $where . "  GROUP BY bld_id, floor ORDER BY bld_id,cast(floor as SIGNED) desc,id DESC");
        $group_room_nolist = M()->query("SELECT `bld_id`,`unit`,`no` FROM `xk_roomlist` ". $where . "  GROUP BY bld_id, unit, no ORDER BY  bld_id,cast(unit as SIGNED),cast(no as SIGNED),id asc");
        $group_room_no = M()->query("SELECT * FROM `xk_roomlist` ". $where . "  ORDER BY bld_id,cast(unit as SIGNED),cast(floor as SIGNED) desc,cast(no as SIGNED),id ASC");
        $ysroom = M()->query("SELECT count(1) as yscount,sum(total) as cjtotal FROM `xk_roomlist` ". $where . " AND is_xf=1 ORDER BY bld_id,cast(unit as SIGNED),cast(floor as SIGNED) desc,cast(no as SIGNED),id ASC");
               
        $this->assign('rooms', $group_room_no);
        $this->assign('nolist', $group_room_nolist);
        $this->assign('floors', $group_room_floor);
        $this->assign('units', $group_room_unit);
        $this->assign('ii', 0);
        $this->assign('projinfo',$projinfo);
        $this->assign('projid',$project_id);
        $this->assign('bldid',0);
        $this->assign('roomcount', count($group_room_no));
        $this->assign('yscount', $ysroom[0]['yscount']);
        $this->assign('wscount', count($group_room_no)-$ysroom[0]['yscount']);
        $this->assign('cjtotal', round($ysroom[0]['cjtotal']/10000,2));
        $this->assign('xsqhl', round($ysroom[0]['yscount']/count($group_room_no)*100,0));
        
        unset($where);
        //获取相关楼栋
        $build_ids = array();
        foreach ($group_room_build as $group_room_build_k => $group_room_build_v) {
                $build_ids[] = $group_room_build_v['bld_id'];
        }
        if (!empty($build_ids)) {
			$Build = D('Common/Build');
			$where['id'] = array('in', $build_ids);
			$build_list = $Build->getBuildList($where, 'cast(buildname as SIGNED), id asc');
        } else {
			$build_list = array();
        }
        $build_new_list = array();
        foreach ($build_list as $key => $build) {
                $build_new_list[$build['id']] = $build;
        }
        $this->assign('builds', $build_new_list);
        
        $this->set_seo_title("LED大屏显示");
        $this->display();
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
            $projid = I('projid', 0, 'trim');
            //$bldid = I('bldid', 0, 'trim');
            $Model = new \Think\Model(); 
 
             //获取选房数据; 10分钟之内的取消选房数据
            $rooms=$Model->query("SELECT a.* FROM xk_roomlist a WHERE 333=333 and  a.proj_id=" .$projid."  and (is_qxxf=1 or is_xf=1)  ORDER BY a.xftime desc,a.qxxftime desc,a.bld_id,a.unit,a.floor desc,a.no,a.id ASC ;" );
            $rooms = empty($rooms)?[]:$rooms;
            $this->success(['成功',$rooms]);
    } 
}
