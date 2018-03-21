<?php

namespace Account\Controller;

/**
 * 微信认购记录
 *
 * @create 2017-04-17
 * @author jxw
 */
class WeixBuylogController extends BaseController {

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
        $this->set_current_action('weixbuy_log', 'weixbuy');
    }

    /**
     * 数据导出
     *
     * @create 2017-09-30
     * @author qzb
     */
    public function check_jl(){
        $search_project_id = I('project_id', '0', 'intval');
        $search_batch_id = I('batch_id', '0', 'intval');
        $search_word = I('word', '', 'trim');

        //用户的项目和项目批次
        $user_project_ids = $this->get_user_project_ids();
        $user_batch_ids = $this->get_user_batch_ids();

        $orderHouseOrderModel = D('Common/OrderHouseOrder');

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
            $like['belong_real_name'] = array('like', '%' . $search_word . '%');
            $like['room_room'] = array('like', '%' . $search_word . '%');
            $like['belong_phone'] = array('like', '%' . $search_word . '%');
            $like['code'] = array('like', '%' . $search_word . '%');
            $like['_logic'] = 'or';
            $where['_complex'] = $like;
        }

        //总数
        $choose_activity_count = $orderHouseOrderModel->where($where)->count();

        //分页
        $Page = $this->bootstrapPage($choose_activity_count, 15);
        //取范围
        //$limit = $Page->firstRow . ',' . $Page->listRows;

        $choose_activity_list = $orderHouseOrderModel->getList(
            $where, "*,FROM_UNIXTIME( log_time,'%Y-%m-%d  %H:%i:%s') as log_time1", 'log_time asc, id DESC'
        );
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Writer.Excel5");
        import("Org.Util.PHPExcel.IOFactory.php");

        //创建PHPExcel对象，注意，不能少了\
        $objPHPExcel = new \PHPExcel();
        $filename = '微信认购记录-'.time().".xls";
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(22);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("F")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("G")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("H")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', '序号');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', '项目');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', '批次');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', '房间');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', '姓名');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', '手机');
        $objPHPExcel->getActiveSheet()->setCellValue('G1', '选房码');
        $objPHPExcel->getActiveSheet()->setCellValue('H1', '选房时间');


        for ($k =0; $k < count($choose_activity_list); $k++) {
            $objPHPExcel->getActiveSheet()->setCellValue('A'.($k+2),$k+1);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.($k+2),$choose_activity_list[$k]['project_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.($k+2),$choose_activity_list[$k]['batch_name']);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.($k+2),$choose_activity_list[$k]['build_name']."-".$choose_activity_list[$k]['unit_no']."单元-".$choose_activity_list[$k]['floor_no']."层-".$choose_activity_list[$k]['room_room']);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.($k+2),$choose_activity_list[$k]['belong_real_name']);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.($k+2),$choose_activity_list[$k]['belong_phone'],\PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('G'.($k+2),$choose_activity_list[$k]['code'],\PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.($k+2),$choose_activity_list[$k]['log_time1'],\PHPExcel_Cell_DataType::TYPE_STRING);
        }

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//        $objWriter->save($filename);
// 输出Excel表格到浏览器下载
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=$filename");
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter->save('php://output');
        exit;

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
        $search_status = I('status', 0, 'intval');

        //设置当前搜索
        $search = array(
            'search_project_id' => $search_project_id,
            'search_batch_id' => $search_batch_id,
            'search_word' => $search_word,
            'search_status' => $search_status,
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

        $orderHouseOrderModel = D('Common/OrderHouseOrder');

        //条件
        $where = array();
        if (!empty($search_project_id)) {
            $where['project_id'][] = $search_project_id;
        }else{
            //项目条件
            if (!empty($user_project_ids)) {
                $where['project_id'][] = array('in', $user_project_ids);
            } else {
                $where['project_id'][] = '-99999';
            }
        }


        if (!empty($search_batch_id)) {
            $where['batch_id'][] = $search_batch_id;
        }else {
            //批次条件
            if (!empty($user_batch_ids)) {
                $where['batch_id'][] = array('in', $user_batch_ids);
            } else {
                $where['batch_id'][] = '-99999';
            }
        }
        //状态条件
        if (!empty($search_status)) {
            if($search_status!==2){
                $where['is_checked'][] = $search_status;
            }
        }else {
            $where['is_checked'][] = 0;
        }
        //搜索查询
        if (!empty($search_word)) {
            $like['belong_real_name'] = array('like', '%' . $search_word . '%');
            $like['room_room'] = array('like', '%' . $search_word . '%');
            $like['belong_phone'] = array('like', '%' . $search_word . '%');
            $like['code'] = array('like', '%' . $search_word . '%');
            $like['_logic'] = 'or';
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
        $p = I('p', '1', 'intval');
        $this->assign('p', $p);
        $this->assign('total_pages', $total_pages);
        $this->assign('count', $choose_activity_count);
        $this->assign('page_show', $page_show);
        $this->assign('choose_activity_list', $choose_activity_list);

        $this->set_seo_title("微信认购记录");

        $this->display();

    }

    public function check(){

        if (!IS_AJAX)
            $this->error('错误的请求方式');

        //项目ID
        $id = I('post.id',0,'intval');
        if(empty($id))
            $this->error('无房间数据');
        M()->table("xk_order_house_order")->where("id=$id")->save(['is_checked'=>1]);
        //用户的项目和项目批次
        $user_project_ids = $this->get_user_project_ids();
        if (empty($user_project_ids))
            $this->error('无项目');

        $user_batch_ids = $this->get_user_batch_ids();
        if (empty($user_batch_ids))
            $this->error('无批次');

        $orderedRoom = D('Common/OrderHouseOrder')
            ->where([
                'project_id'=>[
                    'in'
                    ,array_values($user_project_ids)
                ]
                ,'batch_id'=>[
                    'in'
                    ,array_values($user_batch_ids)
                ]
                ,'id'=>$id
            ])->find();

        if(empty($orderedRoom))
            $this->error('无房间数据');

//        $this->cloudPrint($orderedRoom);
        $this->success('打印中，请稍等！');
    }

    //YLY打印
    function liansuo_post($url,$data){ // 模拟提交数据函数
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检测
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect:')); //解决数据包大不能提交
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
        curl_setopt($curl, CURLOPT_COOKIEFILE, $GLOBALS['cookie_file']); // 读取上面所储存的Cookie信息
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回

        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            echo 'Errno'.curl_error($curl);
        }
        curl_close($curl); // 关键CURL会话
        return $tmpInfo; // 返回数据
    }

    function generateSign($params, $apiKey, $msign)
    {
        //所有请求参数按照字母先后顺序排
        ksort($params);
        //定义字符串开始所包括的字符串
        $stringToBeSigned = $apiKey;
        //把所有参数名和参数值串在一起
        foreach ($params as $k => $v)
        {
            $stringToBeSigned .= urldecode($k.$v);
        }
        unset($k, $v);
        //定义字符串结尾所包括的字符串
        $stringToBeSigned .= $msign;
        //使用MD5进行加密，再转化成大写
        return strtoupper(md5($stringToBeSigned));
    }

//打印示例
    function cloudPrint($data)
    {

        $data['log_time'] = date('Y-m-d H:i:s',$data['log_time']);

        $machine_code = '4004506696';//打印机终端号
        $mKey= '4br5spxrcpr2';//打印机秘钥
        //打印内容
        $msg="";

        $msg .='@@2·   【选房小票】\n\n';

        $msg .="房间:{$data['project_name']}-{$data['build_name']}-{$data['unit_no']}单元-{$data['floor_no']}层-{$data['room_room']}\n";
        $msg .="客户:{$data['belong_real_name']}\n";
        $msg .="手机:{$data['belong_phone']}\n";
        $msg .="选房时间:{$data['log_time']}\n";
        $msg .="签约号:{$data['code']}\n";

        $partner= '4472';
        $apiKey= '2ea43a0eb8644e2b4f1e1ee67f945cc80c412fcc';
        $ti = time();
        $params = array(
            'partner'=>$partner,
            'machine_code'=>$machine_code,
            'time'=>$ti
        );
        $sign = $this->generateSign($params,$apiKey,$mKey);
        $params['sign'] = $sign;
        $params['content'] = $msg;
        $url = 'http://open.10ss.net:8888';//打印接口端点
        $p = '';
        foreach ($params as $k => $v) {
            $p .= $k.'='.$v.'&';
        }
        $data = rtrim($p, '&');
        $isprint=$this->liansuo_post($url,$data);
    }

}
