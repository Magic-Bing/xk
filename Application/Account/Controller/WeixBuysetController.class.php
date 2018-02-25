<?php

namespace Account\Controller;

/**
 * 微信认购设置
 *
 * @create 2017-04-17
 * @author jxw
 */
class WeixBuysetController extends BaseController {

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
        $this->set_current_action('weixbuy_set', 'weixbuy');
    }

    public function index(){
        //项目ID
        if(isset($_POST['project_id'])){
            $search_project_id = I('project_id', 0, 'intval');
            session("selected_project",$search_project_id);
        }else{
            $search_project_id = session("selected_project");
        }
        $search_batch_id = I('batch_id', 0, 'intval');
        $search_word = I('word', '', 'trim');
        $this->assign('bid', $search_batch_id);

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

        $eventOrderHouseModel = D('Common/EventOrderHouse');

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

       if (!empty($search_batch_id)) {
            $where['batch_id'][] = $search_batch_id;
        }else{
            //批次条件
            if (!empty($user_batch_ids)) {
                $where['batch_id'] = array('in', $user_batch_ids);
            } else {
                $where['batch_id'] = '-99999';
            }
        }

        //搜索查询
        if (!empty($search_word)) {
            $like['name'] = array('like', '%' . $search_word . '%');
            /*$like['rdd_project_name'] = array('like', '%' . $search_word . '%');*/
            $where['_complex'] = $like;
        }

        //总数
        $choose_activity_count = $eventOrderHouseModel->where($where)->count();

        //分页
        $Page = $this->bootstrapPage($choose_activity_count, 15);
        $page_show = $Page->show();
        $total_pages = $Page->totalPages;

        //取范围
        $limit = $Page->firstRow . ',' . $Page->listRows;

        $choose_activity_list = $eventOrderHouseModel->getList(
            $where, '*', 'start_time DESC, id DESC', $limit
        );

        foreach ($choose_activity_list as &$choose_activity) {

            $choose_activity['project_name'] = $project_list[$choose_activity['project_id']]['name'];

        }

        $p = I('p', '1', 'intval');
        $this->assign('p', $p);
        $this->assign('total_pages', $total_pages);
        $this->assign('count', $choose_activity_count);
        $this->assign('page_show', $page_show);

        $this->assign('choose_activity_list', $choose_activity_list);
        
        $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
        $this->assign('http_type', $http_type);
        $this->set_seo_title("微信认购设置");
        $this->display();
    }

    public function display_add(){
        //项目ID
        $project_id = I('project_id', 0, 'intval');
        $this->assign('project_id', $project_id);

        //用户的项目和项目批次
        $user_project_ids = $this->get_user_project_ids();
        $user_batch_ids = $this->get_user_batch_ids();

        //获取项目列表
        $project_where = array();
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
        $user_batch_where = array();
        if (!empty($user_batch_ids)) {
            $user_batch_where['id'] = array('in', $user_batch_ids);
        } else {
            $user_batch_where['id'] = '-99999';
        }
        $batch_list = D('Batch')->getList($user_batch_where, '*');
        $this->assign('batch_list', $batch_list);

        if (!empty($batch_list)) {
            foreach ($batch_list as $batch_list_key => $batch_list_value) {
                $project_batch_list[$batch_list_value['proj_id']][] = array(
                    'n' => urlencode($batch_list_value['name']),
                    'v' => $batch_list_value['id'],
                );
            }
        } else {
            $project_batch_list = array();
        }

        $project_new_list = array();
        if (!empty($project_old_list)) {
            foreach ($project_old_list as $project_old_list_key => $project_old_list_value) {
                $project_new_list[] = array(
                    'n' => urlencode($project_old_list_value['company_name'] . '--' . $project_old_list_value['name']),
                    'v' => $project_old_list_value['id'],
                    's' => isset($project_batch_list[$project_old_list_value['id']]) ? $project_batch_list[$project_old_list_value['id']] : ''
                );
            }
        }

        $project_json = urldecode(json_encode($project_new_list));
        $this->assign('project_json', $project_json);

        $this->set_seo_title('微信认购设置');

        $this->display('add');
    }
    
    public function add()
    {
        if (!IS_AJAX){
            $this->error("提交错误，请稍后重试！");
        }
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->saveName = array('uniqid','');
        $upload->savePath  =      '../Uploads/img/wxlogin/'; // 设置附件上传目录    // 上传单个文件
        $upload->autoSub  = true;
        $upload->subName  = array('date','Ymd');
        $info   =   $upload->uploadOne($_FILES['login_img']);
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }
        $obj = array();
        $path= "/Uploads/img/wxlogin/".date("Ymd",time())."/".$info['savename'];
        $obj['loginimg']=$path;
        $notEmpty = array('name'=>'没有填写名称','project_id'=>'没有选择项目','batch_id'=>'没有选择批次','start_time'=>'没有选择开始时间','end_time'=>'没有选择结束时间');
        foreach (array_keys($notEmpty) as $item) {
            $value = I("post.{$item}");

            if (empty($value)){
                $this->error($notEmpty[$item]);
            }

            $obj[$item] = $value;
        }

        $fields = array('desc','mark','maxcount');
        foreach ($fields as $item) {
            $obj[$item] = I("post.{$item}");
        }
        $obj['is_short_message']=I("short","","trim")?1:0;
        $obj['states']=I("states","","trim")?1:0;
        $obj['isysdl']=I("isysdl","","trim")?1:0;
        $obj['is_show_discount']=I("is_show_discount","","trim")?1:0;
        $obj['is_aqyz']=I("is_aqyz","","trim")?1:0;
        $project = D("project")->field('cp_id,name')->where(array('id'=>$obj['project_id']))->find();

        if (empty($project['cp_id'])){
            $this->error('提交错误，请稍后重试！');
        }

        $obj['company_id'] = $project['cp_id'];
        $obj['rdd_company_name'] = $project['cp_id'];

        $obj['start_time'] = strtotime($obj['start_time']);
        $obj['end_time'] = strtotime($obj['end_time']);

        $obj['log_time'] = time();

        $eventOrderHouseModel = D('EventOrderHouse');
        $result = $eventOrderHouseModel->add($obj);

        if ($result){
            if(!empty($obj['states']))
                D('EventOrderHouse')->initializeByIdToRedis($result,1);

            $this->success('添加成功');
        }else{
            $this->error('添加失败，请稍后重试。');
        }
    }

    public function display_edit()
    {
        $id = I('id', 0, 'intval');
        if ($id == 0) {
            $this->error("活动信息不存在，请确认后重试！");
        }
        $this->assign('id', $id);

        //奖励信息
        $eventOrderHouseModel = D('EventOrderHouse');

        $choose_activity = $eventOrderHouseModel->getOneById($id);
        if (empty($choose_activity)) {
            $this->error("活动信息不存在，请确认后重试！");
        }

        $this->assign('choose_order_house', $choose_activity);

        //用户的项目和项目批次
        $user_project_ids = $this->get_user_project_ids();
        $user_batch_ids = $this->get_user_batch_ids();

        //获取项目列表
        $project_where = array();
        if (!empty($user_project_ids)) {
            $project_where['id'] = array('in', $user_project_ids);
        } else {
            $project_where['id'] = '-99999';
        }
        $project_old_list = D('Common/ProjectView')->getList($project_where, 'company_id DESC, id DESC', '500');
        if (!empty($project_old_list)) {
            foreach ($project_old_list as $project_list_key => $project_list_value) {
                $project_list[$project_list_value['id']] = $project_list_value;
            }
        } else {
            $project_list = array();
        }
        $this->assign('project_list', $project_list);

        //批次
        $user_batch_where = array();
        if (!empty($user_batch_ids)) {
            $user_batch_where['id'] = array('in', $user_batch_ids);
        } else {
            $user_batch_where['id'] = '-99999';
        }
        $batch_list = D('Batch')->getList($user_batch_where, '*');
        $this->assign('batch_list', $batch_list);

        if (!empty($batch_list)) {
            foreach ($batch_list as $batch_list_key => $batch_list_value) {
                $project_batch_list[$batch_list_value['proj_id']][] = array(
                    'n' => urlencode($batch_list_value['name']),
                    'v' => $batch_list_value['id'],
                );
            }
        } else {
            $project_batch_list = array();
        }

        $project_new_list = array();
        if (!empty($project_old_list)) {
            foreach ($project_old_list as $project_old_list_key => $project_old_list_value) {
                $project_new_list[] = array(
                    'n' => urlencode($project_old_list_value['company_name'] . '--' . $project_old_list_value['name']),
                    'v' => $project_old_list_value['id'],
                    's' => isset($project_batch_list[$project_old_list_value['id']]) ? $project_batch_list[$project_old_list_value['id']] : ''
                );
            }
        }

        $project_json = urldecode(json_encode($project_new_list));
        $this->assign('project_json', $project_json);

        //当前批次
        $batch_id = $choose_activity['batch_id'];
        $batch_where['id'] = $batch_id;
        $batch = D('Batch')->getOne($batch_where, '*');
        $this->assign('batch', $batch);

        $this->set_seo_title('微信认购设置');

        $this->display('edit');
    }
    public function edit()
    {
        if (!IS_AJAX){
            $this->error("提交错误，请稍后重试！");
        }
        $obj = array();
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->saveName = array('uniqid','');
        $upload->savePath  =      '../Uploads/img/wxlogin/'; // 设置附件上传目录    // 上传单个文件
        $upload->autoSub  = true;
        $upload->subName  = array('date','Ymd');
        $info   =   $upload->uploadOne($_FILES['login_img']);
        if($info) {// 上传错误提示错误信息
            $path= "/Uploads/img/wxlogin/".date("Ymd",time())."/".$info['savename'];
            $obj['loginimg']=$path;
        }
        $notEmpty = array('id'=>'应用错误','name'=>'没有填写名称','project_id'=>'没有选择项目','batch_id'=>'没有选择批次','start_time'=>'没有选择开始时间','end_time'=>'没有选择结束时间','maxcount'=>'没有填写备选房间个数');
        foreach (array_keys($notEmpty) as $item) {
            $value = I("post.{$item}");

            if (empty($value)){
                $this->error($notEmpty[$item]);
            }

            $obj[$item] = $value;
        }

        $fields = array('desc','mark');
        foreach ($fields as $item) {
            $obj[$item] = I("post.{$item}");
        }
        $obj['is_short_message']=I("short","","trim")?1:0;
        $obj['states']=I("states","","trim")?1:0;
        $obj['isysdl']=I("isysdl","","trim")?1:0;
        $obj['is_show_discount']=I("is_show_discount","","trim")?1:0;
        $obj['is_aqyz']=I("is_aqyz","","trim")?1:0;
        $project = D("project")->field('cp_id,name')->where(array('id'=>$obj['project_id']))->find();

        if (empty($project['cp_id'])){
            $this->error('提交错误，请稍后重试！');
        }

        $obj['company_id'] = $project['cp_id'];
        $obj['rdd_company_name'] = $project['cp_id'];

        $obj['start_time'] = strtotime($obj['start_time']);
        $obj['end_time'] = strtotime($obj['end_time']);

        $obj['log_time'] = time();
        
        $id = $obj['id'];
        $options = array('where'=>array('id'=>$id));
        unset($obj['id']);

        $eventOrderHouseModel = D('EventOrderHouse');
        $result = $eventOrderHouseModel->save($obj,$options);

        if(!empty($obj['states']))
            D('EventOrderHouse')->initializeByIdToRedis($id,1);
        else
        {
            D('EventOrderHouse')->cleanAllById($id);
            D('EventOrderHouse')->cleanLogById($id);
        }
        if ($result){
            $this->success('修改成功');
        }else{
            $this->error('修改失败，请稍后重试。');
        }
    }

    public function remove()
    {
        if (!IS_AJAX){
            $this->error("提交错误，请稍后重试！");
        }

        $ids = I("post.ids",0,'intval');

        if(empty($ids))
            $this->error("活动信息不存在，请确认后重试！");

        $eventOrderHouseModel = D('EventOrderHouse');
        $option = [
            'where'=>['id'=>['in',$ids]]
        ];
        $eventOrderHouseModel->delete($option);

        foreach ($ids as $item) {
            $eventOrderHouseModel->cleanAllById($item);
        }

        $this->success('删除成功');

    }

    public function AnalyticalRoomHot(){

//        $eventId = I("eventId",0);
        $this->set_current_action('weixbuy_fx', 'weixbuy');
//        if (empty($eventId))
//            $this->error('没有选中活动');
        $selected_project=session("selected_project");
        $this->assign('selected_project', $selected_project);
        //用户的项目和项目批次
        $user_project_ids = $this->get_user_project_ids();

//        $user_batch_ids = $this->get_user_batch_ids();
        $arr_string=implode(",",$user_project_ids);
       $projects=M()->table("xk_project")->field("id,name")->where("id in($arr_string)")->order("id DESC")->select();
//       echo json_encode($projects);exit;
        //预购房间模型
      /*  $eventOrderHouseModel = D('Common/EventOrderHouse');

        //获取活动
        $event = $eventOrderHouseModel->getOne($eventId);

        //活动
        if( !in_array($event['project_id'],$user_project_ids) || !in_array($event['batch_id'],$user_batch_ids) )
            $this->error('无权限');
        $roomModel = D('Common/Room');
        $rooms = $roomModel->getRoomAttrByBuildingIdBatchId($event['project_id'],$event['batch_id']);*/
//                echo json_encode($rooms);exit;
//        $this->assign('eventId',$event['id']);
//        $this->assign('eventName',$event['name']);
        $this->assign('projects',$projects);
        $this->set_seo_title("微信认购分析");
        $this->display();
    }

    /*==================================微信认购分析=====================================*/
    /*
     * 获取批次
     * 2017-10-19
     * qzb*/
    public  function get_px(){
        $pid=I("pid",0,'intval');
        session('selected_project',$pid);
        $batchs=M()->table("xk_kppc")->field("id,name")->where("proj_id=$pid")->select();
        echo json_encode($batchs);exit;
    }
    /*
     * 获取活动
     * 2017-10-19
     * qzb*/
    public  function get_hd(){
        $pid=I("post.pid");
        $bid=I("post.bid");
        $hd=M()->table("xk_event_order_house")->field("id,name")->where("project_id=$pid AND batch_id=$bid")->select();
        echo json_encode($hd);exit;
    }
    /*
     * 热点分析
     * 2017-10-19
     * qzb*/
    public function get_hot(){
        $pid=I("post.pid");
        $bid=I("post.bid");
        $hid=I("post.hid");
        $roomModel = D('Common/Room');
        $rooms = $roomModel->getRoomAttrByBuildingIdBatchId($pid,$bid);
        $this->assign('rooms',$rooms);
        echo $this->fetch(":WeixBuyset/FxHot");exit;
    }

    //房源认购情况
    public function AnalyticalRoomOrder(){
        $pid=I("post.pid");
        $bid=I("post.bid");
        $hid=I("post.hid");
        $roomModel = D('Common/Room');

        //获取所有房源
        $rooms = $roomModel->getRoomsByBuildingIdBatchId($pid,$bid);

        //获取已被预定的房源
        $orderHouseOrderModel = D('Common/OrderHouseOrder');
        $orders = $orderHouseOrderModel->getOrderedRoomsByEventId($hid);

        //合并数据
        for ($i=0;$i<count($orders);$i++){
            for ($j=0;$j<count($rooms);$j++){
                if ($orders[$i]['room_id']==$rooms[$j]['id']){

                    $rooms[$j]['order_time'] = date('Y-m-d H:i:s',$orders[$i]['log_time']);
                    $rooms[$j]['belong_real_name'] = $orders[$i]['belong_real_name'];
                     $rooms[$j]['belong_phone'] = $orders[$i]['belong_phone'];

                    array_splice($orders,$i,1);
                    $i--;
                    break;
                }
            }
        }
        $this->assign('rooms',$rooms);
        echo $this->fetch();exit;
    }

    //客户收藏和认购统计
    public function AnalyticalCustomerCollectedOrdered(){
        $pid=I("post.pid");
        $bid=I("post.bid");
        $hid=I("post.hid");
        $sql = "
        SELECT 
            choose.id
            ,choose.customer_name
            ,choose.customer_phone
            ,collection.room_id
            ,`order`.build_name
            ,`order`.unit_no
            ,`order`.floor_no
            ,`order`.room_no
            ,`order`.room_room
            ,GROUP_CONCAT(distinct CONCAT(building.buildname,'-', collection_room.unit,'-', collection_room.floor,'-', collection_room.room)) AS collection
            ,CONCAT(choose.ywy, '(', choose.ywyphone,')') AS adviser
        FROM
             xk_choose choose                                                         
                LEFT JOIN
            xk_project project ON project.id = choose.project_id                     
                LEFT JOIN
            xk_user user ON user.cp_id = project.cp_id                               
                AND user.NAME=choose.ywy
                LEFT JOIN
            xk_order_house_phone_login login ON login.phone = choose.customer_phone  
                LEFT JOIN
            xk_cst2rooms collection ON collection.cst_id = choose.id
                LEFT JOIN
            xk_order_house_order `order` on `order`.belong_phone = login.phone       
                LEFT JOIN
            xk_room collection_room on collection_room.id = collection.room_id       
                LEFT JOIN
            xk_build building on building.id = collection_room.bld_id                      
        WHERE
            choose.project_id = {$pid}
                AND choose.batch_id = {$bid}
        GROUP BY choose.id
        ;
        ";
        $data = D('Common/Choose')->query($sql);
        foreach ($data as &$item){
            $item['collection'] = explode(',',$item['collection']);
            foreach ($item['collection'] as &$itemA)
                $itemA = explode('-',$itemA);
            $item['room_no'] = $item['floor_no']."".sprintf('%02s',$item['room_no']);
        }
        $this->assign('data',$data);
        echo $this->fetch();exit;
    }

    //未登录用户客户明细
    public function AnalyticalCustomerNotLogin(){
        $pid=I("post.pid");
        $bid=I("post.bid");
        $hid=I("post.hid");
        $sql="
        SELECT 
            choose.id
            ,choose.customer_name
            ,choose.customer_phone
            ,choose.cardno
            ,choose.cyjno
            ,choose.ywy
            ,choose.ywyphone
        FROM
            xk_choose choose
                LEFT JOIN
            xk_order_house_phone_login login ON choose.customer_phone = login.phone 
                AND login.event_id = {$hid}
              
        WHERE
            choose.project_id = {$pid}
                AND choose.batch_id = {$bid}
                And login.phone is null
         GROUP BY choose.id
        ;
        ";
        $data = D('Common/Choose')->query($sql);
        $this->assign('data',$data);
        $this->display();
    }
    /*==================================    END    =====================================*/

   /* public function AnalyticalRoomOrder(){

        $eventId = I("eventId",0);
        if (empty($eventId))
            $this->error('没有选中活动');
        //用户的项目和项目批次
        $user_project_ids = $this->get_user_project_ids();
        $user_batch_ids = $this->get_user_batch_ids();

        //预购房间模型
        $eventOrderHouseModel = D('Common/EventOrderHouse');

        //获取活动
        $event = $eventOrderHouseModel->getOne($eventId);

        //活动
        if( !in_array($event['project_id'],$user_project_ids) || !in_array($event['batch_id'],$user_batch_ids) )
            $this->error('无权限');

        $roomModel = D('Common/Room');

        //获取所有房源
        $rooms = $roomModel->getRoomsByBuildingIdBatchId($event['project_id'],$event['batch_id']);

        //获取已被预定的房源
        $orderHouseOrderModel = D('Common/OrderHouseOrder');
        $orders = $orderHouseOrderModel->getOrderedRoomsByEventId($eventId);

        //合并数据

        for ($i=0;$i<count($orders);$i++){
            for ($j=0;$j<count($rooms);$j++){
                if ($orders[$i]['room_id']==$rooms[$j]['id']){

                    $rooms[$j]['order_time'] = date('Y-m-d H:i:s',$orders[$i]['log_time']);
                    $rooms[$j]['belong_real_name'] = $orders[$i]['belong_real_name'];

                    array_splice($orders,$i,1);
                    $i--;
                    break;
                }
            }
        }

        $this->assign('eventId',$event['id']);
        $this->assign('eventName',$event['name']);

        $this->assign('rooms',$rooms);


        $this->display();
    }

    public function AnalyticalCustomerCollectedOrdered(){

        $eventId = I("eventId",0);
        if (empty($eventId))
            $this->error('没有选中活动');
        //用户的项目和项目批次
        $user_project_ids = $this->get_user_project_ids();
        $user_batch_ids = $this->get_user_batch_ids();

        //预购房间模型
        $eventOrderHouseModel = D('Common/EventOrderHouse');

        //获取活动
        $event = $eventOrderHouseModel->getOne($eventId);

        //活动
        if( !in_array($event['project_id'],$user_project_ids) || !in_array($event['batch_id'],$user_batch_ids) )
            $this->error('无权限');

//        $sql = "
//        SELECT
//            choose.id
//            ,choose.customer_name
//            ,choose.customer_phone
//            ,collection.room_id
//            ,`order`.build_name
//            ,`order`.unit_no
//            ,`order`.floor_no
//            ,`order`.room_no
//            ,GROUP_CONCAT(distinct CONCAT(building.buildname,'-', collection_room.unit,'-', collection_room.floor,'-', collection_room.no)) AS collection
//            ,GROUP_CONCAT(distinct CONCAT(user.name, ' ', user.mobile)) AS adviser
//        FROM
//            xk_choose choose                                                         --客户
//                LEFT JOIN
//            xk_project project ON project.id = choose.project_id                     --项目 于 客户 关联 ，用于 下一步 关联 置业顾问
//                LEFT JOIN
//            xk_user user ON user.cp_id = project.cp_id                               --用户 于 项目 关联 , 为2 为置业顾问 ， 获取 置业顾问
//                AND user.type = 2
//                LEFT JOIN
//            xk_order_house_phone_login login ON login.phone = choose.customer_phone  --登陆 于 客户 关联 ，用于 下一步 收藏
//                LEFT JOIN
//            xk_cst2rooms collection ON collection.cst_id = login.customer_id         --收藏 于 登陆 关联 ，用于 下一步 收藏房间
//                LEFT JOIN
//            xk_order_house_order `order` on `order`.belong_phone = login.phone       --预定 于 登陆 关联 ，用于 获取 已预购成功
//                LEFT JOIN
//            xk_room collection_room on collection_room.id = collection.room_id       --收藏房间 于 收藏 关联 ， 用于 获取 所有收藏房间数据
//                LEFT JOIN
//            xk_build building on building.id = collection_room.bld_id                --栋 于 收藏房间 关联 ，用于 获取 栋名
//        WHERE
//            choose.project_id = {$event['project_id']}
//                AND choose.batch_id = {$event['batch_id']}
//        GROUP BY choose.id
//        ;
//        ";

        $sql = "
        SELECT
            choose.id
            ,choose.customer_name
            ,choose.customer_phone
            ,collection.room_id
            ,`order`.build_name
            ,`order`.unit_no
            ,`order`.floor_no
            ,`order`.room_no
            ,GROUP_CONCAT(distinct CONCAT(building.buildname,'-', collection_room.unit,'-', collection_room.floor,'-', collection_room.no)) AS collection
            ,GROUP_CONCAT(distinct CONCAT(user.name, ' ', user.mobile)) AS adviser
        FROM
            xk_choose choose
                LEFT JOIN
            xk_project project ON project.id = choose.project_id
                LEFT JOIN
            xk_user user ON user.cp_id = project.cp_id
                AND user.type = 2
                LEFT JOIN
            xk_order_house_phone_login login ON login.phone = choose.customer_phone
                LEFT JOIN
            xk_cst2rooms collection ON collection.cst_id = login.customer_id
                AND  collection.proj_id = {$event['project_id']}
                LEFT JOIN
            xk_order_house_order `order` on `order`.belong_phone = login.phone
                LEFT JOIN
            xk_room collection_room on collection_room.id = collection.room_id
                LEFT JOIN
            xk_build building on building.id = collection_room.bld_id
        WHERE
            choose.project_id = {$event['project_id']}
                AND choose.batch_id = {$event['batch_id']}
        GROUP BY choose.id
        ;
        ";


        $data = D('Common/Choose')->query($sql);

        foreach ($data as &$item){
            $item['collection'] = explode(',',$item['collection']);

            foreach ($item['collection'] as &$itemA)
                $itemA = explode('-',$itemA);

            $item['room_no'] = $item['floor_no']."".sprintf('%02s',$item['room_no']);

        }

        $this->assign('eventId',$event['id']);
        $this->assign('eventName',$event['name']);

        $this->assign('data',$data);

        $this->display();
    }

    public function AnalyticalCustomerNotLogin(){
        $eventId = I("eventId",0,'intval');
        if (empty($eventId))
            $this->error('没有选中活动');
        //用户的项目和项目批次
        $user_project_ids = $this->get_user_project_ids();
        $user_batch_ids = $this->get_user_batch_ids();

        //预购房间模型
        $eventOrderHouseModel = D('Common/EventOrderHouse');

        //获取活动
        $event = $eventOrderHouseModel->getOne($eventId);

        //活动
        if( !in_array($event['project_id'],$user_project_ids) || !in_array($event['batch_id'],$user_batch_ids) )
            $this->error('无权限');

//        $sql="
//        SELECT
//            choose.id
//            ,choose.customer_name
//            ,choose.customer_phone
//            ,GROUP_CONCAT(distinct CONCAT(user.name, ' ', user.mobile)) AS adviser
//        FROM
//            xk_choose choose                                                         --客户
//                right JOIN
//            xk_order_house_phone_login login ON choose.customer_phone != login.phone --客户登陆记录 关于 客户 ，关联 不等于 手机号
//                LEFT JOIN
//            xk_project project ON project.id = choose.project_id                     --项目 于 客户 关联 ，用于 下一步 关联 置业顾问
//                LEFT JOIN
//            xk_user user ON user.cp_id = project.cp_id                               --用户 于 项目 关联 , 为2 为置业顾问 ， 获取 置业顾问
//                AND user.type = 2
//        WHERE
//            choose.project_id = 3
//                AND choose.batch_id = 3
//         GROUP BY choose.id
//        ;
//        ";

        $sql="
        SELECT 
            choose.id
            ,choose.customer_name
            ,choose.customer_phone
            ,GROUP_CONCAT(distinct CONCAT(user.name, ' ', user.mobile)) AS adviser
        FROM
            xk_choose choose
                LEFT JOIN
            xk_order_house_phone_login login ON choose.customer_phone = login.phone 
                AND login.event_id = {$event['id']}
                LEFT JOIN
            xk_project project ON project.id = choose.project_id                     
                LEFT JOIN
            xk_user user ON user.cp_id = project.cp_id                               
                AND user.type = 2 
        WHERE
            choose.project_id = {$event['project_id']}
                AND choose.batch_id = {$event['batch_id']}
                And login.phone is null
         GROUP BY choose.id
        ;
        ";

        $data = D('Common/Choose')->query($sql);

        $this->assign('eventId',$event['id']);
        $this->assign('eventName',$event['name']);

        $this->assign('data',$data);

        $this->display();

    }*/


}
