<?php

namespace Account\Controller;

/**
 * 摇号
 *
 * @create 2018-01-13
 * @author jxw
 */
class YaoHsetController extends BaseController {

    /**
     * 系统构造函数
     *
     * @create 2017-04-17
     * @author jxw
     */
    public function _initialize() {
        parent::_initialize();

        //分类名称
        $this->assign('classify_name', '选房摇号');

        //设置当前方法
        $this->set_current_action('yaoh_set', 'yaoh');
    }

    public function index(){
        //项目ID
        $search_project_id = I('project_id', 0, 'intval');
        $search_batch_id = I('batch_id', 0, 'intval');
        //$search_word = I('word', '', 'trim');
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

        $YaohModel = D('Common/YaoHset');

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
        /*if (!empty($search_word)) {
            $like['name'] = array('like', '%' . $search_word . '%');
            $where['_complex'] = $like;
        }*/

        //总数
        $count = $YaohModel->where($where)->count();

        //分页
        $Page = $this->bootstrapPage($count, 15);
        $page_show = $Page->show();
        $total_pages = $Page->totalPages;

        //取范围
        $limit = $Page->firstRow . ',' . $Page->listRows;

        $list = $YaohModel->getList(
            $where, '*', 'project_id,batch_id desc,status desc,id DESC', $limit
        );
        foreach ($list as $k=>$item )
        {
            $cstcount=D("Choose")->where(" project_id={$item['project_id']} and batch_id={$item['batch_id']} and status=1")->count();
            $list[$k]['cstcount']=$cstcount;
            $yyhcount=D("Choose")->join("inner join xk_yaohresult s on xk_choose.id=s.cstid")->where(" xk_choose.project_id={$item['project_id']} and xk_choose.batch_id={$item['batch_id']} and xk_choose.status=1")->count();
            $list[$k]['yyhcount']=$yyhcount;
            if ($yyhcount==0)
            {
                $list[$k]['status']=0;
            }
            else if ($cstcount==$yyhcount)
            {
                $list[$k]['status']=-1;
            }
            else
            {
                 $list[$k]['status']=1;
            }
        }
        $p = I('p', '1', 'intval');
        $this->assign('p', $p);

        $this->assign('total_pages', $total_pages);
        $this->assign('count', $count);
        $this->assign('page_show', $page_show);

        $this->assign('list', $list);

        $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
        $this->assign('http_type', $http_type);
        $this->set_seo_title("摇号准备");
        $this->display();
    }
    
