<?php

namespace Saler\Controller;


/**
 * 首页
 *
 * @create 2016-8-25
 * @author zlw
 */
class EventOrderHouseController extends BaseEventOrderHouseController
{

    /**
     * 活动数据展示页面
     *
     */
    public function index()
    {
        $eventId = I('get.eventId',0,'intval');

        $buildingId = I('get.buildingId',0,'intval');

        $unit = I('get.unit',0,'intval');

        if (empty($eventId))
            $this->error('', U('EventOrderHouse/list'));

        $eventOrderHouseModel = D('Common/EventOrderHouse');

        $event = $eventOrderHouseModel->getOne($eventId);

        $buildings = D('Common/Build')->getBuildingsOrderBuildCodeByBatchIdProjectId($event['batch_id'],$event['project_id']);

        //项目判断
        if (!empty($buildingId)){
            $exists = false;

            foreach ($buildings as &$building) {
                if ($buildingId == $building['id']){
                    $findBuilding = $building;
                    $exists=true;
                    break;
                }
            }

            if (!$exists)
                $this->error('', U('EventOrderHouse/list'));
        }else{
            $findBuilding = $buildings[0];
        }

        $units = D('Common/Room')->getAllUnitsByBuilding(array_column($buildings,'id'));
        $buildingUnits = [];

        //栋 含有 单元 冗余 查询
        for($i=0;$i<count($units);$i++){
            $buildingUnits[$units[$i]['bld_id']][]=$units[$i]['unit'];
        }

        $units = array_column($units,'unit');

        //单元判断
        if (!empty($unit)){
            if (in_array($unit,$units))
                $findUnit = $unit;
            else
                $this->error('', U('EventOrderHouse/list'));
        }else{
            $findUnit = $units[0];
        }

        $rooms = D('Common/Room')->getRoomListOrderFloorDescNoAscByBuildingIdUnitId($findBuilding['id'],$findUnit);

        $orderedRooms = D('Common/OrderHouseOrder')->getOrderedHouseByEventId($eventId);
        $orderedRooms = array_column($orderedRooms,'room_id');

        $hotRooms = D('Common/Cst2rooms')
            ->field('room_id')
            ->where([
                'proj_id'=>$event['project_id']
            ])
            ->group('room_id')
            ->limit(10)
            ->select();
        $hotRooms = array_column($hotRooms,'room_id');

        $this->assign('eventId',$eventId);

        $this->assign('event',$event);

        $this->assign('buildings',$buildings);

        $this->assign('units',$units);
        $this->assign('buildingUnits',$buildingUnits);

        $this->assign('rooms',json_encode(empty($rooms)?[]:$rooms));
        $this->assign('orderedRooms',json_encode(empty($orderedRooms)?[]:$orderedRooms));
        $this->assign('hotRooms',json_encode(empty($hotRooms)?[]:$hotRooms));

        $this->assign('findBuilding',$findBuilding);
        $this->assign('findUnit',$findUnit);

        $this->display();
    }

