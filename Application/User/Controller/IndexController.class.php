<?php

namespace User\Controller;
use Think\Controller;
/**
 * 首页
 *
 * @create 2016-8-22
 * @author zlw
 */
class IndexController extends Controller
{


	/*
	 * 电子开盘客户端登录
	 * 2018-3-16
	 * qzb*/

	public function login()
    {
        $info=I('info','','trim');
        $arr=explode("b",$info);
        if(count($arr)!==2){
            $this->error("请输入正确的登录地址！");
        }
        $bid=(int)$arr[1];
        $arr1=explode("p",$arr[0]);
        $pid=(int)$arr1[1];
        if(empty($pid) || empty($bid)){
            $this->error("无效的参数！");
        }
        $pd=M()->table("xk_pzcsvalue")->where('project_id='.$pid.' AND batch_id='.$bid.' AND pzcs_id=1 AND cs_value=-1')->find();
        if($pd){
            $this->error("错误的项目类型！");
        }
        session_start();
        session("pid",$pid);
        session("bid",$bid);
        $this->display();
    }

    /**
     * 电子开盘 短信发送页面
     * 2018-3-16
     * qzb
     */
    public function send_sms_code() {
        if (!IS_AJAX) {
            $this->error('请求错误，请确认后重试');
        }
        $phone = I("phone", 0,"trim");
        $pid = session("pid");
        $bid = session("bid");
        if (empty($phone)) {
            $this->error('请填写手机号码');
        }
        if (empty($phone) || strlen($phone) != 11) {
            $this->error('请填写正确的手机号码');
        }
        $jmphone=rsa_encode($phone,getChoosekey());//加密
        $where = ['project_id' => $pid, 'batch_id' => $bid, 'customer_phone' => $jmphone];
        $chooseinfo = D('Common/choose')->field('customer_name,id,status')->where($where)->find();
        if (!$chooseinfo) {
            $this->error('你还未参与此项目');
        }
        if ($chooseinfo['status'] < 1) {
            $this->error('账号未启用，请联系管理员！');
        }
        $code = sprintf("%6s", rand(100000, 999999));
        //阿里短信服务
        if(!empty(cookie("order_house_code"))){
            $this->error('5分钟内不能重复获取！');
        }
            cookie("order_house_code", $code,300);
            cookie('phone', $jmphone);
            cookie("realName", $chooseinfo['customer_name']);
            cookie("chooseuid", $chooseinfo['id']);
            $this->success($code);
//        $sms = new Alisms();
//        $status1 = $sms->send_verify($phone, $code);
//        if ($status1) {
//            cookie("order_house_code", $code,300);
//            cookie('phone', $jmphone);
//            cookie("realName", $realName);
//            cookie("chooseuid", $chooseinfo['id']);
//            $this->success('验证码发送中，请稍等...');
//        } else {
//            $this->error($sms->error);
//        }
    }

    /*
     * 验证账号
     * 2018-3-16
     * qzb*/
    public function check(){
        if (!IS_AJAX) {
            $this->error('请求错误，请确认后重试！');
        }
        $phone = I('post.phone', 0);
        $code = I('post.code', 0);
        $pid = session("pid");
        $bid = session("bid");
        if (empty($phone)) {
            $this->error('请填写手机号码');
        }
        if (strlen($phone) != 11) {
            $this->error('请填写正确的手机号码');
        }
        $jmphone=rsa_encode($phone,getChoosekey());//加密
        if (cookie('phone') != $jmphone || empty(cookie('order_house_code'))) {
            $this->error('请先获取验证码');
        }
        if (empty($code)) {
            $this->error('请填写验证码');
        }
        if ($code != cookie('order_house_code') && cookie('phone') == $jmphone) {
            $this->error('请填写正确的验证码');
        }
        session("phone", cookie('phone'));
        session("realName", cookie("realName"));
        session("dz_uid", cookie("chooseuid"));
        cookie('order_house_code', NULL);
        $this->success("验证成功",__CONTROLLER__."/index");
    }

