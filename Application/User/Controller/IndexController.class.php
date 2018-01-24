<?php

namespace User\Controller;


/**
 * 首页
 *
 * @create 2016-8-22
 * @author zlw
 */
class IndexController extends BaseController 
{
	/**
	 * 构造方法
	 *
	 * @create 2016-11-16
	 * @author zlw
	 */
	public function _initialize()
	{
		//设置项目相关
		$this->set_project();
		//$this->wx_login();
		parent::_initialize();
	}
        
	
	/**
	 * 设置项目相关
	 *
	 * @create 2016-11-16
	 * @author zlw
	 */
	protected function set_project()
	{
		$search_info = I('info', '', 'trim');
		
		$project_id = get_search_id_by($search_info, 'p', '');
		if (!empty($project_id)) {
			D('Weixin', 'Logic')->setProjectId($project_id);
		}
	}
	
	/**
	 * 首页
	 *
	 * @create 2016-8-22
	 * @author zlw
	 */
    public function index() 
	{		
		//分析
		$search_info = I('info', '', 'trim');
		$this->assign("info",$search_info);

		$search_project_id = get_search_id_by($search_info, 'p');
        $count=$this->get_bx_count($search_project_id);
        $this->assign("cou",$count);
        $this->assign("eventId",$search_project_id);
		if( !empty($search_project_id)&& $search_project_id>0)
		{
			 $model = new \Think\Model();
			 $pclst=$model->query("select * from xk_kppc a where a.proj_id='". $search_project_id ."' and is_dq=1 order by id desc limit 1 ");
			 cookie('pc_id',$pclst[0]['id']);
			 cookie('proj_id',$pclst[0]['proj_id']);
		}

		//归类
		$Room = D('Common/Room');
		$Roomview = D('Common/Roomview');
		$where['proj_id'] = $search_project_id;
		$where['is_dq'] = 1;
		$group_room_build = $Roomview->getRoomListGroupBy('bld_id', 'bld_id', 'bld_id, id', $where);
		$group_room_unit = $Roomview->getRoomListGroupBy('bld_id, unit', 'bld_id, unit', 'bld_id, unit, id', $where);

		//数据格式化
		$new_group_room_unit = array();
		foreach ($group_room_unit as $group_room_unit_key => $group_room_unit_value) {
			$new_group_room_unit[$group_room_unit_value['bld_id']][] = $group_room_unit_value;
		}
		$this->assign('new_units', $new_group_room_unit);
		$this->assign('units', array_merge($new_group_room_unit));

		//分析
		$search_build_id = get_search_id_by($search_info, 'b', $group_room_build[0]['bld_id']);
		$search_unit_id = get_search_id_by($search_info, 'u', $new_group_room_unit[$search_build_id][0]['unit']);

		//获取楼层
		unset($where);
		$where['proj_id'] = $search_project_id;
		$where['bld_id'] = $search_build_id;
		$where['unit'] = $search_unit_id;
		$group_room_floor = $Room->getRoomListGroupBy('floor', 'floor DESC', 'id DESC', $where);
		$this->assign('floors', $group_room_floor);

		//设置当前搜索
		$search = array(
			'search_project_id' => $search_project_id,
			'search_build_id' 	=> $search_build_id,
			'search_unit_id' 	=> $search_unit_id,
		);
		$this->assign($search);

		//户型
		//$Room = D('Common/Room');
		$Roomview = D('Common/Roomview');
		$hx_list = $Roomview->getRoomListGroupBy('hx, proj_id', 'hx', 'hx ASC', array('proj_id' => $search_project_id));
		$this->assign('hx_list', $hx_list);

		//项目
		$Project = D('Common/Project');
		
		//获取项目
		$project_info = $Project->getProjectById($search_project_id);
		$this->assign('project', $project_info);

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
		$this->assign('buildings', array_merge($build_new_list));
//        echo json_encode($build_new_list);exit;
		//房间
		unset($where);
		$where['proj_id'] = $search_project_id;
		$where['bld_id'] = $search_build_id;
		$where['unit'] = $search_unit_id;
		$room_list = D("Common/Room")->getRoomListJoinAttribute($where, 'floor DESC, no ASC');

		$new_room_list = array();
		$room_ids = array();
		foreach ($room_list as $room_list_key => $room_list_value) {
			$new_room_list[$room_list_value['floor']][] = $room_list_value;
			$room_ids[] = $room_list_value['id'];
		}
		$this->assign('rooms', $new_room_list);
//        echo json_encode($group_room_floor);
//        echo json_encode($new_room_list);exit;
		//收藏
		unset($where);
		$collection_room_ids = array();
		if (count($room_list)>1)
		{
			$where['cst_id'] 	= $this->get_customer_id();
			$where['room_id'] 	= array('in', $room_ids);
			$room_collection = D('Common/Collection')->getList($where);
			foreach ($room_collection as $room_collection_key => $room_collection_value) {
				$collection_room_ids[] = $room_collection_value['room_id'];
			}
		}		
		$this->assign('collection_room_ids', $collection_room_ids);
//        echo json_encode($build_new_list);
//        echo json_encode($new_group_room_unit);
//        exit;
		$this->set_seo_title($project_info['name']);
        $this->display();
    }