    public function room(){
        $eventId = I('post.eventId',0,'intval');

        $buildingId = I('post.buildingId',0,'intval');

        $unit = I('post.unit',0,'intval');

        if (empty($eventId))
            $this->error('', U('EventOrderHouse/list'));

        $eventOrderHouseModel = D('Common/EventOrderHouse');

        $event = $eventOrderHouseModel->getOne($eventId);

        $buildings = D('Common/Build')->getBuildingsOrderBuildCodeByBatchIdProjectId($event['batch_id'],$event['project_id']);

        //项目判断
        $findBuilding = null;
        if (!empty($buildingId)){
            $exists = false;

            foreach ($buildings as &$building) {
                if ($buildingId == $building['id']){
                    $findBuilding = $building;
                    $exists=true;
                    break;
                }
            }

            if (!$exists)
                $this->error('', U('EventOrderHouse/list'));
        }else{
            $findBuilding = $buildings[0];
        }

        $units = D('Common/Room')->getAllUnitsByBuilding(array_column($buildings,'id'));
        $buildingUnits = [];

        //栋 含有 单元 冗余 查询
        for($i=0;$i<count($units);$i++){
            $buildingUnits[$units[$i]['bld_id']][]=$units[$i]['unit'];
        }

        $units = array_column($units,'unit');

        $findUnit = null;
        //单元判断
        if (!empty($unit)){
            if (in_array($unit,$units))
                $findUnit = $unit;
            else
                $this->error('', U('EventOrderHouse/list'));
        }else{
            $findUnit = $units[0];
        }

        $rooms = D('Common/Room')->getRoomListOrderFloorDescNoAscByBuildingIdUnitId($findBuilding['id'],$findUnit);

        $orderedRooms = D('Common/OrderHouseOrder')->getOrderedHouseByEventId($eventId);
        $orderedRooms = array_column($orderedRooms,'room_id');

        $hotRooms = D('Common/Cst2rooms')
            ->field('room_id')
            ->where([
                'proj_id'=>$event['project_id']
            ])
            ->group('room_id')
            ->limit(10)
            ->select();
        $hotRooms = array_column($hotRooms,'room_id');

        $this->show(json_encode([
            'rooms'=>empty($rooms)?[]:$rooms
            ,'orderedRooms'=>empty($orderedRooms)?[]:$orderedRooms
            ,'hotRooms'=>empty($hotRooms)?[]:$hotRooms
        ]));
    }

    public function hot(){
//collection 收藏，comparison 对比，follow 关注
        $now_type = I('type', '', 'strtolower,trim');
        if (!in_array($now_type, array('collection', 'comparison', 'follow'))) {
            $now_type = 'collection';
        }
        $this->assign('now_type', $now_type);

        //分析
        $eventId = I('eventId',0,'intval');
        if (empty($eventId))
            $this->error('', U('EventOrderHouse/list'));

        $this->assign('eventId',$eventId);

        $event = D('Common/EventOrderHouse')->getOne($eventId);


        $search_project_id = $event['project_id'];
        if ($search_project_id == 0) {
            $this->error('项目不存在，请查看其他项目！', U('index/index'));
        }

        //设置当前搜索
        $search = array(
            'search_project_id' => $search_project_id,
        );
        $this->assign($search);

        //获取项目
        $Project = D('Common/Project');
        $project_info = $Project->getProjectById($search_project_id);
        $this->assign('project', $project_info);

        //判断是否该项目
        $user_where['userid'] = $this->get_user_id();
        $user_where['projid'] = $search_project_id;
        $user_project_list = D("Station")->getpProjectListByUserId($user_where['userid'], $user_where['projid']);
        if (empty($user_project_list)) {
            $this->error('你没有该项目，请选择其他项目！', U('index/index'));
        }

        //户型
        $Room = D('Common/Room');
        $Roomview = D('Common/Roomview');
        $hx_list = $Roomview->getRoomListGroupBy('hx', 'hx', 'hx ASC', array());
        $this->assign('hx_list', $hx_list);

        //户型列表
        $hxs = array();
        foreach ($hx_list as $hx_list_value) {
            $hxs[] = $hx_list_value;
        }

        //当前户型
        $now_hx = I('hx', '', 'strtolower,trim');
        $now_hxs = explode(',', $now_hx);
        $this->assign('now_hxs', $now_hxs);

        //当前查询key
        switch ($now_type) {
            case 'comparison':
                $now_attribute_key = 'sscount';
                $attribute_where['sscount'] = array('NEQ', 0);
                $attribute_order_by = 'sscount DESC';
                $sub_title = '对比次数';
                break;
            case 'follow':
                $now_attribute_key = 'djcount';
                $attribute_where['djcount'] = array('NEQ', 0);
                $attribute_order_by = 'djcount DESC';
                $sub_title = '关注次数';
                break;
            case 'collection':
            default:
                $now_attribute_key = 'sccount';
                $attribute_where['sccount'] = array('NEQ', 0);
                $attribute_order_by = 'sccount DESC';
                $sub_title = '收藏次数';
                break;
        }
        if (!empty($now_hxs[0])) {
            $attribute_where['hx'] = array('in', $now_hxs);
        }
        $attribute_where['proj_id'] = $search_project_id;

        //收藏
        $attribute_list = D("Common/Roomattribute")->getAttributeListJoinRoom(
            $attribute_where,
            $attribute_order_by,
            'room_id, djcount, sccount, sscount',
            10
        );

        $max_count = $attribute_list[0][$now_attribute_key];
        foreach ($attribute_list as $attribute_list_key => $attribute_list_value) {
            $attribute_list[$attribute_list_key]['precision'] = round(($attribute_list_value[$now_attribute_key]/$max_count)*100, 2).'%';
            $attribute_list[$attribute_list_key]['now_count'] = $attribute_list_value[$now_attribute_key];
        }
        $this->assign('attribute_list', $attribute_list);

        //房间ID列表
        $room_ids = array();
        foreach ($attribute_list as $attribute) {
            $room_ids[$attribute['room_id']] = $attribute['room_id'];
        }

        //获取房间列表
        if (!empty($room_ids)) {
            $where['id'] = array('in', $room_ids);
            if (!empty($now_hxs[0])) {
                $where['hx'] = array('in', $now_hxs);
            }
            $where['proj_id'] = $search_project_id;
            $room_list = D("Common/Room")->getRoomList($where);
        } else {
            $room_list = array();
        }

        $build_ids = array();
        $new_room_list = array();
        foreach ($room_list as $room_list_k => $room_list_v) {
            $build_ids[$room_list_v['bld_id']] = $room_list_v['bld_id'];
            $new_room_list[$room_list_v['id']] = $room_list_v;
        }

        $this->assign('room_list', $new_room_list);

        //获取相关楼栋
        if (!empty($build_ids)) {
            $Build = D('Common/Build');
            $where['id'] = array('in', $build_ids);
            $old_build_list = $Build->getBuildList($where, 'buildname, id DESC');
        } else {
            $old_build_list = array();
        }

        $build_list = array();
        foreach ($old_build_list as $key => $build) {
            $build_list[$build['id']] = $build;
        }
        $this->assign('build_list', $build_list);

        //二级标题
        $this->assign('sub_title', $sub_title);

        if (IS_AJAX) {
            $this->display('sale');
        } else {
            $this->set_seo_title($project_info['name']);
            $this->display();
        }
    }