    public function display_yaoh(){
        //项目ID
        $id = I('id', 0, 'intval');
        if(empty($id))
        {
            $this->error("系统错误，请稍后重试！");
        }
        $yaohset=D("YaoHset")->getOneById("$id");
        
        if(empty($yaohset) || $yaohset['is_yx']==0)
        {
            $this->error("系统错误，请稍后重试！");
        }
        
        //用户的项目和项目批次权限
        $user_project_ids = $this->get_user_project_ids();
        $user_batch_ids = $this->get_user_batch_ids();
        if ($yaohset['project_id'] != 0) {
            if (!in_array($yaohset['project_id'], $user_project_ids)) {
                $this->error("你没有权限访问该项目的信息！");
            }
        }
        if ($yaohset['batch_id'] != 0) {
            if (!in_array($yaohset['batch_id'], $user_batch_ids)) {
                $this->error("你没有权限访问该批次的信息！");
            }
        }
       
        //所有有效客户
        //$cstlist=D("ChooseUser")->field('id,customer_name,customer_phone,cardno,cyjno')->where(" project_id={$yaohset['project_id']} and batch_id={$yaohset['batch_id']} and status=1")->select();
        $cstlist=D("ChooseUser")->join(" left join xk_yaohresult s on xk_choose.id=s.cstid")->field('xk_choose.id,xk_choose.customer_name,xk_choose.customer_phone,xk_choose.cardno,xk_choose.cyjno')->where(" xk_choose.project_id={$yaohset['project_id']} and xk_choose.batch_id={$yaohset['batch_id']} and xk_choose.status=1 and s.id is null")->select();
        foreach( $cstlist as $k =>$onecst){
            $cstlist[$k]['customer_phone']=rsa_decode($onecst['customer_phone'],  getChoosekey());
            $cstlist[$k]['cardno']=rsa_decode($onecst['cardno'],  getChoosekey());
        }
        $this->assign('cstlist',json_encode($cstlist));
        
        if(empty($cstlist))
        {
            $this->assign('isend', 1);
        }
        else
        {
            $this->assign('isend', 0);
        }
        
        if (count($cstlist)<$yaohset['mzgs'])
        {
            $yaohset['mzgs']=count($cstlist);
        }
        //控制显示内容
        $tmparray =explode("手机",$yaohset['showcontent']);
        if(count($tmparray)>1)
        {
            $showcontent['hasphone']=1;
        }
        else{
            $showcontent['hasphone']=-1;
        }
        $tmparray =explode("编号",$yaohset['showcontent']);
        if(count($tmparray)>1)
        {
            $showcontent['hascyjno']=1;
        }
        else{
            $showcontent['hascyjno']=-1;
        }
        $tmparray =explode("身份证",$yaohset['showcontent']);
        if(count($tmparray)>1)
        {
            $showcontent['hascard']=1;
        }
        else{
            $showcontent['hascard']=-1;
        }
        $this->assign('showcontent', $showcontent);
                
        //项目
        $Project = D('Common/Project');
        //获取当前项目
        $project_info = $Project->getProjectById($yaohset['project_id']);
        $this->assign('project', $project_info);
        
         //获取当前批次
        $kppc_info = D("Kppc")->find($yaohset['batch_id']);
        $this->assign('Kppc', $kppc_info);
        
        $this->assign('yaohset', $yaohset);
        
        //$http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
        //$this->assign('http_type', $http_type);
        $this->set_seo_title("选房摇号");
        $this->display("yaoh");
    }
    
     public function history_yaoh(){
        //项目ID
        $id = I('id', 0, 'intval');
        $zcid = I('zcid', 0, 'intval');
        if(empty($id) || empty($zcid))
        {
            $this->error("系统错误，请稍后重试！");
        }
        $yaohset=D("YaoHset")->getOneById("$id");
        
        if(empty($yaohset))
        {
            $this->error("系统错误，请稍后重试！");
        }
        //用户的项目和项目批次权限
        $user_project_ids = $this->get_user_project_ids();
        $user_batch_ids = $this->get_user_batch_ids();
        if ($yaohset['project_id'] != 0) {
            if (!in_array($yaohset['project_id'], $user_project_ids)) {
                $this->error("你没有权限访问该项目的信息！");
            }
        }
        if ($yaohset['batch_id'] != 0) {
            if (!in_array($yaohset['batch_id'], $user_batch_ids)) {
                $this->error("你没有权限访问该批次的信息！");
            }
        }
        $yaohresult = D('Common/YaoHresult');
        $where['group']=$zcid;
        $where['yaohset_id']=$id;
        //摇号结果数据
         $cstlist = $yaohresult->getList(
            $where, '*', 'id asc'
        );
        if(empty($cstlist))
        {
            $this->assign('isend', 1);
        }
        else
        {
            $this->assign('isend', 0);
        }
        
        $this->assign('cstlist',$cstlist);

        //控制显示内容
        $tmparray =explode("手机",$yaohset['showcontent']);
        if(count($tmparray)>1)
        {
            $showcontent['hasphone']=1;
        }
        else{
            $showcontent['hasphone']=-1;
        }
        $tmparray =explode("编号",$yaohset['showcontent']);
        if(count($tmparray)>1)
        {
            $showcontent['hascyjno']=1;
        }
        else{
            $showcontent['hascyjno']=-1;
        }
        $tmparray =explode("身份证",$yaohset['showcontent']);
        if(count($tmparray)>1)
        {
            $showcontent['hascard']=1;
        }
        else{
            $showcontent['hascard']=-1;
        }
        $this->assign('showcontent', $showcontent);
                
        //项目
        $Project = D('Common/Project');
        //获取当前项目
        $project_info = $Project->getProjectById($yaohset['project_id']);
        $this->assign('project', $project_info);
        
         //获取当前批次
        $kppc_info = D("Kppc")->find($yaohset['batch_id']);
        $this->assign('Kppc', $kppc_info);
        
        $this->assign('yaohset', $yaohset);
        $this->assign('zcid', $zcid);
        
        //$http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
        //$this->assign('http_type', $http_type);
        $this->set_seo_title("查看摇号历史记录");
        $this->display("history_yaoh");
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
        
        $item["allgz"]=['姓名+VIP编号','姓名+手机号','姓名+身份证','姓名+VIP编号+身份证'];
        $this->assign('item', $item);
        
        $project_json = urldecode(json_encode($project_new_list));
        $this->assign('project_json', $project_json);

        $this->set_seo_title('摇号准备');

        $this->display('add');
    }
    
