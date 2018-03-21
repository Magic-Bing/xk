<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/19 0019
 * Time: 16:23
 */

namespace Account\Controller;



class CstSignController extends BaseController
{
    /**
     * 系统构造函数
     *
     * @create 2017-04-17
     * @author jxw
     */
    public function _initialize() {
        parent::_initialize();

        //分类名称
        $this->assign('classify_name', '客户签到');
        $this->set_current_action('choose_sign', '999');
    }

    //页面
    public function index(){
        $zt=I("zt",0,"intval");
        $selected_project=session("selected_project");
        $this->assign('selected_project', $selected_project?$selected_project:0);
        $selected_batch=session("selected_batch");
        $this->assign('selected_batch', $selected_batch?$selected_batch:0);
        //当前用户的项目
        $user_project_ids = $this->get_user_project_ids();
        //获取项目列表
        $project_where = array();
        $project_where['status'] = 1;
        $project_where['id'] = array('in', $user_project_ids);
        $project_old_list = D('Common/ProjectView')->getList($project_where, 'company_id DESC, id DESC', '50');
        $this->assign('project_list', $project_old_list);
        //当前用户的批次
        $user_batch_ids = $this->get_user_batch_ids();
        //批次
        if (!empty($user_batch_ids)) {
            $user_batch_where['id'] = array('in', $user_batch_ids);
        } else {
            $user_batch_where['id'] = '-99999';
        }
        $batch_list = D('Batch')->getList($user_batch_where, '*','id DESC');
        $this->assign('batch_list', $batch_list);
        $this->assign('zt', $zt);
        $this->display();
    }


    //获取客户列表
    public  function user_list(){
        if(!IS_AJAX){
            $this->error("非法操作",U("index/index"));
        }
        //当前用户的项目
        $user_project_ids = $this->get_user_project_ids();
        $user_project_ids=array_merge($user_project_ids);
        $arr_str=implode(",",$user_project_ids);
        $page_num=I("num",C("SIGN_PAGE_NUM"),"intval");
        $pid=I("pid",0,"intval");
        session("selected_project",$pid);
        $bid=I("bid",0,"intval");
        session("selected_batch",$bid);
        $search=I("search",'',"trim");
        $page=I("page",0,"intval");
        $zt=I("zt",0,"intval");
        $b='';
        $s='';
        if($pid !== 0){
            $p="AND c.project_id =$pid";
        }else{
            $p="AND c.project_id in ($arr_str)";
        }
        if($bid !== 0){
            $b="AND c.batch_id =$bid";
        }
        if($search !== ''){
            $s="AND (c.customer_name like '%$search%' OR c.like_p like '%".strencode($search)."%' OR c.like_c like '%".strencode($search)."%' )";
        }
        if($zt<2){
            $z="AND c.is_sign=$zt";
        }else{
            $z='';
        }
        $count=M()->table("xk_choose c")->where("1 = 1 $z $p $b $s")->count();
        $all_page=ceil($count/$page_num);
        $res=M()->table("xk_choose c")->field("c.*,p.id zid")->join('LEFT JOIN xk_pzcsvalue p ON p.project_id=c.project_id AND p.batch_id=c.batch_id AND p.pzcs_id=2 AND p.cs_value=-1')->where("1 = 1 $z $p $b $s")->limit($page*$page_num,$page_num)->select();
        $this->assign('page_num', $page_num);
        $this->assign('page', $page+1);
        $this->assign('pages', $page);
        $this->assign('count', $count);
        $this->assign('all_page', $all_page);
        $this->assign('res', $res);
        echo $this->fetch();
    }

    //获取用户签到信息或者自动签到
    public function auto_sign(){
        if(!IS_AJAX){
            $this->error("非法操作",U("index/index"));
        }
        $user_project_ids = $this->get_user_project_ids();
        $user_project_ids=array_merge($user_project_ids);
        $arr_str=implode(",",$user_project_ids);
        $pid=I("pid",0,"intval");
        $bid=I("bid",0,"intval");
        $card=I("card",'',"trim");
        $name=I("name",'',"trim");
        if($pid !== 0){
            $p="AND c.project_id =$pid";
        }else{
            $p="AND c.project_id in ($arr_str)";
        }
        if($bid !== 0){
            $b="AND c.batch_id =$bid";
        }else{
            $b='';
        }
        if($card !== ''){
            $s="AND (c.like_c like '%".strencode($card)."%' )";
        }else{
            $s='';
        }
        $res=M()->table("xk_choose c")->field("c.*,p.id zid")->join('LEFT JOIN xk_pzcsvalue p ON p.project_id=c.project_id AND p.batch_id=c.batch_id AND p.pzcs_id=2 AND p.cs_value=-1')->where("1 = 1  $p $b $s")->select();
        if(empty($res)){
           $this->error("不存在该客户！");
        }else{
            if(empty($res[0]['zid'])){
                if(count($res)>1){
                    $auto_cst=0;
                    $auto_arr=[];
                    for($i=0;$i<count($res);$i++){
                        if(empty($res[$i]['is_sign'])){
                            $auto_cst++;
                            $auto_arr[]=$res[$i];
                        }
                    }
                    if($auto_cst === 1){
                        $this->success("auto_one");
                    }elseif($auto_cst === 0){
                        $name=M()->table("xk_choose2user_log")->where("choose_id={$res[0]['id']} AND log_type='签到'")->order("id desc")->find();
                        $this->success($name);
                    }else{
                        $t_conut=count($auto_arr);
                        for($k=0;$k<$t_conut;$k++){
                            $data['choose_id']=$auto_arr[$k]['id'];
                            $data['user_id']=$this->get_user_id();
                            $data['log_time']=time();
                            $data['log_ip']=$this->getIP();
                            $data['cst_name']=$name;
                            $data['log_type']='签到';
                            try{
                                M()->table('xk_choose')->where("id={$auto_arr[$k]['id']}")->save(['is_sign'=>1,'sign_time' => time()]);
                                M()->table("xk_choose2user_log")->add($data);
                                M()->commit();
                            }catch (\Think\Exception $e) {
                                M()->rollback();
                                $this->error("签到失败，请刷新重试！");
                            }
                        }
                        $str="成功签到了".$t_conut.'个。';
                        $this->success($str);
                    }
                }else{
                    if(empty($res[0]['is_sign'])){
                        $this->success("auto_one");
                    }else{
                        $name=M()->table("xk_choose2user_log")->where("choose_id={$res[0]['id']} AND log_type='签到'")->order("id desc")->find();
                        $this->success($name);
                    }
                }
            }else{
                $auto_cst=0;
                for($i=0;$i<count($res);$i++){
                    if(empty($res[$i]['is_sign'])){
                        $auto_cst++;
                    }
                }
                if($auto_cst === 0){
                    $name=M()->table("xk_choose2user_log")->where("choose_id={$res[0]['id']} AND log_type='签到'")->order("id desc")->find();
                    $this->success($name);
                }else{
                    $this->success("not_auto");
                }
            }

        }


    }

