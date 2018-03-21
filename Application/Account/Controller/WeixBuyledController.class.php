<?php

namespace Account\Controller;

use Think\Cache\Driver\Redis;
use \Redis as OriginRedis;
/**
 * 微信认购LED大屏
 *
 * @create 2017-04-17
 * @author jxw
 */
class WeixBuyledController extends BaseController {

    /**
     * 系统构造函数
     *
     * @create 2017-04-17
     * @author jxw
     */
    public function _initialize() {
        parent::_initialize();

        //分类名称
        $this->assign('classify_name', '微信开盘');

        //设置当前方法
        $this->set_current_action('weixbuy_led', 'weixbuy');
    }

    public function index(){

        //项目ID
        if(isset($_POST['project_id'])){
            $search_project_id = I('project_id', 0, 'intval');
            session("selected_project",$search_project_id);
        }else{
            $search_project_id = session("selected_project");
        }
        if(isset($_POST['batch_id'])){
            $search_batch_id = I('batch_id', 0, 'intval');
            session("selected_batch",$search_batch_id);
        }else{
            $search_batch_id = (int)session("selected_batch");
        }
        $search_word = I('word', '', 'trim');

        //设置当前搜索
        $search = array(
            'search_project_id' => $search_project_id,
            'search_batch_id' => $search_batch_id,
            'search_word' => $search_word,
        );
        $this->assign($search);

        //项目
        $Project = D('Common/Project');

        //获取当前项目
        $project_info = $Project->getProjectById($search_project_id);
        $this->assign('project', $project_info);

        //用户的项目和项目批次
        $user_project_ids = $this->get_user_project_ids();
        $user_batch_ids = $this->get_user_batch_ids();

        if ($search_project_id != 0) {
            if (!in_array($search_project_id, $user_project_ids)) {
                $this->error("你没有权限访问该项目的信息！");
            }
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
                $project_list[$project_list_value['id']] = $project_list_value;
            }
        } else {
            $project_list = array();
        }
        $this->assign('project_list', $project_list);

        //批次
        if (!empty($user_batch_ids)) {
            $user_batch_where['id'] = array('in', $user_batch_ids);
        } else {
            $user_batch_where['id'] = '-99999';
        }
        $user_batch_where['proj_id'] = $search_project_id;
        $batch_list = D('Batch')->getList($user_batch_where, '*');
        $this->assign('batch_list', $batch_list);

        $orderHouseOrderModel = D('Common/EventOrderHouse');

        //条件
        $where = array();
        if (!empty($search_project_id)) {
            $where['project_id'][] = $search_project_id;
        }

        //项目条件
        if (!empty($user_project_ids)) {
            $where['project_id'][] = array('in', $user_project_ids);
        } else {
            $where['project_id'][] = '-99999';
        }

        //批次条件
        if (!empty($user_batch_ids)) {
            $where['batch_id'][] = array('in', $user_batch_ids);
        } else {
            $where['batch_id'][] = '-99999';
        }

        //搜索查询
        if (!empty($search_word)) {
            $like['name'] = array('like', '%' . $search_word . '%');
            /*$like['buildname'] = array('like', '%' . $search_word . '%');
            $like['_logic'] = 'or';*/
            $where['_complex'] = $like;
        }

        //总数
        $choose_activity_count = $orderHouseOrderModel->where($where)->count();

        //分页
        $Page = $this->bootstrapPage($choose_activity_count, 15);
        $page_show = $Page->show();
        $total_pages = $Page->totalPages;

        //取范围
        $limit = $Page->firstRow . ',' . $Page->listRows;

        $choose_activity_list = $orderHouseOrderModel->getList(
            $where, '*', 'log_time DESC, id DESC', $limit
        );
         
        if (!empty($choose_activity_list))
        {
            $i=0;
            foreach($choose_activity_list as $choose_activity )
            {
                $bldlist="";
                $allbld=M()->query("select buildname from xk_build where proj_id= " .$choose_activity['project_id'] ." and pc_id= " .$choose_activity['batch_id']);
                foreach($allbld as $onebld)
                {
                    if ($bldlist=="")
                    {
                        $bldlist=$onebld['buildname'];
                    }
                    else
                    {
                        $bldlist.=";".$onebld['buildname'];
                    }
                }
                $choose_activity_list[$i]['bldlist']=$bldlist;
                $roomcount=M()->query("select count(1) as roomcount,pcname from xk_roomlist where proj_id= " .$choose_activity['project_id'] ." and 99=99 and pc_id= " .$choose_activity['batch_id']);
                $choose_activity_list[$i]['roomcount']=$roomcount[0]['roomcount'];
                $choose_activity_list[$i]['batch_name']=$roomcount[0]['pcname'];
                $choose_activity_list[$i]['project_name'] =$project_list[$choose_activity['project_id']]["name"];
                $i++;
            }
        }
        $p = I('p', '1', 'intval');
        $this->assign('p', $p);