    public function is_login(){
        $uid=session("dz_uid");
        if(empty($uid)){
            $this->display(":Index/error");
            exit;
        }
    }
    /*
     * 获取收藏房源的数量
     *
     * 2018-3-19
     * qzb*/
    public function getSc(){
        $uid=session("dz_uid");
        $count=M()->table("xk_cst2rooms")->where('cst_id='.$uid)->count();
        return $count;
    }
    /**
	 * 电子开盘客户手机端首页
	 *
	 * @create 2018-3-16
	 * @author qzb
	 */
    public function index() 
	{
	    $this->is_login();

        $Project = D('Common/Project');
        $pid = session("pid");
        $bid = session("bid");
        //项目
        $uid=session("dz_uid");
        $isws=I("isws",0,"intval");
        $this->assign('isws', $isws);
        $search_info = I('info', '', 'trim');
        $this->assign('pid', $pid);
        $this->assign('bid', $bid);
        $projinfo=M()->table("xk_kppc k")->field("k.*,p.name pname")->join("xk_project p ON p.id=k.proj_id")->where("k.proj_id=".$pid." AND k.id=".$bid)->find();
//        echo $pid."-".$bid;exit;
        
        //归类
        $Roomview = D('Common/Roomview');
        $where['proj_id'] = $pid;
        $where['pc_id'] = $bid;
        if(!empty($isws) && $isws>0)
        {
            $where['is_xf']=0;
        }
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
        $where['proj_id'] = $pid;
        $where['bld_id'] = $search_build_id;
        $where['unit'] = $search_unit_id;
        $where['pc_id'] = $bid;
        if(!empty($isws) && $isws>0)
        {
            $where['is_xf']=0;
        }
        $group_room_floor = $Roomview->getRoomListGroupBy('floor', 'floor DESC', 'cast(floor as SIGNED) DESC', $where);
        $this->assign('floors', $group_room_floor);

        //设置当前搜索
        $search = array(
            'pid' => $pid,
            'search_build_id' 	=> $search_build_id,
            'search_unit_id' 	=> $search_unit_id,
        );
        $this->assign($search);

        //条件
        $search_info = array(
            'p' => $pid,
            'b' => $search_build_id,
            'u' => $search_unit_id,
        );
        $this->assign('search_info', $search_info);

        //获取项目
        $project_info = $Project->getProjectById($pid);
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
        $where['proj_id'] = $pid;
        $where['bld_id'] = $search_build_id;
        $where['unit'] = $search_unit_id;
        if(!empty($isws) && $isws>0)
        {
            $where['is_xf']=0;
        }


        $room_list = D("Common/Room")->getRoomListChoose($where, 'floor DESC, no ASC');

        $new_room_list = array();
        foreach ($room_list as $room_list_key => $room_list_value) {
            $new_room_list[$room_list_value['floor']][] = $room_list_value;
        }
        $b_name=M()->table("xk_build")->field("buildname")->where("id=$search_build_id")->find();
        $this->assign('rooms', $new_room_list);
        $this->assign("b_name",$b_name);
        $this->assign("projinfo",$projinfo);
        $this->assign("cou",$this->getSc());
        $this->display();
    }


    /**
     * 电子开盘房间详情
     *
     * @create 2018-3-19
     * @author qzb
     */
    public function room_detail()
    {
        $this->is_login();
        //权限查询
        //先查询权限情况
        $uid=session("dz_uid");
        $id = I('id', '', 'intval');
        if (empty($id) || $id == 0) {
            $this->error("ID不能为空，请访问其他房间！", U("user/index/index"));
        }

        $room = D("Common/Roomview")->getOneById($id);//
        if (empty($room)) {
            $this->error("房间信息不存在，请访问其他房间！", U("user/index/index"));
        }
        $this->assign('room', $room);
        $this->assign('room_id', $id);
        //楼栋
        $build = D("Common/Build")->getBuildById($room['bld_id']);
        $this->assign('build', $build);
        //房间属性
        $room_attribute = D("Common/Roomattribute")->getAttributeListByRoomId($id);
        $this->assign('room_attribute', $room_attribute);
        //户型信息
        $hxwhere = [
            'fields' => '*'
            , 'where' => [
                'project_id' => $room['proj_id']
                , 'batch_id' => $room['pc_id']
                , 'hx' => $room['hx']
                , '2=2'
            ]
        ];
        $hxinfo = D('hxset')->find($hxwhere);
        $this->assign('hxinfo', $hxinfo);
        //热力指数
        $hot_num = $this -> roomrlzs($room_attribute,$room['proj_id']);
        $this->assign('hot_num', $hot_num);
        //第一意向
        $first_count=M()->table('xk_cst2rooms cr')->where("cr.room_id=$id and px=1")->group("cr.room_id")->count();
        $this->assign('first_count', $first_count);
        //是否收藏
        $crid=M()->table("xk_cst2rooms")->field("id")->where('cst_id='.$uid.' AND room_id='.$id)->find();
        $this->assign("crid",$crid);
        $this->assign("cou",$this->getSc());
        $this->display();
    }
    //计算房间热力指数得分(5为满分)
    public function roomrlzs($room_attribute,$project_id)
    {
        $Model = new \Think\Model();
        $zgs=$Model->query("select sum(djcount)/count(1) as zdj,sum(sscount)/count(1) as zss,sum(sccount)/count(1) as zsc from xk_roomattribute a left join xk_roomlist b on a.room_id=b.id where b.proj_id='".$project_id ."' and b.is_dq=1 and 66=66");
        $djcount=$room_attribute['djcount'];
        $sscount=$room_attribute['sscount'];
        $sccount=$room_attribute['sccount'];

        $zdjcount=$zgs[0]['zdj'];
        $zsscount=$zgs[0]['zss'];
        $zsccount=$zgs[0]['zsc'];
        if (empty($zdjcount)||$zdjcount==0)
        {
            $djcount=1;
            $zdjcount=1;
        }
        if (empty($zsscount)||$zsscount==0)
        {
            $sscount=1;
            $zsscount=1;
        }
        if (empty($zsccount)||$zsccount==0)
        {
            $sccount=1;
            $zsccount=1;
        }
        $num=round(($djcount/$zdjcount*0.2 + $sscount/$zsscount*0.3 + $sccount/$zsccount*0.5) * 5,0);
        if ($num>5)
            $num=5;
        return $num;
    }

