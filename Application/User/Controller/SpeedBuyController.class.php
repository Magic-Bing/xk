<?php

namespace User\Controller;

use Lookey\Lottery\Rander as Lottery;
use Org\Util\String as Stringer;

/**
 * 活动
 *
 * @create 2017-02-08
 * @author jxw
 */
class SpeedBuyController extends BaseController {

    /**
     * 间隔时间
     *
     * @create 2017-02-08
     * @author jxw
     */
    //private $interval_time = 60;

    /**
     * 构造方法
     *
     * @create 2017-01-13
     * @author jxw
     */
    public function _initialize() {
        parent::_initialize();
        //$this->assign('interval_time', $this->interval_time);
        //当前方法
	$this->assign('action_name', strtolower(ACTION_NAME));
    }

    /**
     * 默认方法
     *
     * @create 2017-02-08
     * @author jxw
     */
    public function index() {
        $choose_id=cookie('choose_id');
        if (empty($choose_id) or $choose_id<=0 )
        {
            redirect( "../user/login/index?type=speedbuy");
        }
        //$choose_id=22;
        $is_havehd=-1;
        $project_id = D("Weixin", "Logic")->getProjectId();
        if (empty($project_id) || $project_id == 0) {
                $this->error("访问错误，请访问其他页面！");
        }
        $this->assign('project_id', $project_id);
        //获取批次ID
        $batch_where['proj_id'] = $project_id;
        $batch_where['is_dq'] = 1;
        $batch = D("Batch")->getOne($batch_where);
	$batch_id = $batch['id'];
        
        $activity = D('Common/Choose_activity');
        //最近竞价活动
        $where['project_id'] = $project_id;
        $where['batch_id'] = $batch_id;
        $where['status'] = 1;
        $where[] = 'start_time <= ' . time();
        $where[] = 'end_time >= ' . time();
        $where[] = '999=999';
        $dqhd = $activity->getOne($where, '*,-1 as yjks,end_time-unix_timestamp(now()) as djs ', 'id ASC');
        if (empty($dqhd))
        {
            //获取下轮活动
             $where1['project_id'] = $project_id;
             $where1['batch_id'] = $batch_id;
             $where1['status'] = 1;
             $where1[] = 'start_time >= ' . time();
             $where1[] = 'end_time >= ' . time();
             $where1[] = '777=777';
             $nexthd = $activity->getOne($where1, '*,start_time-unix_timestamp(now()) as yjks,-1 as djs ', 'end_time desc,id ASC');
             if (!empty($nexthd)){
                 $is_havehd=0;
                 $dqhd=$nexthd;
             }  
        }
        else
        {
            $is_havehd=1;
        }
        $Model = new \Think\Model(); 
        if (!empty($dqhd)&&$dqhd['id']>0)
        {
            $choose_log=$Model->query("SELECT a.id,a.money as zmoney,a.money-b.money as kymoney,a.customer_phone,b.* FROM  xk_choose a left join (select * from xk_choose_log where activity_id = " . $dqhd['id'] ." and choose_id = " . $choose_id ." ) b on a.id=b.choose_id where a.id = " . $choose_id ." order by a.id asc limit 1" );
        }
        else
        {
            $choose_log=$Model->query("SELECT a.id,a.money as zmoney,a.money as kymoney FROM  xk_choose a where a.id=".$choose_id." order by a.id asc limit 1" );
        }
        $this->assign('is_havehd', $is_havehd);
        $this->assign('dqhd', $dqhd);
        $this->assign('choose_log', $choose_log[0]);
        $this->set_seo_title('极速秒购');
        $this->display();
    }