    //签到和取消签到
    public  function sign(){
        if(!IS_AJAX){
            $this->error("非法操作",U("index/index"));
        }
        date_default_timezone_set('prg');
        M()->startTrans();//开启事务
        $id=I("id",0,'intval');
        $zt=I("zt",1,'intval');
        $name=I("name",'','trim');
        if($zt===0){
            $data['log_type']='取消签到';
        }else{
            $data['log_type']='签到';
        }
        $data['choose_id']=$id;
        $data['user_id']=$this->get_user_id();
        $data['log_time']=time();
        $data['log_ip']=$this->getIP();
        $data['cst_name']=$name;
        try{
            M()->table('xk_choose')->where("id=$id")->save(['is_sign'=>$zt,'sign_time' => time()]);
            M()->table("xk_choose2user_log")->add($data);
            M()->commit();
            echo 'true';
        }catch (\Think\Exception $e) {
            M()->rollback();
            echo $e->getMessage();exit;
        }
    }

    //导出EXCEL
    public function check_excel(){
        $user_project_ids = $this->get_user_project_ids();
        $user_project_ids=array_merge($user_project_ids);
        $arr_str=implode(",",$user_project_ids);
        $pid=I("pid",0,"intval");
        $bid=I("bid",0,"intval");
        $search=I("search",'',"trim");
        $zt=I("zt",0,"intval");
        $b='';
        $s='';
        if($pid !== 0){
            $p="AND project_id =$pid";
        }else{
            $p="AND project_id in ($arr_str)";
        }
        if($bid !== 0){
            $b="AND batch_id =$bid";
        }
        if($search !== ''){
            $s="AND (customer_name like '%$search%' OR like_p like '%".strencode($search)."%' OR like_c like '%".strencode($search)."%' )";
        }
        if($zt<2){
            $z="AND is_sign=$zt";
        }else{
            $z='';
        }
        $res=M()->table("xk_choose")->field("customer_name,customer_phone,cardno,cyjno,ywy,is_sign")->where("1 = 1 $z $p $b $s")->select();
        import("Org.Util.PHPExcel");
        import("Org.Util.PHPExcel.Writer.Excel5");
        import("Org.Util.PHPExcel.IOFactory.php");

        //创建PHPExcel对象，注意，不能少了\
        $objPHPExcel = new \PHPExcel();
        if ($zt === 1) {
            $filename = '客户数据-已签到-' . time() . ".xls";
        } elseif ($zt ===0){
            $filename = '客户数据-未签到-' . time() . ".xls";
        }else{
            $filename = '客户数据-全部-' . time() . ".xls";
        }
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle("A")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("B")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("C")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("D")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("E")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle("F")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', '客户名称');
        $objPHPExcel->getActiveSheet()->setCellValue('B1', '手机号码');
        $objPHPExcel->getActiveSheet()->setCellValue('C1', '身份证号码');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', '诚意金编号');
        $objPHPExcel->getActiveSheet()->setCellValue('E1', '置业顾问');
        $objPHPExcel->getActiveSheet()->setCellValue('F1', '签到状态');
        for ($k = 0; $k < count($res); $k++) {
            if($res[$k]['is_sign'] == 0){
                $p="未签到";
            }else{
                $p="已签到";
            }
//            $objActSheet->setCellValue($j.$column, $value, \PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValue('A' . ($k + 2), $res[$k]['customer_name']);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('B' . ($k + 2), rsa_decode($res[$k]['customer_phone'], getChoosekey()), \PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('C' . ($k + 2), rsa_decode($res[$k]['cardno'], getChoosekey()), \PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->setCellValue('D' . ($k + 2), $res[$k]['cyjno']);
            $objPHPExcel->getActiveSheet()->setCellValue('E' . ($k + 2), $res[$k]['ywy']);
            $objPHPExcel->getActiveSheet()->setCellValue('F' . ($k + 2), $p);
        }

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//        $objWriter->save($filename);
// 输出Excel表格到浏览器下载
        $filename = urlencode($filename);
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
}