    public function add()
    {
        if (!IS_AJAX){
            $this->error("提交错误，请稍后重试！");
        }
       
        $obj = array();

        $notEmpty = array('project_id'=>'没有选择项目','batch_id'=>'没有选择批次','name'=>'没有填写摇号名称','mzgs'=>'没有填写每组抽取人数','showcontent'=>'没有选择大屏显示内容');
        foreach (array_keys($notEmpty) as $item) {
            $value = I("post.{$item}");

            if (empty($value)){
                $this->error($notEmpty[$item]);
            }

            $obj[$item] = $value;
        }

        $fields = array('remark');
        foreach ($fields as $item) {
            $obj[$item] = I("post.{$item}");
        }

        $project = D("project")->field('*')->where(array('id'=>$obj['project_id']))->find();

        if (empty($project['id'])){
            $this->error('提交错误，请稍后重试！');
        }
        $obj['is_yx']=I("is_yx","","trim")?1:0;

        $yaohset = D('YaoHset');
        
        $one=$yaohset->where("project_id={$obj['project_id']} and batch_id={$obj['batch_id']} and is_yx=1" )->find();
        if(!empty($one))
        {
            $this->error('同一批次只能有一个启用的摇号');
        }

        $result = $yaohset->add($obj);

        if ($result){
            $this->success('添加成功');
        }else{
            $this->error('添加失败，请稍后重试。');
        }
    }

    public function display_edit()
    {
        $id = I('id', 0, 'intval');
        if ($id == 0) {
            $this->error("摇号设置不存在，请确认后重试！");
        }
        $this->assign('id', $id);

        
        $yaohset = D('YaoHset');

        $item = $yaohset->getOneById($id);
        if (empty($item)) {
            $this->error("活动信息不存在，请确认后重试！");
        }
        $item["allgz"]=['姓名+VIP编号','姓名+手机号','姓名+身份证','姓名+VIP编号+身份证'];
        $this->assign('item', $item);
        
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
        $batch_id = $item['batch_id'];
        $batch_where['id'] = $batch_id;
        $batch = D('Batch')->getOne($batch_where, '*');
        $this->assign('batch', $batch);
        $this->set_seo_title('摇号准备');

        $this->display('edit');
    }
    