    /**
     * 房间列表
     *
     * @create 2016-9-6
     * @author zlw
     */
    public function room()
    {
        $search_where = array();

        //楼栋
        $build_ids = I('build_ids', '', 'trim');
        if (!empty($build_ids)) {
            $search_where['bld_id'] = array('in', explode(',', $build_ids));
        }

        //楼层
        $floor_start = I('floor_start', '', 'trim');
        if (!empty($floor_start)) {
            $search_where['floor'][] = array('egt', intval($floor_start));
        } else {
            $search_where['floor'][] = array('egt', -2);
        }
        $floor_end = I('floor_end', '', 'trim');
        if (!empty($floor_end)) {
            $search_where['floor'][] = array('elt', intval($floor_end));
        } else {
            $search_where['floor'][] = array('elt', 999);
        }

        //面积
        $area_start = I('area_start', '', 'trim');
        if (!empty($area_start)) {
            $search_where['area'][] = array('egt', intval($area_start));
        } else {
            $search_where['area'][] = array('egt', 1);
        }
        $area_end = I('area_end', '', 'trim');
        if (!empty($area_end)) {
            $search_where['area'][] = array('elt', intval($area_end));
        }else{
            $search_where['area'][] = array('elt', 99999);
        }


        //价格
        $price_start = I('price_start', '', 'trim');
        if (!empty($price_start)) {
            $search_where['price'][] = array('egt', intval($price_start));
        }else{
            $search_where['price'][] = array('egt', 1);
        }

        $price_end = I('price_end', '', 'trim');
        if (!empty($price_end)) {
            $search_where['price'][] = array('elt', intval($price_end));
        }else{
            $search_where['price'][] = array('elt', 999999999);
        }


        //户型
        $hx_ids = I('hx_ids', '', 'trim');
        if (!empty($hx_ids)) {
            $search_where['hx'] = array('in', explode(',', $hx_ids));
        }

        //项目
        $Project = D('Common/Project');
        $project_list = $Project->getProjectList(array(
            'status' => 1
        ), 'name ASC, id ASC');
        $this->assign('projects', $project_list);

        //格式化楼栋
        $new_project_list = array();
        foreach ($project_list as $project_list_key => $project_list_value) {
            $new_project_list[$project_list_value['id']][] = $project_list_value;
        }
        $this->assign('new_projects', $new_project_list);

        //分析
        $search_info = I('info', '', 'trim');
        $search_project_id = get_search_id_by($search_info, 'p', $project_list[0]['id']);

        //户型
        $Room = D('Common/Room');
        unset($where);
        $where['proj_id'] = $search_project_id;
        $hx_list = $Room->getRoomListGroupBy('hx, proj_id', 'hx', 'hx ASC', $where);
        $this->assign('hx_list', $hx_list);

        //归类
        $Room = D('Common/Room');
        $where['proj_id'] = $search_project_id;
        $where = array_merge($where, $search_where);
        $group_room_build = $Room->getRoomListGroupBy('bld_id', 'bld_id', 'bld_id, id', $where);
        $group_room_unit = $Room->getRoomListGroupBy('bld_id, unit', 'bld_id, unit', 'bld_id, unit, id', $where);

        //数据格式化
        $new_group_room_unit = array();
        foreach ($group_room_unit as $group_room_unit_key => $group_room_unit_value) {
            $new_group_room_unit[$group_room_unit_value['bld_id']][] = $group_room_unit_value;
        }
        $this->assign('new_units', $new_group_room_unit);

        //分析
        $search_build_id = get_search_id_by($search_info, 'b', $group_room_build[0]['bld_id']);
        $search_unit_id = get_search_id_by($search_info, 'u', $new_group_room_unit[$search_build_id][0]['unit']);

        //获取楼层
        unset($where);
        $where['proj_id'] 	= $search_project_id;
        $where['bld_id'] 	= $search_build_id;
        $where['unit'] 		= $search_unit_id;
        $where = array_merge($where, $search_where);
        $group_room_floor = $Room->getRoomListGroupBy('floor', 'floor DESC', 'id DESC', $where);
        $this->assign('floors', $group_room_floor);

        //设置当前搜索
        $search = array(
            'search_project_id' => $search_project_id,
            'search_build_id' 	=> $search_build_id,
            'search_unit_id' 	=> $search_unit_id,
        );
        $this->assign($search);

        //获取项目
        $project_info = $Project->getProjectById($search_project_id);
        $this->assign('project', $project_info);

        //获取相关楼栋
        $build_ids = array();
        foreach ($group_room_build as $group_room_build_k => $group_room_build_v) {
            $build_ids[] = $group_room_build_v['bld_id'];
        }

        if (!empty($build_ids)) {
            $Build = D('Common/Build');
            $where['id'] = array('in', $build_ids);
            $build_list = $Build->getBuildList($where, 'buildname, id DESC');
        } else {
            $build_list = array();
        }

        $build_new_list = array();
        foreach ($build_list as $key => $build) {
            $build_new_list[$build['id']] = $build;
        }
        $this->assign('builds', $build_new_list);

        //房间
        unset($where);

        $where['proj_id'] 	= $search_project_id;
        $where['bld_id'] 	= $search_build_id;
        $where['unit'] 		= $search_unit_id;
        $where = array_merge($where, $search_where);
        //$room_list = D("Common/Room")->getRoomList($where, 'floor DESC, no ASC');
        $room_list = D("Common/Room")->getRoomListJoinAttribute($where, 'floor DESC, no ASC');

        $new_room_list = array();
        foreach ($room_list as $room_list_key => $room_list_value) {
            $new_room_list[$room_list_value['floor']][] = $room_list_value;
        }

        $new_room_list = array();
        $room_ids = array();
        foreach ($room_list as $room_list_key => $room_list_value) {
            $new_room_list[$room_list_value['floor']][] = $room_list_value;
            $room_ids[] = $room_list_value['id'];
        }
        $this->assign('rooms', $new_room_list);

        //收藏
        unset($where);
        $collection_room_ids = array();
        if (count($room_list)>1)
        {
            $where['cst_id'] 	= $this->get_customer_id();
            $where['room_id'] 	= array('in', $room_ids);
            $room_collection = D('Common/Collection')->getList($where);
            foreach ($room_collection as $room_collection_key => $room_collection_value) {
                $collection_room_ids[] = $room_collection_value['room_id'];
            }
        }
        $this->assign('collection_room_ids', $collection_room_ids);

        unset($where);
        $where['cst_id'] = $this->get_customer_id();
        $where['hd_id'] = 1;
        $Wxrg = D('Common/WxrgLog')->getOne($where);
        $this->assign('wxrg', $Wxrg);
        //获取内容
        $room_list = $this->fetch();

        $this->success($room_list, U('index/index'));
    }