    /**
     * 点击竞价
     *
     * @create 2017-02-08
     * @author jxw
     */
    public function click() {
        if (!IS_AJAX) {
            $this->error('提交失败，请重试！', U('index'));
        }
        $id = I("id", 0, 'intval');
        $choose_id = I("choose_id", 0, 'intval');
        $amount = I("amount", 0);
        $kyamount=0;
        if ($id == 0) {
            $this->error('ID不能为空，请确认后重试！', U('index'));
        }
        if ($amount == 0) {
            $this->error('竞价金额不能为0', U('index'));
        }
        $Model = new \Think\Model(); 
        $auction=$Model->query("SELECT a.* FROM  xk_choose_activity a  where a.id = " . $id  );
        if (empty($auction)){
             $this->error('ID错误，请稍后重试！', U('index'));
        }
        else
        {
            if(time()> $auction[0]['end_time']){
               $this->error('本轮竞价已结束', U('index'));
            }  
            if ($choose_id<>0)
            {
                $choose=$Model->query("SELECT a.* FROM  xk_choose a  where id = '" . $choose_id ."'" );
                $kyamount=$choose[0]['money'];
                if($amount>$kyamount){
                    $this->error('当前出价不能大于总金额', U('index'));
                }
                
                $choose_log=$Model->query("SELECT a.* FROM  xk_choose_log a  where a.activity_id = " . $id ." and choose_id = '" . $choose_id ."'" );
                if(empty($choose_log))
                {
                    $data['choose_id']=$choose_id;
                    $data['activity_id']=$id;
                    $data['money']=$amount;
                    $data['add_time']=time();
                    $data['add_ip']=get_client_ip(0, true);
                    $choose_log1 = M("choose_log");  
                    $choose_log1->add($data);
                }
                else
                {
                    $data['money']=$amount;
                    $data['add_time']=time();
                    $data['add_ip']=get_client_ip(0, true);
                    $choose_log1 = M("choose_log"); 
                    $choose_log1->where('id='.$choose_log[0]['id'])->save($data);
                }
            }
        }
        
        $this->success('本次竞价成功，请等待结果！', U('index'));
    }
    
    
    /**
     * 获取竞拍结果
     *
     * @create 2017-02-05
     * @author jxw
     */
    public function result() {
       //$id = I("aid", 0, 'intval');
       //$choose_id = I("cid", 0, 'intval');
        $id=20;
        $choose_id=22;
        $pwcg['is_pwcg']=0;
        if ($id == 0) {
            $this->error('ID不能为空，请稍后重试！', U('index'));
        }
        $activity = D('Common/Choose_activity');
        $where['id'] =  $id;
        $dqhd = $activity->getOne($where, '*', 'id ASC');
        if (empty($dqhd)){
             $this->error('ID错误，请稍后重试！', U('index'));
        }
        else
        {
            $Model = new \Think\Model(); 
            $choose_log=$Model->query("SELECT a.id,a.money as zmoney,a.money-b.money as kymoney,a.customer_phone,b.* FROM  xk_choose a left join (select * from xk_choose_log where activity_id = " . $dqhd['id'] ." and choose_id = " . $choose_id ." ) b on a.id=b.choose_id where a.id = " . $choose_id ." order by a.id asc limit 1" ); 
            if ($choose_log[0]['is_pwcg']==1)
            {
                $pwcg['is_pwcg']=1;
                $pwcg['pxh']=$choose_log[0]['pxh'];
            }
            else
            {
                $loglist=$Model->query("SELECT * FROM  xk_choose_log where activity_id = " . $id ." order by money desc,add_time asc, id asc limit 10" );
                $i=0;
                foreach ($loglist as $onelog ) {
                    $i++;
                    if ($onelog['choose_id']== $choose_log[0]['choose_id'])
                    {
                        $data['is_pwcg']=1;
                        $data['pxh']=$i;
                        $choose_log1 = M("choose_log"); 
                        $choose_log1->where('id='.$choose_log[0]['id'])->save($data);
                        
                        $pwcg['is_pwcg']=1;
                        $pwcg['pxh']=$i;
                        break;
                    }
		}
            }
        }
        $this->assign('pwcg', $pwcg);
        $this->assign('dqhd', $dqhd);
        $this->assign('choose_log', $choose_log[0]);
        $this->set_seo_title('竞拍结果');
        $this->display();
    }
    
     public function login() {
        /*$choose_id=cookie('choose_id');
        if (!empty($choose_id) and $choose_id>0 )
        {
            redirect( "../auction");
        }*/
         $this->set_seo_title('快速登录');
         $this->display();
     }