    public function edit()
    {
        if (!IS_AJAX){
            $this->error("提交错误，请稍后重试！");
        }
        $obj = array();
       
        $notEmpty = array('id'=>'应用错误','project_id'=>'没有选择项目','batch_id'=>'没有选择批次','mzgs'=>'没有填写每组抽取人数','showcontent'=>'没有选择大屏显示内容');
        foreach (array_keys($notEmpty) as $item) {
            $value = I("post.{$item}");

            if (empty($value)){
                $this->error($notEmpty[$item]);
            }

            $obj[$item] = $value;
        }

        $fields = array('remark');
        foreach ($fields as $item) {
            $obj[$item] = I("post.{$item}");
        }
        $project = D("project")->field('*')->where(array('id'=>$obj['project_id']))->find();

        if (empty($project['id'])){
            $this->error('提交错误，请稍后重试！');
        }
        
       $obj['is_yx']=I("is_yx","","trim")?1:0;
        
        $id = $obj['id'];
        $options = array('where'=>array('id'=>$id));
        unset($obj['id']);

        $yaohset = D('YaoHset');
        $yaohset->save($obj,$options);
        $this->success('修改成功');
        
    }

    public function remove()
    {
        if (!IS_AJAX){
            $this->error("提交错误，请稍后重试！");
        }

        $ids = I("post.ids",0,'intval');

        if(empty($ids))
            $this->error("记录不存在，请确认后重试！");

        $yaohset = D('YaoHset');
        $option = [
            'where'=>['id'=>['in',$ids]]
        ];
        $yaohset->delete($option);

        $this->success('删除成功');

    }
    
    public function getYaohcst(){
        if (!IS_AJAX){
            $this->error("提交错误，请稍后重试！");
        }
        $id = I("id",0,'intval');
        if(empty($id))
        {
            $this->error("系统错误，请稍后重试！");
        }
        $yaohset=D("YaoHset")->getOneById("$id");
        
        if(empty($yaohset))
        {
            $this->error("系统错误，请稍后重试！");
        }
        $list=D("ChooseUser")->join(" left join xk_yaohresult s on xk_choose.id=s.cstid")->field('xk_choose.id,xk_choose.customer_name,xk_choose.customer_phone,xk_choose.cardno,xk_choose.cyjno')->where(" xk_choose.project_id={$yaohset['project_id']} and xk_choose.batch_id={$yaohset['batch_id']} and xk_choose.status=1 and s.id is null")->select();
        if(empty($list))
        {
            $this->error("系统错误，请稍后重试！");
        }
        $count = count($list);
        $rand_list=range(0, $count-1);
        $rcount=$yaohset['mzgs'];
        $status=1;
        if ($rcount>$count)
        {
            $rcount=$count;
            $status=-1;
        }
        $rand_list = array_rand($rand_list, $rcount);
        $user=D(User)->find(session('ACCOUNT_ID'));
        foreach( $rand_list as $k =>$onecst){
            $cstlist[$k]=$list[$onecst];
            $cstlist[$k]['customer_phone']=rsa_decode($cstlist[$k]['customer_phone'],  getChoosekey());
            $cstlist[$k]['cardno']=rsa_decode($cstlist[$k]['cardno'],  getChoosekey());
            
            $data[$k]['cstid']=$list[$onecst]['id'];
            $data[$k]['group']=$yaohset['dqmaxgroup']+1;
            $data[$k]['no']=$yaohset['dqmaxno']+$k+1;
            $data[$k]['pxingroup']=$k+1;
            $data[$k]['yaohset_id']=$yaohset['id']; 
            $data[$k]['project_id']=$yaohset['project_id'];
            $data[$k]['batch_id']=$yaohset['batch_id'];
            $data[$k]['createdtime']=time();
            $data[$k]['createdby']=$user['name'];
            $data[$k]['createdbyid']=$user['id'];
        }
        $data1['dqmaxgroup']=$yaohset['dqmaxgroup']+1;
        $data1['dqmaxno']=$yaohset['dqmaxno']+$rcount;
        $data1['status']=$status;
        $YaoHresult=D("YaoHresult");
        try {
            $YaoHresult->startTrans();
            $YaoHresult->addAll($data);
            D("YaoHset")->editOneById($yaohset['id'],$data1);
            $YaoHresult->commit();
            $this->success(["成功",$cstlist]);
        }catch (\Exception $e) {
            $YaoHresult->rollback();
            $this->error("系统错误，请稍后重试！");
        }
        //$this->success(["成功",$cstlist]);
    }

}