    /**
     * 微信认购
     *
     * @create 2017-04-25
     * @author jxw
     */
    public function wxrg()
    {
        //分析
        $search_info = I('info', '', 'trim');
        $search_project_id = get_search_id_by($search_info, 'p');
        if( !empty($search_project_id)&& $search_project_id>0)
        {
            $model = new \Think\Model();
            $pclst=$model->query("select * from xk_kppc a where a.proj_id='". $search_project_id ."' and is_dq=1 order by id desc limit 1 ");
            cookie('pc_id',$pclst[0]['id']);
            cookie('proj_id',$pclst[0]['proj_id']);
        }

        //归类
        $Room = D('Common/Room');
        $Roomview = D('Common/Roomview');
        $where['proj_id'] = $search_project_id;
        $where['is_dq'] = 1;
        $group_room_build = $Roomview->getRoomListGroupBy('bld_id', 'bld_id', 'bld_id, id', $where);
        $group_room_unit = $Roomview->getRoomListGroupBy('bld_id, unit', 'bld_id, unit', 'bld_id, unit, id', $where);

        //数据格式化
        $new_group_room_unit = array();
        foreach ($group_room_unit as $group_room_unit_key => $group_room_unit_value) {
            $new_group_room_unit[$group_room_unit_value['bld_id']][] = $group_room_unit_value;
        }
        $this->assign('new_units', $new_group_room_unit);

        //分析
        $search_build_id = get_search_id_by($search_info, 'b', $group_room_build[0]['bld_id']);
        $search_unit_id = get_search_id_by($search_info, 'u', $new_group_room_unit[$search_build_id][0]['unit']);

        //获取楼层
        unset($where);
        $where['proj_id'] = $search_project_id;
        $where['bld_id'] = $search_build_id;
        $where['unit'] = $search_unit_id;
        $group_room_floor = $Room->getRoomListGroupBy('floor', 'floor DESC', 'id DESC', $where);
        $this->assign('floors', $group_room_floor);

        //设置当前搜索
        $search = array(
            'search_project_id' => $search_project_id,
            'search_build_id' 	=> $search_build_id,
            'search_unit_id' 	=> $search_unit_id,
        );
        $this->assign($search);

        //户型
        //$Room = D('Common/Room');
        $Roomview = D('Common/Roomview');
        $hx_list = $Roomview->getRoomListGroupBy('hx, proj_id', 'hx', 'hx ASC', array('proj_id' => $search_project_id));
        $this->assign('hx_list', $hx_list);

        //项目
        $Project = D('Common/Project');

        //获取项目
        $project_info = $Project->getProjectById($search_project_id);
        $this->assign('project', $project_info);

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

        //房间
        unset($where);
        $where['proj_id'] = $search_project_id;
        $where['bld_id'] = $search_build_id;
        $where['unit'] = $search_unit_id;
        $room_list = D("Common/Room")->getRoomListJoinAttribute($where, 'floor DESC, no ASC');

        $new_room_list = array();
        $room_ids = array();
        foreach ($room_list as $room_list_key => $room_list_value) {
            $new_room_list[$room_list_value['floor']][] = $room_list_value;
            $room_ids[] = $room_list_value['id'];
        }
        $this->assign('rooms', $new_room_list);

        //收藏
        unset($where);
        $collection_room_ids = array();
        if (count($room_list)>1)
        {
            $where['cst_id'] 	= $this->get_customer_id();
            //$where['room_id'] 	= array('in', $room_ids);
            $where['proj_id'] 	= $search_project_id;
            $room_collection = D('Common/Collection')->getList($where);
            foreach ($room_collection as $room_collection_key => $room_collection_value) {
                $collection_room_ids[] = $room_collection_value['room_id'];
            }
        }

        //备选房间列表
        if (!empty($collection_room_ids)) {
            unset($where);
            $where['id'] = array('in', $collection_room_ids);
            $bxrooms = D("Common/Room")->getRoomListJoinWxrg($where, "bld_id ASC, unit ASC, floor ASC, no ASC");
        } else {
            $bxrooms = array();
        }

        //获取相关信息
        if (!empty($bxrooms)) {
            foreach ($bxrooms as $key => $room) {
                //楼栋信息
                $bld_id = $room['bld_id'];
                $build = D("Common/Build")->getBuildById($bld_id);

                //判断时间
                if (date('d', $room['xftime']) == date('d')) {
                    $time = date('H:i', $room['xftime']);
                } elseif (!empty($room['xftime'])) {
                    $time = date('Y-m-d H:i', $room['xftime']);
                } else {
                    $time = '';
                }
                $data = array(
                    'room_id' 		=> $room['id'],
                    'room_name' 	=> $build['buildname'].$room['unit'].'单元',
                    'room_floor' 	=> $room['floor'],
                    'room_number' 	=> $room['room'],
                    'room_hx' 		=> $room['hx'],
                    'room_area' 	=> $room['area'],
                    'room_tnarea' 	=> $room['tnarea'],
                    'room_total' 	=> $room['total'],
                    'room_is_xf' 	=> $room['is_xf'],
                    'xftime' 		=> $time
                );

                $bxrooms[$key] = array_merge($room, $data);
            }
        }
        $cstid=$this->get_customer_id();
        unset($where);
        $where['cst_id'] = $cstid;
        $where['hd_id'] = 1;
        $Wxrg = D('Common/WxrgLog')->getOne($where);
        $this->assign('wxrg', $Wxrg);
        $this->assign('bxrooms', $bxrooms);
        $this->assign('cstid', $cstid);
        $this->assign('collection_room_ids', $collection_room_ids);
        $this->assign('scgs', count($collection_room_ids));
        $this->set_seo_title($project_info['name']);
        $this->display();
    }