    /*
     * 添加备选
     * 2018-3-19
     * qzb
     * */
    public function add_bx(){
        $id=I("id",0,"intval");
        $uid=session("dz_uid");
        $pid = session("pid");
       $px=M()->table("xk_cst2rooms")->field("max(px) px")->where("cst_id=$uid AND proj_id=$pid")->find();
       $data['cst_id']=$uid;
       $data['proj_id']=$pid;
       $data['sctime']=time();
       $data['room_id']=$id;
       $data['px']=(int)$px['px']+1;
       $pd=M()->table("xk_cst2rooms")->add($data);
       if($pd){
            $this->success("添加成功");
       }else{
           $this->success("添加失败，请刷新后重试！");
       }

    }
    /*
     * 删除备选
     * 2018-3-19
     * qzb
     * */
    public function delete_bx(){
        $id=I("id",0,"intval");
        $uid=session("dz_uid");
        $px=M()->table("xk_cst2rooms")->field("px")->where('cst_id='.$uid.' AND room_id='.$id)->find();
        $pd=M()->table("xk_cst2rooms")->where('cst_id='.$uid.' AND room_id='.$id)->delete();
        if($pd){
            M()->execute("update xk_cst2rooms set px=px-1 WHERE cst_id=$uid AND px>{$px['px']}");
            $this->success("取消成功");
        }else{
            $this->success("取消失败，请刷新后重试！");
        }
    }

    /**
     * 电子开盘搜索页面-客户端
     *
     * @create 2018-3
     * @author qzb
     */
    public function search()
    {
        $this->is_login();
        $uid=session("dz_uid");
        $pid = session("pid");
        $bid = session("bid");
        $where['proj_id'] = $pid;
        $where['pc_id'] = $bid;

        //楼栋
        $Buildview = D('Common/Buildview');
        $build_list = $Buildview->getBuildList($where, 'buildname ASC');
        $this->assign('build_list', $build_list);
        //户型
        $Roomview = D('Common/Roomview');
        $hx_list = $Roomview->getRoomListGroupBy('hx, proj_id', 'hx', 'hx ASC', $where);
        $this->assign('hx_list', $hx_list);
        $this->assign("cou",$this->getSc());
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
     * 电子开盘房间比对-客户端
     *
     * @create 2018-3-2
     * @author qzb
     */
    public function dz_room()
    {
        $this->is_login();
        $ids = I('ids', '', 'trim');
        if (empty($ids)) {
            $this->error("房间选择不能为空，请重试！", U("saler/project/index"));
        }
        $ids = explode(',', $ids);
        $where['id'] = array('in', $ids);

        //获取房间列表
        $rooms = D("Common/Room")->getRoomList($where, 'no ASC');
        if (empty($rooms)) {
            $this->error("房间信息不存在，请重试！", U("saler/project/index"));
        }
        $this->assign('rooms', $rooms);
        //房间个数
        $rooms_count = count($rooms);
        $this->assign('rooms_count', $rooms_count);

        //获取房间属性列表
        $where1['room_id'] = array('in', $ids);
        $room_old_attributes = D("Common/Roomattribute")->getAttributeList($where1, 'room_id ASC');
        $room_attributes = array();
        foreach ($room_old_attributes as $room_attributes_key => $room_attribute) {
            $room_attributes[$room_attribute['room_id']] = $room_attribute;
            $first_count=M()->table('xk_cst2rooms cr')->where("cr.room_id=". $room_attribute['room_id'] ." and px=1")->group("cr.room_id")->count();
            $room_attributes[$room_attribute['room_id']]['first_count'] = $first_count;
        }

        $this->assign('room_attributes', $room_attributes);

        //更改比对数据
        foreach ($ids as $ids_key => $ids_value) {
            D("Common/Roomattribute")->editAttributeCompareByRoomId(1, $ids_value);
        }



        //楼栋
        $old_build_list = D('Common/Build')->getBuildList(array(), 'buildname, id DESC');

        $build_list = array();
        foreach ($old_build_list as $build_key => $build) {
            $build_list[$build['id']] = $build;
        }
        $this->assign('builds', $build_list);
        $this->assign("cou",$this->getSc());
        $this->display();
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
