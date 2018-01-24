<?php

namespace User\Controller;

use Lookey\Lottery\Rander as Lottery;
use Org\Util\String as Stringer;

/**
 * 活动
 *
 * @create 2017-01-12
 * @author jxw
 */
class loginController extends BaseController {

    /**
     * 间隔时间
     *
     * @create 2017-01-12
     * @author jxw
     */
    //private $interval_time = 60;

    /**
     * 构造方法
     *
      @create 2017-01-13
     * @author jxw
     */
    public function _initialize() {
        parent::_initialize();
        //$this->assign('interval_time', $this->interval_time);
    }

    /**
     * 默认方法
     *
     * @create 2017-01-15
     * @author jxw
     */
    public function index() {
         $type = I("type",'');
         if ($type==''){ $type='speedbuy';}
         $this->assign('logintype', $type);
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
        $type = I("type",'');
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
        $this->success('../'.$type, U('index'));
     }
}