    /**
     * 微信认购
     *
     * @create 2017-04-26
     * @author jxw
     */
    public function wxrg_add()
    {
        if (!IS_AJAX) {
            $this->error('请求错误，请确认后重试！');
        }

        //获取ID
        $id = I('room_id', 0, 'intval');
        if (empty($id) || $id == 0) {
            $this->error('房间ID不能为空，请确认后重试！');
        }

        //验证当前房间信息
        $room = D("Room")->getRoomById($id);
        if (empty($room)) {
            $this->error('房间信息不存在，请确认后重试！');
        }
        $cstid=$this->get_customer_id();
        //判断当前房间是否选择
        $is_success=0;
        if ($room['is_xf'] <> 1) {
            //判断当前客户本次微信认购是否已购买房间
            unset($where);
            $where['cst_id'] = $cstid;
            $where['hd_id'] = 1;
            $cst2wxrg = D('Common/WxrgLog')->getList($where);
            if (!empty($cst2wxrg))
            {
                $this->error('已购买其他房间，不能再次购买！');
            }
            $cst = D("Customer")->getOneById($cstid);
            $data = array(
                'is_xf' => 1,
                'xftime' => time(),
                'cstname' => $cst['name'],
            );

            $check_has_edit = D("Room")->editRoomById($data, $id);
            if ($check_has_edit === false) {
                $this->error('认购失败，请确认后重试！', U('room/index'));
            }
            //日志
            $this->wxrg_add_log($room['id'],$cstid,$cst['name']);
            $is_success=1;
        }

        $Model = new \Think\Model();
        $projid=$room['proj_id'];
        //获取备选的房间
        unset($where);
        $where['cst_id'] = $cstid;
        $where['proj_id'] = $projid;
        $where['is_dq'] = 1;
        $bxrooms = D('Common/Collectionview')->getListJoinWxrg($where);
        $sxrooms=array();
        $sxrooms[0]=$is_success;
        $sxrooms[1]=$bxrooms;
        $this->success($sxrooms);
    }