	/**
	 * 活动列表
	 *
	 */
    public function list()
	{

        $user_where['userid'] = $this->get_user_id();
        $Model = new \Think\Model();
        $userinfo=$Model->query("SELECT * FROM xk_user WHERE id=". $user_where['userid'] ." limit 1" );
        if (empty($userinfo) || count($userinfo)<1)
            $this->error('用户登录信息异常，请重新登录！', U('logging/index'));

        $user_project_list = D("Station")->getpProjectListByUserId($user_where['userid']);


        $eventOrderHouseModel = D('Common/EventOrderHouse');

        $project_ids = array();
        foreach ($user_project_list as $user_project_list_value) {
            $project_ids[] = $user_project_list_value['proj_id'];
        }

        $options = [
            'where'=>[
                'project_id'=>[
                    'in'
                    ,$project_ids
                ]
            ]
        ];

        $eventList = $eventOrderHouseModel->select($options);

        //print_r($eventList);exit;
        $this->assign('eventList',$eventList);

        $this->display();
    }
	
	public function login(){
        $this->set_seo_title("登录");
        $this->display();
    }

    /**
     * 登录
     *
     */
    public function check()
    {
        if (!IS_AJAX) {
            $this->error('请求错误，请确认后重试！', U('EventOrderHouse/login'));
        }

        $name = I('name', '', 'trim');
        if (empty($name)) {
            $this->error('用户名不能为空！', U('EventOrderHouse/login'));
        }
        $Model = new \Think\Model();
        $user=$Model->query("SELECT * FROM xk_user WHERE (code='" . $name . "' or mobile='".$name."')  limit 1" );

        $password = I('pwd', '', 'trim');
        if ($user[0]['password'] != md5(md5($password))) {
            $this->error('用户名或者密码错误！', U('EventOrderHouse/login'));
        }
        session('USER_ID', $user[0]['id']);
        $this->success(U('EventOrderHouse/list'));
    }


    /**
     * 退出
     *
     */
    public function logout()
    {
        session('USER_ID', null);

        $this->success('退出成功！', U('EventOrderHouse/login'));
    }
}