        $this->assign('total_pages', $total_pages);
        $this->assign('count', $choose_activity_count);
        $this->assign('page_show', $page_show);
        $this->assign('choose_activity_list', $choose_activity_list);
        $this->set_seo_title("LED大屏显示");

        $this->display();
    }
    
    public function led()
    {
        $userid=$this->get_user_id();
        $eid=I("eid",0,'intval');
        if($eid==0)
        {
            redirect(U('../login/index'),0);
        }
        $event=M()->query("select * from xk_event_order_house where id=".$eid);
        if (!empty($event))
        {
            $projid = $event[0]['project_id'];
            $pc_id = $event[0]['batch_id'];
        }
        else
        {
            $this->error('系统错误，请重试！', U('../login/index'));
        }
        $this->assign('eventId',$eid);
        //活动倒计时
        if($event[0]["states"]==1)//开启
        {
            $time = $event[0]['end_time']*1000-$this->getMillisecond();
            if (time()<$event[0]['start_time'])//活动未开始时，返回活动开始倒计时time和整个活动时长time1
            {
                $time=$event[0]['start_time']*1000-$this->getMillisecond();
                $time1=$event[0]['end_time']*1000-$event[0]['start_time']*1000;
                $this->assign('iswks',1);
                $this->assign('time1',$time1);
            }
            else {//活动已开始，返回的time和time1一样
               $time = $event[0]['end_time']*1000-$this->getMillisecond();
               if(time()>$event[0]['end_time']){
                   $this->assign('iswks',-1);//活动已结束
               }
               else
               {
                   $this->assign('iswks',0);
               }
               $this->assign('time1',$time);
            }
            //活动倒计时
            $this->assign('time',$time);
        }
        else//关闭
        {
            $time=0;
            $time1=0;
            $this->assign('iswks',-1);//活动已结束
            $this->assign('time',$time);
            $this->assign('time1',$time1);
        }
        $oneuser=D("User")->find($userid);
        if(empty($oneuser))
        {
              $this->error('系统错误，请重试！', U('../login/index'));
        }
        else
        {
            if($oneuser['is_all']<1)
            {
                $projlist1=M()->query("select * from xk_station2user a left join xk_station2proj b on a.station_id=b.station_id where a.userid=".$userid ." and b.proj_id=". $projid );
                if (empty($projlist1) || count($projlist1)<1){
                         $this->error('您无权查看此项目，请联系管理员！', U('login/index'));
                }
            }
        }
        $where="";
        if ($pc_id<>0)
        {
            $where=" and pc_id=".$pc_id;
        }
        $projinfo=M()->query("select * from xk_project where id=". $projid );
        
        $group_room_build = M()->query("SELECT bld_id,buildname,buildcode FROM xk_roomlist WHERE proj_id = " . $projid . $where . "  GROUP BY bld_id ORDER BY bld_id,id asc");
        $group_room_unit = M()->query("SELECT `bld_id`,`unit` FROM `xk_roomlist` WHERE proj_id = ".$projid . $where . "  GROUP BY bld_id, unit ORDER BY bld_id,id asc");
        $group_room_floor = M()->query("SELECT `bld_id`,`unit`,`floor` FROM `xk_roomlist` WHERE `proj_id` = ".$projid.$where . "  GROUP BY bld_id, floor ORDER BY bld_id,cast(floor as SIGNED) desc,id DESC");
        $group_room_nolist = M()->query("SELECT `bld_id`,`unit`,`no` FROM `xk_roomlist` WHERE `proj_id` = ". $projid . $where . "  GROUP BY bld_id, unit, no ORDER BY  bld_id,cast(unit as SIGNED),cast(no as SIGNED),id asc");
        $group_room_no = M()->query("SELECT * FROM `xk_roomlist` WHERE `proj_id` = " . $projid . $where . "  ORDER BY bld_id,cast(unit as SIGNED),cast(floor as SIGNED) desc,cast(no as SIGNED),id ASC");
        $ysroom = M()->query("SELECT count(1) as yscount,sum(total) as cjtotal FROM `xk_roomlist` WHERE `proj_id` = " . $projid . $where . " AND is_xf=1 ORDER BY bld_id,cast(unit as SIGNED),cast(floor as SIGNED) desc,cast(no as SIGNED),id ASC");
        //数据格式化
        /*foreach ($group_room_nolist as $group_room_nolist_key => $group_room_nolist_value) {
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
        }*/
        
        //print_r($group_room_nolist);
//        echo json_encode($group_room_no);exit;
        $this->assign('rooms', $group_room_no);
        $this->assign('nolist', $group_room_nolist);
        $this->assign('floors', $group_room_floor);
        $this->assign('units', $group_room_unit);
        $this->assign('ii', 0);
        $this->assign('projinfo',$projinfo);
        $this->assign('projid',$projid);
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
    
    public function ledbak()
    {
        $userid=$this->get_user_id();
        $eid=I("eid","0",'intval');
        if($eid==0)
        {
            redirect(U('../login/index'),0);
        }
        $event=M()->query("select * from xk_event_order_house where id=".$eid);
        if (!empty($event))
        {
            $projid = $event[0]['project_id'];
            $pc_id = $event[0]['batch_id'];
        }
        else
        {
            $this->error('系统错误，请重试！', U('../login/index'));
        }
        $this->assign('eventId',$eid);
        //活动倒计时
        if($event[0]["states"]==1)//开启
        {
            $time = $event['end_time']*1000-$this->getMillisecond();
            if (time()<$event['start_time'])//活动未开始时，返回活动开始倒计时time和整个活动时长time1
            {
                $time=$event['start_time']*1000-$this->getMillisecond();
                $time1=$event['end_time']*1000-$event['start_time']*1000;
                $this->assign('iswks',1);
                $this->assign('time1',$time1);
            }
            else {//活动已开始，返回的time和time1一样
               $time = $event['end_time']*1000-$this->getMillisecond();
               if(time()>$event['end_time']){
                   $this->assign('iswks',-1);//活动已结束
               }
               else
               {
                   $this->assign('iswks',0);
               }
               $this->assign('time1',$time);
            }
            //活动倒计时
            $this->assign('time',$time);
        }
        else//关闭
        {
            $time=0;
            $time1=0;
            $this->assign('iswks',-1);//活动已结束
            $this->assign('time',$time);
            $this->assign('time1',$time1);
        }
         
        $projlist1=M()->query("select * from xk_station2user a left join xk_station2proj b on a.station_id=b.station_id where a.userid=".$userid ." and b.proj_id=". $projid );
        if (empty($projlist1) || count($projlist1)<1){
                 $this->error('您无权查看此项目，请联系管理员！', U('login/index'));
        }
        $where="";
        if ($pc_id<>0)
        {
            $where=" and pc_id=".$pc_id;
        }
        $projinfo=M()->query("select * from xk_project where id=". $projid );
        
        $group_room_build = M()->query("SELECT bld_id,buildname,buildcode FROM xk_roomlist WHERE proj_id = " . $projid . $where . "  GROUP BY bld_id ORDER BY id DESC");
        $group_room_unit = M()->query("SELECT `bld_id`,`unit` FROM `xk_roomlist` WHERE proj_id = ".$projid . $where . "  GROUP BY bld_id, unit ORDER BY id asc");
        $group_room_floor = M()->query("SELECT `bld_id`,`unit`,`floor` FROM `xk_roomlist` WHERE `proj_id` = ".$projid.$where . "  GROUP BY bld_id, floor ORDER BY id DESC");
        $group_room_nolist = M()->query("SELECT `bld_id`,`unit`,`no` FROM `xk_roomlist` WHERE `proj_id` = ". $projid . $where . "  GROUP BY bld_id, unit, no ORDER BY cast(unit as SIGNED),cast(no as SIGNED),id asc");
        $group_room_no = M()->query("SELECT * FROM `xk_roomlist` WHERE `proj_id` = " . $projid . $where . "  ORDER BY bld_id,cast(unit as SIGNED),cast(floor as SIGNED) desc,cast(no as SIGNED),id ASC");
        $ysroom = M()->query("SELECT count(1) as yscount FROM `xk_roomlist` WHERE `proj_id` = " . $projid . $where . " AND is_xf=1 ORDER BY bld_id,cast(unit as SIGNED),cast(floor as SIGNED) desc,cast(no as SIGNED),id ASC");
        //数据格式化
         foreach ($group_room_nolist as $group_room_nolist_key => $group_room_nolist_value) {
            $group_room_nolist[$group_room_nolist_value['bld_id']][$group_room_nolist_value['unit']][] = $group_room_nolist_value;
        }
        
        print_r($group_room_nolist);
        foreach ($group_room_unit as $group_room_unit_key => $group_room_unit_value) {
                $group_room_unit[$group_room_unit_value['bld_id']][] = $group_room_unit_value;
        }
        foreach ($group_room_floor as $group_room_floor_key => $group_room_floor_value) {
            $group_room_floor[$group_room_floor_value['bld_id']][] = $group_room_floor_value;
        }
        foreach ($group_room_no as $group_room_no_key => $group_room_no_value) {
            $group_room_no[$group_room_no_value['bld_id']][$group_room_no_value['unit']][$group_room_no_value['floor']][$group_room_no_value['no']][] = $group_room_no_value;
        }
        
        $this->assign('rooms', $group_room_no);
        $this->assign('nolist', $group_room_nolist);
        $this->assign('floors', $group_room_floor);
        $this->assign('units', $group_room_unit);
        $this->assign('ii', 0);
        $this->assign('projinfo',$projinfo);
        $this->assign('projid',$projid);
        $this->assign('roomcount', count($group_room_no));
        $this->assign('yscount', $ysroom[0]['yscount']);
        $this->assign('xsqhl', round($ysroom[0]['yscount']/count($group_room_no)*100,2));
        
        
        
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
        
        $this->set_seo_title("LED大屏显示");
        $this->display();
    }
    
    /**
     * 获取所有已购买房间的ID
     */
    public function getAllOrderedRooms(){
        if (!IS_AJAX) {
            $this->error('请求错误，请确认后重试！');
        }

        $eventId = I('eventId', 0, 'intval');
        if (empty($eventId)){
            $this->error('活动ID不能为空，请确认后重试！');
        }

        $redis = new OriginRedis();
        $redis->connect(C('REDIS_HOST'));

        $event = $redis->hGetAll("event_order_house_{$eventId}");
        
        //if (!empty($event) && time()>$event['start_time'] &&time()<$event['end_time'])
        if (!empty($event) )
        {
            $eventOrderHouseModel = D('Common/EventOrderHouse');
            $orderedRooms = $eventOrderHouseModel->getAllOrderedRoomInRedis($eventId);
        }
        //else
        //{
        //    $event1=M("event_order_house")->find($eventId);
        //    $orderedRooms=M()->query("select * from xk_roomlist where proj_id=" . $event1['project_id'] . " and pc_id=" . $event1['batch_id'] ." order by xftime");
        //}
        $orderedRooms = empty($orderedRooms)?[]:$orderedRooms;

        //$this->show(json_encode($orderedRooms));
        $this->success(['成功',$orderedRooms]);
    }
    //单独获取活动倒计时(包含毫秒)
    public function geteventdjs() {
        if (!IS_AJAX)
            $this->error('请求错误，请确认后重试！');

        $id = I('id', 0, 'intval');
        $eventOrderHouseModel = D('Common/EventOrderHouse');
        //$event = $eventOrderHouseModel->getEventByEventId(geturl($id, getUrlkey())["eventId"]);
        $event = $eventOrderHouseModel->getEventByEventId($id);
        $dqhm = $this->getMillisecond();
        if ($dqhm < $event['start_time'] * 1000) {//活动未开始时，返回活动开始倒计时time和整个活动时长time1
            $time = $event['start_time'] * 1000 - $dqhm;
            $time1=$event['end_time']*1000-$event['start_time']*1000;
            $djsinfo['iswks'] = 1;
            $djsinfo['time1'] = $time1;
        } else {//活动已开始，返回的time和time1一样
            if ($dqhm > $event['end_time'] * 1000) {
                $time = 0;
            } else {
                $time = $event['end_time'] * 1000 - $dqhm;
            }
            $djsinfo['iswks'] = 0;
            $djsinfo['time1'] = $time;
        }
        $djsinfo['time'] = $time;
        $this->success(['成功', $djsinfo]);
    }
    
    //当前时间戳(包含毫秒)
    public function getMillisecond() { 
        list($s1, $s2) = explode(' ', microtime()); 
        return (float)sprintf('%.0f', (floatval($s1) + floatval($s2)) * 1000); 
    }
}