     /**
     * 获取密码
     *
     * @create 2017-02-05
     * @author jxw
     */
     public function getpwd() {
        if (!IS_AJAX) {
            $this->error('提交失败，请重试！', U('index'));
        }
        $phone = I("phone",'');
        if ($phone == '') {
            $this->error('请输入手机号码', U('index'));
        }
        $project_id = D("Weixin", "Logic")->getProjectId();
        if (empty($project_id) || $project_id == 0) {
                $this->error("访问错误，请访问其他页面！");
        }
        //获取批次ID
        $batch_where['proj_id'] = $project_id;
        $batch_where['is_dq'] = 1;
        $batch = D("Batch")->getOne($batch_where);
	$batch_id = $batch['id'];
        $Model = new \Think\Model(); 
        $choose=$Model->query("SELECT a.* FROM  xk_choose a  where a.project_id = " . $project_id ." and a.batch_id=" . $batch_id ." and customer_phone='" .$phone."'");
        if(empty($choose) or $choose[0]['id']<=0)
        {
            $this->error("手机号码不存在，请确认！");
        }
        else
        {
            $choose_user=$Model->query("SELECT a.* FROM  xk_choose_user a  where a.choose_id = " .$choose[0]['id']);
        }
        
        if(empty($choose_user) or $choose_user[0]['id']<=0 or $choose_user[0]['password']=='')
        {
            $makecode =  mt_rand(100000,999999);
            if (empty($choose_user) or $choose_user[0]['id'] <= 0)
            {
                $data['project_id']=$project_id;
                $data['batch_id']=$batch_id;
                $data['choose_id']=$choose[0]['id'];
                $data['customer_phone']=$phone;
                $data['password']=$makecode;
                $data['add_time']=time();
                $data['add_ip']=get_client_ip(0, true);
                $choose_user1 = M("choose_user");  
                $choose_user1->add($data);
            }
            else
            {
                $data['password']= $makecode;
                $choose_user1 = M("choose_user"); 
                $choose_user1->where('id='.$choose_user[0]['id'])->save($data);
            }
        }
        else
        {
            $makecode=$choose_user[0]['password'];
        }
        //采用阿里大鱼短信接口生成密码同时发送手机短信
        //define('hopedir', dirname(__FILE__));  
        require "taobaoauto/TopSdk.php";
        require "taobaoauto/top/TopClient.php";
        $c = new \TopClient();

        $c->appkey = '23313605';
        $c->secretKey = '7c7e8044e251fa21fe3503c610bc6b1e';
        $req = new \AlibabaAliqinFcSmsNumSendRequest();
        $req->setExtend("123456");
        $req->setSmsType("normal");
        $req->setSmsFreeSignName("链商科技");
        $req->setSmsParam("{\"password\":\"$makecode\"}");
        $req->setRecNum($phone);
        $req->setSmsTemplateCode("SMS_45440004");
        $resp = $c->execute($req);
	//$arr = $this->objectArray($resp);    
        $this->success('获取密码成功', U('index'));
     }
     
     /**
     * 登录
     *
     * @create 2017-02-05
     * @author jxw
     */
     public function logining() {
        if (!IS_AJAX) {
            $this->error('提交失败，请重试！', U('index'));
        }
        $phone = I("phone",'');
        $pwd = I("pwd",'');
        if ($phone == '') {
            $this->error('请输入手机号码', U('index'));
        }
        if ($pwd == '') {
            $this->error('密码不能为空', U('index'));
        }
        $project_id = D("Weixin", "Logic")->getProjectId();
        if (empty($project_id) || $project_id == 0) {
                $this->error("访问错误，请访问其他页面！");
        }
        //获取批次ID
        $batch_where['proj_id'] = $project_id;
        $batch_where['is_dq'] = 1;
        $batch = D("Batch")->getOne($batch_where);
	$batch_id = $batch['id'];
        $Model = new \Think\Model(); 
        $choose_user=$Model->query("SELECT a.* FROM  xk_choose_user a  where a.project_id = " . $project_id ." and a.batch_id=" . $batch_id ." and customer_phone='" .$phone."' and password='".$pwd."' and status=1");
        if(empty($choose_user) or $choose_user[0]['id']<=0)
        {
            $this->error("用户名或密码错误，请重新登录！");
        }
        else
        {
            $data['is_login']= 1;
            $data['login_time']=time();
            $data['login_ip']=get_client_ip(0, true);
            $choose_user1 = M("choose_user"); 
            $choose_user1->where('id='.$choose_user[0]['id'])->save($data);
        }
        cookie('choose_id',$choose_user[0]['choose_id'] ,43200);
        $this->success('登录成功', U('index'));
     }
}