    /**
     * 微信认购 - 后置操作方法
     *
     * @create 2017-04-26
     * @author jxw
     */
    public function wxrg_add_log($room_id,$cst_id, $cst_name)
    {
        D("WxrgLog")->wxrglog($room_id, $cst_id, $cst_name,1);
    }

    //备选房源(收藏列表)
    public function collectedroom()
    {
        $id = I('id', 0, 'trim');
        $cid = session("user_id");
        $model=M();
        $res=$model->table("xk_room r")->field("b.buildname bname,r.unit,r.floor,r.room,r.area,r.total,r.hx,h.hxmx,c.id,c.px,r.id rid")->
            join("xk_cst2rooms c ON r.id=c.room_id")->
            join("LEFT JOIN xk_hxset h ON h.hx=r.hx")->
            join("xk_build b ON b.id=r.bld_id")->
            where("c.proj_id=$id AND c.cst_id=$cid")->order("c.px asc")->select();
        $this->assign("res",$res);
        $this->assign("id",$id);
        $this->set_seo_title("备选房源");
        $this->display(":index/collectedroom");
    }

    //取消收藏
    public function delete_collected(){
        $id=I("post.id");
        $px=M()->table("xk_cst2rooms")->where("id=$id")->select();
        $pd=M()->table("xk_cst2rooms")->where("id=$id")->delete();
        if($pd){
            M()->execute("update xk_cst2rooms set px=(px-1) WHERE cst_id={$px[0]['cst_id']} AND proj_id={$px[0]['proj_id']} AND px>{$px[0]['px']}");
        }
        echo $pd?"true":"false";exit;
    }

    //调整排序
    public function update_px(){
        $cid=I("post.cid");
        $apx=I("post.apx");
        $pd=I("post.pd");
        $pid=I("post.pid");
        $uid=session("user_id");
        if(!$uid){
            $uid=cookie('user_id');
        }
        if($pd=="sx"){//升序
            $p=M()->table("xk_cst2rooms")->where("cst_id=$uid AND proj_id=$pid AND px=($apx-1)")->save(['px'=>$apx]);
            if($p){
                M()->table("xk_cst2rooms")->where("id=$cid")->save(['px'=>($apx-1)]);
            }else{
                echo 'false';exit;
            }
        }else{//降序
            $p=M()->table("xk_cst2rooms")->where("cst_id=$uid AND proj_id=$pid AND px=($apx+1)")->save(['px'=>$apx]);
            if($p){
                M()->table("xk_cst2rooms")->where("id=$cid")->save(['px'=>($apx+1)]);
            }else{
                echo 'false';exit;
            }
        }
    }
}
